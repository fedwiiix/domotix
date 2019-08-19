<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container">
  <div id="titre_module">Link</div><br>
  <br><br>
  <input type="text" id="link_name" placeholder=" Nom" style="border-radius:10px 0 0 10px; width:30%; text-align:center;"/>
  <input type="text" id="link_url" placeholder=" Url" style="border-radius:0 0px 0px 0; width:10%; text-align:center;"/>
  <button type="button" onclick="inserer_link()" style="border-radius:0 10px 10px 0; width:20%; border-top:1px solid #006dad; text-align:center;">Ajouter</button>
  <br><br>	
  <br id="new_block">
  <?php
  $links = afficher_database_table("link order by id_link desc");  
	foreach ($links as $link) {
	?>
	<button type="button" id="<?php echo 'link_'.$link['id_link']; ?>" onclick="launchUrl('<?php echo $link['link_url']; ?>')" title="<?php echo $link['link_url']; ?>" style="border-radius:10px 0 0 10px; width:60%;"><?php echo $link['link_name']; ?></button>
	<button type="button" id="<?php echo 'link_'.$link['id_link']; ?>" title="Double click pour effacer un lien" onclick="supprimer_link('<?php echo $link['id_link']; ?>')" style="border-radius:0 10px 10px 0; width:20%;">X</button>	
  <?php } ?> 
	
<br><br>
</div>	

<script type="text/javascript">
	function launchUrl(url){
		window.open(url);
	}
	function inserer_link(){
	
		var link_name = $('#link_name').val()
		var link_url = $('#link_url').val()

		if( link_name=='' || link_url=='' ) {	
			afficherMessage('Veuillez compléter les champs !');
		} else {
			
			$('#link_name').val('')
			$('#link_url').val('')
			block = 	"<button type='button' style='border-radius:10px 0 0 10px; width:60%;' onclick='launchUrl(\""+link_url+"\")'>"+link_name+"</button><button type='button' style='border-radius:0 10px 10px 0; width:20%; margin-left:4px;'>X</button>"

			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_link' , link_name, link_url },
				"success": function(response){ afficherMessage(response.result); $('#new_block').after(block); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});
		}
	}
	function supprimer_link(id_link){	

		ConfirmBox('Ete vous sûre de vouloir suprimer ce lien?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'supprimer_link' ,  id_link },
				"success": function(response){ afficherMessage(response.result); $('[id=link_'+id_link+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});
		});	
	}

</script>
