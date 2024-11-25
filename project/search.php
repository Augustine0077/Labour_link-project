<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search Results</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form label {
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }
        .search-form input[type="text"] {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        .search-form button {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        .job-list {
            list-style: none;
            padding: 0;
        }
        .job-item {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .job-item a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .job-item a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
        .job-location {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>



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

    // Get search input
    $job_title = isset($_GET['job_title']) ? $_GET['job_title'] : '';
    $location = isset($_GET['location']) ? $_GET['location'] : '';

    // Create SQL query with conditions for job title and location
    $sql = "SELECT * FROM job_postings WHERE 1=1";

    if (!empty($job_title)) {
        $sql .= " AND job_title LIKE '%" . $conn->real_escape_string($job_title) . "%'";
    }

    if (!empty($location)) {
        $sql .= " AND location LIKE '%" . $conn->real_escape_string($location) . "%'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Job Postings</h2>";
        echo "<ul class='job-list'>";
        while ($row = $result->fetch_assoc()) {
            // Display job title as clickable link leading to job_details.php
            echo "<li class='job-item'>";
            echo "<a href='job_detail.php?job_id=" . $row['job_id'] . "'>Job Title: " . htmlspecialchars($row['job_title']) . "</a>";
            echo "<div class='job-location'>Location: " . htmlspecialchars($row['location']) . "</div>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No results found.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
