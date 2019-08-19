<?php require ('../parametre/security.php'); 
$_SESSION["page"] = "agenda";
require ('../parametre/acces_page.php');
require("../database/databaseFunctions.php");

if(isset( $_GET["onglet"]))
{
	$onglet = $_GET["onglet"];
}
$tous=0;
if(isset( $_GET["tous"])) 
{
	$tous = $_GET["tous"];
}

$nom_mois = Array("","Janvier","Février","Mars" ,"Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$nom_jour = Array("","Lundi","Mardi","Mercredi" ,"Jeudi","Vendredi","Samedi","Dimanche");

if(isset( $_GET["jour"])) 
{
    $jour=$_GET["jour"];
    $d= explode("/",$jour);     
    $a=$d[2];
    $m=$d[1];
    $j=$d[0];
    $jour = date("N", mktime(0, 0, 0, $m, $j, $a));
?>
  <script>
    $(function() {
    $( "#accordion" ).accordion({
			heightStyle: "content"
    });
  });
  </script>

<?php
	$events = get_diary('',"$a-$m-$j");
	$event_mois = array();
	$i=0; 
	foreach ($events as $event) { // on cherche les evenements du mois 
		if($j.$m.$a == date('jny',strtotime($event["date_event"])) || $j.$m == date('jn',strtotime($event["date_event"])) && $event["recurence"]=="true" || $j.$m == date('jn',strtotime($event["date_event"])) && $event["recurence"]=="1" ){
		$event_mois[$i] = $event;
		$i++;	
		}
	 } 
?>
<!-- ************************************************************************* -->

<img onclick="quitter_planning()" style="width:50px; float:left;" src="img/appImg/gche.png">

<h1><?php echo $nom_jour[$jour].' '.$j.' '.$nom_mois[$m]; ?></h1>

<div id="formulaire_modif_event" align="center">

	<div class="input_ligne" style="width:85%;">
		<br>
			<label>Date: </label>
			<input type="date" value="" id="date_evenement_modif" />
			<label <?php if($onglet=='Anniversaire'){ echo "hidden"; } ?> >Heure:</label>
			<input <?php if($onglet=='Anniversaire'){ echo "hidden"; } ?> type="time" value="" id="heure_evenement_modif" />
			<label hidden>Fin:</label>
			<input hidden type="time" value="<?php echo date("H:i");?>" id="temp_evenement_modif" />
		<br><br>	
			<input hidden type="text" id="type_agenda_modif" />
			<label>Nom:</label>
			<input type="text" id="evenement_modif" placeholder="Evenement" />
		<br>
			<br><label>Détails:</label>
			<input style="width:40%;" type="text" id="detail_evenement_modif" placeholder="Détails" />
		<br>
			<div <?php if($onglet=='Anniversaire'){ echo "hidden"; } ?> >
				<input type="checkbox" id="checkbox_evenement_modif"/>
				<label for="checkbox_evenement_modif"></label>
				<label>Evénement annuel</label>
			  <br><br>

				<input type="checkbox" id="rapel_evenement_modif" onchange="if(this.checked!=true){ document.getElementById('rappel_modif_div').style.display='none'; }else{ document.getElementById('rappel_modif_div').style.display='block'; }"/>
				<label for="rapel_evenement_modif"></label>
				<label>Rappel:</label>

				<div style="display:none" id="rappel_modif_div">
          <label>Type de rapel:</label>
          <select id="type_rappel_evenement_modif">
            <option id="type_rappel_evenement_init">SMS</option>
            <option>SMS</option>
            <option>Mail</option>
          </select>
				</div> 
			</div>  
		  <br>	
	    <input type="text" hidden value="" id="id_event" />
	</div>    

		<br><button id="bp_event" onclick="modifier_event(<?php echo $j; ?>,<?php echo $m; ?>,<?php echo $a; ?>);">Modifier</button>
	   <button id="bp_event" onclick="suprimmer_event(<?php echo $j; ?>,<?php echo $m; ?>,<?php echo $a; ?>);">Supprimer</button>
	   <button id="bp_event" onclick="annuler_affich_modif_event();">Annuler</button><br><br>
</div>

<!-- ************************************************************************************************************************************************** update -->

  <div id="accordion" align="center"><?php 
      foreach ($event_mois as $event) { //evenements du mois 
        if($onglet==$event["type_agenda"]){
        $i=0;

        ?><h3><?php echo html_entity_decode($event["event"]); if($event["heure_event"]!='00:00:00') echo ': '.date('h',strtotime($event["heure_event"])).'h'; ?></h3>
        <div>
          <div <?php if($onglet=='Anniversaire' && $event["detail_event"]=='' ){ echo "hidden"; } ?> class="input_ligne" style="width:85%;">
          <br>
              <div hidden><label>Evenement:</label><br><b id="<?php echo 'evenement'.$event["id_event"]; ?>"><?php echo html_entity_decode($event["event"]); ?></b></div>
              <div hidden><label>heure:</label><br><b  id="<?php echo 'type_agenda'.$event["id_event"]; ?>"><?php echo $event["type_agenda"]; ?></b></div>

              <div hidden id=""><label>Date:</label><br><b id="<?php echo 'date_evenement'.$event["id_event"]; ?>"><?php echo $event["date_event"]; ?></b></div>

              <?php if($event["heure_event"]!='00:00:00'){ $i=1; ?>
                <label>Heure: </label>
                <b id="<?php echo 'heure_evenement'.$event["id_event"]; ?>"><?php echo $event["heure_event"]; ?></b>
              <?php }else{ ?>
                <b hidden id="<?php echo 'heure_evenement'.$event["id_event"]; ?>"><?php echo $event["heure_event"]; ?></b>
              <?php } ?>
              <?php if($event["duree_event"]!='0000-00-00 00:00:00'){ $i=1; ?>
                <?php }else{ ?><div hidden id=""><?php } ?>
                <label>durée:</label><b id="<?php echo 'temp_evenement'.$event["id_event"]; ?>"><?php echo $event["duree_event"]; ?></b></div>
              <?php if( $event["detail_event"]!=''){ $i=1; ?>
              <div id=""><label>détail:</label><b id="<?php echo 'detail_evenement'.$event["id_event"]; ?>"><?php echo $event["detail_event"]; ?></b></div>
              <?php }else{ ?>
              <div hidden><label>détail: </label><br><b id="<?php echo 'detail_evenement'.$event["id_event"]; ?>"><?php echo $event["detail_event"]; ?></b></div>
              <?php } ?>

              <?php if( $event["recurence"]=='1' && $onglet!='Anniversaire' ){ $i=1; ?>
                <div id=""><label>annuel:</label><b hidden id="<?php echo 'checkbox_evenement'.$event["id_event"]; ?>"><?php echo $event["recurence"]; ?></b><b>Oui</b></div>
                <?php }else{ ?>
                <div hidden><label>Récurence:</label><br><b id="<?php echo 'checkbox_evenement'.$event["id_event"]; ?>"><?php echo $event["recurence"]; ?></b></div>
                <?php } ?>

              <?php if( $event["rappel_event"]=='Oui' && $onglet!='Anniversaire'){ $i=1; ?>
              <div id=""><label>Rappel: </label><b id="<?php echo 'rapel_evenement'.$event["id_event"]; ?>"><?php echo $event["rappel_event"]; ?></b></div>
              <div id=""><label>Type: </label><b id="<?php echo 'type_rappel_evenement'.$event["id_event"]; ?>"><?php echo $event["type_rappel"]; ?></b></div>
              <?php }else{ ?>
              <div hidden><label>rappel:</label><br><b id="<?php echo 'rapel_evenement'.$event["id_event"]; ?>"><?php echo $event["rappel_event"]; ?></b></div>
              <div hidden><label>type:</label><br><b id="<?php echo 'type_rappel_evenement'.$event["id_event"]; ?>"><?php echo $event["type_rappel"]; ?></b></div>
              <?php } 
                if( $i!=1 ){ ?>
              Aucunes données pour cet événement<br>
              <?php } ?>
              <br>
          </div>
          <button id="bp_event" onclick="affich_modif_event(<?php echo $event["id_event"]; ?>);">Modifier</button>
        </div>
      <?php	
        } 
      }

    if( $i != 0 ){ ?>
      <h3><button id="bp_event">Nouvel événement</button></h3>
    <?php	} else { ?>
        <h3 >Nouvel événement</h3>
    <?php }	?>

    <!-- ************************************************************************************************************************************************** new event -->

    <div id="formulaire_new_event" align="center">
      <div class="input_ligne" style="width:85%;">
        <label><?php echo $onglet; ?></label>
        <br><br>
        <label>Date:</label>
        <input type="date" value="<?php echo date('Y-m-d',strtotime($a.'-'.$m.'-'.$j)) ?>" id="date_evenement" />
        <label <?php if($onglet=='Anniversaire'){ echo "hidden"; } ?> >Heure:</label>
        <input <?php if($onglet=='Anniversaire'){ echo "hidden"; } ?> type="time" value="00:00" id="heure_evenement" />
        <label hidden>Fin:</label>
        <input hidden type="time" value="" id="temp_evenement" />
        <br><br>
        <label>Nom:</label>
        <input type="text" id="evenement" placeholder="Evenement" />
        <br><br>
        <label>Détails:</label>
        <input type="text" id="detail_evenement" style="width:40%;" placeholder="Détails" />

        <input hidden type="text" id="type_agenda"/>
        <br>
        <div <?php if($onglet=='Anniversaire'){ echo "hidden"; } ?> >

          <input type="checkbox" id="checkbox_evenement"/>
          <label for="checkbox_evenement"></label>
          <label >Evénement annuel</label>
          <br><br>

          <input type="checkbox" id="rapel_evenement" onchange="if(this.checked!=true){ document.getElementById('rappel_div').style.display='none'; }else{ document.getElementById('rappel_div').style.display='block'; }"/>
          <label for="rapel_evenement"></label>
          <label>Rappel:</label>

          <div style="display:none" id="rappel_div">
            <label>Type:</label>
            <select id="type_rappel_evenement" >
              <option>SMS</option>
              <option>Mail</option>
            </select>
          </div>
        </div>
        <br>
    </div>
    <br><button id="bp_event" onclick="inserer_event(<?php echo $j; ?>,<?php echo $m; ?>,<?php echo $a; ?>);">Ajouter</button><br><br>
  </div>
</div>

<?php 

//****************************************************************************************************************************************************************************
} else if($onglet=='Agenda' || $onglet=='Anniversaire') { //*****************************************************************************************************************
//****************************************************************************************************************************************************************************

  $m=date("n");
  $a=date("y");
  if(isset( $_GET["annee"])) // la variable existe
      $a=$_GET["annee"];

  if(isset( $_GET["mois"])) // la variable existe
  {
      $m = $_GET["mois"];
      if($m>12){
          $m=1;
          $a++;
      } else if($m<1){
          $m=12;
          $a--;
      }
  }
	$events = get_diary('+30 days',"$a-$m-01");				// on cherche les evenements du mois 
  $event_mois = array();
  $i=0; 
  foreach ($events as $event) { 
    if($m.$a == date('ny',strtotime($event["date_event"])) || $m == date('n',strtotime($event["date_event"])) && $event["recurence"]=="true" || $m == date('n',strtotime($event["date_event"])) && $event["recurence"]=="1" ){
    $event_mois[$i] = $event;
    $i++;	
    }
   } ?>
				
  <div id="titre_pages" style="text-align:center; padding:0;">
  <img id="bp_mois_prec" onclick="mois_prec(<?php echo $m; ?>,<?php echo $a; ?>,<?php echo $tous; ?>)" src="img/appImg/gche.png"/>
  <div class="titre_agenda"><?php echo $nom_mois[$m]." 20".$a; ?></div>
  <img id="bp_mois_next" onclick="mois_suiv(<?php echo $m; ?>,<?php echo $a; ?>,<?php echo $tous; ?>)" src="img/appImg/drte.png" />
  </div>
  <br><br>
  <?php echo $i." événements"; ?>
	
  <div class="affichage_mois">
    <div class="first_line"><?php
      for($i=1; $i<8; $i++){
          echo '<li>'.$nom_jour[$i].'</li>';
      } ?>
    </div><?php

    $j = date("N", mktime(0, 0, 0, $m, 1, $a ));
    $j--;
    $nb_j=cal_days_in_month ( 1 , $m , $a );
    if($m!=1)
        $nb=cal_days_in_month ( 1 , $m-1 , $a );
    else
        $nb=cal_days_in_month ( 1 , 12 , $a-1 );
  
    $i=0;
    while($i<$j){
        ?><li class="jautre" onclick="afficher_jour(<?php echo $nb-$j+$i+1; ?>,<?php if($m!=1){ echo $m-1; }else{ echo $m; } ?>,<?php if($m==1){ echo $a-1; }else{ echo $a; }  ?>);"><?php echo $nb-$j+$i+1; ?></li><?php
    $i++;
    }
    ?><ol id="calendar"><?php
    for($i=1; $i<=$nb_j; $i++){ 			

        ?><li class="days" id="<?php if( $i==date('j') && $m==date("n") && $a==date("y")){ echo 'today'; } ?>" onclick="afficher_jour(<?php echo $i; ?>,<?php echo $m; ?>,<?php echo $a; ?>);"><div id="date_jour"><?php echo $i ?></div><?php
        foreach ($event_mois as $event) { // month events 
          
          if( $i.$m == date('jn',strtotime($event["date_event"])) && ( $event["type_agenda"] == $onglet || $tous )  ){
            
            if( $event["type_agenda"] == 'Anniversaire' && $tous )
              echo '<NOBR style="color: rgba(255, 255, 255,0.3);" title="'.$event["detail_event"].'" >• '.html_entity_decode($event["event"]).'</NOBR><br>';
            else
              echo '<NOBR title="'.$event["detail_event"].'">• '.html_entity_decode($event["event"]).'</NOBR><br>';
          }
       }
       ?></li><?php
    }
    ?></ol><?php
    $i=1;
    while($j+$nb_j+$i<40){
        ?><li class="jautre" onclick="afficher_jour(<?php echo $i; ?>,<?php if($m!=12){ echo $m+1; }else{ echo $m; } ?>,<?php if($m==12){ echo $a+1; }else{ echo $a; } ?>);"><?php echo $i ?></li><?php
    $i++;
    }
  ?>
  </div>

<?php
//****************************************************************************************************************************************************************************
 }  else if($onglet=='Fêtes') { //*********************************************************************************************************************************************
//****************************************************************************************************************************************************************************

  $m=date("n");
  $a=date("y");
  if(isset( $_GET["annee"])) // la variable existe
    $a=$_GET["annee"];

  if(isset( $_GET["mois"])) // la variable existe
  {
    $m = $_GET["mois"];
    if($m>12){
        $m=1;
        $a++;
    } else if($m<1){
        $m=12;
        $a--;
    }
  }

  $saints = afficher_database_table("agenda_saint WHERE saint_mois = $m");				// on cherche les evenements du mois 
  $event_mois = array();
  $i=0; 
  foreach ($saints as $saint) { 

    if( $saint["saint_mois"] == intval($m) ){
      $event_mois[$i] = $saint;
      $i++;
    }
  }
  ?>
				
	<div id="titre_pages" style="text-align:center; padding:0;">
	<img id="bp_mois_prec" onclick="mois_prec(<?php echo $m; ?>,<?php echo $a; ?>)" src="img/appImg/gche.png"/>
	<div class="titre_agenda"><?php echo $nom_mois[$m]." 20".$a; ?></div>
	<img id="bp_mois_next" onclick="mois_suiv(<?php echo $m; ?>,<?php echo $a; ?>)" src="img/appImg/drte.png" /></div><br><br>
	</br>
	
  <div class="affichage_mois">
    <div class="first_line"><?php
        for($i=1; $i<8; $i++){
            echo '<li>'.$nom_jour[$i].'</li>';
        }   ?>
    </div><?php

    $j = date("N", mktime(0, 0, 0, $m, 1, $a ));
    $j--;
    $nb_j=cal_days_in_month ( 1 , $m , $a );

    if($m!=1)
        $nb=cal_days_in_month ( 1 , $m-1 , $a );
    else
        $nb=cal_days_in_month ( 1 , 12 , $a-1 );

   $i=0;
    while($i<$j){
        ?><li class="jautre"><?php echo $nb-$j+$i+1; ?></li><?php
    $i++;
    }
    ?><ol id="calendar"><?php
    for($i=1; $i<=$nb_j; $i++){
      ?><li class="days" id="<?php if( $i==date('j') && $m==date("n") && $a==date("y")){ echo 'today'; } ?>">
      <?php	
      foreach ($event_mois as $event) { //evenements du mois 
        if( $event["saint_jour"] == intval($i) ){

          ?><div style="float:right;"><?php echo $i; ?></div>
          <input class="checkbox_agenda" hidden <?php if($event["avertir_saint"]){ echo 'checked'; } ?> id="<?php echo $i.$m; ?>" type="checkbox" onclick="modifier_avertir_saint('<?php echo $i; ?>','<?php echo $m; ?>', this.checked )" />
          <label class="checkbox_agenda" for="<?php echo $i.$m; ?>"></label>
          <?php 
          echo '<br><aaa title="'.html_entity_decode($event["saint_nom1"]).'" >'.html_entity_decode($event["saint_nom1"]).'</aaa>';
          echo '<br><aaa title="'.html_entity_decode($event["saint_nom2"]).'" >'.html_entity_decode($event["saint_nom2"]).'</aaa>';
        } 
      }
      ?></li><?php
    }
    ?></ol><?php
    $i=1;
    while($j+$nb_j+$i<42){
        ?><li class="jautre"><?php echo $i ?></li><?php
    $i++;
    } ?>
</div>
<?php } ?>
