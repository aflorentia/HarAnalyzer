<!DOCTYPE html>
<html> 
<head>
    <meta charset="UTF-8">
</head>
 <body>



<?php

    session_start();


$servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname="haranalyzer";


    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully<br>";

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pswRepeat = $_POST['pswRepeat'];

    echo "Username parsed from html  : ".$username."<br>";
    echo "email parsed from html  : ".$email."<br>";
    echo "Password parsed from html  : ".$password."<br>";
    echo "Password Repeat parsed from html  : ".$pswRepeat."<br>";

    $sql = "INSERT INTO users (username, password, email)
    VALUES ( '$username' , '$password' , '$email' )";

    if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    $_SESSION['session_username'] = $_POST['username'];
    header('Location: login.html');

    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//    header('Location: signup.html');

    }

    mysqli_close($conn);




?>


</body>
</html>