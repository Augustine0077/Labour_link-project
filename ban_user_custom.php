<?php
include('connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $role = $_POST['role'];
    $months = intval($_POST['months']);

    if ($role === 'seeker') {
        $table = 'jobseeker_reg';
    } elseif ($role === 'recruiter') {
        $table = 'rec_reg';
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role specified.']);
        exit();
    }

    // Calculate the ban end date
    $current_date = new DateTime();
    $current_date->modify("+{$months} months");
    $ban_end_date = $current_date->format('Y-m-d H:i:s');

    $sql = "UPDATE $table SET ban_start_date = NOW(), ban_end_date = ? WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $ban_end_date, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'User has been banned successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to ban the user.']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
