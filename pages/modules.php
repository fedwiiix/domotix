<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
require ("../database/databaseFunctions.php"); 

$modules = $_SESSION["droit_module"]; 
switch ($_SESSION['droit']) {								//droit pour afficher les modules selon le type d'user 
  case 3:
    $place="place_administrateur";
    break;
  case 2:
    $place="place_resident";
    break;
  case 1:
    $place="place_app";
    break;
}
?>
<div class="big-container" id="modulePage">
  <?php 
  for($e=1; $e<9; $e++){
    foreach ($modules as $module) { 		
      if ($module[$place]=='2.'.$e)
          require ('../modules/'.$module['nom_module'].'.php');
    }
  } ?>
</div>