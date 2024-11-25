<?php
session_start();
include('connection.php');
if(isset($_POST['next'])){
    //$id= $_POST[''];
    //$lst_nme = $_POST['seeker_lastname'];
    $email=$_SESSION['email'];
    $ph_no=$_POST['mobile'];
    $pr_pto=$_POST['profile_photo'];
    $Address=$_POST['address'];
    $pin=$_POST['pin'];
    $gender=$_POST['gender'];
    $Dob=$_POST['dob'];
  
    // Insert the new user into the database
//update 
    $sql = "UPDATE jobseeker_reg set seeker_pn_no=? where email=?";
    $stmt=$con->prepare($sql);
    $stmt->bind_param("is",$ph_no,$email);
    $result = $stmt->execute();
       if($result){
    	echo $email;
   	echo $ph_no;
	echo  $gender;

  } else {
       header("location: firstpage.html");
    }
 $email=$_SESSION['email'];
    $ph_no=$_POST['mobile'];
    $pr_pto=$_POST['profile_photo'];
    $Address=$_POST['address'];
    $pin=$_POST['pin'];
    $gender=$_POST['gender'];
    $Dob=$_POST['dob'];

    // Insert the new user into the database
//update 
    $sql = "UPDATE reccreateprofile set phone_number=? where email=?";
    $stmt=$con->prepare($sql);
    $stmt->bind_param("is",$ph_no,$email);
    $result = $stmt->execute();
       if($result){
    	echo $email;
   	echo $ph_no;
	echo  $gender;

  } else {
       header("location: firstpage.html");
    }


  $stmt->close();
    $con->close();
}
?>
