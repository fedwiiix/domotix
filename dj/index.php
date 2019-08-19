<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
?>

<meta charset="utf-8">

<html>
  <head>
    <title>DJ</title>                   <!-- on insère les css.... -->
    <link rel="shortcut icon" href="css/icon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dj_mobile.css">
 
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

  </head>
  <body>
    <style type="text/css"></style>
    <?php require ('lecteur.php'); ?>

    <div class="list">   
        <div class="folder_list"><?php require ('folder_list.php'); ?></div>
        <div class="music_list"><?php require ('music.php'); ?></div>

        <button class="control" id="bp_menu_onglet3" onclick="onglet_move( this, 'playlist' )">-</button>
        <div class="play_list" id="play_list"></div>
    </div>

  </body>
</html>
  
<script type="text/javascript">///////////////////////////////////////////////////////////////////////////////////////////////////////////

window.onbeforeunload = function(event)   // blocker si on actualise
{ 
    return confirm("Confirm refresh");
};
 
var refresh_ok=1;

  var volume_deck_1=1
  var volume_deck_2=1
  var volume_deck_3=1
  var volume_automix=1, volume_automix_valid=0

  var playlist = [];
  var playlist_name = [];
  var id_playlist=0

var auto_crossfader=0
var value_crossfader=0
var direction_crossfader


  var auto_mix=0;
  var mix_lecteur=3;
  var mix_next=0;

var audio_automix = document.getElementById("deck_2"); // Changer le text en Play si la musique est terminée
var audio_automix_bis = document.getElementById("deck_3"); // Changer le text en Play si la musique est terminée
var crossfader = document.querySelector('#crossfader');

refresh_music()
function refresh_music()
{
  if(refresh_ok){

    var player = document.querySelector("#deck_1");
    if (!player.paused) {
      var deck_1_sliderBar = document.querySelector("#deck_1_sliderBar");
      var deck_1_progressTime = document.querySelector("#deck_1_progressTime");
      deck_1_sliderBar.value = player.currentTime;
      deck_1_progressTime.innerHTML = formatTime(player.currentTime);
      var timemax = document.querySelector("#deck_1_timemax");
      if(timemax.innerHTML==""||timemax.innerHTML=="NaN:NaN")
        music_time("deck_1")
    }
      var player = document.querySelector("#deck_2");
      if (!player.paused) {
      var deck_2_sliderBar = document.querySelector("#deck_2_sliderBar");
      var deck_2_progressTime = document.querySelector("#deck_2_progressTime");
      deck_2_sliderBar.value = player.currentTime;
      deck_2_progressTime.innerHTML = formatTime(player.currentTime);
      var timemax = document.querySelector("#deck_2_timemax");
      if(timemax.innerHTML==""||timemax.innerHTML=="NaN:NaN")
        music_time("deck_2")
    }
    var player = document.querySelector("#deck_3");
    if (!player.paused) {
      var deck_3_sliderBar = document.querySelector("#deck_3_sliderBar");
      var deck_3_progressTime = document.querySelector("#deck_3_progressTime");
      deck_3_sliderBar.value = player.currentTime;
      deck_3_progressTime.innerHTML = formatTime(player.currentTime);
      var timemax = document.querySelector("#deck_3_timemax");
      if(timemax.innerHTML==""||timemax.innerHTML=="NaN:NaN")
        music_time("deck_3")
    }
    setTimeout("refresh_music();",'500');
  }  
}
function play(idPlayer, control) {

    var player = document.querySelector('#' + idPlayer);
    var cd = document.querySelector('#cd_' + idPlayer);

    if(player.src!=''){
      if (player.paused) {
          player.play();
          control.innerHTML = '<img src="img/pause_icon.png" width="30"/>';
          $('#cd_mobile_' + idPlayer).animate(  {"opacity": "1"},1000);
          $('#cd_fixe_' + idPlayer).animate(  {"opacity": "0"},1000);
          music_time(idPlayer)
          
      } else {
          player.pause(); 
          control.innerHTML = '<img src="img/play_icon.png" width="30"/>';
          $('#cd_mobile_' + idPlayer).animate(  {"opacity": "0"},1000);
          $('#cd_fixe_' + idPlayer).animate(  {"opacity": "1"},1000);
      }
    }
}

