<?php
/*****************************************************************************************************

# Api to set values in database

options
  * add meteo data
  * add alarms
  * add elements in speed note

example of use: 
  * https://user:pass@sjtm.fr/domotix/database/setDbApi.php?request=suiviMeteo&moduleName=aia&temperature=22&brightness=75&pressure=89&humidity=56
  * https://user:pass@sjtm.fr/domotix/database/setDbApi.php?request=note&text="your note to add"
  * https://user:pass@sjtm.fr/domotix/database/setDbApi.php?request=alarme&heure_alarme=10:45&repeter_alarme=0000000&status_alarme=1

return in json format
  * error noResult
  * ok

*****************************************************************************************************/

require('../parametre/digestConnection.php');

$_ = array();
foreach($_POST as $key=>$val){
	$_[$key]=addslashes( htmlentities($val));
}
foreach($_GET as $key=>$val){
	$_[$key]=addslashes( htmlentities($val));
}


if(isset( $_["request"])  ) // la variable existe
{
  $request = $_["request"];
}else{
  header('Location: ../index.php');
  die("acces denied");
}

require("databaseFunctions.php"); 
$result['state']  = 'noResult';


if($request=='suiviMeteo' && isset($_['moduleName']) && $_['moduleName']!=""){

    $temperature = $_['temperature'];
    $brightness = $_['brightness'];
    $pressure = $_['pressure'];
    $humidity = $_['humidity'];
    $moduleName = $_['moduleName'];

    $rep = connexion()->exec("INSERT INTO  `domotix`.`suivi_meteo` (`id_suivi` ,`date_suivi` ,`moduleName` ,`temperature` ,`brightness` ,`pressure` ,`humidity`)VALUES ( NULL , NOW(),'$moduleName','$temperature','$brightness','$pressure','$humidity');");
    if($rep) 
      $result['state']  = 'ok';
  
}else if($request=='alarme'){

    $heure_alarme = $_['heure_alarme'];
    $repeter_alarme = $_['repeter_alarme'];
    $status_alarme = $_['status_alarme'];


    $rep = connexion()->exec("INSERT INTO `alarmes` (`id_alarme`, `action_alarme`, `repeter_alarme`, `heure_alarme`, `status_alarme`, `appareil_alarme`, `cmd`) VALUES (NULL,'','$repeter_alarme','$heure_alarme','$status_alarme','','' )");
    if($rep) 
      $result['state']  = 'ok';
  
}else if($request=='note' && isset($_['text'])){

    $response = connexion()->query("SELECT `text_note` FROM `domotix`.`bloc_note` WHERE niveau_note='note_rapide'");
    while ($datas = $response->fetch()) { $text = $datas; }
    $response->closeCursor(); 
  
    $newText = $text['text_note'].'\n\n'.$_['text'];
    if($newText != ""){
      $rep = connexion()->exec("UPDATE `domotix`.`bloc_note` SET `text_note`='$newText' WHERE niveau_note='note_rapide'");
      if($rep) 			
        $result['state']  = 'ok';
    }	 
}

$result['mysql'] = json_encode( connexion()->errorInfo() );
if( $result['state']!= "none")
	echo '{"result":"'.$result['state'].'","mysql":'.$result['mysql'].' }';



?>


