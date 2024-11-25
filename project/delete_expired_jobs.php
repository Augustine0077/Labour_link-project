<?php
// Include your database connection file (e.g., connection.php)
include 'connection.php';

// Calculate the date 1 day ago
$oneDayAgo = date('Y-m-d H:i:s', strtotime('-1 day'));

// SQL query to delete jobs posted more than 1 day ago
$sql = "DELETE FROM `pending_jobs` WHERE `posted_date` < '$oneDayAgo'";

// Perform the deletion query
if (mysqli_query($con, $sql)) {
    echo "Expired jobs deleted successfully.";
} else {
    echo "Error deleting expired jobs: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
