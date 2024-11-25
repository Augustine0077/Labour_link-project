<?php
include 'connection.php'; // Make sure this file contains your database connection details

header('Content-Type: application/json');

$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$response = [];

if (!empty($searchTerm)) {
    // Prepare the SQL query
    $query = "
    SELECT job_title, Description, Location, No_of_Openings FROM reccreateprofile WHERE job_title LIKE '%$searchTerm%' OR Description LIKE '%$searchTerm%' OR Location LIKE '%$searchTerm%' OR No_of_Openings LIKE '%$searchTerm%'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check for a query error
    if (!$result) {
        $response['status'] = 'error';
        $response['message'] = 'Query failed: ' . mysqli_error($conn);
    } else {
        // Fetch the search results
        if (mysqli_num_rows($result) > 0) {
            $jobs = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $jobs[] = [
                    'job_title' => htmlspecialchars($row['job_title']),
                    'Description' => htmlspecialchars($row['Description']),
                    'Location' => htmlspecialchars($row['Location']),
                    'No_of_Openings' => htmlspecialchars($row['No_of_Openings'])
                ];
            }
            $response['status'] = 'success';
            $response['jobs'] = $jobs;
        } else {
            $response['status'] = 'no_jobs';
            $response['message'] = 'No jobs found.';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'No search term provided.';
}

echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
