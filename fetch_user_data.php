<?php
session_start();
include('connection.php');

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Query to get the user's name and email
    $sql = "SELECT first_name, email FROM job_seekers WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['name' => $user['first_name'], 'email' => $user['email']]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['error' => 'User not logged in']);
}
?>
