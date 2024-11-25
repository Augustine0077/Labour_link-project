<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $role = $_POST['role'];
    $message = $_POST['message'];

    // Determine the table based on the role
    if ($role === 'seeker') {
        $table = 'jobseeker_reg';
    } elseif ($role === 'recruiter') {
        $table = 'rec_reg';
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role specified.']);
        exit;
    }

    // Update the user's record to set ban start and end dates
    $ban_start_date = date('Y-m-d H:i:s');
    $ban_end_date = date('Y-m-d H:i:s', strtotime('+10 days'));

    $sql = "UPDATE $table SET ban_start_date = ?, ban_end_date = ? WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $ban_start_date, $ban_end_date, $email);
    
    if ($stmt->execute()) {
        // Send the message
        $to = $email;
        $subject = 'Important Notice';
        $headers = 'From: no-reply@example.com' . "\r\n" .
                   'Reply-To: no-reply@example.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $message, $headers);

        echo json_encode(['success' => true, 'message' => 'Message sent and user banned for 10 days.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to ban user or send message.']);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
