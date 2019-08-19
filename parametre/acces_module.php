<?php	
	session_start();
	if(isset( $_SESSION["module"])) 
	{
	$nom_page = $_SESSION["module"];			
	$pages=$_SESSION['droit_module'];

	 foreach ($pages as $page) { 
		if($page['nom_module']==$nom_page ){
			
			if( $_SESSION['droit'] >= $page['utilisateur_module'] ){
			} else {
				header('Location: ../index.html');
			}
		}
	}
}
?>