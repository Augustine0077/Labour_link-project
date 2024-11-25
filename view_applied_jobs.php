<?php
session_start();
include 'connection.php';

// Check if the seeker is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$seeker_email = $_SESSION['email'];

// Fetch applied jobs for the logged-in seeker
$query = "
    SELECT ja.job_title, ja.seeker_email, js.first_name AS seeker_name
    FROM job_applications ja
    JOIN job_seekers js ON ja.seeker_email = js.email
    WHERE ja.seeker_email = ?
";

$stmt = $con->prepare($query);
$stmt->bind_param("s", $seeker_email);  // Bind the logged-in seeker's email
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: light green;
            padding: 20px;
        }

        .job-listing-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: light green;
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

        .back-btn {
            display: inline-block;
            background-color: green;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .back-btn:hover {
            background-color: green;
        }
    </style>
</head>
<body>

<div class="job-listing-container">
    <h1>Applied Jobs for <?php echo htmlspecialchars($seeker_email); ?></h1>

    <?php if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) { ?>
            <div class="job">
                <h3>Job Title: <?php echo htmlspecialchars($row['job_title']); ?></h3>
                <p>Seeker Name: <?php echo htmlspecialchars($row['seeker_name']); ?></p>
                <p>Seeker Email: <?php echo htmlspecialchars($row['seeker_email']); ?></p>
            </div>
        <?php }
    } else {
        echo "<p>No jobs applied yet.</p>";
    }
    ?>

    <!-- Back to Home Button -->
    <a href="seeker_home.html" class="back-btn">Back to Home</a>
</div>

<?php
$stmt->close();
mysqli_close($con);
?>
</body>
</html>
