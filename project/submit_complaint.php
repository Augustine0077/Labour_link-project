<?php
// Database connection
$servername = "localhost"; // Update with your database host
$username = "root";        // Update with your database username
$password = "";            // Update with your database password
$dbname = "labourlink";    // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    $complainer_email = $conn->real_escape_string($_POST['complainer_email']);
    $complainer_role = $conn->real_escape_string($_POST['complainer_role']);
    $complained_against_email = $conn->real_escape_string($_POST['complained_against_email']);
    $rating = (int) $_POST['rating'];
    $complaint = $conn->real_escape_string($_POST['complaint']);

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        $message = "Rating must be between 1 and 5.";
        $message_type = "error";
    } else {
        // Prepare SQL query
        $sql = "INSERT INTO complaints (complainer_email, complainer_role, complained_against_email, rating, complaint) 
                VALUES ('$complainer_email', '$complainer_role', '$complained_against_email', $rating, '$complaint')";

        if ($conn->query($sql) === TRUE) {
            $message = "Complaint submitted successfully.";
            $message_type = "success";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $message_type = "error";
        }
    }
}

// Redirect back to form page with message
header("Location: complaint_form.php?message=" . urlencode($message) . "&type=" . $message_type);
exit();

$conn->close();
?>
