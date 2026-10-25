<?php
/**
 * Data Katalog dan Konfigurasi Landing Page
 * Berdasarkan Ketentuan PRD Equipment Rental Platform v1.1
 * Mendukung pembacaan dinamis dari Database MySQL (kampus_rental) dengan fallback array.
 */

require_once __DIR__ . '/../config/database.php';

$site_config = [
    'app_name' => 'PinjamKampus',
    'tagline' => 'Platform Resmi Penyewaan Peralatan Acara Kampus',
    'location' => 'Gedung Sentral Logistik & Inventaris Kampus Lt. 1',
    'operational_hours' => [
        'weekday' => 'Senin - Jumat: 08.00 - 17.00 WIB',
        'saturday' => 'Sabtu: 09.00 - 14.00 WIB',
        'sunday' => 'Minggu & Hari Libur Nasional: Tutup (Mengikuti kalender akademik kampus)'
    ],
    'contact_email' => 'inventaris@kampus.ac.id',
    'contact_phone' => '+62 812-3456-7890',
    'helpdesk_wa' => 'https://wa.me/6281234567890'
];

$rental_steps = [
    [
        'step' => '01',
        'title' => 'Daftar & Verifikasi Akun',
        'desc' => 'Gunakan NIM resmi dan email kampus (@kampus.ac.id). Verifikasi email sekali untuk mengaktifkan akses peminjaman mahasiswa.'
    ],
    [
        'step' => '02',
        'title' => 'Pilih Alat & Tentukan Jadwal',
        'desc' => 'Pilih hingga maksimal 5 unit fisik dengan durasi sewa maksimal 3 hari, dan waktu pengajuan maksimal 30 hari sebelum acara.'
    ],
    [
        'step' => '03',
        'title' => 'Persetujuan & Pembayaran',
        'desc' => 'Admin/Operator memvalidasi ketersediaan. Setelah disetujui, bayar invoice via QRIS atau Virtual Account dalam batas waktu 1 jam.'
    ],
    [
        'step' => '04',
        'title' => 'Pengambilan di Sentra Logistik',
        'desc' => 'Tunjukkan QR Booking & KTM di meja layanan inventaris kampus. Operator memverifikasi kondisi alat dan foto serah-terima.'
    ],
    [
        'step' => '05',
        'title' => 'Pengembalian & Tutup Sewa',
        'desc' => 'Kembalikan unit tepat waktu (tersedia grace period 15 menit). Petugas melakukan cek fisik dan transaksi booking dinyatakan selesai.'
    ]
];

$faq_list = [
    [
        'q' => 'Siapa saja yang berhak menyewa peralatan di platform ini?',
        'a' => 'Seluruh mahasiswa aktif yang memiliki NIM valid dan akun berstatus terverifikasi menggunakan email resmi kampus (@kampus.ac.id). Peminjaman diperuntukkan bagi kegiatan akademik, sidang, riset, serta program kerja organisasi kemahasiswaan (BEM, HIMA, UKM).'
    ],
    [
        'q' => 'Berapa batas maksimal unit dan lama durasi peminjaman?',
        'a' => 'Sesuai aturan PRD, setiap mahasiswa dibatasi maksimal 5 unit fisik per booking dengan durasi sewa maksimal 3 hari. Pemesanan dapat diajukan paling jauh 30 hari ke depan dan mahasiswa hanya boleh memiliki satu booking aktif dalam satu waktu.'
    ],
    [
        'q' => 'Bagaimana metode pembayaran dan batas waktu pelunasan sewa?',
        'a' => 'Pembayaran biaya sewa resmi dilakukan secara online melalui QRIS (GoPay, OVO, Dana, BCA, dll.) atau Virtual Account bank setelah booking disetujui oleh Admin/Operator. Batas pelunasan adalah 1 jam sejak invoice terbit.'
    ],
    [
        'q' => 'Apakah ada toleransi waktu (grace period) saat pengembalian barang?',
        'a' => 'Ya, sistem menyediakan grace period keterlambatan selama 15 menit setelah waktu pengembalian yang dijadwalkan tanpa dikenakan denda. Jika pengembalian melewati batas grace period, denda keterlambatan akan dihitung per jam atau per hari sesuai tarif kampus.'
    ],
    [
        'q' => 'Apakah pengunjung umum tanpa login bisa memesan alat?',
        'a' => 'Pengunjung umum dapat melihat katalog publik, rincian spesifikasi teknis, dan tarif sewa per hari. Namun, untuk memeriksa detail ketersediaan tanggal kalender serta melakukan pemesanan (booking), pengunjung wajib melakukan registrasi dan login sebagai mahasiswa aktif.'
    ],
    [
        'q' => 'Di mana lokasi pengambilan dan pengembalian barang fisik?',
        'a' => 'Semua unit inventaris kampus terpusat di satu lokasi: Gedung Sentral Logistik & Inventaris Kampus Lantai 1. Tidak disediakan jasa pengantaran; mahasiswa mengambil dan mengembalikan barang secara mandiri bersama petugas operator.'
    ]
];

