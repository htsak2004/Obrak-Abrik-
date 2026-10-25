-- ==============================================================================
-- Equipment Rental Platform - Database Schema (PRD Versi 1.1)
-- Database Engine: MySQL / MariaDB (InnoDB, UTF-8 MB4)
-- ==============================================================================

CREATE DATABASE IF NOT EXISTS `kampus_rental` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `kampus_rental`;

-- 1. Tabel Users & Autentikasi (PRD Bab 3 & Bab 4)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nim` VARCHAR(30) UNIQUE NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('mahasiswa', 'operator', 'admin') NOT NULL DEFAULT 'mahasiswa',
  `faculty` VARCHAR(150) NULL,
  `phone` VARCHAR(25) NULL,
  `status` ENUM('unverified', 'verified', 'suspended') NOT NULL DEFAULT 'unverified',
  `email_verified_at` DATETIME NULL,
  `verification_token` VARCHAR(100) NULL,
  `reset_token` VARCHAR(100) NULL,
  `reset_token_expires_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_email` (`email`),
  INDEX `idx_users_nim` (`nim`)
) ENGINE=InnoDB;

-- 2. Tabel Kategori & Tarif Flat Harian (PRD Bab 5 & Bab 6)
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `daily_rate` DECIMAL(12,2) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Tabel Unit Inventaris Fisik (PRD Bab 5.1 & Bab 5.2)
-- Status operasional dipisahkan dari kondisi fisik sesuai ketentuan PRD 5.1
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NOT NULL,
  `item_code` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `brand` VARCHAR(100) NOT NULL,
  `model_series` VARCHAR(100) NULL,
  `description` TEXT NULL,
  `specs` TEXT NULL,
  `condition_grade` ENUM('Grade A', 'Grade B', 'Perlu Perbaikan') NOT NULL DEFAULT 'Grade A',
  `operational_status` ENUM('available', 'reserved', 'rented', 'maintenance') NOT NULL DEFAULT 'available',
  `image_main` VARCHAR(255) NULL,
  `features` JSON NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT,
  INDEX `idx_equipment_status` (`operational_status`),
  INDEX `idx_equipment_category` (`category_id`)
) ENGINE=InnoDB;

-- 4. Tabel Pemesanan / Booking (PRD Bab 6 & Bab 7)
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_code` VARCHAR(30) UNIQUE NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `pickup_time` TIME NOT NULL,
  `return_time` TIME NOT NULL,
  `billed_days` INT UNSIGNED NOT NULL,
  `purpose` VARCHAR(255) NOT NULL,
  `event_name` VARCHAR(150) NULL,
  `status` ENUM(
    'menunggu_persetujuan',
    'ditolak',
    'menunggu_pembayaran',
    'dibayar',
    'siap_diambil',
    'dipinjam',
    'menunggu_inspeksi',
    'menunggu_penyelesaian_biaya',
    'sengketa_ditinjau',
    'selesai',
    'dibatalkan',
    'kedaluwarsa'
  ) NOT NULL DEFAULT 'menunggu_persetujuan',
  `approved_by` INT UNSIGNED NULL,
  `approved_at` DATETIME NULL,
  `rejection_reason` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  INDEX `idx_booking_dates` (`start_date`, `end_date`),
  INDEX `idx_booking_status` (`status`)
) ENGINE=InnoDB;

-- 5. Tabel Item Detail Booking (PRD Bab 5.3 & Bab 6)
-- Menyimpan alokasi unit fisik atomik dan snapshot tarif kategori saat disetujui
CREATE TABLE IF NOT EXISTS `booking_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT UNSIGNED NOT NULL,
  `equipment_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `daily_rate_snapshot` DECIMAL(12,2) NOT NULL,
  `subtotal` DECIMAL(12,2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`equipment_id`) REFERENCES `equipment`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT,
  INDEX `idx_booking_items_eq` (`equipment_id`)
) ENGINE=InnoDB;

-- 6. Tabel Invoice & Pembayaran (PRD Bab 7)
-- Satu invoice per booking, batas bayar 1 jam, QRIS & Virtual Account
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `invoice_code` VARCHAR(30) UNIQUE NOT NULL,
  `booking_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `rental_total` DECIMAL(12,2) NOT NULL,
  `penalty_total` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `damage_total` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` DECIMAL(12,2) NOT NULL,
  `payment_method` ENUM('qris', 'virtual_account', 'manual') NOT NULL DEFAULT 'qris',
  `payment_provider` VARCHAR(50) NULL,
  `payment_reference` VARCHAR(100) NULL,
  `va_number` VARCHAR(50) NULL,
  `qris_url` VARCHAR(255) NULL,
  `status` ENUM('unpaid', 'paid', 'expired', 'cancelled') NOT NULL DEFAULT 'unpaid',
  `expires_at` DATETIME NOT NULL,
  `paid_at` DATETIME NULL,
  `webhook_payload` JSON NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  INDEX `idx_invoice_status` (`status`),
  INDEX `idx_invoice_expiry` (`expires_at`)
) ENGINE=InnoDB;

