<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json; charset=UTF-8");

//return 1 for successful deletion
//return 0 for failed deletion
error_reporting(E_ERROR);

try{
	$imgfile = $_GET["imgfile"];
	unlink("images/" . $imgfile);
	unlink("images/" . $imgfile . "_s");
		
	$json_out =  "[".json_encode(array("result"=>1))."]";
	echo $json_out;
}
catch(Exception $e) {
	$json_out =  "[".json_encode(array("result"=>0))."]";
	echo $json_out;
}
?>