<?php
/**
 * Header & Navbar Component
 * Navigation: Beranda, Katalog, Cara Menyewa, Tentang Kami, FAQ, Kontak, Login, Daftar
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($site_config['app_name']); ?> — <?= htmlspecialchars($site_config['tagline']); ?></title>
  <meta name="description" content="Platform resmi peminjaman dan penyewaan peralatan kampus terpusat: kamera cinema, proyektor seminar, sound PA, dan lighting untuk mahasiswa dan UKM.">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563eb'><path d='M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z'/></svg>">
</head>
<body>

  <!-- Header & Navigation -->
  <header class="site-header" id="siteHeader">
    <div class="container">
      <nav class="navbar" aria-label="Navigasi Utama">
        <!-- Brand Logo -->
        <a href="#beranda" class="brand-logo" id="brandLogo">
          <div class="brand-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
              <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
          </div>
          <div class="brand-text">Gear<span>Hub</span></div>
        </a>

        <!-- Desktop Menu -->
        <ul class="nav-menu" id="navMenu">
          <li><a href="#beranda" class="nav-link active">Beranda</a></li>
          <li><a href="#katalog" class="nav-link">Katalog</a></li>
          <li><a href="#cara-menyewa" class="nav-link">Cara Menyewa</a></li>
          <li><a href="#tentang-kami" class="nav-link">Tentang Kami</a></li>
          <li><a href="#faq" class="nav-link">FAQ</a></li>
          <li><a href="#kontak" class="nav-link">Kontak</a></li>

          <!-- Mobile Only Action Buttons inside Menu -->
          <li class="mobile-actions" style="display: none;">
            <button type="button" class="btn btn-outline btn-block" onclick="openModal('loginModal')">Masuk</button>
            <button type="button" class="btn btn-primary btn-block" onclick="openModal('registerModal')">Daftar Mahasiswa</button>
          </li>
        </ul>

        <!-- Action Buttons (Desktop) -->
        <div class="nav-actions">
          <button type="button" class="btn btn-outline btn-sm" id="btnLoginHeader" onclick="openModal('loginModal')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
              <polyline points="10 17 15 12 10 7"/>
              <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Masuk
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="btnRegisterHeader" onclick="openModal('registerModal')">
            Daftar Mahasiswa
          </button>
        </div>

        <!-- Mobile Hamburger Toggle -->
        <button type="button" class="mobile-toggle" id="mobileToggle" aria-label="Buka Menu Navigasi">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
          </svg>
        </button>
      </nav>
    </div>
  </header>
