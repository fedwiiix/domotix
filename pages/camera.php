<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
require ("../database/databaseFunctions.php");

$onglet = 'camera';
if(!isset( $_GET["onglet"])) // la variable existe
{
?>
<div id="volet" align="center" >
  <li class="mv-item"><a onclick="afficherOngletPpage('camera', 'camera')">Caméra</a></li>
  <li class="mv-item"><a onclick="afficherOngletPpage('camera', 'captures')">Captures</a></li>
</div>
<div class="big-container">
  <div id="onglet_affichage" align="center" style="height:100%; width:85%; margin-left:15%; overflow-y: scroll;"></div>
</div>

<!-- ******************************************************************************************************************************************************************** -->

<script type="text/javascript">
	afficherOngletPpage('camera', 'camera')
</script>

<?php }else{

  $onglet = $_GET["onglet"]; 
  $ip = $_SESSION['ip_raspberry']; // remove port
  $ini =parse_ini_file( getcwd()."/../parametre/server.ini"); // get camera pass
  $cameraPass=$ini["cameraPass"];
?>

<?php if($onglet=='camera'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	?>
  <div id="titre_pages">Caméra de surveillance</div><br><br>		<!-- titre -->
    	
	<iframe class="tour_camera" runat="server" frameborder=0 name="cam" target="target" src="http://<?php echo $ip; ?>:8081/?action=stream&<?php echo $cameraPass; ?>" ></iframe>
	<div class="bp_camera">
		<img class="fleche_camera" onclick="action_camera('cam_haut');" src="img/haut.png" />
		<br>
		<img class="fleche_camera" onclick="action_camera('cam_gauche');" src="img/appImg/gche.png" />
		<img class="fleche_camera" onclick="action_camera('cam_milieu');" src="img/appImg/mill.png" />
		<img class="fleche_camera" onclick="action_camera('cam_droite');" src="img/appImg/drte.png" />
		<br>
		<img class="fleche_camera" onclick="action_camera('cam_bas');" src="img/appImg/bas.png"/>
		<br>
		<img class="camera" onclick="action_camera('cam_on');" src="img/appImg/on.png"  />
		<img class="camera" onclick="action_camera('cam_off');" src="img/appImg/off.png"  />
		<img class="camera" onclick="action_camera('travelling_cam');" src="img/appImg/travelling.png"/>
	</div>

<?php } else if($onglet=='captures'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	
	
	<div id="titre_pages">Captures</div><br><br>		<!-- titre -->		
	<iframe class="block" style="height:80%;" src="http://<?php echo $ip; ?>:8080/captures?pass=2gBDun342nDK6xXd4a4WR45Xz" ></iframe>
	 
<?php } /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	
<script>

function action_camera(action){ // on / off cam

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {	
    result = JSON.parse(this.responseText).result;
    if(result!= "" || result!= "error"){
      var xhr = new XMLHttpRequest();
      xhr.open('GET', result,true);
      xhr.send();
    }else{
      alert("Une erreur s'est produite.")
    }
  }
  };
  xmlhttp.open("GET", "./api/action.php?action="+action, true);
  xmlhttp.send();
}
  
</script>

<?php } ?>