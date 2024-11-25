<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "labourlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve email from session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if ($email) {
    // Prepare and execute the query to fetch the user's name
    $sql = "SELECT name FROM rec_reg WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the result
            $row = $result->fetch_assoc();
            echo json_encode(["name" => $row['name']]);
        } else {
            echo json_encode(["name" => null]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
    }
} else {
    echo json_encode(["name" => null]);
}

$conn->close();
?>
