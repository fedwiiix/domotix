<?php
session_start();
if ( !isset($_SESSION['id']) AND !isset($_SESSION['pseudo']))
{	
    header('Location: ./index.php'); 
}

//ini_set('display_errors', 1);



// Token first part in connection page

/*$ticket = uniqid(); // create random ticket
$ticket = hash('sha512', $ticket); // hash
setcookie("ticket", $ticket, time() + (60 * 20)); // save in both sides / expires after 20 min  
$_SESSION['ticket'] = $ticket;*/
/*
session_start();
if ( isset($_SESSION['ticket']) && isset($_COOKIE['ticket']) ){
	
  if ($_COOKIE['ticket'] == $_SESSION['ticket'])
  {
    
    session_write_close();
    $ticket = uniqid(); // create new
    $ticket = hash('sha512', $ticket);
    $_SESSION['ticket'] = $_COOKIE['ticket']= $ticket;
    
    echo "<script>console.log('yes')</script>";
    
  }else{
    // On détruit la session
    //$_SESSION = array();
    //session_destroy();
    //header('location:./index.php');
    echo "<script>console.log('no')</script>";
  }
}else{	
    //header('Location: ./index.php'); 
}
*/
?>