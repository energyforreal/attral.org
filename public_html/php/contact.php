<?php
declare(strict_types=1);

const PCB_EMAIL = 'projects@attral.org';
const GENERAL_EMAIL = 'info@attral.org';
const FROM_EMAIL = 'noreply@attral.org';
const SITE_NAME = 'ATTRAL';
const MAX_FILE_SIZE = 10485760; // 10 MB
const UPLOAD_DIR = __DIR__ . '/../uploads/';
const LOG_DIR = __DIR__ . '/../logs/';
const LOG_FILE = LOG_DIR . 'contact.log';
const RATE_LIMIT_DIR = __DIR__ . '/../storage/rate-limits/';
const SESSION_RATE_LIMIT_SECONDS = 30;
const IP_RATE_LIMIT_SECONDS = 30;
const CSRF_TTL_SECONDS = 1800;
const CAPTCHA_SECRET = '';

$serviceLabels = [
  'pcb-design' => 'PCB Design',
  'pcb-fabrication' => 'PCB Fabrication & Assembly',
  'web-development' => 'Full Stack Web Development',
  'ai-agent' => 'AI Agent Development',
  'ai-automation' => 'AI Workflow Automation',
  'other' => 'Other / General Inquiry',
];

$allowedFileRules = [
  'pdf' => ['application/pdf'],
  'zip' => ['application/zip', 'application/x-zip-compressed'],
  'rar' => ['application/vnd.rar', 'application/x-rar', 'application/x-rar-compressed'],
  'gbr' => ['text/plain', 'application/octet-stream'],
  'brd' => ['text/plain', 'application/octet-stream'],
  'sch' => ['text/plain', 'application/octet-stream'],
  'step' => ['application/step', 'model/step', 'text/plain', 'application/octet-stream'],
  'png' => ['image/png'],
  'jpg' => ['image/jpeg'],
  'jpeg' => ['image/jpeg'],
];

header('Content-Type: application/json; charset=UTF-8');
applyCorsHeaders();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
  http_response_code(204);
  exit;
}

session_start();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'GET' && ($_GET['csrf'] ?? '') === '1') {
  $token = issueCsrfToken();
  respond(true, ['csrfToken' => $token]);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
  header('Allow: POST');
  respondError('METHOD_NOT_ALLOWED', 'Method not allowed', 405);
}

$clientIp = getClientIp();
if ($clientIp !== null && isRateLimitedByIp($clientIp, IP_RATE_LIMIT_SECONDS)) {
  logEvent('warning', 'blocked_rate_limit_ip', ['ip' => $clientIp]);
  respondError('RATE_LIMIT', 'Please wait before submitting again.', 429);
}
if (isset($_SESSION['last_submit']) && (time() - (int) $_SESSION['last_submit']) < SESSION_RATE_LIMIT_SECONDS) {
  logEvent('warning', 'blocked_rate_limit_session', ['ip' => $clientIp]);
  respondError('RATE_LIMIT', 'Please wait before submitting again.', 429);
}

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
  logEvent('warning', 'blocked_csrf', ['ip' => $clientIp]);
  respondError('CSRF_INVALID', 'Security validation failed. Please refresh and try again.', 403);
}

if (!empty($_POST['website'] ?? '')) {
  logEvent('warning', 'blocked_honeypot', ['ip' => $clientIp]);
  respondError('SPAM_DETECTED', 'We could not process this submission.', 400);
}

if (!verifyCaptchaToken(trim((string) ($_POST['captcha_token'] ?? '')))) {
  logEvent('warning', 'blocked_captcha', ['ip' => $clientIp]);
  respondError('CAPTCHA_FAILED', 'Captcha validation failed. Please try again.', 400);
}

$required = ['name', 'email', 'phone', 'service', 'message'];
foreach ($required as $field) {
  if (empty($_POST[$field])) {
    respondError('MISSING_FIELD', 'Please complete all required fields.', 422, ['field' => $field]);
  }
}

