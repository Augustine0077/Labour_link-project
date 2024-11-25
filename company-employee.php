<?php
session_start();
include 'connection.php'; // Assuming db_connection.php has the database connection code
$email = $_SESSION['email']; // Use email from the session

// Fetch job details from the job_posting table for company employee
$job_query = "SELECT job_title, description, openings, wage, posted_by FROM job_postings WHERE job_title = 'company employee'";
$result = mysqli_query($con, $job_query);

// Check if the job query returned any results
if (!$result || mysqli_num_rows($result) == 0) {
    echo "No job details found or error fetching job details: " . mysqli_error($con);
    exit;
}

$job = mysqli_fetch_assoc($result);

// Fetch recruiter details from rec_reg table using rec_id (posted_by)
$recruiter_query = "SELECT name FROM rec_reg WHERE rec_id = '".$job['posted_by']."'";
$recruiter_result = mysqli_query($con, $recruiter_query);

// Check if the recruiter query returned any results
if (!$recruiter_result || mysqli_num_rows($recruiter_result) == 0) {
    $recruiter = ['name' => 'Unknown Recruiter'];
} else {
    $recruiter = mysqli_fetch_assoc($recruiter_result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Employee Job Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .job-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .job-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }

        .job-details {
            padding: 15px;
        }

        .job-details p {
            font-size: 1.1em;
            color: #333;
        }

        .apply-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }

        .apply-btn:hover {
            background-color: #218838;
        }

        /* Back Button Style */
        .back-btn {
            display: inline-block;
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            margin-left: 10px;
            cursor: pointer;
        }

        .back-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="job-container">
    <div class="job-header">
        <h2><?php echo $job['job_title']; ?></h2>
    </div>

    <div class="job-details">
        <p><strong>Description:</strong> <?php echo $job['description']; ?></p>
        <p><strong>Openings:</strong> <?php echo $job['openings']; ?></p>
        <p><strong>Wage:</strong> ₹<?php echo $job['wage']; ?></p>
        <p><strong>Posted By:</strong> <?php echo $recruiter['name']; ?></p>

        <!-- Apply Button -->
        <form method="POST" action="job_listings.php">
            <!-- Ensure job_id is properly fetched, adjust the query if it's not being returned -->
            <input type="hidden" name="job_id" value="<?php echo isset($job['job_id']) ? $job['job_id'] : ''; ?>">
            <button type="submit" class="apply-btn">Apply for this job</button>
        </form>

        <!-- Back Button -->
        <a href="seeker_home.html" class="back-btn">Back</a>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($con);
?>
