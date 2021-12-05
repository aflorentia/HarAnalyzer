<!DOCTYPE html>
<html>

<head>
    <meta  http-equiv="content-type" content="text/html; charset=utf-8"  charset="UTF-8">
    <title>JS FileReader</title>
    <!--    <script src="require.js"></script></head>-->

<body>
<section>
    <div>

        <input type="file" id="fileSelector"  multiple>
        <button type="submit" id="submit">Submit</button>
        <script src="f_reader.js" charset="utf-8" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            var kappa = 0;
            $(document).ready(function(){
                $("#submit").click(function(){
                    if (kappa === 1 ) {
                        // console.log(kappa);
                        $("#uploadButton").css("visibility", "visible");
                        $("#saveButton").css("visibility", "visible");
                        $("#upvote").css("visibility", "visible");

                    }
                });
            })

        </script>
        <div  id="optionsOfHarResults" ><br>

            <!--            <form class="form-inline pull-left" action="upload.php" method="post">-->
            <!--                <input type="submit" id="uploadButton" name="uploadButton" value="Upload" style="visibility: hidden">-->
            <button type="submit" id="saveButton" class="submit btn btn-outline btn-lg" style="visibility: hidden" >Download</button>
            <!--            </form>-->

            <button type="submit" id="uploadButton" class="submit btn btn-outline btn-lg" style="visibility: hidden" >Upload</button>
            <script src="uploadJSON.js"></script>
            <!--        <button type="submit" id="saveButton" class="submit btn btn-outline btn-lg" style="visibility: hidden" >Save Locally</button>-->
            <!--        <li class="list-inline-item">-->
            <!--            <form class="form-inline pull-right" action="" method="post">-->
            <!--                <input type="submit" id="saveButton" name="saveButton" value="Save" style="visibility: hidden">-->
            <!--            </form>-->
            <!--        </li>-->
        </div>
        <script src="downloadJSON.js" charset="UTF-8"></script>


    </div>
</section>
</body>

</html>



<?php
session_start();

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

    $response = file_get_contents('http://ip-api.com/json/?fields=city,lat,lon,isp,query');
    echo $response . "<br>";
    $object = json_decode($response);
    echo "Latitude is: " . $object->lat . "<br>";
    echo "Longitude is: " . $object->lon . "<br>";


//    header("Content-Type: application/json; charset=UTF-8");
//    $obj = json_decode($_POST["x"], false);
//    echo $obj."<br>";
    $str_json = file_get_contents('php://input');
    $finalObj = json_decode($str_json);
    var_dump($finalObj);

//    $sql = array();
//    foreach ($data as $row){
//        $sql[] = '("'.mysql_real_escape_string($row['text']). ' ", '. '.$row['
//    }
//    foreach ($finalObj as $key=>$value) {
////        Started_Date_Time, Timings_Wait, Server_IP_Address,Request_Method,Request_URL,Request_context_type,Request_cache_control,Request_pragma,Request_expires,Request_age,Request_last_modified,Request_host,Response_Status,Response_Status_Text,Response_context_type,Response_cache_control,Response_pragma,Response_expires,Response_age,Response_last_modified,Response_host
//    }

    $sql = "INSERT INTO harfields (Started_Date_Time, Timings_Wait, Server_IP_Address)
    VALUES ( '$finalObj=>Started_Date_Time' , '$finalObj=>Timing_Wait' , '$finalObj=>Server_IP_Address' )";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        //        $_SESSION['session_username'] = $_POST['username'];
        //        header('Location: login.html');


        //    $logFile = "view.log";
        //    $id = $_POST['id'];
        //    file_put_contents($logFile, $id);
        //    echo $id;

    }
}
?>




