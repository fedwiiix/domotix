<?php require ('../parametre/security.php'); 

$initial_directory = $_SESSION["cloudDir"];
		  
$allowed_ext = array('png', 'jpg', 'gif', 'pdf', 'mp4', 'avi','m4a', 'mp3','txt','css','js','html','php','h','c','py','sh','','md', 'ino','ini');

if(isset($_GET["displayMode"]))
{
	$_SESSION["displayMode"]=$_GET["displayMode"];
}
if(isset($_SESSION["displayMode"])){
  if($_SESSION["displayMode"]=="true"){ ?>

<style>
  #case_dir,#case_file{
    width: 48%;
    text-align: left;
  }
  #titre_case{
    width: 80%;
    margin-top:10px;
  }
  #img_file{
    width: 35px;
    height: 35px;
  }
  #img_file p{
    font-size:10px;
  }
</style>
    
 <?php }else{ ?>
    
<?php }
}


if(isset( $_GET["dossier"]) && $_GET["dossier"])
{
	$directory=urldecode($_GET["dossier"]);
}else{
	$directory = $_SESSION['cloudInitDir']; 
}
$_SESSION['upload_directory'] = $directory;

if(isset( $_GET["recherche"])) 
{
	$recherche = '#'.$_GET["recherche"]."#i";
}else{
	$recherche = '';
}
if (strpos($initial_directory.$directory, '../'))  // check good path
  die('error file denied');

