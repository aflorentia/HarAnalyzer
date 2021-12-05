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
    <script src="connectionCheck.js"></script>
    <script>   connectionCheck();    </script>
    <link rel="stylesheet" href="user.css">
</head>
<body data-target="#navbarResponsive">
<div id="user">
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


<section id="form" class="caption text-center offset " >
    <h1>Hello
        <?php
            session_start();
            echo $_SESSION['session_username'].'!';
        ?>
    </h1>

    <h3>Analyze your data</h3>
    <a class="btn btn-outline btn-lg" href="upload.html">Upload File</a>

</section>
<div id="contact" class="offset">
    <footer class="foot container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-lg-4">
                <div class="contactus">
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



