<?php
// Initialize the session
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
$password = $_POST['password'];

echo "Username parsed from html  : ".$username."<br>";
echo "Password parsed from html  : ".$password."<br>";


$sql = "select * from users where username = '$username' and password = '$password'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if($count == 1){
	 if ($row["admin"] == 1) {
            echo '<script>alert("You are an Administrator");</script>';
            header('Location: ../admin/Admin.html');
     } 
	 else {
            echo "<h1><center> Login successful USER </center></h1>";
			$_SESSION['session_username'] = $_POST['username'];
			$_SESSION['session_id'] = $row["id"];
			$_SESSION['login'] = True;
			echo "Welcome <b>".$_SESSION['session_username '];
			header('Location: ../user/user.php' );
     }
	
    

}
else{
    echo "<h1> Login failed. Invalid username or password.</h1>";
//    header('Location: login.html');

}
