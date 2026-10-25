<?php
/**
 * Footer Component
 * Tautan navigasi, ringkasan kebijakan kampus, dan integrasi script
 */
?>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Brand & Info -->
        <div class="footer-brand">
          <a href="#beranda" class="brand-logo">
            <div class="brand-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
              </svg>
            </div>
            <div class="brand-text">Gear<span style="color: #60a5fa;">Hub</span></div>
          </a>
          <p class="footer-about">
            Platform terpadu penyewaan peralatan acara kampus. Memfasilitasi kebutuhan kegiatan kemahasiswaan, seminar, sidang, dan riset dengan alokasi transparan serta jaminan kualitas fisik.
          </p>
        </div>

        <!-- Menu Links -->
        <div class="footer-column">
          <h4>Menu Navigasi</h4>
          <ul class="footer-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#katalog">Katalog Peralatan</a></li>
            <li><a href="#cara-menyewa">Cara Menyewa</a></li>
            <li><a href="#tentang-kami">Tentang Kami</a></li>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#kontak">Kontak & Lokasi</a></li>
          </ul>
        </div>

        <!-- Ketentuan PRD -->
        <div class="footer-column">
          <h4>Ketentuan & Aturan</h4>
          <ul class="footer-links">
            <li><a href="javascript:void(0)" onclick="openModal('loginModal')">Syarat & Kebijakan Sewa</a></li>
            <li><a href="javascript:void(0)" onclick="alert('Grace period pengembalian adalah 15 menit. Tarif sewa berlaku flat 24 jam dengan pembulatan ke atas sesuai PRD Bab 6.')">Aturan Tarif & Denda</a></li>
            <li><a href="javascript:void(0)" onclick="alert('Sengketa kondisi fisik diselesaikan berdasarkan foto timestamp digital saat serah-terima dan pengembalian bersama operator.')">Prosedur Kondisi & Sengketa</a></li>
            <li><a href="javascript:void(0)" onclick="alert('Pembayaran online sah setelah webhook payment gateway diverifikasi server dalam batas 1 jam.')">Kebijakan Pembayaran</a></li>
          </ul>
        </div>


      <div class="footer-bottom">
        <div>
          &copy; <?= date('Y'); ?> <?= htmlspecialchars($site_config['app_name']); ?> • Platform Resmi Inventaris Kampus. Seluruh hak cipta dilindungi.
        </div>
        <div>
          PRD Equipment Rental Platform Versi 1.1 — PHP 8.2 & Vanilla CSS
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="assets/js/main.js"></script>
</body>
</html>
