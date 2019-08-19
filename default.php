<?php require ('parametre/security.php'); require ("database/databaseFunctions.php");  ?>

<!doctype html>
<html>
	<head>
		<title><?php echo $_SESSION['assistant_name']; ?></title>										<!-- on insère les css.... -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
		<link rel="shortcut icon" href="css/img/icon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" type= "text/css" href="css/form.css" />
		<link rel="stylesheet" type= "text/css" href="css/mise_en_page.css" />
		<link rel="stylesheet" type= "text/css" href="css/cloud.css" />
		<link rel="stylesheet" type="text/css" href="css/editer_doc.css">
		<link rel="stylesheet" type= "text/css" href="css/musicPlayer.css" />

		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 

     <?php session_start();
     if($_SESSION['droit']==1){ // application only ?>
      <style type="text/css">
        html *{cursor: none !important;}
		  </style>
		 <?php require ('api/keyboard.html'); }  ?>

	</head>
  <body onKeyUp="/*touche_presser(event.keyCode)*/">

    <div id="menu_web"><?php require ('menu.php'); ?></div>

    <div class="message">Bienvenu sur Aya</div>

    <div id="centre"></div>
    <div id="centre_dj"></div>
    <div id="centre_musicPlayer"></div>

    <!-- fileUpload for cloud app -->
    <div id="quitter_upload" onclick="afficher_upload()" style="position:absolute; width:100%; height:100%; z-index:9; display: none; background-color: rgba(0,0,0,0.3);"></div>
    <div id="fileupload" align="center"><iframe width="310px" height="100%" src="cloud/qsd4pk7s1s-upload/index.php" style="border:0;"></iframe></div>

  </body>
</html>

