<?php

use PHPMailer\PHPMailer\PHPMailer;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


$db_servername = "localhost";
$db_username = "dev";
$db_password = "P@ssw0rd";
$db_name = "tshshell_dev";

$inputEmail = $_POST['inputEmail'];
$aCode = round(microtime(true) * 1000);

// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$select_sql = "SELECT * FROM Visitors where Email = '". $inputEmail . "' ";
$select_result = $conn->query($select_sql);
$count = $select_result->num_rows;

if($count > 0){
    $sql = "UPDATE Visitors SET Acode = '". $aCode ."', Password = '', Status = 0 WHERE Email = '". $inputEmail."' ";
    $result = $conn->query($sql);
    while($row = $select_result->fetch_assoc()) {
        $inputFirstName = $row["Firstname"];
        $inputLastName = $row["Lastname"];
    }
    
    $conn->close();
    
    // Send email
    
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "pavana.vmuser@gmail.com";
    $mail->Password = "vmuser@14";
    $mail->setFrom('tuj44306@temple.edu', 'Pavana Pradeep');
    $mail->addAddress($inputEmail, $inputFirstName ." ".$inputLastName);
    $mail->Subject = 'PHPMailer GMail SMTP test';
    $mail->msgHTML("Please click link to complete registration: http://localhost/final/php/authenticate.php?Email=".$inputEmail."&Acode=".$aCode."");
    
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
} else {
    $conn->close();
}
session_start();
$_SESSION["RegState"] = 0;
if ($result === TRUE) {
    $_SESSION["Message"] = "Email found. Check your inbox.";
} else {
    $_SESSION["Message"] = "Email not found. Please register.";
}
header("location:../index.php");

?>