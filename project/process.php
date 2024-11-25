<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $role = $_POST["role"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Send email to the user
    $headers = "From: admin@example.com";

    include('connection.php'); // Including database connection at the beginning

    if (mail($email, $subject, $message, $headers)) {
        // Update database to ban the user if message sent successfully
        if ($role == 'seeker') {
            // Updating job_seekers table for job seekers
            $sql = "UPDATE job_seekers SET ban_start_date = NOW(), ban_end_date = DATE_ADD(NOW(), INTERVAL 10 DAY), permanently_banned = 0 WHERE email = '$email'";
        } else if ($role == 'recruiter') {
            // Updating rec_reg table for recruiters
            $sql = "UPDATE rec_reg SET ban_start_date = NOW(), ban_end_date = DATE_ADD(NOW(), INTERVAL 10 DAY), permanently_banned = 0 WHERE email = '$email'";
        }

        // Execute the ban update query
        if (mysqli_query($con, $sql)) {
            // Record action in logs
            $sql_log = "INSERT INTO logs (user_email, action) VALUES ('$email', 'Banned and notified')";
            mysqli_query($con, $sql_log);

            // Redirect to success page after updating the database
            header('Location: message_success.html');
            exit(); // Exit to ensure the rest of the script doesn't execute
        } else {
            // Redirect to failure page if the ban update fails
            header('Location: message_failure.html');
            exit();
        }
    } else {
        // Redirect to failure page if the email fails to send
        header('Location: message_failure.html');
        exit();
    }

    mysqli_close($con); // Closing the database connection
} else {
    echo 'Invalid request method.';
}
?>
