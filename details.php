<?php
// Set the header to display the page as HTML
header('Content-Type: text/html; charset=UTF-8');

// Check if s_id is set in the URL
if (!isset($_GET['s_id'])) {
    echo "<p>Error: s_id is required.</p>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labourlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "<p>Connection failed: " . $conn->connect_error . "</p>";
    exit();
}

// Sanitize and prepare the s_id
$s_id = $conn->real_escape_string($_GET['s_id']);

// Prepare and execute the SQL query
$sql = "SELECT first_name, job_title, location, gender, skills, hourly_rate
        FROM job_seekers WHERE s_id = '$s_id'";
$result = $conn->query($sql);

// Check if the query was successful and if any rows were returned
if ($result && $result->num_rows > 0) {
    $details = $result->fetch_assoc();
} else {
    echo "<p>No details found for the provided s_id.</p>";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeker Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #a8e6a3; /* Lighter green background color */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px; /* Increased width for more space */
            width: 100%;
            text-align: left;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #00796b;
            text-align: center;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .detail-row label {
            font-weight: bold;
            color: #00796b;
            font-size: 18px;
            width: 40%; /* Adjust width to fit content */
            text-align: left;
        }
        .detail-row span {
            color: #555;
            font-size: 16px;
            width: 60%; /* Adjust width to fit content */
            text-align: right;
        }
        .button-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .button {
            width: 40%;
            padding: 10px;
            text-align: center;
            background-color: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #004d40;
        }
        .button.cancel {
            background-color: #d32f2f;
        }
        .button.cancel:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Seeker Details</h1>
        </div>
        <div class="details">
            <p><strong>Name:</strong> <span class="value"><?php echo htmlspecialchars($details['first_name']); ?></span></p>
            <p><strong>Job Title:</strong> <span class="value"><?php echo htmlspecialchars($details['job_title']); ?></span></p>
            <p><strong>Location:</strong> <span class="value"><?php echo htmlspecialchars($details['location']); ?></span></p>
            <p><strong>Gender:</strong> <span class="value"><?php echo htmlspecialchars($details['gender']); ?></span></p>
            <p><strong>Skills:</strong> <span class="value"><?php echo htmlspecialchars($details['skills']); ?></span></p>
            <p><strong>Expected Hourly Rate:</strong> <span class="value"><?php echo htmlspecialchars($details['hourly_rate']); ?></span></p>
        </div>
        <div class="button-row">
            <a href="rec_home.html" class="button cancel">Back</a> <!-- Back button on the left -->
            <a href="confirm_hire.php?s_id=<?php echo urlencode($s_id); ?>" class="button">Hire</a> <!-- Hire button on the right -->
        </div>
    </div>
</body>
</html>