function erreur_lecteur(idPlayer) {                     //    gestion des erreurs
 
  if(auto_mix){
    music_suivante()

  }else{
    var titre = document.querySelector('#'+idPlayer+'_titre');
    titre.innerHTML = "Musique illisible!"
    document.getElementById('message').innerHTML="Musique illisible!<br>"
    setTimeout("document.getElementById('message').innerHTML=''",'2000');
  }
}
function music_time(idPlayer) {
  var player = document.querySelector('#' + idPlayer);
  var sliderBar = document.querySelector("#"+idPlayer+"_sliderBar");
  var timemax = document.querySelector("#"+idPlayer+"_timemax");

  taille_slidbar = document.getElementById(idPlayer+"_sliderBar").offsetWidth

  if(formatTime(player.duration) != "NaN:NaN" && formatTime(player.duration) != ""){
    sliderBar.max = player.duration;
    sliderBar.step = player.duration/taille_slidbar;
    timemax.innerHTML = formatTime(player.duration);
  }
  
}
function resume(idPlayer) {
    var player = document.querySelector('#' + idPlayer);
    var bpplay = document.querySelector("#"+idPlayer+"_play");
    var cd = document.querySelector('#cd_' + idPlayer);
    var timemax = document.querySelector("#"+idPlayer+"_timemax");
    var sliderBar = document.querySelector("#"+idPlayer+"_sliderBar");
      
    player.currentTime = 0;
    player.pause();
    refresh_music(idPlayer)
    bpplay.innerHTML = '<img src="img/play_icon.png" width="30"/>';
    timemax.innerHTML=''
    sliderBar.value=0
    
    $('#cd_mobile_' + idPlayer).animate(  {"opacity": "0"},1000);
    $('#cd_fixe_' + idPlayer).animate(  {"opacity": "1"},1000);
}
function move_music(value,idPlayer) {
  
  refresh_ok=0
  var player = document.querySelector('#' + idPlayer);
  player.currentTime = value;
  setTimeout("refresh_ok=1; refresh_music();",'500');
}

function sound_music(value,idPlayer) {
  
    var player = document.querySelector('#' + idPlayer);
    var crossfader = document.querySelector('#crossfader');
    var value2 = crossfader.value

    if(idPlayer == 'deck_1'){
      volume_deck_1 = value
      player.volume = -(value2-1)/2 * value
    }else{

      if(mix_next==0){
        volume_deck_2 = value
        volume_deck_3 = value
        value2 = (parseFloat(value2)+1)/2 * value
        audio_automix.volume = value2
        audio_automix_bis.volume = value2
        document.querySelector('#deck_2_sliderBar_vol').value=value
        document.querySelector('#deck_3_sliderBar_vol').value=value
        volume_automix=value
      }
    }
}
crossfader.addEventListener('mousedown', function() { 
  crossfader.addEventListener('mousemove', function() { 
       move_crossfader(crossfader.value)
  }, false);
 }, false);
function move_crossfader(value){
   
   if(mix_next==0){
     var player1 = document.querySelector('#deck_1');
     var player2 = document.querySelector('#deck_2');
     var player3 = document.querySelector('#deck_3');

     var crossfader_progress_1 = document.querySelector('#crossfader_progress_1');
     var crossfader_progress_2 = document.querySelector('#crossfader_progress_2');
     player1.volume = -(value-1)/2 * volume_deck_1
     player2.volume = (parseFloat(value)+1)/2 * volume_deck_2
     player3.volume = (parseFloat(value)+1)/2 * volume_deck_3
     crossfader_progress_1.innerHTML=parseInt(-(value-1)/2 *100)
     crossfader_progress_2.innerHTML=parseInt((parseFloat(value)+1)/2 *100)

    value_crossfader = value
    console.log( value_crossfader );
  }
}
function auto_move_crossfader(direction){
   direction_crossfader = direction
   auto_crossfader=1
   console.log(direction)
 }
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

///////////////////////////////////////////////////////////  automix

