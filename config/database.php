<?php
/**
 * Database Connection & Configuration Manager
 * Equipment Rental Platform (PRD v1.1)
 */

class Database {
    private static ?PDO $instance = null;

    // Default configuration (dapat disesuaikan atau dimuat dari file env/config lokal)
    private static array $config = [
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'dbname'   => 'kampus_rental',
        'username' => 'root',
        'password' => '', // Sesuaikan dengan password MySQL Anda
        'charset'  => 'utf8mb4'
    ];

    /**
     * Set konfigurasi database kustom
     */
    public static function setConfig(array $customConfig): void {
        self::$config = array_merge(self::$config, $customConfig);
        self::$instance = null; // Reset connection instance
    }

    /**
     * Ambil instance koneksi PDO Singleton
     */
    public static function getConnection(): ?PDO {
        if (self::$instance === null) {
            // Cek apakah ada file db_config.php lokal
            $localConfigFile = __DIR__ . '/db_config.php';
            if (file_exists($localConfigFile)) {
                $localConfig = require $localConfigFile;
                if (is_array($localConfig)) {
                    self::$config = array_merge(self::$config, $localConfig);
                }
            }

            try {
                $dsn = sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                    self::$config['host'],
                    self::$config['port'],
                    self::$config['dbname'],
                    self::$config['charset']
                );

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ];

                self::$instance = new PDO($dsn, self::$config['username'], self::$config['password'], $options);
            } catch (PDOException $e) {
                // Return null if connection fails, caller can check with Database::isConnected()
                self::$instance = null;
                error_log("Database Connection Error: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Cek apakah koneksi database aktif
     */
    public static function isConnected(): bool {
        return self::getConnection() !== null;
    }

    /**
     * Mendapatkan info konfigurasi saat ini (tanpa mengekspos password secara mentah)
     */
    public static function getConfigInfo(): array {
        $info = self::$config;
        $info['password'] = empty($info['password']) ? '(kosong)' : '******';
        return $info;
    }
}
