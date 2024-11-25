<?php
// Database connection
$host = 'localhost';
$dbname = 'labourlink';
$user = 'your_username';
$pass = 'your_password';
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

    $sql = "UPDATE reg_reg SET otp = ?, otp_expiry = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $otp, $otp_expiry, $email);
    
    if ($stmt->execute()) {
        // Send OTP to email (using mail() function or any mail service)
        mail($email, "Your OTP Code", "Your OTP code is: " . $otp);
        echo 'OTP sent successfully.';
    } else {
        echo 'Error: ' . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
