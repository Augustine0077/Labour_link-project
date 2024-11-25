<?php
session_start();
include('connection.php');

// Insert Seeker Profile
if(isset($_POST['seeker_submit'])){
  $seeker_name = $_POST['seeker_name'];
  $seeker_email = $_POST['seeker_email'];
  $seeker_mobile = $_POST['seeker_mobile'];
  $seeker_password = $_POST['seeker_password'];

  $seeker_sql = "INSERT INTO jobseeker_reg (name, email, seeker_pn_no, password) VALUES (?, ?, ?, ?)";
  $seeker_stmt = $con->prepare($seeker_sql);
  $seeker_stmt->bind_param("ssss", $seeker_name, $seeker_email, $seeker_mobile, $seeker_password);
  $seeker_result = $seeker_stmt->execute();
  if($seeker_result){
    echo "Seeker Profile inserted successfully";
  } else{
    die("Failed to connect with MySQL: " . mysqli_connect_error());
  }
}

// Insert Recruiter Profile
if(isset($_POST['recruiter_submit'])){
  $recruiter_name = $_POST['recruiter_name'];
  $recruiter_email = $_POST['recruiter_email'];
  $recruiter_mobile = $_POST['recruiter_mobile'];
  $recruiter_password = $_POST['recruiter_password'];

  $recruiter_sql = "INSERT INTO recruiter_reg (name, email, recruiter_pn_no, password) VALUES (?, ?, ?, ?)";
  $recruiter_stmt = $con->prepare($recruiter_sql);
  $recruiter_stmt->bind_param("ssss", $recruiter_name, $recruiter_email, $recruiter_mobile, $recruiter_password);
  $recruiter_result = $recruiter_stmt->execute();
  if($recruiter_result){
    echo "Recruiter Profile inserted successfully";
  } else{
    die("Failed to connect with MySQL: " . mysqli_connect_error());
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

  <title>Crud operation</title>
  <h3>Seeker Profile</h3>
</head>
<body>
  <div class="container my-5">
    <form method="post">
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" placeholder="Enter your name" name="seeker_name" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" placeholder="Enter your email" name="seeker_email" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Mobile</label>
        <input type="text" class="form-control" placeholder="Enter your mobile number" name="seeker_mobile" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" placeholder="Enter your password" name="seeker_password">
      </div>
      <button type="submit" class="btn btn-primary" name="seeker_submit">Submit</button>
    </form>
  </div>

  <!-- Recruiter Profile -->
  <div class="container my-5">
    <form method="post">
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" placeholder="Enter recruiter's name" name="recruiter_name" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" placeholder="Enter recruiter's email" name="recruiter_email" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Mobile</label>
        <input type="text" class="form-control" placeholder="Enter recruiter's mobile number" name="recruiter_mobile" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" placeholder="Enter recruiter's password" name="recruiter_password">
      </div>
      <button type="submit" class="btn btn-primary" name="recruiter_submit">Submit</button>
    </form>
  </div>
</body>
</html>
