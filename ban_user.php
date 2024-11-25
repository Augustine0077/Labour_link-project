<?php
include('connection.php'); // Include the database connection

// Check if the email and role are sent via POST
if (isset($_POST['email']) && isset($_POST['role'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    // Get the current date for ban_start_date
    $ban_start_date = date('Y-m-d H:i:s');
    
    // Define the duration of the ban (10 days in this example)
    $ban_end_date = date('Y-m-d H:i:s', strtotime($ban_start_date . ' + 10 days'));

    if ($role === 'seeker') {
        // Update the job_seekers table with the ban dates
        $sql = "UPDATE job_seekers 
                SET ban_start_date = '$ban_start_date', ban_end_date = '$ban_end_date'
                WHERE email = '$email'";

        if (mysqli_query($con, $sql)) {
            $response = [
                'success' => true,
                'message' => 'Job seeker banned successfully with ban_start_date set.'
            ];
        } else {
            // Log the error
            error_log('SQL Error: ' . mysqli_error($con)); // Log error
            $response = [
                'success' => false,
                'message' => 'Error updating job seeker ban: ' . mysqli_error($con)
            ];
        }
    } elseif ($role === 'recruiter') {
        // Update the rec_reg table with the ban dates for recruiters
        $sql = "UPDATE rec_reg 
                SET ban_start_date = '$ban_start_date', ban_end_date = '$ban_end_date'
                WHERE email = '$email'";

        if (mysqli_query($con, $sql)) {
            $response = [
                'success' => true,
                'message' => 'Recruiter banned successfully with ban_start_date set.'
            ];
        } else {
            // Log the error
            error_log('SQL Error: ' . mysqli_error($con)); // Log error
            $response = [
                'success' => false,
                'message' => 'Error updating recruiter ban: ' . mysqli_error($con)
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Invalid role.'
        ];
    }

    // Return JSON response
    echo json_encode($response);
} else {
    $response = [
        'success' => false,
        'message' => 'Email or role not provided.'
    ];
    echo json_encode($response);
}
?>
