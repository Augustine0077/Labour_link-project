<?php
include('connection.php'); // Include the database connection file
session_start(); // Start the session to manage user logins
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('desktop-wallpaper-construction-worker-construction-work.jpg'); /* Adding the background image */
            background-size: cover; /* Ensures the image covers the entire background */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-attachment: fixed; /* Keeps the background fixed when scrolling */
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Adding a slight white background with transparency for better readability */
            padding: 20px;
            border-radius: 10px;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .form-inline input[type="email"] {
            width: 250px;
            transition: all 0.3s ease-in-out;
        }

        .form-inline input[type="email"]:focus {
            width: 300px;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        .table {
            margin-bottom: 30px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
        }

        td {
            text-align: center;
            vertical-align: middle;
        }

        .btn {
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 250px;
            z-index: 1050;
        }
    </style>
    <script>
        function showToast(message, type = 'success') {
            const toastContainer = document.createElement('div');
            toastContainer.className = `toast alert alert-${type}`;
            toastContainer.innerHTML = `
                <div class="d-flex justify-content-between">
                    <div>${message}</div>
                    <button type="button" class="ml-2 mb-1 close" onclick="this.parentElement.parentElement.remove();">
                        &times;
                    </button>
                </div>
            `;
            document.body.appendChild(toastContainer);
            setTimeout(() => toastContainer.remove(), 4000);
        }

        function sendMessage(email, role) {
            const message = `
            Subject: Temporary Ban Notification

            Dear Labour Link user,

            We have noticed that you have committed some violations of our platform’s terms and policies. As a result, we have decided to impose a temporary ban on your account for 10 days, starting from today.

            We kindly ask you to review the terms and conditions of our platform to avoid further issues.

            Thank you for your understanding, and we hope to welcome you back once the ban period has ended.

            

            Sincerely,
            The Labour Link Team`;

            if (confirm(`Are you sure you want to send this message to ${role} with email ${email}?`)) {
                document.getElementById('email').value = email;
                document.getElementById('role').value = role;
                document.getElementById('subject').value = 'Temporary Ban Notification';
                document.getElementById('message').value = message;
                document.getElementById('messageForm').submit();
            }
        }

        function banUser(email, role) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "ban_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            showToast(response.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showToast('Error: ' + response.message, 'danger');
                        }
                    } catch (e) {
                        showToast('Invalid JSON response: ' + xhr.responseText, 'danger');
                    }
                }
            };
            xhr.send("email=" + encodeURIComponent(email) + "&role=" + encodeURIComponent(role));
        }

        function permanentBanUser(email, role) {
            if (confirm(`Are you sure you want to permanently ban ${role} with email ${email}?`)) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "permanent_ban_user.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                showToast(response.message, 'success');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showToast('Error: ' + response.message, 'danger');
                            }
                        } catch (e) {
                            showToast('Invalid JSON response: ' + xhr.responseText, 'danger');
                        }
                    }
                };
                xhr.send("email=" + encodeURIComponent(email) + "&role=" + encodeURIComponent(role));
            }
        }
    </script>
</head>
<body>
<div class="container">
    <!-- Back Button -->
    <button class="btn btn-secondary back-button" onclick="history.back()">Back</button>

    <!-- Search Form -->
    <form method="GET" action="" class="form-inline mb-3">
        <input type="email" name="search_email" class="form-control mr-2" placeholder="Search by email" required>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Message Form -->
    <form id="messageForm" action="process.php" method="post" style="display:none;">
        <input type="hidden" id="email" name="email">
        <input type="hidden" id="role" name="role">
        <input type="hidden" id="subject" name="subject">
        <input type="hidden" id="message" name="message">
    </form>

    <!-- Job Seekers Table -->
    <h2>Job Seekers</h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">First Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch data from the job_seekers
        $search_email = isset($_GET['search_email']) ? $_GET['search_email'] : '';
        $sql_seeker = "SELECT first_name, email, ban_start_date, ban_end_date, permanently_banned 
                       FROM job_seekers 
                       WHERE permanently_banned = 0";
        if (!empty($search_email)) {
            $sql_seeker .= " AND email LIKE '%$search_email%'";
        }
        $result_seeker = mysqli_query($con, $sql_seeker);
        if ($result_seeker) {
            while ($row_seeker = mysqli_fetch_assoc($result_seeker)) {
                $first_name = $row_seeker['first_name'];
                $email = $row_seeker['email'];
                $ban_start_date = $row_seeker['ban_start_date'];
                $ban_end_date = $row_seeker['ban_end_date'];

                echo '<tr>
                        <td>'.$first_name.'</td>
                        <td>'.$email.'</td>
                        <td>';
                if (is_null($ban_start_date) || $ban_start_date < date('Y-m-d H:i:s')) {
                    echo ' <button class="btn btn-primary" onclick="sendMessage(\''.$email.'\', \'seeker\')">Send Message & Ban</button>';
                    echo ' <button class="btn btn-danger" onclick="permanentBanUser(\''.$email.'\', \'seeker\')">Permanent Ban</button>';
                } else {
                    echo 'Ban starts on '.$ban_start_date;
                }
                echo '</td>
                      </tr>';
            }
        }
        ?>
        </tbody>
    </table>

    <!-- Recruiter Table -->
    <h2>Job Recruiters</h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch data from the job_recruiters
        $sql_recruiter = "SELECT name, email, ban_start_date, ban_end_date, permanently_banned 
                           FROM rec_reg 
                           WHERE permanently_banned = 0";
        if (!empty($search_email)) {
            $sql_recruiter .= " AND email LIKE '%$search_email%'";
        }
        $result_recruiter = mysqli_query($con, $sql_recruiter);
        if ($result_recruiter) {
            while ($row_recruiter = mysqli_fetch_assoc($result_recruiter)) {
                $name = $row_recruiter['name'];
                $email = $row_recruiter['email'];
                $ban_start_date = $row_recruiter['ban_start_date'];
                $ban_end_date = $row_recruiter['ban_end_date'];

                echo '<tr>
                        <td>'.$name.'</td>
                        <td>'.$email.'</td>
                        <td>';
                if (is_null($ban_start_date) || $ban_start_date < date('Y-m-d H:i:s')) {
                    echo ' <button class="btn btn-primary" onclick="sendMessage(\''.$email.'\', \'recruiter\')">Send Message & Ban</button>';
                    echo ' <button class="btn btn-danger" onclick="permanentBanUser(\''.$email.'\', \'recruiter\')">Permanent Ban</button>';
                } else {
                    echo 'Ban starts on '.$ban_start_date;
                }
                echo '</td>
                      </tr>';
            }
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
