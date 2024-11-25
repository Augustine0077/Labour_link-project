<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <style>
    .star-rating {
      unicode-bidi: bidi-override;
      direction: rtl;
      text-align: left;
    }

    .star-rating input[type="radio"] {
      display: none;
    }

    .star-rating label {
      color: #ccc;
      font-size: 25px;
      padding: 0;
      cursor: pointer;
    }

    .star-rating label:before {
      content: "\2605";
      padding: 5px;
    }

    .star-rating input[type="radio"]:checked ~ label {
      color: #ffcc00;
    }
  </style>
</head>
<body>
<link rel="stylesheet" href="display.css">

<div class="container">
  <h1>Admin Page</h1>
  <!-- New buttons for "Who all got job" and "pending jobs" -->
  <button class="btn btn-success my-2">
    <a href="display_got_job.php" class="text-light" style="text-decoration: none; color: inherit;">Who all got job</a>
  </button>
  <button class="btn btn-warning my-2">
    <a href="pending_jobs.php" class="text-light" style="text-decoration: none; color: inherit;">Pending jobs</a>
  </button>

  <!-- Seeker Table -->
  <h2>Seeker Table</h2>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Mobile</th>
        <th scope="col">Password</th>
        <th scope="col">Rating</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Fetch data from jobseeker_reg table
      $sql1 = "SELECT * FROM jobseeker_reg";
      $result1 = mysqli_query($con, $sql1);
      if ($result1) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
          $id1 = $row1['seeker_id'];
          $name1 = $row1['name'];
          $email1 = $row1['email'];
          $mobile1 = $row1['seeker_pn_no'];
          $password1 = $row1['password'];
          echo '<tr>
                  <td>'.$id1.'</td>
                  <td>'.$name1.'</td>
                  <td>'.$email1.'</td>
                  <td>'.$mobile1.'</td>
                  <td>'.$password1.'</td>
                  <td>
                    <div class="star-rating">
                      <input type="radio" id="star5-'.$id1.'" name="rating-'.$id1.'" value="5">
                      <label for="star5-'.$id1.'"></label>
                      <input type="radio" id="star4-'.$id1.'" name="rating-'.$id1.'" value="4">
                      <label for="star4-'.$id1.'"></label>
                      <input type="radio" id="star3-'.$id1.'" name="rating-'.$id1.'" value="3">
                      <label for="star3-'.$id1.'"></label>
                      <input type="radio" id="star2-'.$id1.'" name="rating-'.$id1.'" value="2">
                      <label for="star2-'.$id1.'"></label>
                      <input type="radio" id="star1-'.$id1.'" name="rating-'.$id1.'" value="1">
                      <label for="star1-'.$id1.'"></label>
                    </div>
                  </td>
                  <td>
                    <button><a href="update.php?updateid='.$id1.'&type=seeker">Allow</a></button>
                    <button><a href="delete.php?deleteid='.$id1.'&type=seeker">Delete</a></button>
                  </td>
                </tr>';
        }
      }
      ?>
    </tbody>
  </table>

  <!-- Recruiter Table -->
  <h2>Recruiter Table</h2>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Mobile</th>
        <th scope="col">Password</th>
        <th scope="col">Rating</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Fetch data from reccreateprofile table
      $sql2 = "SELECT * FROM reccreateprofile";
      $result2 = mysqli_query($con, $sql2);
      if ($result2) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
          $id2 = $row2['recu_id'];
          $name2 = $row2['name'];
          $email2 = $row2['email'];
          $mobile2 = $row2['phone_number'];
          $password2 = $row2['password'];
          echo '<tr>
                  <td>'.$id2.'</td>
                  <td>'.$name2.'</td>
                  <td>'.$email2.'</td>
                  <td>'.$mobile2.'</td>
                  <td>'.$password2.'</td>
                  <td>
                    <div class="star-rating">
                      <input type="radio" id="star5-'.$id2.'" name="rating-'.$id2.'" value="5">
                      <label for="star5-'.$id2.'"></label>
                      <input type="radio" id="star4-'.$id2.'" name="rating-'.$id2.'" value="4">
                      <label for="star4-'.$id2.'"></label>
                      <input type="radio" id="star3-'.$id2.'" name="rating-'.$id2.'" value="3">
                      <label for="star3-'.$id2.'"></label>
                      <input type="radio" id="star2-'.$id2.'" name="rating-'.$id2.'" value="2">
                      <label for="star2-'.$id2.'"></label>
                      <input type="radio" id="star1-'.$id2.'" name="rating-'.$id2.'" value="1">
                      <label for="star1-'.$id2.'"></label>
                    </div>
                  </td>
                  <td>
                    <button><a href="update.php?updateid='.$id2.'&type=recruiter">Allow</a></button>
                    <button><a href="delete.php?deleteid='.$id2.'&type=recruiter">Delete</a></button>
                  </td>
                </tr>';
        }
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
