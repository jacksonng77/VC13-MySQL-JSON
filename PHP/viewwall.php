<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json; charset=UTF-8");

include("global.php");

$conn = new mysqli(server, dbuser, dbpw, db);

$userid = $_GET['userid'];
$relationshipid = $_GET['relationshipid'];
$view = $_GET['view'];

if ($view == "me"){
	$query = "select wallpostid, userid, timeofposting, message from mywall where userid = '" . $userid . "' order by timeofposting DESC";
}
else{

	if ($relationshipid == ""){
		$query = "select wallpostid, userid, timeofposting, message from mywall where userid IN (select friendid from myfriends where userid = '". $userid . "') order by timeofposting DESC";
	}
	else {
		$query = "select wallpostid, userid, timeofposting, message from mywall where userid IN (select friendid from myfriends where userid = '" . $userid . "' and relationshipid = " . $relationshipid . ") order by timeofposting DESC";
	}
}
$result = $conn->query($query);

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	if ($outp != "[") {$outp .= ",";}
	$outp .= '{"wallpostid":"'  . $rs["wallpostid"] . '",';
	$outp .= '"userid":"' . $rs["userid"] . '",';
	$outp .= '"timeofposting":"' . $rs["timeofposting"] . '",';
	$outp .= '"message":"'   . $rs["message"]        . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>