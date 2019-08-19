<?php
/*****************************************************************************************************

# database action

insert, edit, delete values in the database with an action and assigned variables

*****************************************************************************************************/

require ('../parametre/security.php'); 
  
$start=microtime(true);
function secure($string){
	return addslashes( htmlentities(trim($string),NULL,'UTF-8'));  //addslashes
}

require("databaseFunctions.php"); 		// connection

error_reporting(E_ALL);
//Calage de la date
date_default_timezone_set('Europe/Paris');
//Récuperation et sécurisation de toutes les variables POST et GET
$_ = array();
foreach($_POST as $key=>$val){
	$_[$key]=secure($val);
}
foreach($_GET as $key=>$val){
	$_[$key]=secure($val);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

$result['state']  = 'Aucun changement';
			
switch($_['action']){ // --------Test réception---------------------------------------------------------------------------	

	case 'get_db':		
		
		echo json_encode( afficher_database_table($_['db']));
		$result['state']= "none";
	break;
	case 'inserer_link':		
			
			$rep = connexion()->exec("INSERT INTO `link`(`id_link`, `link_name`, `link_url`) VALUES (NULL,'".$_['link_name']."','".$_['link_url']."')");
			if($rep)
				$result['state']  = 'Lien ajouté';
	break;
	case 'supprimer_link':					
			
			$rep = connexion()->exec("DELETE FROM `link` WHERE id_link=".$_['id_link']."");
			if($rep) 			
				$result['state']  = 'Lien supprimé';
	break;
/********************************************** album *****************************************************************************/
	/*case 'inserer_album':		
			
			$rep = connexion()->exec("INSERT INTO `album`(`id_album`, `nom_album`, `album`, `taille_album`, `date_album`) VALUES (NULL,'".$_['nom_album']."','".$_['album']."','".$_['nb_block']."',NOW())");
			if($rep) 			
				$result['state']  = 'Album ajouté';
	break;
	case 'suprimer_album':					
			
			$rep = connexion()->exec("DELETE FROM `album` WHERE id_album=".$_['id_album']);
			if($rep) 			
				$result['state']  = 'Album supprimé';
	break;	
	case 'modifier_album':					
			
			$rep = connexion()->exec("UPDATE `album` SET `nom_album`='".$_['nom_album']."',`album`='".$_['album']."',`taille_album`='".$_['nb_block']."' WHERE id_album=".$_['id_album']);
			if($rep) 			
				$result['state']  = 'Album modifier';
	break;*/


/********************************************** mode d'affichage *****************************************************************************/	
	case 'modifier_mode_affichage':					

		$rep = connexion()->exec("UPDATE `utilisateurs` SET `mode_affichage`='".$_['mode_affichage']."' WHERE id_utilisateur=".$_['id']."");
		if($rep) 			
			$result['state']  = 'Mode d\'affichage mis à jour';
	break;

	case 'modifier_chauffage':		
			
		$rep = connexion()->exec("UPDATE `option_chauffage` SET `parametre`='".$_['option2_chauffage']."' WHERE id='".$_['option1_chauffage']."'");
		if($rep) 			
			$result['state']  = 'Chauffage mis à jour';
	break;
/********************************************** note *****************************************************************************/
	case 'inserer_note':
			
		$rep = connexion()->exec("INSERT INTO `domotix`.`bloc_note` (`id_note`, `niveau_note`, `titre_note`, `text_note`) VALUES (NULL, '".$_['niveau_note']."', '".$_['titre_note']."', '".$_['text_note']."')");
		if($rep) 			
			$result['state']  = 'Note ajoutée';
	break;
  	case 'supprimer_note':					
		
		$rep = connexion()->exec("DELETE FROM `domotix`.`bloc_note` WHERE id_note=".$_['id_note']."");
		if($rep) 			
			$result['state']  = 'Note supprimmée';
	break;	
	case 'modifier_note':		
					
		$rep = connexion()->exec("UPDATE `domotix`.`bloc_note` SET `niveau_note`='".$_['niveau_note']."',`titre_note`='".$_['titre_note']."',`text_note`='".$_['text_note']."' WHERE id_note='".$_['id_note']."'");
		if($rep) 			
			$result['state']  = 'Note sauvegardée';
	break;

/********************************************** message *****************************************************************************/
	case 'inserer_message':						
			
			$rep = connexion()->exec("INSERT INTO `message`(`id_message`, `auteur_message`, `id_auteur`, `message`, `date_message`) VALUES (NULL,'".$_['auteur_message']."','".$_['id_auteur']."','".$_['text_message']."',NOW())");
			if($rep) 			
				$result['state']  = 'Message posté';
	break;
  	case 'supprimer_message':					
			
			$rep = connexion()->exec("DELETE FROM message WHERE id_message=".$_['id_message']);
			if($rep) 			
				$result['state']  = 'Message supprimé';
	break;	
	case 'modifier_message':
			
			$rep = connexion()->exec("UPDATE `message` SET `auteur_message`='".$_['auteur_message']."', `id_auteur`='".$_['id_auteur']."',`message`='".$_['text_message']."',`date_message`=NOW() WHERE id_message='".$_['id']."'");
			if($rep) 				
				$result['state']  = 'message mis à jour';
	break;

/********************************************** utilisateurs *****************************************************************************/	
	case 'inserer_utilisateur':						
			
      $password=$_['password_utilisateur'];
			$password = sha1(md5(sha1($password)));
			$rep = connexion()->exec("INSERT INTO `utilisateurs`(`id_utilisateur`, `pseudo`, `password`, `email`, `droit`, `mode_affichage`, `date`) VALUES (NULL,'".$_['nom_utilisateur']."','$password','".$_['email']."','".$_['droit']."', 0, NOW())");
			if($rep) 				
				$result['state']  = 'Utilisateur Ajouté';
	break;
	case 'suprimer_utilisateur':					

			$rep = connexion()->exec("DELETE FROM utilisateurs WHERE id_utilisateur=".$_['id_utilisateur']);
			if($rep) 					
				$result['state']  = 'Utilisateur supprimé';
	break;
	case 'modifier_mdp_utilisateur':					// by simple user
      
      $password=$_['password_utilisateur'];
			$ancien_pass = sha1(md5(sha1($ancien_pass)));
            if(strlen($password)<39)
            	$password = sha1(md5(sha1($password)));

            if($ancien_pass==$password && strlen($new_pass) > 5 ){
                $new_pass = sha1(md5(sha1($new_pass)));
				$rep = connexion()->exec("UPDATE `utilisateurs` SET `pseudo`='".$_['nom_utilisateur']."',`password`='$new_pass', `email`='".$_['email']."', `date`=NOW() WHERE id_utilisateur=".$_['id_utilisateur']);   
				if($rep) 				
					$result['state']  = 'Utilisateur mis à jour';
			}else{
				if($ancien_pass!=$_['password_utilisateur'])
					$result['state']  = 'Veuillez vérifier l\'ancien mot de passe';
				if(strlen($new_pass) < 5)
					$result['state']  = 'le nouveau mot de passe est trop court';
			}
	break;
	case 'modifier_utilisateur':			// modif by admin user		

      $password=$_['password_utilisateur'];
			if($password!=NULL){
					$new_pass = sha1(md5(sha1($password)));
					$rep = connexion()->exec("UPDATE `utilisateurs` SET `pseudo`='".$_['nom_utilisateur']."',`password`='$new_pass', `email`='".$_['email']."',`droit`='".$_['droit']."', `date`=NOW() WHERE id_utilisateur=".$_['id_utilisateur']);   
			} else {
					$rep = connexion()->exec("UPDATE `utilisateurs` SET `pseudo`='".$_['nom_utilisateur']."',`email`='".$_['email']."',`droit`='".$_['droit']."', `date`=NOW() WHERE id_utilisateur=".$_['id_utilisateur']);   
			}
			if($rep) 				
				$result['state']  = 'Utilisateur modifié';
	break;

/********************************************** assistantCmd *****************************************************************************/	
	case 'inserer_AssistantCmd':						
			
		$rep = connexion()->exec("INSERT INTO `assistantCmd` (`id`, `commentaire`, `keywords`, `action`, `cmd`, `reponse`) VALUES (NULL, '".$_['commentaire']."', '".$_['keywords']."', '".$_['action_cmd']."', '".$_['cmd']."', '".$_['reponse']."')");
		if($rep) 				
			$result['state']  = 'Commande ajouté';			
	break;
	case 'supprimer_AssistantCmd':
			
			$rep = connexion()->exec("DELETE FROM assistantCmd WHERE id=".$_['id']);
			if($rep) 				
				$result['state']  = 'Commande supprimé';
	break;
	case 'modifier_AssistantCmd':	
			
			$rep = connexion()->exec("UPDATE `assistantCmd` SET `commentaire` = '".$_['commentaire']."', `keywords` = '".$_['keywords']."', `action` = '".$_['action_cmd']."', `cmd` = '".$_['cmd']."', `reponse` = '".$_['reponse']."' WHERE `assistantCmd`.`id` = ".$_['id']);
			if($rep) 				
				$result['state']  = 'Commande mis à jour';
	break;

/********************************************** Piece *****************************************************************************/	
	case 'inserer_piece':						
			
		$rep = connexion()->exec("INSERT INTO `piece`(`id_piece`, `nom`, `detail`) VALUES (NULL,'".$_['nom_piece']."','".$_['detail_piece']."')");
		if($rep) 				
			$result['state']  = 'Pièce ajouté';			
	break;
	case 'suprimer_piece':
			
			$rep = connexion()->exec("DELETE FROM piece WHERE id_piece=".$_['id_piece']);
			if($rep) 				
				$result['state']  = 'Pièce supprimé';
	break;
	case 'modifier_piece':	
			
			$rep = connexion()->exec("UPDATE `piece` SET `nom`='".$_['nom_piece']."',`detail`='".$_['detail_piece']."' WHERE `id_piece`='".$_['id_piece']);
			if($rep) 				
				$result['state']  = 'Pièce mis à jour';
	break;

/********************************************** Droit Page *****************************************************************************/	
	case 'inserer_page':						
			
			$rep = connexion()->exec("INSERT INTO `domotix`.`droits_pages`(`id`, `nom`, `utilisateur`) VALUES (NULL,'".$_['nom']."','".$_['utilisateur']."')");
			if($rep) 
				$result['state']  = 'Page insérée';
	break;
	case 'suprimer_page':
			
			$rep = connexion()->exec("DELETE FROM droits_pages WHERE id=".$_['id_page']);
			if($rep) 
				$result['state']  = 'Page supprimée';
	break;
	case 'modifier_page':	
			
			$rep = connexion()->exec("UPDATE `droits_pages` SET `nom`='".$_['nom']."',`utilisateur`='".$_['utilisateur']."' WHERE `id`=".$_['id_page']);
			if($rep) 
				$result['state']  = 'Pages mis à jour';
	break;

/********************************************** Appareils *****************************************************************************/	
	case 'inserer_appareil':					
			$result['state']  = 'qsdqsd ajouté';
			$rep = connexion()->exec("INSERT INTO `appareils`(`id_appareil`, `nom`, `piece`, `mode`, `code_radio`, `nom_bouton`, `afficher`, `droit`, `date`) VALUES (NULL,'".$_['nom_appareil']."','".$_['piece_appareil']."','".$_['mode_radio']."','".$_['code_radio']."','".$_['nom_bouton']."','".$_['afficher']."','".$_['droit']."',NOW())");
			if($rep) 
				$result['state']  = 'Appareil ajouté';
	break;
	case 'supprimer_appareil':
			
			$rep = connexion()->exec("DELETE FROM appareils WHERE id_appareil=".$_['id_appareil']);
			if($rep) 
				$result['state']  = 'Appareil supprimé';
	break;
	case 'modifier_appareil':	
			
			$rep = connexion()->exec("UPDATE `appareils` SET `nom`='".$_['nom_appareil']."',`piece`='".$_['piece_appareil']."',`mode`='".$_['mode_radio']."',`code_radio`='".$_['code_radio']."',`afficher`='".$_['afficher']."',`nom_bouton`='".$_['nom_bouton']."',`droit`='".$_['droit']."' WHERE id_appareil=".$_['id_appareil']);
			if($rep) 
				$result['state']  = 'Appareil mis à jour';
	break;

/********************************************** telecommande *****************************************************************************/	
	case 'inserer_telecommande':				
			
			$rep = connexion()->exec("INSERT INTO `telecommande`(`id_telecommande`, `detail_telecommande`, `code_telecommande`, `cmd_telecommande`, `appareil_telecommande`, `piece_telecommande`) VALUES (NULL,'".$_['detail_telecommande']."','".$_['code_telecommande']."','".$_['cmd_telecommande']."','".$_['appareil_telecommande']."','".$_['piece_telecommande']."')");
			if($rep) 
				$result['state']  = 'Commande ajoutée';
	break;
	case 'supprimer_telecommande':
			
			$rep = connexion()->exec("DELETE FROM `telecommande` WHERE id_telecommande=".$_['id_telecommande']);
			if($rep) 
				$result['state']  = 'Commande supprimée';
	break;
	case 'modifier_telecommande':	
			
			$rep = connexion()->exec("UPDATE `telecommande` SET `detail_telecommande`='".$_['detail_telecommande']."', `code_telecommande`='".$_['code_telecommande']."',`cmd_telecommande`='".$_['cmd_telecommande']."',`appareil_telecommande`='".$_['appareil_telecommande']."',`piece_telecommande`='".$_['piece_telecommande']."' WHERE id_telecommande='".$_['id_telecommande']."'");
			if($rep) 
				$result['state']  = 'Mise à jour effectuée';
	break;

/********************************************** telecommande Music *****************************************************************************/	
	
	case 'new_telecommande_music':	

			$nom_cmds = ['Play','Stop','Pause','Previous','Next','Volume +','Volume -','1','2','3','4','5','6','7','8','9','10'];

			foreach ($nom_cmds as $nom_cmd) {
				$rep = connexion()->exec("INSERT INTO  `domotix`.`telecommande_music` (`id_telecommande` ,`numero_telecomande` ,`code_telecommande` ,`cmd_telecommande`)VALUES (NULL ,  '".$_['numero_new_telecomande']."',  '','$nom_cmd')");
			}		
			if($rep) 
				$result['state']  = 'Télécommande ajoutée';

	break;
	case 'supprimer_all_telecommande_music':					
			
			$rep = connexion()->exec("DELETE FROM `telecommande_music` WHERE numero_telecomande=".$_['numero_suppr_telecomande']);
			if($rep) 
				$result['state']  = 'Télécommande supprimée';
	break;
	case 'modifier_telecommande_music':	
			
			$rep = connexion()->exec("UPDATE `telecommande_music` SET `code_telecommande`='".$_['code_telecommande']."' WHERE id_telecommande=".$_['id_telecommande']);
			if($rep) 
				$result['state']  = 'Mise à jour effectuée';
	break;

/********************************************** fonctions *****************************************************************************/	
	case 'inserer_fonction':					
    
    $rep = connexion()->exec("INSERT INTO `fonctions` (`id_fonction`, `nom`, `appareil`, `status_appareil`, `date_fonction`, `heure_fonction`, `status_fonction`, `date`) VALUES (NULL,'".$_['nom_fonction']."','".$_['appareil_fonction']."','".$_['status_appareil']."', '".$_['date_fonction']."', '".$_['heure_fonction']."','".$_['status_fonction']."',NOW())");
			if($rep)
				$result['state']  = 'Fonction ajoutée';
	break;
	case 'suprimer_fonction':
	
			$rep = connexion()->exec("DELETE FROM fonctions WHERE id_fonction=".$_['id_fonction']);
			if($rep) 
				$result['state']  = 'Fonction supprimée';
	break;
	case 'modifier_fonction':
				
			$rep = connexion()->exec("UPDATE `fonctions` SET `nom`='".$_['nom_fonction']."',`appareil`='".$_['appareil_fonction']."',`status_appareil`='".$_['status_appareil']."',`date_fonction`='".$_['date_fonction']."',`heure_fonction`='".$_['heure_fonction']."',`status_fonction`='".$_['status_fonction']."' ,`date`=NOW() WHERE id_fonction='".$_['id_fonction']."'");
			if($rep) 
				$result['state']  = 'Fonction modifiée';
	break;
		
/********************************************** Agenda *****************************************************************************/	
	case 'inserer_event':					
			
			$rep = connexion()->exec("INSERT INTO `agenda`(`id_event`, `type_agenda`, `date_event`, `heure_event`, `duree_event`, `event`, `detail_event`, `recurence`, `rappel_event`, `type_rappel`) VALUES (NULL,'".$_['type_agenda']."','".$_['date_evenement']."','".$_['heure_evenement']."', '".$_['temp_evenement']."', '".$_['evenement']."', '".$_['detail_evenement']."', ".$_['recurence'].", '".$_['rapel_evenement']."', '".$_['type_rappel_evenement']."')");
			if($rep) 
				$result['state']  = 'Evénement ajouté';
	break;
	case 'suprimer_event':
	
			$rep = connexion()->exec("DELETE FROM `domotix`.`agenda` WHERE `agenda`.`id_event` =".$_['id_event']);
			if($rep) 
				$result['state']  = 'Evénement supprimé';
	break;
	case 'modifier_event':
				
			$rep = connexion()->exec("UPDATE `agenda` SET `type_agenda`='".$_['type_agenda']."', `date_event`='".$_['date_evenement']."',`heure_event`='".$_['heure_evenement']."',`duree_event`='".$_['temp_evenement']."',`event`='".$_['evenement']."',`detail_event`='".$_['detail_evenement']."',`recurence`=".$_['recurence'].",`rappel_event`='".$_['rapel_evenement']."',`type_rappel`='".$_['type_rappel_evenement']."' WHERE `agenda`.`id_event`=".$_['id_event']);
			if($rep) 	
				$result['state']  = 'Agenda mis à jour';
	break;

	case 'modifier_avertir_saint':
				
			$rep = connexion()->exec("UPDATE `agenda_saint` SET `avertir_saint`=".$_['value_saint']." WHERE saint_mois=".$_['mois_saint']." AND saint_jour=".$_['jour_saint']);
			if($rep) 
				$result['state']  = 'Demande prise en compte';
	break;

		
/********************************************** Options *****************************************************************************/	
	case 'modifier_option':
				
			$rep = connexion()->exec("UPDATE `parametres` SET `parametre`='".$_['parametre']."' WHERE `id`='".$_['id_option']."'");
			if($rep) 
				$result['state']  = 'Option mise à jour';
	break;

/********************************************** Alarmes *****************************************************************************/	
	case 'inserer_alarme':					
    
			$rep = connexion()->exec("INSERT INTO `alarmes` (`id_alarme`, `action_alarme`, `repeter_alarme`, `heure_alarme`, `status_alarme`, `appareil_alarme`, `cmd`) VALUES (NULL,'".$_['a1']."','".$_['a2']."','".$_['a3']."','".$_['a4']."','".$_['a5']."','".$_['a6']."' )");
			if($rep) 
				$result['state']  = 'Alame ajoutée';
	break;
	case 'suprimer_alarme':
	
			$rep = connexion()->exec("DELETE FROM alarmes WHERE id_alarme=".$_['id_alarme']."");
			if($rep) 
				$result['state']  = 'Alarme supprimée';
	break;
	case 'modifier_alarme':
				
			$rep = connexion()->exec("UPDATE `alarmes` SET `action_alarme`='".$_['a1']."',`repeter_alarme`='".$_['a2']."',`heure_alarme`='".$_['a3']."',`status_alarme`='".$_['a4']."',`appareil_alarme`='".$_['a5']."',`cmd`='".$_['a6']."' WHERE id_alarme=".$_['id_alarme']);
			if($rep) 
				$result['state']  = 'Alarme modifiée';
	break;
	
/********************************************** modules *****************************************************************************/	
	case 'inserer_module':					
	
			$rep = connexion()->exec("INSERT INTO `module`(`id_module`, `nom_module`, `place_app`, `place_resident`, `place_administrateur`, `utilisateur_module`, `date`) VALUES (NULL,'".$_['nom_module']."','".$_['place_app']."','".$_['place_resident']."','".$_['place_administrateur']."','".$_['droit']."',NOW())");	
			if($rep) 
				$result['state']  = 'Module ajouté';
	break;
	case 'suprimer_module':
	
			$rep = connexion()->exec("DELETE FROM module WHERE id_module=".$_['id_module']);
			if($rep) 
				$result['state']  = 'Module supprimé';
	break;
	case 'modifier_module':
				
			$rep = connexion()->exec("UPDATE `module` SET `nom_module`='".$_['nom_module']."',`place_app`='".$_['place_app']."',`place_resident`='".$_['place_resident']."',`place_administrateur`='".$_['place_administrateur']."',`utilisateur_module`='".$_['droit']."',`date`=NOW() WHERE id_module='".$_['id_module']."'");
			if($rep) 
				$result['state']  = 'Module mis à jour';
	break;

/********************************************** citations *****************************************************************************/	
	case 'inserer_citation':				
	
			$rep = connexion()->exec("INSERT INTO `citations`(`id_citation`, `citation`, `auteur_citation`, `theme_citation`, `note_citation`, `date_citation`) VALUES (NULL,'".$_['text_citation']."','".$_['auteur_citation']."','".$_['theme_citation']."','".$_['note_citation']."',NOW())");
			if($rep) 
				$result['state']  = 'Citation ajoutée';
	break;
	case 'suprimer_citation':
	
			$rep = connexion()->exec("DELETE FROM `citations` WHERE id_citation=".$_['id_citation']);
			if($rep) 
				$result['state']  = 'Citation supprimée';
	break;
	case 'modifier_citation':
	
			$rep = connexion()->exec("UPDATE `citations` SET `note_citation`='".$_['note_citation']."',`citation`='".$_['text_citation']."',`auteur_citation`='".$_['auteur_citation']."',`theme_citation`='".$_['theme_citation']."' WHERE id_citation=".$_['id_citation']);
			if($rep) 
				$result['state']  = 'Citation modifiée';
	break;
	case 'supprimer_$rep = connexion':
	
			$rep = connexion()->exec("DELETE FROM `".$_['rep']." = connexion_domotix` WHERE id_utilisateur=".$_['id_utilisateur']);
			if($rep) 
				$result['state']  = 'Connexion supprimée';
	break;


	default:
		$result['state'] = 'Aucune action définie';
	break;
}

//echo mysql_query($rep);

$result['mysql'] = json_encode( connexion()->errorInfo() );
if( $result['state']!= "none")
	echo '{"result":"'.$result['state'].'","mysql":'.$result['mysql'].' }';

?>
