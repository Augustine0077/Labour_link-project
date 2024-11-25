<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Displaying Got Jobs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1a1a1a; /* Dark background */
            font-family: Arial, sans-serif;
            color: #ccc; /* Light grey text */
            background-image: url('desktop-wallpaper-construction-worker-construction-work - Copy.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            margin-top: 50px;
            background-color: rgba(51, 51, 51, 0.8); /* Semi-transparent dark container background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
            color: #fff; /* White text */
        }
        .table {
            background-color: rgba(68, 68, 68, 0.9); /* Semi-transparent dark table background */
            color: #fff; /* White text */
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background-color: #555; /* Darker table header */
            color: #fff; /* White text */
        }
        .table td {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #666; /* Darker row on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Pending Jobs</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Job</th>
            <th scope="col">Recruiter Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM `pending_jobs`";
        $result = mysqli_query($con, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>'. htmlspecialchars($row['job_name']). '</td>';
                echo '<td>'. htmlspecialchars($row['rq_name']). '</td>';
                echo '<td>'. htmlspecialchars($row['email']). '</td>';
                echo '<td>'. htmlspecialchars($row['phone_no']). '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">Error: '. htmlspecialchars(mysqli_error($con)). '</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
