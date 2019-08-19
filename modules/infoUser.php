<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container">
  
  <div id="titre_module" >Info sur votre connection</div><br>
     <br>   
  <?php
  echo "Votre IP: $REMOTE_ADDR";
  $add = $_SERVER['REMOTE_ADDR'];
  echo $add;
	?><br><br><a href="<?php echo'http://www.localiser-IP.com/?ip='.$add; ?>" target="blanck">Votre localisation</a>
</div>