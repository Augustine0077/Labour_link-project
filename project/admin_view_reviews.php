<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('desktop-wallpaper-construction-worker-construction-work - Copy.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
            max-width: 90%;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
        }
        td, th {
            text-align: center;
            padding: 15px;
        }
        tr {
            transition: background-color 0.3s ease;
        }
        .yellow-highlight {
            background-color: #ffff99 !important; /* Yellow highlight */
        }
        .red-highlight {
            background-color: #ffcccc !important; /* Red highlight */
        }
        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            padding: 10px 20px;
            font-size: 1.2rem;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }
        .scroll-to-top:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
    <button class="btn btn-primary back-button" onclick="history.back()">Back</button>
    <h2>Complaints</h2>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Complainer Email</th>
            <th scope="col">Complainer Role</th>
            <th scope="col">Complained Against Email</th>
            <th scope="col">Complaint</th>
            <th scope="col">Rating</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Function to count the number of 1-star ratings for each user
        function getOneStarCount($email, $con) {
            $sql = "SELECT COUNT(*) as one_star_count FROM complaints WHERE complained_against_email = '$email' AND rating = 1";
            $result = mysqli_query($con, $sql);
            return mysqli_fetch_assoc($result)['one_star_count'];
        }

        // Fetch all complaints ordered by created_at DESC
        $sql = "SELECT * FROM complaints ORDER BY created_at DESC";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $complained_email = $row['complained_against_email'];

                // Calculate the number of 1-star ratings for this user
                $one_star_count = getOneStarCount($complained_email, $con);

                // Determine color based on number of 1-star ratings
                $highlight_class = '';
                if ($one_star_count >= 10) {
                    $highlight_class = 'red-highlight'; // 10 or more 1-star ratings
                } elseif ($one_star_count == 5) {
                    $highlight_class = 'yellow-highlight'; // 5 to 9 1-star ratings
                }

                // Display the complaint with the proper highlight
                echo '<tr class="' . $highlight_class . '">';
                echo '<td>'.$row['complainer_email'].'</td>';
                echo '<td>'.$row['complainer_role'].'</td>';
                echo '<td>'.$row['complained_against_email'].'</td>';
                echo '<td>'.$row['complaint'].'</td>';
                echo '<td>'.$row['rating'].'</td>';
                echo '<td>'.$row['created_at'].'</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No complaints found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Scroll to Top Button -->
<button class="scroll-to-top" onclick="scrollToTop()">Top</button>

<script>
    // Scroll to Top functionality
    window.addEventListener('scroll', function() {
        const scrollButton = document.querySelector('.scroll-to-top');
        if (window.pageYOffset > 300) {
            scrollButton.style.display = 'block';
        } else {
            scrollButton.style.display = 'none';
        }
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
</body>
</html>
