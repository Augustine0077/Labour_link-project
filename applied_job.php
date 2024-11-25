<?php
session_start();
include 'connection.php';

// Check if the seeker is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check if job ID is submitted
if (isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $seeker_email = $_SESSION['email'];

    // Fetch job title and recruiter's email using the job_id
    $query = "
        SELECT jp.job_title, rr.email AS recruiter_email
        FROM job_postings jp
        JOIN rec_reg rr ON jp.posted_by = rr.email
        WHERE jp.job_id = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
        $job_title = $job['job_title'];
        $recruiter_email = $job['recruiter_email'];

        // Check if the seeker has already applied for this job
        $check_application_query = "
            SELECT * FROM job_applications
            WHERE seeker_email = ? AND job_title = ?
        ";
        $check_stmt = $con->prepare($check_application_query);
        $check_stmt->bind_param("ss", $seeker_email, $job_title);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<p>Sorry, you have already applied for this job.</p>";
        } else {
            // Insert application details into the job_applications table
            $insert_query = "
                INSERT INTO job_applications (seeker_email, job_title, recruiter_email)
                VALUES (?, ?, ?)
            ";
            $insert_stmt = $con->prepare($insert_query);
            $insert_stmt->bind_param("sss", $seeker_email, $job_title, $recruiter_email);

            if ($insert_stmt->execute()) {
                echo "<p>Application submitted successfully!</p>";
            } else {
                echo "<p>Error submitting application: " . $insert_stmt->error . "</p>";
            }

            $insert_stmt->close();
        }

        $check_stmt->close();
    } else {
        echo "<p>Job not found.</p>";
    }

    $stmt->close();
} else {
    echo "<p>No job selected.</p>";
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .back-btn {
            display: inline-block;
            background-color: #28a745; /* Green color */
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<body>

    <a href="job_listings.php" class="back-btn">Back to Job Listings</a>
</body>
</html>
