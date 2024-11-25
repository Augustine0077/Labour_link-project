<?php
include_once "dbconnect.php";
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

echo $name=nullcheck($val['name']);
echo "</br>";
echo $email=nullcheck($val['email']);
echo "</br>";
echo $pass=md5(nullcheck($val['pass']));
echo "</br>";
echo $photo=nullcheck($val['photo']);
echo "</br>";
echo $address=nullcheck($val['address']);
echo "</br>";
echo $dob=nullcheck($val['dob']);
echo "</br>";
echo $cnumber=nullcheck($val['cnumber']);
echo "</br>";
echo $gender=nullcheck($val['gender']);
echo "</br>";
echo $elevel=nullcheck($val['elevel']);
echo "</br>";
echo $cname=nullcheck($val['collegename']);
echo "</br>";
echo $dname=nullcheck($val['dname']);
echo "</br>";
echo $ypassing=nullcheck($val['ypassing']);
echo "</br>";
echo $skills=nullcheck($val['skills']);
echo "</br>";
echo $experience=nullcheck($val['experience']);
echo "</br>";
echo $jrole=nullcheck($val['jrole']);
echo "</br>";
echo $rate=nullcheck($val['rate']);
echo "</br>";
echo $lang=nullcheck($val['lang']);
echo "</br>";
echo $location=nullcheck($val['location']);
echo "</br>";
 $sql = "INSERT INTO skr_table (Name, Email, password,Profile photo, Address,DOB,Contact Number,Gender,Education Level,College Name,Degree/Diploma Name,Year of passing,Skills,Experience,Job Role,Expected Hourly Rate,Known Languages,Location) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssssssssssssss", $name, $email, $pass, $photo, $address, $dob, $cnumber, $gender, $elevel, $cname, $dname, $ypassing,$skills, $experience,$jrole,$rate, $lang,$location);
    $result = $stmt->execute();

        $stmt->close();
    mysqli_close($con);
}
?>
