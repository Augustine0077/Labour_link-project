<?php
// Start the session
session_start();

// Include database connection (update with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labourlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for the form submission
$complainer_email = '';
$success_message = '';
$error_message = '';

// Check if the user is logged in and retrieve the email from the session
if (isset($_SESSION['email'])) {
    $complainer_email = $_SESSION['email'];
} else {
    // Redirect to login page or handle as needed if the user is not logged in
    $complainer_email = '';  // Default value for demonstration purposes
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $complainer_email = $_POST['complainer_email'];
    $complainer_role = $_POST['complainer_role'];
    $complained_against_email = $_POST['complain_against']; // Fixed variable
    $complaint = $_POST['complaint'];
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0; // Default rating if not selected

    // Prepare and execute the SQL query to insert the complaint into the complaints table
    $query = "INSERT INTO complaints (complainer_email, complainer_role, complained_against_email, complaint, rating, created_at)
              VALUES (?, ?, ?, ?, ?, NOW())"; // Using placeholders to prevent SQL injection

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ssssi", $complainer_email, $complainer_role, $complained_against_email, $complaint, $rating);

        if ($stmt->execute()) {
            // Set a flag to trigger the success message and redirect in the HTML
            echo "<script>
                    alert('Complaint submitted successfully.');
                    window.location.href = 'rec_home.html';
                  </script>";
        } else {
            // Handle error if the query fails
            $error_message = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle error if the query couldn't be prepared
        $error_message = "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate and Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #4CAF50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
        .rating-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .stars {
            display: flex;
            justify-content: center;
            flex-direction: row-reverse;
        }
        .stars input {
            display: none;
        }
        .stars label {
            font-size: 30px;
            cursor: pointer;
        }
        .stars label:before {
            content: '\2605';
            display: inline-block;
        }
        .stars input:checked ~ label:before {
            content: '\2605';
            color: gold;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Submit Your Complaint</h1>
    
    <!-- Success or error messages -->
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="complainer_email">Your Email:</label>
            <!-- Pre-fill the email field with the session email -->
            <input type="email" id="complainer_email" name="complainer_email" value="<?php echo htmlspecialchars($complainer_email); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="complainer_role">Your Role:</label>
            <input type="text" id="complainer_role" name="complainer_role" required>
        </div>
        <div class="form-group">
            <label for="complain_against">Complain Against (Email):</label>
            <input type="email" id="complain_against" name="complain_against" required>
        </div>
        <div class="form-group">
            <label for="complaint">Complaint:</label>
            <textarea id="complaint" name="complaint" rows="5" required></textarea>
        </div>
        <div class="form-group rating-wrapper">
            <label>Rating:</label>
            <div class="stars">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5"></label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4"></label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3"></label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2"></label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1"></label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit">Submit Complaint</button>
        </div>
    </form>
</div>

</body>
</html>