-- 7. Tabel Log Serah-Terima & Pengembalian Fisik (PRD Bab 8)
CREATE TABLE IF NOT EXISTS `handover_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT UNSIGNED NOT NULL,
  `equipment_id` INT UNSIGNED NOT NULL,
  `operator_id` INT UNSIGNED NOT NULL,
  `type` ENUM('serah_terima', 'pengembalian') NOT NULL,
  `log_timestamp` DATETIME NOT NULL,
  `physical_condition` TEXT NOT NULL,
  `condition_photo_url` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`equipment_id`) REFERENCES `equipment`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`operator_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 8. Tabel Denda & Biaya Kerusakan (PRD Bab 10)
CREATE TABLE IF NOT EXISTS `penalties_damages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT UNSIGNED NOT NULL,
  `type` ENUM('keterlambatan', 'kerusakan', 'kehilangan') NOT NULL,
  `late_minutes` INT NOT NULL DEFAULT 0,
  `amount` DECIMAL(12,2) NOT NULL,
  `description` TEXT NULL,
  `status` ENUM('pending', 'verified', 'disputed', 'paid', 'waived') NOT NULL DEFAULT 'pending',
  `reported_by` INT UNSIGNED NOT NULL,
  `verified_by` INT UNSIGNED NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`reported_by`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`verified_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 9. Tabel Sengketa / Disputes (PRD Bab 10)
CREATE TABLE IF NOT EXISTS `disputes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `penalty_damage_id` INT UNSIGNED NULL,
  `reason` TEXT NOT NULL,
  `proof_attachment_url` VARCHAR(255) NULL,
  `status` ENUM('menunggu_review', 'diterima', 'ditolak', 'disesuaikan') NOT NULL DEFAULT 'menunggu_review',
  `adjusted_amount` DECIMAL(12,2) NULL,
  `admin_notes` TEXT NULL,
  `resolved_by` INT UNSIGNED NULL,
  `resolved_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`penalty_damage_id`) REFERENCES `penalties_damages`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`resolved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 10. Tabel Audit Trail Terpusat (PRD Bab 12.4)
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `actor_id` INT UNSIGNED NULL,
  `actor_role` VARCHAR(50) NULL,
  `action` VARCHAR(100) NOT NULL,
  `target_table` VARCHAR(50) NOT NULL,
  `target_id` INT UNSIGNED NULL,
  `old_values` JSON NULL,
  `new_values` JSON NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`actor_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  INDEX `idx_audit_action` (`action`),
  INDEX `idx_audit_target` (`target_table`, `target_id`)
) ENGINE=InnoDB;

-- 11. Tabel Konfigurasi Sistem (PRD Bab 1.4, 6, 10)
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(50) UNIQUE NOT NULL,
  `setting_value` TEXT NOT NULL,
  `description` VARCHAR(255) NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==============================================================================
-- SEEDER DATA AWAL (MASTER & DEMO USERS)
-- Password Default untuk Akun Demo: 'Password123!'
-- Hashed dengan BCRYPT: $2y$10$wS2WbT2vK17Lq90fE59G..7L116.Wv65b2JzPjF3hT4w41r1N6X7K
-- ==============================================================================

