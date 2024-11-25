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

    // Fetch job details based on job_id
    $job_query = "SELECT job_title, description, location, wage, skills_required, openings, hours, posted_by FROM job_postings WHERE job_id = ?";
    $stmt = $con->prepare($job_query);
    $stmt->bind_param("i", $job_id);  // Bind job_id to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // If job is found
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        echo "Job not found.";
        exit();
    }

} else {
    echo "No job selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .job-details-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .job-details {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .back-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .job-details p {
            margin: 10px 0;
        }

        .apply-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .apply-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="job-details-container">
    <h1>Job Details</h1>

    <div class="job-details">
        <p><strong>Job Title:</strong> <?php echo $job['job_title']; ?></p>
        <p><strong>Description:</strong> <?php echo $job['description']; ?></p>
        <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
        <p><strong>Wage:</strong> ₹<?php echo $job['wage']; ?></p>
        <p><strong>No of Openings:</strong> ₹<?php echo $job['openings']; ?></p>

        <p><strong>Skills Required:</strong> <?php echo $job['skills_required']; ?></p>
        <p><strong>Hours Required:</strong> <?php echo $job['hours']; ?></p>
        <p><strong>Posted By:</strong> <?php echo $job['posted_by']; ?></p>

        <!-- Apply Button (Optional, you can remove this if applying is handled in a different flow) -->
        <form method="POST" action="apply.php">
            <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
            <button type="submit" class="apply-btn">Apply Now</button>
        </form>
    </div>

    <!-- Back to Job Listings -->
    <a href="job_listings.php" class="back-btn">Back to Job Listings</a>
</div>

<?php mysqli_close($con); ?>
</body>
</html>
