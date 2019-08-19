<?php 

setcookie('pseudo', '', time() -3600, '/domotix/', null, true, false); // remove coockies
setcookie('password', '', time() -3600, '/domotix/', null, true, false);

session_start();    // remove session var
$_SESSION = array();
session_destroy();

header('Location: ../index.php');  
?>