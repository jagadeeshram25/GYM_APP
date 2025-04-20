<?php
$host = "localhost";
$user = 'root';
$pass = '';
$dbname = "gym_aaaapp";
$con = mysqli_connect($host, $user, $pass, $dbname);

if ($con) {
    echo "Connection Success";
} else {
    die("Connection Failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $name = trim($_POST['name']);
    $membershipPlan = trim($_POST['membershipPlan']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO reviews (name, membership_plan, rating, review) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("ssis", $name, $membershipPlan, $rating, $review);

    // Execute and check
    if ($stmt->execute()) {
        echo "<script>window.location.href='reviews.html?status=success';</script>";
        exit();
    } else {
        echo "<script>alert('Error while submitting your review. Please try again later.');</script>";
    }

    $stmt->close();
}

$con->close();
?>