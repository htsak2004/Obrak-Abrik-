<?php
/**
 * Katalog Publik Component
 * Menampilkan daftar inventaris peralatan kampus, tarif flat harian, dan spesifikasi
 * Mengikuti PRD AC-02 (Publik dapat melihat katalog, ketersediaan unit detail perlu login)
 */
?>
<section class="catalog-section section-padding" id="katalog">
  <div class="container">
    <div class="section-header">
      <div class="badge-tag">Katalog Peralatan Kampus</div>
      <h2 class="section-title">Peralatan Berkualitas untuk Setiap Kegiatan</h2>
      <p class="section-desc">
        Jelajahi unit inventaris kampus dengan tarif resmi mahasiswa. Ketersediaan tanggal kalender terintegrasi otomatis dengan sistem serah-terima sentral kampus.
      </p>
    </div>

    <!-- Category Filter Bar -->
    <div class="catalog-filter-bar">
      <button type="button" class="filter-btn active" data-filter="all">Semua Kategori</button>
      <button type="button" class="filter-btn" data-filter="kamera">Kamera & Lensa</button>
      <button type="button" class="filter-btn" data-filter="audio">Audio & Sound System</button>
      <button type="button" class="filter-btn" data-filter="proyektor">Proyektor & Layar</button>
      <button type="button" class="filter-btn" data-filter="lighting">Lighting & Rigging</button>
    </div>

    <!-- Catalog Grid -->
    <div class="catalog-grid" id="catalogGrid">
      <?php foreach ($catalog_items as $item): ?>
        <?php $item_json = urlencode(json_encode($item)); ?>
        <article class="catalog-card" data-category="<?= htmlspecialchars($item['category']); ?>" id="card-<?= htmlspecialchars($item['id']); ?>">
          <div class="catalog-thumb">
            <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" loading="lazy">
            <span class="badge-category"><?= htmlspecialchars($item['category_name']); ?></span>
            <span class="badge-condition"><?= htmlspecialchars($item['condition']); ?></span>
          </div>

          <div class="catalog-body">
            <div class="catalog-brand"><?= htmlspecialchars($item['brand']); ?></div>
            <h3 class="catalog-name"><?= htmlspecialchars($item['name']); ?></h3>
            <p class="catalog-desc"><?= htmlspecialchars($item['description']); ?></p>

            <ul class="catalog-features">
              <?php foreach (array_slice($item['features'], 0, 3) as $feat): ?>
                <li>
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                  <span><?= htmlspecialchars($feat); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="catalog-footer">
              <div class="price-box">
                <span class="price-label">Tarif Sewa Kampus</span>
                <div class="price-value">
                  Rp <?= number_format($item['price_per_day'], 0, ',', '.'); ?>
                  <span class="price-unit">/ hari</span>
                </div>
              </div>

              <div style="display: flex; gap: 8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="openItemDetail('<?= $item_json; ?>')">
                  Detail
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="openModal('loginModal')">
                  Sewa
                </button>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <!-- Notice Banner Sesuai PRD Section 2.1 & AC-02 -->
    <div class="catalog-notice">
      <div class="notice-info">
        <div class="notice-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </div>
        <div class="notice-text">
          <h4>Keterangan Akses Ketersediaan Unit</h4>
          <p>Pengunjung publik dapat melihat katalog dan spesifikasi. Detail kalender slot waktu ketersediaan dan pengajuan booking memerlukan login akun Mahasiswa terverifikasi.</p>
        </div>
      </div>
      <button type="button" class="btn btn-primary" onclick="openModal('registerModal')">
        Daftar Akun Mahasiswa
      </button>
    </div>
  </div>
</section>
