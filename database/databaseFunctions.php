<?php

function connexion()
{ 
    try{
//************************************************************************** SERVER INFOS *****************************
      
  $VALEUR_hote='localhost';                 // database adress
  $VALEUR_port='3306';                      // database port (default 3306)
  $VALEUR_nom_bd='domotix';                 // database name

  $VALEUR_user='fredy';                       // user name
  $VALEUR_mot_de_passe='tdEgapmtgIDH90tU';         // password
      
//************************************************************************** SERVER INFOS *****************************

  $bdd = new PDO('mysql:host='.$VALEUR_hote.';port='.$VALEUR_port.';dbname='.$VALEUR_nom_bd, $VALEUR_user, $VALEUR_mot_de_passe, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); // MySQL connection
  
  }catch(Exception $e){ 
    die('------------------------------------- Erreur : db ------------------------------------------');
  }
return $bdd;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        connection

function connexion_user($login, $pass_hache)  // user connection
{
  $login = addslashes(htmlspecialchars($login));
  $pass_hache = addslashes(htmlspecialchars($pass_hache));

  $pass_hache = sha1(md5(sha1($pass_hache)));// pass hach
  $response = connexion()->query("SELECT `id_utilisateur`, `pseudo`, `email` , `droit` FROM `utilisateurs` WHERE pseudo = '$login' AND password = '$pass_hache'");
  while ($datas = $response->fetch()) // get user infos
      {
      return $datas;
      }
  $response->closeCursor(); // end request   
}

function inserer_connexion_domotix($pseudo,$ip_utilisateur,$droit_utilisateur,$succes) // insert connection in database -> to ban bad users 
{
  $pseudo = addslashes(htmlspecialchars($pseudo));
  $ip_utilisateur = addslashes(htmlspecialchars($ip_utilisateur));
  $droit_utilisateur = addslashes(htmlspecialchars($droit_utilisateur));
  $succes = addslashes(htmlspecialchars($succes));
  connexion()->exec("INSERT INTO `domotix`.`connexion_domotix` (`id_utilisateur`, `pseudo`, `ip_utilisateur`, `droit_utilisateur`, `date_connection`, `succes`) VALUES (NULL, '$pseudo', '$ip_utilisateur','$droit_utilisateur', NOW(), '$succes')");
}

function afficher_database_table_connexion( $table )    // get data for the connection
{
  if( $table== "parametres" or $table== "module" or $table== "droits_pages" )
      $response = connexion()->query("SELECT * FROM $table");
  else if( $table== "connexion_domotix" )
      $response = connexion()->query('SELECT * FROM `connexion_domotix` ORDER BY date_connection DESC LIMIT 50'); // see previous connections to ban users
  $returns = array();
  while ($datas = $response->fetch())
     {
      $returns[]=$datas;
     }
  $response->closeCursor(); 
  return $returns;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        display public quotes

function afficher_citations( $add )    // on affiche les données
{
  $response = connexion()->query("SELECT * FROM citations $add");
  $returns = array();
  while ($datas = $response->fetch())
    {
     $returns[]=$datas;
    }
  $response->closeCursor(); // Termine le traitement de la requête
  return $returns;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        affichage des données

session_start();

if ( (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])) OR (isset($_SESSION['pass_get_db']) AND $_SESSION['pass_get_db']=="nJkHZkB9S7e386g4DR9Kp9yf9") )
{

function afficher_database_table( $table )    // on affiche les données
{
  $response = connexion()->query("SELECT * FROM $table");

  $returns = array();
  while ($datas = $response->fetch())
    {
     $returns[]=$datas;
    }
  $response->closeCursor(); // Termine le traitement de la requête
  return $returns;
}

function get_diary($mode, $date_begin)    // get agenda of the week or day
{

    if(!$date_begin)
        $date_begin = date("y-m-d");

    if($mode=='week')
        $date_end = date('y-m-d', strtotime($date_begin. ' + 7 days'));

    else if($mode=='tomorrow')
        $date_begin = $date_end = date('y-m-d', strtotime($date_begin. ' + 1 days'));
    else if($mode=='yesteday')
        $date_begin = $date_end = date('y-m-d', strtotime($date_begin. ' - 1 days'));
    else 
        $date_end = date('y-m-d', strtotime($date_begin.' '.$mode));

    $month_begin = date('m', strtotime($date_begin));
    $month_end = date('m', strtotime($date_end));

    $day_begin = date('d', strtotime($date_begin));
    $day_end = date('d', strtotime($date_end));

    if($month_begin == $month_end)  // if it's between 2 month
        $response = connexion()->query("SELECT * FROM agenda WHERE ((recurence = '1' AND MONTH(date_event) = '$month_begin' AND DAY(date_event) between '$day_begin' and '$day_end') OR (date_event between '$date_begin' and '$date_end')) ORDER BY DAY(date_event) ASC");
    else
        $response = connexion()->query("SELECT * FROM agenda WHERE ((recurence = '1' AND ( ( MONTH(date_event) = '$month_begin' AND DAY(date_event) between '$day_begin' and '31' ) OR ( MONTH(date_event) = '$month_end' AND DAY(date_event) between '1' and '$day_end' ))) OR (date_event between '$date_begin' and '$date_end')) ORDER BY DAY(date_event) ASC");

    $returns = array();
    while ($datas = $response->fetch())
        {
         $returns[]=$datas;
        }
    $response->closeCursor(); // Termine le traitement de la requête
    return $returns;
    }
}

?>



