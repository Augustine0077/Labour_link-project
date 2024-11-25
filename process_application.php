<?php
include("connection.php"); // Ensure this includes your database connection
session_start();

// Check if the seeker email and action are provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seeker_email'], $_POST['action'])) {
    $seeker_email = $_POST['seeker_email'];
    $recruiter_email = $_SESSION['email']; // Get the recruiter's email from the session

    // Get the job title from job_applications
    $job_title_sql = "SELECT job_title FROM job_applications WHERE seeker_email = ? AND recruiter_email = ?";
    $job_title_stmt = $con->prepare($job_title_sql);
    
    if ($job_title_stmt === false) {
        die("Error preparing job title statement: " . $con->error);
    }

    $job_title_stmt->bind_param("ss", $seeker_email, $recruiter_email);
    $job_title_stmt->execute();
    $job_title_stmt->bind_result($job_title);
    $job_title_stmt->fetch();
    $job_title_stmt->close();

    // Check if the action is reject or accept
    if ($_POST['action'] === 'reject') {
        // SQL query to delete the application (handle rejection logic)
        $sql = "DELETE FROM job_applications WHERE seeker_email = ? AND recruiter_email = ?";
        $stmt = $con->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $con->error);
        }

        $stmt->bind_param("ss", $seeker_email, $recruiter_email);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }

        // Check if the rejection was successful
        if ($stmt->affected_rows > 0) {
            // Prepare the notification message
            $notification_message = "Your application for the position '$job_title' has been rejected.";
            
            // Insert notification into the notifications table
            $notification_sql = "INSERT INTO notifications (seeker_email, message, recruiter_email, job_title) VALUES (?, ?, ?, ?)";
            $notification_stmt = $con->prepare($notification_sql);
            if ($notification_stmt === false) {
                die("Error preparing notification statement: " . $con->error);
            }
            $notification_stmt->bind_param("ssss", $seeker_email, $notification_message, $recruiter_email, $job_title);
            if (!$notification_stmt->execute()) {
                die("Error executing notification statement: " . $notification_stmt->error);
            }
        } else {
            echo "Error rejecting application. Please try again.";
        }

        // Redirect to recruiter home page after rejection
        header("Location: rec_home.html?status=rejected");
        exit();

    } elseif ($_POST['action'] === 'accept') {
        // SQL query to delete the application (same logic as rejection)
        $sql = "DELETE FROM job_applications WHERE seeker_email = ? AND recruiter_email = ?";
        $stmt = $con->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $con->error);
        }

        $stmt->bind_param("ss", $seeker_email, $recruiter_email);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }

        // Check if the acceptance was successful
        if ($stmt->affected_rows > 0) {
            // Prepare the notification message for acceptance
            $notification_message = "Your application for the position '$job_title' has been accepted.";
            
            // Insert notification into the notifications table
            $notification_sql = "INSERT INTO notifications (seeker_email, message, recruiter_email, job_title) VALUES (?, ?, ?, ?)";
            $notification_stmt = $con->prepare($notification_sql);
            if ($notification_stmt === false) {
                die("Error preparing notification statement: " . $con->error);
            }
            $notification_stmt->bind_param("ssss", $seeker_email, $notification_message, $recruiter_email, $job_title);
            if (!$notification_stmt->execute()) {
                die("Error executing notification statement: " . $notification_stmt->error);
            }

            // Now retrieve the job ID from the job_postings table
            $job_id_sql = "SELECT job_id FROM job_postings WHERE job_title = ?";
            $job_id_stmt = $con->prepare($job_id_sql);
            if ($job_id_stmt === false) {
                die("Error preparing job ID statement: " . $con->error);
            }

            $job_id_stmt->bind_param("s", $job_title);
            $job_id_stmt->execute();
            $job_id_stmt->bind_result($job_id);
            $job_id_stmt->fetch();
            $job_id_stmt->close();

            // Check if job ID is found
            if (!$job_id) {
                echo "No job ID found for the job title: '$job_title'.";
                exit();
            } else {
                // Decrease the number of openings for the corresponding job
                $update_openings_sql = "UPDATE job_postings SET openings = openings - 1 WHERE job_id = ? AND openings > 0";
                $update_openings_stmt = $con->prepare($update_openings_sql);
                if ($update_openings_stmt === false) {
                    die("Error preparing update openings statement: " . $con->error);
                }
                $update_openings_stmt->bind_param("i", $job_id);
                if (!$update_openings_stmt->execute()) {
                    die("Error executing update openings statement: " . $update_openings_stmt->error);
                }

                // Check affected rows
                if ($update_openings_stmt->affected_rows > 0) {
                    echo "Successfully decreased openings for job ID: $job_id.";
                } else {
                    echo "No openings decreased. Possible reason: No openings left or job ID not found.";
                }
            }

            // Redirect to contact_info.php with the seeker's email
            header("Location: seeker_contact.php?email=" . urlencode($seeker_email));
            exit();
        } else {
            echo "Error accepting application. Please try again.";
        }
    }
}

// Close the connection
$con->close();
?>