function retirer_playlist(id)
{
  playlist[id]=''
  for (i=id; i < id_playlist; i++) {

    if(playlist[i]=='')
      playlist[i]=playlist[i+1]
      playlist_name[i]=playlist_name[i+1]
      playlist[i+1]=''
  }
  id_playlist--;
  affichage_playlist()
}
function affichage_playlist()
{
  document.getElementById('play_list').innerHTML="<div id='nb_music' style='background: #383838; padding-top:5px;'>"+id_playlist+"</div>"
  for (i=0; i < id_playlist; i++) {

    music = reinitialiser_caracteres_special(playlist_name[i]);

    document.getElementById('play_list').innerHTML +="<div class='music_playlist_element' id='music_playlist_"+i+"' style='background: #383838;'>"
    + "<button class='btn_list' id='1' onclick='add_music_playlist("+i+",this)' ondblclick='add_music_playlist("+i+",this,1)'>1</button>"
    + "<button class='btn_list' id='2' onclick='add_music_playlist("+i+",this)' ondblclick='add_music_playlist("+i+",this,1)'>2</button>"
    + "<button class='btn_list' id='2' onclick='change_music_playlist("+i+",1)'>↑</button>"
    + "<button class='btn_list' id='2' onclick='change_music_playlist("+i+",0)'>↓</button>"
    + "<button class='btn_list' style='margin-right:15px' onclick='retirer_playlist("+i+")'>-</button>"+music+"</div>"
  }
}
function add_music_playlist(id,music,validation)
{
  add_music(parseInt(music.id), playlist[id], playlist_name[id],validation)
}
function add_music(deck,lien_music,music,validation,vérif)
{
  if(deck==0){

    if(vérif=='1'){
      playlist[id_playlist]=lien_music
      playlist_name[id_playlist]=music
      id_playlist++;
      music2 = reinitialiser_caracteres_special(music);

    }else{
      var deja_present=0
      arret = id_playlist
      if(id_playlist>30)
        arret = 30
      for (i=0; i < arret; i++) {
        if(playlist[i]==lien_music)
          deja_present=1
      }
      if (!deja_present) {

        playlist[id_playlist]=lien_music
        playlist_name[id_playlist]=music
        id_playlist++;
        music2 = reinitialiser_caracteres_special(music);

        affichage_playlist()
      }
    }

  }else{
  var player = document.querySelector('#deck_'+deck);

  if(player.paused || validation){
    resume('deck_'+deck)
    lien_music = reinitialiser_caracteres_special(lien_music);
    music = reinitialiser_caracteres_special(music);
    player.src = "player.php?file="+encodeURIComponent(lien_music)
    player.preload
    var titre = document.querySelector('#deck_'+deck+'_titre');
    titre.innerHTML = music
    setTimeout("music_time('deck_"+deck+"')",'1000');
    } else {
      document.getElementById('message').innerHTML="Musique en cour<br>"
      setTimeout("document.getElementById('message').innerHTML=''",'2000');
    }
  } 
}
function vider_playlist()
{
  for(i=0;i<=id_playlist;i++){
    playlist[id_playlist]=''
    playlist_name[id_playlist]=''
  }
  id_playlist=0
  affichage_playlist()
}
function lecture_aléatoire()
{
  var alea_playlist = [];
  var alea_playlist_name = [];
  var alea
  for (i=0; i < id_playlist; i++)
      alea_playlist[i]=''

  for (i=0; i < id_playlist; i++) {
    do{
      alea=Math.floor(Math.random() * id_playlist )
    }while(alea_playlist[alea]!='')

    alea_playlist[alea] = playlist[i]
    alea_playlist_name[alea] = playlist_name[i]
  }
  for (i=0; i < id_playlist; i++) {
    playlist[i]=alea_playlist[i]
    playlist_name[i]=alea_playlist_name[i]
  }
  affichage_playlist()
}
function change_music_playlist(id,move){
    var a,b
  if(move && id!=0){
    a=playlist[id]
    b=playlist_name[id]
    playlist[id]=playlist[id-1]
    playlist_name[id]=playlist_name[id-1]
    playlist[id-1]=a
    playlist_name[id-1]=b
    affichage_playlist()
  }else if(id!=id_playlist-1){
    a=playlist[id]
    b=playlist_name[id]
    playlist[id]=playlist[id+1]
    playlist_name[id]=playlist_name[id+1]
    playlist[id+1]=a
    playlist_name[id+1]=b
    affichage_playlist()
  }
}
function lancer_auto_mix(){

  if(auto_mix){
    auto_mix=0
    $('#auto_mix_bp').css('color', 'white');
    $('.deck_3' ).css(  {"display": "none"});
    $('.deck_2' ).css(  {"display": "block"});
    $('#auto_mix_control' ).css(  {"display": "none"});
    resume("deck_2")
    resume("deck_3")
  }else if(id_playlist){
    auto_mix=1 
    move_crossfader(1)
    crossfader.value=1

    if (audio_automix.paused)
      music_suivante()
    $('#auto_mix_bp').css('color', 'red');
    $('#auto_mix_control' ).css(  {"display": "block"});
  }
  console.log(auto_mix)
}
function music_suivante(){
  if(playlist[0]!='' && playlist[0]!=undefined){
    add_music(mix_lecteur, playlist[0],playlist_name[0],1)
    retirer_playlist(0)
    play('deck_'+mix_lecteur, document.getElementById("deck_"+mix_lecteur+"_play"))

    if(mix_lecteur==2){
      mix_lecteur=3;
      $('.deck_2' ).css(  {"display": "block"});
      $('.deck_3' ).css(  {"display": "none"});
    }else{
      mix_lecteur=2
      $('.deck_3' ).css(  {"display": "block"});
      $('.deck_2' ).css(  {"display": "none"});
    }
    mix_next=1
  }
}
////////////////////////////////////////////////////////////////////////////////////////////// horloge et crossfader et automix

