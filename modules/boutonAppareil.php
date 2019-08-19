<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container" align="center">
  <div id="titre_module" onclick="/*lancer_onglet('configuration','appareil')*/">Appareils</div><br><br><br>
 
  <?php  $appareils = afficher_database_table('appareils');
  
  foreach ($appareils as $appareil) {

    if($appareil['afficher']=="true"){

      $nom = explode("/", $appareil['nom_bouton']);
      $cmd = explode("/", $appareil['code_radio']);
      $id_appareil = $appareil['id_appareil'];

      echo '<div class="module_appareils" align="right"><span>'.$appareil['nom'].'</span>';

      if(sizeof($nom)>2){        // 4 boutons
        for($i=0;$i<sizeof($nom);$i++){
          if($i==1){
            echo '<button style="border-radius: 0 28px 0 0; width:20%; width:20%;" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
          }else if($i==sizeof($nom)-1){
            echo '<button style="border-radius: 0 0 28px 0; width:20%;" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
          }else{
            echo '<button style="border-radius: 0; width:20%;" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
          }
          if($i%2){
            echo '<br>';
          }
        }
      }else{
        for($i=0;$i<sizeof($nom);$i++){
          if(sizeof($nom)==1){
            echo '<button style="width:40%; border-radius: 0 28px 28px 0" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
          }else if($i==0){
            echo '<button style="border-radius:  0 ; width:20%;" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
          }else if($i==sizeof($nom)-1){
            echo '<button style="border-radius: 0 28px 28px 0; width:20%;" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
          }
        }
      } 
      echo '</div>';
    } 
  } ?>
<br><br>
</div>

<script type="text/javascript">
																		
function bp_appareil(appareil,etat,mode){ // on off buttons functions

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {	
			result = JSON.parse(this.responseText).result;
			if(result!= "" || result!= "error"){

				var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
        //if ( this.status == 200) {
          afficherMessage('Action effectuée')
        } //}
				xhr.open('GET', result,true);
				xhr.send();
			}else{
				afficherMessage("Une erreur s'est produite.")
			}
		}
	};
	xmlhttp.open("GET", "./api/action.php?action=appareil&etat="+etat+"&mode="+mode+"&id="+appareil, true);
	xmlhttp.send();
}

</script>


