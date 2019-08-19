<?php require ('../parametre/security.php'); ?>

<meta charset="utf-8">
<?php

function reinitialiser_caracteres_special($f){
  $f = preg_replace("#/_/_#", " ", $f);
  $f = preg_replace("#_plus_#", "+", $f); 
  $f = preg_replace("#_apostrophe_#", "'", $f);  
  $f = preg_replace("#_etcom_#", "&", $f);
  $f = preg_replace("#_interrog_#", "?", $f);
  $f = preg_replace("#_parro_#", "(", $f);
  $f = preg_replace("#_parrf_#", ")", $f);
  return $f;
}

function modifier_caracteres_special($f){
  $f = preg_replace("# #", "/_/_", $f);
  $f = preg_replace("#\+#", "_plus_", $f);  
  $f = preg_replace("#'#", "_apostrophe_", $f);  
  $f = preg_replace("#&#", "_etcom_", $f);
  $f = preg_replace("#\?#", "_interrog_", $f);
  $f = preg_replace("#\(#", "_parro_", $f);
  $f = preg_replace("#\)#", "_parrf_", $f);
  $f = preg_replace("#\##", "_achtag_", $f);
  return $f;
}


if(isset( $_GET["dossier"])) // la variable existe
{
  $directory = reinitialiser_caracteres_special($_GET["dossier"]);    // on remet les espaces que l'on à enlever précédament
} else {
  $directory= $_SESSION["cloudDir"].$_SESSION["cloudMusicDir"];
}
if (strpos($directory, '../')) 
  die('error file denied');

$recherche = '';
if(isset( $_GET["recherche"])) // la variable existe
{
  $recherche = $_GET["recherche"];
  $recherche = reinitialiser_caracteres_special($recherche);
  $recherche='#'.$recherche."#i";
}  

  $nb_fichier=0;
  $dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
  foreach ($dir as $element) {    
    if($element != '.' && $element != '..') {
      if (!is_dir($directory.'/'.$element)) {

        if($recherche==''){ 
          $fichier[] = $element;
          $extension[$element] = pathinfo($element, PATHINFO_EXTENSION);
          $nb_fichier++;
        }else  if(preg_match($recherche, $element)){ 
          $fichier[] = $element;
          $extension[$element] = pathinfo($element, PATHINFO_EXTENSION);
          $nb_fichier++;
        }
      }
      else {  $dossier[] = $element;  }
    }
  }
?>

<div style="background: #383838; padding-top:5px;"></div>


<div id="nb_music"><?php echo $nb_fichier; ?></div>

<button class="control" id="bp_menu_onglet2" onclick="onglet_move( this, 'music' )">-</button>

<?php
if(!empty($fichier)){
  sort($fichier);

    $i=0;
    foreach($fichier as $lien) { 
      if ($extension[$lien]=='mp3' || $extension[$lien]=='m4a' || $extension[$lien]=='MP3'){
        

       // $lien = iconv("ISO-8859-1","UTF-8",$lien); 

        $lien_music=$directory.'/'.$lien;
        $lien=substr($lien,0,-4);

        $lien_music =  modifier_caracteres_special($lien_music);
        $lien2 =  modifier_caracteres_special($lien);

        if($i%2 == 0){
          ?><div class="music_list_element" id="music_list_element1"><button class="btn_list" id="bp_list1" onclick="add_music(1, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>')" ondblclick="add_music(1, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>',1)">1</button><button class="btn_list" onclick="add_music(2, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>')" ondblclick="add_music(2, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>',1)">2</button><button class="btn_list" style="margin-right:15px" onclick="add_music(0, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>')">+</button><?php echo $lien; ?></div><?php
        } else {
          ?><div class="music_list_element" id="music_list_element2"><button class="btn_list" id="bp_list11" onclick="add_music(1, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>')" ondblclick="add_music(1, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>',1)">1</button><button class="btn_list" onclick="add_music(2, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>')" ondblclick="add_music(2, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>',1)">2</button><button class="btn_list" style="margin-right:15px" onclick="add_music(0, '<?php echo $lien_music; ?>','<?php echo $lien2; ?>')">+</button><?php echo $lien; ?></div><?php
        }


          if(isset( $_GET["playlist"])) // la variable existe
          {
              ?><script> add_music('0', '<?php echo $lien_music; ?>','<?php echo $lien2; ?>','','1') </script><?php
          }
        $i++;
      }
  }
 }
  if(isset( $_GET["playlist"])) // la variable existe
          {
              ?><script> affichage_playlist() </script><?php
          }
?>