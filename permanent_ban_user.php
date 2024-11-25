<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Determine the table based on the role
    if ($role === 'seeker') {
        $table = 'job_seekers'; // Corrected to 'job_seekers' for job seekers
    } elseif ($role === 'recruiter') {
        $table = 'rec_reg'; // Table for recruiters
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role specified.']);
        exit;
    }

    // Update the user's record to set permanent ban
    $sql = "UPDATE $table SET permanently_banned = 1, ban_start_date = NULL, ban_end_date = NULL WHERE email = ?";

    $stmt = $con->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $con->error]);
        exit;
    }

    // Bind the parameter and execute the statement
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User permanently banned successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to ban user.']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
