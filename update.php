<?php
include('connection.php');

if(isset($_GET['updateid']) && isset($_GET['type'])) {
    $id = $_GET['updateid'];
    $type = $_GET['type']; // to distinguish between seeker and recruiter

    echo "Update ID: " . $id . "<br>";
    echo "Type: " . $type . "<br>";

    if($type == 'seeker') {
        // Fetch the seeker data
        $sql = "SELECT * FROM jobseeker_reg WHERE seeker_id = $id";
        $result = mysqli_query($con, $sql);
        if($result) {
            $row = mysqli_fetch_assoc($result);

            if($row) {
                // Insert into the main jobseekers table
                $name = $row['name'];
                $email = $row['email'];
                $mobile = $row['seeker_pn_no'];
                $password = $row['password'];

                $insertSql = "INSERT INTO allowed_seekeer (name, email, phone_no, password) VALUES ('$name', '$email', '$mobile', '$password')";
                $insertResult = mysqli_query($con, $insertSql);

                if($insertResult) {
                    // Delete from jobseeker_reg table
                    $deleteSql = "DELETE FROM jobseeker_reg WHERE seeker_id = $id";
                    mysqli_query($con, $deleteSql);
                    header('Location: admin_page.php'); // Redirect back to admin page
                } else {
                    echo "Error inserting seeker data: " . mysqli_error($con);
                }
            } else {
                echo "Seeker not found.";
            }
        } else {
            echo "Error fetching seeker data: " . mysqli_error($con);
        }
    } elseif($type == 'recruiter') {
        // Fetch the recruiter data
        $sql = "SELECT * FROM reccreateprofile WHERE recu_id = $id";
        $result = mysqli_query($con, $sql);
        if($result) {
            $row = mysqli_fetch_assoc($result);

            if($row) {
                // Insert into the main recruiters table
                $name = $row['name'];
                $email = $row['email'];
                $mobile = $row['phone_no'];
                $password = $row['password'];

                $insertSql = "INSERT INTO orginal_table (name, email, phone_no, password) VALUES ('$name', '$email', '$mobile', '$password')";
                $insertResult = mysqli_query($con, $insertSql);

                if($insertResult) {
                    // Delete from reccreateprofile table
                    $deleteSql = "DELETE FROM reccreateprofile WHERE recu_id = $id";
                    mysqli_query($con, $deleteSql);
                    header('Location: admin_page.php'); // Redirect back to admin page
                } else {
                    echo "Error inserting recruiter data: " . mysqli_error($con);
                }
            } else {
                echo "Recruiter not found.";
            }
        } else {
            echo "Error fetching recruiter data: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid request.";
}
?>
