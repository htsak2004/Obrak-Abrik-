<?php
/**
 * Hero Section Component
 * Dirender sesuai referensi gambar pengguna dan diimprove secara visual & fungsional
 */
?>
<section class="hero-section" id="beranda">
  <div class="container">
    <div class="hero-grid">
      <!-- Left Column: Copywriting & Interactive Search -->
      <div class="hero-content">
        <div class="badge-tag">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Platform Resmi Inventaris Kampus
        </div>

        <h1 class="hero-headline">
          Sukseskan Event Kampusmu Tanpa Ribet Beli Alat
        </h1>

        <p class="hero-subtitle">
          Sewa kamera mirrorless, proyektor seminar, sound system aktif, dan alat dokumentasi event. Cukup jaminan KTM, ketersediaan jadwal transparan, dan unit siap pakai di titik kumpul kampus.
        </p>

        <!-- Search Bar Widget (Improvement dari gambar) -->
        <div class="search-widget" id="heroSearchWidget">
          <form id="heroSearchForm" onsubmit="return false;">
            <div class="search-fields">
              <!-- Field 1: Nama Alat -->
              <div class="input-group">
                <label for="heroKeyword" class="input-label">Nama Alat / Kebutuhan</label>
                <div class="input-wrapper">
                  <span class="input-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="11" cy="11" r="8"/>
                      <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                  </span>
                  <input type="text" id="heroKeyword" class="form-control" placeholder="Cari kamera, proyektor, mic...">
                </div>
              </div>

              <!-- Field 2: Kategori -->
              <div class="input-group">
                <label for="heroCategory" class="input-label">Kategori</label>
                <div class="input-wrapper">
                  <span class="input-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                      <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                  </span>
                  <select id="heroCategory" class="form-control">
                    <option value="all">Semua Kategori</option>
                    <option value="kamera">Kamera & Lensa</option>
                    <option value="audio">Audio & Sound System</option>
                    <option value="proyektor">Proyektor & Layar</option>
                    <option value="lighting">Lighting & Rigging</option>
                  </select>
                </div>
              </div>

              <!-- Field 3: Tanggal Acara -->
              <div class="input-group">
                <label for="heroDate" class="input-label">Tanggal Acara</label>
                <div class="input-wrapper">
                  <span class="input-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                      <line x1="16" y1="2" x2="16" y2="6"/>
                      <line x1="8" y1="2" x2="8" y2="6"/>
                      <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                  </span>
                  <input type="date" id="heroDate" class="form-control" value="<?= date('Y-m-d', strtotime('+1 day')); ?>" min="<?= date('Y-m-d'); ?>">
                </div>
              </div>
            </div>

            <!-- Search Bottom Bar -->
            <div class="search-bottom">
              <div class="live-badge">
                <span class="live-pulse" aria-hidden="true"></span>
                <span>Kalender ketersediaan terhubung live dengan data booking kampus</span>
              </div>
              <button type="button" class="btn btn-primary" id="heroSearchBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"/>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari Alat Tersedia
              </button>
            </div>
          </form>
        </div>

        <!-- Quick Tags -->
        <div class="hero-quick-tags">
          <span>Pilihan populer:</span>
          <span class="tag-chip" data-search="Sony">Sony A7 IV</span>
          <span class="tag-chip" data-search="Epson">Proyektor 8000L</span>
          <span class="tag-chip" data-search="Soundcraft">Mixer Soundcraft</span>
          <span class="tag-chip" data-search="Godox">Lighting Godox 200W</span>
        </div>
      </div>

      <!-- Right Column: Visual Equipment Highlight Card (Sesuai Referensi Gambar) -->
      <div class="hero-media">
        <div class="hero-card">
          <div class="hero-card-img-wrapper">
            <img src="assets/images/hero_equipment.jpg" alt="Peralatan Event Kampus Cinema Camera, Proyektor, Mixer Sound PA" class="hero-card-img">
            <div class="hero-card-overlay">
              <div class="hero-card-top">
                <span class="badge-featured">INVENTARIS TERLENGKAP</span>
                <span class="badge-status-ready">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                  Unit Ready di Kampus
                </span>
              </div>

              <div class="hero-card-bottom">
                <h2 class="hero-card-title">Kamera Cinema, Proyektor Lumens Tinggi & Sound PA</h2>
                <p class="hero-card-text">Khusus mendukung seminar, sidang skripsi, pelantikan, & konser UKM</p>
                <div class="hero-card-badges">
                  <span class="spec-pill">Tarif Flat Harian</span>
                  <span class="spec-pill">Jaminan KTM</span>
                  <span class="spec-pill">Validasi Anti-Bentrok</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
