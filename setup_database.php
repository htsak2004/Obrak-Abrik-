<?php
/**
 * Setup & Database Migrator Web UI / CLI
 * Equipment Rental Platform (PRD v1.1)
 */

$configFile = __DIR__ . '/config/db_config.php';
$config = file_exists($configFile) ? require $configFile : [
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'dbname'   => 'kampus_rental',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4'
];

$message = '';
$status = '';
$tablesCreated = [];

// Handle Form Submission / CLI Execution
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (php_sapi_name() === 'cli' && isset($argv[1]) && $argv[1] === '--install')) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $config['host']     = trim($_POST['host'] ?? '127.0.0.1');
        $config['port']     = trim($_POST['port'] ?? '3306');
        $config['dbname']   = trim($_POST['dbname'] ?? 'kampus_rental');
        $config['username'] = trim($_POST['username'] ?? 'root');
        $config['password'] = $_POST['password'] ?? '';

        // Simpan ke config/db_config.php
        $configContent = "<?php\nreturn " . var_export($config, true) . ";\n";
        file_put_contents($configFile, $configContent);
    }

    try {
        // 1. Hubungkan ke MySQL Server tanpa memilih dbname dulu
        $dsn = "mysql:host={$config['host']};port={$config['port']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // 2. Baca file database.sql
        $sqlFile = __DIR__ . '/database.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("File database.sql tidak ditemukan.");
        }

        $sql = file_get_contents($sqlFile);
        
        // 3. Eksekusi DDL & Seeder SQL
        $pdo->exec($sql);

        // 4. Hubungkan ke database yang baru dibuat untuk cek tabel
        $pdoDb = new PDO("mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4", $config['username'], $config['password']);
        $stmt = $pdoDb->query("SHOW TABLES");
        $tablesCreated = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $status = 'success';
        $message = "Database '{$config['dbname']}' dan seluruh tabel berhasil dibuat & di-seed!";
    } catch (Exception $e) {
        $status = 'error';
        $message = "Gagal menginisialisasi database: " . $e->getMessage();
    }
}

// Jika CLI mode
if (php_sapi_name() === 'cli') {
    echo "=== SETUP DATABASE KAMPUS RENTAL ===\n";
    if ($status === 'success') {
        echo "[SUKSES] $message\n";
        echo "Tabel yang dibuat (" . count($tablesCreated) . "):\n - " . implode("\n - ", $tablesCreated) . "\n";
    } elseif ($status === 'error') {
        echo "[ERROR] $message\n";
    } else {
        echo "Gunakan argumen --install untuk menjalankan instalasi otomatis.\nContoh: php setup_database.php --install\n";
    }
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Setup Database — PinjamKampus</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { background-color: #f8fafc; padding: 48px 16px; }
    .setup-card {
      max-width: 640px;
      margin: 0 auto;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 36px;
      box-shadow: 0 10px 25px -3px rgba(15, 23, 42, 0.08);
    }
    .alert-box {
      padding: 14px 18px;
      border-radius: 10px;
      margin-bottom: 24px;
      font-size: 0.95rem;
    }
    .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    .table-badge {
      display: inline-block;
      padding: 4px 10px;
      background: #f1f5f9;
      color: #334155;
      border-radius: 6px;
      font-size: 0.825rem;
      font-weight: 600;
      margin: 4px;
    }
  </style>
</head>
<body>

  <div class="setup-card">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
      <div class="brand-icon" style="width: 44px; height: 44px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <ellipse cx="12" cy="5" rx="9" ry="3"/>
          <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
          <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
        </svg>
      </div>
      <div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a;">Inisialisasi Database MySQL</h2>
        <p style="font-size: 0.875rem; color: #64748b;">PinjamKampus • Equipment Rental Platform PRD v1.1</p>
      </div>
    </div>

    <?php if ($status === 'success'): ?>
      <div class="alert-box alert-success">
        <strong>✓ Berhasil!</strong> <?= htmlspecialchars($message); ?>
      </div>

      <div style="margin-bottom: 24px;">
        <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Tabel Database Terdaftar (<?= count($tablesCreated); ?>):</h4>
        <div>
          <?php foreach ($tablesCreated as $tbl): ?>
            <span class="table-badge"><?= htmlspecialchars($tbl); ?></span>
          <?php endforeach; ?>
        </div>
      </div>

      <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px; margin-bottom: 24px; font-size: 0.875rem; color: #1e40af;">
        <strong>Akun Bawaan (Seeder) Siap Pakai:</strong><br>
        • <strong>Admin:</strong> admin@kampus.ac.id | Password: <code>Password123!</code><br>
        • <strong>Operator:</strong> operator@kampus.ac.id | Password: <code>Password123!</code><br>
        • <strong>Mahasiswa:</strong> budi@kampus.ac.id (NIM: 13521099) | Password: <code>Password123!</code>
      </div>

      <div style="display: flex; gap: 12px;">
        <a href="index.php" class="btn btn-primary btn-block">Kembali ke Landing Page</a>
      </div>

    <?php else: ?>
      <?php if ($status === 'error'): ?>
        <div class="alert-box alert-error">
          <strong>✕ Gagal:</strong> <?= htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <p style="font-size: 0.925rem; color: #475569; margin-bottom: 20px; line-height: 1.6;">
        Formulir ini akan membuat database <code>kampus_rental</code>, seluruh tabel relasional (users, categories, equipment, bookings, invoices, audit log), dan mengisi seeder data awal secara otomatis.
      </p>

      <form method="POST">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Host MySQL</label>
            <input type="text" name="host" class="form-input" value="<?= htmlspecialchars($config['host']); ?>" required>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Port</label>
            <input type="text" name="port" class="form-input" value="<?= htmlspecialchars($config['port']); ?>" required>
          </div>
        </div>

        <div style="margin-bottom: 14px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Nama Database</label>
          <input type="text" name="dbname" class="form-input" value="<?= htmlspecialchars($config['dbname']); ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Username MySQL</label>
            <input type="text" name="username" class="form-input" value="<?= htmlspecialchars($config['username']); ?>" required>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Password MySQL</label>
            <input type="password" name="password" class="form-input" value="<?= htmlspecialchars($config['password']); ?>" placeholder="Password root MySQL Anda">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
          Jalankan Setup & Migrasi Database
        </button>
      </form>
    <?php endif; ?>
  </div>

</body>
</html>