$name = sanitizeText((string) $_POST['name']);
$email = sanitizeEmail((string) $_POST['email']);
$phone = sanitizeText((string) $_POST['phone']);
$company = sanitizeText((string) ($_POST['company'] ?? 'Not provided'));
$service = sanitizeText((string) $_POST['service']);
$message = sanitizeText((string) $_POST['message'], true);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  respondError('INVALID_EMAIL', 'Please enter a valid email address.', 422);
}
if (!array_key_exists($service, $serviceLabels)) {
  respondError('INVALID_SERVICE', 'Please select a valid service.', 422);
}

$toEmail = in_array($service, ['pcb-design', 'pcb-fabrication'], true) ? PCB_EMAIL : GENERAL_EMAIL;
$serviceLabel = $serviceLabels[$service];
$attachment = handleAttachmentUpload($_FILES['attachment'] ?? null, $allowedFileRules);

$replyToName = preg_replace('/[\r\n]+/', ' ', $name) ?: 'Customer';
$replyToEmail = str_replace(["\r", "\n"], '', $email);
$subject = "[ATTRAL Inquiry] {$serviceLabel} - {$name}";

$body = "New project inquiry received via attral.org\n\n";
$body .= "-------------------------------------------\n";
$body .= "CLIENT DETAILS\n";
$body .= "-------------------------------------------\n";
$body .= "Name:    {$name}\n";
$body .= "Email:   {$email}\n";
$body .= "Phone:   {$phone}\n";
$body .= "Company: {$company}\n\n";
$body .= "-------------------------------------------\n";
$body .= "SERVICE REQUESTED\n";
$body .= "-------------------------------------------\n";
$body .= "{$serviceLabel}\n\n";
$body .= "-------------------------------------------\n";
$body .= "PROJECT DESCRIPTION\n";
$body .= "-------------------------------------------\n";
$body .= "{$message}\n\n";
$body .= "-------------------------------------------\n";
$body .= "ATTACHMENT\n";
$body .= "-------------------------------------------\n";
$body .= $attachment['original_name'] !== null ? "File: {$attachment['original_name']}\n\n" : "No file attached\n\n";
$body .= "-------------------------------------------\n";
$body .= "Sent via ATTRAL Contact Form · " . date('Y-m-d H:i:s T') . "\n";

$staffSent = sendStaffEmail($toEmail, $subject, $body, $replyToName, $replyToEmail, $attachment);
if (!$staffSent) {
  logEvent('error', 'mail_staff_failed', ['to' => $toEmail, 'ip' => $clientIp, 'service' => $service]);
  respondError('MAIL_DELIVERY_FAILED', 'Unable to send your inquiry right now. Please try again shortly.', 500);
}

$_SESSION['last_submit'] = time();
if ($clientIp !== null) {
  rememberIpSubmission($clientIp);
}

$autoReplySent = sendAutoReply($replyToEmail, $name, $serviceLabel, $toEmail);
if (!$autoReplySent) {
  logEvent('warning', 'mail_autoreply_failed', ['to' => $replyToEmail, 'ip' => $clientIp, 'service' => $service]);
}

logEvent('info', 'mail_staff_sent', ['to' => $toEmail, 'reply_to' => $replyToEmail, 'ip' => $clientIp, 'service' => $service]);
respond(true, $autoReplySent ? [] : ['warning' => ['code' => 'AUTOREPLY_FAILED', 'message' => 'Staff inquiry sent, but auto-reply failed.']]);

function applyCorsHeaders(): void
{
  header('Vary: Origin');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
  $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
  $allowedOrigins = ['https://attral.org', 'https://www.attral.org', 'http://localhost', 'http://127.0.0.1'];
  if ($origin !== '' && in_array($origin, $allowedOrigins, true)) {
    header('Access-Control-Allow-Origin: ' . $origin);
  } else {
    header('Access-Control-Allow-Origin: https://attral.org');
  }
}

function respond(bool $success, array $extra = [], int $statusCode = 200): void
{
  http_response_code($statusCode);
  echo json_encode(array_merge(['success' => $success], $extra), JSON_UNESCAPED_SLASHES);
  exit;
}