date_heure('date_heure');
function date_heure(id)
{
  date = new Date;
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
  n = date.getMilliseconds();
  resultat = h+':'+m+':'+s//+':'+n;
  document.getElementById(id).innerHTML = resultat;
  setTimeout('date_heure("'+id+'");','50');

if(mix_next){  
  mix_next++
  if(mix_next<100){
    if(mix_lecteur==2){

        if(volume_deck_2>0.01)
          volume_deck_2 -=0.01
        if(volume_deck_3<volume_automix)
          volume_deck_3+=0.01
      }else{

        if(volume_deck_3>0.01)
          volume_deck_3-=0.01
        if(volume_deck_2<volume_automix)
          volume_deck_2+=0.01
      }
      if(value_crossfader != -1){
        audio_automix.volume = volume_deck_2
        audio_automix_bis.volume = volume_deck_3
      }
  } else {
    resume("deck_"+mix_lecteur)
    mix_next=0
  }
}
if(auto_mix){  
    if(mix_lecteur==3){
      player = audio_automix
    }
    else{
      player = audio_automix_bis
    }  
    if(player.currentTime + 12 > player.duration){  // temps avant la finde la chanson quand on lance la suivante

        music_suivante()
    }
}
if(auto_crossfader && auto_crossfader<100){

  auto_crossfader++
  console.log(value_crossfader)

  if(direction_crossfader == 1 && value_crossfader > -1)
    value_crossfader-=0.03
  if(direction_crossfader == 2 && value_crossfader < 1)
    value_crossfader+=0.03
  if(direction_crossfader == 1 && value_crossfader < -0.98){
     value_crossfader=-1
    auto_crossfader=100
  }   
  if(direction_crossfader == 2 && value_crossfader > 0.98){
    value_crossfader=1
    auto_crossfader=100
  } 
   crossfader.value = value_crossfader
   move_crossfader(value_crossfader)
}
  return true;
}

///////////////////////////////////////////////////////// folder

var file_deja_afficher = 0

