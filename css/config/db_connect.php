<?php
$host = "localhost";
$dbname = "gym_aaaapp";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8mb4");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?> 