-- Seeder Kategori
INSERT INTO `categories` (`id`, `slug`, `name`, `daily_rate`, `description`) VALUES
(1, 'kamera', 'Kamera & Lensa', 175000.00, 'Kamera mirrorless, lensa premium, gimbal stabilizer dan rigging video'),
(2, 'audio', 'Audio & Sound System', 160000.00, 'Mixer audio console, mic wireless UHF, sound active speaker portable'),
(3, 'proyektor', 'Proyektor & Layar', 250000.00, 'Proyektor laser lumens tinggi, layar tripod, splitter dan kabel HDMI panjang'),
(4, 'lighting', 'Lighting & Rigging', 95000.00, 'Lampu LED continous 200W, softbox octabox, tripod stand dan remote control')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Seeder Inventaris Peralatan
INSERT INTO `equipment` (`id`, `category_id`, `item_code`, `name`, `brand`, `model_series`, `description`, `specs`, `condition_grade`, `operational_status`, `image_main`, `features`) VALUES
(1, 1, 'CAM-SONY-001', 'Sony Alpha 7 IV + FE 24-70mm F2.8 GM', 'Sony', 'A7 IV', 'Kamera mirrorless full-frame 33MP 4K 60p untuk liputan live dan aftermovie.', 'Video 4K 10-bit 4:2:2, Real-time Eye AF, Dual Slot SD/CFexpress Type A', 'Grade A', 'available', 'assets/images/catalog_camera.jpg', '["Sensor Full-Frame 33MP", "Lensa 24-70mm F2.8 GM", "2 Baterai + Dual Charger", "SD Card 128GB High Speed"]'),
(2, 3, 'PRO-EPSON-001', 'Epson Laser Projector 8000 Lumens WUXGA', 'Epson Pro', 'EB-L1000 Series', 'Proyektor laser daya terang tinggi resolusi WUXGA untuk auditorium besar.', '8000 ANSI Lumens, WUXGA, Kontras 2.500.000:1, Input HDMI/LAN', 'Grade A', 'available', 'assets/images/catalog_projector.jpg', '["Kecerahan 8.000 ANSI Lumens", "Resolusi Full HD+ WUXGA", "Kabel HDMI 20 meter", "Remote Laser Pointer"]'),
(3, 2, 'SND-SNT-001', 'Soundcraft Mixer 12 Ch + Dual Wireless Mic Shure', 'Soundcraft & Shure', 'Signature 12', 'Mixer 12 channel analog USB dengan efek Lexicon dan 2 mic wireless Shure UHF.', 'Frekuensi UHF 518-542 MHz, Lexicon Digital Effects, USB Interface', 'Grade A', 'available', 'assets/images/catalog_sound.jpg', '["Mixer 12 Channel", "2x Mic Wireless Shure", "4x Kabel XLR 10m", "Hardcase Flightbox"]'),
(4, 4, 'LGT-GDX-001', 'Godox Continuous Video Light 200W + Octabox 90cm', 'Godox', 'VL200 II', 'Lampu continue LED 200W daylight 5600K dengan softbox bowens mount 90cm.', '5600K Daylight, 74.000 Lux @1m, CRI 96+, Silent Fan Cooling', 'Grade A', 'available', 'assets/images/catalog_lighting.jpg', '["Daya 200W CRI 96+", "Softbox Bowens 90cm", "Heavy Duty Light Stand", "Wireless Remote"]'),
(5, 1, 'CAM-DJI-001', 'DJI Ronin RS 3 Pro Gimbal Stabilizer', 'DJI', 'RS 3 Pro', 'Gimbal stabilizer 3-axis serat karbon payload 4.5kg.', 'Layar Sentuh OLED 1.8\", Carbon Fiber Arms, Baterai Grip 12 Jam', 'Grade A', 'available', 'assets/images/hero_equipment.jpg', '["Kapasitas Beban 4.5kg", "Layar Sentuh OLED", "Baterai Grip 12 Jam", "Automated Axis Locks"]'),
(6, 2, 'SND-YMH-001', 'Yamaha StagePas 600BT Portable PA System', 'Yamaha', 'StagePas 600BT', 'Sistem tata suara panggung 680W speaker 10 inci dan Bluetooth.', 'Output 680W, 10 Channel Powered Mixer, Bluetooth Audio, SPX Reverb', 'Grade A', 'available', 'assets/images/catalog_sound.jpg', '["Daya 680W (Sepasang Speaker)", "Mixer 10 Channel Detachable", "Stand Speaker Sepasang", "Bluetooth Streaming"]')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Seeder Akun Pengguna (3 Role Sesuai PRD)
-- Hash password: 'Password123!' -> $2y$10$wS2WbT2vK17Lq90fE59G..7L116.Wv65b2JzPjF3hT4w41r1N6X7K
INSERT INTO `users` (`id`, `nim`, `name`, `email`, `password_hash`, `role`, `faculty`, `phone`, `status`, `email_verified_at`) VALUES
(1, NULL, 'Administrator Kampus', 'admin@kampus.ac.id', '$2y$10$wS2WbT2vK17Lq90fE59G..7L116.Wv65b2JzPjF3hT4w41r1N6X7K', 'admin', 'Direktorat Sarana Prasarana', '081234567890', 'verified', NOW()),
(2, NULL, 'Staf Operator Logistik', 'operator@kampus.ac.id', '$2y$10$wS2WbT2vK17Lq90fE59G..7L116.Wv65b2JzPjF3hT4w41r1N6X7K', 'operator', 'Sentra Inventaris Kampus', '081234567891', 'verified', NOW()),
(3, '13521099', 'Budi Santoso', 'budi@kampus.ac.id', '$2y$10$wS2WbT2vK17Lq90fE59G..7L116.Wv65b2JzPjF3hT4w41r1N6X7K', 'mahasiswa', 'Sekolah Teknik Elektro & Informatika', '081234567892', 'verified', NOW())
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Seeder Pengaturan Sistem (PRD Policy)
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `description`) VALUES
('grace_period_minutes', '15', 'Grace period toleransi keterlambatan tanpa denda (menit)'),
('max_units_per_booking', '5', 'Batas maksimal unit fisik per pengajuan booking'),
('max_rental_days', '3', 'Durasi maksimal sewa peralatan (hari)'),
('max_advance_days', '30', 'Batas reservasi ke depan (hari)'),
('invoice_expiry_minutes', '60', 'Batas waktu pelunasan invoice setelah approval (menit)'),
('campus_location', 'Gedung Sentral Logistik & Inventaris Kampus Lt. 1', 'Titik lokasi pengambilan dan serah-terima fisik'),
('operational_hours_weekday', '08:00 - 17:00 WIB', 'Jam kerja operasional Senin - Jumat'),
('operational_hours_saturday', '09:00 - 14:00 WIB', 'Jam kerja operasional Sabtu')
ON DUPLICATE KEY UPDATE `setting_value`=VALUES(`setting_value`);
