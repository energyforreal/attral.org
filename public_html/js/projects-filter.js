const filterButtons = document.querySelectorAll('.filter-btn');
const projectItems = document.querySelectorAll('.project-item');

if (filterButtons.length) {
  filterButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
      document.querySelector('.filter-btn.active')?.classList.remove('active');
      btn.classList.add('active');
      const category = btn.dataset.category || 'all';

      projectItems.forEach((item) => {
        item.style.display = category === 'all' || item.dataset.category === category ? 'block' : 'none';
      });
    });
  });
}
