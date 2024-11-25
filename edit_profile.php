<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = trim($_POST["name"]);
    $address = trim($_POST["address"]);
    $skill = trim($_POST["skill"]);
    $job_title = trim($_POST["job_title"]);
    $location = trim($_POST["location"]);

    // Prepare update statement
    $sql = "UPDATE job_seekers SET first_name=?, address=?, skills=?, job_title=?, location=? WHERE email=?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssss", $name, $address, $skill, $job_title, $location, $_SESSION['email']);

    // Execute the statement
    if (!$stmt->execute()) {
        die("Error updating profile: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $con->close();

    // Redirect to profile page after update
    header("Location: seeker_home.html");
    exit();
}

// Fetch current user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM job_seekers WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
            max-width: 400px;
            width: 100%;
            text-align: left;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #00796b;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            color: #00796b;
            font-size: 20px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 17px;
            color: #555;
        }
        .save-changes-button, .back-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
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
        .save-changes-button:hover, .back-button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user["first_name"]); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user["address"]); ?>" required>
            </div>
            <div class="form-group">
                <label for="skill">Skill:</label>
                <input type="text" id="skill" name="skill" value="<?php echo htmlspecialchars($user["skills"]); ?>" required>
            </div>
             <div class="form-group">
                <label for="job_title">Job Title:</label>
                <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($user["job_title"]); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user["location"]); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="save-changes-button">Save Changes</button>
            </div>
        </form>
        <a href="seeker_home.html" class="back-button">Back to Home</a> <!-- Add a Back button -->
    </div>
</body>
</html>
