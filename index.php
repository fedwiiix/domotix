<!doctype html>

<html>
	<head>										<!-- on insère les css.... -->
		<meta charset="utf-8">
		<link rel="shortcut icon" href="css/img/icon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/form.css">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Domotix</title>
    <style>
      body {
        width: 100%;
        height: 100%;
         background-image: url(css/img/bg8.png);
         background-repeat: no-repeat;
         background-size: cover;
         -moz-backgroud-size:100% 100%;
         -o-backgroud-size:100% 100%;
         -webkit-backgroud-size:100% 100%;
      }
    </style>
	</head>
<body>
<div class="body">
<?php require_once ('parametre/connection.php'); ?>			
<div class="connexion" align="center">
	<form method="post"><br><br>
    <eee>
      <input type="text" name="user" placeholder="Login" /><br>
      <input type="password" name="pass" placeholder="Password" /><br>
      <?php if($_SESSION['message']){
        ?><div id="message"><?php echo $_SESSION['message']; ?></div>
      <?php }else{ ?>
        <input type="checkbox" id="cookie" name="cookie" title="Rester connecté"/><label for="cookie"></label>
      <?php } ?>
      <input type="submit" id="bouton_connexion" name="submit" value="Connexion" /><br>
    </eee>
	</form>
</div>
</div>	
</body>
</html>

