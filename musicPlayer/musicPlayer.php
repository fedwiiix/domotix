<?php 
require ('../parametre/security.php');
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
 ?>

<!-- ********************************************************************************************************************************************************************* -->

	<div id="volet" align="center" oncontextmenu="return monmenu(this,'')">
		<li class="mv-item"><a onclick="afficher_music_file('')">Toutes</a></li>
		<?php 
		$directory= $_SESSION["cloudDir"].$_SESSION["cloudMusicDir"];
		$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
		foreach ($dir as $element) {   
			if($element != '.' && $element != '..') {
				if (is_dir($directory.'/'.$element)) {
					?><li class="mv-item"><a onclick="afficher_music_file('<?php echo $element; ?>')"><?php echo $element ?></a></li><?php
				}
			}		
		}
		?>
		<input type="search" id="recherche" placeholder="Search" ></input>

	</div>

	<div class="big-container-musicPlayer" style="overflow:hidden;">

	<audio id="player_1" autoplay="autoplay" onerror="next_music();"><source src=""></source></audio>
					
	<div id="musicPlayer_liste" align="center"><?php require ('musicPlayer_liste.php'); ?></div>
	
	<div id="musicbox">
		<div class="bp_musicbox">
			<ee class="bp_previous"></ee>
			<ee class="bp_play"></ee>
			<ee class="bp_next"></ee>
		</div>

		<progress id="player_progress" value="0" step="0.01" max="100"></progress>
		<div id="player_time"><span id="player_currenttime">00:00</span><span>/</span><span id="player_timemax">00:00</span></div>
		<input type="range" id="player_volume" min="0" max="1" step="0.01" value="1">
		<div id="player_titre">Music Player</div>
		<div id="player_artist"></div>
		<div id="player_album"></div>
		<div id="player_year"></div>
		<img id="player_image" src="./img/music/musique.png">



		<input type="checkbox" id="bp_aleatoire" checked/>
		<label class="bp_aleatoire" for="bp_aleatoire"><aaaa></aaaa></label>

		<div class="bp_playlist">
			<button class="automix">Mix</button>
      <button class="info">Info</button>
		</div>
	</div>

	<div id="playlistbox">
		
		<div id="player_info_affichage">
			<img id="player_image_affichage" src="./img/music/musique.png">
			<div id="player_titre_affichage">PlayerList</div>
			<div id="player_artist_affichage">Artiste</div>
			<div id="player_album_affichage">Album</div>
			<div id="player_year_affichage">2006</div>
			<div id="player_time_affichage">03:00</div>

		</div>
		<br>
		<ul class="playlist"></ul>

		<div style="height:150px; width:100%;"></div>
	</div>
</div>

<script type="text/javascript">

//******************************************************************************************************************* var and fuctions

actif_music_dir =""

player_1 = document.getElementById("player_1");
player_1_play="play"

actif_player_id="player_1"
actif_player = document.getElementById(actif_player_id);
actif_music=0

playlistMode=0
aleatoireMode=1
infoModeMode=0
  
function afficher_music_file(link){
	actif_music_dir = link;	
	$("#musicPlayer_liste").load("musicPlayer/musicPlayer_liste.php?dossier="+encodeURIComponent(link));	
}

function urldecode (str) {
  return decodeURIComponent((str + '').replace(/\+/g, '%20'));
}
function baseName(str)
{
   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
    if(base.lastIndexOf(".") != -1)       
        base = base.substring(0, base.lastIndexOf("."));
   return base;
}

//******************************************************************************************************************* Player 

function click_music(link){
	get_music_tag_and_affiche( link )
}

