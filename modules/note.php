<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container">

	<div id="titre_module" onclick="lancer_onglet('blocNote')">Notes</div><br><br>     
	<?php $notes = afficher_database_table("bloc_note");
			foreach ($notes as $note) 
			{
				if('note_rapide' == $note["niveau_note"])
				{
					$text = $note['text_note'];
					?>	
					<button id = "btn_domotix" style="float:right; margin-right:10%;" onclick = "modifier_note('<?php echo $note["id_note"] ?>')">SAVE</button>
					<textarea type="text" id="text_editor_note" style="height:70%; width:85%;"><?php echo html_entity_decode($text); ?></textarea><?php
				} 
			}
	 ?>
</div>

<script type="text/javascript">

function modifier_note(id_note) {

	var text_note = $('#text_editor_note').val() 
	var titre_note = "note";
	var niveau_note = "note_rapide";
		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {	action: 'modifier_note', id_note, niveau_note, titre_note, text_note },
			"success": function(response){ afficherMessage(response.result); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});
} 
  
</script>


