<?php require ('../parametre/security.php'); 

$initial_directory = $_SESSION["cloudDir"];
	  
if(isset( $_GET["file"]))
{
	$file = urldecode($_GET["file"]);
} 
if (strpos($file, '../'))  // check good path
  die('error file denied');

$extension = pathinfo($file, PATHINFO_EXTENSION);

$extEdit = array('', 'md', 'ino','txt','css','js','php','h','c','py','sh','ini','html');
$extEditE = 0;
foreach($extEdit as $ext){
  if($extension==$ext){
    $extEditE = 1;
} }

if( !isset( $_GET["music"]) ){ ?> 

	<div id="titre_pages" class="titre_affichage">
	<img onclick="quitter_cloud_affichage()" height="30px" src="img/cloud/precedent.png" style="float:left; cursor:pointer; padding-top:5px; padding-right:20px;">

		<?php 
			echo basename($file, '.'.$extension ); 
      if($extEditE == 1){  
				
			if( $_SESSION['droit']>=2 ){ ?><button id="bp_editer" style="margin-left:10px; vertical-align:top;" onclick="cloud_editer('<?php echo urlencode($file) ?>')">Editer</button><?php }    // if user right is good
			}
    ?>
	</div>

	<div id="espace_affichage"><?php


	if($extension=='html'){
		
		$contenu=file_get_contents($initial_directory.$file);
		//$contenu = utf8_decode($contenu); ?>
		<div style="width: 92%; min-height: 100%; padding: 5% 2%; background:white; text-align:left;"><?php echo $contenu ?></div><?php 

	}else if($extEditE == 1){  
		
		$contenu=file_get_contents($initial_directory.$file);
		//$contenu = utf8_decode($contenu); 
		?><textarea readonly style="resize: none; width: 94%; min-height: 100%; padding: 1%; background:white;"><?php echo $contenu ?></textarea><?php

	} else if($extension=="jpeg" || $extension=="jpg" || $extension=="gif" || $extension=="png" || $extension=="JPG" || $extension=="PNG"){  

		?><img src="cloud/affichage.php?file=<?php echo urlencode($file); ?>" style="max-height:90%; max-width:96%; vertical-align:center;"/><?php
		
	} else if($extension=="pdf"){  
		
		?><object data="cloud/affichage.php?file=<?php echo urlencode($file); ?>" width="96%" height="100%"></object><?php 

	} else if($extension=="webm" || $extension=="ogg" || $extension=="mp4" || $extension=="flv"){  
		
		?><video controls autoplay id="video" src="cloud/affichage.php?file=<?php echo urlencode($file); ?>" style="max-height:90%; max-width:96%; vertical-align:center;" ></video><?php 

	} ?></div><?php

} else { //************************************************************************************************************************************************************************
?>
	
	<div class="cloud_music_lecteur" >
    <b id="titre_music_lecteur"><img onclick="quitter_music_lecteur()" height="30px" src="img/cloud/precedent.png" style="float:left; cursor:pointer; padding: 15px 5px 0 20px;"><?php echo basename($file, '.'.$extension ); ?></b>
		
		<audio id="audio" controls="controls" autoplay="autoplay" style="display:none;" >
			<source src="cloud/affichage.php?file=<?php echo urlencode($file); ?>" ></source>
		</audio>

    <div id="cloudMusicbox">
			<ee class="cloudBp_play"></ee>
      <progress id="cloudPlayer_progress" value="0" step="0.01" max="100"></progress>
      <div id="cloudPlayer_time"><span id="cloudPlayer_currenttime">00:00</span><span>/</span><span id="cloudPlayer_timemax">00:00</span></div>
      <input type="range" id="cloudPlayer_volume" min="0" max="1" step="0.01" value="1">
		</div>
	  <br>
	</div>

<script type="text/javascript">

  
//******************************************************************************************************* sound and progress bar
  
player = document.getElementById("audio");

  
var progressbar = document.getElementById('cloudPlayer_progress');
progressbar.addEventListener("click", seek);

function seek(event) {
	var percent = event.offsetX / this.offsetWidth;
	player.currentTime = percent * player.duration;
	progressbar.value = percent
}
player.addEventListener('timeupdate',function (){
	curtime = parseInt(player.currentTime, 10);
	$("#cloudPlayer_progress").attr("value", curtime);
	$("#cloudPlayer_currenttime").html(formatTime(curtime));

	if(player.duration){
		$('#cloudPlayer_timemax').html(formatTime(player.duration))
		$("#cloudPlayer_progress").attr("max", player.duration);
	}

});

function formatTime(time) {
    var hours = Math.floor(time / 3600);
    var mins  = Math.floor((time % 3600) / 60);
    var secs  = Math.floor(time % 60);
    if (secs < 10) {
        secs = "0" + secs;
    }
    if (hours) {
        if (mins < 10) {
            mins = "0" + mins;
        }
        return hours + ":" + mins + ":" + secs; // hh:mm:ss
    } else {
        return mins + ":" + secs; // mm:ss
    }
}
  
$("#cloudPlayer_volume").on("input", function() {
	player.volume = $(this).val();
});
  
$(".cloudBp_play").click(function() {
  if(!player.paused){
      player.pause();
      $(".cloudBp_play").css('background-image','url(img/music/white_play.png)')

  }else{
    player.play()
    $(".cloudBp_play").css('background-image','url(img/music/white_pause.png)')
  }
}); 
$( ".cloudBp_play" ).mouseenter(function() {
  
    var img = $(this).css('background-image').split( '/' ).pop().slice(0, -6)
    if(img == 'play')
        $( this ).css('background-image','url(img/music/white_play.png)')
    else if(img == 'pause')
      $( this ).css('background-image','url(img/music/white_pause.png)')
});
$( ".cloudBp_play" ).mouseleave( function() {
    var img = $(this).css('background-image').split( '/' ).pop().slice(0, -6)
    if(img == 'white_play')
    	$( this ).css('background-image','url(img/music/play.png)')
	  else if(img == 'white_pause')
		  $( this ).css('background-image','url(img/music/pause.png)')
});				

</script>

<?php } ?>