<?php
// Database connection for KiariHive
$host = "localhost";      // usually localhost
$db   = "kiarihive";      // your database name
$user = "root";           // your MySQL username
$pass = "";               // your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
