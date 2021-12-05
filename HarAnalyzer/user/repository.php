<?php
session_start();

if (!$_SESSION["login"]){

    header ("Location: ../home/login.html");
}
//if ($_POST) {

//    echo "Session Username: " . $_SESSION["session_username"] . "<br>";
//    echo "Session Id: " . $_SESSION['session_id'] . '<br><br>';

    $username_user = $_SESSION["session_username"] ;
    $id_user = $_SESSION['session_id'];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "haranalyzer";


// Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
//    echo "Connected successfully<br>";


//////////////////////////////////////////////////////////////////////////////
//////////////Last upload's Date//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
    $sql = "select COUNT(*) as 'inTotal' from harfiles where user = $id_user ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $inTotal = $row['inTotal'];
//        echo $noFiles;
    }
    else {
        $inTotal = 0;
    }

//////////////////////////////////////////////////////////////////////////////
//////////////Uploads in Total//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
$sql = "select MAX(uploadDate) as 'max_uploadDate' from harfiles where user = $id_user ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if($count == 1) {
    $max_uploadDate = $row['max_uploadDate'];
//        echo $noFiles;
}
else {
    $max_uploadDate = "You haven't upload anything yet!";
}

//}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Har Analyzer</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fixed.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    
    <link rel="stylesheet" href="aboutHARu.css">
</head>
<body data-spy="scroll" data-target="#navbarResponsive">


<div id="repos">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid ">
        <a class="navbar-brand" href="user.php"><img src="logo.png"></a>
            <div class="title">
                <div>Har Analyzer</div>
            </div>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="user.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="aboutHARu.html" class="nav-link">More About Har</a>
                    </li>
                    <li class="nav-item">
                        <a href="aboutusu.html" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="map.html" class="nav-link">Visualize</a>
                    </li>
                    <li class="nav-item hid" >
                        <a href="upload.html" class="nav-link">Upload File</a>
                    </li>
                    <li class="nav-item hid" >
                        <a href="repository.php" class="nav-link"> My Repository</a>
                    </li>
                    <li class="nav-item hid" >
                        <a href="logout.php" class="nav-link">Log Out</a>
                    </li>
                    <li class="nav-item hid">
                        <a href="setup.php" class="nav-link"><img src="u1.jpg"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="landing">
        <div class="home-wrap">
            <div class="home-inner"></div>
        </div>
    </div>

</div>


<section id="repository" class="offset ">
    <div class="row">
        <div class="caption">
            <h1>Profile Page</h1>
            <div>
                <p>Your account details are below:</p>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><?php echo $username_user ; ?></td>
                    </tr>
                    <tr>
                        <td>Last Upload:</td>
                        <td><?php echo $max_uploadDate; ?></td>
                    </tr>
                    <tr>
                        <td>Uploads in Total:</td>
                        <td><?php echo $inTotal; ?></td>
                    </tr>
                </table>
            </div>


        </div>
    </div>
</section>

<div class="landing"><
    <div class="home-wrap">
        <div class="home-inner"></div>
    </div>
</div>






<div id="contact" class="offset">
    <footer class="foot container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-lg-4">
                <div class="contactus">
                    <br>
                    <strong>Contact Us</strong>
                    <p>Phones:<br>
                        Afentaki Florentia : +306981045579<br>
                        Oikonomopoulou Emma : +306988452227<br>
                        Sigourou Alkisti : +306975469110<br>
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-4 text-center">
                <div class="cookies">
                    <br>
                    <br>
                    <br>
                    <a href="cookiesu.html" class="cookies"><strong>Cookies</strong></a>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-4 text-right">
                <div class="privacy">
                    <br>
                    <br>
                    <br>
                    <a href="termsu.html" class="privacy"><strong>Terms &amp; Conditions</strong></a>
                </div>
            </div>
        </div>

        <hr class="socket col-md-12 col-sm-12 col-lg-12">
        &copy FEA Developers.

    </footer>
</div>

</body>
</html>