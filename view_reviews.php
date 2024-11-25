<?php
include('connection.php');
session_start();

$email = $_SESSION['email'];
$sql = "SELECT reviewer_email, review, created_at FROM user_reviews WHERE reviewee_email = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $reviewer_email, $review, $created_at);

echo "<h2>Your Reviews and Complaints</h2>";
echo "<table border='1'>
<tr>
<th>Reviewer Email</th>
<th>Review</th>
<th>Created At</th>
</tr>";

while (mysqli_stmt_fetch($stmt)) {
    echo "<tr>
    <td>" . htmlspecialchars($reviewer_email) . "</td>
    <td>" . htmlspecialchars($review) . "</td>
    <td>" . htmlspecialchars($created_at) . "</td>
    </tr>";
}

echo "</table>";

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
