<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
require ("../database/databaseFunctions.php");

if(isset( $_GET["onglet"])) // la variable existe
{
	$messages = afficher_database_table("message ORDER BY `message`.`date_message` DESC");			//on affiche les données
	$message_today=0;
	foreach ($messages as $message) 
	{
		if( date("d/m/Y") == date('d/m/Y',strtotime($message["date_message"])))
			$message_today=1;
		
	if($_SESSION['pseudo'] == $message['auteur_message'] && $_SESSION['id'] == $message['id_auteur']){
		?><div id="affichage_message" style="float:right;"><?php
	} else {
		?><div id="affichage_message" style="float:left; "><?php
	}	
		
    ?><h4 style="margin-left:20px;" title="<?php	echo " le ".date('d/m/y',strtotime($message["date_message"])); ?>">
      <span style="float:left; "><?php	echo $message['auteur_message'].':'; ?></span><?php	
      if($_SESSION['pseudo'] == $message['auteur_message'] && $_SESSION['id'] == $message['id_auteur'] || $_SESSION['droit']==3 ){ ?> 
        <button style="float:right; margin-right:20px;" onclick="supprimer_message('<?php echo $message['id_message'] ?>')">X</button>
      <?php	} ?><p style="tex-align:left;"><?php echo $message['message']; ?></p>
      </h4>
	</div>
<?php } 

} else { ?>

<!-- ******************************************************************************************************************************************************************** -->
	<div id="volet" align="center" ></div>
	<div class="big-container">

		<div id="titre_pages">Messagerie</div><br><br>
		<textarea type="text" id="text_editor_message"><?php echo html_entity_decode($text); ?></textarea>
		<button id="" onclick="inserer_message()">Poster</button>
		<div class="affichage_messages" align="center" style="height:80%; width:90%; padding:5%; overflow-y: scroll;"></div>
	</div>

<!-- ******************************************************************************************************************************************************************** -->

	<script type="text/javascript">		

		$(".affichage_messages").load("pages/messagerie.php?onglet=1");

		setInterval(function(){ $(".affichage_messages").load("pages/messagerie.php?onglet=1"); }, 3000);
		function inserer_message(){
			var text_message = document.getElementById("text_editor_message").value;
			var auteur_message = "<?php echo $_SESSION['pseudo'] ?>";
			var id_auteur = "<?php echo $_SESSION['id'] ?>";
			text_message = cleanHTML(text_message)
			document.getElementById("text_editor_message").textContent = ""

			if( text_message=='' ) {	//si il y en à un de vide
				
				afficherMessage("Veuillez compléter Le message!");
			} else {
				
				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'inserer_message' , auteur_message, id_auteur, text_message },
					"success": function(response){ afficherMessage(response.result);	$(".affichage_messages").load("pages/messagerie.php?onglet=1"); },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
					});	
			}
			setTimeout(function() {	span.innerHTML ='' }, 1000);
		}
		function supprimer_message(id_message){
			ConfirmBox('Ete vous sûre de vouloir suprimer ce message?', function() {
			
				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'supprimer_message' ,  id_message },
					"success": function(response){ afficherMessage(response.result);	$(".affichage_messages").load("pages/messagerie.php?onglet=1"); },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }	
					});	
		
			})
			setTimeout(function() {	span.innerHTML ='' }, 1000);
		}
		function modifier_message(id_message){
			
			var text_message = document.getElementById("text_editor_message").value;
			var auteur_message = "<?php echo $_SESSION['pseudo'] ?>";
			
			if( text_message=='' ) {	//si il y en à un de vide
							
				afficherMessage("Veuillez compléter le champ !");
			} else {														// sinon
			
				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'modifier_message' , id_message, auteur_message, text_message },
					"success": function(response){ afficherMessage(response.result); },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
					});	
				lancer_onglet('messagerie')
			}
			setTimeout(function() {	span.innerHTML ='' }, 1000);
		}
	</script>

<?php } ?>