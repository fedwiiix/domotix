<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container_long">
  <div id="titre_module" onclick="lancer_onglet('messagerie');" ><div id="notif_clignottement"></div>Messagerie</div><br><br>
  <div style="width:88%; margin:auto; ">
      <?php
        session_start();
        $id = $_SESSION['id'];

        $messages = afficher_database_table("message ORDER BY `message`.`date_message` DESC");			//on affiche les données
        $message_today=0;
        foreach ($messages as $message) 
        {
          if( date("d/m/Y") == date('d/m/Y',strtotime($message["date_message"])) &&  $message['id_auteur'] != $id )
            $message_today=1;

        if($_SESSION['pseudo'] == $message['auteur_message'] && $_SESSION['id'] == $message['id_auteur']){
          ?><div id="affichage_message" style="float:right;"><?php
        } else {
          ?><div id="affichage_message" style="float:left;"><?php
        }	
        ?><h4 style="margin-left:20px;" title="<?php	echo " le ".date('d/m/y',strtotime($message["date_message"])); ?>">
          <span style="float:left; "><?php	echo $message['auteur_message'].':'; ?></span>
        <p style="tex-align:left;"><?php echo $message['message']; ?></p>
          </h4>
        </div>
        <?php	} ?>
      </div>
  </div>
<!--/div-->

<script type="text/javascript">		
	
	$( document ).ready(function() {
     if("<?php echo $message_today ?>"==1){
			 
			 $("#notif_clignottement").css('display', 'block');
			 setInterval('$("#notif_clignottement").fadeOut(900).delay(300).fadeIn(800);',2200);
		 }
	});
	
</script>