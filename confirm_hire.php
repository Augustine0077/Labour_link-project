<?php
// Set the header to display the page as HTML
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_GET['s_id'])) {
    echo "<p>Error: s_id is required.</p>";
    exit();
}

$s_id = htmlspecialchars($_GET['s_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Hire</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #a8e6a3; /* Lighter green background color */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #00796b;
        }
        .container p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .button {
            width: 50%;
            padding: 10px;
            text-align: center;
            background-color: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
            margin: 0 10px;
        }
        .button:hover {
            background-color: #004d40;
        }
        .button.cancel {
            background-color: #d32f2f;
        }
        .button.cancel:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirm Hiring</h1>
        <p>Are you sure you want to contact this job seeker?</p>
        <div>
            <a href="process_hire.php?s_id=<?php echo urlencode($s_id); ?>" class="button">Yes, Contact</a>
            <a href="javascript:history.back()" class="button cancel">Cancel</a>
        </div>
    </div>
</body>
</html>
