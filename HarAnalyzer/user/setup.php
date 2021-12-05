<?php
session_start();

if (!$_SESSION["login"]){

    header ("Location: ../home/login.html");
}


if ($_POST) {
    echo "Session Username: " . $_SESSION["session_username"] . "<br>";

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
    echo "Connected successfully<br>";

    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];
    $curPassword = $_POST['curPassword'];

    echo "New Username parsed from html  : " . $username . "<br>";
    echo "New Password parsed from html  : " . $newPassword . "<br>";
    echo "Current Password parsed from html  : " . $curPassword . "<br>";

    $result = mysqli_query($conn, "SELECT * from users WHERE username='" . $_SESSION["session_username"] . "'");
    $row = mysqli_fetch_array($result);
//printf ("%s (%s)\n", $row["email"], $row["password"]);
//echo $curPassword;
    echo "Current Password parsed from PHP  : " . $row["password"] . "<br>";


    if (!(empty($newPassword) && empty($newUsername))) {
        echo "comb works" . "<br>";
        if ($curPassword == $row["password"]) {
            echo "Passwords match" . "<br>";


            if ( !empty($newPassword) && !empty($newUsername) ) {
                mysqli_query($conn, "UPDATE users set password='" . $_POST["newPassword"] . "' WHERE username='" . $_SESSION["session_username"] . "'");
                mysqli_query($conn, "UPDATE users set username='" . $_POST["newUsername"] . "' WHERE username='" . $_SESSION["session_username"] . "'");
                $_SESSION["session_username"] = $newUsername;

//                $message1 = "Username and Password Changed";
                header('Location: setup.php?message=5', false);


            }elseif (!empty($newUsername)) {
                mysqli_query($conn, "UPDATE users set username='" . $_POST["newUsername"] . "' WHERE username='" . $_SESSION["session_username"] . "'");
                $_SESSION["session_username"] = $newUsername;

//                $message2 = "Username Changed";
//                $_SESSION["message2"] = $message2;
//            echo "<meta http-equiv='refresh' content='0'>";
                header('Location: setup.php?message=1', false);

            }elseif (!empty($newPassword)) {
            mysqli_query($conn, "UPDATE users set password='" . $_POST["newPassword"] . "' WHERE username='" . $_SESSION["session_username"] . "'");
//                $message1 = "Password Changed";
//                $_SESSION["message1"] = $message1;
//                echo "<meta http-equiv='refresh' content='0'>";
            header('Location: setup.php?message=2', false);
            }
        } else {
//            $message3 = "Current Password is not correct";
//            $_SESSION["message3"] = $message3;
            header('Location: setup.php?message=3', false);
        }


    } else {
        $_SESSION["Error"] = "You left one or more of the required fields.";
    }

//header('Location: setup.php' );
}
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
    
    <link rel="stylesheet" href="setup.css">
</head>
<body data-spy="scroll" data-target="#navbarResponsive">
<div id="cookies" class="har">
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

<section id="setup" class="offset ">
    <div class="row">
        <div class="caption">

            <form class="mainform" method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> >
                <div class="form-group ">
                    <h1>Profile Settings</h1>
                </div>
                <div class="form-group">
                    <label for="newUsername">New Username</label>
                    <input type="text" name="newUsername" placeholder="Enter New Username" id="newUsername"  class="form-control" >
                </div>

                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" name="newPassword" placeholder="Enter New Password" id="newPassword"  class="form-control">
                    <!--                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[#$*&@]).{8,}"-->
                </div>
                <div id="message">
                    <h3>Password must contain the following:</h3>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="symbol" class="invalid">A <b>character</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>

                <script>
                    var myInput = document.getElementById("password1");
                    var letter = document.getElementById("letter");
                    var capital = document.getElementById("capital");
                    var number = document.getElementById("number");
                    var symbol = document.getElementById("symbol");
                    var length = document.getElementById("length");

                    // When the user clicks on the password field, show the message box
                    myInput.onfocus = function() {
                        document.getElementById("message").style.display = "block";
                    }

                    // When the user clicks outside of the password field, hide the message box
                    myInput.onblur = function() {
                        document.getElementById("message").style.display = "none";
                    }

                    // When the user starts to type something inside the password field
                    myInput.onkeyup = function() {
                        // Validate lowercase letters
                        var lowerCaseLetters = /[a-z]/g;
                        if(myInput.value.match(lowerCaseLetters)) {
                            letter.classList.remove("invalid");
                            letter.classList.add("valid");
                        } else {
                            letter.classList.remove("valid");
                            letter.classList.add("invalid");
                        }

                        // Validate capital letters
                        var upperCaseLetters = /[A-Z]/g;
                        if(myInput.value.match(upperCaseLetters)) {
                            capital.classList.remove("invalid");
                            capital.classList.add("valid");
                        } else {
                            capital.classList.remove("valid");
                            capital.classList.add("invalid");
                        }

                        // Validate numbers
                        var numbers = /[0-9]/g;
                        if(myInput.value.match(numbers)) {
                            number.classList.remove("invalid");
                            number.classList.add("valid");
                        } else {
                            number.classList.remove("valid");
                            number.classList.add("invalid");
                        }
                        //Validate character
                        var sym = /[#$*&@!%^<>./]/g;
                        if(myInput.value.match(sym)) {
                            symbol.classList.remove("invalid");
                            symbol.classList.add("valid");
                        } else {
                            symbol.classList.remove("valid");
                            symbol.classList.add("invalid");
                        }

                        // Validate length
                        if(myInput.value.length >= 8) {
                            length.classList.remove("invalid");
                            length.classList.add("valid");
                        } else {
                            length.classList.remove("valid");
                            length.classList.add("invalid");
                        }
                    }
                </script>

                <div class="form-group">
                    <label for="curPassword">Current Password</label>
                    <input type="password" name="curPassword" placeholder="Enter Your Password" id="curPassword" required class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="submit btn btn-outline btn-lg">Update</button>
                </div>

                <div class="form-group">
                    <p>
                        <?php
                        if(!empty($_GET['message'])) {
                            if ($_GET['message'] == 1) echo "Username Changed!";
                            if ($_GET['message'] == 2) echo "Password Changed!";
                            if ($_GET['message'] == 5) echo "Username and Password Changed!";

                            if ($_GET['message'] == 3) echo "Current Password is not correct!";
                        }
//                        $temp="";
//                        if( !empty($_SESSION["Error"]) )        $temp = "Error";
//                        elseif( !empty($_SESSION["message1"]))  $temp = "message1";
//                        elseif (!empty($_SESSION["message2"]))  $temp = "message2";
//                        elseif (!empty($_SESSION["message3"]))  $temp = "message3";
//
//                        if (!empty($temp)){
//                            echo $_SESSION[$temp];
//                            unset( $_SESSION[$temp]);
//                        }
                        ?>
                    </p>
                </div>

            </form>
        </div>
    </div>
</section>


<div id="contact" class="offset">
    <footer class="foot container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-lg-4">
                <div class="contactus">
                    <br>
                    <strong>Contact Us</strong>
                    <p>Phones:<br>
                        Afentaki Florentia : +306982045579<br>
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

<?php


?>



