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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $pin = $_POST['pin'];
    $city = $_POST['city'];

    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

    $sql = "INSERT INTO reg_reg (name, email, password, address, pin, city, otp, otp_expiry) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssss', $name, $email, $password, $address, $pin, $city, $otp, $otp_expiry);
    
    if ($stmt->execute()) {
        // Send OTP to email (using mail() function or any mail service)
        mail($email, "Your OTP Code", "Your OTP code is: " . $otp);
        echo 'OTP sent to your email. Please verify.';
    } else {
        echo 'Error: ' . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
