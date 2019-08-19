<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>    
<div class="doubleContainer">

  <div class="container">
    <div id="titre_module" onclick="lancer_onglet('music_player','');" >Music</div><br>
    <br><span id="action"></span><br>
    <button type="button" style="border-radius: 28px 0 0 28px; padding-top:8px;" onclick="music_player('Play')"> <img src="img/appImg/play_icon.png" width="30"/></button>	
    <button type="button" style="border-radius: 0 0 0 0; padding-top:8px;" onclick="music_player('Previous')"> <img src="img/appImg/previous_icon.png" width="30"/></button>
    <button type="button" style="border-radius: 0 0 0 0; padding-top:8px;" onclick="music_player('Pause')"> <img src="img/appImg/pause_icon.png" width="30"/></button>
    <button type="button" style="border-radius: 0 0 0 0; padding-top:8px;" onclick="music_player('Next')"> <img src="img/appImg/next_icon.png" width="30"/></button>
    <button type="button" style="border-radius: 0 28px 28px 0; padding-top:8px;" onclick="music_player('Stop')"> <img src="img/appImg/stop_icon.png" width="30"/></button>
    <br><span id="genre">Playlist</span>
    <div style="height:40px; width: 200px; margin:auto; margin-top:0px;">
    <button type="button" onclick="music_player('decreasevolume')" style="float:left; padding:8px 9px 5px 9px;"> <img src="img/appImg/moins.png" height="20"/></button>  
    <button type="button" onclick="music_player('increasevolume')" style="float:right; padding:8px 9px 5px 9px;"> <img src="img/appImg/plus.png" height="20"/></button>
    </div>
    <br><br><br>
    <?php
    $initial_directory = $_SESSION["cloudDir"].$_SESSION["cloudMusicDir"]."/";
    $dir = scandir($initial_directory) or die($initial_directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
    foreach ($dir as $element) {   
      if($element != '.' && $element != '..') {
        if (is_dir($initial_directory.'/'.$element)) {
          ?><li class="mv-item"><a onclick="music_player('<?php echo 'playlist_'.$element ?>')"><?php echo $element ?></a></li><?php
        }
      }
    } ?>
  <br><br>
  </div>
  
<div class="container" style="position:absolute; bottom:0; ">
	<div id="titre_module" onclick="lancer_onglet('chauffage');">Gestion</div><br><br>
	
	<span id="date_heure" ></span><br><br>
	  <!-- __________________coté température________________________________________________________________________________  -->
	  <?php $temps = afficher_database_table("suivi_temperature");
  				$hour = (date(N) -1) *24 + date(H)+1;  
				  foreach ($temps as $temp) { 
					if ($temp['id_chauffage'] == $hour ){
						$temp = $temp['temperature_chauffage'];
						//On définit les variables d'affichage dans la condition suivante en y affichant la température
					 $froid = '<span class="temp_froid">'. $temp .'</span> °c';
					 $ok = '<span class="temp_ok">'. $temp .'</span> °c';
					 $bof = '<span class="temp_bof">'. $temp .'</span> °c';
					 $wrong = '<span class="temp_wrong">'. $temp .'</span> °c';
					 //Si la température < 65°C alors on affiche en vert, sinon en rouge
					echo "Température: ";
				  if ($temp < 18.0)
				    echo $froid;
				  else if ($temp < 24.0)
				    echo $ok;
				  else if ($temp < 40.0)
				    echo $bof;
				  else
				    echo $wrong;
					}
				 } ?>
	<br>
	<?php $temps = afficher_database_table("suivi_luminositee");
  				$hour = (date(N) -1) *24 + date(H)+1;  
				foreach ($temps as $temp) { 
					if ($temp['id_luminositee'] == $hour ){
						$temp = $temp['luminositee'];
						$temp = $temp/10;
						//On définit les variables d'affichage dans la condition suivante en y affichant la température
					 $froid = '<span class="temp_froid">'. $temp .'</span> %';
					 $ok = '<span class="temp_ok">'. $temp .'</span> %';
					 $bof = '<span class="temp_bof">'. $temp .'</span> %';
					 $wrong = '<span class="temp_wrong">'. $temp .'</span> %';
					 //Si la température < 65°C alors on affiche en vert, sinon en rouge
						echo "Luminositée: ";
				  if ($temp < 25.0)
				    echo $froid;
				  else if ($temp < 50.0)
				    echo $ok;
				  else if ($temp < 75.0)
				    echo $bof;
				  else
				    echo $wrong;
					}
				 } ?>
	
	     <br>
			 humidité: 23%
			 <br>
			 pression: 104 Pa

  <br><br>
  </div>
</div>

<script type="text/javascript"> //  bfonctions js pour gérer tous ces botons que action.php gère enssuite
	
function music_player(mode){

  if (mode.indexOf('playlist_') ==0)
		 document.getElementById("genre").innerHTML = mode.substring(9);
	
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {	
      result = JSON.parse(this.responseText).result;
      if(result!= "" || result!= "error"){
        var xhr = new XMLHttpRequest();
        xhr.open('GET', result,true);
        xhr.send();
        $('#action').html(mode);
        setTimeout(function(){ $('#action').html("")  }, 1000);
      }else{
        alert("Une erreur s'est produite.")
      }
    }
  };
  xmlhttp.open("GET", "./api/action.php?action=music_"+mode, true);
  xmlhttp.send();
}

date_heure();
function date_heure()
{
  date = new Date;
  annee = date.getFullYear();
  moi = date.getMonth();
  mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
  j = date.getDate();
  jour = date.getDay();
  jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
  h = date.getHours();
  if(h<10)
  {
          h = "0"+h;
  }
  m = date.getMinutes();
  if(m<10)
  {
          m = "0"+m;
  }
  s = date.getSeconds();
  if(s<10)
  {
          s = "0"+s;
  }
  resultat = h+':'+m //+':'+s;
  document.getElementById('date_heure').innerHTML = resultat;
  setTimeout('date_heure();','950');
  return true;
}
</script>
