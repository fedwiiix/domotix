<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
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
  $initial_directory = $ini["cloudDir"].$ini["cloudMusicDir"];
  $dir = scandir($initial_directory) or die($initial_directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
  foreach ($dir as $element) {   
    if($element != '.' && $element != '..') {
      if (is_dir($initial_directory.'/'.$element)) {
        ?><li class="mv-item"><a onclick="music_player('<?php echo 'playlist_'.$element ?>')"><?php echo $element ?></a></li><?php
      }
    }
  } ?>
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

</script>
