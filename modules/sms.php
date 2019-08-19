<?php
require ('../parametre/security.php'); 
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  
<div class="container">
	<meta charset="utf-8">
  <div id="titre_module" >SMS</div><br><br><br><br>
    <textarea type="text" name="sms" id="texte" style="width:82%; height:30%;" placeholder="SMS"></textarea>
    <br><br>
		<button type="button" id="bouton_oval" onclick="sms();" > Envoyer </button>
		<br>
</div>

<script type="text/javascript">		
	
function sms(){
		
	var message = document.getElementById("texte").value;
	if(message ==''){
		afficherMessage("Veuillez completer les champs !");
	} else {
		message =encodeURI( message)
	
		$("#texte").val("")
			$.ajax({
				type: "POST",
				url: "./api/action.php",
				dataType: "json",
				data: {action:'sms', message },
        //"success": function(response){ afficherMessage(response.result); },
				//"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
			});	
      afficherMessage("SMS envoyé");
		}
	}

</script>

