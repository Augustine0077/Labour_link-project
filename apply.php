<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check if job_id is set
if (isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];

    // Fetch the job title and recruiter email based on job_id
    $job_query = "SELECT job_title, posted_by FROM job_postings WHERE job_id = ?";
    $stmt = $con->prepare($job_query);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If job is found
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
        $job_title = $job['job_title'];
        $recruiter_email = $job['posted_by']; // Assuming 'posted_by' stores the recruiter's email
    } else {
        echo "Job not found.";
        exit();
    }

    // Get the logged-in user's email (seeker's email)
    $seeker_email = $_SESSION['email'];

    // Check if the seeker has already applied for this job
    $check_query = "SELECT * FROM job_applications WHERE seeker_email = ? AND job_title = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("ss", $seeker_email, $job_title);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // If application exists, show an alert
        echo "<script>
                alert('You have already applied for this job.');
                window.location.href = 'seeker_home.html';
              </script>";
    } else {
        // Insert the application into the job_applications table
        $application_query = "INSERT INTO job_applications (seeker_email, job_title, recruiter_email) VALUES (?, ?, ?)";
        $stmt = $con->prepare($application_query);
        $stmt->bind_param("sss", $seeker_email, $job_title, $recruiter_email);

        // Execute the query
        if ($stmt->execute()) {
            // Display success message and redirect
            echo "<script>
                    alert('Application submitted successfully.');
                    window.location.href = 'seeker_home.html';
                  </script>";
        } else {
            echo "Failed to submit application.";
        }

        $stmt->close();
    }

    $check_stmt->close();
    mysqli_close($con);
} else {
    echo "No job selected.";
    exit();
}
?>
