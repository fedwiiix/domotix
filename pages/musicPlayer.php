<?php 
require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
require ('../musicPlayer/musicPlayer.php');
?>