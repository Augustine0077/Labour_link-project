<?php
session_start();
include('connection.php');

// Insert Seeker Profile
if(isset($_POST['seeker_submit'])){
  $seeker_id = $_POST['seeker_id'];
  $seeker_name = $_POST['seeker_name'];
  $seeker_email = $_POST['seeker_email'];
  $seeker_mobile = $_POST['seeker_mobile'];
  $seeker_password = $_POST['seeker_password'];

  // Validate form inputs
  if(empty($seeker_name) || empty($seeker_email) || empty($seeker_mobile) || empty($seeker_password)) {
    echo "All fields are required";
    exit;
  }

  $seeker_sql = "INSERT INTO jobseeker_reg (seeker_id, name, email, seeker_pn_no, password) VALUES (?, ?, ?, ?, ?)";
  $seeker_stmt = $con->prepare($seeker_sql);
  $seeker_stmt->bind_param("issss", $seeker_id, $seeker_name, $seeker_email, $seeker_mobile, $seeker_password);
  $seeker_result = $seeker_stmt->execute();
  if($seeker_result){
    echo "Seeker Profile inserted successfully";
  } else{
    echo "Failed to insert Seeker Profile: " . $con->error;
  }
}

// Insert Recruiter Profile
if(isset($_POST['recruiter_submit'])){
  $recruiter_id = $_POST['recruiter_id'];
  $recruiter_name = $_POST['recruiter_name'];
  $recruiter_email = $_POST['recruiter_email'];
  $recruiter_mobile = $_POST['recruiter_mobile'];
  $recruiter_password = $_POST['recruiter_password'];

  // Validate form inputs
  if(empty($recruiter_name) || empty($recruiter_email) || empty($recruiter_mobile) || empty($recruiter_password)) {
    echo "All fields are required";
    exit;
  }

  $recruiter_sql = "INSERT INTO reccreateprofile (recu_id, name, email, phone_number, password) VALUES (?, ?, ?, ?, ?)";
  $recruiter_stmt = $con->prepare($recruiter_sql);
  $recruiter_stmt->bind_param("issss", $recruiter_id, $recruiter_name, $recruiter_email, $recruiter_mobile, $recruiter_password);
  $recruiter_result = $recruiter_stmt->execute();
  if($recruiter_result){
    echo "Recruiter Profile inserted successfully";
  } else{
    echo "Failed to insert Recruiter Profile: " . $con->error;
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
        <label>ID</label>
        <input type="text" class="form-control" placeholder="Enter seeker's ID" name="seeker_id" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" placeholder="Enter seeker's name" name="seeker_name" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" placeholder="Enter seeker's email" name="seeker_email" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Mobile</label>
        <input type="text" class="form-control" placeholder="Enter seeker's mobile number" name="seeker_mobile" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" placeholder="Enter seeker's password" name="seeker_password">
      </div>
      <button type="submit" class="btn btn-primary" name="seeker_submit">Submit</button>
    </form>
  </div>

  <!-- Recruiter Profile -->
  <h3>Recruiter Profile</h3>
  <div class="container my-5">
    <form method="post">
      <div class="form-group">
        <label>ID</label>
        <input type="text" class="form-control" placeholder="Enter recruiter's ID" name="recruiter_id" autocomplete="off">
      </div>
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
        <input type="password" class="form-control" placeholder="Ent
