<?php
$server = "localhost";
$username = "root";
$password = '';
$database = "labourlink";

// Create connection
$con = new mysqli($server, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    echo "Connected successfully";
}

// Close the connection (optional, as it will be closed automatically at the end of the script execution)
//$con->close();
?>
