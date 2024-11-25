<?php
include('connection.php');
session_start();

if (isset($_POST['email']) && isset($_POST['role'])) {
    $email = $_POST['email'];
    $role = $_POST['role'];
    $message = $_POST['message'];

    // Determine the table and fields based on the selected role
    if ($role === "seeker") {
        $table = "job_seekers";
        $emailField = "email";
    } elseif ($role === "recruiter") {
        $table = "rec_reg";
        $emailField = "email";
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role']);
        exit;
    }

    $banStartDate = date('Y-m-d H:i:s');
    $banEndDate = date('Y-m-d H:i:s', strtotime($banStartDate . ' +10 days'));

    // Update database to set ban start and end dates
    $sql = "UPDATE $table SET ban_start_date = ?, ban_end_date = ?, is_permanently_banned = FALSE WHERE $emailField = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $banStartDate, $banEndDate, $email);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Message sent and user banned for 10 days.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update ban information.']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Missing parameters.']);
}
?>
