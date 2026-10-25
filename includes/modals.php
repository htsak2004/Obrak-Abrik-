<?php
/**
 * Modals Component
 * 1. Login Modal (dengan tab role: Mahasiswa, Operator, Admin sesuai PRD Bab 2.1)
 * 2. Register Mahasiswa Modal (NIM unik, email kampus sesuai PRD Bab 4 & AC-01)
 * 3. Quick Equipment Detail Modal
 */
?>

<!-- 1. Login Modal -->
<div class="modal-overlay" id="loginModal" role="dialog" aria-modal="true" aria-labelledby="loginTitle">
  <div class="modal-container">
    <div class="modal-header">
      <h3 class="modal-title" id="loginTitle">Masuk ke Sistem</h3>
      <button type="button" class="modal-close" onclick="closeModal('loginModal')" aria-label="Tutup Modal">&times;</button>
    </div>
    <div class="modal-body">
      <!-- Role Switcher Sesuai Arsitektur PRD Bab 2.1 -->
      <div class="role-switcher-box" role="tablist">
        <button type="button" class="role-tab active" data-role="mahasiswa">Mahasiswa</button>
        <button type="button" class="role-tab" data-role="operator">Operator</button>
        <button type="button" class="role-tab" data-role="admin">Admin</button>
      </div>

      <div id="loginRoleNotice" style="font-size: 0.85rem; color: var(--color-slate-600); margin-bottom: 18px; padding: 10px 14px; background: var(--color-slate-50); border-radius: var(--radius-sm); border: 1px solid var(--color-slate-200);">
        Akses mahasiswa: booking alat, cek ketersediaan, upload bukti, lihat riwayat.
      </div>

      <form id="loginForm" onsubmit="event.preventDefault(); alert('Demo Login: Pada tahap selanjutnya ini akan terhubung ke sistem otentikasi role ' + document.getElementById('loginRole').value); closeModal('loginModal');">
        <input type="hidden" id="loginRole" value="mahasiswa">

        <div class="form-group">
          <label for="loginIdentifier">NIM atau Email Kampus</label>
          <input type="text" id="loginIdentifier" class="form-input" placeholder="Contoh: 13521099 atau mhs@kampus.ac.id" required>
        </div>

        <div class="form-group">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label for="loginPassword" style="margin-bottom: 0;">Kata Sandi</label>
            <a href="javascript:void(0)" onclick="alert('Fitur reset kata sandi akan mengirim tautan sekali pakai ke email kampus resmi.')" style="font-size: 0.8rem; color: var(--color-primary); font-weight: 600;">Lupa Sandi?</a>
          </div>
          <input type="password" id="loginPassword" class="form-input" placeholder="Masukkan kata sandi akun" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 24px;">
          Masuk ke Dashboard
        </button>

        <div style="text-align: center; margin-top: 18px; font-size: 0.875rem; color: var(--color-slate-500);">
          Belum punya akun? <a href="javascript:void(0)" onclick="closeModal('loginModal'); openModal('registerModal');" style="color: var(--color-primary); font-weight: 700;">Daftar Mahasiswa di sini</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 2. Register Mahasiswa Modal (PRD Bab 4 & AC-01) -->