// Fallback Default Data
$categories = [
    'all' => 'Semua Kategori',
    'kamera' => 'Kamera & Lensa',
    'audio' => 'Audio & Sound System',
    'proyektor' => 'Proyektor & Layar',
    'lighting' => 'Lighting & Rigging'
];

$catalog_items = [
    [
        'id' => 'EQ-CAM-001',
        'name' => 'Sony Alpha 7 IV + FE 24-70mm F2.8 GM',
        'category' => 'kamera',
        'category_name' => 'Kamera & Lensa',
        'brand' => 'Sony',
        'price_per_day' => 175000,
        'image' => 'assets/images/catalog_camera.jpg',
        'condition' => 'Sangat Baik (Grade A)',
        'description' => 'Kamera mirrorless full-frame 33MP 4K 60p, sangat ideal untuk dokumentasi wisuda, seminar nasional, aftermovie expo UKM, dan liputan live.',
        'features' => ['Sensor Full-Frame 33MP', 'Lensa 24-70mm F2.8 G-Master', '2 Baterai + Charger Dual', 'SD Card 128GB High-Speed V60'],
        'specs' => 'Video 4K 10-bit 4:2:2, Real-time Eye AF, Dual Slot SD/CFexpress Type A'
    ],
    [
        'id' => 'EQ-PRO-001',
        'name' => 'Epson Laser Projector 8000 Lumens WUXGA',
        'category' => 'proyektor',
        'category_name' => 'Proyektor & Layar',
        'brand' => 'Epson Pro',
        'price_per_day' => 250000,
        'image' => 'assets/images/catalog_projector.jpg',
        'condition' => 'Prima (Grade A)',
        'description' => 'Proyektor laser berdaya terang tinggi 8.000 ANSI Lumens resolusi WUXGA (Full HD+). Sangat tajam untuk auditorium utama dan ruang seminar 500+ orang.',
        'features' => ['Kecerahan 8.000 ANSI Lumens', 'Resolusi Full HD+ WUXGA', 'Kabel HDMI 20 meter + Splitter', 'Remote Presenter Laser'],
        'specs' => 'Laser Light Source hingga 20.000 jam, Kontras 2.500.000:1, Input HDMI/LAN'
    ],
    [
        'id' => 'EQ-SND-001',
        'name' => 'Soundcraft Mixer 12 Ch + Dual Wireless Mic Shure',
        'category' => 'audio',
        'category_name' => 'Audio & Sound System',
        'brand' => 'Soundcraft & Shure',
        'price_per_day' => 160000,
        'image' => 'assets/images/catalog_sound.jpg',
        'condition' => 'Sangat Baik (Grade A)',
        'description' => 'Paket audio mixing profesional 12-channel terintegrasi efek Lexicon dan 2 unit mic wireless Shure UHF anti-feedback.',
        'features' => ['Mixer 12 Channel Analog/USB', '2x Mic Wireless Shure Dual Channel', '4x Kabel XLR 10 meter', 'Hardcase Flightbox'],
        'specs' => 'Frekuensi UHF 518-542 MHz, Lexicon Digital Effects Processor, USB Audio Interface'
    ],
    [
        'id' => 'EQ-LGT-001',
        'name' => 'Godox Continuous Video Light 200W + Octabox 90cm',
        'category' => 'lighting',
        'category_name' => 'Lighting & Rigging',
        'brand' => 'Godox',
        'price_per_day' => 95000,
        'image' => 'assets/images/catalog_lighting.jpg',
        'condition' => 'Sangat Baik (Grade A)',
        'description' => 'Lampu sorot LED continue 200 Watt daylight 5600K dengan softbox octabox 90cm bowens mount.',
        'features' => ['Daya 200W CRI 96+ TLCI 97', 'Softbox Bowens 90cm + Grid Diffuser', 'Light Stand Heavy Duty 2.8m', 'Wireless Remote Controller'],
        'specs' => '5600K Balanced Daylight, 74.000 Lux @1m, Silent Fan Cooling Mode'
    ],
    [
        'id' => 'EQ-CAM-002',
        'name' => 'DJI Ronin RS 3 Pro Gimbal Stabilizer',
        'category' => 'kamera',
        'category_name' => 'Kamera & Lensa',
        'brand' => 'DJI',
        'price_per_day' => 120000,
        'image' => 'assets/images/hero_equipment.jpg',
        'condition' => 'Sangat Baik (Grade A)',
        'description' => 'Gimbal stabilizer 3-axis berbahan serat karbon dengan kapasitas beban 4.5kg untuk pergerakan kamera sinematik.',
        'features' => ['Kapasitas Payload hingga 4.5kg', 'Layar Sentuh OLED 1.8 inch', 'Extended Carbon Fiber Axis Arms', 'Baterai Grip hingga 12 jam'],
        'specs' => 'SuperSmooth stabilization mode, Automated Axis Locks, LiDAR focusing ready'
    ],
    [
        'id' => 'EQ-SND-002',
        'name' => 'Yamaha StagePas 600BT Portable PA System',
        'category' => 'audio',
        'category_name' => 'Audio & Sound System',
        'brand' => 'Yamaha',
        'price_per_day' => 220000,
        'image' => 'assets/images/catalog_sound.jpg',
        'condition' => 'Prima (Grade A)',
        'description' => 'Sistem tata suara all-in-one 680 Watt terdiri dari sepasang speaker 10 inci, mixer 10-channel, dan Bluetooth.',
        'features' => ['Daya Output 680W (340W + 340W)', 'Sepasang Speaker 10" + Stand Speaker', 'Mixer 10 Channel Detachable', 'Bluetooth Audio Streaming'],
        'specs' => 'SPX digital reverb, 1-Knob Master EQ with bass boost, Phantom power'
    ]
];

