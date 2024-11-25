<?php
// Set the header to display the page as HTML
header('Content-Type: text/html; charset=UTF-8');

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

$s_id = $conn->real_escape_string($_GET['s_id']);

$sql = "SELECT first_name, job_title, phone
        FROM job_seekers WHERE s_id = '$s_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $details = $result->fetch_assoc();
} else {
    echo "<p>No contact details found for the provided s_id.</p>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:#e6ffe6; /* Lighter green background color */
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
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #00796b;
        }
        .container p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .button {
            width: 45%;
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
            display: inline-block;
            margin: 0 10px;
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
        <h1>Contact Details</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($details['first_name']); ?></p>
        <p><strong>Job Title:</strong> <?php echo htmlspecialchars($details['job_title']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($details['phone']); ?></p>
                <div>
            <a href="rec_home.html" class="button cancel">Back</a>
        </div>
    </div>
</body>
</html>
