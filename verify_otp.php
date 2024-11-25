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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];
    $email = $_POST['email'];

    $sql = "SELECT otp, otp_expiry FROM reg_reg WHERE email = ? AND otp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $otp);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($storedOtp, $otpExpiry);
        $stmt->fetch();
        
        if (new DateTime() <= new DateTime($otpExpiry)) {
            echo 'OTP verified successfully.';
            // Proceed with registration completion
        } else {
            echo 'OTP has expired.';
        }
    } else {
        echo 'Invalid OTP.';
    }

    $stmt->close();
}

$conn->close();
?>