// Mencoba Membaca dari Database MySQL jika koneksi aktif
try {
    $pdo = Database::getConnection();
    if ($pdo) {
        // Ambil kategori dari DB
        $catStmt = $pdo->query("SELECT slug, name FROM categories ORDER BY id ASC");
        $dbCategories = ['all' => 'Semua Kategori'];
        while ($row = $catStmt->fetch()) {
            $dbCategories[$row['slug']] = $row['name'];
        }
        if (count($dbCategories) > 1) {
            $categories = $dbCategories;
        }

        // Ambil inventaris peralatan dari DB
        $eqStmt = $pdo->query("
            SELECT e.*, c.slug AS cat_slug, c.name AS cat_name, c.daily_rate 
            FROM equipment e
            JOIN categories c ON e.category_id = c.id
            ORDER BY e.id ASC
        ");
        $dbItems = [];
        while ($row = $eqStmt->fetch()) {
            $features = [];
            if (!empty($row['features'])) {
                $decoded = json_decode($row['features'], true);
                if (is_array($decoded)) {
                    $features = $decoded;
                }
            }

            $dbItems[] = [
                'id' => $row['item_code'],
                'name' => $row['name'],
                'category' => $row['cat_slug'],
                'category_name' => $row['cat_name'],
                'brand' => $row['brand'],
                'price_per_day' => (float)$row['daily_rate'],
                'image' => !empty($row['image_main']) ? $row['image_main'] : 'assets/images/catalog_camera.jpg',
                'condition' => $row['condition_grade'],
                'description' => $row['description'],
                'features' => $features,
                'specs' => $row['specs']
            ];
        }

        if (!empty($dbItems)) {
            $catalog_items = $dbItems;
        }
    }
} catch (Exception $e) {
    // Graceful fallback to static array
}
