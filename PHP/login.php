<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json; charset=UTF-8");

error_reporting(E_ERROR);

include("global.php");

try{
    $found = 0;

    $conn = new mysqli(server, dbuser, dbpw, db);
	$userid = $_GET["userid"];
	$password = $_GET['password'];
	
	$query = "SELECT email from profiles where userid ='" . $userid . "' and password = '" . $password . "'";
        $result = $conn->query($query);

        $outp = "[";
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	    if ($outp != "[") {$outp .= ",";}
	    $outp .= '{"result":"'   . $rs["email"]        . '"}';
            $found = 1;
        }

        if ($found == 0){
            $outp .= '{"result":"0"}';
        }

        $outp .="]";

	echo $outp;
 
	$conn->close();
}
catch(Exception $e) {
	$json_out =  "[".json_encode(array("result"=>0))."]";
	echo $json_out;
}
?>