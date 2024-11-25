<?php
session_start();
include('connection.php');
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $_SESSION['email']=$email;

    // Validate passwords match
    //if($password != $repassword){
        //echo "<script>alert('Passwords do not match.');</script>";
      //  exit();
    //}
    // Hash the password
    //$password = password_hash($password, PASSWORD_DEFAULT);
    // Insert the new user into the database
    $sql = "INSERT INTO jobseeker_reg(name,email,password) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);
    $result = $stmt->execute();
    //echo $result;
// header("location:login.html");
//
    if($result){
      
        // Redirect to login page
     header("location:skercreateprofile.html");
   } else {
           header("location:seekerreg.html"); 
    }
//
    $stmt->close();
    $con->close();

}
?>
