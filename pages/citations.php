<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php'); 
require ("../database/databaseFunctions.php");

$theme='';
if(!isset( $_GET["theme"])) // la variable existe
{
	
?>
<div id="volet" align="center" >
	<?php if($_SESSION['droit']>=2){ ?> 	
	<li class="mv-item"><a onclick="edit_citation()">Editer</a></li>
	<?php } ?> 	

	<li class="mv-item"><a onclick="afficher_theme('','')">citations</a></li>
	<br>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">De Vie</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Avancer</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Saint</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Bonheur</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Biblique</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Amour</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Proverbe</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Célèbre</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Cinéma</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Définition</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Humour</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Silence</a></li>
	<li class="mv-item"><a onclick="afficher_theme(this.innerHTML,'')">Autres</a></li>
	<br><br>
	<li class="mv-item"><a onclick="afficher_theme('','ordre_note')">Best Of</a></li>

	<input type="search" id="recherche" placeholder="Search" ></input>
</div>
<div class="big-container" align="center"></div>


<!-- ******************************************************************************************************************************************************************** -->

<script type="text/javascript">

	$(".big-container").load("pages/citations.php?theme");
	

	var global_theme = '';
	var global_ordre = ''
	var note=0, note_cheched=0

	function afficher_theme(theme, ordre){

		if(ordre=='')		
			global_theme = theme.replace(/ /g, '%20');
		global_ordre = ordre
		note=0
		$(".big-container").load("pages/citations.php?theme="+global_theme+"&ordre="+ordre);	
	}
	function edit_citation(){

		note=0
		$(".big-container").load("pages/citations.php?theme="+global_theme+"&ordre="+global_ordre+"&edit_citation");	
	}
	
function seach(recherche){
	$(".big-container").load("pages/citations.php?theme="+global_theme+"&recherche="+encodeURIComponent(recherche));
}
$( "#recherche" ).mouseover(function() {
  $("#recherche").animate({'border-radius':'10%','width':'80%'},200);
});
$( "#recherche" ).mouseleave(function() {
	if($("#recherche").val()==''){
    setTimeout(function() {
      $("#recherche").stop().animate({'width':'32px','border-radius':'80%'},500);
    }, 1000);
	}
});
$("#recherche").keydown(function() { seach($("#recherche").val());  });
$("#recherche").keyup(function() {
        seach($("#recherche").val()); 
	if($("#recherche").val()==''){
    setTimeout(function() {
        $("#recherche").stop().animate({'width':'32px','border-radius':'80%'},500);
    }, 1000);
	}	
});
 
	
	function inserer_citation(){
		var text_citation = document.getElementById("text_citation").value;
		var auteur_citation = document.getElementById("auteur_citation").value;
		var theme_citation = document.getElementById("theme_citation").value;
		var note_citation =note;

		text_citation = text_citation
		
		var span = document.getElementById("citation_message");
		if( text_citation=='' || theme_citation=='Thème' ) {	//si il y en à un de vide
			
			span.innerHTML = "Veuillez compléter tous les champs !";
		} else {
			note_cheched=0
			span.innerHTML = "Citation ajouté";
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_citation' , text_citation, auteur_citation, theme_citation, note_citation },
				});	
			afficher_theme(theme_citation,global_ordre)
		}
		
	}
	function suprimer_citation(id_citation){
		ConfirmBox('Are you sure you want to do this?', function() {
		
			var span = document.getElementById("citation_message");
			span.innerHTML = "Citation supprimé";
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'suprimer_citation' ,  id_citation },
				});	
			afficher_theme(global_theme,global_ordre)
		})
	}
	
	var modif =0
	var id_modif = -1
	function modifier_citation(id){
		//alert(note)
		
		if( (id_modif != id || modif) && id_modif!=-1 ){
			$("#text"+id_modif+','+ "#auteur"+id_modif).attr('contenteditable', false);
			$("#theme"+id_modif).css('display', 'none');
		}
		if(!modif || id_modif != id ){
			
			modif=1
			id_modif = id
			$("#text"+id+','+ "#auteur"+id).attr('contenteditable', true);
			$("#theme"+id).css('display', 'block');

		}else{
			modif =0
			var id_citation = id_modif
			var text_citation = document.getElementById("text"+id_modif).innerHTML;
			var auteur_citation = document.getElementById("auteur"+id_modif).innerHTML;
			var theme_citation = document.getElementById("theme"+id_modif).value;
			var note_citation = note

			text_citation = cleanHTML((text_citation))
			auteur_citation = cleanHTML((auteur_citation))

			for(i=1;i<=5;i++){
				if($("#etoile_"+i+id_modif).css('color')=='rgb(255, 255, 0)')
					note_citation++
			}
						
			if( text_citation=="" ) {	//si il y en à un de vide
				alert("Aucune citation noté")
			} else {
				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'modifier_citation' , id_citation, text_citation, auteur_citation, theme_citation, note_citation },
					});	
			}
		}
	}

	function etoile_over(nb,id){	
		for(i=1;i<=5;i++)
			$("#etoile_"+i+id).css('color', '#19608f');
		for(i=1;i<=nb;i++)
			 $("#etoile_"+i+id).css('color', '#114263');
	}
