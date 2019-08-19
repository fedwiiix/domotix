<?php require ('../parametre/security.php'); ?>

<meta charset="utf-8">
<?php 
  session_start();
  $directory= $_SESSION["cloudDir"].$_SESSION["cloudMusicDir"];

if (strpos($directory, '../')) 
  die('error file denied');

$nb_fichier=0;
$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
foreach ($dir as $element) {    
  if($element != '.' && $element != '..') {
    if (is_dir($directory.'/'.$element)) {

      $dossier[] = $element;  }
  }
}

?>

<button class="control" id="bp_menu_onglet1" onclick="onglet_move( this, 'dossier' )">-</button>



<div id="accordion">

<h3  id="folder_list" style="padding-top:5px" onClick="open_folder('<?php echo $directory; ?>')">Musiques</h3>
<div></div>

<?php


if(!empty($dossier)) {
  sort($dossier); 
    foreach($dossier as $lien){

      $directory2=$directory.'/'.$lien;

      ?><h3 id="folder_list" onClick="open_folder('<?php echo $directory2; ?>')"><button class="btn_list" style="margin-right:5px" onclick="folder_in_playlist('<?php echo $directory2; ?>')">+</button><?php echo $lien; ?></h3>
      <div><?php

        
        $dir = scandir($directory2) or die($directory2.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
        foreach ($dir as $element) {    
          if($element != '.' && $element != '..') {
            if (is_dir($directory2.'/'.$element)) {
              $directory3=$directory2.'/'.$element;
             ?><div id="folder_list" style="padding-left:25px;" onClick="open_folder('<?php echo $directory3; ?>')"><button class="btn_list" style="margin-right:5px" onclick="folder_in_playlist('<?php echo $directory3; ?>')">+</button><?php echo $element; ?></div><?php  
                  
                  $dire = scandir($directory3) or die($directory3.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                  foreach ($dire as $elemente) {    
                    if($elemente != '.' && $elemente != '..') {
                      if (is_dir($directory3.'/'.$elemente)) {
                        $directory4=$directory3.'/'.$elemente;
                       ?><NOBR><div id="folder_list" style="padding-left:40px;" onClick="open_folder('<?php echo $directory4; ?>')"><button class="btn_list" style="margin-right:5px" onclick="folder_in_playlist('<?php echo $directory4; ?>')">+</button><?php echo $elemente; ?></div></NOBR><?php  
                     

                        $diree = scandir($directory4) or die($directory4.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                        foreach ($diree as $elementee) {    
                          if($elementee != '.' && $elementee != '..') {
                            if (is_dir($directory4.'/'.$elementee)) {
                              $directory5=$directory4.'/'.$elementee;
                             ?><NOBR><div id="folder_list" style="padding-left:60px;" onClick="open_folder('<?php echo $directory5; ?>')"><button class="btn_list" style="margin-right:5px" onclick="folder_in_playlist('<?php echo $directory5; ?>')">+</button><?php echo $elementee; ?></div></NOBR><?php  
                           

                             }
                            }
                          }



                     }
                    }
                  }
                 
           }
          }
        }//<div class="music_list_element" id="" style="background: #383838;">

        ?></div><?php

   }
}
?>


</div>

 <script>
$( function() {
    $( "#accordion" ).accordion({
      heightStyle: "content"
    });
  } );
  </script>