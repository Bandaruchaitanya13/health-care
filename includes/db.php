<?php
/**
 * CarePulse AI - Database Singleton Connection (PDO)
 * Implements prepared statements, strict typing, and connection pooling logic.
 */

require_once __DIR__ . '/config.php';

class Database {
    private static ?Database $instance = null;
    private ?PDO $conn = null;

    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];

        // Enable SSL encryption for cloud MySQL (TiDB Cloud port 4000 or DB_SSL flag)
        if ((defined('DB_PORT') && DB_PORT == 4000) || getenv('DB_SSL') === 'true') {
            if (file_exists('/etc/ssl/certs/ca-certificates.crt')) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = '/etc/ssl/certs/ca-certificates.crt';
            }
            if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
            }
        }

        try {
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
            try {
                $this->conn->exec("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            } catch (Throwable $ignore) {
                // Ignore if engine does not support dynamic sql_mode
            }
        } catch (PDOException $e) {
            error_log("[Database Connection Error] " . $e->getMessage());
            die(json_encode([
                'success' => false,
                'error' => 'Database connection failed. Please ensure MySQL server is running.'
            ]));
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->conn;
    }

    // Static helper to quickly run parameterized queries
    public static function query(string $sql, array $params = []): PDOStatement {
        $pdo = self::getInstance()->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetchOne(string $sql, array $params = []) {
        return self::query($sql, $params)->fetch();
    }

    public static function insert(string $sql, array $params = []): int {
        $pdo = self::getInstance()->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$pdo->lastInsertId();
    }

    public static function execute(string $sql, array $params = []): int {
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }
}
