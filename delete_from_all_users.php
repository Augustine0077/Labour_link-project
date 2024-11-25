<?php
include('connection.php');

if(isset($_GET['deleteid'])) {
  $id = $_GET['deleteid'];

  // Delete from jobseeker_allowed table
  $sql1 = "DELETE FROM jobseeker_allowed WHERE ald_seeker_id=$id";
  $result1 = mysqli_query($con, $sql1);

  // Delete from reccreateprofile table
  $sql2 = "DELETE FROM orginal_table WHERE ald_recu_id=$id";
  $result2 = mysqli_query($con, $sql2);

  if($result1 && $result2) {
    //echo "Deleted successfully"; // Add semicolon at the end of the line
    header('location:display.php');
  } else {
    die(mysqli_error($con));
  }
}
?>