<?php 
require ('../parametre/security.php');
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
require ("../database/databaseFunctions.php");

if(!isset( $_GET["onglet"])) // la variable existe
{
?>
<div id="volet" align="center" >
	<li class="mv-item"><a onclick="afficherOngletPpage('chauffage', 'chauffage')">Chauffage</a></li>
	<li class="mv-item"><a onclick="afficherOngletPpage('chauffage', 'meteo')">Météo</a></li>
</div>
<div class="big-container"></div>


<script type="text/javascript">

	afficherOngletPpage('chauffage', 'chauffage')
	
</script>

<?php }else{/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($_GET["onglet"]=='chauffage'){ 
	
	$luminositees = afficher_database_table("suivi_luminositee");
	$temps = afficher_database_table("suivi_temperature");
	$option_chauffage = afficher_database_table("option_chauffage");

	foreach ($option_chauffage as $opt) { 
		$option[ $opt['id'] ]=$opt['parametre'];
	}?>

	<div id="titre_pages">Chauffage</div>		<!-- titre -->

		<?php require('../api/phpGraph.php');
	
		$i=0;
		foreach ($temps as $temp) { 
			$data[$i]=$temp['temperature_chauffage'];
			$date[$i]=$temp['heure_chauffage'];
		$i++;
		}
		$nom_jour = Array("","Lundi","Mardi","Mercredi" ,"Jeudi","Vendredi","Samedi","Dimanche");
				?>

	<div id="graph_chauffage">
	<?php
		$day = date(N);
		for($i=1;$i<8;$i++){ 
			for($e=0;$e<24;$e++){ 
				
				if(	$date[($i-1)*24+$e] == date("W") - 1 && $day < $i || $date[($i-1)*24+$e] == date("W") && $day >= $i || $date[($i-1)*24+$e] == date("W") && $i == 7 )
					
					$data_jour[$e] = $data[($i-1)*24+$e];
				else
						$data_jour[$e] = 0;
				
				if($data_jour[$e-1] == 0 && $data_jour[$e] != 0 && $data_jour[$e-2] != 0 && $e > 2)
					$data_jour[$e-1] = ($data_jour[$e] + $data_jour[$e-2])/2;
			}
			$data_jour[$e]=0;
		?>				
		
		<div id="<?php echo 'graphe_'.$i ?>" style="margin-bottom:-80px; display:none;">	
			<button style="float:left; border-radius:10px; background-color:#114263;" id="bp_graphe_prec" onclick="graphe_prec()">Précédent</button>
			<span id="msg_graphe" style="width:400px"><?php echo $nom_jour[$i]." "; ?></span>
			<button id="bp_graphe_suiv" style="float:right; border-radius:10px; background-color:#114263;" onclick="graphe_suiv()">Suivant</button>
			<?php
			
			$G = new phpGraph();			//We call an instance of phpGraph() class
			echo $G->draw($data_jour,array(		//Then we draw charts
				'type' => 'curve',
						'title' => "Température",
				'tooltips'=>true,
				)
			);	?>
		</div>
	<?php }  /////////////////////////////////////////// 

		$i=0;
		foreach ($luminositees as $luminositee) { 
			$data[$i]=$luminositee['luminositee'] /10;
			$date[$i]=$luminositee['heure_luminositee'];
			$i++;
		}

		$day = date(N);
		for($i=1;$i<8;$i++){ 
			for($e=0;$e<24;$e++){ 
				if(	$date[($i-1)*24+$e] == date("W") - 1 && $day < $i || $date[($i-1)*24+$e] == date("W") && $day >= $i || $date[($i-1)*24+$e] == date("W") && $i == 7 )
					$data_jour[$e] = $data[($i-1)*24+$e];
				else
						$data_jour[$e] = 0;
				
				if($data_jour[$e-1] == 0 && $data_jour[$e] != 0 && $data_jour[$e-2] != 0 && $e > 2)
					$data_jour[$e-1] = ($data_jour[$e] + $data_jour[$e-2])/2;
			}
			$data_jour[$e]=0;
		?>				
		
		<div id="<?php echo 'graphe_'.$i ?>" style="margin-bottom:-80px; display:none;">	
			<?php
			echo $G->draw($data_jour,array(		//Then we draw charts
				'type' => 'curve',
						'title' => "Luminositée",
				'tooltips'=>true,
				)
			);	?>
		</div>
	<?php } ?>	
	</div>

	<div id="module_chauffage" style="margin-top:5%;">
		<input type="radio" name="mode_chauffage" value="mode_de_chauffage" <?php if( $option['mode_chauffage'] == 'mode_de_chauffage' ){ echo "checked"; } ?> onclick="changer_mode_chauffage('mode_chauffage' )"/>
		Mode de chauffage:

		<div align="left" style="width:90%; margin-left:10%; margin-top:5%;"> 
			<input type="radio" name="mode" value="chaud" id="mode1" <?php if($option['mode_reglage'] == 'chaud' ){ echo "checked"; } ?>/> Chaud <br>
			<input type="radio" name="mode" value="tempéré" id="mode3" <?php if($option['mode_reglage'] == 'temp&eacute;r&eacute;' ){ echo "checked"; } ?>/> Tempéré <br>
			<input type="radio" name="mode" value="voyage" id="mode4" <?php if($option['mode_reglage'] == 'voyage' ){ echo "checked"; } ?>/> Voyage <br>
			<input type="radio" name="mode" value="off" id="mode5" <?php if($option['mode_reglage'] == 'off' ){ echo "checked"; } ?>/> Off <br>
		</div>
		
		<button type="button" onclick="changer_mode_chauffage('mode_reglage')">Valider</button> <br>
	</div>	

	<div id="module_chauffage">
		<?php $hour = (date(N) -1) *24 + date(H)+1;  
		foreach ($temps as $temp) { 
			if ($temp['id_chauffage'] == $hour ){
				$temp = $temp['temperature_chauffage'];
				//On définit les variables d'affichage dans la condition suivante en y affichant la température
				$froid = '<span class="temp_froid">'. $temp .'</span> °c';
				$ok = '<span class="temp_ok">'. $temp .'</span> °c';
				$bof = '<span class="temp_bof">'. $temp .'</span> °c';
				$wrong = '<span class="temp_wrong">'. $temp .'</span> °c';
				//Si la température < 65°C alors on affiche en vert, sinon en rouge
				echo "Temp : ";
			if ($temp < 18.0)
			echo $froid;
			else if ($temp < 24.0)
			echo $ok;
			else if ($temp < 40.0)
			echo $bof;
			else
			echo $wrong;
			}
		} echo '<br>';

		$hour = (date(N) -1) *24 + date(H)+1;  
		foreach ($luminositees as $temp) { 
			if ($temp['id_luminositee'] == $hour ){
				$temp = $temp['luminositee'];
				$temp = $temp/10;
				//On définit les variables d'affichage dans la condition suivante en y affichant la température
				$froid = '<span class="temp_froid">'. $temp .'</span> %';
				$ok = '<span class="temp_ok">'. $temp .'</span> %';
				$bof = '<span class="temp_bof">'. $temp .'</span> %';
				$wrong = '<span class="temp_wrong">'. $temp .'</span> %';
				//Si la température < 65°C alors on affiche en vert, sinon en rouge
				echo "Lum : ";
			if ($temp < 25.0)
			echo $froid;
			else if ($temp < 50.0)
			echo $ok;
			else if ($temp < 75.0)
			echo $bof;
			else
			echo $wrong;
			}
		} ?>
		
	</div>

	<div id="module_chauffage">
		<input type="radio" name="mode_chauffage" value="mode_de_temperature" <?php if($option['mode_chauffage'] == 'mode_de_temperature' ){ echo "checked"; } ?> onclick="changer_mode_chauffage('mode_chauffage')"/>
		Régler la Température:
		<div class="range_temperature">  
			<input type="range" id="mode_de_temperature_range" max="40" min="10" value="<?php echo $option['mode_temperature']; ?>" style=" width:80%; margin-top: 10%;" />
		</div>
		<span id="temp_val" style="margin-left:30%;">value</span><br>
		<button type="button" onclick="changer_mode_chauffage('mode_temperature')">Valider</button> 
	</div>




	<div id="module_chauffage" style="width:75%; margin-bottom:50px;">
		<input type="radio" name="mode_chauffage" value="mode_programation" <?php if($option['mode_chauffage'] == 'mode_programation' ){ echo "checked"; } ?> onclick="changer_mode_chauffage('mode_chauffage')"/>
		Programmer le chauffage:<br>


		<div id="range_temp">   
			<div class="range_button" id="temp_range_1" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Allumage du chauffage"></div>
			<div class="range_button" id="temp_range_2" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Extinction du chauffage"></div>
			<div class="range_button" id="temp_range_3" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Allumage du chauffage"></div>
			<div class="range_button" id="temp_range_4" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Extinction du chauffage"></div>
			<div class="range_button" id="temp_range_5" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Allumage du chauffage"></div>
			<div class="range_button" id="temp_range_6" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Extinction du chauffage"></div>
			<div class="range_button" id="temp_range_7" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Allumage du chauffage"></div>
			<div class="range_button" id="temp_range_8" onmousemove="move_range(this)" onmouseup="move_range(this)" title="Extinction du chauffage"></div>
		</div>
		
		<br>
		<button type="button" onclick="sauvegarder_chauffage_reglage()">Valider</button> <span id="temp_rang_val"></span>
	</div>

<?php } else if($_GET["onglet"]=='meteo'){ /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	
	
	
 <div id="titre_pages">Météo</div><br><br>		<!-- titre -->
  
	<br><br>
	<div id="meteo_chauffage">
		
<div id='tameteo' style='font-family:Arial;text-align:center;border:solid 1px #114263; background:#114263; width:460px; padding:4px'><a href='http://www.ta-meteo.fr/lannion' target='_blank' title='Météo Lannion' style='font-weight: bold;font-size:14px;text-decoration:none;color:#FFFFFF;line-height:14px;'>Météo Lannion</a><br/><a href='http://www.ta-meteo.fr' target='_blank' title='meteo'><img src='http://www.ta-meteo.fr/widget4/263236097e39479394a30a4d69d21626.png?t=time()' border='0'></a><br/><a href='http://www.ta-meteo.fr/lannion' style='font-size:10px;text-decoration:none;color:#FFFFFF;line-height:10px;' target='_blank' >More</a></div>
<div id='tameteo' style='font-family:Arial;text-align:center;border:solid 1px #114263; background:#114263; width:460px; padding:4px'><a href='http://www.ta-meteo.fr/brest' target='_blank' title='Météo Brest' style='font-weight: bold;font-size:14px;text-decoration:none;color:#FFFFFF;line-height:14px;'>Météo Brest</a><br/><a href='http://www.ta-meteo.fr' target='_blank' title='meteo'><img src='http://www.ta-meteo.fr/widget4/60c7341ad26544d8ada710f4af777085.png?t=time()' border='0'></a><br/><a href='http://www.ta-meteo.fr/brest' style='font-size:10px;text-decoration:none;color:#FFFFFF;line-height:10px;' target='_blank' >More</a></div>
<div id='tameteo' style='font-family:Arial;text-align:center;border:solid 1px #114263; background:#114263; width:460px; padding:4px'><a href='http://www.ta-meteo.fr/laval-53000' target='_blank' title='Météo Laval' style='font-weight: bold;font-size:14px;text-decoration:none;color:#FFFFFF;line-height:14px;'>Météo Laval</a><br/><a href='http://www.ta-meteo.fr' target='_blank' title='meteo'><img src='http://www.ta-meteo.fr/widget4/fde7cec3f2f3418490028b68c679301f.png?t=time()' border='0'></a><br/><a href='http://www.ta-meteo.fr/Laval' style='font-size:10px;text-decoration:none;color:#FFFFFF;line-height:10px;' target='_blank' >More</a></div>
		
	</div>	
	<br><br>


			 
<?php } /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>	

<script type="text/javascript">							// fonctions on et off
    afficher_ranges()

	var jour_graphe, a; 	
	jour_graphe = "<?php echo $day; ?>" ;
	a=7;
	
	$( document ).ready(function() {
		
    $("[id=graphe_"+jour_graphe+"]").css('display', 'block');
		//$("#bp_graphe_suiv").css('display', 'none');
  });
	
	function graphe_suiv(){
		if(a < 7){
			$("[id=graphe_"+jour_graphe+"]").css('display', 'none');
			$("[id=bp_graphe_suiv]").css('display', 'block');
			jour_graphe++;
			a++;
			if(jour_graphe==8)
				jour_graphe=1
			$("[id=graphe_"+jour_graphe+"]").css('display', 'block');
	  }
	}
	function graphe_prec(){
		if(a >= 2){
			$("[id=graphe_"+jour_graphe+"]").css('display', 'none');	
			$("[id=bp_graphe_prec]").css('display', 'block');
			jour_graphe--;
			a--;
			if(jour_graphe==0)
				jour_graphe=7
			$("[id=graphe_"+jour_graphe+"]").css('display', 'block');
		} 
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	var temp = document.getElementById("mode_de_temperature_range").value;
	var span = document.getElementById("temp_val");
	span.innerHTML = temp;
	var range = document.getElementById('mode_de_temperature_range');
	range.onmousemove = function() {
			var temp = document.getElementById("mode_de_temperature_range").value;
			span.innerHTML = temp;
	};
/////////////////////////////////////////////////////////////////////////////////////////////////////
	function changer_mode_chauffage(fonction){

		option1_chauffage = fonction

		if(fonction == 'mode_chauffage')
			option2_chauffage = $('input[name=mode_chauffage]:checked').val();
		else if(fonction == 'mode_reglage')
			option2_chauffage = $('input[name=mode]:checked').val()
		else if(fonction == 'mode_temperature')
			option2_chauffage =	document.getElementById("mode_de_temperature_range").value;		

		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'modifier_chauffage' , option1_chauffage, option2_chauffage },
			"success": function(response){ afficherMessage(response.result); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});	
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////


	$("[class=range_button]").draggable({
	    axis : 'x',
	    containment : '#range_temp',
	});

  	function move_range(objet){

  		var longueur = document.getElementById("range_temp").offsetWidth -8  // -20 = offset des boutons
  		var position = objet.offsetLeft

  		var value = position * 24 /longueur

  		var e = value.toFixed(1)
  		value = Math.trunc(value)
  		e = (e - value)/10*5 
  		value = value + e
  		value = value.toFixed(1)        
      
    var str=value.toString()
    str = str.replace(".", "h")+'0'
    var span = document.getElementById("temp_rang_val");
		span.innerHTML = str
		objet.innerHTML = str

		for(var i=1; i<9;i++){
	  		var a=document.getElementById("temp_range_"+i);
			a.style.zIndex = 2
  		}
  		objet.style.zIndex = 5
	}

	function afficher_ranges(){

		var longueur = document.getElementById("range_temp").offsetWidth -8  // -20 = offset des boutons
		var temp_range = [ 0,
	  		 "<?php echo $option['temp_range_1']; ?>",
	  		 "<?php echo $option['temp_range_2']; ?>",
	  		 "<?php echo $option['temp_range_3']; ?>",
	  		 "<?php echo $option['temp_range_4']; ?>",
	  		 "<?php echo $option['temp_range_5']; ?>",
	  		 "<?php echo $option['temp_range_6']; ?>",
	  		 "<?php echo $option['temp_range_7']; ?>",
	  		 "<?php echo $option['temp_range_8']; ?>"
  		 ]
  		for(var i=1; i<9;i++){
  			
	  		var objet=document.getElementById("temp_range_"+i);

	  		if(i%2)
	  			objet.style.backgroundColor = '#19608f'
	  		else
	  			objet.style.backgroundColor = '#114263'

	  		var value = temp_range[i]
	  		value = Math.trunc(value)
	  		var a = (temp_range[i] - value)*10/6 
	  		value = (value + a) * longueur /24
        

			objet.style.left = value +"px"
      objet.innerHTML = temp_range[i].replace(".", "h")
			
  		}
	}

	function sauvegarder_chauffage_reglage(){

		var temp_range = [ "0",
	  		 "temp_range_1",
	  		 "temp_range_2",
	  		 "temp_range_3",
	  		 "temp_range_4",
	  		 "temp_range_5",
	  		 "temp_range_6",
	  		 "temp_range_7",
	  		 "temp_range_8"
  		 ]
  		var valeur = new Array();

  		for(var i=1; i<9;i++){
	  		var objet=document.getElementById("temp_range_"+i);
	  		move_range(objet)
	  		valeur[i] = objet.innerHTML.replace("h", ".")
	  	}

	  	for(var i=1; i<8;i++){
	  		for(var j=1; j<8;j++){

	  			if(valeur[j] > valeur[j+1]){
	  				var e = valeur[j]
	  				valeur[j] = valeur[j+1]
	  				valeur[j+1] = e
	  			}
	  		}
	  	}

	  	for(var i=1; i<9;i++){
	  		option1_chauffage = "temp_range_"+i
	  		option2_chauffage = valeur[i]

	  		$.ajax({
				type: "POST",
				url: "./database/action_database.php",
				dataType: "json",
				data: {action:'modifier_chauffage' , option1_chauffage, option2_chauffage },
				"success": function(response){ afficherMessage(response.result); },
				"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});
  		}
	}			

</script>

<?php } ?>	