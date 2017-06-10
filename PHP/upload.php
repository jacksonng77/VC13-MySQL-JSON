<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json; charset=UTF-8");

include("global.php");

try{
	$filename = tempnam('images', '');
	$new_image_name = basename(preg_replace('"\.tmp$"', '.jpg', $filename));
	unlink($filename);
	
	//print_r($_FILES);
	move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $new_image_name);	
	
	make_thumb("images/" .$new_image_name, "images/" .$new_image_name . "_s", 100);
	
	$json_out = "[" . json_encode(array("result"=>$new_image_name)) . "]";
	echo $json_out;
}
catch(Exception $e) {
	$json_out =  "[".json_encode(array("result"=>0))."]";
	echo $json_out;
}
?>