<?php
session_start();

// Database connection
$servername = "localhost";  // Update with your database host
$username = "root";         // Update with your database username
$password = "";             // Update with your database password
$dbname = "labourlink";     // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get job ID from URL or form
$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #d4fc79 0%, #96e6a1 100%); /* Soft purple gradient background */
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .job-container {
            background-color: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            padding: 20px;
            width: 100%;
        }

        h2 {
            color: #333;
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-apply {
            background-color: #28a745;
        }

        .btn-back {
            background-color: #007bff;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="job-container">
    <?php
    if (!empty($job_id)) {
        // Fetch the job details for the given job ID
        $sql = "SELECT * FROM job_postings WHERE job_id = '" . $conn->real_escape_string($job_id) . "'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>Job Details</h2>";
            echo "<p><strong>Job Title:</strong> " . $row['job_title'] . "</p>";
            echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
            echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
            echo "<p><strong>Salary:</strong> Rs: " . $row['wage'] . "</p>";
            echo "<p><strong>Posted On:</strong> " . $row['date_time'] . "</p>";

            // Check if user is logged in
            if ($user_email) {
                // Retrieve seeker ID
                $s_id_query = $conn->prepare("SELECT s_id FROM job_seekers WHERE email = ?");
                $s_id_query->bind_param("s", $user_email);
                $s_id_query->execute();
                $s_id_result = $s_id_query->get_result();

                if ($s_id_result->num_rows > 0) {
                    $seeker = $s_id_result->fetch_assoc();
                    $s_id = $seeker['s_id'];

                    // Check if the user has already applied for the job
                    $check_stmt = $conn->prepare("SELECT * FROM applied_jobs WHERE s_id = ? AND job_id = ?");
                    $check_stmt->bind_param("ii", $s_id, $job_id);
                    $check_stmt->execute();
                    $check_result = $check_stmt->get_result();

                    if ($check_result->num_rows > 0) {
                        echo "<p style='color: red;'>You have already applied for this job.</p>";
                    } else {
                        // Handle application process
                        if (isset($_POST['apply'])) {
                            // Prepare the SQL statement to apply for the job
                            $apply_stmt = $conn->prepare("INSERT INTO applied_jobs (s_id, job_id, user_email) VALUES (?, ?, ?)");
                            $apply_stmt->bind_param("iis", $s_id, $job_id, $user_email);
                            
                            if ($apply_stmt->execute()) {
                                echo "<p style='color: green;'>Application successful!</p>";
                            } else {
                                echo "<p style='color: red;'>Error applying for job: " . $apply_stmt->error . "</p>";
                            }
                            $apply_stmt->close();
                        }
                        echo '<form method="POST">
                                <input type="submit" name="apply" value="Apply Now" class="btn btn-apply">
                              </form>';
                    }
                    $check_stmt->close();
                } else {
                    echo "<p style='color: red;'>Seeker ID not found.</p>";
                }
            } else {
                echo "<p style='color: red;'>You need to be logged in to apply for this job.</p>";
            }
        } else {
            echo "<p>No details found for this job.</p>";
        }
    } else {
        echo "<p>Invalid job ID.</p>";
    }

    $conn->close();
    ?>

    <!-- Buttons: Back -->
    <div class="buttons">
        <a href="seeker_home.html" class="btn btn-back">Back</a>
    </div>
</div>

</body>
</html>
