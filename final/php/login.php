<?php 
    $db_servername = "localhost";
    $db_username = "dev";
    $db_password = "P@ssw0rd";
    $db_name = "tshshell_dev";
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Create connection
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM Visitors where Email = '". $email . "' AND Password = '" . $password ."' AND Status = 1 ";
    $result = $conn->query($sql);
    $count = $result->num_rows;
    $conn->close();
    
    if ($count > 0) {
        header("location:../dashboard.php");
    } else {
        session_start();
        $_SESSION["RegState"] = 0;
        $_SESSION["Error"] = "Login failed, please try again!!!";
        header("location:../index.php");
    }
?>