function etoile_out(nb,id){
	    if(note_cheched==0){
	    	for(i=1;i<=5;i++)
				 $("#etoile_"+i+id).css('color', '#19608f');
			for(i=1;i<=nb;i++)
				$("#etoile_"+i+id).css('color', '#114263');
		}else if(id==''){
			for(i=1;i<=5;i++)
				 $("#etoile_"+i).css('color', '#19608f');
			for(i=1;i<=note;i++)
				$("#etoile_"+i).css('color', 'blue');
		}else{
			note_cheched=0
		}
	}
function etoile_click(nb,id){
		note=nb
		for(i=1;i<=5;i++)
				 $("#etoile_"+i+id).css('color', '#19608f');
		for(i=1;i<=note;i++)
			 $("#etoile_"+i+id).css('color', '#114263');
		note_cheched=1
		if(id!=''){
			modifier_citation(id)
		}else{
			for(i=1;i<=note;i++)
			 $("#etoile_"+i+id).css('color', 'blue');
		}
			
	}
	
</script>


<!-- ******************************************************************************************************************************************************************** -->





<?php 
} else {

	$theme = $_GET["theme"];

if(isset( $_GET["edit_citation"])) 
{
	if($_SESSION['edit_citation'])
		$_SESSION['edit_citation'] = 0;
	else
		$_SESSION['edit_citation'] = 1;
} 

$ordre='';
if(isset( $_GET["ordre"])) // la variable existe
{
	$ordre = $_GET["ordre"];
} 
$recherche='';
if(isset( $_GET["recherche"])) // la variable existe
{
	$recherche = urldecode( $_GET["recherche"]);
  $recherche='#'.$recherche."#i";
}
?>

<div id="titre_pages">Citations: <?php echo $theme; ?></div><br><br>
<br>
	

	<?php if($_SESSION['droit']>=2 && $_SESSION['edit_citation']){ ?> 	
	<div class="input_ligne" style="width:85%;">

			<span id="citation_message"></span>	
			<br><label style="padding-right:20%">Ajouter ma Citation: </label>

			<?php
				for ($i=1; $i<=$note; $i++) { ?>
					<b class='etoile' style="color:#114263" id='etoile_<?php echo $i.$id; ?>' onmouseover="etoile_over('<?php echo $i; ?>','')" onmouseout="etoile_out('<?php echo $i; ?>','')" onclick="etoile_click('<?php echo $i; ?>','')">★</b>
				<?php } 
				for ($i=$note+1; $i<=5; $i++) { ?>
					<b class='etoile' id='etoile_<?php echo $i.$id; ?>' onmouseover="etoile_over('<?php echo $i; ?>','')" onmouseout="etoile_out('<?php echo $i; ?>','')" onclick="etoile_click('<?php echo $i; ?>','')">★</b>
				<?php } ?>

			<br>
			<textarea id="text_citation" style="width:80%; height:50px; border:1px solid grey; border-radius: 10px;"></textarea>
			<br>
			<input style="width:40%;" type="text" id="auteur_citation" placeholder="Auteur / référence" />
		
			<select id="theme_citation" >
				<option>Thème</option>
				<option>De Vie</option>
				<option>Avancer</option>
				<option>Saint</option>
				<option>Bonheur</option>
				<option>Biblique</option>
				<option>Amour</option>
				<option>Proverbe</option>
				<option>Célèbre</option>
				<option>Cinéma</option>
				<option>Définition</option>
				<option>Humour</option>
				<option>Silence</option>
				<option>Autres</option>
			</select>
			
			<button type="button" onclick="inserer_citation();" > Ajouter </button>
			<br><br>
	</div><br>
	<?php } ?>


<?php

if($ordre=='') // la variable existe
{
	$citations = afficher_database_table("citations ORDER BY date_citation DESC");
}else if($ordre=='ordre_note'){
	$citations = afficher_database_table("citations ORDER BY note_citation DESC");
}

$j=0;
foreach ($citations as $citation) 
{

	$text_citation = html_entity_decode($citation['citation']);
	$auteur_citation = html_entity_decode($citation['auteur_citation']);

	if( preg_match($recherche,$text_citation) || preg_match($recherche,$auteur_citation) || $recherche=='' ){ 

	if(html_entity_decode($citation['theme_citation']) == $theme || $theme=='' ){
		$j++;
		$id=$citation['id_citation'];

	?><div id="affichage_citation" class='<?php echo $id; ?>' title="<?php	echo "Ajouté le ".date('d/m/y',strtotime($citation["date_citation"])); ?>">
		
		<div style="width:90%; padding-top:10px;" id='text<?php echo $id; ?>'><?php echo $text_citation; ?></div>
		<div style=" width:90%; " align="right" id='auteur<?php echo $id; ?>'><?php echo $auteur_citation ?></div>
		
		<div style="width:90%;"align="right" >	
			<select hidden class="modiftheme_citation" id='theme<?php echo $id; ?>'>
					<option><?php echo $citation['theme_citation']; ?></option>
					<option>De Vie</option>
					<option>Avancer</option>
					<option>Saint</option>
					<option>Bonheur</option>
					<option>Biblique</option>
					<option>Amour</option>
					<option>Proverbe</option>
					<option>Célèbre</option>
					<option>Cinéma</option>
					<option>Définition</option>
					<option>Humour</option>
					<option>Silence</option>
					<option>Autres</option>
				</select>	

				<?php	
				if($_SESSION['droit']>=2  && $_SESSION['edit_citation']){ ?>
						<?php

						$note = $citation['note_citation'];
						for ($i=1; $i<=$note; $i++) { ?>
							<b class='etoile' style="color:#114263" id='etoile_<?php echo $i.$id; ?>' onmouseover="etoile_over('<?php echo $i; ?>','<?php echo $id; ?>')" onmouseout="etoile_out('<?php echo $note; ?>','<?php echo $id; ?>')" onclick="etoile_click('<?php echo $i; ?>','<?php echo $id; ?>')">★</b>
						<?php } 
						for ($i=$note+1; $i<=5; $i++) { ?>
							<b class='etoile' style="color:#19608f" id='etoile_<?php echo $i.$id; ?>' onmouseover="etoile_over('<?php echo $i; ?>','<?php echo $id; ?>')" onmouseout="etoile_out('<?php echo $note; ?>','<?php echo $id; ?>')" onclick="etoile_click('<?php echo $i; ?>','<?php echo $id; ?>')">★</b>
						<?php } ?>
										<button onclick="suprimer_citation('<?php echo $citation['id_citation'] ?>')">X</button>
				<?php }else{ ?>
						<?php
						$note = $citation['note_citation'];
						for ($i=1; $i<=$note; $i++) { ?>
							<b class='etoile' style="color:#114263">★</b>
						<?php } 
						for ($i=$note+1; $i<=5; $i++) { ?>
							<b class='etoile' style="color:#19608f">★</b>
						<?php } ?>
				<?php } ?>
		</div>
		
	</div>	
</div>

<?php } }  }
echo "<div style='position:absolute; z-index:3; top:5px; right:30px; border:1px solid grey; border-radius: 50%; padding:3px;' >".$j."</div>";
?>

<br>




<!-- ******************************************************************************************************************************************************************** -->

<?php } ?>