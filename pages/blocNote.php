<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');

if(!isset( $_GET["note"]))
{
?>
<div class = "affichage_note"></div>

<script type = "text/javascript">

  lancer_note('')

  function lancer_note(id_note) {

    if(id_note!='')
      $(".affichage_note").load('pages/blocNote.php?note='+id_note);
    else
      $(".affichage_note").load('pages/blocNote.php?note');
  }
  function bouton_theme(titre_theme,id){
    $('.supprimer_theme').css('display', 'block');
    $('.modifier_theme').css('display', 'block');
  }
  function inserer_note() {

    var text_note = document.getElementById("text_editor_note").value;
    var titre_note = document.getElementById("titre_note").value;
    var niveau_note = document.getElementById("niveau_note").value;

    if (text_note == '' || titre_note == 'Nouvelle note') { //si il y en à un de vide

      afficherMessage("Veuillez compléter La note!");
    } else {

      $.ajax({
        type: "POST",
        url: "./database/action_database.php",
        dataType: "json",
        data: { action: 'inserer_note', niveau_note, titre_note, text_note },
        "success": function(response){ afficherMessage(response.result); },
        "error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
      });
      lancer_onglet('blocNote')
    }
  }
  function inserer_theme() {

    var titre_note = document.getElementById("titre_note").value;
    var niveau_note = "titre_theme";
    var text_note = "";

    if (titre_note == '' || titre_note == 'Nouvelle note') { //si il y en à un de vide

      afficherMessage("Veuillez compléter Le nom du thème!");
    } else {
      $.ajax({
        type: "POST",
        url: "./database/action_database.php",
        dataType: "json",
        data: { action: 'inserer_note', niveau_note, titre_note, text_note },
        "success": function(response){ afficherMessage(response.result); },
        "error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
      });
      lancer_onglet('blocNote')
    }
  }
  function supprimer_note(id_note) {

    ConfirmBox('Are you sure you want to do this?', function() {
      $.ajax({
        type: "POST",
        url: "./database/action_database.php",
        dataType: "json",
        data: {	action: 'supprimer_note',	id_note },
        "success": function(response){ afficherMessage(response.result); },
        "error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
      });
      lancer_onglet('blocNote')
    });
  }

  function modifier_note(id_note) {

    var text_note = document.getElementById("text_editor_note").value;
    var titre_note = document.getElementById("titre_note").value;
    var niveau_note = document.getElementById("niveau_note").value;

    if(niveau_note==id_note){
      var text_note = "";
      niveau_note = "titre_theme";
    }

    if (titre_note == '') { //si il y en à un de vide

      afficherMessage("Veuillez compléter les champs !");
    } else { 

      $.ajax({
        type: "POST",
        url: "./database/action_database.php",
        dataType: "json",
        data: {	action: 'modifier_note', id_note, niveau_note, titre_note, text_note },
        "success": function(response){ afficherMessage(response.result); },
        "error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
      });
    }
  } 
</script>


<?php }else if(isset( $_GET["note"])){
  
require("../database/databaseFunctions.php");
$notes = afficher_database_table("bloc_note");
?>

<div id="volet" align="center" style="height:96%;">
	<div id="accordion">
	<h3 hidden ><li class="mv-item"><a>Ajouter</a></li></h3>
	<div></div>
	<?php	
		foreach ($notes as $note){
			if($note["niveau_note"] == "titre_theme"){ ?>
			<h3  onclick="bouton_theme('<?php echo $note['niveau_note'] ?>','<?php echo $note['id_note'] ?>')"><li class="mv-item"><a><?php echo html_entity_decode($note['titre_note']);?></a></li></h3><div><br>
			<?php	$i=0; 	
			$theme = $note["id_note"];
			foreach ($notes as $note) 
			{
				if($note["niveau_note"] == $theme && $note["niveau_note"] != "titre_theme"){ $i++;
					?><h4 onclick="lancer_note('<?php echo $note['id_note'] ?>')" title="<?php echo $note["titre_note"] ?>"><li class="mv-item"><a style="padding-top:0px; margin-top: 0px; padding-bottom:0px; margin-bottom: 0px;"><?php echo html_entity_decode($note['titre_note']); ?></a></li></h4><?php	
			} }
			if( $_GET["note"]=='modifier' ){ ?>
				<div align="center" style = "width:100%;" >
				<?php if( $i==0 ){ ?>
					<button style="width:40%; border-radius:28px 0 0 28px;" onclick = "supprimer_note('<?php echo $theme ?>')">supprimer theme</button>
				<?php }else{ ?>
					<button style="width:40%; border-radius:28px 0 0 28px;" onclick = "alert('Veuillez supprimer chaque note avant!')">supprimer theme</button>
				<?php } ?>
				<button style="width:40%; border-radius:0 28px 28px 0;" onclick = "lancer_note('<?php echo $note['id_note'] ?>')">modifier theme</button>
				</div>
			<?php }
		?></div><?php			
			} 
		}
	?>
	</div><br><br>
	<?php if( $_GET["note"]=='' ){ ?> 
    <button id = "bouton_oval" style="" onclick = "lancer_note('modifier')">Modifier les thèmes</button><br>	
    <button id = "bouton_oval" style="width:30%;" onclick = "lancer_note('new')">+</button>
  <?php } else if( $_GET["note"]=='new' ) { ?>
    Ajouter<br>
    <button id = "bouton_oval" style="width:30%; border-radius:28px 0 0 28px;" onclick = "lancer_note('')">Retour</button>
    <button id = "bouton_oval" style="width:30%; border-radius:0;" onclick = "inserer_note()">Note</button>
    <button id = "bouton_oval" style="width:30%; border-radius:0 28px 28px 0;" onclick = "inserer_theme()">Theme</button>
    <br>
  <?php } else if( $_GET["note"]=='modifier' ) { ?>	
    <button id = "bouton_oval" style="width:30%;" onclick = "lancer_note('')">Retour</button>	
  <?php } else { ?>	
    <button id = "bouton_oval" style="width:30%; border-radius:28px 0 0 28px;" onclick = "lancer_note('')">Retour</button>	
    <button id = "bouton_oval" style="width:30%; border-radius:0 28px 28px 0; " onclick = "modifier_note('<?php echo $_GET["note"] ?>')">SAVE</button>
  <?php } ?>
</div>


<div class = "big-container">
<div id = "titre_pages">Bloc Note</div ><br><br><?php

if($_GET["note"] == 'new' ){					// nouvelle note
		
	?><input id="titre_note" value="Nouvelle note" style="background:rgba(0,0,0,0); ">
	<select id="niveau_note" style="background:rgba(0,0,0,0);">
		<?php foreach ($notes as $note) 
		{ if($note["niveau_note"] == "titre_theme")
			{		echo '<option value="'.$note['id_note'].'">'.$note['titre_note'].'</option>';	}
		} ?>
	</select>
	<textarea type="text" id="text_editor_note"></textarea><?php
}else if($_GET["note"] != 'modifier' ){
	foreach ($notes as $note) 
	{
		if($_GET["note"] == $note["id_note"] && $note["niveau_note"]=='titre_theme' )					// modifier la note
		{
			$text = $note['text_note'];
			?><input id="titre_note" value="<?php echo stripslashes($note['titre_note']); ?>" style="background:rgba(0,0,0,0); ">
			
			<select id="niveau_note" style="background:rgba(0,0,0,0); ">
				<option value="titre_theme">Thème</option>
			</select>	
			<textarea hidden type="text" id="text_editor_note"><?php echo html_entity_decode($text); ?></textarea><?php
		}else
		if($_GET["note"] == $note["id_note"])					// modifier la note
		{
			$text = $note['text_note'];
			?><input id="titre_note" value="<?php echo stripslashes($note['titre_note']); ?>" style="background:rgba(0,0,0,0); ">
			
			<select id="niveau_note" style="background:rgba(0,0,0,0); "><?php
				foreach ($notes as $note) 
				{ if($note["niveau_note"] == "titre_theme")
					{		echo '<option value="'.$note['id_note'].'">'.$note['titre_note'].'</option>';	}
				}  ?>
			</select>	
			<button id = "bouton_oval" style="min-width:40px; border-radius:0;" onclick = "supprimer_note('<?php echo $_GET["note"] ?>')">x</button>
			<textarea type="text" id="text_editor_note"><?php echo html_entity_decode($text); ?></textarea><?php
		} 
	}
}
?></div>
	
<script>

$(function() {
    $( "#accordion" ).accordion({
      heightStyle: "content"
    });
  });
</script>
	
<?php } ?>
