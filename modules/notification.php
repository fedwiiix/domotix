<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?> 

<div class="container_long">
  <div id="titre_module" >Notifications</div><br><br>
  <div class="notification" align="center">

    <p style="color: green; opacity:0.5; font-weight:bold;">
    <?php
    $m=date("n");
    $i=date('j');
    $date = date("y-m-d");
    $m1=date('n',strtotime($date . "+1 days"));
    $i1=date('j',strtotime($date . "+1 days"));

    $saints = afficher_database_table("agenda_saint WHERE ((saint_mois = $m AND saint_jour =$i) OR (saint_mois = $m1 AND saint_jour =$i1))");
    $i=0;
    foreach ($saints as $saint) { 
      if( !$i ){
        echo "Fêtes de ".html_entity_decode($saint["saint_nom1"]);
        if( $saint["saint_nom2"] !='')
          echo ' & '.html_entity_decode($saint["saint_nom2"]); 
        echo "</p><p>";
        $i++;
      }else{
        echo "Demain: ".html_entity_decode($saint["saint_nom1"]);
        if( $saint["saint_nom2"] !='')
          echo ' & '.html_entity_decode($saint["saint_nom2"]);
      }
    } 
    ?></p>
    <hr>
    
    <?php 
    $events = get_diary('+7 days');
    $j=sizeof($events);

    if($j>0){ ?>
      <h3 onclick="lancer_onglet('agenda')"><?php echo $j." "; ?>événement<?php if($j>1) echo "s"; ?> à venir:</h3><br>
    <table>                                        
        <tr><th>Evénement</th>
            <th>Date</th>
            <th>heure&nbsp;&nbsp;&nbsp;</th>
        </tr>
    <?php  
      foreach ($events as $event) { ?> 
          <tr>
          <?php  if($event['type_agenda']=="Anniversaire"){
              echo '<td style="color:#006dad; width:50%;">'.$event['event'].'&nbsp;</td>';
            }else{
              echo '<td style="width:50%;">'.$event['event'].'&nbsp;</td>';
            } ?>
            <td><?php echo date('j/m',strtotime($event["date_event"]))."&nbsp;"; ?></td>    
            <td><?php if(date('G:i',strtotime($event["date_event"]))!='0:00')  echo date('G:i',strtotime($event["date_event"])); ?></td>           
          </tr>
    <?php } ?>
    </table> 
    <?php }

     $i=0; 
    $alarmes = afficher_database_table("alarmes");/////////////////////////////////////////////////////////////////////////////////////
    foreach ($alarmes as $alarme) {    
        if( $alarme['status_alarme'] ){
          $i++;
        }
    }
    if($i>0 && $j>0 ){
      ?><br><hr><?php

    } 
    if($i>0){ ?>
      <h3 onclick="lancer_onglet('configuration','alarme')"><?php echo $i." "; ?>Alarme<?php if($i>1) echo "s"; ?> actives:</h3><br>
    <table>                                        
      <tr><th>Date</th>
        <th>heure&nbsp;&nbsp;&nbsp;</th>
        <th>Action</th>
      </tr>
      <?php   
      foreach ($alarmes as $alarme) {    
          if( $alarme['status_alarme'] ){ ?>
      <tr>
          <td>
            <?php $recurence = $alarme['repeter_alarme']; ?>
            <label <?php if($recurence[1]!=1){ echo 'hidden'; } ?>>Lu</label>
            <label <?php if($recurence[2]!=1){ echo 'hidden'; } ?>>Ma</label>
            <label <?php if($recurence[3]!=1){ echo 'hidden'; } ?>>Me</label> 
            <label <?php if($recurence[4]!=1){ echo 'hidden'; } ?>>Je</label>
            <label <?php if($recurence[5]!=1){ echo 'hidden'; } ?>>Ve</label>
            <label <?php if($recurence[6]!=1){ echo 'hidden'; } ?>>Sa</label>
            <label <?php if($recurence[0]!=1){ echo 'hidden'; } ?>>Di</label>
          </td> 
          <td><?php echo date('G:i',strtotime($alarme["heure_alarme"])); ?></td>    
          <td><?php echo $alarme['action_alarme']; ?></td>           
      </tr>
      <?php } } ?>
    </table> 
    <?php } 
    
    $j=0;
    $fonctions = afficher_database_table("fonctions");/////////////////////////////////////////////////////////////////////////////////////
    $now = new DateTime();

    foreach ($fonctions as $fonction) { 
    if($_SESSION['droit']>$fonction['droit']){ 
       if( $fonction['status_fonction']=="Activ&eacute;e" && $fonction["date_fonction"] > $now){ 
         $j++;
       }
      }
    }
    if($i>0 && $j>0){
      ?><br><hr><?php
    } 
    if($j>0){ ?>
      <h3 onclick="lancer_onglet('configuration','fonction')"><?php echo $j." "; ?>Fonction<?php if($j>1) echo "s"; ?> programées actives:</h3><br>
    <table>                                     
      <tr><th>fonction&nbsp;&nbsp;&nbsp;</th>
      <th>appareil</th>
      <th>Date</th>
      <th>Heure</th></tr>
      <?php   
      foreach ($fonctions as $fonction) { 
      if($_SESSION['droit']>$fonction['droit']){ 
        if( $fonction['status_fonction']=="Activ&eacute;e" && $fonction["date_fonction"] > $now ){ ?>
      <tr>
        <td><?php echo $fonction['nom']."&nbsp;"; ?></td> 
        <td><?php echo $fonction['appareil']."&nbsp;"; ?></td> 
        <td><?php echo date('j/m',strtotime($fonction["date_fonction"])); ?></td> 
        <td><?php echo date('G:i',strtotime($fonction["heure_fonction"])); ?></td> 
      </tr>    
      <?php } } } ?>
    </table>
    <?php } 

    $messages = afficher_database_table("message");/////////////////////////////////////////////////////////////////////////////////////	
    $i=0;
    foreach ($messages as $message) 
    {
      if( date("d/m/Y") == date('d/m/Y',strtotime($message["date_message"]))){
        if($_SESSION['id'] != $message['id_auteur'])
        $i++;
    } }

    if($i>0){    ?>
    <br><hr>
    <h3 onclick="lancer_onglet('messagerie')"><?php echo $i." "; ?>Message<?php if($i>1) echo "s"; ?> reçu aujourd'hui:</h3><br><?php
    }
    foreach ($messages as $message) 
    {
      if( date("d/m/Y") == date('d/m/Y',strtotime($message["date_message"]))){
        if($_SESSION['id'] != $message['id_auteur']){
    ?>
      <div style="margin-left:20%; padding-bottom:0px;" title="<?php	echo " le ".date('d/m/y',strtotime($message["date_message"])); ?>">
      <?php	echo $message['auteur_message'].':'; ?>
      <b style="margin-left:10px;"><?php echo $message['message']; ?></b>
      </div>

    <?php	} } } ?>

  </div>
  <br><br>
</div>