function respondError(string $code, string $message, int $statusCode = 400, array $extra = []): void
{
  respond(false, array_merge(['error' => ['code' => $code, 'message' => $message]], $extra), $statusCode);
}

function issueCsrfToken(): string
{
  $now = time();
  $current = (string) ($_SESSION['contact_csrf_token'] ?? '');
  $issuedAt = (int) ($_SESSION['contact_csrf_issued_at'] ?? 0);
  if ($current !== '' && ($now - $issuedAt) < CSRF_TTL_SECONDS) {
    return $current;
  }
  $token = bin2hex(random_bytes(32));
  $_SESSION['contact_csrf_token'] = $token;
  $_SESSION['contact_csrf_issued_at'] = $now;
  return $token;
}

function verifyCsrfToken(string $incoming): bool
{
  if ($incoming === '') {
    return false;
  }
  $token = (string) ($_SESSION['contact_csrf_token'] ?? '');
  $issuedAt = (int) ($_SESSION['contact_csrf_issued_at'] ?? 0);
  if ($token === '' || (time() - $issuedAt) > CSRF_TTL_SECONDS) {
    return false;
  }
  return hash_equals($token, $incoming);
}

function sanitizeText(string $value, bool $allowNewLines = false): string
{
  $value = trim($value);
  $value = strip_tags($value);
  if (!$allowNewLines) {
    $value = preg_replace('/[\r\n]+/', ' ', $value) ?? $value;
  }
  return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sanitizeEmail(string $value): string
{
  $email = filter_var(trim($value), FILTER_SANITIZE_EMAIL);
  return str_replace(["\r", "\n"], '', (string) $email);
}

function sanitizeFilename(string $filename): string
{
  $base = basename($filename);
  $clean = preg_replace('/[^A-Za-z0-9._-]/', '_', $base) ?? '';
  return trim($clean, '._-');
}

function getClientIp(): ?string
{
  $candidates = [
    $_SERVER['HTTP_CF_CONNECTING_IP'] ?? '',
    $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '',
    $_SERVER['REMOTE_ADDR'] ?? '',
  ];
  foreach ($candidates as $candidate) {
    if ($candidate === '') {
      continue;
    }
    $value = trim(explode(',', $candidate)[0]);
    if (filter_var($value, FILTER_VALIDATE_IP)) {
      return $value;
    }
  }
  return null;
}

function getRateLimitPath(string $ip): string
{
  return RATE_LIMIT_DIR . hash('sha256', $ip) . '.json';
}

function isRateLimitedByIp(string $ip, int $cooldownSeconds): bool
{
  $path = getRateLimitPath($ip);
  if (!is_file($path)) {
    return false;
  }
  $raw = (string) file_get_contents($path);
  $data = json_decode($raw, true);
  if (!is_array($data)) {
    return false;
  }
  $last = (int) ($data['last_submit'] ?? 0);
  return $last > 0 && (time() - $last) < $cooldownSeconds;
}

function rememberIpSubmission(string $ip): void
{
  if (!is_dir(RATE_LIMIT_DIR)) {
    mkdir(RATE_LIMIT_DIR, 0755, true);
  }
  $payload = ['last_submit' => time(), 'ip_hash' => hash('sha256', $ip)];
  file_put_contents(getRateLimitPath($ip), json_encode($payload), LOCK_EX);
}

function logEvent(string $level, string $event, array $context = []): void
{
  if (!is_dir(LOG_DIR)) {
    mkdir(LOG_DIR, 0755, true);
  }
  $entry = [
    'time' => date('c'),
    'level' => $level,
    'event' => $event,
    'context' => $context,
  ];
  file_put_contents(LOG_FILE, json_encode($entry, JSON_UNESCAPED_SLASHES) . PHP_EOL, FILE_APPEND | LOCK_EX);
}

function verifyCaptchaToken(string $token): bool
{
  if ($token === '') {
    return true;
  }
  if (CAPTCHA_SECRET === '') {
    return true;
  }
  return false;
}

function handleAttachmentUpload(?array $file, array $allowedRules): array
{
  if ($file === null || empty($file['name'])) {
    return [
      'path' => null,
      'original_name' => null,
      'safe_name' => null,
      'mime' => null,
    ];
  }

  if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    respondError('FILE_UPLOAD_ERROR', 'Unable to process the selected file.', 422);
  }

  $size = (int) ($file['size'] ?? 0);
  if ($size <= 0 || $size > MAX_FILE_SIZE) {
    respondError('FILE_TOO_LARGE', 'Attachment must be 10MB or smaller.', 422);
  }

  $extension = strtolower((string) pathinfo((string) $file['name'], PATHINFO_EXTENSION));
  if (!array_key_exists($extension, $allowedRules)) {
    respondError('FILE_TYPE_NOT_ALLOWED', 'This file type is not supported.', 422);
  }

  $tmpPath = (string) ($file['tmp_name'] ?? '');
  if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
    respondError('FILE_UPLOAD_ERROR', 'Unable to process the selected file.', 422);
  }

  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $detectedMime = $finfo ? (string) finfo_file($finfo, $tmpPath) : '';
  if ($finfo) {
    finfo_close($finfo);
  }
  if ($detectedMime === '' || !in_array($detectedMime, $allowedRules[$extension], true)) {
    respondError('FILE_MIME_MISMATCH', 'File content does not match the selected file type.', 422);
  }

  if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
  }

  $original = sanitizeFilename((string) $file['name']);
  if ($original === '') {
    $original = 'attachment.' . $extension;
  }
  $safeName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
  $destination = UPLOAD_DIR . $safeName;

  if (!move_uploaded_file($tmpPath, $destination)) {
    respondError('FILE_UPLOAD_ERROR', 'Unable to save attachment.', 500);
  }

  return [
    'path' => $destination,
    'original_name' => $original,
    'safe_name' => $safeName,
    'mime' => $detectedMime,
  ];
}

