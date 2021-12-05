<?php
session_start();

//if ($_POST) {
    echo "Session Username: " . $_SESSION["session_username"] . "<br>";
    echo "Session Id: " . $_SESSION['session_id'].'<br><br>';
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
    echo "Connected successfully<br>";


//    $b = $_SESSION["session_username"];
//    $sql = "select id from users where username = '$b' ";
//    $result = mysqli_query($conn, $sql);
//    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//    $count = mysqli_num_rows($result);
//
//    if($count == 1) {
////        echo "<h1><center> Login successful </center></h1>";
//        $_SESSION['session_id'] = $row["id"];
//    }
//echo "Session Username: " . $_SESSION['session_id'].'<br><br>';
//$id_user = $_SESSION['session_id'];


//////////////////////////////////////////////////////////////////////////////
//////////////Looking for id_object///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
    $sql = "select MAX(noFiles) as 'max_noFiles' from harfiles where user = $id_user ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $noFiles = $row['max_noFiles']+1;
        echo $noFiles;
    }
    else {
        $noFiles = 1;
    }


//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////Parse JSON file from JS////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
//    header("Content-Type: application/json; charset=UTF-8");
//    $obj = json_decode($_POST["x"], false);
//    echo $obj."<br>";

    $str_json = file_get_contents('php://input');
    $finalObj = json_decode($str_json,true);
//    Check how many entries you Will have => harFiles Table
    echo "final Obj";
    print_r($finalObj);

    $entries = count($finalObj);
    echo "Entries of this file: ".$entries."<br>";


//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Use Ip-Api        ///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
    $response = file_get_contents('http://ip-api.com/json/?fields=city,lat,lon,isp,query');
    echo $response . "<br><br>";
    $object = json_decode($response);
//    echo "Latitude is: " . gettype($object->lat) . "<br>";
//    echo "Longitude is: " . $object->lon . "<br>";

    echo "ISP is: " . explode(" ",$object->isp)[0] . "<br>";




    $sql = "INSERT INTO harfiles ( user, noFiles, name, entries, uploadDate ,IP, ISP , latitude , longitude)
        VALUES ( '$id_user' ,'$noFiles','','$entries', NOW() , '$object->query' , '$object->isp', '$object->lat', '$object->lon' )";

    mysqli_query($conn, $sql) or die(mysqli_error($conn)) ;











//////////////////////////////////////////////////////////////////////////////
//////////////Looking for id_object///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
    $sql = "select MAX(id) as 'max' from harfiles where user = $id_user ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count == 1) {
            $id_object = $row['max'];
        }

//////////////////////////////////////////////////////////////////////////////
//////////////Insert into HarFields Table///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
    foreach ($finalObj as $entry){
//        echo $entry["Timings_Wait"]."<br>";
        $STD = $entry["Started_Date_Time"];
        $TW = $entry["Timings_Wait"];
        $SIPA = $entry["Server_IP_Address"];
        $RM = $entry["Request_Method"];
        $RURL = $entry["Request_URL"];
        $Qct = $entry["Request_content_type"];
        $Qcc = $entry["Request_cache_control"];
        $Qp = $entry["Request_pragma"];
        $Qe = $entry["Request_expires"];
        $Qa = $entry["Request_age"];
        $Qlm = $entry["Request_last_modified"];
        $Qh = $entry["Request_host"];
        $RS = $entry["Response_Status"];
        $RST = $entry["Response_Status_Text"];
        $Sct = $entry["Response_content_type"];
        $Scc = $entry["Response_cache_control"];
        $Sp = $entry["Response_pragma"];
        $Se = $entry["Response_expires"];
        $Sa = $entry["Response_age"];
        $Slm = $entry["Response_last_modified"];
        $Sh = $entry["Response_host"];

        $sql = "INSERT INTO harfields ( id_har, id_object, Started_Date_Time, Timings_Wait, Server_IP_Address, Request_Method, Request_URL,
                       Request_context_type, Request_cache_control, Request_pragma, Request_expires, Request_age, Request_last_modified,
                       Request_host, Response_Status, Response_Status_Text, Response_context_type, Response_cache_control, Response_pragma,
                       Response_expires, Response_age, Response_last_modified, Response_host )
        VALUES ( '', '$id_object', '$STD', '$TW' , '$SIPA', '$RM', '$RURL', '$Qct', '$Qcc', '$Qp', '$Qe', '$Qa', '$Qlm', '$Qh', '$RS', '$RST', '$Sct', '$Scc', '$Sp', '$Se', '$Sa', '$Slm', '$Sh' )";

        mysqli_query($conn, $sql) or die(mysqli_error($conn)) ;

    }







//    }
//}
