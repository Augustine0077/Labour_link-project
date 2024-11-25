<?php
include("connection.php"); // Ensure this includes your database connection
session_start();

// Check if recruiter is logged in
if (!isset($_SESSION['email'])) {
    echo "Please log in to view your job applications.";
    exit();
}

// Retrieve the recruiter's email from the session
$recruiter_email = $_SESSION['email'];

// Check if a seeker email is provided for detail view
$seeker_email = isset($_GET['email']) ? $_GET['email'] : null;

// If a seeker email is provided, fetch their details
if ($seeker_email) {
    // Prepare the SQL query to fetch seeker details
    $sql = "SELECT * FROM job_seekers WHERE email = ?";
    $stmt = $con->prepare($sql);

    // Check if statement preparation was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $stmt->bind_param("s", $seeker_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a seeker was found
    if ($result->num_rows > 0) {
        $seeker = $result->fetch_assoc(); // Fetch the seeker data
    } else {
        echo "No seeker found with that email.";
        exit();
    }
} else {
    // Prepare the SQL query to fetch distinct applications and job seeker details
    $sql = "SELECT DISTINCT js.first_name, js.last_name, js.job_title, js.email, ja.application_date 
            FROM job_applications ja
            JOIN job_seekers js ON ja.seeker_email = js.email
            WHERE ja.recruiter_email = ?";
    $stmt = $con->prepare($sql);

    // Check if statement preparation was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $stmt->bind_param("s", $recruiter_email);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6ffe6;
            margin: 0;
            padding: 20px;
            color: #000; /* Set all text to black */
        }
        h1, h2 {
            text-align: center;
            color: #000; /* Set headings to black */
            margin-bottom: 40px;
        }
        .back-arrow {
            font-size: 18px;
            text-decoration: none;
            color: #000; /* Set button text to black */
            margin: 10px;
            padding: 10px 15px;
            border: 2px solid #2e8b57;
            border-radius: 5px;
            display: inline-block;
        }
        .back-arrow:hover {
            color: #228b22;
            border-color: #228b22;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 320px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .card h3 {
            margin-top: 0;
            color: #000; /* Set card titles to black */
            font-size: 1.5em;
            font-weight: bold;
            border-bottom: 2px solid #2e8b57;
            padding-bottom: 10px;
        }
        .card p {
            margin: 5px 0;
            color: #000; /* Set card text to black */
            font-size: 0.9em;
        }
        .card span {
            font-weight: bold;
            color: #444;
        }
        .details {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: auto;
            text-align: center; /* Center the text in the details section */
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px; /* Add margin to separate from seeker details */
        }
        .action-button {
            padding: 10px 20px; /* Increased padding for size */
            border-radius: 5px;
            cursor: pointer;
            width: 50%; /* Increased width to take full space */
            margin: 0 5px; /* Margin between buttons */
        }
        .reject-button {
            background-color: rgba(255, 77, 77, 0.5); /* Light red and transparent */
            border: 2px solid rgba(255, 0, 0, 0.5); /* Light red border */
            color: #000; /* Set button text to black */
        }
        .reject-button:hover {
            background-color: rgba(255, 0, 0, 0.7); /* Darker on hover */
        }
        .accept-button {
            background-color: #2e8b57; /* Green color */
            border: 2px solid #2e8b57; /* Green border */
            color: #fff; /* White text */
        }
        .accept-button:hover {
            background-color: #228b22; /* Darker green on hover */
        }
    </style>
</head>
<body>

    <!-- Back Arrow Link -->
    <a href="rec_home.html" class="back-arrow">&larr; Back</a>

    <?php if ($seeker_email): ?>
        <h1>Job Seeker Details</h1>
        <div class="details">
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($seeker['first_name'] . ' ' . $seeker['last_name']); ?></p>
            <p><strong>Job Title:</strong> <?php echo htmlspecialchars($seeker['job_title']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($seeker['dob']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($seeker['location']); ?></p>
            <p><strong>Hourly Rate:</strong> $<?php echo htmlspecialchars($seeker['hourly_rate']); ?></p>
            <p><strong>Skills:</strong> <?php echo htmlspecialchars($seeker['skills']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($seeker['gender']); ?></p>

            <!-- Buttons for Accept and Reject -->
            <div class="button-container">
                <form action="process_application.php" method="POST" style="flex-grow: 1; text-align: center;">
                    <input type="hidden" name="seeker_email" value="<?php echo htmlspecialchars($seeker['email']); ?>">
                    <input type="hidden" name="action" value="reject"> <!-- Action for rejection -->
                    <button type="submit" class="action-button reject-button">Reject</button>
                </form>
                <form action="process_application.php" method="POST" style="flex-grow: 1; text-align: center;">
                    <input type="hidden" name="seeker_email" value="<?php echo htmlspecialchars($seeker['email']); ?>">
                    <input type="hidden" name="action" value="accept"> <!-- Action for acceptance -->
                    <button type="submit" class="action-button accept-button">Accept</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <h1>Your Job Applications</h1>
        <div class="container">
            <?php
            // Check if any applications were found
            if ($result->num_rows > 0) {
                // Loop through the results and display each application in a card format
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<h3>' . htmlspecialchars($row['job_title']) . '</h3>';
                    echo '<p><span>Job Seeker Name:</span> <a href="?email=' . urlencode($row['email']) . '">' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . '</a></p>';
                    echo '<p><span>Application Date:</span> ' . htmlspecialchars($row['application_date']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>No applications found for your email.</p>";
            }
            ?>
        </div>
    <?php endif; ?>

</body>
</html>
