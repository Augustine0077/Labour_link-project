<?php
session_start(); // Start the session at the beginning

$servername = "localhost";
$username = "root"; // replace with your database username
$password = ''; // replace with your database password
$dbname = "labourlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $pin = $_POST['pin'];
    $city = $_POST['city'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO rec_reg (name, email, password, address, pin, city) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $password, $address, $pin, $city);

    if ($stmt->execute()) {
        // Store the email in the session
        $_SESSION['email'] = $email;

        // Redirect to rec_home.php
        header("Location: rec_home.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
