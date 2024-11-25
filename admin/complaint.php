<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $complaint = htmlspecialchars($_POST['complaint']);

    // Server-side validation for name
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        die("Invalid name: Please use only letters and spaces.");
    }

    // Database connection (modify these values according to your setup)
    $servername = "localhost";
    $username = "root";
    $dbname = "labourlink";
    $conn = new mysqli($servername, $username, "", $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO complaint (name, email, subject, complaint) VALUES ('$name', '$email', '$subject', '$complaint')";

    if ($conn->query($sql) === TRUE) {
        // If the complaint is registered successfully, show a JavaScript alert and redirect
        echo "<script>
            alert('Complaint registered successfully!');
            window.location.href = 'seeker_home.html'; // Replace 'seeker_profile.php' with the actual profile page URL
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
