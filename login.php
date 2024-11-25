<?php
include("connection.php");
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['mail']; // Retrieve email from form input
    $password = $_POST['pass'];
    $role = $_POST['selection'];

    // Determine the table and ID field based on the selected role
    if (!strcmp($role, "admin")) {
        $sql = "SELECT * FROM admin_reg WHERE mail = ?";
    } elseif (!strcmp($role, "seeker")) {
        $sql = "SELECT * FROM job_seekers WHERE email = ?";
    } elseif (!strcmp($role, "recruiter")) {
        $sql = "SELECT * FROM rec_reg WHERE email = ?";
    } else {
        echo "Invalid role selected.";
        exit;
    }

    // Prepare the statement
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the user is permanently banned
        if (isset($user['permanently_banned']) && $user['permanently_banned'] == 1) {
            header("Location: perm_ban.php");
            exit;
        }

        // Check if the user is temporarily banned
        if (isset($user['ban_start_date']) && strtotime($user['ban_start_date']) > time()) {
            header("Location: temp_ban.php");
            exit;
        }

        // Verify password
        if (!strcmp($password, $user['password'])) {
            // Password is correct, start session and redirect
            $_SESSION['user_id'] = $user[$role . '_id'];
            $_SESSION['user_type'] = $role;
            $_SESSION['is_admin'] = $role === 'admin' ? $user['is_admin'] : 0;

            // Set email in session
            $_SESSION['email'] = $email;

            // Handle redirection based on role
            if (!strcmp($role, "admin")) {
                header("Location: menu.html");
            } elseif (!strcmp($role, "seeker")) {
                header("Location: seeker_home.html");
            } elseif (!strcmp($role, "recruiter")) {
                header("Location: rec_home.html");
            }
        } else {
            echo "<script>alert('Incorrect password.');</script>";
            header("Location: login.html");
        }
    } else {
        echo "<script>alert('Email not found.');</script>";
        header("Location: login.html");
    }

    $stmt->close();
    $con->close();
}
?>
