<!-- Got Job Table -->
<h2>Got Job Table</h2>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone Number</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Fetch data from got_job table
    $sql3 = "SELECT id, name, email, phone_no FROM got_job";
    $result3 = mysqli_query($con, $sql3);
    if ($result3) {
      while ($row3 = mysqli_fetch_assoc($result3)) {
        $id3 = $row3['id'];
        $name3 = $row3['name'];
        $email3 = $row3['email'];
        $phone_no3 = $row3['phone_no'];
        echo '<tr>
                <td>'.$id3.'</td>
                <td>'.$name3.'</td>
                <td>'.$email3.'</td>
                <td>'.$phone_no3.'</td>
              </tr>';
      }
    }
    ?>
  </tbody>
</table>
