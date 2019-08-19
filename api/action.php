<?php  
require ('../parametre/security.php');

function secure($string){	return htmlentities(stripslashes($string),NULL,'UTF-8'); }
$_ = array();
foreach($_POST as $key=>$val){	$_[$key]=secure($val); }
foreach($_GET as $key=>$val){	$_[$key]=secure($val); }

 session_start();

require("../database/databaseFunctions.php");


	$action = $_['action'];
  
  $parametres = afficher_database_table("parametres"); 
  foreach ($parametres as $opt) { 
    $parametre[$opt['id']] = $opt['parametre'];
  }
  $ip=$parametre['ip_raspberry'];
  $sms_url=$parametre['lien_sms'];
	$result['state'] = "";

	$pass= "Y22k9Xu9E9Bw7L3vRd4s3ETqk";
	$link= 'http://'.$ip.":8080/action_domotix?pass=".$pass.'&action=';

  
	if($action=="appareil"){

		$etat = $_['etat'];
    $mode = $_['mode'];
		$result['state'] = $link.$etat.'&mode='.$mode;

	}else if(explode("_", $action)[0]=="music"){

		$result['state'] = $link.$action;

	}else if($action == 'sms'){

		$message = $_['message'];
		$lien_sms = $sms_url.($message);
		//header("location: $lien_sms");
 		header("location: ".$lien_sms);
    $result['state']="Sms envoyé";

	} else if($action == 'Erreur_Authentification'){

		$lien_sms = $sms_url."domotix : De nombreuses tentatives de connexion mauvaise pour:".$login;
		header("location: $lien_sms");

	} else if( $action == "actionAssistant" ){
    
    $result['state'] = $link;
    
  } else if( $action == "rebootServer" ){

		$type_machine = $_['type_machine'];
		$password = $_['password'];
		$login = $_['login'];

		$resultat=connexion_user($login, $password);	// Vérification des identifiants dans la db

		if ($resultat['id_utilisateur']){
			if($type_machine == 'serveur'){
				$result['state'] = "Serveur redémaré";
				echo '{"result":"'.$result['state'].'"}';
				exec("sudo /sbin/reboot");
				
			}else if($type_machine == 'assistant'){
				$result['state'] = $link.$action;
			}
		}
	}else{
	
		$result['state'] = $link.$action;
	}

	echo '{"result":"'.$result['state'].'"}';

?>