function sendStaffEmail(
  string $toEmail,
  string $subject,
  string $body,
  string $replyToName,
  string $replyToEmail,
  array $attachment
): bool {
  $baseHeaders = "From: " . SITE_NAME . " <" . FROM_EMAIL . ">\r\n";
  $baseHeaders .= "Reply-To: {$replyToName} <{$replyToEmail}>\r\n";
  $baseHeaders .= "X-Mailer: PHP/" . phpversion() . "\r\n";
  $baseHeaders .= "MIME-Version: 1.0\r\n";

  if ($attachment['path'] && $attachment['original_name'] && is_file($attachment['path'])) {
    $boundary = 'b-' . bin2hex(random_bytes(12));
    $headers = $baseHeaders . "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

    $encoded = chunk_split(base64_encode((string) file_get_contents((string) $attachment['path'])));
    $mime = $attachment['mime'] ?: 'application/octet-stream';
    $filename = $attachment['original_name'];

    $message = "--{$boundary}\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message .= $body . "\r\n";
    $message .= "--{$boundary}\r\n";
    $message .= "Content-Type: {$mime}; name=\"{$filename}\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
    $message .= $encoded . "\r\n";
    $message .= "--{$boundary}--";

    return mail($toEmail, $subject, $message, $headers);
  }

  $headers = $baseHeaders . "Content-Type: text/plain; charset=UTF-8\r\n";
  return mail($toEmail, $subject, $body, $headers);
}

function sendAutoReply(string $toEmail, string $name, string $serviceLabel, string $teamMailbox): bool
{
  $subject = 'We received your inquiry - ATTRAL';
  $body = "Hi {$name},\n\n";
  $body .= "Thank you for reaching out to ATTRAL. We have received your inquiry regarding:\n";
  $body .= "{$serviceLabel}\n\n";
  $body .= "Our team will review your project details and respond within 24 business hours.\n\n";
  $body .= "For urgent matters, you can reach us at:\n";
  $body .= "+91 8903479870\n";
  $body .= "{$teamMailbox}\n\n";
  $body .= "Best regards,\n";
  $body .= "ATTRAL Engineering Team\n";
  $body .= "attral.org\n";

  $headers = "From: " . SITE_NAME . " <" . FROM_EMAIL . ">\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
  return mail($toEmail, $subject, $body, $headers);
}