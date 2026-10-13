<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>CarePulse Diagnostic</h2>";

try {
    echo "1. Loading config & db...<br>";
    require_once __DIR__ . '/includes/config.php';
    require_once __DIR__ . '/includes/db.php';
    require_once __DIR__ . '/includes/auth.php';

    echo "2. Querying departments...<br>";
    $departments = Database::fetchAll("SELECT * FROM departments ORDER BY id ASC LIMIT 8");
    echo "Departments count: " . count($departments) . "<br>";

    echo "3. Querying featured doctors...<br>";
    $featuredDoctors = Database::fetchAll("
        SELECT d.*, u.name, u.avatar, dep.name as department_name, dep.icon as department_icon
        FROM doctor_profiles d
        JOIN users u ON d.user_id = u.id
        JOIN departments dep ON d.department_id = dep.id
        WHERE u.status = 'active'
        ORDER BY d.rating DESC LIMIT 4
    ");
    echo "Featured doctors count: " . count($featuredDoctors) . "<br>";

    echo "4. Loading header...<br>";
    require_once __DIR__ . '/includes/security.php';
    $currentUser = Auth::currentUser();
    echo "Current user check passed.<br>";

    echo "<h3 style='color:green;'>All core checks passed!</h3>";
} catch (Throwable $e) {
    echo "<h3 style='color:red;'>ERROR: " . htmlspecialchars($e->getMessage()) . "</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
