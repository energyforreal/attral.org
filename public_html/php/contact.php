<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://attral.org');
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], ['http://localhost', 'http://127.0.0.1'])) {
  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
}

session_start();
if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit'] < 30)) {
  echo json_encode(['success' => false, 'error' => 'Please wait before submitting again']);
  exit;
}

define('PCB_EMAIL', 'projects@attral.org');
define('GENERAL_EMAIL', 'info@attral.org');
define('FROM_EMAIL', 'noreply@attral.org');
define('SITE_NAME', 'ATTRAL');
define('MAX_FILE_SIZE', 10 * 1024 * 1024);
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

$allowed_extensions = ['pdf', 'zip', 'rar', 'gbr', 'brd', 'sch', 'step', 'png', 'jpg', 'jpeg'];

if (!empty($_POST['website'])) {
  echo json_encode(['success' => false, 'error' => 'Spam detected']);
  exit;
}

$required = ['name', 'email', 'phone', 'service', 'message'];
foreach ($required as $field) {
  if (empty($_POST[$field])) {
    echo json_encode(['success' => false, 'error' => "Missing: $field"]);
    exit;
  }
}

$name = htmlspecialchars(strip_tags(trim($_POST['name'])));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
$company = htmlspecialchars(strip_tags(trim($_POST['company'] ?? 'Not provided')));
$service = htmlspecialchars(strip_tags(trim($_POST['service'])));
$message = htmlspecialchars(strip_tags(trim($_POST['message'])));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['success' => false, 'error' => 'Invalid email address']);
  exit;
}

$pcb_services = ['pcb-design', 'pcb-fabrication'];
$to_email = in_array($service, $pcb_services) ? PCB_EMAIL : GENERAL_EMAIL;

$attachment_path = null;
$attachment_name = null;

if (!empty($_FILES['attachment']['name'])) {
  $file = $_FILES['attachment'];
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $filesize = $file['size'];

  if (!in_array($ext, $allowed_extensions)) {
    echo json_encode(['success' => false, 'error' => 'File type not allowed']);
    exit;
  }
  if ($filesize > MAX_FILE_SIZE) {
    echo json_encode(['success' => false, 'error' => 'File exceeds 10MB limit']);
    exit;
  }
  if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'File upload error']);
    exit;
  }

  if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
  }

  $safe_name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $dest = UPLOAD_DIR . $safe_name;

  if (move_uploaded_file($file['tmp_name'], $dest)) {
    $attachment_path = $dest;
    $attachment_name = $file['name'];
  }
}

$service_labels = [
  'pcb-design' => 'PCB Design',
  'pcb-fabrication' => 'PCB Fabrication & Assembly',
  'web-development' => 'Full Stack Web Development',
  'ai-agent' => 'AI Agent Development',
  'ai-automation' => 'AI Workflow Automation',
  'other' => 'Other / General Inquiry',
];
$service_label = $service_labels[$service] ?? $service;

$subject = "[ATTRAL Inquiry] $service_label — $name";

$body = "New project inquiry received via attral.org\n\n";
$body .= "-------------------------------------------\n";
$body .= "CLIENT DETAILS\n";
$body .= "-------------------------------------------\n";
$body .= "Name:    $name\n";
$body .= "Email:   $email\n";
$body .= "Phone:   $phone\n";
$body .= "Company: $company\n\n";
$body .= "-------------------------------------------\n";
$body .= "SERVICE REQUESTED\n";
$body .= "-------------------------------------------\n";
$body .= "$service_label\n\n";
$body .= "-------------------------------------------\n";
$body .= "PROJECT DESCRIPTION\n";
$body .= "-------------------------------------------\n";
$body .= "$message\n\n";
$body .= "-------------------------------------------\n";
$body .= "ATTACHMENT\n";
$body .= "-------------------------------------------\n";
$body .= ($attachment_name ? "File: $attachment_name (saved to /uploads/$safe_name)" : "No file attached") . "\n\n";
$body .= "-------------------------------------------\n";
$body .= "Sent via ATTRAL Contact Form · " . date('Y-m-d H:i:s T') . "\n";

$headers = "From: " . SITE_NAME . " <" . FROM_EMAIL . ">\r\n";
$headers .= "Reply-To: $name <$email>\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if ($attachment_path && file_exists($attachment_path)) {
  $file_content = chunk_split(base64_encode(file_get_contents($attachment_path)));
  $mime_boundary = md5(time());

  $headers_with_attach = "From: " . SITE_NAME . " <" . FROM_EMAIL . ">\r\n";
  $headers_with_attach .= "Reply-To: $name <$email>\r\n";
  $headers_with_attach .= "MIME-Version: 1.0\r\n";
  $headers_with_attach .= "Content-Type: multipart/mixed; boundary=\"$mime_boundary\"\r\n";

  $body_with_attach = "--$mime_boundary\r\n";
  $body_with_attach .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
  $body_with_attach .= $body . "\r\n";
  $body_with_attach .= "--$mime_boundary\r\n";
  $body_with_attach .= "Content-Type: application/octet-stream; name=\"$attachment_name\"\r\n";
  $body_with_attach .= "Content-Transfer-Encoding: base64\r\n";
  $body_with_attach .= "Content-Disposition: attachment; filename=\"$attachment_name\"\r\n\r\n";
  $body_with_attach .= $file_content . "\r\n";
  $body_with_attach .= "--$mime_boundary--";

  $sent = mail($to_email, $subject, $body_with_attach, $headers_with_attach);
} else {
  $sent = mail($to_email, $subject, $body, $headers);
}

$auto_reply_subject = "We received your inquiry — ATTRAL";
$auto_reply_body = "Hi $name,\n\n";
$auto_reply_body .= "Thank you for reaching out to ATTRAL. We've received your inquiry regarding:\n";
$auto_reply_body .= "$service_label\n\n";
$auto_reply_body .= "Our team will review your project details and respond within 24 business hours.\n\n";
$auto_reply_body .= "For urgent matters, you can reach us at:\n";
$auto_reply_body .= "📞  +91 8903479870\n";
$auto_reply_body .= "📧  " . (($service === 'pcb-design' || $service === 'pcb-fabrication') ? PCB_EMAIL : GENERAL_EMAIL) . "\n\n";
$auto_reply_body .= "Best regards,\n";
$auto_reply_body .= "ATTRAL Engineering Team\n";
$auto_reply_body .= "attral.org\n";

$auto_headers = "From: ATTRAL <" . FROM_EMAIL . ">\r\n";
$auto_headers .= "MIME-Version: 1.0\r\n";
$auto_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($email, $auto_reply_subject, $auto_reply_body, $auto_headers);

if ($sent) {
  $_SESSION['last_submit'] = time();
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'Mail delivery failed']);
}
?>