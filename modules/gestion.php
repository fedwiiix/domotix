<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container">
	
<div id="titre_module" onclick="lancer_onglet('chauffage');">Gestion</div><br><br>
	
	<span id="date_heure" ></span><br><br>
	  <!-- __________________coté température________________________________________________________________________________  -->
	  <?php $temps = afficher_database_table("suivi_temperature");
  				$hour = (date(N) -1) *24 + date(H)+1;  
				  foreach ($temps as $temp) { 
					if ($temp['id_chauffage'] == $hour ){
						$temp = $temp['temperature_chauffage'];
						//On définit les variables d'affichage dans la condition suivante en y affichant la température
					 $froid = '<span class="temp_froid">'. $temp .'</span> °c';
					 $ok = '<span class="temp_ok">'. $temp .'</span> °c';
					 $bof = '<span class="temp_bof">'. $temp .'</span> °c';
					 $wrong = '<span class="temp_wrong">'. $temp .'</span> °c';
					 //Si la température < 65°C alors on affiche en vert, sinon en rouge
					echo "Température: ";
				  if ($temp < 18.0)
				    echo $froid;
				  else if ($temp < 24.0)
				    echo $ok;
				  else if ($temp < 40.0)
				    echo $bof;
				  else
				    echo $wrong;
					}
				 } ?>
	<br>
	<?php $temps = afficher_database_table("suivi_luminositee");
  				$hour = (date(N) -1) *24 + date(H)+1;  
				foreach ($temps as $temp) { 
					if ($temp['id_luminositee'] == $hour ){
						$temp = $temp['luminositee'];
						$temp = $temp/10;
						//On définit les variables d'affichage dans la condition suivante en y affichant la température
					 $froid = '<span class="temp_froid">'. $temp .'</span> %';
					 $ok = '<span class="temp_ok">'. $temp .'</span> %';
					 $bof = '<span class="temp_bof">'. $temp .'</span> %';
					 $wrong = '<span class="temp_wrong">'. $temp .'</span> %';
					 //Si la température < 65°C alors on affiche en vert, sinon en rouge
						echo "Luminositée: ";
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
	
	     <br>
			 humidité: 23%
			 <br>
			 pression: 104 Pa
			 <br>
</div>


<script type="text/javascript">

	date_heure();

	function date_heure()
    {
        date = new Date;
        annee = date.getFullYear();
        moi = date.getMonth();
        mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
        j = date.getDate();
        jour = date.getDay();
        jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        resultat = h+':'+m+':'+s;
        document.getElementById('date_heure').innerHTML = resultat;
        setTimeout('date_heure();','1000');
        return true;
    }
</script>