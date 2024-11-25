<?php
include_once "dbconnect.php";

if(isset($_POST['data'])){
    $data=$_POST['data'];
    parse_str($data, $value);
    insert_data($con,$value);
}

function nullcheck($data){
    return isset($data) && $data !== null ? $data : '';
}

function insert_data($con, $val){
    $name = nullcheck($val['name']);
    $email = nullcheck($val['email']);
    $pass = md5(nullcheck($val['pass']));
    $title = nullcheck($val['title']);
    $description = nullcheck($val['description']);
    $area = nullcheck($val['area']);
    $city = nullcheck($val['city']);
    $skills = nullcheck($val['skills']);
    $opening = nullcheck($val['opening']);
    $date_and_time = nullcheck($val['date_and_time']);
    $hours = nullcheck($val['hours']);
    $wage = nullcheck($val['wage']);
    $sql = "INSERT INTO rec_table (Name, Email, password, Job_title, Description, Area, City, Skills, No_of_openings, date_and_time, hours, wage) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssssssss", $name, $email, $pass, $title, $description, $area, $city, $skills, $opening, $date_and_time, $hours, $wage);
    $result = $stmt->execute();

        $stmt->close();
    mysqli_close($con);
}
?>
