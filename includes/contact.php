<?php
/**
 * Kontak & Lokasi Sentral Operasional
 * Menampilkan lokasi fisik, jam operasional resmi, helpdesk, dan formulir pesan
 * Sesuai PRD Bab 1.4 & Bab 8
 */
?>
<section class="contact-section section-padding" id="kontak">
  <div class="container">
    <div class="section-header">
      <div class="badge-tag">Bantuan & Lokasi Fisik</div>
      <h2 class="section-title">Hubungi Kami & Titik Pengambilan</h2>
      <p class="section-desc">
        Inventaris alat berada di satu lokasi pusat kampus. Silakan kunjungi meja layanan kami pada jam operasional untuk serah-terima fisik atau konsultasi teknis kebutuhan event.
      </p>
    </div>

    <div class="contact-grid">
      <!-- Info Card -->
      <div class="contact-info-card">
        <div class="info-block">
          <div class="info-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
          </div>
          <div class="info-text">
            <h4>Titik Pengambilan & Pengembalian Fisik</h4>
            <p><?= htmlspecialchars($site_config['location']); ?></p>
            <p style="font-size: 0.8rem; color: var(--color-slate-500); margin-top: 4px;">*Mahasiswa mengambil dan mengembalikan barang secara mandiri di lokasi ini.</p>
          </div>
        </div>

        <div class="info-block">
          <div class="info-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <div class="info-text">
            <h4>Jam Operasional Layanan</h4>
            <ul>
              <li><strong>Senin - Jumat:</strong> 08.00 - 17.00 WIB</li>
              <li><strong>Sabtu:</strong> 09.00 - 14.00 WIB</li>
              <li><strong>Minggu / Libur Nasional:</strong> Tutup (Kalender Resmi Kampus)</li>
            </ul>
          </div>
        </div>

        <div class="info-block">
          <div class="info-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
          </div>
          <div class="info-text">
            <h4>Kontak Resmi Helpdesk</h4>
            <p>Email: <a href="mailto:<?= htmlspecialchars($site_config['contact_email']); ?>" style="color: var(--color-primary); font-weight: 600;"><?= htmlspecialchars($site_config['contact_email']); ?></a></p>
            <p>WhatsApp Layanan: <a href="<?= htmlspecialchars($site_config['helpdesk_wa']); ?>" target="_blank" rel="noopener noreferrer" style="color: var(--color-emerald-600); font-weight: 600;"><?= htmlspecialchars($site_config['contact_phone']); ?></a></p>
          </div>
        </div>
      </div>

      <!-- Quick Form -->
      <div class="contact-form-card">
        <h3>Kirim Pesan atau Pertanyaan</h3>
        <p>Butuh rekomendasi paket peralatan untuk seminar besar atau konser UKM? Kirim pesan ke pengelola inventaris.</p>

        <form id="contactForm" onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah diterima oleh bagian logistik inventaris kampus.'); this.reset();">
          <div class="form-group">
            <label for="contactName">Nama Lengkap & NIM / Unit</label>
            <input type="text" id="contactName" class="form-input" placeholder="Contoh: Budi Santoso (13521099 - HIMA TI)" required>
          </div>

          <div class="form-group">
            <label for="contactEmail">Email Kampus</label>
            <input type="email" id="contactEmail" class="form-input" placeholder="nama@kampus.ac.id" required>
          </div>

          <div class="form-group">
            <label for="contactMessage">Pesan / Kebutuhan Acara</label>
            <textarea id="contactMessage" class="form-textarea" rows="4" placeholder="Jelaskan kebutuhan peralatan acara atau pertanyaan spesifikasi..." required></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-block">
            Kirim Pesan
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