$nb_img=0;
$nb_fichier=0;
$dir = scandir($initial_directory.$directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
foreach ($dir as $element) {   	
	if($element != '.' && $element != '..' && $element[0] != '.') {

		if(preg_match($recherche, $element) || $recherche==''){ 
			if (!is_dir($initial_directory.$directory.'/'.$element)) {

				$fichier[] = $element;
				$extension[$element] = pathinfo($element, PATHINFO_EXTENSION);
				$nb_fichier++;
        
        if($extension[$element]=='jpeg' || $extension[$element]=='jpg' || $extension[$element]=='gif' || $extension[$element]=='png' || $extension[$element]=='JPG' || $extension[$element]=='PNG')
          $nb_img++;
			}
			else {	$dossier[] = $element;	}
		}
	}
}

$titre = explode('/',$directory);
$titre_dir = $titre[sizeof($titre)-1];
$prec_dir = substr($directory,0,-strlen($titre_dir)-1);

// **************************************************************************************************************************************************************************

if( strlen($prec_dir)>0 ){
	?>
	<div id="titre_pages" class="droppable" data="<?php echo urlencode($prec_dir) ?>" oncontextmenu="return monmenu(this,'titre')">
	<img onclick="afficher_dossier('<?php echo urlencode($prec_dir) ?>',1)" height="30px" src="img/cloud/precedent.png" style="float:left; cursor:pointer; padding-top:5px;"><?php echo $titre_dir; ?></div>
<?php }else{ ?>
	<div id="titre_pages" oncontextmenu="return monmenu(this,'titre')"><?php echo $titre_dir; ?></div>
<?php } 

if($nb_fichier>20){ ?><div style="position:absolute; z-index:5; top: 5px; right: 30px; padding:4px; background:grey; border-radius:50%;"><?php echo $nb_fichier;?></div><?php } ?>

<br><br><div id="folder_list" align="left"><?php	

	foreach($dossier as $lien){?>

		<fieldset id="case_dir" data="<?php echo urlencode($lien) ?>" onmousedown="afficher_fichier()" onmouseup="afficher_dossier('<?php echo urlencode($directory."/".$lien) ?>')"  oncontextmenu="return monmenu(this,'<?php echo urlencode($lien); ?>')">
			<img id="img_file" src="img/cloud/icon/dossier.png" >
			<ee id="titre_case"><?php echo $lien; ?></ee>
		</fieldset><?php
	}
?></div><?php
if(!empty($dossier) && !empty($fichier)) {
	echo '<div id="trait"></div>';
}
?><div id="file_list" align="left"><?php

if(!empty($fichier)){
	foreach($fichier as $lien) {

		$ext_connu = 0;
		foreach($allowed_ext as $ext){
			if(strtolower($extension[$lien])==$ext){
				$ext_connu = 1;
		} }
    
					
	  ?><fieldset id="<?php if($nb_fichier<100){ echo 'case_file'; }else{ echo 'case_file_allonger'; } ?>" data="<?php echo urlencode($lien) ?>" <?php if($ext_connu){ ?> onmousedown="afficher_fichier()" onmouseup="afficher_fichier('<?php echo urlencode($lien) ?>')" <?php } ?> oncontextmenu="return monmenu(this,'<?php echo urlencode($lien); ?>')"><?php

		if (strtolower($extension[$lien])=='pdf'){
      ?><img id="img_file" src="cloud/affichage.php?img&file=<?php echo urlencode($directory.'/'.$lien); ?>"><?php /*	?><img id="img_file" src="img/cloud/pdf.png"><?php*/
      if ($_SESSION["displayMode"]!="true") {
          echo '<img style=" margin-top:-41px; margin-left:1px; float:left; height:40px;" src="img/cloud/icon/pdfIcon.png">';
       }
      
		} else if (strtolower($extension[$lien])=='jpeg' || strtolower($extension[$lien])=='jpg' || strtolower($extension[$lien])=='gif' || strtolower($extension[$lien])=='png'){

      if( $nb_img <100 ){
			?> <img id="img_file" src="cloud/affichage.php?img&file=<?php echo urlencode($directory.'/'.$lien); ?>">
      <?php }else{ ?>
			<img id="img_file" class="<?php echo urlencode($directory.'/'.$lien); ?>" src="img/cloud/icon/img.png"><?php
      }

		} else if (strtolower($extension[$lien])=='mp3' || strtolower($extension[$lien])=='m4a'){
				?><img id="img_file" src="img/cloud/icon/musique.png"><?php
		} else if(strtolower($extension[$lien])=="webm" || strtolower($extension[$lien])=="ogg" || strtolower($extension[$lien])=="mp4" || strtolower($extension[$lien])=="flv"){ 
				?><img id="img_file" src="img/cloud/icon/video.png"><?php
		} else {
        if (file_exists("../img/cloud/icon/$extension[$lien].png") && $_SESSION["displayMode"]!="true") {
          echo '<img id="img_file" src="img/cloud/icon/'.$extension[$lien].'.png">';
        }else{
          ?><ee id="img_file"><p><?php echo $extension[$lien]; ?></p></ee><?php
        }
		} 
		?><ee id="titre_case"><?php echo $lien; ?></ee>
	  </fieldset><?php

	}
}
?></div>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    
  var actifDir ="<?php echo $directory ?>";
  var linkCopyDrag =""
  var linkPasteDrag =""  
    
  $( function() {
    $( "fieldset" ).draggable({ revert: "invalid" });
 
    $( "[id=case_dir], .droppable" ).droppable({
      classes: {
        "ui-droppable-active": "drop-active",
        "ui-droppable-hover": "drop-hover"
      },
      drop: function( event, ui ) {
        
        if($(this).attr("id")=="titre_pages" )
          linkPasteDrag = $(this).attr("data")
        else
          linkPasteDrag = actifDir + "/" + $(this).attr("data")
        //alert(linkCopyDrag+" + "+ linkPasteDrag)
        cloud_action( 'deplacer', actifDir + "/" + linkCopyDrag, linkPasteDrag  + "/" + linkCopyDrag )
      }
    });
  } );

$( "fieldset" ).mousedown(function(event) { 
  $('#titre_pages').css('z-index','2')
  $('fieldset').css('z-index','1')
  $(this).css('z-index','3')
  linkCopyDrag = $(this).attr('data')
});

  </script>
