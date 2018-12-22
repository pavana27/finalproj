<?php

$db_servername = "localhost";
$db_username = "dev";
$db_password = "P@ssw0rd";
$db_name = "tshshell_dev";

$email=$_POST['email'];
$password = $_POST['inputPassword'];

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "update Visitors set  Password = '". $password ."', RdateTime = '".date("Y-m-d H:i:s")."', Status = 1, Acode = NULL where Email = '".$email."'";
$result = $conn->query($sql);
$conn->close();

echo $result;

if($result){
    session_start();
    $_SESSION["RegState"] = 5;
    header("location:../dashboard.php");
} else {
    session_start();
    $_SESSION["RegState"] = 2;
    $_SESSION["Error"] = "Email or Acode not match.";
    header("location:../index.php");
}
    
?>