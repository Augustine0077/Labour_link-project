<?php
session_start();
include("connection.php");

// Check if the email is set in the session
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    // Get the email from the session
    $email = $_SESSION['email'];

    // Define the SQL query
    $sql = "SELECT * FROM rec_reg WHERE email = ?";

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

    // Check if there are rows returned
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
                    background-color: #e6ffe6; /* Updated background color */
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
            </style>
        </head>
        <body>
            <div class="container">
                <h1>PROFILE</h1>
                <div class="detail-row">
                    <label for="name">Name:</label>
                    <span id="name"><?= htmlspecialchars($user["name"]) ?></span>
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
                    <label for="pin">PIN:</label>
                    <span id="pin"><?= htmlspecialchars($user["pin"]) ?></span>
                </div>
                <div class="detail-row">
                    <label for="city">City:</label>
                    <span id="city"><?= htmlspecialchars($user["city"]) ?></span>
                </div>

                <div class="button-row">
                    <a href="rec_home.html" class="button">Back</a>
                    <a href="editprofile.php" class="button">Edit Profile</a>
                </div>
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
