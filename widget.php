<?php /*require ('parametre/security.php');*//*require ('parametre/digestConnection.php');*/ require ("database/databaseFunctions.php");  ?>

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
    <style type="text/css">

        #centre, .container_long, .container_haut, .container, .big-container, .big-container-musicPlayer, .dj_container{
          margin:0;
          padding:0;
          position:absolute;
          z-index:5;
          top:0;
          left:0;
          width: 100%;
          height: 100%;
        }
        #titre_module, #titre_pages{
          width:100% !important;
        }
      html *{
        cursor: none !important;
        -webkit-user-select: none; /* Safari */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none;
      }
    </style>
    <?php require ('api/keyboard.html'); ?>
		
	</head>
  <body onKeyUp="/*touche_presser(event.keyCode)*/">
    <div class="message">Bienvenu</div>
    <div id="centre"></div>
  </body>
</html>
