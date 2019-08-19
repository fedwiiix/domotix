<?php 	
if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
{
	header('Location: default.php');
}
require("database/databaseFunctions.php");	

function secure($string){
	return addslashes( htmlentities($string,NULL,'UTF-8'));
}
$_ = array();
foreach($_POST as $key=>$val){
	$_[$key]=secure($val);
}
foreach($_GET as $key=>$val){
	$_[$key]=secure($val);
}

/*$ip_utilisateur = $_SERVER["REMOTE_ADDR"];																		// get ip for french ip alone
$country = file_get_contents('https://ipapi.co/'.$ip_utilisateur.'/country');
if( $country != 'FR' )	
	header('Location: ../index.php'); */

$connexions = afficher_database_table_connexion("connexion_domotix"); 			// fail2ban
$i=0;
foreach ($connexions as $connexion) {
	if($connexion['ip_utilisateur'] == $ip_utilisateur ){
		if( $connexion['succes'] == 0){
			$i++;
			if($connexion['droit_utilisateur']==6){
				header('Location: ../index.php');
			}
		} else { break; }
	} 
}

if($i>9){
	inserer_connexion_domotix($login,$ip_utilisateur,6,0);
	$_SESSION['message'] = 'Vous êtes banni';
  
} else if(isset($_['submit']) || (isset($_COOKIE['pseudo']) && isset($_COOKIE['password'])) ){
	
	if( (empty($_['user']) || empty($_['pass']) ) && (!$_COOKIE['pseudo'] && !$_COOKIE['password']) ) 							//si il y en à un de vide
	{
		$_SESSION['message'] = "Veuillez completer les champs";
		
	} else {
    

		if(isset($_SESSION['test_mdp']) && $_SESSION['test_mdp']>5){
			header('Location: ../index.php');	
		}else if(isset($_SESSION['test_mdp']) && $_SESSION['test_mdp']>=3){
			$_SESSION['test_mdp']++;
		} else {
	
      if(isset($_['user']) && isset($_['pass'])){			// on récupère les données
        
        $passwd = $_['pass'];
			  $login = $_['user'];           
      }else{
        $Cle = sha1(md5("MotDePasseSuperSecretsjtm"));
        $passwd = Decrypte($_COOKIE['password'],$Cle); 	
        $login =  Decrypte($_COOKIE['pseudo'],$Cle);
      }
				

			$resultat=connexion_user($login, $passwd);							// Vérification des identifiants dans la db

			if (!$resultat['id_utilisateur'])									// vérif du résultat
			{	
				inserer_connexion_domotix($login,$ip_utilisateur,'',0);
				if(isset($_SESSION['test_mdp'])){
					$_SESSION['test_mdp']++;
					if($_SESSION['test_mdp']==3){
						$_SESSION['message']="Attendez quelques minutes";
					}else{
						$_SESSION['message'] = $_SESSION['test_mdp'].' - Information incorectes'.'<br>';
					}
				}else{
					$_SESSION['test_mdp']=1;
					$_SESSION['message'] = $_SESSION['test_mdp'].' - Information incorectes'.'<br>';
				}
				
			}else{															   // si il s'est bien connecté
        
        session_start();												// on démarre la session
        $ini =parse_ini_file( getcwd()."/parametre/server.ini");        // get init values
        $_SESSION["cloudDir"]=$ini["cloudDir"];
        $_SESSION["cloudInitDir"]=$ini["cloudInitDir"];
        $_SESSION["cloudMusicDir"]=$ini["cloudMusicDir"];
        $_SESSION["cloudTrashDir"]=$ini["cloudTrashDir"];

        $_SESSION['backendDir']=$ini["backendDir"];

        
				$_SESSION['id'] = $resultat['id_utilisateur'];					// on renseigne les variables globales
				$_SESSION['pseudo'] = $login;
				//$_SESSION['email'] = $resultat['email'];
				
				$_SESSION['droit']=$resultat['droit'];							                            // droit d'accès aux pages et aux modules
				$_SESSION['droit_page']=afficher_database_table_connexion("droits_pages");		  // on met le droit d'laffichages des pages en globale
				$_SESSION['droit_module']=afficher_database_table_connexion("module");

				$parametres = afficher_database_table_connexion("parametres");								  // on renseigne également le nom da l'assistant car on n'appelle pas les fonctions db dans default
				

				foreach ($parametres as $opt) { 
					$_SESSION[$opt['id']] = $opt['parametre'];
				}
				inserer_connexion_domotix($login,$ip_utilisateur,$resultat['droit'],1);

        if(isset($_['cookie']) ){
          $Cle = sha1(md5("MotDePasseSuperSecretsjtm")); 
          $cryptLogin= Crypte($login,$Cle);
          $cryptPass= Crypte($passwd,$Cle);
          
          setcookie('pseudo', $cryptLogin, time() + 3*24*3600, '/domotix/', null, true, false); // On écrit un cookie durré 3j
          setcookie('password', $cryptPass, time() + 3*24*3600, '/domotix/', null, true, false);
        }
        
				$_SESSION['message']= 'Vous êtes connecté';
        header('Location: default.php');
			}				
		}
	}
} 

//*********************************************************************************************** Crypt

function GenerationCle($Texte,$CleDEncryptage) 
  { 
  $CleDEncryptage = md5($CleDEncryptage); 
  $Compteur=0; 
  $VariableTemp = ""; 
  for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) 
    { 
    if ($Compteur==strlen($CleDEncryptage))
      $Compteur=0; 
    $VariableTemp.= substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1); 
    $Compteur++; 
    } 
  return $VariableTemp; 
  }

function Crypte($Texte,$Cle) 
  { 
  srand((double)microtime()*1000000); 
  $CleDEncryptage = md5(rand(0,32000) ); 
  $Compteur=0; 
  $VariableTemp = ""; 
  for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) 
    { 
    if ($Compteur==strlen($CleDEncryptage)) 
      $Compteur=0; 
    $VariableTemp.= substr($CleDEncryptage,$Compteur,1).(substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1) ); 
    $Compteur++;
    } 
  return base64_encode(GenerationCle($VariableTemp,$Cle) );
  }

function Decrypte($Texte,$Cle) 
  { 
  $Texte = GenerationCle(base64_decode($Texte),$Cle);
  $VariableTemp = ""; 
  for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) 
    { 
    $md5 = substr($Texte,$Ctr,1); 
    $Ctr++; 
    $VariableTemp.= (substr($Texte,$Ctr,1) ^ $md5); 
    } 
  return $VariableTemp; 
  }







?>
