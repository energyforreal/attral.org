const filterButtons = document.querySelectorAll('.filter-btn');
const projectItems = document.querySelectorAll('.project-item');
const filterStatus = document.getElementById('projects-filter-status');

if (filterButtons.length) {
  const setFilterStatus = (label, count) => {
    if (!filterStatus) {
      return;
    }
    filterStatus.textContent = `${label} selected. Showing ${count} project${count === 1 ? '' : 's'}.`;
  };

  filterButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
      document.querySelector('.filter-btn.active')?.classList.remove('active');
      btn.classList.add('active');

      filterButtons.forEach((filterBtn) => {
        filterBtn.setAttribute('aria-pressed', filterBtn === btn ? 'true' : 'false');
      });

      const category = btn.dataset.category || 'all';
      let visibleCount = 0;

      projectItems.forEach((item) => {
        const isMatch = category === 'all' || item.dataset.category === category;
        item.style.display = isMatch ? 'block' : 'none';
        item.toggleAttribute('hidden', !isMatch);
        if (isMatch) {
          visibleCount += 1;
        }
      });

      setFilterStatus(btn.textContent?.trim() || 'Filter', visibleCount);
    });
  });

  const initialLabel = document.querySelector('.filter-btn.active')?.textContent?.trim() || 'All';
  setFilterStatus(initialLabel, projectItems.length);
}
