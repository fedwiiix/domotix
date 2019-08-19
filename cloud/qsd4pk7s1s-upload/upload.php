<?php
require ('../../parametre/security.php'); 
$directory = $_SESSION["cloudDir"].$_SESSION['upload_directory'];
if (strpos($directory, '../'))  // check good path
  die('{"status":"error"}');

$allowed = array('png', 'jpg', 'gif','zip','', 'pdf', 'mp4', 'avi','ma4', 'mp3', 'wma', 'docx','xlsx','odt','txt','css','js','html','php','c','py','sql');  // A list of permitted file extensions

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);  // check ext
	/*if(!in_array(strtolower($extension), $allowed))
		die('{"status":"error"}');*/

	if(move_uploaded_file($_FILES['upl']['tmp_name'], $directory.'/'.$_FILES['upl']['name']))
		die( '{"status":"success"}');
}
die('{"status":"error"}');
