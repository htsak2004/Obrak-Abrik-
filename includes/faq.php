<?php
/**
 * FAQ Component (Frequently Asked Questions)
 * Tanya Jawab interaktif mengenai aturan peminjaman, pembayaran, denda, dan lokasi
 */
?>
<section class="faq-section section-padding" id="faq">
  <div class="container">
    <div class="section-header">
      <div class="badge-tag">Pusat Informasi</div>
      <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
      <p class="section-desc">
        Ketahui aturan peminjaman, tata cara pembayaran, kebijakan denda, serta lokasi layanan sentral inventaris kampus.
      </p>
    </div>

    <div class="faq-wrapper">
      <?php foreach ($faq_list as $index => $faq): ?>
        <div class="faq-item <?= $index === 0 ? 'active' : ''; ?>">
          <button type="button" class="faq-header" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>">
            <span class="faq-question"><?= htmlspecialchars($faq['q']); ?></span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
              </svg>
            </span>
          </button>
          <div class="faq-content">
            <p><?= htmlspecialchars($faq['a']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
