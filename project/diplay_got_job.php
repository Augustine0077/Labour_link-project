<?php
include 'connection.php';

// Function to get the count of pending jobs
function getPendingJobCount($con) {
    $sql = "SELECT COUNT(*) AS count FROM `pending_jobs`";
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    }
    return $count;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Displaying Pending Jobs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('desktop-wallpaper-construction-worker-construction-work - Copy.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
        }
        .table {
            background-color: white;
            border-radius: 10px;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table td {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Updated Job (<?php echo getPendingJobCount($con); ?> Pending Jobs)</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Job Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Requester Name</th>
            <th scope="col">Posted Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT `job_name`, `email`, `phone_no`, `rq_name`, `posted_date` FROM `pending_jobs`";
        $result = mysqli_query($con, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['job_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['phone_no']) . '</td>';
                echo '<td>' . htmlspecialchars($row['rq_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['posted_date']) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">Error: ' . htmlspecialchars(mysqli_error($con)) . '</td></tr>';
        }
        ?>
        </tbody>
    </table>
    
    <a href="javascript:history.back()" class="btn btn-primary">Back</a> <!-- Back button using history -->
</div>
</body>
</html>
