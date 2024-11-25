<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labourlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Fetch fname, job_title, location, and s_id from the job_seekers table
$sql = "SELECT first_name, s_id, job_title, location FROM job_seekers";
$result = $conn->query($sql);

$seekers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $seekers[] = $row;
    }
    echo json_encode($seekers);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No records found"]);
}

$conn->close();
?>
