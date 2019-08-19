<div class="container_long">
<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');

	$nom_mois = Array("","Janvier","Février","Mars" ,"Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	$nom_jour = Array("","Lundi","Mardi","Mercredi" ,"Jeudi","Vendredi","Samedi","Dimanche");
	$j = date("j");
	$m = date("n");
	$jour = date("N", mktime(0, 0, 0, $m, $j, date("Y")));
	$nb_j=cal_days_in_month ( 1 , $m , date("Y") );
	?>
           
<div id="titre_module" onclick="lancer_onglet('agenda');" style="cursor:pointer;">Agenda: <?php echo ' '.$nom_jour[$jour].' '.$j.' '.$nom_mois[$m]; ?> </div><br>
<br> 
<?php $events = $events = get_diary('+3 days');
		?>
	<div id="affichage_planing"> 
		<div id="col_agenda"> 
		<div id="titre_module_agenda">Aujourd'hui</div><br><?php 
		foreach ($events as $event) { 
			$d = explode("-",$event['date_event']); 
			if($d[1]==$m && $d[2]==$j){
				if($event['type_agenda']=="Anniversaire"){
					echo '<li style="color:grey;">'.html_entity_decode($event['event']).'</li>';
				}else{
					echo '<li>'.html_entity_decode($event['event']).'</li>';
				}
			}
		}	?></div>
			<div id="col_agenda"><?php 
			if($j==$nb_j){
				$j=0;
				$m++;
			}
			$jour = date("N", mktime(0, 0, 0, $m, $j+1, date("Y")));
			echo '<div id="titre_module_agenda">'.$nom_jour[$jour].'</div><br>';
			foreach ($events as $event) { 
				$d = explode("-",$event['date_event']); 
				if($d[1]==$m && $d[2]==$j+1){
					if($event['type_agenda']=="Anniversaire"){
						echo '<li style="color:grey;">'.html_entity_decode($event['event']).'</li>';
					}else{
						echo '<li>'.html_entity_decode($event['event']).'</li>';
					}
				}
		}	?></div>
			<div id="col_agenda"><?php 
		  if($j==$nb_j){
				$j=-1;
				$m++;
			}
			$jour = date("N", mktime(0, 0, 0, $m, $j+2, date("Y")));
			echo '<div id="titre_module_agenda">'.$nom_jour[$jour].'</div><br>';
			foreach ($events as $event) { 
			$d = explode("-",$event['date_event']); 
			if($d[1]==$m && $d[2]==$j+2){
				if($event['type_agenda']=="Anniversaire"){
					echo '<li style="color:grey;">'.html_entity_decode($event['event']).'</li>';
				}else{
					echo '<li>'.html_entity_decode($event['event']).'</li><br>';
				}
			}
		}	?></div>
		<div id="col_agenda" style="border-right:0;"><?php 
		  if($j==$nb_j){
				$j=-2;
				$m++;
			}
			$jour = date("N", mktime(0, 0, 0, $m, $j+3, date("Y")));
			echo '<div id="titre_module_agenda">'.$nom_jour[$jour].'</div><br>';
			foreach ($events as $event) { 
			$d = explode("-",$event['date_event']); 
			if($d[1]==$m && $d[2]==$j+3){
				if($event['type_agenda']=="Anniversaire"){
					echo '<li style="color:grey;">'.html_entity_decode($event['event']).'</li>';
				}else{
					echo '<li>'.html_entity_decode($event['event']).'</li>';
				}
			}
				
		}	?></div>
	</div>	
</div>

