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
}

// Fetch data from rec_table
$sql = "SELECT * FROM rec_table";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Initialize an empty array to store fetched data
    $rows = array();

    // Fetch rows one by onec
    while ($row = $result->fetch_assoc()) {
        // Append each row to the $rows array
        $rows[] = $row;
    }

    // Encode the $rows array into JSON format
    $json_data = json_encode($rows);

    // Output the JSON data
    echo $json_data;
} else {
    echo "0 results";
}

// Close connection
$con->close();
?>
