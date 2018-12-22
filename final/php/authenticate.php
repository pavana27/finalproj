<?php
   
$db_servername = "localhost";
$db_username = "dev";
$db_password = "P@ssw0rd";
$db_name = "tshshell_dev";

$email = $_GET['Email'];
$aCode = $_GET['Acode'];
   
$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Visitors where Email = '". $email . "' AND Acode = '" . $aCode ."' AND Status = 0 ";
$result = $conn->query($sql);
$count = $result->num_rows;
$conn->close();

if ($count > 0) {
    session_start();
    $_SESSION["RegState"] = 2;
    $_SESSION["inputEmail"] = $email;
    $_SESSION["Error"] = "";
    header("location:../index.php");
} else {
    session_start();
    $_SESSION["RegState"] = 0;
    $_SESSION["Message"] = "Email or Acode not match.";
    header("location:../index.php");
}
   
?>