<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Delete job postings with zero openings
$delete_query = "DELETE FROM job_postings WHERE openings = 0";
mysqli_query($con, $delete_query); // Execute the deletion query

// Fetch job postings from the job_postings table where the date_time is greater than or equal to the current time
$job_query = "SELECT job_id, job_title, description, location, wage, posted_by 
              FROM job_postings 
              WHERE date_time >= NOW()"; // Only fetch jobs that are posted at or after the current time
$result = mysqli_query($con, $job_query);

if (!$result) {
    echo "Error fetching job listings: " . mysqli_error($con);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('bg.jpeg') no-repeat center center fixed;
            background-size: cover; /* Ensure the background covers the whole page */
            color: #333; /* General text color */
        }

        .job-listing-container {
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

        .job {
            margin-bottom: 30px;
        }

        .job h3 {
            margin: 0;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
            padding-left: 10px;
            border-radius: 5px;
        }

        .job-details {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
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
            background-color: #FFC0CB;
        }

        .job p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="job-listing-container">
    <h1>Available Job Listings</h1>

    <?php while ($job = mysqli_fetch_assoc($result)) { ?>
        <div class="job">
            <h3><?php echo $job['job_title']; ?></h3>
            <div class="job-details">
                <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
                <p><strong>Description:</strong> <?php echo $job['description']; ?></p>
                <p><strong>Wage:</strong> ₹<?php echo $job['wage']; ?></p>

                <!-- Apply Button -->
                <form method="POST" action="job_details.php">
                    <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">
                    <button type="submit" class="apply-btn">View Job</button>
                </form>

            </div>
        </div>
    <?php } ?>

    <!-- Back to Home Button -->
    <a href="seeker_home.html" class="back-btn">Back to Home</a>
</div>

<?php mysqli_close($con); ?>
</body>
</html>
