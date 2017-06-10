<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json; charset=UTF-8");

include("global.php");

$conn = new mysqli(server, dbuser, dbpw, db);
$userid = $_GET['userid'];
$search = $_GET['search'];

$query = "select distinct userid, currentlocation, profileimage, description from profiles where (userid like '%" . $search . "%' or description like '%" . $search . "%') and (userid <> '" . $userid . "')";
$result = $conn->query($query);

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	if ($outp != "[") {$outp .= ",";}
	$outp .= '{"userid":"'  . $rs["userid"] . '",';
	$outp .= '"currentlocation":"' . $rs["currentlocation"] . '",';
	$outp .= '"profileimage":"' . $rs["profileimage"] . '",';
	$outp .= '"description":"'   . $rs["description"]        . '"}';
}
$outp .="]";

$conn->close();

echo($outp);
?>