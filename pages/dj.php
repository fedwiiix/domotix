<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
?>
<div class="dj_container" style="overflow:hidden;">
  <iframe width="100%" height="100%" src="./dj/index.php" style="border:0;"></iframe>
</div>