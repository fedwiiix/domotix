<?php require ('../parametre/security.php'); 
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');
?>

<div id="planing" ></div>
<div id="quitter_planing" onclick="quitter_planning()"></div>
<div id="volet" align="center" >

  <li class="mv-item"><a onclick="afficher_onglet_conf('Agenda', 1)">Evénements</a></li>
  <li class="mv-item"><a onclick="afficher_onglet_conf('Agenda',0)">Agenda</a></li>
  <li class="mv-item"><a onclick="afficher_onglet_conf('Anniversaire',0)">Anniversaire</a></li>
  <li class="mv-item"><a onclick="afficher_onglet_conf('Fêtes',0)">Fêtes</a></li>
  <br><br>
  <span style="color:white; padding:5px;" id="message_onglet">Agenda</span>
</div>
<div class="big-container"><?php require ('agendaAffichage.php'); ?></div>

<script type="text/javascript">

  var onglet='Agenda'
  afficher_onglet_conf('Agenda', 1)

  function afficher_onglet_conf(onglet,tous){

    this.onglet = onglet
    $('#message_onglet').html(onglet);
    quitter_planning()
    afficherOngletPpage('agendaAffichage', onglet+'&tous='+tous )
  }
  function afficher_jour(j,  m, a)
  {
   $('#planing').css('display', 'block');
   $('.big-container').css('overflow-y', 'hidden');
   $('#quitter_planing').css('display', 'block');
   $("#planing").load("pages/agendaAffichage.php?jour="+j+'/'+  m+'/'+ a+"&onglet="+onglet);
  }
  function mois_suiv(m,a,tous)
  {
   m++;
   afficherOngletPpage('agendaAffichage', onglet+"&mois="+m+"&annee="+a+'&tous='+tous )
  }
  function mois_prec(m,a,tous)
  {
   m--;
   afficherOngletPpage('agendaAffichage', onglet+"&mois="+m+"&annee="+a+'&tous='+tous )
  }
  function quitter_planning()
  {
    $('#planing').css('display', 'none');
    $('.big-container').css('overflow-y', 'scroll');
    $('#quitter_planing').css('display', 'none');
    $("#planing").html("");
  }
  //**************************************************************************************************************
  function inserer_event(j,  m, a){

		var type_agenda = onglet //document.getElementById("type_agenda").value;
		if(type_agenda == 'Evénements')
			type_agenda = 'Agenda'
	
		var date_evenement = document.getElementById("date_evenement").value;
		var heure_evenement = document.getElementById("heure_evenement").value;
		var temp_evenement = document.getElementById("temp_evenement").value;
		var evenement = document.getElementById("evenement").value;
		var detail_evenement = document.getElementById("detail_evenement").value;
		var rapel_evenement = document.getElementById("rapel_evenement").checked;
		var type_rappel_evenement = document.getElementById("type_rappel_evenement").value;
		var recurence = document.getElementById("checkbox_evenement").checked;

    if(rapel_evenement==true){
      rapel_evenement = "Oui"
    }else{		rapel_evenement = "Non"	}

    if(type_agenda=='Anniversaire'){
      rapel_evenement = "Oui"
      type_rappel_evenement = "SMS"
      recurence = 1
    }
    if( evenement=='' ) {	//si il y en à un de vide
      afficherMessage("Veuillez completer tout les champs !");
    } else {		

      $.ajax({
        type: "POST",
        url: "./database/action_database.php",
        dataType: "json",
        data: {action:'inserer_event' ,type_agenda, date_evenement, heure_evenement, temp_evenement, evenement, detail_evenement,recurence, rapel_evenement, type_rappel_evenement },
        "success": function(response){ afficherMessage(response.result); afficherOngletPpage('agendaAffichage', onglet+"&mois="+m+"&annee="+a ) },
        "error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
      });	
      $("#agenda").load("pages/agendaAffichage.php?mois="+m+"&annee="+a+"&onglet="+onglet);
      afficher_jour(j,  m, a);
    }
  }
	function suprimmer_event(j,  m, a){		
				
		id_event = document.getElementById("id_event").value
		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'suprimer_event' ,  id_event },
			"success": function(response){ afficherMessage(response.result); afficherOngletPpage('agendaAffichage', onglet+"&mois="+m+"&annee="+a ) },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
		afficher_jour(j,  m, a);
		}
	function annuler_affich_modif_event(id_event){
		$('#formulaire_modif_event').css('display', 'none');
		$('#accordion').css('display', 'block');
	}
	function affich_modif_event(id_event){ 
		$('#formulaire_modif_event').css('display', 'block');
		$('#accordion').css('display', 'none');
		document.getElementById("id_event").value = id_event;

		
		document.getElementById("type_agenda_modif").value = document.getElementById("type_agenda"+id_event).innerHTML;
		document.getElementById("date_evenement_modif").value = document.getElementById("date_evenement"+id_event).innerHTML;
		document.getElementById("heure_evenement_modif").value = document.getElementById("heure_evenement"+id_event).innerHTML;
		document.getElementById("temp_evenement_modif").value = document.getElementById("temp_evenement"+id_event).innerHTML;
		document.getElementById("evenement_modif").value = document.getElementById("evenement"+id_event).innerHTML;
		document.getElementById("detail_evenement_modif").value = document.getElementById("detail_evenement"+id_event).innerHTML;

		if( document.getElementById("checkbox_evenement"+id_event).innerHTML == 1 || document.getElementById("checkbox_evenement"+id_event).innerHTML == 'true')
			document.getElementById("checkbox_evenement_modif").checked =1


		document.getElementById("rapel_evenement_modif").innerHTML = document.getElementById("rapel_evenement"+id_event).innerHTML;
		
		if(document.getElementById("rapel_evenement"+id_event).innerHTML=='Oui'){
			document.getElementById("rapel_evenement_modif").checked =1 
			document.getElementById('rappel_modif_div').style.display='block';
		}
		document.getElementById("type_rappel_evenement_init").innerHTML = document.getElementById("type_rappel_evenement"+id_event).innerHTML;
	}
	function modifier_event(j,  m, a){

		var type_agenda = onglet //document.getElementById("type_agenda_modif").value;
		var id_event = document.getElementById("id_event").value;
		var date_evenement = document.getElementById("date_evenement_modif").value;
		var heure_evenement = document.getElementById("heure_evenement_modif").value;
		var temp_evenement = document.getElementById("temp_evenement_modif").value;
		var evenement = document.getElementById("evenement_modif").value;
		var detail_evenement = document.getElementById("detail_evenement_modif").value;
		var rapel_evenement = document.getElementById("rapel_evenement_modif").checked;
		var type_rappel_evenement = document.getElementById("type_rappel_evenement_modif").value;
		var recurence = document.getElementById("checkbox_evenement_modif").checked;


	if(rapel_evenement==true){
		rapel_evenement = "Oui"
	}else{		rapel_evenement = "Non"	}

	if( evenement=='' ) {	//si il y en à un de vide

		afficherMessage("Veuillez completer tout les champs !");

	} else {		

		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'modifier_event' , id_event, type_agenda, date_evenement, heure_evenement, temp_evenement, evenement, detail_evenement, recurence, rapel_evenement, type_rappel_evenement },
			"success": function(response){ afficherMessage(response.result); afficherOngletPpage('agendaAffichage', onglet+"&mois="+m+"&annee="+a ); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
		});	
		quitter_planning();
	}
	}

	function modifier_avertir_saint(jour_saint,  mois_saint, value_saint){	

		$.ajax({
			type: "POST",
			url: "./database/action_database.php",
			dataType: "json",
			data: {action:'modifier_avertir_saint' ,  jour_saint, mois_saint, value_saint },
			"success": function(response){ afficherMessage(response.result); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
	}

</script>
