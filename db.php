<?php
$host = 'localhost';
$db = 'library_management';
$user = 'root';
$pass = '';

// MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);
$checkBookQuery = "SELECT available_copies FROM books WHERE id = ?";

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// PDO connection
try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>