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
    $pin = trim($_POST["pin"]);
    $city = trim($_POST["city"]);

    // Prepare update statement
    $sql = "UPDATE rec_reg SET name=?, address=?, pin=?, city=? WHERE email=?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind parameters
    $stmt->bind_param("ssiss", $name, $address, $pin, $city, $_SESSION['email']);
    if (!$stmt) {
        die("Error binding parameters: " . $stmt->error);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        die("Error updating profile: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $con->close();

    // Redirect to profile page after update
    header("Location: rec_home.html");
    exit();
}

// Fetch current user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM rec_reg WHERE email = ?";
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
    .save-changes-button {
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
    .save-changes-button:hover {
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
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user["address"]); ?>" required>
            </div>
            <div class="form-group">
                <label for="pin">PIN:</label>
                <input type="text" id="pin" name="pin" value="<?php echo htmlspecialchars($user["pin"]); ?>" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user["city"]); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="save-changes-button">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
