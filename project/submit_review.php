<?php
include('connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewer_email = $_SESSION['email'];
    $reviewee_email = $_POST['reviewee_email'];
    $review = $_POST['review'];

    $sql = "INSERT INTO user_reviews (reviewer_email, reviewee_email, review) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $reviewer_email, $reviewee_email, $review);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Review submitted successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
