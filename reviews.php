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

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $name = trim($_POST['name']);
    $plan = trim($_POST['plan']);
    $rating = trim($_POST['rating']);
    $review_text = trim($_POST['review_text']);

    // Validate inputs
    if (empty($name) || empty($plan) || empty($rating) || empty($review_text)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit();
    }

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO reviews (name, plan, rating, text) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $con->error]);
        exit();
    }

    $stmt->bind_param("ssis", $name, $plan, $rating, $review_text);

    // Execute and check
    if ($stmt->execute()) {
        // Get the inserted review ID
        $new_id = $stmt->insert_id;
        
        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Review submitted successfully',
            'review_id' => $new_id
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error while submitting review: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    // Handle GET request for fetching reviews
    $query = "SELECT * FROM reviews ORDER BY date DESC";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $reviews = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
        
        echo json_encode([
            'status' => 'success',
            'data' => [
                'reviews' => $reviews
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to fetch reviews: ' . mysqli_error($con)
        ]);
    }
}

$con->close();
?>