<?php
/**
 * Cara Menyewa Component (How it Works)
 * Alur peminjaman 5 tahap yang merefleksikan alur PRD v1.1
 */
?>
<section class="steps-section section-padding" id="cara-menyewa">
  <div class="container">
    <div class="section-header">
      <div class="badge-tag">Alur Transparan & Mudah</div>
      <h2 class="section-title">Cara Menyewa Peralatan Kampus</h2>
      <p class="section-desc">
        Proses penyewaan dirancang transparan dan terstruktur agar menjaga ketersediaan fisik alat serta kelancaran seluruh kegiatan mahasiswa.
      </p>
    </div>

    <div class="steps-grid">
      <?php foreach ($rental_steps as $step): ?>
        <div class="step-card">
          <div class="step-number"><?= htmlspecialchars($step['step']); ?></div>
          <h3 class="step-title"><?= htmlspecialchars($step['title']); ?></h3>
          <p class="step-desc"><?= htmlspecialchars($step['desc']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
