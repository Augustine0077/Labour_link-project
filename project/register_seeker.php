<?php
// Include the database connection
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $job_title = htmlspecialchars($_POST['job_title']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $gender = $_POST['gender'];
    $location = htmlspecialchars($_POST['location']);
    $hourly_rate = htmlspecialchars($_POST['hourly_rate']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $skills = htmlspecialchars($_POST['skills']);
    
    // Validate that passwords match
    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    // Check if the email already exists
    $check_email_sql = "SELECT s_id FROM job_seekers WHERE email = ?";
    $stmt = $con->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        echo "<script>alert('This email is already registered. Please use a different email.');</script>";
        $stmt->close();
        exit();
    } else {
        // Insert user data into the database (without OTP)
        $sql = "INSERT INTO job_seekers (first_name, last_name, job_title, email, password, gender, location,  hourly_rate, phone, address, skills)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssssssss", $first_name, $last_name, $job_title, $email, $password, $gender, $location,  $hourly_rate, $phone, $address, $skills);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close(); // Close the previous statement
    }

    $con->close(); // Close the database connection
}
?>
