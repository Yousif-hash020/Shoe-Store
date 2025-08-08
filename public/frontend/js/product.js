// Product Listing Page Interactivity for EliteKicks
// Filters and Sort functionality – integrates seamlessly with existing cart logic in script.js
document.addEventListener('DOMContentLoaded', () => {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    function handleNavbarScroll() {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleNavbarScroll);
    handleNavbarScroll(); // Initial check

    const filterButtons = document.querySelectorAll('.btn-filter');
    // const sortSelect = document.getElementById('sortSelect'); // Removed sorting
    const productGrid = document.getElementById('productGrid');
    let activeFilter = 'all';

    // Get all items
    const items = productGrid.children;

    // Update display based on active filter
    function updateDisplay() {
        const filteredItems = [...items].filter(item => {
            if (activeFilter === 'all') {
                return true;
            }
            return item.classList.contains(activeFilter);
        });

        // Hide all items first
        items.forEach(item => item.style.display = 'none');
        // Show only items for current filter
        filteredItems.forEach(item => item.style.display = '');
    }

    // Bootstrap Pagination Implementation
    const productsPerPage = 6;
    let currentPage = 1;

    function setupPagination() {
      const productItems = document.querySelectorAll('.product-item');
      const pageCount = Math.ceil(productItems.length / productsPerPage);
      const paginationEl = document.getElementById('paginationBar');
      
      if (!paginationEl || pageCount <= 1) return;
      
      paginationEl.innerHTML = '';
      
      // Previous button
      const prevLi = document.createElement('li');
      prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
      prevLi.innerHTML = `
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      `;
      prevLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) showPage(currentPage - 1);
      });
      
      // Page numbers
      for (let i = 1; i <= pageCount; i++) {
        const pageLi = document.createElement('li');
        pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
        pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        pageLi.addEventListener('click', (e) => {
          e.preventDefault();
          showPage(i);
        });
        paginationEl.appendChild(pageLi);
      }
      
      // Next button
      const nextLi = document.createElement('li');
      nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
      nextLi.innerHTML = `
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      `;
      nextLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < pageCount) showPage(currentPage + 1);
      });
      
      // Show first page by default
      showPage(1);
    }

    function showPage(page) {
      const productItems = document.querySelectorAll('.product-item');
      const startIndex = (page - 1) * productsPerPage;
      const endIndex = startIndex + productsPerPage;

      productItems.forEach((item, index) => {
        item.style.display = (index >= startIndex && index < endIndex) ? 'block' : 'none';
      });

      currentPage = page;
      updateActivePage();
    }

    function updateActivePage() {
      const paginationItems = document.querySelectorAll('#paginationBar .page-item');
      paginationItems.forEach((item, index) => {
        if (index === 0) return; // Skip previous button
        if (index === paginationItems.length - 1) return; // Skip next button
        
        const pageNum = index; // Because index 0 is previous button
        item.classList.toggle('active', pageNum === currentPage);
        item.classList.toggle('disabled', false);
      });
      
      // Update prev/next buttons
      const prevBtn = paginationItems[0];
      const nextBtn = paginationItems[paginationItems.length - 1];
      
      prevBtn.classList.toggle('disabled', currentPage === 1);
      nextBtn.classList.toggle('disabled', currentPage === paginationItems.length - 2);
    }

    // Initialize pagination when DOM is loaded
    setupPagination();
});
