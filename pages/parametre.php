<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
require ("../database/databaseFunctions.php");


function getDroit($droit){
		
	switch ($droit) {
			case 3:
				$utilisateur = "Administrateur";
				break;
			case 2:
				$utilisateur = "Résident";
				break;
			case 1:
				$utilisateur = "Application";
				break;
			case 4:
				$utilisateur = "Aucun";
				break;
	}
	return $utilisateur;
}


if(!isset( $_GET["onglet"])) // la variable existe
{
?>
<div id="volet" align="center" >
  
  <?php if( $_SESSION['droit']>=3 ){ ?>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'option')">Paramètres</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'suivi')">Suivi</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'modules')">Modules</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'page')">Pages</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'piece')">Pièces</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'utilisateurs')">Utilisateurs</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('parametre', 'connexions')">Connexions</a></li>
	<?php } ?>

	<br><br>
	<a href="parametre/deconnexion.php" id="deconnexion"><div><img src="img/menu/deconnexion.png" height="50px" /></div></a>
</div>
<div class="big-container" align="center"></div>

<script type="text/javascript">
afficherOngletPpage('parametre', 'option')
</script>

<!-- ******************************************************************************************************************************************************************** -->

<?php } else {

$onglet = $_GET["onglet"];
if($onglet=='option'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

	<div id="titre_pages">Paramètres</div><br><br>		
<!-- _______________________________________zone d'option principales___________________________________________________________  -->

		<br>
		<?php
		$utilisateurs = afficher_database_table("utilisateurs");
		$parametres = afficher_database_table("parametres"); 
		foreach ($parametres as $opt) { 
			$parametre[$opt['id']] = $opt['parametre'];
		}
		
		if( $_SESSION['droit']>=3 ){ ?>
		<div class="input_ligne" style="width:80%;">Nom de de l'intelligence: 
			<input type="text" id="assistant" value="<?php echo $parametre['assistant']; ?>"/>
			<button type="button" onclick="modifier_option('assistant');" >Modifier</button>
			
		</div>
		<div class="input_ligne" style="width:80%;">Adresse IP:
			<input type="text" id="ip_raspberry" value="<?php echo $parametre['ip_raspberry']; ?>"/>
			<button  onclick="afficherMessage('Adresse de votre Raspberry Pi')" style="border-radius:50%; border: 1px solid grey;">i</button>
			<button type="button" onclick="modifier_option('ip_raspberry');" >Modifier</button>
		</div>
		<div class="input_ligne" style="width:80%;">Pièce:
			<select id="piece" >	
				<option><?php echo $parametre['piece']; ?></option>	
				<?php  $pieces = afficher_database_table('piece');	
				foreach ($pieces as $piece) { 
					echo '<option>'.$piece['nom'].'</option>';
				} ?>
			</select>
			<button  onclick="afficherMessage('Pièce où se situe le module d\'intelligence')" style="border-radius:50%; border: 1px solid grey;">i</button>
			<button type="button" onclick="modifier_option('piece');" >Modifier</button>
		</div>
		<div class="input_ligne" style="width:80%;">Ville:
			<input type="text" id="ville" value="<?php echo $parametre['ville']; ?>"/>
			<button  onclick="afficherMessage('Votre ville pour vous donner des infos suplémentaires')" style="border-radius:50%; border: 1px solid grey;">i</button>
			<button type="button" onclick="modifier_option('ville');" >Modifier</button>
		</div>
		<div hidden class="input_ligne" style="width:80%;">Cloud directory:
			<input type="text" id="cloud_directory" value="<?php echo $parametre['cloud_directory']; ?>"/>
			<button  onclick="afficherMessage('Emplacement absolue du dossier où se trouve le cloud')" style="border-radius:50%; border: 1px solid grey;">i</button>
			<button type="button" onclick="modifier_option('cloud_directory');" >Modifier</button>
		</div>
		<div hidden class="input_ligne" style="width:80%;">Backend directory:
			<input type="text" id="backend_directory" value="<?php echo $parametre['backend_directory']; ?>"/>
			<button  onclick="afficherMessage('Emplacement absolue du dossier où se trouve le Back-end')" style="border-radius:50%; border: 1px solid grey;">i</button>
			<button type="button" onclick="modifier_option('backend_directory');" >Modifier</button>
		</div>

	<div class="input_ligne" style="width:80%;" >Lien SMS de notification:
			<input type="text" id="lien_sms" value="<?php echo '***'; ?>"/>
			<button type="button" onclick="modifier_option('lien_sms');" >Modifier</button>
			<button  onclick="afficherMessage('Lien SMS internet pour envoyer des sms par url. (marche avec Free) Exemle: https://smsapi.free-mobile.fr/sendmsg?user=12345678&pass=azertyuio&msg=')" title="Lien SMS internet pour envoyer des sms par url. (marche avec Free) Exemle: https://smsapi.free-mobile.fr/sendmsg?user=12345678&pass=azertyuio&msg=" style="border-radius:50%; border: 1px solid grey;">i</button>
		</div>
		<?php } 
		
	    foreach ($utilisateurs as $utilisateur) { 	
	    if ($utilisateur['pseudo'] == $_SESSION['pseudo']){ ?>

	    <!--div class="input_ligne" style="width:80%;">Mode d'affichage Web App:
			<input type="checkbox" id="check_app" <?php if($utilisateur['mode_affichage']){ ?> checked <?php } ?> onclick=" change_value_textbox('text_mode_affichage')" />
			<label for="check_app"></label>

			<input  hidden type="text" id="text_mode_affichage" value="<?php echo $utilisateur['mode_affichage']; ?>"/>	
			<button type="button" onclick="modifier_mode_affichage(text_mode_affichage, '<?php echo $utilisateur['id_utilisateur']; ?>');" >Modifier</button> 
		</div>
		<br-->

		<table style="width:70%; margin:auto;"><tr>
			<th>Utilisateur</th>
			<th>Password</th>
			<th>Email</th>
		</tr></table> 
		    
	    <div class="input_ligne" style="width:80%;">
		    <input type="text" id="<?php echo $utilisateur['id_utilisateur'].'nom'; ?>" value="<?php echo $utilisateur['pseudo']; ?>"/>
			<input type="password" id="ancien_pass" placeholder="Ancien password"/></td>			
			<input type="password" id="new_pass1" placeholder="Nouveau password"/></td>
			<input type="password" id="new_pass2" placeholder="Nouveau password"/></td>
			<input type="text" id="<?php echo $utilisateur['id_utilisateur'].'email'; ?>" value="<?php echo $utilisateur['email']; ?>"/>
			
			
			<button type="button" onclick="modifier_mdp_utilisateur('<?php echo $utilisateur['id_utilisateur']; ?>','<?php echo $utilisateur['password']; ?>');" >Modifier</button>		<!-- modifier user  -->
		</div>	
	   <?php }} ?>

<?php } if($onglet=='suivi' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

	<div id="titre_pages">Suivi du fonctionnement</div><br><br>
	<br>

	<!--div class="input_ligne" style="width:75%;">
	<input type="password" id="password_reboot" style="width:100px" placeholder="password"/></td>
	<button type="button" onclick="reboot('serveur');" >Redémarer le Serveur</button>
	<button type="button" onclick="reboot('assistant');" >Redémarer l'Assistant</button>
	</div-->
	
	<br><b>Log du serveur</b>
  <div style='text-align:left; overflow-y: scroll; height:400px;' class="block" id="domotix_log" ><?php echo file_get_contents($_SESSION['backendDir'].'/domotixServer.log'); ?><br><br><br></div>

	<div syle="width:100%;"><b>Log de l'assistant</b>
	<iframe class="block" style="height:400px;" src="http://<?php echo $_SESSION['ip_raspberry']; ?>:8080/log?pass=2gBDun342nDK6xXd4a4WR45Xz" ></iframe>
		</div>

  <button onclick="action('refresh');" style="margin: 10px;">Raffraichir la page</button>
  <button onclick="action('reload');" style="margin: 10px;">Redémarer le service</button>
  <button onclick="action('kill');" style="margin: 10px;">Arrêter le service</button>
  <button onclick="action('reboot');" style="margin: 10px;">Redémarer l'Assistant</button>
  <button onclick="action('halt');" style="margin: 10px;">Arrêter l'Assistant</button>
	<br><br><br><br>
	

<script>
document.getElementById('domotix_log').scrollTop = document.getElementById('domotix_log').scrollHeight;
</script>



<?php  }else if($onglet=='page' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	


<div id="titre_pages">Affichage des pages</div><br><br>

        <div class="input_ligne" style="width:50%;">

			<select id="nom" >									<!-- selectbox type nom  -->
				<option value="">Page</option>
				<?php 
				$directory="../pages";
				$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
				foreach ($dir as $element) {   
					if($element != '.' && $element != '..') {
					if (!is_dir($directory.'/'.$element)) {	
					$extension = pathinfo($element, PATHINFO_EXTENSION);
						if($extension=="php"){
							$name = substr($element, 0, -4);
							?><option value="<?php echo $name ?>"><?php echo $name ?></option><?php
						}
					}}
				}
				?>
			</select>

          <select id="utilisateur" >									<!-- selectbox type user  -->
	            <option value="1">Application</option>
              <option value="2">Résident</option>
              <option value="3">Administrateur</option>
						  <option value="4">Aucun</option>
            </select>
          <button type="button" onclick="inserer_page();" > Ajouter </button> <!-- ajouter user  -->
        
      </div>



<!-- ____________________on affiche les données utilisateurs________________________________________________________  --><!--//on affiche les données utilisateurs-->
<br>

	<table style="width:65%; margin:auto;"><tr>
		<th>Page</th>
		<th>Utilisateur</th>
		<th>Supprimer</th>
		<th>Modifier</th>
	</tr></table> 
	
<?php
	$pages = afficher_database_table("droits_pages");

    foreach ($pages as $page) { 
		
		$id_page = $page['id']; 		
?>
	<div class="input_ligne" style="width:60%;" id="<?php echo 'pages_'.$id_page; ?>">

		<select id="<?php echo $id_page.'nom'; ?>" >									<!-- selectbox type nom  -->
			<option value="<?php echo $page['nom']; ?>"><?php echo $page['nom']; ?></option>
			<?php 
			$directory="../pages";
			$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
			foreach ($dir as $element) {   
				if($element != '.' && $element != '..') {
				if (!is_dir($directory.'/'.$element)) {	
				$extension = pathinfo($element, PATHINFO_EXTENSION);
					if($extension=="php"){
						$name = substr($element, 0, -4);
						?><option value="<?php echo $name ?>"><?php echo $name ?></option><?php
					}
				}}
			}
			?>
		</select>			

		<select id="<?php echo $id_page.'utilisateur'; ?>"  >
				  <option value="<?php echo $page['utilisateur']; ?>"><?php echo getDroit($page['utilisateur']); ?></option>
				  <option value="1">Application</option>
              <option value="2">Résident</option>
              <option value="3">Administrateur</option>
						  <option value="4">Aucun</option>
	            </select>
		
		<button type="button" onclick="supprimer_page(<?php echo $id_page; ?>);" >X</button>   	<!-- supprimer user  -->
		<button type="button" onclick="modifier_page(<?php echo $id_page; ?>);" >Modifier</button>		<!-- modifier user  -->	
	</div>
    <?php } ?>


<?php }else if($onglet=='modules' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	


<div id="titre_pages">Affichage des modules</div><br><br>


<!-- _______________________________________zone de texte___________________________________________________________  -->
			  
	
		<div class="input_ligne" style="width:75%;">

		  <select id="nom_module" >									<!-- selectbox type nom  -->
			<option value="">Modules</option>
			<?php 
			$directory="../modules";
			$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
			foreach ($dir as $element) {   
				if($element != '.' && $element != '..') {
				if (!is_dir($directory.'/'.$element)) {	
				$extension = pathinfo($element, PATHINFO_EXTENSION);
					if($extension=="php"){
						$name = substr($element, 0, -4);
						?><option value="<?php echo $name ?>"><?php echo $name ?></option><?php
					}
				}}
			}
			?>
		</select>
          
		<input type="text" id="place_app" placeholder="Application" style="width:110px;"/>			<!-- textbox tempo  -->
		<input type="text" id="place_resident" placeholder="Résident" style="width:110px;"/>
		<input type="text" id="place_administrateur" placeholder="Administrateur" style="width:110px;"/>

		<select id="utilisateur_module" >									<!-- selectbox type user  -->
			<option value="1">Application</option>
              <option value="2">Résident</option>
              <option value="3">Administrateur</option>
						  <option value="4">Aucun</option>
		</select>

		<button type="button" onclick="inserer_module();" >Ajouter</button> 						<!-- ajouter user  -->
        
      </div>



<!-- ____________________on affiche les données fonction________________________________________________________  -->

<br>
	<table style="width:80%; margin:auto;">										
	    <tr>
			<th>Nom</th>
			<th>Place Application</th>
			<th>Place Résident</th>
			<th>Place Admin</th>
			<th>Droits</th>
		</tr>
	</table>

<?php  
	$modules = afficher_database_table("module");
    foreach ($modules as $module) { 	
		$id_module = $module['id_module'];	
?>
	<div class="input_ligne" style="width:80%;" id="<?php echo 'modules_'.$id_module; ?>">
    
		<select id="<?php echo $id_module.'nom_module'; ?>" >									<!-- selectbox type nom  -->
			<option value="<?php echo $module['nom_module']; ?>"><?php echo $module['nom_module']; ?></option>
			<?php 
			$directory="../modules";
			$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
			foreach ($dir as $element) {   
				if($element != '.' && $element != '..') {
				if (!is_dir($directory.'/'.$element)) {	
				$extension = pathinfo($element, PATHINFO_EXTENSION);
					if($extension=="php"){
						$name = substr($element, 0, -4);
						?><option value="<?php echo $name ?>"><?php echo $name ?></option><?php
					}
				}}
			}
			?>
		</select>

		<input type="text" id="<?php echo $id_module.'place_app'; ?>" value="<?php echo $module['place_app']; ?>" style="width:110px;"/>
		<input HIDDEN type="text" id="<?php echo $id_module.'place_app'; ?>" value="<?php echo $module['place_app']; ?>" style="width:110px;"/>
		<td><input type="text" id="<?php echo $id_module.'place_resident'; ?>" value="<?php echo $module['place_resident']; ?>" style="width:110px;"/>
		<input HIDDEN type="text" id="<?php echo $id_module.'place_resident'; ?>" value="<?php echo $module['place_resident']; ?>" style="width:110px;"/>
		<input type="text" id="<?php echo $id_module.'place_administrateur'; ?>" value="<?php echo $module['place_administrateur']; ?>" style="width:110px;"/>
		<select id="<?php echo $id_module.'utilisateur_module'; ?>"  >
      <option value="<?php echo $module['utilisateur_module']; ?>"><?php echo getDroit($module['utilisateur_module']); ?></option>
			  <option value="1">Application</option>
              <option value="2">Résident</option>
              <option value="3">Administrateur</option>
						  <option value="4">Aucun</option>
            </select>

        <button type="button" onclick="supprimer_module(<?php echo $id_module; ?>);" >X</button>		
		<button type="button" onclick="modifier_module('<?php echo $id_module; ?>');" >Modifier</button>		<!-- modifier user  -->
	
	</div>
   <?php } ?>




<?php }else if($onglet=='piece' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

	<div id="titre_pages">Pièces</div><br><br>

<!-- __________________________________________________________________________________________________  -->

	<div class="input_ligne" style="width:40%;">
      <input type="text" id="nom_piece" placeholder="nom de la piece"/>	<!-- textbox nom  -->
      <input type="text" id="detail_piece" placeholder="detail"/>	<!-- textbox détail  -->
      <button type="button" onclick="inserer_piece();" > Ajouter </button><!-- ajouter user  -->
    </div>


<!-- ____________________on affiche les données utilisateurs________________________________________________________  -->
<br>

	<table style="width:40%; margin:auto;">										
	    <tr><th>Pieces</th>
			<th>Détail</th>
			<th>Supprimer</th>
			<th>Modifier</th>
		</tr>
	</table>
	

<?php  
	$pieces = afficher_database_table("piece");
    foreach ($pieces as $piece) { 
		
		$id_piece = $piece['id_piece']; 			
?>
	<div class="input_ligne" style="width:50%;" id="<?php echo 'pieces_'.$id_piece; ?>">
		<input type="text" id="<?php echo $id_piece.'nom'; ?>" value="<?php echo $piece['nom']; ?>"/>			
		<input type="text" id="<?php echo $id_piece.'detail'; ?>" value="<?php echo $piece['detail']; ?>"/>
		
		<button type="button" onclick="supprimer_piece(<?php echo $id_piece; ?>);" >X</button>  	<!-- supprimer user  -->
		<button type="button" onclick="modifier_piece(<?php echo $id_piece; ?>);" >Modifier</button>		<!-- modifier user  -->
	</div>
   <?php } ?>

<?php }if($onglet=='utilisateurs' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

<div id="titre_pages">Utilisateurs</div><br><br>
			  
<!-- _______________________________________zone de texte___________________________________________________________  -->
			  

												  		<!-- zones d'ajout d'utilisateurs  -->
        <div class="input_ligne" style="width:65%;">

          <input type="text" id="nom" placeholder="nom"/>	<!-- textbox nom  -->
		      <input type="text" id="password" placeholder="password" />			<!-- textbox password  -->
		      <input type="text" id="email" placeholder="email" />		<!-- textbox password  -->
          <select type="text" id="type_utilisateur" >								<!-- selectbox type user  -->
	              <option value="1">Application</option>
	              <option value="2">Résident</option>
	              <option value="3">Administrateur</option>
            </select>
            
            
          <button type="button" onclick="inserer_utilisateur();" > Ajouter </button> <!-- ajouter user  -->
      </div>



<!-- ____________________on affiche les données utilisateurs________________________________________________________  -->
	<br>
	<table style="width:70%; margin:auto;">										
	    <tr><th>Utilisateur</th>
			<th>Password</th>
			<th>Email</th>
			<th>Privilèges</th>
			<th>Supprimer</th>
			<th>Modifier</th>
		</tr>
	</table>
	
<?php  
	$utilisateurs = afficher_database_table("utilisateurs");

    foreach ($utilisateurs as $utilisateur) { 
		
		if ( $utilisateur['id_utilisateur'] != $_SESSION['id']){
?>
	<div class="input_ligne" style="width:70%;" id="<?php echo 'utilisateurs_'.$utilisateur['id_utilisateur']; ?>">

		<input type="text" id="<?php echo $utilisateur['id_utilisateur'].'nom'; ?>" value="<?php echo $utilisateur['pseudo']; ?>"/>		
		<input type="text" id="<?php echo $utilisateur['id_utilisateur'].'password'; ?>" placeholder='check/modifier' value="<?php // echo $utilisateur['password']; ?>"/>
		<input type="checkbox" id="<?php echo $utilisateur['id_utilisateur'].'checkbox_modifier_pass'; ?>" value="mdp"> 
		<label for="<?php echo $utilisateur['id_utilisateur'].'checkbox_modifier_pass'; ?>"></label>
		<input type="text" id="<?php echo $utilisateur['id_utilisateur'].'email'; ?>" value="<?php echo $utilisateur['email']; ?>"/>
		<select id="<?php echo $utilisateur['id_utilisateur'].'type'; ?>" >
		          <option value="<?php echo $utilisateur['droit']; ?>"><?php echo getDroit($utilisateur['droit']); ?></option>
				  			<option value="1">Application</option>
	              <option value="2">Résident</option>
	              <option value="3">Administrateur</option>
	            </select>
		
		<button type="button" onclick="supprimer_utilisateur(<?php echo $utilisateur['id_utilisateur']; ?>);" >X</button>		<!-- supprimer user  -->
		<button type="button" onclick="modifier_utilisateur(<?php echo $utilisateur['id_utilisateur']; ?>);" >Modifier</button>		<!-- modifier user  -->
		
	</div>

	<?php } } }else  if($onglet=='connexions' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

<div id="titre_pages">Connexions à Domotix</div><br><br>  

<!-- ____________________on affiche les données connexions________________________________________________________  -->
	<br>
	<table style="width:70%; margin:auto;">										
	    <tr><th>Utilisateurs</th>
			<th>IP de connexion</th>
			<th>Doits</th>
			<th>Date de connexion</th>
			<th>Succes</th>
			<th>
				<select id="affichage_connexion" style="background-color:rgba(0,0,0,0); border:0px;" >
					<option>Tous</option>
					<option>Succès</option>
					<option>Echecs</option>
	      </select></th>
		</tr>
	</table>
	
<?php
$connexions = afficher_database_table("connexion_domotix","date_connection DESC");

$i=0;
    foreach ($connexions as $connexion) {


$i++;
if($i>50)
	break;

?>
	<div class="input_ligne" style="width:70%;" id="<?php echo 'connexion_'.$connexion['id_utilisateur']; ?>" class="<?php echo 'connexion'.$connexion['succes']; ?>">

		<input type="text" value="<?php echo $connexion['pseudo']; ?>"/>		
		<input type="text" value="<?php echo $connexion['ip_utilisateur']; ?>"/>
		<a title="Localisation de la connexion" href="<?php echo'http://www.localiser-IP.com/?ip='.$connexion['ip_utilisateur']; ?>" target="blanck"><button style="border-radius:50%; border: 1px solid grey;">i</button></a>
		
		<input type="text" style="width:50px;" value="<?php echo date('H:m',strtotime($connexion['date_connection'])); ?>"/>

		<input type="text" style="width:50px; <?php if(date('d',strtotime($connexion['date_connection']))== date('d') || date('d',strtotime($connexion['date_connection']))== date('d', strtotime($date_begin. ' - 1 days')) ){ echo 'font-weight:bold;'; } ?>" value="<?php echo date('d/m',strtotime($connexion['date_connection'])); ?>"/>
		
		<input type="text" value="<?php echo getDroit($connexion['droit_utilisateur']); ?>"/>
		<input type="text" style="width:20px;" value="<?php echo $connexion['succes']; ?>"/>


		<button type="button" onclick="supprimer_connexion(<?php echo $connexion['id_utilisateur']; ?>);" >X</button>	
	</div>
   	<?php } } ?>



<br><br>


<script type="text/javascript">		
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

																		// fonctions on et off pour chaques boutons
/*function reboot(type_machine){

	var login = "<?php echo $_SESSION['pseudo']; ?>"
	var password = $('#password_reboot').val()

	if (password != null || password != "") {	
		
		$.ajax({
			type: "POST",
			url: "./api/action.php",
			dataType: "json",
			data: {action:'reboot' , type_machine, login, password },
			"success": function(response){ afficherMessage(response.result); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});	

	} else {
		afficherMessage('Veuillez donner votre mot de passe !');
	}
}*/

  function action(mode){
		ConfirmBox('Ete vous sûre de vouloir effectuer cette opération ?', function() {
			
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {	
        result = JSON.parse(this.responseText).result;
        if(result!= "" || result!= "error"){

          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
          //if ( this.status == 200) {
            afficherMessage('Action effectuée')
          } //}
          xhr.open('GET', result+mode,true);
          xhr.send();

        }else{
          afficherMessage("Une erreur s'est produite.")
        }
      }
    };
    xmlhttp.open("GET", "./api/action.php?action=actionAssistant", true);
    xmlhttp.send();
		})
	}
  

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	function modifier_option(id_option){
	
		var parametre = $('#'+id_option).val()

		
		if( parametre=='' || parametre=='***') {	//si il y en à un de vide

			afficherMessage('Veuillez compléter les champs !');
		} else {														// sinon
			$.ajax({
		 
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_option' , id_option,  parametre },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}
	function modifier_mdp_utilisateur(id_utilisateur,password_utilisateur){
	

		var nom_utilisateur = $('#'+id_utilisateur+'nom').val()
		var ancien_pass = $('#ancien_pass').val()
		var new_pass = $('#new_pass1').val()
		var new_pass2 = $('#new_pass2').val()
		var email = $('#'+id_utilisateur+'email').val()
			
			if( new_pass != new_pass2 ) {	//si il y en à un de vide
				
				afficherMessage("Les nouveaux mots de passes sont  différents");
			} else if( nom_utilisateur=='' ||  ancien_pass == '' ||  new_pass == '' || email=='' ) {	//si il y en à un de vide
				
				afficherMessage('Veuillez compléter les champs !');
			} else {														// sinon

				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'modifier_mdp_utilisateur' , id_utilisateur,  nom_utilisateur, ancien_pass, password_utilisateur, new_pass, email },
					"success": function(response){ afficherMessage(response.result); },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
					});	
			}		
	}

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function inserer_page(){
	
		var nom = $('#nom').val()
		var utilisateur = $('#utilisateur').val()
		
		if( nom=='' ) {	//si nom de vide
			
			afficherMessage('Veuillez compléter le nom !');
		} else {	
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_page' , nom, utilisateur },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('parametre','page') },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}
	function supprimer_page(id_page){		
		ConfirmBox('Ete vous sûre de vouloir suprimer cette page?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'suprimer_page' ,  id_page },
				"success": function(response){ afficherMessage(response.result); $('[id=pages_'+id_page+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
		})
	}
	
	function modifier_page(id_page){
	
		var nom = $('#'+id_page+'nom').val()
		var utilisateur = $('#'+id_page+'utilisateur').val()

		if( nom=='' ) {	
			
			afficherMessage('Veuillez compléter les champs !');
		} else {													
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_page' , id_page,  nom, utilisateur },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function inserer_module(){
	
		var nom_module = $('#nom_module').val()
		var droit = $('#utilisateur_module').val()
		var place_app = $('#place_app').val()
		var place_resident = $('#place_resident').val()
		var place_administrateur = $('#place_administrateur').val()
		
		if( nom_module=='' ) {
			
			afficherMessage('Veuillez compléter les champs !');
		} else {														// sinon

			switch (utilisateur_module) {								//droit pour afficher les pages ou pas
				case "3":
					place_app = place_resident = '';
					break;
				case "2":
					place_app = '';
					break;
			}

			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_module' , nom_module, place_app, place_resident, place_administrateur, droit },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('parametre','modules') },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}
function supprimer_module(id_module){		
	ConfirmBox('Ete vous sûre de vouloir suprimer ce module?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'suprimer_module' ,  id_module },
				"success": function(response){ afficherMessage(response.result); $('[id=modules_'+id_module+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
		})
	}
function modifier_module(id_module){
	
		var nom_module = $('#'+id_module+'nom_module').val()
		var place_app = $('#'+id_module+'place_app').val()
		var	place_resident = $('#'+id_module+'place_resident').val()
		var	droit = $('#'+id_module+'utilisateur_module').val() 
		var	place_administrateur = $('#'+id_module+'place_administrateur').val()
	
		if( nom_module=='' ) {	//si il y en à un de vide
			
			afficherMessage('Veuillez compléter les champs !');
		} else {														// sinon

			switch (droit) {								//droit pour afficher les pages ou pas
				case "3":
					place_app = place_resident = '';
					break;
				case "2":
					place_app = '';
					break;
			}

			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_module' , id_module, nom_module, place_app, place_resident, place_administrateur, droit },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function inserer_piece(){
	
		var nom_piece = $('#nom_piece').val()
		var detail_piece = $('#detail_piece').val()
		
		
		if( nom_piece=='' ) {	//si nom de vide
			
			afficherMessage('Veuillez compléter le nom !');
		} else {													

			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_piece' , nom_piece, detail_piece },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('parametre','piece') },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}
	function supprimer_piece(id_piece){		
		ConfirmBox('Ete vous sûre de vouloir suprimer cette pièce?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'suprimer_piece' ,  id_piece },
				"success": function(response){ afficherMessage(response.result); $('[id=pieces_'+id_piece+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
		})
	}
	
	function modifier_piece(id_piece){
	
		var nom_piece = $('#'+id_piece+'nom').val()
		var detail_piece = $('#'+id_piece+'detail').val()

		if( nom_piece=='' ) {	//si il y en à un de vide
			
			afficherMessage('Veuillez compléter les champs !');
		} else {														// sinon
			$.ajax({
		 
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_piece' , id_piece,  nom_piece, detail_piece },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function inserer_utilisateur(){
	
		var nom_utilisateur = $('#nom').val()
		var password_utilisateur = $('#password').val()
		var email = $('#email').val()
		var droit = $('#type_utilisateur').val()
		
		if( nom_utilisateur=='' ||  password_utilisateur == '' || email=='' ) {	//si il y en à un de vide
			
			afficherMessage('Veuillez compléter les champs !');
		} else {													
			$.ajax({
		 
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_utilisateur' , nom_utilisateur, password_utilisateur, email, droit },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('parametre', 'utilisateurs') },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}
function supprimer_utilisateur(id_utilisateur){
		ConfirmBox('Ete vous sûre de vouloir suprimer cet utilisateur?', function() {
			$.ajax({
		 
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'suprimer_utilisateur' ,  id_utilisateur },
				"success": function(response){ afficherMessage(response.result); $('[id=utilisateurs_'+id_utilisateur+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});
		})
	}
	
function modifier_utilisateur(id_utilisateur){
	
		var nom_utilisateur = $('#'+id_utilisateur+'nom').val()
	
	  if (document.getElementById(id_utilisateur+'checkbox_modifier_pass').checked == true){
			var password_utilisateur = $('#'+id_utilisateur+'password').val()
      $('#'+id_utilisateur+'password').val('')
	  }
		var email = $('#'+id_utilisateur+'email').val()
		var droit = $('#'+id_utilisateur+'type').val()

		if( nom_utilisateur=='' ||  password_utilisateur == '' && document.getElementById(id_utilisateur+'checkbox_modifier_pass').checked == true || email=='' ) {	//si il y en à un de vide
			
			afficherMessage('Veuillez compléter les champs !');
		} else {														// sinon

			$.ajax({
		 
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_utilisateur' , id_utilisateur,  nom_utilisateur, password_utilisateur, email, droit },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
		}
	}

function modifier_mode_affichage(mode,id){
	
	mode_affichage= $('#text_mode_affichage').val()
	$.ajax({
 
		type: "POST",
		url: "./database/action_database.php",
		dataType: "json",
		data: {action:'modifier_mode_affichage' , id, mode_affichage },
		"success": function(response){ afficherMessage(response.result); },
		"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});	
}
function change_value_textbox(cible){
	
	if(document.getElementById('check_app').checked==false){
		document.getElementById(cible).value=0
	}else if(document.getElementById('check_app').checked){
		document.getElementById(cible).value=1
	}
}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$( "#affichage_connexion" ).change(function() {
  
  var affichage_connexion = $('#affichage_connexion').val()
  if(affichage_connexion == 'Succès'){
	  $("[class=connexion1]").css('display', 'block');
	  $("[class=connexion0]").css('display', 'none');
	  
  } else if(affichage_connexion == 'Echecs'){
	  $("[class=connexion1]").css('display', 'none');
	  $("[class=connexion0]").css('display', 'block');
  } else {
	  $("[class=connexion1]").css('display', 'block');
	  $("[class=connexion0]").css('display', 'block');
  }
});

function supprimer_connexion(id_utilisateur){
	ConfirmBox('Ete vous sûre de vouloir suprimer cette connexion?', function() {
		$.ajax({
		
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'supprimer_connexion' ,  id_utilisateur },
			"success": function(response){ afficherMessage(response.result); $('[id=connexion_'+id_utilisateur+']').remove() },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});
	})
	
}

</script>

<?php } ?>