function play_music(link,name, n){

	if(playlistMode && name!='' ){
		$( ".playlist" ).append( "<li class='playlist_title'  name='"+link+"' ondblclick='$(this).remove(); play_music( \""+link+"\",\"\","+n+")' >"+name+"</li>" );
	}else if(link!=undefined){
    window.stop() // reset of navigator download
		$('#'+actif_player_id).attr("src","musicPlayer/player.php?file="+(link))	
		$(".bp_play").css('background-image','url(img/music/pause.png)')
		get_music_tag( link )
		actif_music=parseInt(n)
	}	
}

//******************************************************************************************************* prev next and random

$(".bp_previous").click(function(event) {
	if(aleatoireMode && !playlistMode){
		random_music()
	}else{
		if( actif_music >0 && !playlistMode){
			$('.music_title').eq(actif_music-1).dblclick();
		}
	}
});

$(".bp_next").click(function(event) {
	next_music()
});
player_1.onended = function() {
	next_music()
};

function next_music(){
	if(aleatoireMode && !playlistMode ){
		random_music()
	}else{
		if(playlistMode){
			play_music($('.playlist_title').first().attr('name'),'', $('.playlist_title').first().attr('id') )
			$( ".playlist_title" ).first().remove();

		}else if( $('.music_title').eq(actif_music-1).attr('id') && !playlistMode ){
			$('.music_title').eq(actif_music+1).dblclick();
			
		}else{
			random_music()
		}
	}
}

function random_music(){
	n = $( ".music_title" ).length;
	rand = Math.floor(Math.random()*n);
	$('.music_title').eq(rand).dblclick();
	actif_music=rand
}

//******************************************************************************************************* random and playlist mode

$(".bp_aleatoire").click(function(event) {
	if( $("#bp_aleatoire").is(':checked') ){
		aleatoireMode=0	
	} else {
		aleatoireMode=1
	}
	console.log(aleatoireMode)
});

$(".automix").click(function(event) {
	if( playlistMode ){
    	$("#playlistbox").animate(  {"bottom": "-80%"},500);
		playlistMode=0	
	} else {
		$("#playlistbox").animate(  {"bottom": "0px"},500);	
		playlistMode=1
	}
}); 
$(".info").click(function(event) {
		if( playlistMode==0 ){
      if( infoModeMode ){
        $("#playlistbox").animate(  {"bottom": "-80%"},500);
        infoModeMode=0	
      } else {
        $("#playlistbox").animate(  {"bottom": "-40%"},500);	
        infoModeMode=1
      }
    }
}); 

$( function() {					// sortable
    $( ".playlist" ).sortable();
    $( ".playlist" ).disableSelection();
  } );

//******************************************************************************************************* play

$(".bp_play").click(function() {
	if(!$('#'+actif_player_id).attr("src")){
		random_music()
	}else{
		if(!player_1.paused){
				player_1.pause();
				$(".bp_play").css('background-image','url(img/music/white_play.png)')
			
		}else{
			player_1.play()
			$(".bp_play").css('background-image','url(img/music/white_pause.png)')
		}
	}
});

$( ".bp_play" ).mouseenter(function() {
  
    var img = $(this).css('background-image').split( '/' ).pop().slice(0, -6)
    if(img == 'play')
        $( this ).css('background-image','url(img/music/white_play.png)')
    else if(img == 'pause')
      $( this ).css('background-image','url(img/music/white_pause.png)')
});
$( ".bp_play" ).mouseleave( function() {
    var img = $(this).css('background-image').split( '/' ).pop().slice(0, -6)
    if(img == 'white_play')
    	$( this ).css('background-image','url(img/music/play.png)')
	  else if(img == 'white_pause')
		  $( this ).css('background-image','url(img/music/pause.png)')
});				

$("#player_volume").on("input", function() {
	player_1.volume = $(this).val();
});

//******************************************************************************************************* sound and progress bar
var progressbar = document.getElementById('player_progress');
progressbar.addEventListener("click", seek);

