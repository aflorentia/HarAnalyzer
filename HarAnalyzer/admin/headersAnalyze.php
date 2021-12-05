<?php
session_start();
//if ($_POST) {

//    echo "Session Username: " . $_SESSION["session_username"] . "<br>";
//    echo "Session Id: " . $_SESSION['session_id'] . '<br><br>';

//$username_user = $_SESSION["session_username"] ;
//$id_user = $_SESSION['session_id'];

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

///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT harfields.Response_context_type, harfields.Response_cache_control , harfiles.ISP
                                                FROM harfields  INNER JOIN harfiles  on harfields.id_object = harfiles.id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $content_type = array();
    $max_age = array();
    $isp = array();
    $i=1;
    while ($row = mysqli_fetch_assoc($result)) {

        $pr = mysqli_fetch_array($result);

        if (!empty($pr['ISP'])){


            if (empty($pr['Response_context_type'])){
                $temp = "others";
            }
            elseif(strpos($pr['Response_context_type'],'image')!==false) {
                $temp = "image";
            }elseif (strpos($pr['Response_context_type'],"font")!==false){
                $temp = "font";
            }

            else {
                $path = substr(strrchr($pr['Response_context_type'], "/"), 1);
                $temp = explode(";", $path )[0]; // "index.html"

                if (strpos($temp,"-")!==false){     // x-javascript
                    $temp = explode("-", $temp)[1];
                }
            }

            $myObject = new stdClass();
            $myObject->content_type = $temp;
            array_push($content_type,$myObject);

            if (!empty($pr['Response_cache_control']) ) {

                if (strpos($pr['Response_cache_control'], "max-age=") !== false) {

                    $temp2 = explode("=", $pr['Response_cache_control'])[1];
                    //            print_r($temp);
                    $temp2 = (int)explode(",", $temp2)[0];
                    //            print_r($temp);


                } else {
                    //            echo "You must calculate TTL <br>";
                    $temp2 = 0;
                }
            }else
                $temp2=0;

            $myObject = new stdClass();
            $myObject->max_age = $temp2;

            array_push($max_age,$myObject);
//            echo "<br>";

            array_push($isp, $pr['ISP']);

        }
    }
}
$ttlResp = array();
$ttlResp = $content_type;
//    print_r($ttlResp);

foreach ($ttlResp as $key => $object) {
    $object->max_age = $max_age[$key]->max_age;
    $object->isp = $isp[$key];

}


//    echo "<br>";
//    $max_age = json_encode($max_age);
//    echo $max_age;

echo json_encode($ttlResp);



