<?php
include('connection.php');

if(isset($_GET['updateid'])) {
    $id = $_GET['updateid'];
    $type = $_GET['type']; // to distinguish between seeker and recruiter

    if($type == 'seeker') {
        // Fetch the seeker data
        $sql = "SELECT * FROM jobseeker_reg WHERE seeker_id = $id";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row) {
            // Insert into the main jobseekers table
            $name = $row['name'];
            $email = $row['email'];
            $mobile = $row['seeker_pn_no'];
            $password = $row['password'];

            $insertSql = "INSERT INTO user_tble (name, email, phone_number, password) VALUES ('$name', '$email', '$mobile', '$password')";
            $insertResult = mysqli_query($con, $insertSql);

            if($insertResult) {
                // Delete from jobseeker_reg table
                $deleteSql = "DELETE FROM jobseeker_reg WHERE seeker_id = $id";
                mysqli_query($con, $deleteSql);
                header('Location: admin_page.php'); // Redirect back to admin page
            }
        }
    } elseif($type == 'recruiter') {
        // Fetch the recruiter data
        $sql = "SELECT * FROM reccreateprofile WHERE recu_id = $id";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row) {
            // Insert into the main recruiters table
            $name = $row['name'];
            $email = $row['email'];
            $mobile = $row['phone_number'];
            $password = $row['password'];

            $insertSql = "INSERT INTO user_tbl (name, email, phone_number, password) VALUES ('$name', '$email', '$mobile', '$password')";
            $insertResult = mysqli_query($con, $insertSql);

            if($insertResult) {
                // Delete from reccreateprofile table
                $deleteSql = "DELETE FROM reccreateprofile WHERE recu_id = $id";
                mysqli_query($con, $deleteSql);
                header('Location: admin_page.php'); // Redirect back to admin page
            }
        }
    }
}
?>