<div class="modal-overlay" id="registerModal" role="dialog" aria-modal="true" aria-labelledby="registerTitle">
  <div class="modal-container">
    <div class="modal-header">
      <h3 class="modal-title" id="registerTitle">Pendaftaran Mahasiswa</h3>
      <button type="button" class="modal-close" onclick="closeModal('registerModal')" aria-label="Tutup Modal">&times;</button>
    </div>
    <div class="modal-body">
      <div style="font-size: 0.85rem; color: var(--color-slate-600); margin-bottom: 18px; padding: 10px 14px; background: var(--color-primary-subtle); border-radius: var(--radius-sm); border: 1px solid var(--color-primary-border);">
        <strong>Penting (AC-01):</strong> Pendaftaran mandiri hanya berlaku untuk mahasiswa aktif menggunakan NIM terdaftar dan email resmi kampus. Akun staf operator/admin dibuat langsung oleh Admin.
      </div>

      <form id="registerForm" onsubmit="event.preventDefault(); alert('Pendaftaran berhasil disimulasikan! Tautan verifikasi email telah dikirimkan ke email kampus Anda.'); closeModal('registerModal');">
        <div class="form-group">
          <label for="regNim">Nomor Induk Mahasiswa (NIM)</label>
          <input type="text" id="regNim" class="form-input" placeholder="Contoh: 13521099" pattern="[0-9]{6,12}" title="NIM harus berupa angka 6-12 digit" required>
        </div>

        <div class="form-group">
          <label for="regName">Nama Lengkap Sesuai KTM</label>
          <input type="text" id="regName" class="form-input" placeholder="Masukkan nama lengkap Anda" required>
        </div>

        <div class="form-group">
          <label for="regFaculty">Fakultas / Program Studi</label>
          <input type="text" id="regFaculty" class="form-input" placeholder="Contoh: Sekolah Teknik Elektro & Informatika" required>
        </div>

        <div class="form-group">
          <label for="regEmail">Email Resmi Kampus (@kampus.ac.id)</label>
          <input type="email" id="regEmail" class="form-input" placeholder="nama_mahasiswa@kampus.ac.id" required>
        </div>

        <div class="form-group">
          <label for="regPassword">Kata Sandi</label>
          <input type="password" id="regPassword" class="form-input" placeholder="Minimal 8 karakter kombinasi aman" minlength="8" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 24px;">
          Daftar Sekarang
        </button>

        <div style="text-align: center; margin-top: 18px; font-size: 0.875rem; color: var(--color-slate-500);">
          Sudah punya akun? <a href="javascript:void(0)" onclick="closeModal('registerModal'); openModal('loginModal');" style="color: var(--color-primary); font-weight: 700;">Masuk di sini</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 3. Detail Equipment Modal -->
<div class="modal-overlay" id="detailModal" role="dialog" aria-modal="true" aria-labelledby="modalItemName">
  <div class="modal-container modal-lg">
    <div class="modal-header">
      <h3 class="modal-title">Spesifikasi Peralatan</h3>
      <button type="button" class="modal-close" onclick="closeModal('detailModal')" aria-label="Tutup Modal">&times;</button>
    </div>
    <div class="modal-body">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;" class="detail-modal-grid">
        <div style="border-radius: var(--radius-md); overflow: hidden; background: var(--color-slate-100); aspect-ratio: 4/3;">
          <img id="modalItemImg" src="" alt="Foto Peralatan" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div>
          <div id="modalItemBrand" style="font-size: 0.8rem; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase;"></div>
          <h2 id="modalItemName" style="font-size: 1.35rem; font-weight: 800; color: var(--color-slate-900); margin: 6px 0 12px; line-height: 1.3;"></h2>
          
          <div style="display: flex; gap: 8px; margin-bottom: 16px;">
            <span id="modalItemCondition" style="font-size: 0.75rem; padding: 4px 10px; background: var(--color-emerald-50); color: var(--color-emerald-600); border: 1px solid var(--color-emerald-border); border-radius: var(--radius-sm); font-weight: 700;"></span>
          </div>

          <div class="price-box" style="margin-bottom: 16px;">
            <span class="price-label">Tarif Sewa Mahasiswa</span>
            <div id="modalItemPrice" class="price-value" style="font-size: 1.5rem;"></div>
          </div>

          <p id="modalItemDesc" style="font-size: 0.875rem; color: var(--color-slate-600); line-height: 1.6;"></p>
        </div>
      </div>

      <div style="background: var(--color-slate-50); border: 1px solid var(--color-slate-200); border-radius: var(--radius-md); padding: 18px; margin-bottom: 20px;">
        <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--color-slate-800); margin-bottom: 8px;">Kelengkapan Unit Fisik:</h4>
        <ul id="modalItemFeatures" style="font-size: 0.85rem; color: var(--color-slate-600); padding-left: 20px; line-height: 1.6;"></ul>

        <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--color-slate-800); margin-top: 14px; margin-bottom: 4px;">Spesifikasi Teknis:</h4>
        <p id="modalItemSpecs" style="font-size: 0.85rem; color: var(--color-slate-600);"></p>
      </div>

      <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
        <span style="font-size: 0.8rem; color: var(--color-slate-500);">*Booking ketersediaan unit memerlukan login akun Mahasiswa.</span>
        <button type="button" class="btn btn-primary" onclick="closeModal('detailModal'); openModal('loginModal');">
          Masuk & Booking Sekarang
        </button>
      </div>
    </div>
  </div>
</div>
