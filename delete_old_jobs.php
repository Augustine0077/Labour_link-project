<?php
include 'connection.php';

// SQL query to delete jobs older than 24 hours
$sql = "DELETE FROM `pending_jobs` WHERE `created_at` < NOW() - INTERVAL 1 DAY";

// Debugging: Print the query
echo "Running query: $sql<br>";

// Execute the query
if (mysqli_query($con, $sql)) {
    echo "Old jobs deleted successfully.";
} else {
    echo "Error deleting old jobs: " . mysqli_error($con);
}

mysqli_close($con);
?>
