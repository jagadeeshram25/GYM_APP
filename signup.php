<?php
// Database connection details
$host = "localhost";
$user = 'root';
$pass = '';
$dbname = "gym_aaaapp"; // Change to your database name
$con = mysqli_connect($host, $user, $pass, $dbname);

// Check connection

if($con){
    echo "Connection Success";
} else{
    echo "Connection Failed";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $age = trim($_POST['age']);
    $fitnessGoal = trim($_POST['fitnessGoal']);
    $membershipPlan = trim($_POST['membershipPlan']);

    // Validate password
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO users (name, email, password, age, fitnessGoal, membershipPlan) VALUES (?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $con->error);
}

$stmt->bind_param("ssssss", $name, $email, $hashedPassword, $age, $fitnessGoal, $membershipPlan);

    // Execute and check
    if ($stmt->execute()) {
        // Redirect on success
        echo "<script>alert('Registration successful! Please log in.'); window.location.href='login.html';</script>";
        exit();
    } else {
        echo "<script>alert('Error while submitting. Please try again later.');</script>";
    }

    // Close statement and connection
    $stmt->close();
}

$con->close();
?>