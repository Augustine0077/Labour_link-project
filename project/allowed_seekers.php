<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Seeker allowed -->
    <h2>Seeker allowed</h2>
    <table class="table">
      <thead>
        <tr> 
          <th scope="col">Id</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Mobile</th>
          <th scope="col">Operation</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch data from allowed seekers table
        $sql1 = "SELECT * FROM allowed_seekeer";
        $result1 = mysqli_query($con, $sql1);
        if ($result1) {
          while ($row1 = mysqli_fetch_assoc($result1)) {
            $id = isset($row1['id']) ? $row1['id'] : ''; // Check if 'id' key exists

                 $id = $row1['ald_seeker_id'];
		$id = $row1['ald_seeker_id'];
		$name1 = $row1['name'];
            $email1 = $row1['email'];
            $mobile1 = $row1['phone_no'];
            echo '<tr>
                    <td>'.$id.'</td>
                    <td>'.$name1.'</td>
                    <td>'.$email1.'</td>
                    <td>'.$mobile1.'</td>
                    <td>
                      <button><a href="delete_from_all_users.php?deleteID='.$id1.'&type=seeker">Delete</a></button>
                    </td>
                  </tr>';
          }
        }
        ?>
      </tbody>
    </table>

    <!-- Recruiter allowed-->
    <h2>Recruiter allowed</h2>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Mobile</th>
          <th scope="col">Operation</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch data from orginal_table table
        $sql2 = "SELECT * FROM orginal_table";
        $result2 = mysqli_query($con, $sql2);
        if ($result2) {
          while ($row2 = mysqli_fetch_assoc($result2)) {
            $id2 = isset($row2['id']) ? $row2['id'] : ''; // Check if 'id' key exists
                        
$id = $row2['ald_recu_id'];

$name2 = $row2['name'];
            $email2 = $row2['email'];
            $mobile2 = $row2['phone_no'];
            echo '<tr>
                    <td>'.$id2.'</td>
                    <td>'.$name2.'</td>
                    <td>'.$email2.'</td>
                    <td>'.$mobile2.'</td>
                    <td>
                      <button><a href="delete_from_all_users.php?deleteID='.$id2.'&type=recruiter">Delete</a></button>
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
