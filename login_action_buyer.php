<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labourlink";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if all required POST variables are set
if (isset($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["job_title"], $_POST["password"], $_POST["phonenumber"], $_POST["address"], $_POST["dob"], $_POST["gender"], $_POST["skills"], $_POST["hourly_rate"], $_POST["work_experience"], $_POST["years_of_experience"], $_POST["location"])) {
    
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $job_title = $_POST["job_title"];
    $password = $_POST["password"]; // hash password for security
    $phonenumber = $_POST["phonenumber"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $skills = $_POST["skills"];
    $hourly_rate = $_POST["hourly_rate"];
    $work_experience = $_POST["work_experience"];
    $years_of_experience = $_POST["years_of_experience"];
    $languages_known = isset($_POST["languages_known"]) ? implode(",", $_POST["languages_known"]) : '';
    $location = $_POST["location"];

    $sql = "INSERT INTO register (fname, lname, email, job_title, password, phonenumber, address, dob, gender, skills, work_experience, year_of_experience, expected_hourly_rate, known_language, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssssssssssss", $firstname, $lastname, $email, $job_title, $password, $phonenumber, $address, $dob, $gender, $skills, $work_experience, $years_of_experience, $hourly_rate, $languages_known, $location);

        if ($stmt->execute()) {
            $_SESSION['labourlink'] = 'true';
            $_SESSION['email'] = $email;
            header("Location: seeker_home.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

}
$conn->close();
?>
