
<?php
$host = '127.0.0.1';
$port = 3306;
$db   = 'carepulse_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "SUCCESS: PHP connected to carepulse_db!";
$conn->close();
?>
