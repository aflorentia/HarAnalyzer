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
    $cache_dir = array();
    $isp = array();
    $i=1;
    while ($row = mysqli_fetch_assoc($result)) {

        $pr = mysqli_fetch_array($result);

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

//        echo $pr['Response_cache_control'];
        if (!empty($pr['Response_cache_control']) ) {

            $temp2 = $pr['Response_cache_control'];
            if (strpos($temp2, "max-age=") !== false) {
                $temp2 = explode("max", $pr['Response_cache_control'])[0];
            }

            $temp2 = explode(",", $pr['Response_cache_control']);

            $dirSize = sizeof($temp2);
//            print_r($temp2);
//            echo $dirSize;
            $cond = 0;
            while ($cond<$dirSize){
//                echo $temp2[$cond];
                if (str_contains($temp2[$cond],"public")){
//                    echo $temp2[$cond];

                    $myObjectDir = new stdClass();
                    $myObjectDir->cache_dir = "public";

                    array_push($cache_dir,$myObjectDir);

                    array_push($content_type,$myObject);
                    array_push($isp, $pr['ISP']);
                }
                elseif (str_contains($temp2[$cond],"private")){
//                    echo $temp2[$cond];

                    $myObjectDir = new stdClass();
                    $myObjectDir->cache_dir = "private";

                    array_push($cache_dir,$myObjectDir);

                    array_push($content_type,$myObject);
                    array_push($isp, $pr['ISP']);

                }elseif (str_contains($temp2[$cond],"no-cache")){
//                    echo $temp2[$cond];

                    $myObjectDir = new stdClass();
                    $myObjectDir->cache_dir = "no-cache";

                    array_push($cache_dir,$myObjectDir);

                    array_push($content_type,$myObject);
                    array_push($isp, $pr['ISP']);

                } elseif (str_contains($temp2[$cond],"no-store")){
//                    echo $temp2[$cond];

                    $myObjectDir = new stdClass();
                    $myObjectDir->cache_dir = "no-store";

                    array_push($cache_dir,$myObjectDir);

                    array_push($content_type,$myObject);
                    array_push($isp, $pr['ISP']);
                }
                $cond ++;
            }


//            $myObjectDir = new stdClass();
//            $myObjectDir->cache_dir = $temp2;
//
//            array_push($cache_dir,$myObjectDir);
//
//            array_push($content_type,$myObject);
//            array_push($isp, $pr['ISP']);

        }



    }

//    print_r($content_type);
//    echo "<br>End of Content Type modulation <br><br>";
}

//$sql = "SELECT DISTINCT harfields.Response_cache_control
//                                                FROM harfields";

//$result = mysqli_query($conn, $sql);

//$pr = mysqli_fetch_array($result);
//print_r($pr);
//echo "<br><br>";
//if (mysqli_num_rows($result) > 0) {
//
//    $cache_dir = array();
//    while ($row = mysqli_fetch_assoc($result)) {
//
//
//        $pr = mysqli_fetch_array($result);
////        print_r($pr);
////        echo "<br><br>";
//        if(strpos($pr[0], "max-age=")) {
//            $temp = explode("=", $pr[0])[1];
////        print_r($temp);
//            $temp = (int)explode(",", $temp)[0];
////            print_r($temp);
//
//            $myObject = new stdClass();
//            $myObject->max_age = $temp;
//
//            array_push($cache_dir,$myObject);
////            echo "<br>";
//        }
//        else{
////            echo "You must calculate TTL <br>";
//        }
//    }
//    print_r($cache_dir);

//echo sizeof($content_type)."<br>";
//echo sizeof($cache_dir);

//    $content_type = (array_slice($content_type,0,10));
//    print_r($content_type);

//    echo "<br><br>";
//print_r($cache_dir);
$ttlResp = array();
$ttlResp = $content_type;
//    print_r($ttlResp);
foreach ($ttlResp as $key => $object) {
//        echo $content_type[$key]->content_type;
    $object->cache_dir = $cache_dir[$key]->cache_dir;
    $object->isp = $isp[$key];

}


//    echo "<br>";
//    $cache_dir = json_encode($cache_dir);
//    echo $cache_dir;

echo json_encode($ttlResp);