function seek(event) {
	var percent = event.offsetX / this.offsetWidth;
	actif_player.currentTime = percent * actif_player.duration;
	progressbar.value = percent
}
player_1.addEventListener('timeupdate',function (){
	curtime = parseInt(player_1.currentTime, 10);
	$("#player_progress").attr("value", curtime);
	$("#player_currenttime").html(formatTime(curtime));

	if(actif_player.duration){
		$('#player_timemax').html(formatTime(actif_player.duration))
		$("#player_progress").attr("max", player_1.duration);
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

//*******************************************************************************************************   get tag

function get_music_tag( file ){

	$.ajax({
			type: "POST",
			url: "./musicPlayer/player_action.php",
			dataType: "json",
			data: {action: "get_music_tag" , file },
			"success": function(response){ 	
				
				$("#player_titre").html(urldecode(response.titre));
				$("#player_album").html(urldecode(response.album));
				$("#player_artist").html(urldecode(response.artist));
				$("#player_year").html(urldecode(response.year));
				$('#player_timemax').html(urldecode(response.time))

				if(response.image!=''){

					var image = $("#player_image");
					image.fadeOut('slow', function () {
						image.attr('src','data:image/png;base64,'+response.image);
						image.fadeIn('slow');
					});
				}else{
					var image = $("#player_image");
					if(image.attr('src')!= "./img/music/musique.png"){
						image.fadeOut('slow', function () {
							image.attr('src',"./img/music/musique.png");
							image.fadeIn('slow');
						});
					}
				}
			},
			"error": function(jqXHR, textStatus){ /*alert('Request failed: ' + textStatus);*/ }
	});	
}

function get_music_tag_and_affiche( file ){

$.ajax({
		type: "POST",
		url: "./musicPlayer/player_action.php",
		dataType: "json",
		data: {action: "get_music_tag" , file },
		"success": function(response){ 	
			
			$("#player_titre_affichage").html(urldecode(response.titre));
			$("#player_album_affichage").html("");
			$("#player_artist_affichage").html("");
			$("#player_year_affichage").html("");
			$('#player_time_affichage').html("");

			if(response.album)
				$("#player_album_affichage").html(urldecode("Album: "+response.album));
			if(response.artist)
				$("#player_artist_affichage").html(urldecode("Artiste: "+response.artist));
			if(response.year)
				$("#player_year_affichage").html(urldecode("Année: "+response.year));
			if(response.time)
				$('#player_time_affichage').html(urldecode("Durée: "+response.time))

			if(response.image!=''){

				var image = $("#player_image_affichage");
				image.fadeOut('slow', function () {
					image.attr('src','data:image/png;base64,'+response.image);
					image.fadeIn('slow');
				});
			}else{
				var image = $("#player_image_affichage");
				if(image.attr('src')!= "./img/music/musique.png"){
					image.fadeOut('slow', function () {
						image.attr('src',"./img/music/musique.png");
						image.fadeIn('slow');
					});
				}
			}
		},
		"error": function(jqXHR, textStatus){ /*alert('Request failed: ' + textStatus);*/ }
});	
}

//*******************************************************************************************************   recherche

function seach(recherche){
	$("#musicPlayer_liste").load("musicPlayer/musicPlayer_liste.php?dossier="+encodeURIComponent(actif_music_dir)+"&recherche="+encodeURIComponent(recherche));
}
$( "#recherche" ).mouseover(function() {
  $("#recherche").animate({'border-radius':'10%','width':'80%'},200);
});
$( "#recherche" ).mouseleave(function() {
	if($("#recherche").val()==''){
    setTimeout(function() {
      $("#recherche").stop().animate({'width':'32px','border-radius':'80%'},500);
    }, 1000);
	}
});
$("#recherche").keydown(function() { seach($("#recherche").val());  });
$("#recherche").keyup(function() {
        seach($("#recherche").val()); 
	if($("#recherche").val()==''){
    setTimeout(function() {
        $("#recherche").stop().animate({'width':'32px','border-radius':'80%'},500);
    }, 1000);
	}	
});

</script>