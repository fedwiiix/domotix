<?php require ('../parametre/security.php'); 
require ("../database/databaseFunctions.php"); 

	$onglet='';                       
	if(isset( $_GET["onglet"])) { 
		$onglet=$_GET["onglet"];
	} 	
?>
<div class="big-container" >
 <?php require ('../modules/'.$onglet.'.php');	?>
</div>