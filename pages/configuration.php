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
    case 0:
      $utilisateur = "Aucun";
      break;
  }
	return $utilisateur;
}

$sous_onglet='alarme';
if(isset( $_GET["sous_onglet"])) // la variable existe
{
	$sous_onglet = $_GET["sous_onglet"];
} 

if(isset( $_GET["onglet"])) // la variable existe
{
	$onglet = $_GET["onglet"];
} else{

?>

<div id="volet" align="center" >
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'alarme')">Alarmes</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'fonction')">Fonctions</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'assistantCmd')">Assistant</a></li>
	
	<?php if( $_SESSION['droit']==1 ){ ?>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'suivi')">Suivi</a></li>
  <?php }else if( $_SESSION['droit']>=3 ){ ?>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'appareil')">Appareils</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'receptions_appareil')">Télécommande</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'musique_serveur')">Musique</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('configuration', 'detections')">Détections</a></li>
	<?php } ?>
</div>

<div class="big-container"></div>

<script type="text/javascript">
afficherOngletPpage('configuration', '<?php echo $sous_onglet; ?>');
</script>
<?php } ?>
 
<?php if($onglet=='alarme'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$appareils = afficher_database_table('appareils'); ?>	

	<div id="titre_pages">Alarmes</div><br><br>

	<br>
	<table style="width:65%; margin:auto;">										
    <tr>
      <th>Heure</th>
      <th>Date</th>
      <th>Action</th>
      <th>Statut</th>
      <th>Répéter</th>
		</tr>
	</table> 
	<div class="input_ligne" style="width:85%;">
		<input type="time" value="<?php echo date("H:i");?>" id="heure_alarme" />

    <input type="checkbox" id="Lu"/><label for="Lu">Lu</label>
		<input type="checkbox" id="Ma"/><label for="Ma">Ma</label>
		<input type="checkbox" id="Me"/><label for="Me">Me</label> 
		<input type="checkbox" id="Je"/><label for="Je">Je</label>
		<input type="checkbox" id="Ve"/><label for="Ve">Ve</label>
		<input type="checkbox" id="Sa"/><label for="Sa">Sa</label>
		<input type="checkbox" id="Di"/><label for="Di">Di</label>

		<select id="action_alarme" >
			<option>sonnerie</option>
		  <option>Bip</option>
		  <option>Musique</option>
		  <option>aucune</option>
		</select>
		
	  <select type="text" id="appareil_alarme" onchange="changeAppareil('','cmd','cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>"><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" id="cmd" >							
      <option value="">Commande</option>
        <option style="display:none;" id="cmdAppareil" value=""></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option style="display:none;" id="<?php echo "cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>

    <select id="status_alarme">
      <option value="1">Activée</option>
      <option value="0">Désactivée</option>
		</select>
		
		<button type="button" onclick="inserer_alarme();" > Ajouter </button>
	</div>		
<br>
<!-- ____________________on affiche les données utilisateurs________________________________________________________  -->
	<table style="width:70%; margin:auto;">										
    <tr>
      <th>Heure</th>
			<th>Date</th>
			<th>Action</th>
			<th>Statut</th>
			<th>Répéter</th>
			<th>ajouter</th>
		</tr>
	</table>
	<div id="add_element"></div>			

	<?php  $alarmes = afficher_database_table("alarmes"); 
	foreach ($alarmes as $alarme) { ?>

   <div class="input_ligne" id="<?php echo 'alarme_'.$alarme['id_alarme']; ?>" style="width:90%;">

    <input type="time" id="<?php echo $alarme['id_alarme'].'heure'; ?>" value="<?php echo $alarme['heure_alarme']; ?>"/>

    <?php $recurence = $alarme['repeter_alarme']; ?>

    <input type="checkbox" id="<?php echo $alarme['id_alarme'].'Lu'; ?>" <?php if($recurence[1]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Lu'; ?>">Lu</label>
		<input type="checkbox" id="<?php echo $alarme['id_alarme'].'Ma'; ?>" <?php if($recurence[2]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Ma'; ?>">Ma</label>
		<input type="checkbox" id="<?php echo $alarme['id_alarme'].'Me'; ?>" <?php if($recurence[3]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Me'; ?>">Me</label> 
		<input type="checkbox" id="<?php echo $alarme['id_alarme'].'Je'; ?>" <?php if($recurence[4]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Je'; ?>">Je</label>
		<input type="checkbox" id="<?php echo $alarme['id_alarme'].'Ve'; ?>" <?php if($recurence[5]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Ve'; ?>">Ve</label>
		<input type="checkbox" id="<?php echo $alarme['id_alarme'].'Sa'; ?>" <?php if($recurence[6]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Sa'; ?>">Sa</label>
		<input type="checkbox" id="<?php echo $alarme['id_alarme'].'Di'; ?>" <?php if($recurence[0]=='1'){ echo 'checked'; } ?>/><label for="<?php echo $alarme['id_alarme'].'Di'; ?>">Di</label>
		
		<select id="<?php echo $alarme['id_alarme'].'action'; ?>" >
		  <option><?php echo $alarme['action_alarme']; ?></option>
		  <option>sonnerie</option>
		  <option>Bip</option>
		  <option>Musique</option>
		  <option>aucune</option>
		</select>
     
     <select type="text" id="<?php echo $alarme['id_alarme'].'appareil'; ?>" onchange="changeAppareil(<?php echo $alarme['id_alarme']; ?>,'cmd',<?php echo $alarme['id_alarme']; ?>+'cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>" <?php if($appareil['id_appareil']==$alarme['appareil_alarme']){ echo "selected"; } ?>><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" class="cmd" id="<?php echo $alarme['id_alarme']; ?>cmd" >							
        <option value="<?php echo $alarme["cmd"]; ?>"><?php echo $alarme["cmd"]; ?></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option <?php if($appareil['id_appareil']!=$alarme['appareil_alarme']){ echo 'style="display:none;"'; } ?> id="<?php echo $alarme['id_alarme']."cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>

		<select id="<?php echo $alarme['id_alarme'].'status'; ?>">
		  <option value="<?php echo $alarme['status_alarme']; ?>"><?php echo ($alarme['status_alarme'] ? 'Activée' : 'Désactivée'); ?></option>
		  <option value="1">Activée</option>
		  <option value="0">Désactivée</option>
		</select>
							  
		<button type="button" onclick="suprimer_alarme(<?php echo $alarme['id_alarme']; ?>);" >X</button>
		<button type="button" onclick="modifier_alarme(<?php echo $alarme['id_alarme']; ?>);" >Modifier</button>
	
	</div>
    <?php } ?>
	
<?php }else if($onglet=='assistantCmd' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

  <div id="titre_pages">Commandes de l'assistant</div><br><br>
    <br>
 <?php 
   $cmds = afficher_database_table("assistantCmd"); 
  $appareils = afficher_database_table('appareils');
    $recherche = '';                                                         
    if(isset( $_GET["recherche"])) 
    {
      $recherche = '#'.$_GET["recherche"]."#i";
    }                                                         
  ?>
  <input type="text" id="recherche" placeholder="Rechercher" onfocus="this.setSelectionRange(this.value.length, this.value.length);" value="<?php echo $_GET["recherche"]; ?>"></input>
  <br><br>

  <div class="input_ligne" style="width:80%; padding-top:10px;">
    <b style="width:120px; display:inline-block; text-align:right;">Commentaire: </b><input type="text" id="commentaire" placeholder="Commentaire" style="width:70%; text-align:left; margin-left:2%; margin-left:2%;"/><br>	
    <b style="width:120px; display:inline-block; text-align:right;">Mots clés: </b><input type="text" id="keywords" placeholder="Keywords" value='[["motClé1","motClé2"],["motClé3","motClé4"]]' style="width:70%; text-align:left; margin-left:2%;"/><br>	
    <b style="width:120px; display:inline-block; text-align:right;">Réponse: </b><input type="text" id="reponse" placeholder="Réponse" value='["réponse1","réponse2"]' style="width:70%; text-align:left; margin-left:2%;"/><br>

    <select type="text" id="action" onchange="changeAppareil('','cmd','cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>"><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" id="cmd" >							
      <option value="">Commande</option>
        <option style="display:none;" id="cmdAppareil" value=""></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option style="display:none;" id="<?php echo "cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>
    <button type="button" onclick="inserer_AssistantCmd();" > Ajouter </button>
  </div>
<br><br>

  <?php                                                                                                                 
  foreach ($cmds as $cmd) { 
    
    if( $recherche=='' || preg_match($recherche, $cmd['commentaire']) || preg_match($recherche, $cmd['keywords']) || preg_match($recherche, $cmd['reponse'])){ 
    $id = $cmd['id'];
      
  ?>

    <div class="input_ligne" style="width:80%; padding-top:10px;" id="assistantCmd_<?php echo $id; ?>">
      <b style="width:120px; display:inline-block; text-align:right;">Commentaire: </b><input type="text" id="<?php echo $id; ?>commentaire" value="<?php echo str_replace('"','&quot;',$cmd["commentaire"]); ?>" style="width:70%; text-align:left; margin-left:2%;"/><br>	
      <b style="width:120px; display:inline-block; text-align:right;">Mots clés: </b><input type="text" id="<?php echo $id; ?>keywords" style="width:70%; text-align:left; margin-left:2%;" value="<?php echo str_replace('"','&quot;',$cmd["keywords"]); ?>" /><br>	
      <b style="width:120px; display:inline-block; text-align:right;">Réponse: </b><input type="text" id="<?php echo $id; ?>reponse" style="width:70%; text-align:left; margin-left:2%;" value="<?php echo str_replace('"','&quot;',$cmd["reponse"]); ?>" /><br>
      
      <select type="text" id="<?php echo $id; ?>action" onchange="changeAppareil(<?php echo $id; ?>,'cmd',<?php echo $id; ?>+'cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>" <?php if($appareil['id_appareil']==$cmd["action"]){ echo "selected"; } ?>><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" class="cmd" id="<?php echo $id; ?>cmd" >							
        <option value="<?php echo $cmd["cmd"]; ?>"><?php echo $cmd["cmd"]; ?></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option <?php if($appareil['id_appareil']!=$cmd["action"]){ echo 'style="display:none;"'; } ?> id="<?php echo $id."cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>
      
     <button type="button" onclick="supprimer_AssistantCmd(<?php echo $id; ?>);" >X</button>
      <button type="button" onclick="modifier_AssistantCmd(<?php echo $id; ?>);" >Modifier</button>
    </div>

  <?php } } ?>


<script>
$('#recherche').focus();
$("#recherche").keyup(function() {
  $(".big-container").load("pages/configuration.php?onglet=assistantCmd&recherche="+$("#recherche").val());	
})
</script>

<?php }else if($onglet=='assistantCmd'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

 <div id="titre_pages">Commandes de l'assistant</div><br><br>
    <br>

 <?php 
   $cmds = afficher_database_table("assistantCmd"); 
    $recherche = '';                                                         
    if(isset( $_GET["recherche"])) 
    {
      $recherche = '#'.$_GET["recherche"]."#i";
    }                                                         
  ?>
  <input type="text" id="recherche" placeholder="Rechercher" onfocus="this.setSelectionRange(this.value.length, this.value.length);" onkeyup="assistantCmdSearch(this.value)" value="<?php echo $_GET["recherche"]; ?>"></input>
  <br><br>
  <?php                                                                                                                 
  foreach ($cmds as $cmd) { 
    
    if( $recherche=='' || preg_match($recherche, $cmd['commentaire']) || preg_match($recherche, $cmd['keywords']) || preg_match($recherche, $cmd['reponse'])){ 
    $id = $cmd['id'];
  ?>
    <div class="input_ligne" style="width:80%; padding:10px auto;" id="assistantCmd_<?php echo $id; ?>">
      <b style="width:120px; display:inline-block; text-align:right;">Mots clés: </b><input type="text" id="<?php echo $id; ?>keywords" style="width:70%; text-align:left; margin-left:2%;" value="<?php echo str_replace('"','&quot;',$cmd["keywords"]); ?>" /><br>	
      <b style="width:120px; display:inline-block; text-align:right;">Réponse: </b><input type="text" id="<?php echo $id; ?>reponse" style="width:70%; text-align:left; margin-left:2%;" value="<?php echo str_replace('"','&quot;',$cmd["reponse"]); ?>" /><br>
   </div>
  <?php } } ?>
<script>
$('#recherche').focus();
function assistantCmdSearch(value){
  $(".big-container").load("pages/configuration.php?onglet=assistantCmd&recherche="+value);	
}
</script>


<?php }else if($onglet=='appareil' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	


<div id="titre_pages">Appareils électriques</div><br><br><br>		<!-- titre --> 
 
<!-- __________________________________________zone input________________________________________________________  -->
	
	<table style="width:70%; margin:auto;">										
	    <tr><th>Appareil</th>
			<th>pièce</th>
			<th>Code</th>
			<th>Bp1/Bp2</th>
			<th>Privilèges</th>
		</tr>
	</table> 

	<div class="input_ligne" style="width:85%;">

		<input type="text" id="nom_appareil" placeholder="nom"/>
		
		<select id="piece_appareil" >								<!-- selectbox appareil dans la db piece -->
			<?php  $pieces = afficher_database_table('piece');		//  on affiche les pieces dispo 	
			foreach ($pieces as $piece) { ?>
			<option><?php echo $piece['nom']; ?></option>
			<?php } ?>
      <option></option>
		</select>
    <select id="mode" >								
			<option>Radio 315</option>
			<option>Radio 433</option>
			<option>Radio HC-12</option>
		</select>
			
		<input type="text" id="code_radio" placeholder="code radio" />
	  	<input type="text" id="nom_bouton" placeholder="bp1/bp2" />
    
    <input type="checkbox" id="afficher" title="Afficher dans le module de boutons"/><label for="afficher" style="color:grey; margin:0 2px;"> Afficher</label>
	  
	  	<select id="droit_appareil" >
		  <option value='1'>Application</option>
		  <option value='2'>Résident</option>
		  <option value='3'>Administrateur</option>
		</select>
	  	<button type="button" onclick="inserer_appareil();" > Ajouter </button>  <!-- ajouter-->
			
	</div>


<!-- ____________________on affiche les données appareil________________________________________________________  -->
<br>
	<table style="width:70%; margin:auto;">										
	    <tr><th>Appareil</th>
			<th>pièce</th>
			<th>Code</th>
			<th>Bp1/Bp2</th>
			<th>Privilèges</th>
		</tr>
	</table> 

	<?php  $appareils = afficher_database_table('appareils');
			$pieces = afficher_database_table('piece');

	foreach ($appareils as $appareil) { 
		$id_appareil= $appareil['id_appareil']; ?>

	<div class="input_ligne" id="<?php echo 'appareil_'.$id_appareil; ?>" style="width:90%;">

		<input type="text" id="<?php echo $id_appareil.'nom'; ?>" value="<?php echo $appareil['nom']; ?>"/>			
		<select id="<?php echo $id_appareil.'piece'; ?>" >								
			<option><?php echo $appareil['piece']; ?></option>
			<?php
			foreach ($pieces as $piece) { ?>
			<option><?php echo $piece['nom']; ?></option>
			<?php } ?>
      <option></option>
		</select>
    
    <select id="<?php echo $id_appareil.'mode'; ?>" >								
			<option><?php echo $appareil['mode']; ?></option>
		  <option>Radio 315</option>
		  <option>Radio 433</option>
			<option>Radio HC-12</option>
		</select>

		<input type="text" id="<?php echo $id_appareil.'code'; ?>" value="<?php echo $appareil['code_radio']; ?>"/> 
		<input type="text" id="<?php echo $id_appareil.'nom_bouton'; ?>" value="<?php echo $appareil['nom_bouton']; ?>"/>
    <input type="checkbox" id="<?php echo $id_appareil.'afficher'; ?>" <?php if($appareil['afficher']=='true'){ echo 'checked'; } ?>/><label for="<?php echo $id_appareil.'afficher'; ?>" style="color:grey; margin:0 2px;"> Afficher</label>

		<select id="<?php echo $id_appareil.'droit'; ?>" >
		  <option value="<?php echo $appareil['droit']; ?>"><?php echo getDroit($appareil['droit']); ?></option>
		  <option value='1'>Application</option>
		  <option value='2'>résident</option>
		  <option value='3'>Administrateur</option>
		  <option value='4'>Aucun</option>
		</select>
		
		<button type="button" onclick="supprimer_appareil(<?php echo $id_appareil; ?>);" >X</button>		<!-- suprimer user  -->
		<button type="button" onclick="modifier_appareil(<?php echo $id_appareil; ?>);" > Modifier </button>		<!-- modifier user  -->

	
																		<!-- boutons on/off pour commander chaque appareils différents -->
		

		<?php 
			$nom = explode("/", $appareil['nom_bouton']);
			$cmd = explode("/", $appareil['code_radio']);

			for($i=0;$i<sizeof($nom);$i++){
				echo '<button type="button" class="btn btn-default btn-lg" onclick="bp_appareil(\''.$id_appareil.'\',\''.$cmd[$i].'\',\''.$appareil['mode'].'\');" >'.$nom[$i].'</button>';
			}	
  		echo "</div>";
  	} ?>

  	<br>
		
<?php  }else if($onglet=='receptions_appareil' && $_SESSION['droit']>=3){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	$telecommandes = afficher_database_table('telecommande');
	$appareils = afficher_database_table('appareils');
	$pieces = afficher_database_table('piece');
	?>


	<div id="titre_pages">Télécommande</div><br><br><br>		<!-- titre --> 
 
<!-- __________________________________________zone input________________________________________________________  -->

	<table style="width:70%; margin:auto;">	
			<th>Appareil</th>									
			<th>Code réception</th>
			<th>On/Off</th>
			<th>Pièce</th>
			<th>Droits</th>
		</tr>
	</table> 
	<div class="input_ligne" style="width:85%;">

		<input type="text" style="width:auto" id="detail_telecommande" placeholder="Detail"/>
		<input type="text" id="code_telecommande" placeholder="Code radio"/>

    
    
    <select type="text" id="appareil_telecommande" onchange="changeAppareil('','cmd_telecommande','cmdAppareil'+this.value)" >							
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>"><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" id="cmd_telecommande" >							
      <option value="">Commande</option>
        <option style="display:none;" id="cmdAppareil" value=""></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option style="display:none;" id="<?php echo "cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>

	  	<button type="button" onclick="inserer_telecommande();" > Ajouter </button>  <!-- ajouter-->
	</div>

<!-- ____________________on affiche les données appareil________________________________________________________  -->
	<br>
	<table style="width:70%; margin:auto;">										
	    <tr><th>Appareil</th>									
			<th>Code réception</th>
			<th>On/Off</th>
			<th>Pièce</th>
			<th>Droits</th>
		</tr>
	</table> 
	<?php  	
	foreach ($telecommandes as $telecommande) { 

		$id_telecommande = $telecommande['id_telecommande']; ?>

	<div class="input_ligne" id="<?php echo 'telecommande_'.$id_telecommande; ?>" style="width:90%;">

    <input type="text" id="<?php echo $id_telecommande.'detail_telecommande'; ?>" style="width:auto" value="<?php echo $telecommande['detail_telecommande']; ?>"/>
		<input type="text" id="<?php echo $id_telecommande.'code_telecommande'; ?>" value="<?php echo $telecommande['code_telecommande']; ?>"/> 
    
    <select type="text" id="<?php echo $id_telecommande; ?>appareil_telecommande" onchange="changeAppareil(<?php echo $id_telecommande; ?>,'cmd_telecommande',<?php echo $id_telecommande; ?>+'cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>" <?php if($appareil['id_appareil']==$telecommande['appareil_telecommande']){ echo "selected"; } ?>><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" id="<?php echo $id_telecommande; ?>cmd_telecommande" >							
        <option value="<?php echo $telecommande['cmd_telecommande']; ?>"><?php echo $telecommande['cmd_telecommande']; ?></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option <?php if($appareil['id_appareil']!=$telecommande['appareil_telecommande']){ echo 'style="display:none;"'; } ?> id="<?php echo $id_telecommande."cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>
		
		<button type="button" onclick="supprimer_telecommande(<?php echo $id_telecommande; ?>);" >X</button>		<!-- suprimer user  -->
		<button type="button" onclick="modifier_telecommande(<?php echo $id_telecommande; ?>);" > Modifier </button>		<!-- modifier user  -->

  		<?php 
			echo "</div>";
  	} ?>

<?php///////////////////////*************************************************************************************/////////////?>


<?php }else if($onglet=='fonction'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $appareils = afficher_database_table('appareils');?>	



<div id="titre_pages">Fonctions de temporisation</div><br><br><br>

	<table style="width:70%; margin:auto;">										
	    <tr><th>Fonction</th>
			<th>Appareil</th>
			<th>Status</th>
			<th>Date</th>
			<th>Heure</th>
			<th>Ajouter</th>
		</tr>
	</table> 

	<div class="input_ligne" style="width:90%;">

    <input type="text" id="nom_fonction" placeholder="fonction"/>
    <select type="text" id="appareil_fonction" onchange="changeAppareil('','status_appareil','cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>"><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" id="status_appareil" >							
      <option value="">Commande</option>
        <option style="display:none;" id="cmdAppareil" value=""></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option style="display:none;" id="<?php echo "cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>
    
    


         <input type="date" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y+1-m-d");?>" min="<?php echo date("Y-m-d");?>" id="date_fonction" />
		 <input type="time" value="<?php echo date("H:i");?>" id="heure_fonction" />	

		 <select id="status_fonction" >								<!-- selectbox status appareils -->
			<option>Activée</option>
			<option>Désactivée</option>
          </select>		
          
                    
          <button type="button" onclick="inserer_fonction();" >Ajouter</button>						<!-- ajouter user  -->
       
    </div>

<!-- ____________________on affiche les données fonction________________________________________________________  -->

	<br>
	<table style="width:70%; margin:auto;">										
	    <tr><th>Fonction</th>
			<th>Appareil</th>
			<th>Status</th>
			<th>Date</th>
			<th>Heure</th>
			<th>Supprimer</th>
			<th>Modifier</th>
		</tr>
	</table> 

	
<?php  $fonctions = afficher_database_table("fonctions");
    foreach ($fonctions as $fonction) { 

		$id_fonction = $fonction['id_fonction'];
    if($_SESSION['droit']>=$fonction['droit']){
      
?><div class="input_ligne" id="<?php echo 'func_'.$id_fonction; ?>" style="width:95%;">

    <input type="text" id="<?php echo $id_fonction.'nom'; ?>" value="<?php echo $fonction['nom']; ?>"/></td>			
  
    <select type="text" id="<?php echo $id_fonction.'appareil'; ?>" onchange="changeAppareil(<?php echo $id_fonction; ?>,'status_appareil',<?php echo $id_fonction; ?>+'cmdAppareil'+this.value)" >							
      <option value="">Action</option>
      <option value="">Aucune</option>
      <?php foreach ($appareils as $appareil) { ?>
        <option value="<?php echo $appareil['id_appareil']; ?>" <?php if($appareil['id_appareil']==$fonction['appareil']){ echo "selected"; } ?>><?php echo $appareil['nom'].' - '.$appareil['piece']; ?></option>
      <?php } ?>
    </select>
    <select type="text" class="cmd" id="<?php echo $id_fonction.'status_appareil'; ?>" >							
        <option value="<?php echo  $fonction['status_appareil']; ?>"><?php echo  $fonction['status_appareil']; ?></option>
        <?php
        foreach ($appareils as $appareil) {	
          $nom = explode("/", $appareil['nom_bouton']);
          for($i=0;$i<sizeof($nom);$i++){ ?>
            <option <?php if($appareil['id_appareil']!=$fonction['appareil']){ echo 'style="display:none;"'; } ?> id="<?php echo $id_fonction."cmdAppareil".$appareil['id_appareil']; ?>" value="<?php echo $nom[$i]; ?>"><?php echo $nom[$i]; ?></option>
        <?php } }  ?>
     </select>
    
	<input type="date" id="<?php echo $id_fonction.'date_fonction'; ?>" min="<?php echo date("Y-m-d");?>" value="<?php echo $fonction['date_fonction']; ?>"/>			
	<input type="time" id="<?php echo $id_fonction.'heure_fonction'; ?>" value="<?php echo $fonction['heure_fonction']; ?>"/>

	<select id="<?php echo $id_fonction.'status_fonction'; ?>" >
    		<option><?php echo $fonction['status_fonction']; ?></option>								<!-- selectbox status appareils -->
			<option>Activée</option>
			<option>Désactivée</option>
          </select>

	<button type="button" onclick="suprimer_fonction(<?php echo $id_fonction; ?>);" >X</button>				<!-- suprimer user  -->
	<button type="button" onclick="modifier_fonction(<?php echo $id_fonction; ?>);" >Modifier</button>		<!-- modifier user  -->
  

<?php /*
foreach ($appareils as $appareil) { 
	if( $appareil['nom'] == $fonction['appareil'] ){	
		$id_appareil = $appareil['id_appareil']; 
		$status = $fonction['status_appareil']; ?>
    	<button type="button" class="btn btn-default btn-lg" onclick="bp_appareil(<?php echo $id_appareil; ?>,'<?php echo $status; ?>');" ><?php echo $appareil['nom']; ?></button>
<?php } } */ ?>


</div>
	
   <?php } 
} ?>
<div id="fonction" ></div>
</div>
<?php }else if($onglet=='musique_serveur' && $_SESSION['droit']>=3){	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 	?>
	
<div id="titre_pages">Serveur de Musique</div><br><br><br>		<!-- titre --> 


	<?php  $telecommandes = afficher_database_table('telecommande_music');
	$numero_telecomande_max = 0;
	foreach ($telecommandes as $telecommande) { 
		if( $telecommande['numero_telecomande'] > $numero_telecomande_max )
			$numero_telecomande_max = $telecommande['numero_telecomande']; 
	}

	?><button type="button" onclick="new_telecommande_music(<?php echo $numero_telecomande_max+1; ?>);" > Nouvelle </button><?php

	for ($i=1; $i <= $numero_telecomande_max; $i++) {
		$j=0;
    
		echo '<div class="input_ligne" style="width:70%;" id="telecommande_music_'.$i.'" style="padding:15px;">';
    
		foreach ($telecommandes as $telecommande) { 		// on le fait pour tout les appareils
		
			$id_telecommande = $telecommande['id_telecommande']; 

			if( $telecommande['numero_telecomande'] == $i ){ 

				if(!$j){
					?><b>Télécommande <?php echo $j+1; ?>: </b><button type="button" id="<?php echo 'telecommande_music_'.$i; ?>" onclick="supprimer_all_telecommande_music(<?php echo $i; ?>);" > Supprimer </button>
					<table style="width:70%; margin:auto;">										
						<tr><th>Commande</th>
							<th>Code réception</th>
						</tr>
					</table><?php
					$j=1;
				} ?>			
				<?php if( intval($telecommande['cmd_telecommande'])>0 &&  intval($telecommande['cmd_telecommande'])<11 ){ echo "Playlist "; } echo $telecommande['cmd_telecommande']; ?>
				<input hidden type="text" id="<?php echo $id_telecommande.'numero_telecomande'; ?>" value="<?php echo $telecommande['numero_telecomande']; ?>"/>
				<input hidden type="text" id="<?php echo $id_telecommande.'cmd_telecommande'; ?>" value="<?php echo $telecommande['cmd_telecommande']; ?>"/>
				<input type="text" id="<?php echo $id_telecommande.'code_telecommande'; ?>" value="<?php echo $telecommande['code_telecommande']; ?>"/>

				<button type="button" onclick="modifier_telecommande_music(<?php echo $id_telecommande; ?>);" > Modifier </button><br>
		  		
	<?php }

	 } echo '</div>'; } ?><br><br>
		
		
<?php }else if($onglet=='detections' && $_SESSION['droit']>=3){	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 	?>
	
<div id="titre_pages">Détections</div><br><br><br>

	<table style="width:70%; margin:auto;">										
	    <tr><th>Nom</th>
			<th>Date</th>
			<th>Succession</th>
		</tr>
	</table> 

<?php  $capteurs = afficher_database_table("capteurs","date_detection DESC");
$i=0;
foreach ($capteurs as $capteur) { 
	$i++;
	if( $i < 10 ){
			?>
  <div class="input_ligne" style="width:75%;">
		<input type="text" style="width:200px"  value="<?php echo $capteur['nom_capteur']; ?>"/>
		<input type="text" style="width:200px"  value="<?php echo date('d/m/y H:i',strtotime($capteur['date_detection'])); ?>"/>			
		<input type="text" style="width:200px"  value="<?php echo $capteur['succession']; ?>"/>
	</div>
	<?php } else if( $i < 60 ){ ?>
		
	<div class="input_ligne" id="capteurs_masquee" style="width:75%; display:none;">
		<input type="text" style="width:200px" value="<?php echo $capteur['nom_capteur']; ?>"/>
		<input type="text" style="width:200px;" value="<?php echo date('d/m/y H:i',strtotime($capteur['date_detection'])); ?>"/>			
		<input type="text" style="width:200px" value="<?php echo $capteur['succession']; ?>"/>
	</div>
		
<?php } } ?>
<br><br>
<button type="button" class="btn btn-default btn-lg" id="bppluscapt" onclick=" $('[id=capteurs_masquee]').css('display', 'block'); $('#bppluscapt').css('display', 'none');" >Afficher plus</button>
<br><br>
	
	<?php } if($onglet=='suivi' && $_SESSION['droit']==1){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

	<div id="titre_pages">Suivi du fonctionnement</div><br><br>
	<br>
	
	<br><b>Log du serveur</b>
    <div style='text-align:left; overflow-y: scroll; height:400px;' class="block" id="domotix_log" ><?php echo file_get_contents($_SESSION['backend_directory'].'/domotixServer.log'); ?><br><br><br></div>


	<div syle="width:100%;"><b>Log de l'assistant</b>
	<iframe class="block" style="height:400px;" src="http://<?php echo $_SESSION['ip_raspberry']; ?>:8080/log?pass=2gBDun342nDK6xXd4a4WR45Xz" ></iframe>
	</div>
  <button onclick="action('refresh');" style="margin: 10px;">Raffraichir la page</button>
  <button onclick="action('refresh');" style="margin: 10px;">Afficher les commandes vocales</button>
  <button onclick="action('reload');" style="margin: 10px;">Redémarer le service</button>
  <button onclick="action('kill');" style="margin: 10px;">Arrêter le service</button>
  <button onclick="action('reboot');" style="margin: 10px;">Redémarer l'Assistant</button>
  <button onclick="action('halt');" style="margin: 10px;">Arrêter l'Assistant</button>
	<br><br><br><br>

<script>
  document.getElementById('domotix_log').scrollTop = document.getElementById('domotix_log').scrollHeight;
</script>

<?php  }

	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	
 


<script type="text/javascript">		
  
  
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
  
  function bp_appareil(appareil,etat,mode){

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
				xhr.open('GET', result,true);
				xhr.send();

			}else{
				afficherMessage("Une erreur s'est produite.")
			}
		}
	};
	xmlhttp.open("GET", "./api/action.php?action=appareil&etat="+etat+"&mode="+mode+"&id="+appareil, true);
	xmlhttp.send();
}

  
function changeAppareil(id, idSelect, idButton){
  $('#'+id+idSelect+' option').css('display','none')
  $('[id='+idButton+']').css('display','block')
  $('#'+idButton).attr('selected', true)
}

  
  
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	var day=["Di","Lu","Ma","Me","Je","Ve","Sa"]
	function inserer_alarme(){
		var a1 = $('#action_alarme').val()
    var a2 = ""
    for(i=0;i<7;i++){
      if($('#'+day[i]).is(":checked"))
        a2+="1"
      else
        a2+="0"
    }
		var a3 = $('#heure_alarme').val()
		var a4 = $('#status_alarme').val()
		var a5 = $('#appareil_alarme').val()	
    var a6 = $('#cmd').val()	

		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'inserer_alarme' , a1, a2, a3, a4, a5, a6 },
			"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration', 'alarme'); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});
	}
	function suprimer_alarme(id_alarme){
		ConfirmBox('Ete vous sûre de vouloir suprimer cette alarme?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'suprimer_alarme' ,  id_alarme },
				"success": function(response){ afficherMessage(response.result); $('[id=alarme_'+id_alarme+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
		})
	}
	function modifier_alarme(id_alarme){
		
		var a1 = $('#'+id_alarme+"action").val()
		var a2 = "" 
    for(i=0;i<7;i++){
      if($('#'+id_alarme+day[i]).is(":checked"))
        a2+="1"
      else
        a2+="0"
    }
    var a3 = $('#'+id_alarme+"heure").val()
		var a4 = $('#'+id_alarme+"status").val() 
		var a5 = $('#'+id_alarme+"appareil").val()
    var a6 = $('#'+id_alarme+"cmd").val()
				
		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'modifier_alarme' , id_alarme, a1, a2, a3, a4, a5 , a6 },
			"success": function(response){ afficherMessage(response.result); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});	
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  
function inserer_AssistantCmd(){
	
		var commentaire = $('#commentaire').val()
		var keywords = $('#keywords').val()
		var action_cmd = $('#action').val()
		var cmd = $('#cmd').val()
		var reponse = $('#reponse').val()		
		
		Ok=0
    try {
      JSON.parse(keywords)
      JSON.parse(reponse)
      Ok=1
    }catch(error) {}

    if (Ok==0 && keywords.indexOf("{")==-1 && reponse.indexOf("{")==-1 ){
      afficherMessage('Veuillez utiliser le bon format pour les mots clés et les réponses !');
      
    }else if( commentaire=='' ) {	//si nom de vide
			
			afficherMessage('Veuillez compléter le commentaire !');
		} else {													

			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_AssistantCmd' , commentaire, keywords, action_cmd, cmd, reponse },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration','assistantCmd') },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}
  
	function supprimer_AssistantCmd(id){		
		ConfirmBox('Ete vous sûre de vouloir suprimer cette pièce?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'supprimer_AssistantCmd' ,  id },
				"success": function(response){ afficherMessage(response.result); $('[id=assistantCmd_'+id+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
		})
	}
	
	function modifier_AssistantCmd(id){
	
		var commentaire = $('#'+id+'commentaire').val()
		var keywords = $('#'+id+'keywords').val()
		var action_cmd = $('#'+id+'action').val()
		var cmd = $('#'+id+'cmd').val()
		var reponse = $('#'+id+'reponse').val()		
    
    Ok=0
    try {
      JSON.parse(keywords)
      JSON.parse(reponse)
      Ok=1
    }catch(error) {}

    if (Ok==0 && keywords.indexOf("{")==-1 && reponse.indexOf("{")==-1 ){
      afficherMessage('Veuillez utiliser le bon format pour les mots clés et les réponses !');
      
    }else if( commentaire=='' ) {	//si nom de vide
			
			afficherMessage('Veuillez compléter le commentaire !');
		} else {														// sinon
			$.ajax({
		 
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_AssistantCmd' , id, commentaire, keywords, action_cmd, cmd, reponse },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	}
	}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//---------------------------------------------------------------------------------------------------fonction db
	
	function inserer_appareil(){
	
		var nom_appareil = $('#nom_appareil').val()
		var piece_appareil = $('#piece_appareil').val()
		var code_radio = $('#code_radio').val()
		var nom_bouton = $('#nom_bouton').val()
		var droit = $('#droit_appareil').val()
    var mode_radio = $('#mode').val()
    var afficher = $('#afficher').is(":checked")

    if(nom_bouton==''){
      nom_bouton='On/Off'
    }
		if(  nom_appareil=='' ||  code_radio == '' ) {
			afficherMessage('Veuillez compléter les champs !');
		} else {														
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_appareil' , nom_appareil, piece_appareil,mode_radio, code_radio,afficher, nom_bouton, droit },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration', 'appareil'); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		}
	}
	function supprimer_appareil(id_appareil){		
		ConfirmBox('Ete vous sûre de vouloir suprimer cet appareil?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'supprimer_appareil' ,  id_appareil },
				"success": function(response){ afficherMessage(response.result); $('[id=appareil_'+id_appareil+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		})
	}
	function modifier_appareil(id_appareil){

		var nom_appareil = $('#'+id_appareil+'nom').val()
		var piece_appareil = $('#'+id_appareil+'piece').val()
		var code_radio = $('#'+id_appareil+'code').val()
		var nom_bouton = $('#'+id_appareil+'nom_bouton').val()
		var droit = $('#'+id_appareil+'droit').val()
    var mode_radio = $('#'+id_appareil+'mode').val()
    var afficher = $('#'+id_appareil+'afficher').is(":checked")

		if(  nom_appareil=='' ||  code_radio == ''  ||  nom_bouton == ''  ) {
			afficherMessage('Veuillez compléter les champs !');
		} else {							
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_appareil' , id_appareil, nom_appareil, piece_appareil,mode_radio, code_radio,afficher, nom_bouton, droit },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	function inserer_telecommande(){
	
		var detail_telecommande = $('#detail_telecommande').val()
		var code_telecommande = $('#code_telecommande').val()
		var cmd_telecommande = $('#cmd_telecommande').val()
		var appareil_telecommande = $('#appareil_telecommande').val()
		var piece_telecommande = $('#piece_telecommande').val()

		if( code_telecommande=='' ||  cmd_telecommande=='' ||  appareil_telecommande == ''  ||  piece_telecommande == '' ) {
			afficherMessage('Veuillez compléter les champs !');
		} else {													
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_telecommande' , detail_telecommande, code_telecommande, cmd_telecommande, appareil_telecommande, piece_telecommande },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration', 'receptions_appareil'); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		}
	}
	function supprimer_telecommande(id_telecommande){

		ConfirmBox('Ete vous sûre de vouloir suprimer cet appareil?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'supprimer_telecommande' ,  id_telecommande },
				"success": function(response){ afficherMessage(response.result); $('[id=telecommande_'+id_telecommande+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		})
	}
	function modifier_telecommande(id_telecommande){

		var detail_telecommande = $('#'+id_telecommande+'detail_telecommande').val()
		var code_telecommande = $('#'+id_telecommande+'code_telecommande').val()
		var cmd_telecommande = $('#'+id_telecommande+'cmd_telecommande').val()
		var appareil_telecommande = $('#'+id_telecommande+'appareil_telecommande').val()
		var piece_telecommande = $('#'+id_telecommande+'piece_telecommande').val()

		if( code_telecommande=='' ||  cmd_telecommande=='' ||  appareil_telecommande == ''  ||  piece_telecommande == '' ) {	
			afficherMessage('Veuillez compléter les champs !');
		} else {		
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_telecommande' , id_telecommande, detail_telecommande, code_telecommande, cmd_telecommande, appareil_telecommande, piece_telecommande },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		}
	}



	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	function inserer_telecommande_music(){
	
		var numero_telecomande = $('#numero_telecomande').val()
		var code_telecommande = $('#code_telecommande').val()
		var cmd_telecommande = $('#cmd_telecommande').val()

		if( numero_telecomande=='' ||  code_telecommande=='' ||  cmd_telecommande == '' ) {
			afficherMessage('Veuillez compléter les champs !');
		} else {													
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'inserer_telecommande_music' , numero_telecomande, code_telecommande, cmd_telecommande },
				"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration', 'musique_serveur'); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		}
	}
	function supprimer_telecommande_music(id_telecommande){ 

		ConfirmBox('Ete vous sûre de vouloir suprimer cet télécommande?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'supprimer_telecommande_music' ,  id_telecommande },
				"success": function(response){ afficherMessage(response.result);  $('[id=telecommade_music'+id_telecommande+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		})
	}
	function modifier_telecommande_music(id_telecommande){

		var numero_telecomande = $('#'+id_telecommande+'numero_telecomande').val()
		var code_telecommande = $('#'+id_telecommande+'code_telecommande').val()
		var cmd_telecommande = $('#'+id_telecommande+'cmd_telecommande').val()

		if( numero_telecomande=='' ||  code_telecommande=='' ||  cmd_telecommande == '' ) {	
			afficherMessage('Veuillez compléter les champs !');
		} else {									
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_telecommande_music' , id_telecommande, numero_telecomande, code_telecommande, cmd_telecommande },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		}
	}

	function new_telecommande_music(numero_new_telecomande){

		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'new_telecommande_music' , numero_new_telecomande },
			"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration', 'musique_serveur'); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});
	}
	function supprimer_all_telecommande_music(numero_suppr_telecomande){

		ConfirmBox('Ete vous sûre de vouloir suprimer cet télécommande?', function() {
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'supprimer_all_telecommande_music' , numero_suppr_telecomande },
				"success": function(response){ afficherMessage(response.result); $('[id=telecommande_music_'+numero_suppr_telecomande+']').remove() },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});
		})
	}










	//---------------------------------------------------------------------------------------------------------

	function inserer_fonction(){
		
			var nom_fonction = $('#nom_fonction').val()
			var appareil_fonction = $('#appareil_fonction').val()
			var status_appareil = $('#status_appareil').val()
			var date_fonction = $('#date_fonction').val()
			var heure_fonction = $('#heure_fonction').val()
			var status_fonction = $('#status_fonction').val()
			
			if( nom_fonction=='' ||  date_fonction == '' ||  heure_fonction == '') {
				afficherMessage('Veuillez compléter les champs !');
			} else {		
				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'inserer_fonction' , nom_fonction, appareil_fonction, status_appareil, date_fonction, heure_fonction, status_fonction },
					"success": function(response){ afficherMessage(response.result); afficherOngletPpage('configuration', 'fonction') },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
			}
		}
	function suprimer_fonction(id_fonction){		
			ConfirmBox('Ete vous sûre de vouloir suprimer cette fonction?', function() {
				$.ajax({
			 
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'suprimer_fonction' ,  id_fonction },
					"success": function(response){ afficherMessage(response.result); $('[id=func_'+id_fonction+']').remove() },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
					});	
			})
		}
	function modifier_fonction(id_fonction){
		
			var nom_fonction = $('#'+id_fonction+'nom').val()
			var appareil_fonction = $('#'+id_fonction+'appareil').val()
			var status_appareil = $('#'+id_fonction+'status_appareil').val()
			var date_fonction = $('#'+id_fonction+'date_fonction').val()
			var heure_fonction = $('#'+id_fonction+'heure_fonction').val()
			var status_fonction = $('#'+id_fonction+'status_fonction').val()

			if( nom_fonction=='' ||  date_fonction == ''  ||  heure_fonction == '') {
				afficherMessage('Veuillez compléter les champs !');
			} else {														
				$.ajax({
					type: "POST",
					url: "./database/action_database.php",
					dataType: "json",
					data: {action:'modifier_fonction' , id_fonction,  nom_fonction, appareil_fonction, status_appareil, date_fonction, heure_fonction, status_fonction },
					"success": function(response){ afficherMessage(response.result); },
					"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
				});	
			}
		}



</script>