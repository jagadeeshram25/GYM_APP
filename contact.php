<?php
$host = "localhost";
$user = 'root';
$pass = '';
$dbname = "gym_aaaapp";
$con = mysqli_connect($host,$user,$pass,$dbname);

if($con){
    echo "Connection Success";
} else{
    echo "Connection Failed";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    // Execute and check
    if ($stmt->execute()) {
        // Redirect to contact.html with success flag for popup
        echo "<script>window.location.href='contact.html?status=success';</script>";
        exit();
    } else {
        echo "<script>alert('Error while submitting. Please try again later.');</script>";
    }

    $stmt->close();
}

$con->close();
?>