<?php
session_start(); // Start the session

$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "labourlink";  
$conn = mysqli_connect($host, $user, $password, $db_name);  

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $skills_required = $_POST['skills_required'];
    $openings = $_POST['openings'];
    $date_time = $_POST['date_time'];
    $hours = $_POST['hours'];
    $wage = $_POST['wage'];

    // Get the email from the session
    if (isset($_SESSION['email'])) {
        $posted_by = $_SESSION['email'];
    } else {
        echo "User email is not set in session.";
        $posted_by = ''; // Default value or handle accordingly
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO job_postings (job_title, description, location, skills_required, openings, date_time, hours, wage, posted_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("ssssissss", $job_title, $description, $location, $skills_required, $openings, $date_time, $hours, $wage, $posted_by);

    // Execute the statement
    if ($stmt->execute()) {
        // Close the statement
        $stmt->close();
        
        // Close the connection
        $conn->close();
        
        // Use JavaScript for alert and redirect
        echo '<script>
            alert("New job posting added successfully.");
            window.location.href = "rec_home.html";
        </script>';
    } else {
        // Close the statement
        $stmt->close();
        
        // Close the connection
        $conn->close();
        
        // Display error message
        echo "Error: " . $stmt->error;
    }
}
?>
