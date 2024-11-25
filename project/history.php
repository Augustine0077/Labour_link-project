<?php
session_start();

$host = "localhost";
$user = "root";
$password = '';
$db_name = "labourlink";
$conn = new mysqli($host, $user, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo "Please log in to view your job postings.";
    exit;
}

$posted_by = $_SESSION['email'];

// Prepare and execute the SQL query to fetch job postings for the logged-in user
$sql = "SELECT job_id, job_title, description, location, skills_required, openings, date_time, hours, wage FROM job_postings WHERE posted_by = ? ORDER BY date_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $posted_by);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Postings History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6ffe6;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2e8b57;
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
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .expired {
            background-color: #ffcccc;
        }
        .card h3 {
            margin-top: 0;
            color: #2e8b57;
            font-size: 1.5em;
            font-weight: bold;
            border-bottom: 2px solid #2e8b57;
            padding-bottom: 10px;
        }
        .card p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9em;
        }
        .card span {
            font-weight: bold;
            color: #444;
        }
        .card .wage {
            color: #228b22;
            font-weight: bold;
        }
        .edit-btn {
            display: inline-block;
            background-color: #2e8b57;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            text-align: center;
        }
        .edit-btn:hover {
            background-color: #228b22;
        }
        .common-edit-btn {
            display: block;
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin: 20px auto;
            width: 200px;
            text-decoration: none;
        }
        .common-edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Back Arrow Link -->
    <a href="rec_home.html" class="back-arrow">&larr; Back</a>

    <h1>Your Job Postings History</h1>
    
    <form method="POST" action="edit_job.php"> <!-- Common form for editing -->
        <div class="container">
            <?php
            $hasActiveJobs = false; // Track if there are any active jobs

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Get the current date and job posting date
                    $currentDateTime = new DateTime();
                    $jobDeadline = new DateTime($row["date_time"]);

                    // Check if the job posting is expired
                    $cardClass = ($currentDateTime > $jobDeadline) ? 'expired' : '';

                    // Output the job posting in a card format
                    echo '<div class="card ' . $cardClass . '">';
                    echo '<h3>' . htmlspecialchars($row["job_title"]) . '</h3>';
                    echo '<p><span>Description:</span> ' . htmlspecialchars($row["description"]) . '</p>';
                    echo '<p><span>Location:</span> ' . htmlspecialchars($row["location"]) . '</p>';
                    echo '<p><span>Skills Required:</span> ' . htmlspecialchars($row["skills_required"]) . '</p>';
                    echo '<p><span>Openings:</span> ' . htmlspecialchars($row["openings"]) . '</p>';
                    echo '<p><span>Date & Time:</span> ' . htmlspecialchars($row["date_time"]) . '</p>';
                    echo '<p><span>Hours:</span> ' . htmlspecialchars($row["hours"]) . '</p>';
                    echo '<p><span class="wage">Wage:</span> ' . htmlspecialchars($row["wage"]) . '</p>';

                    // Only add the hidden input for job_id if the job is not expired
                    if ($currentDateTime <= $jobDeadline) {
                        echo '<input type="hidden" name="job_ids[]" value="' . $row["job_id"] . '">'; // Hidden field for job_id
                        $hasActiveJobs = true; // Mark that we have at least one active job
                    }

                    echo '</div>';
                }
            } else {
                echo 'No job postings found.';
            }
            ?>
        </div>
        
        <input type="submit" class="common-edit-btn" value="Edit Jobs" <?php if (!$hasActiveJobs) echo 'disabled'; ?>>
    </form>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
