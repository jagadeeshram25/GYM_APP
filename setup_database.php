<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "gym_aaaapp";

// Create connection without selecting database
$con = mysqli_connect($host, $user, $pass);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($con, $sql)) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . mysqli_error($con) . "<br>";
}

// Select the database
mysqli_select_db($con, $dbname);

// Create reviews table
$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    membership_plan VARCHAR(50) NOT NULL,
    rating INT NOT NULL,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($con, $sql)) {
    echo "Table created successfully or already exists<br>";
} else {
    echo "Error creating table: " . mysqli_error($con) . "<br>";
}

mysqli_close($con);
echo "Setup completed. Please check if there are any errors above.";
?> 