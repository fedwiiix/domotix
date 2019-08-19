<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?> 
<div class="container_long" >
   
  <div id="titre_module" onclick="lancer_onglet('configuration','alarme')" >Alarmes</div><br><br><br>
  <div style="overflow:scroll;" align="center">
    <table style="width:90%;" class="module_alarme">										
      <tr><th>Date</th>
      <th>Heure</th>
      <th>Action</th>
      <th></th></tr>
      <?php 
      $alarmes = afficher_database_table("alarmes");
      $i=0;
      foreach ($alarmes as $alarme) { 	
      ?>
      <tr>
      <td style="min-width:120px;">
        <?php $recurence = $alarme['repeter_alarme']; ?>

        <label <?php if($recurence[1]!=1){ echo 'hidden'; } ?>>Lu</label>
        <label <?php if($recurence[2]!=1){ echo 'hidden'; } ?>>Ma</label>
        <label <?php if($recurence[3]!=1){ echo 'hidden'; } ?>>Me</label> 
        <label <?php if($recurence[4]!=1){ echo 'hidden'; } ?>>Je</label>
        <label <?php if($recurence[5]!=1){ echo 'hidden'; } ?>>Ve</label>
        <label <?php if($recurence[6]!=1){ echo 'hidden'; } ?>>Sa</label>
        <label <?php if($recurence[0]!=1){ echo 'hidden'; } ?>>Di</label>
      </td>			
      <td><input type="time" id="<?php echo $alarme['id_alarme'].'heure'; ?>" value="<?php echo $alarme['heure_alarme']; ?>"/></td>
      <td><?php echo $alarme['action_alarme']; ?></td>
      <td hidden><input type="text" id="<?php echo $alarme['id_alarme'].'action'; ?>" value="<?php echo $alarme['action_alarme']; ?>" style="width:100px;" /></td>	
      <td hidden><input type="text" id="<?php echo $alarme['id_alarme'].'repeter'; ?>" value="<?php echo $alarme['repeter_alarme']; ?>" style="width:100px;" /></td>	
      <td hidden><input type="text" id="<?php echo $alarme['id_alarme'].'appareil'; ?>" value="<?php echo $alarme['appareil_alarme']; ?>" style="width:100px;" /></td>	
      <td><button id="<?php echo $alarme['id_alarme'].'status'; ?>" onclick="activer_alarme(<?php echo $alarme['id_alarme']; ?>)" style="width:100px; text-align:center; opacity:0.8;" value="<?php echo $alarme['status_alarme']; ?>"><?php echo ($alarme['status_alarme'] ? 'Activée' : 'Désactivée'); ?></button> </td>	
      </tr>
      <?php } ?>
    </table> 
  </div>
</div>

<script type="text/javascript">		
  
	function activer_alarme(id_alarme){
    
		var a1 = document.getElementById(id_alarme+"action").value;
		var a2 = document.getElementById(id_alarme+"repeter").value;
		var a3 = document.getElementById(id_alarme+"heure").value;
		var a4 = document.getElementById(id_alarme+"status").innerHTML;
		var a5 = document.getElementById(id_alarme+"appareil").value;
	  var b = document.getElementById(id_alarme+"status");
		
		if(a4 == "Activée") {	//si il y en à un de vide
			a4 = 0;
			b.innerHTML = "Désactivée";
			
		} else if(a4 == "Désactivée") {	
			a4=1;
			b.innerHTML = "Activée";
		}
		afficherMessage("alarme " +b.innerHTML);
		
			$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_alarme' , id_alarme, a1, a2, a3, a4, a5 },
				});	
	}
</script>
