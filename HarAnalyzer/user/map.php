<?php
session_start();
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



////////////////////////////////////////////////////////////////////////////////
////////////////Echo Select id from where ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//$sql = "select id from harfiles where user = $id_user ";
//$result = mysqli_query($conn, $sql);
////$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
////$count = mysqli_num_rows($result);
//
//if (mysqli_num_rows($result) > 0){
//    while($row = mysqli_fetch_assoc($result) ) {
//        echo "id: " . $row["id"]. "<br>";
//  }
//} else {
//  echo "0 results";
//}


//$ips = ['208.80.152.201', '8.8.8.8', '24.48.0.1'];
//echo gettype($ips);
//print_r($ips);
$ipsLOTS = array();
$ipsWeight = array();
//////////////////////////////////////////////////////////////////////////////
//////////////Looking for Server_IP_Address///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
$sql = "SELECT DISTINCT harfields.Server_IP_Address
FROM harfiles 
    INNER JOIN harfields on harfiles.id = harfields.id_object
WHERE harfiles.user= $id_user";

$result = mysqli_query($conn, $sql);
//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//$count = mysqli_num_rows($result);
$answer = array();
$endpoint = 'http://ip-api.com/batch?fields=lat,lon';
if (mysqli_num_rows($result) > 0){
    $i=0;
    while($row = mysqli_fetch_assoc($result) ) {
        $cond =empty($row["Server_IP_Address"]);
//        echo "Server_IP_Address: " . $row["Server_IP_Address"]. " Is Null: " .$cond. "<br>";
        if (!$cond){
            array_push($ipsLOTS,$row['Server_IP_Address']);


            $pk = $row['Server_IP_Address'];
//            echo $pk;

            $sql2 = "SELECT COUNT( harfields.Server_IP_Address) as count
            FROM harfiles 
                INNER JOIN harfields on harfiles.id = harfields.id_object 
                WHERE harfiles.user= $id_user && harfields.Server_IP_Address='". $pk ."'";


            $result2 = mysqli_query($conn, $sql2);
            $data = mysqli_fetch_array($result2, MYSQLI_ASSOC);
//            echo " Data Select ".$data['count'].'<br>';

            array_push($ipsWeight,$data['count']);


        }
//            echo $row["Server_IP_Address"];
//            $url = 'http://ip-api.com/json/'.$row["Server_IP_Address"].'?fields=lat,lon';
//            echo $url;

//            $response = file_get_contents('http://ip-api.com/json/'.$row["Server_IP_Address"].'?fields=lat,lon');
//            array_push($answer,$response);
//

        }

} else {
    echo "0 results";
}




//echo count($ipsLOTS)."<br>";
//echo "Number of ips div: ". (int)(count($ipsLOTS)/100 )."<br>";
//echo "Number of ips Rem: ".(count($ipsLOTS)%100 )."<br><br>";

$numips = count($ipsLOTS);
$numipsDiv = (int)(count($ipsLOTS)/100);
$numipsRem = count($ipsLOTS)%100;
$response = "";
for ($i=0; $i<$numipsDiv; $i++){
//    echo "i: ".$i."<br>";
    $ips = array_slice($ipsLOTS,$i*100,100);

    $options = [
        'http' => [
            'method' => 'POST',
            'user_agent' => 'Batch-Example/1.0',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($ips)
        ]
    ];

    $tempResp = file_get_contents($endpoint, false, stream_context_create($options));
    $tempResp = json_decode($tempResp);

    if ($i==0) {
        $response = $tempResp;
    }
    else{
        $response = array_merge($response,$tempResp);
//        $response= $response . ','. $tempResp;
    }
//    print_r($response);
//    echo "<br>";
//    echo $response."<br>";
//    echo "<br>";
//    echo json_encode($response);

}

//echo "i ".$i."<br>";
if ($numipsRem) {

    $ips = array_slice($ipsLOTS, $i * 100, $numipsRem);
    $options = [
        'http' => [
            'method' => 'POST',
            'user_agent' => 'Batch-Example/1.0',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($ips)
        ]
    ];
//    print_r( $ips);
    $remainingResp = file_get_contents($endpoint, false, stream_context_create($options));
    $remainingResp = json_decode($remainingResp);
//    echo "Remainding: " . $remainingResp . "<br>";

//echo gettype($remainingResp);
//    $response = $response . ',' . $remainingResp;
    if ($i!=0)
    $response = array_merge($response , $remainingResp);
    else
        $response = $remainingResp;

}
//$response = array_merge($response,$tempResp);
//print_r($response);
//echo "<br>";

foreach ($response as $key => $object) {
    $object->weight = (int)$ipsWeight[$key];
//    echo $key ." : ". $object->weight."<br>";
}

//echo "<br>";
echo json_encode($response);
//echo "<br>";
//echo json_encode($ipsWeight);
//echo "<br>";

//print_r( json_decode($jsonblue));



//echo gettype($ips);
//print_r($ips);


//echo gettype($response ). "<br><br>";

//print_r($answer);

//echo $answer;
//echo gettype($answer ). "<br><br>";

//$answer2 = implode(",",$answer);

//echo "2 answer";
//echo $answer2;
//echo gettype($answer2);
//
//echo "<br><br>";

//$object = json_decode($answer2);
//echo "decode";
//echo $object;
//
//echo "<br><br>";
//
//$object = json_encode($answer2);
//echo "encode";
//echo $object;

// 69.171.250.35
//echo json_encode($username_user);

?>

