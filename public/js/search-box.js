// Script dùng chung cho search-box, chỉ cần import file này ở mọi trang có search-box

document.addEventListener('DOMContentLoaded', function () {
  // Nếu search overlay chưa có, không làm gì cả
  const searchOverlay = document.getElementById('search-overlay');
  if (!searchOverlay) return;

  // Tìm icon search (có thể là <span> hoặc <a>)
  const searchIcon = document.getElementById('search-icon') || document.getElementById('search-link');
  const closeSearch = document.getElementById('close-search');
  const searchInput = searchOverlay.querySelector('input');
  const blurBg = searchOverlay.querySelector('.blur-bg');

  // Hiện search overlay
  if (searchIcon) {
    searchIcon.onclick = (e) => {
      if (e) e.preventDefault();
      searchOverlay.classList.add('active');
      setTimeout(() => {
        if (searchInput) searchInput.focus();
      }, 100);
    };
  }

  // Đổi icon khi nhập
  if (searchInput && closeSearch) {
    searchInput.addEventListener('input', function () {
      if (this.value.trim() !== '') {
        closeSearch.textContent = 'search';
        closeSearch.style.color = '#b48c5a';
      } else {
        closeSearch.textContent = 'close';
        closeSearch.style.color = '#222';
      }
    });

    // Enter chuyển trang kết quả
    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        window.location.href = 'search.html?query=' + encodeURIComponent(this.value.trim());
      }
    });
  }

  // Đóng search overlay
  if (closeSearch) {
    closeSearch.onclick = () => {
      if (searchInput && searchInput.value.trim() !== '') {
        // Có thể thực hiện tìm kiếm ở đây nếu muốn
      } else {
        searchOverlay.classList.remove('active');
      }
    };
  }

  // Đóng khi click ra ngoài form
  if (blurBg) {
    blurBg.onclick = () => {
      searchOverlay.classList.remove('active');
    };
  }

  // Đóng khi nhấn ESC
  document.addEventListener('keydown', function (e) {
    if (e.key === "Escape") searchOverlay.classList.remove('active');
  });

  // Mega menu hover functionality
  const navLinks = document.querySelectorAll('nav a');
  const megaMenus = document.querySelectorAll('.mega-menu');

  // Add a small delay to prevent flickering
  let hoverTimeout;

  navLinks.forEach(link => {
    link.addEventListener('mouseenter', function() {
      clearTimeout(hoverTimeout);
      megaMenus.forEach(menu => {
        menu.style.display = 'none';
        menu.style.opacity = '0';
        menu.style.visibility = 'hidden';
      });
      const nextMenu = this.nextElementSibling;
      if (nextMenu && nextMenu.classList.contains('mega-menu')) {
        nextMenu.style.display = 'flex';
        setTimeout(() => {
          nextMenu.style.opacity = '1';
          nextMenu.style.visibility = 'visible';
        }, 50);
      }
    });
  });

  megaMenus.forEach(menu => {
    menu.addEventListener('mouseleave', function() {
      hoverTimeout = setTimeout(() => {
        this.style.opacity = '0';
        this.style.visibility = 'hidden';
        setTimeout(() => {
          this.style.display = 'none';
        }, 300);
      }, 200);
    });
    
    menu.addEventListener('mouseenter', function() {
      clearTimeout(hoverTimeout);
      this.style.display = 'flex';
      this.style.opacity = '1';
      this.style.visibility = 'visible';
    });
  });
});