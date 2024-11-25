<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'labourlink');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "Please log in to view your applied jobs.";
    exit;
}

$loggedInEmail = $_SESSION['email'];

// Fetch applied job details for the logged-in user
$sql = "SELECT seeker_email, job_title, recruiter_email, application_date 
        FROM job_applications 
        WHERE seeker_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $loggedInEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applied Jobs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6ffe6;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2e8b57; /* Heading in green color */
            margin-bottom: 40px;
        }
        .back-arrow {
            font-size: 24px;
            text-decoration: none;
            color: #2e8b57;
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .back-arrow:hover {
            color: #228b22;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 320px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .card h3 {
            margin-top: 0;
            color: #2e8b57; /* Job Title in green color */
            font-size: 1.5em;
            font-weight: bold;
            border-bottom: 2px solid #2e8b57;
            padding-bottom: 10px;
        }
        .card p {
            margin: 8px 0;
            color: #666;
            font-size: 0.9em;
        }
        .card span {
            font-weight: bold;
            color: #444;
        }
        .no-jobs {
            text-align: center;
            color: #fff;
            font-size: 22px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <!-- Back Arrow Link -->
    <a href="seeker_home.html" class="back-arrow">&larr; Back</a>

    <h1>Applied Jobs</h1>
    
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            // Fetch each row as an associative array
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row['job_title']); ?></h3>
                    <p><span>Recruiter:</span> <?php echo htmlspecialchars($row['recruiter_email']); ?></p>
                    <p><span>Applied On:</span> <?php echo htmlspecialchars($row['application_date']); ?></p>
                </div>
                <?php
            }
        } else {
            echo "<div class='no-jobs'>No jobs applied yet</div>";
        }
        ?>
    </div>

</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
