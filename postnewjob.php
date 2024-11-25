<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labourlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user name from the session (make sure this is set during login)
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $skills_required = $_POST['skills_required'];
    $openings = $_POST['openings'];
    $date_time = $_POST['date_time'];
    $hours = $_POST['hours'];
    $wage = $_POST['wage'];

    // Insert job posting details into the database
    $sql = "INSERT INTO job_postings (user_name, job_title, description, location, skills_required, openings, date_time, hours, wage)
            VALUES ('$user_name', '$job_title', '$description', '$location', '$skills_required', $openings, '$date_time', $hours, $wage)";

    if ($conn->query($sql) === TRUE) {
        echo "New job posting created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Job Posting</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #a8e6a3;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            max-width: 600px;
            height: 80%;
            max-height: 600px;
            overflow-y: auto;
            text-align: left;
        }
        .container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #00796b;
            text-align: center;
        }
        .labourlink {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 18px;
            text-decoration: none;
            color: #00796b;
        }
        label {
            font-weight: bold;
            color: #00796b;
            font-size: 20px;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 17px;
            color: #555;
        }
        input[type="submit"] {
            background-color: #00796b;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <a href="#" class="labourlink">LabourLink</a>
    <div class="container">
        <h2>New Job Posting</h2>
        <form action="newjob.php" method="post">
            <label for="job_title">Job Title:</label><br>
            <input type="text" id="job_title" name="job_title" required><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" required></textarea><br><br>

            <label for="location">Location of Work:</label><br>
            <input type="text" id="location" name="location" required><br><br>

            <label for="skills_required">Skills Required:</label><br>
            <input type="text" id="skills_required" name="skills_required" required><br><br>

            <label for="openings">Number of Openings:</label><br>
            <input type="number" id="openings" name="openings" required><br><br>

            <label for="date_time">Date and Time:</label><br>
            <input type="datetime-local" id="date_time" name="date_time" required><br><br>

            <label for="hours">Hours:</label><br>
            <input type="number" id="hours" name="hours" required><br><br>

            <label for="wage">Wage:</label><br>
            <input type="number" id="wage" name="wage" required><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
