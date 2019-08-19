<?php 
/*****************************************************************************************************

Api to get music or folder -> to use after in audio player 

example of use: https://user:pass@sjtm.fr/domotix/musicPlayer/playerApi.php?action=getListDir&path=Classiques

after -> use with python vlc: 
  * player = vlc.MediaPlayer(https://sjtm.fr/domotix/musicPlayer/player.php?file=Classiques/music.m4a&pass=pass)

## action
  * getListDir -> folder list 
  * getListMusic -> music list
  * getOneMusic -> get one random music 

## path
  * path in initial cloud directory
  * path="" for get initial directory
  
## output in json format
  * ["music1","music2","music3"]

*****************************************************************************************************/

require('../parametre/digestConnection.php');  

if(isset( $_GET["action"]) && isset( $_GET["path"])  ) {
  $action = addslashes( htmlentities($_GET["action"],NULL,'UTF-8'));
  $path = addslashes( htmlentities($_GET["path"],NULL,'UTF-8'));
  
  if (strpos($path, '../')) 
    die('error file denied');
}else{
echo "access denied";
header('Location: ../index.php');
exit(0);
}

$ini=parse_ini_file( getcwd()."/../parametre/server.ini");
$initial_directory = $ini["cloudDir"].$ini["cloudMusicDir"]."/";

if($initial_directory==""){  exit(0); } //protect directories if ini is corrupt
$directory=$initial_directory.$path;

if($action=="getListDir"){
  
  $result = "[";
  $dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); 
	foreach ($dir as $element) {   	
		if($element != '.' && $element != '..') {
      if (is_dir($directory.'/'.$element)) {
          $result .= '"'.$element.'",';
      }
		}
	}
  $result = substr_replace($result, "]", -1);
  
}else if($action=="getListMusic"){
  
  $result = "[";
  $dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas');
	foreach ($dir as $element) {   	
		if($element != '.' && $element != '..') {

      if (!is_dir($directory.'/'.$element)) {

        $extension = pathinfo($element, PATHINFO_EXTENSION);
        if ($extension=='mp3' || $extension=='m4a'){
          $result .= '"'.$element.'",';
				}
			}
		}
	}
  $result = substr_replace($result, "]", -1);
  
}else if($action=="getOneMusic"){
  
  $dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas');
	foreach ($dir as $element) {   	
		if($element != '.' && $element != '..') {
      if (!is_dir($directory.'/'.$element)) {
        $extension = pathinfo($element, PATHINFO_EXTENSION);
        if ($extension=='mp3' || $extension=='m4a'){
          $fichier[] = $element;
          $nb_fichier++;
        }
			}
		}
	}
  $result = '["'.$fichier[rand(0,$nb_fichier)].'"]';
  
}
echo $result;

?>


