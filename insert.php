<?php
include_once "connection.php";
if(isset($_POST['data'])){
$data=$_POST['data'];
  parse_str($data, $value);
  insert_data($con,$value);
}
function nullcheck($data){
if(isset($data) && $data!=null){
return $data;
}else{
return '';
}

}

function insert_data($con,$val){

echo $name=nullcheck($val['uname']);
echo "</br>";
echo $email=nullcheck($val['email']);
echo "</br>";
echo $pwd=md5(nullcheck($val['pass']));
echo "</br>";
echo $cnumber=nullcheck($val['cno']);
echo "</br>";
echo $uphoto=nullcheck($val['uphoto']);
echo "</br>";
echo $address=nullcheck($val['address']);
echo "</br>";
echo $gender=nullcheck($val['gender']);
echo "</br>";
echo $dob=nullcheck($val['dob']);
echo "</br>";
echo $elevel=nullcheck($val['elevel']);
echo "</br>";
echo $cname=nullcheck($val['cname']);
echo "</br>";
echo $dname=nullcheck($val['dname']);
echo "</br>";
echo $ypassing=nullcheck($val['ypassing']);
echo "</br>";
echo $skills=nullcheck($val['skills']);
echo "</br>";
echo $wexperience=nullcheck($val['wexperience']);
echo "</br>";
echo $jdescription=nullcheck($val['jdescription']);
echo "</br>";
echo $yexperience=nullcheck($val['eyears']);
echo "</br>";
echo $ehrate=nullcheck($val['ehrate']);
echo "</br>";
echo $klang=nullcheck($val['klang']);
echo "</br>";
echo $location=nullcheck($val['location']);
echo "</br>";
$sql = "INSERT INTO user_tbl(name,email,upassword,address,gender,dob,educational_level,contact_number,profile_photo,degree_name,year_of_passing,skills,work_experience,job_description,year_of_experience,expected_hourly_rate,known_language,location) 
VALUES ('$name','$email','$pwd','$address','$gender','$dob','$elevel','$cnumber','$uphoto','$dname','$ypassing','$skills','$wexperience','$jdescription','$yexperience','$ehrate','$klang','$location')";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssssbssssssss", $name, $email, $pwd, $address, $gender, $dob, $elevel, $cnumber, $uphoto, $dname, $ypassing, $skills, $wexperience, $jdescription, $yexperience, $ehrate, $klang, $location);

    $result = $stmt->execute();
echo $result;
if($result){
  header("location:success.php");
}
//mysqli_query($con,"INSERT INTO user_tbl (FirstName,LastName,email,upassword,phone_number,address,twitter,facebook,googleplus,date) 
//VALUES ('$fname','$lname','$email','$pwd','$number','$address','$twitter','$fbook','$gplus','$date')");
mysqli_close($con);
}
?>