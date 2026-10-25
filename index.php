<?php
/**
 * GearHub - Landing Page Utama
 * Equipment Rental Platform (PRD Versi 1.1)
 *
 * Komponen Terintegrasi:
 * - Header & Navigasi (Beranda, Katalog, Cara Menyewa, Tentang Kami, FAQ, Kontak, Login, Daftar)
 * - Hero Section (Penyempurnaan tampilan referensi gambar dengan live search widget & kartu highlight)
 * - Katalog Publik (Grid inventaris alat kampus, filter kategori, tarif flat harian)
 * - Cara Menyewa (5 tahapan sewa transparan sesuai PRD)
 * - Tentang Kami (Keunggulan sentra logistik kampus & metrik SLA)
 * - FAQ Interaktif (Aturan batasan 5 unit, 7 hari, grace period 15 menit, invoice 1 jam)
 * - Kontak & Lokasi Operasional Kampus
 * - Modal Dialogs (Login dengan role switcher, registrasi mahasiswa, rincian produk)
 * - Footer informatif
 */

require_once __DIR__ . '/data/catalog_data.php';

// Layout Assembly
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/hero.php';
require_once __DIR__ . '/includes/catalog.php';
require_once __DIR__ . '/includes/how_it_works.php';
require_once __DIR__ . '/includes/about.php';
require_once __DIR__ . '/includes/faq.php';
require_once __DIR__ . '/includes/contact.php';
require_once __DIR__ . '/includes/modals.php';
require_once __DIR__ . '/includes/footer.php';
