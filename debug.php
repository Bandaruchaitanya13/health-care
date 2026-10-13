<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/includes/config.php';

echo "<h3>Environment Config:</h3>";
echo "DB_HOST: " . htmlspecialchars(DB_HOST) . "<br>";
echo "DB_PORT: " . htmlspecialchars((string)DB_PORT) . "<br>";
echo "DB_NAME: " . htmlspecialchars(DB_NAME) . "<br>";
echo "DB_USER: " . htmlspecialchars(DB_USER) . "<br>";
echo "DB_PASS: " . (empty(DB_PASS) ? '[EMPTY]' : '[SET]') . "<br>";

echo "<h3>Testing PDO Connection:</h3>";
try {
    require_once __DIR__ . '/includes/db.php';
    $db = Database::getInstance()->getConnection();
    echo "<p style='color:green;'>SUCCESS: Connected to database!</p>";
    $tables = Database::fetchAll("SHOW TABLES");
    echo "Tables found: " . count($tables) . "<br>";
    foreach ($tables as $t) {
        echo "- " . htmlspecialchars(implode(', ', $t)) . "<br>";
    }
} catch (Throwable $e) {
    echo "<p style='color:red;'>ERROR: " . htmlspecialchars($e->getMessage()) . "</p>";
}
