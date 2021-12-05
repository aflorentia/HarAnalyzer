<?php
session_start();
if (!$_SESSION["login"]){

    header ("Location: ../home/login.html");
}


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
   //echo "Connected successfully<br>";

// QUERY 1
$sql = "SELECT COUNT(id) AS usersCount FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row['usersCount']);

//QUERY 2
$sql2 = "SELECT Request_Method,COUNT(*) AS request FROM harfields GROUP BY Request_Method ";
$result2 = $conn->query($sql2);

$res2 = array();
while($row2 = mysqli_fetch_row($result2)) {
    $res2[]= array ("Request_Method" =>$row2[0],"Number_of_Requests" =>$row2[1]);   
}

//QUERY 3
$sql3 = "SELECT Response_Status, COUNT(*) AS status3 FROM harfields GROUP BY Response_Status ";
$result3 = $conn->query($sql3);


$res3 = array();
while($row3 = mysqli_fetch_row($result3)) {
    $res3[]= array ("Response_Status" =>$row3[0],"Number_of_Responses" =>$row3[1]);   
}

//QUERY 4
$sql4 = "SELECT COUNT( DISTINCT Request_URL) AS domain FROM harfields ";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();


$sql41 = "SELECT DISTINCT Request_URL ,COUNT(Request_URL) AS domain FROM harfields GROUP BY Request_URL ";
$result41 = $conn->query($sql41);

$res4 = array();
while($row41 = mysqli_fetch_row($result41)) {
    $res4[]= array ("Request_URL"=>$row41[0],"Number_of_times_of_Requested_URL" =>$row41[1]);   
}

//QUERY 5
$sql5 = "SELECT COUNT( DISTINCT ISP) AS isps FROM harfiles ";
$result5 = $conn->query($sql5);
$row5 = $result5->fetch_assoc();
//var_dump($row5['domain']);

$sql51 = "SELECT DISTINCT ISP ,COUNT(ISP) AS isps FROM harfiles GROUP BY ISP ";
$result51 = $conn->query($sql51);

$res5 = array();
while($row51 = mysqli_fetch_row($result51)) {
    $res5[]= array ("ISP"=>$row51[0],"Number_of_times_of_ISP" =>$row51[1]); 

}


//QUERY 6
$sql6 = "SELECT Response_context_type,AVG(Response_age) AS age FROM harfields GROUP BY Response_context_type ";
$result6 = $conn->query($sql6);

$res6 = array();
while($row6 = mysqli_fetch_row($result6)) {
    $res6[]= array ("Content_Type"=>$row6[0],"Average_Age" =>$row6[1]); 

}



$conn->close();
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
    <link rel="stylesheet" href="getAdminData.css"
</head>

<body>
<div id="adminData" class="data">
   <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid ">
            <a class="navbar-brand" href="admin.html"><img src="logo.png"></a>
            <div class="title">
                <div>Har Analyzer</div>
            </div>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="admin.html" class="nav-link">Home</a>
                    </li>

                    <li class="nav-item hid" >
                        <a href="getAdminData.php" class="nav-link">  User's Statistics </a>
                    </li>
					
					<li class="nav-item hid" >
                        <a href="visualizeDataAdmin.html" class="nav-link"> Visualize Data </a>
                    </li>

                    <li class="nav-item hid" >
                        <a href="timeAnalysis.php" class="nav-link"> Time Analysis </a>
                    </li>
					<li class="nav-item hid" >
                        <a href="headersAnalyze.html" class="nav-link"> Analyze Headers </a>
                    </li>
					
                    <li class="nav-item hid" >
                        <a href="logout.php" class="nav-link">Log Out</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    
</div>
<section class='flex-center admin-data'>
    <div class="row section-background form-group">
        <div class="col-md-12">
            <h1>Data</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Number of Users</th>
                    </tr>
                <tbody>
                    <tr>
                        <td><?=$row['usersCount']?></td>
                    </tr>
                </tbody>
            </table>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Request Method</th>
                        <th>Number Of Requests</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($res2 as $r){ ?>
                            <tr>
                                <td><?=$r["Request_Method"]?></td>
                                <td><?=$r["Number_of_Requests"]?></td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Response Status</th>
                        <th>Number Of Responses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($res3 as $r){ ?>
                            <tr>
                                <td><?=$r["Response_Status"]?></td>
                                <td><?=$r["Number_of_Responses"]?></td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Number of Domains</th>
                    </tr>
                <tbody>
                    <tr>
                        <td><?=$row4['domain']?></td>
                    </tr>
                </tbody>
            </table>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Number of Domain</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($res4 as $r){ ?>
                        <tr>
                            <td><?=$r["Request_URL"]?></td>
                            <td><?=$r["Number_of_times_of_Requested_URL"]?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
    
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Number of IPSs</th>
                    </tr>
                <tbody>
                    <tr>
                        <td><?=$row5['isps']?></td>
                    </tr>
                </tbody>
            </table>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ISP</th>
                        <th>Number of ISPs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($res5 as $r){ ?>
                        <tr>
                            <td><?=$r["ISP"]?></td>
                            <td><?=$r["Number_of_times_of_ISP"]?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Content Type</th>
                        <th>Average Age</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($res6 as $r){ ?>
                        <tr>
                            <td><?=$r["Content_Type"]?></td>
                            <td><?=$r["Average_Age"]?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
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
                    <a href="cookiesa.html" class="cookies"><strong>Cookies</strong></a>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-4 text-right">
                <div class="privacy">
                    <br>
                    <br>
                    <br>
                    <a href="termsa.html" class="privacy"><strong>Terms &amp; Conditions</strong></a>
                </div>
            </div>
        </div>
        
        <hr class="socket col-md-12 col-sm-12 col-lg-12">
        &copy FEA Developers.

    </footer>
    </div>

</body>
</html>