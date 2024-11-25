<?php
session_start();
include("connection.php");

// Ensure the session contains the email
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    // Get the email from the session
    $email = $_SESSION['email'];

    // Define the SQL query
    $sql = "SELECT * FROM register WHERE email = ?";

    // Prepare the statement
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $email);
    if (!$stmt) {
        die("Error binding parameters: " . $stmt->error);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();

    // Check if a user was found
    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>PROFILE</title>
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
                .detail-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 15px;
                }
                .detail-row label {
                    font-weight: bold;
                    color: #00796b;
                    font-size: 20px;
                }
                .detail-row span {
                    color: #555;
                    font-size: 17px;
                    flex: 1;
                    text-align: right;
                }
                .edit-profile-button {
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
                .edit-profile-button:hover {
                    background-color: #004d40;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>PROFILE</h1>
                <div class="detail-row">
                    <label for="name">Name:</label>
                    <span id="name"><?= htmlspecialchars($user["fname"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="email">Email:</label>
                    <span id="email"><?= htmlspecialchars($user["email"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="address">Address:</label>
                    <span id="address"><?= htmlspecialchars($user["address"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="job_title">Job Title:</label>
                    <span id="job_title"><?= htmlspecialchars($user["job_title"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="dob">Date of Birth:</label>
                    <span id="dob"><?= htmlspecialchars($user["dob"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="gender">Gender:</label>
                    <span id="gender"><?= htmlspecialchars($user["gender"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="work_experience">Work Experience:</label>
                    <span id="work_experience"><?= htmlspecialchars($user["work_experience"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="skills">Skills:</label>
                    <span id="skills"><?= htmlspecialchars($user["skills"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="expected_hourly_rate">Hourly Rate:</label>
                    <span id="expected_hourly_rate"><?= htmlspecialchars($user["expected_hourly_rate"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="year_of_experience">Year Of Experience:</label>
                    <span id="year_of_experience"><?= htmlspecialchars($user["year_of_experience"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="known_language">Languages Known:</label>
                    <span id="known_language"><?= htmlspecialchars($user["known_language"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="location">Location:</label>
                    <span id="location"><?= htmlspecialchars($user["location"]) ?></span>
                </div>

                <a href="editprofile.php" class="edit-profile-button">Edit Profile</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "No results found for the given email.";
    }

    // Close statement and connection
    $stmt->close();
    $con->close();
} else {
    echo "No email parameter provided.";
}
?>
