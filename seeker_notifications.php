<?php
// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to login page if email is not found in session
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email (seeker)
$logged_in_email = $_SESSION['email'];

// Initialize the $notifications variable as an empty array
$notifications = [];

// Connect to the database (replace with your connection details)
$servername = "localhost";
$username = "root";              // Use 'root' for XAMPP
$password = "";                  // Empty for XAMPP unless a password is set
$dbname = "labourlink";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch notifications for the logged-in job seeker (seeker_email)
$sql = "SELECT * FROM notifications WHERE seeker_email = '$logged_in_email' ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Store notifications in an array
    while ($row = $result->fetch_assoc()) {
        // Ensure that the email is present before processing
        if (isset($row['seeker_email'])) {
            // Mark notification as read (you can adjust this as needed)
            if (!$row['is_read']) {
                $update_sql = "UPDATE notifications SET is_read = TRUE WHERE seeker_email = '$logged_in_email' AND message = '{$row['message']}'"; // Assuming message is unique per notification
                $conn->query($update_sql);
            }
            $notifications[] = $row;
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: transparent;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        .back-button i {
            margin-right: 8px;
        }

        .notification-card {
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            background: linear-gradient(135deg, #f9c8d8, #f9e1e1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            transition: transform 0.3s ease;
            position: relative;
        }
        .notification-card:hover {
            transform: scale(1.02);
        }
        .notification-header {
            font-weight: bold;
            color: #c0392b;
            font-size: 1.5em;
            margin-bottom: 15px;
        }
        .notification-card p {
            margin: 10px 0;
            color: #333;
            line-height: 1.6;
        }
        .notification-date {
            color: #888;
            font-size: 0.9em;
            margin-top: 10px;
        }
        .highlight {
            font-weight: bold;
        }
        .icon {
            font-size: 24px;
            color: #c0392b;
            margin-right: 10px;
            vertical-align: middle;
        }
        .accepted {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 5px solid #28a745; /* Green left border */
        }
        .rejected {
            background: linear-gradient(135deg, #f9c8d8, #f9e1e1);
            border-left: 5px solid #dc3545; /* Red left border */
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <button class="back-button" onclick="window.location.href='seeker_home.html';">
        <i class="fas fa-arrow-left"></i> Back
    </button>

    <h1>Your Notifications</h1>
    <div id="notifications-container">
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-card <?php echo strpos($notification['message'], 'accepted') !== false ? 'accepted' : 'rejected'; ?>" style="<?php echo !$notification['is_read'] ? 'font-weight: bold;' : ''; ?>">
                    <?php
                    // Extract details from the notification
                    $job_title = !empty($notification['job_title']) ? $notification['job_title'] : "Not Available";
                    $seeker_email = htmlspecialchars($notification['seeker_email']);
                    $recruiter_email = htmlspecialchars($notification['recruiter_email']);
                    $created_at = htmlspecialchars($notification['created_at']);
                    $message = htmlspecialchars($notification['message']);

                    // Extract the seeker's name from the email
                    $seeker_name = explode('@', $seeker_email)[0];

                    // Extract recruiter's name from the email
                    $recruiter_name = explode('@', $recruiter_email)[0];
                    ?>
                    <p class="notification-header"><i class="fas fa-exclamation-circle icon"></i>Hello <span class="highlight"><?php echo ucfirst($seeker_name); ?></span>,</p>
                    <p class="notification-date"><?php echo $created_at; ?></p>
                    <?php if (strpos($message, 'rejected') !== false): ?>
                        <p>Your application for the position '<span class="highlight"><?php echo $job_title; ?></span>' has been rejected by recruiter <span class="highlight"><?php echo ucfirst($recruiter_name); ?></span>.</p>
                    <?php elseif (strpos($message, 'accepted') !== false): ?>
                        <p>Your application for the position '<span class="highlight"><?php echo $job_title; ?></span>' has been accepted by recruiter <span class="highlight"><?php echo ucfirst($recruiter_name); ?></span>.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No notifications available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
