/**
 * PinjamKampus - Client Interactive Scripts
 * Berdasarkan Persyaratan PRD Landing Page & Katalog Publik
 */

document.addEventListener('DOMContentLoaded', () => {
  // Mobile Navigation Toggle
  const mobileToggle = document.getElementById('mobileToggle');
  const navMenu = document.getElementById('navMenu');

  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');
    });

    // Close menu when clicking link
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('active');
      });
    });
  }

  // Active Link on Scroll
  const sections = document.querySelectorAll('section[id]');
  window.addEventListener('scroll', () => {
    const scrollY = window.pageYOffset;
    sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = current.offsetTop - 100;
      const sectionId = current.getAttribute('id');
      const navItem = document.querySelector(`.nav-link[href*="${sectionId}"]`);
      if (navItem) {
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
          navItem.classList.add('active');
        } else {
          navItem.classList.remove('active');
        }
      }
    });
  });

  // Catalog Category Filter
  const filterBtns = document.querySelectorAll('.filter-btn');
  const catalogCards = document.querySelectorAll('.catalog-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');
      filterCatalog(filter);
    });
  });

  function filterCatalog(category) {
    catalogCards.forEach(card => {
      const cardCategory = card.getAttribute('data-category');
      if (category === 'all' || cardCategory === category) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });
  }

  // Hero Search Form Handler
  const heroSearchBtn = document.getElementById('heroSearchBtn');
  const heroKeywordInput = document.getElementById('heroKeyword');
  const heroCategorySelect = document.getElementById('heroCategory');

  if (heroSearchBtn) {
    heroSearchBtn.addEventListener('click', (e) => {
      e.preventDefault();
      executeSearch();
    });
  }

  if (heroKeywordInput) {
    heroKeywordInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        executeSearch();
      }
    });
  }

  function executeSearch() {
    const keyword = (heroKeywordInput ? heroKeywordInput.value.toLowerCase().trim() : '');
    const selectedCategory = (heroCategorySelect ? heroCategorySelect.value : 'all');

    // Scroll smoothly to catalog
    const catalogSection = document.getElementById('katalog');
    if (catalogSection) {
      catalogSection.scrollIntoView({ behavior: 'smooth' });
    }

    // Set filter active button
    filterBtns.forEach(btn => {
      if (btn.getAttribute('data-filter') === selectedCategory) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });

    // Apply filtering
    catalogCards.forEach(card => {
      const name = card.querySelector('.catalog-name').textContent.toLowerCase();
      const brand = card.querySelector('.catalog-brand').textContent.toLowerCase();
      const desc = card.querySelector('.catalog-desc').textContent.toLowerCase();
      const cardCat = card.getAttribute('data-category');

      const matchesCat = (selectedCategory === 'all' || cardCat === selectedCategory);
      const matchesKeyword = (keyword === '' || name.includes(keyword) || brand.includes(keyword) || desc.includes(keyword));

      if (matchesCat && matchesKeyword) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });
  }

  // Quick Tags Click
  document.querySelectorAll('.tag-chip').forEach(chip => {
    chip.addEventListener('click', () => {
      const searchVal = chip.getAttribute('data-search') || chip.textContent.trim();
      if (heroKeywordInput) {
        heroKeywordInput.value = searchVal;
        executeSearch();
      }
    });
  });

  // FAQ Accordion
  const faqHeaders = document.querySelectorAll('.faq-header');
  faqHeaders.forEach(header => {
    header.addEventListener('click', () => {
      const faqItem = header.parentElement;
      const isActive = faqItem.classList.contains('active');

      // Close other FAQs
      document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
      });

      // Toggle current
      if (!isActive) {
        faqItem.classList.add('active');
      }
    });
  });

  // Modals Controller
  const loginModal = document.getElementById('loginModal');
  const registerModal = document.getElementById('registerModal');
  const detailModal = document.getElementById('detailModal');

  window.openModal = function(modalId) {
    const targetModal = document.getElementById(modalId);
    if (targetModal) {
      targetModal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  };

  window.closeModal = function(modalId) {
    const targetModal = document.getElementById(modalId);
    if (targetModal) {
      targetModal.classList.remove('active');
      document.body.style.overflow = '';
    }
  };

  // Close modals when clicking overlay
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  });

  // Role Switcher in Login Modal
  const roleTabs = document.querySelectorAll('.role-tab');
  const roleInput = document.getElementById('loginRole');
  const loginRoleNotice = document.getElementById('loginRoleNotice');

  roleTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      roleTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const role = tab.getAttribute('data-role');
      if (roleInput) roleInput.value = role;

      if (loginRoleNotice) {
        if (role === 'mahasiswa') {
          loginRoleNotice.textContent = 'Akses mahasiswa: booking alat, cek ketersediaan, upload bukti, lihat riwayat.';
        } else if (role === 'operator') {
          loginRoleNotice.textContent = 'Akses operator staf: serah-terima fisik, foto kondisi alat, pantau pengembalian.';
        } else if (role === 'admin') {
          loginRoleNotice.textContent = 'Akses administrator: persetujuan booking, kelola inventaris/tarif, verifikasi pembayaran.';
        }
      }
    });
  });

  // Detail Modal Data Binder
  window.openItemDetail = function(itemDataJson) {
    try {
      const item = JSON.parse(decodeURIComponent(itemDataJson));
      document.getElementById('modalItemName').textContent = item.name;
      document.getElementById('modalItemBrand').textContent = item.brand + ' • ' + item.category_name;
      document.getElementById('modalItemPrice').textContent = 'Rp ' + Number(item.price_per_day).toLocaleString('id-ID');
      document.getElementById('modalItemDesc').textContent = item.description;
      document.getElementById('modalItemCondition').textContent = item.condition;
      document.getElementById('modalItemSpecs').textContent = item.specs;
      document.getElementById('modalItemImg').src = item.image;

      const featuresList = document.getElementById('modalItemFeatures');
      featuresList.innerHTML = '';
      if (item.features && Array.isArray(item.features)) {
        item.features.forEach(f => {
          const li = document.createElement('li');
          li.textContent = f;
          featuresList.appendChild(li);
        });
      }

      openModal('detailModal');
    } catch (e) {
      console.error('Error parsing item details', e);
    }
  };
});
