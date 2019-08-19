<?php
require("../database/data_base_fonction.php");	

if(isset( $_GET["agenda"])) // la variable existe
{


if(isset( $_GET["a"])) // la variable existe    http://169.254.46.68/domotix/php/ins%C3%A9rer_agenda.php?agenda=saint.txt&a
{

	$lien_agenda = $_GET["agenda"];

	$contenu=file_get_contents($lien_agenda);				// on récupère toutes les donnees chants
	//$contenu = utf8_decode($contenu); 
	$e='#\/#';
	$contenu = preg_replace($e, "-", $contenu);
	$agendas= explode("_",$contenu);


	$j=0;
	for ($i=0; $i<367; $i++) {

		echo '<hr>';
		echo $agendas[$j].'<br>';
		echo $agendas[$j+1].'<br>';
		echo $agendas[$j+2].'<br>';
		echo $agendas[$j+3].'<br>';


		$a1 = $agendas[$j];
		$a2 = $agendas[$j+1];
		$a3 = modifier_caracteres_special($agendas[$j+2]);
		$a4 = modifier_caracteres_special($agendas[$j+3]);

			connexion()->exec("INSERT INTO `agenda_saint`(`id_saint`, `saint_mois`, `saint_jour`, `saint_nom1`, `saint_nom2`, `avertir_saint`) VALUES ('','$a1', '$a2','$a3','$a4',0)");
		$j=$j+4;
	}


} else if(isset( $_GET["b"])) {   //  http://169.254.46.68/domotix/php/insérer_agenda.php?agenda=anniversaire.txt&b

	$lien_agenda = $_GET["agenda"];

	$contenu=file_get_contents($lien_agenda);				// on récupère toutes les donnees chants
	//$contenu = utf8_decode($contenu); 
	$e='#\/#';
	$contenu = preg_replace($e, "-", $contenu);
	$agendas= explode("_",$contenu);


	$i=0;
	foreach ($agendas as $agenda) {

		$i++;
		if($i%2){
			echo $date = date('Y-n-j',strtotime($agendas[$i])).'<br>';
			$evenement = modifier_caracteres_special($agenda);
			echo $evenement.'<br>';

			connexion()->exec("INSERT INTO `agenda`(`id_event`, `type_agenda`, `date_event`, `heure_event`, `durée_event`, `event`, `detail_event`, `recurence`, `rappel_event`, `type_rappel`) VALUES ('','Anniversaire','$date','', '', '$evenement', '', '1', 'Oui', 'SMS')");
		}
	}

}else{
	echo 'Aucun mode choisis';
}


}else{
	echo 'Aucun agenda choisis';
}


function modifier_caracteres_special($f){
	$f = preg_replace("# #", "/_/_", $f);
	$f = preg_replace("#\+#", "_plus_", $f);	
	$f = preg_replace("#'#", "_apostrophe_", $f);	 
	$f = preg_replace("#&#", "_etcom_", $f);
	$f = preg_replace("#\?#", "_interrog_", $f);
	$f = preg_replace("#\(#", "_parro_", $f);
	$f = preg_replace("#\)#", "_parrf_", $f);
	return $f;
}
?>