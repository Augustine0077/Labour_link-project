<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Expire the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('logoutimage.png'); /* Background image */
            background-size: cover; /* Make the image cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logout-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .logout-container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .logout-container p {
            color: #666;
            margin-bottom: 20px;
        }

        #logoutBtn {
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        #logoutBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h1>You have been logged out</h1>
        <p>Thank you for visiting. Click the button below to return to the homepage.</p>
        <button id="logoutBtn">Go to Homepage</button>
    </div>

    <script>
        document.getElementById('logoutBtn').addEventListener('click', function() {
            // Redirect to the homepage
            window.location.href = 'index.html'; // Replace with your homepage or desired page
        });
    </script>
</body>
</html>
