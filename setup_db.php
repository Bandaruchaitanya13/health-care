<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

echo "<h2>CarePulse AI - One-Click Cloud Database Setup</h2>";

try {
    $pdo = Database::getInstance()->getConnection();
    echo "<p style='color:green;'>✓ Successfully connected to TiDB Cloud.</p>";

    // Helper to run SQL files cleanly
    function executeSqlFile(PDO $pdo, string $filePath): void {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: " . $filePath);
        }
        $content = file_get_contents($filePath);
        // Remove comments and database creation
        $lines = explode("\n", $content);
        $cleanLines = [];
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                continue;
            }
            if (preg_match('/^CREATE\s+DATABASE/i', $trimmed) || preg_match('/^USE\s+/i', $trimmed)) {
                continue;
            }
            $cleanLines[] = $line;
        }

        $sql = implode("\n", $cleanLines);
        // Split by semicolon that is followed by newline or end of string
        $statements = preg_split('/;\s*(\r?\n|$)/', $sql);

        foreach ($statements as $stmt) {
            $stmt = trim($stmt);
            if (!empty($stmt)) {
                $pdo->exec($stmt);
            }
        }
    }

    echo "<p>Running schema.sql...</p>";
    executeSqlFile($pdo, __DIR__ . '/database/schema.sql');
    echo "<p style='color:green;'>✓ Tables created successfully with exact columns!</p>";

    echo "<p>Running seed.sql...</p>";
    executeSqlFile($pdo, __DIR__ . '/database/seed.sql');
    echo "<p style='color:green;'>✓ Seed data (doctors, admin, patient, departments) populated successfully!</p>";

    echo "<h2 style='color:green;'>🎉 TiDB Database is now 100% synchronized!</h2>";
    echo "<p><a href='index.php'>Go to Homepage</a></p>";
} catch (Throwable $e) {
    echo "<h2 style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
}
