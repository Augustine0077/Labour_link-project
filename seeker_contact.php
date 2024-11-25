<?php
// Start session and check if the user is logged in as a recruiter
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to login page if email is not found in session
    header("Location: login.php");
    exit();
}

// Get the seeker email from the URL
if (isset($_GET['email'])) {
    $seeker_email = $_GET['email'];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = ""; // Empty for XAMPP unless a password is set
    $dbname = "labourlink";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the seeker's contact information
    $sql = "SELECT first_name, last_name, job_title, email, phone FROM job_seekers WHERE email = '$seeker_email'";
    $result = $conn->query($sql);
    $seeker = $result->fetch_assoc();

    // Close the connection
    $conn->close();
} else {
    $seeker = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            padding: 20px;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .contact-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .back-button:hover {
            background-color: #45a049;
        }
        .back-button::before {
            content: '←'; /* Left arrow symbol */
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <!-- Back button with left arrow -->
    <a href="rec_home.html">
        <button class="back-button">Back</button>
    </a>

    <h1>Contact Information</h1>
    <?php if ($seeker): ?>
        <div class="contact-card">
            <h2><?php echo htmlspecialchars($seeker['first_name']) . ' ' . htmlspecialchars($seeker['last_name']); ?></h2>
            <p>Job Title: <?php echo htmlspecialchars($seeker['job_title']); ?></p>
            <p>Email: <?php echo htmlspecialchars($seeker['email']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($seeker['phone']); ?></p>
        </div>
    <?php else: ?>
        <p>No contact information found.</p>
    <?php endif; ?>
</body>
</html>
