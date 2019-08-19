<?php	
session_start();
if(isset( $_SESSION["page"])) 
{
	$nom_page = $_SESSION["page"];			
	$pages=$_SESSION['droit_page'];

	 foreach ($pages as $page) { 
		if($page['nom']==$nom_page ){
      if( $_SESSION['droit'] >= $page['utilisateur'] ){
      } else {
				header('Location: ../index.html');
      }
		}
	}
}

?>