function folder_in_playlist(dossier)
{
  dossier=caracteres_special(dossier)
  $(".music_list").load('music.php?dossier='+dossier+"&playlist=1");
  file_deja_afficher = 1
}
function open_folder(dossier)
{
  if(file_deja_afficher)
    file_deja_afficher = 0
  else{
    str = dossier.split("/")
    dossier=caracteres_special(dossier)
    document.getElementById('message_titre_folder').innerHTML=str[str.length-1]+"<br>"
    document.getElementById('message_titre_folder').value=dossier
    document.getElementById('seach_dj_music').value=''
    $("#seach_dj_music").stop().animate({'width':'32px','border-radius':'80%'},500);

    $(".music_list").load('music.php?dossier='+dossier);
  }
}
//////////////////////////////////////////////////////////// car special
function caracteres_special(f){
    f = f.replace(/\+/g, '_plus_');
    f = f.replace(/\&/g, '_etcom_');
    f = f.replace(/'/g, '_apostrophe_');
    f = f.replace(/ /g, '/_/_'); 
    return f;
  }
  function reinitialiser_caracteres_special(f){
    f = f.replace(/_plus_/g, '\+');
    f = f.replace(/_etcom_/g, '\&');
    f = f.replace(/_apostrophe_/g, "'");
    f = f.replace(/\/_\/_/g, ' ');
    f = f.replace(/_interrog_/g, '\?');
    f = f.replace(/_parro_/g, '\(');
    f = f.replace(/_parrf_/g, '\)'); 
    f = f.replace(/_achtag_/g, '\#'); 
    return f;
  }

////////////////////////////////////////////////////////////////////////////////  mouve display

function nb_deck(nb){
    if(nb[0]==1){
      document.getElementById('nb_deck').innerHTML='2 Decks'
      $(".deck_1").animate(  {"width": "0%"},500);  
      $(".deck_central").animate(  {"width": "40%", "left":"0" },500); 
      $(".deck_2").animate(  {"width": "60%"},500);
      $(".deck_3").animate(  {"width": "60%"},500);  
      $('.deck_1' ).css(  {"display": "none"});
      move_crossfader(1)
      crossfader.value=1
      resume("deck_1")
      $("[id=bp_list1]").css('color', '#383838');
      $("[id=bp_list11]").css('color', '#4D4D4D');  

    }else{
      document.getElementById('nb_deck').innerHTML='1 Deck'
      $(".deck_1").animate(  {"width": "40%"},500);  
      $(".deck_central").animate(  {"width": "20%", "left":"40%" },500); 
      $(".deck_2").animate(  {"width": "40%"},500); 
      $(".deck_3").animate(  {"width": "40%"},500); 
      $("[id=bp_list1]").css('color', 'black');  
      $("[id=bp_list11]").css('color', 'black');  
      $('.deck_1' ).css(  {"display": "block"});
    }
  }

function onglet_move( objet,onglet){
    
  var left_music=20, left_playlist=70
  var width_folder=20, width_music=50, width_playlist=30


    if(onglet=='dossier' && objet.innerHTML=='-'){
      width_folder=2
      width_music=59
      width_playlist=39
      left_music=2
      left_playlist=61
    }else if(onglet=='music' && objet.innerHTML=='-'){
      width_folder=40
      width_music=2 
      width_playlist=58
      left_music=40
      left_playlist=42
    }else if(onglet=='playlist' && objet.innerHTML=='-'){
      width_folder=40
      width_music=58 
      width_playlist=2
      left_music=40
      left_playlist=98
    }
    $(".folder_list").animate(  {"width": width_folder+"%"},500);  
    $(".music_list").animate(  {"width": width_music+"%", 'left': left_music+"%" },500);  
    $(".play_list").animate(  {"width": width_playlist+"%", 'left': left_playlist+"%"},500);

    var signe=objet.innerHTML
    document.getElementById('bp_menu_onglet1').innerHTML='-'
    document.getElementById('bp_menu_onglet2').innerHTML='-'
    document.getElementById('bp_menu_onglet3').innerHTML='-'

    if(signe=='-'){
      objet.innerHTML='+'
    }
} 
//////////////////////////////////////////////////////////////////// search

$( "#seach_dj_music" ).mouseover(function() {
  $("#seach_dj_music").animate({'border-radius':'10%','width':'20%'},200);
});
$( "#seach_dj_music" ).mouseleave(function() {
  if(document.getElementById("seach_dj_music").value==''){
  setTimeout(function() {
      $("#seach_dj_music").stop().animate({'width':'32px','border-radius':'80%'},500);
      }, 1000);
  }
});

function seach_dj(recherche){

    recherche = caracteres_special(recherche);
    dossier = document.getElementById('message_titre_folder').value 
    if(dossier == undefined)
      dossier="../file_cloud/music"

    $(".music_list").load('music.php?dossier='+dossier+'&recherche='+recherche);
 }


</script>


