<?php  require('../parametre/digestConnection.php');  
/*****************************************************************************************************

Api to get values in database

example of use: https://user:pass@sjtm.fr/domotix/database/getDbApi.php?request=alarmes

return json data


*****************************************************************************************************/

if(isset( $_GET["request"])  ) {
  $request = addslashes( htmlentities($_GET["request"],NULL,'UTF-8'));
}else{
header('Location: ../index.php');
die("access denied");
}

session_start();
$_SESSION['pass_get_db']="nJkHZkB9S7e386g4DR9Kp9yf9";
require("databaseFunctions.php"); 

$database_tabe_list = array("alarmes","appareils","parametres", "piece", "telecommande", "telecommande_music" , "assistantCmd" ); 

if($request == "random_citation"){

    $citations =  afficher_database_table("citations", "RAND() LIMIT 1");

    echo '{"citation":[{';
    foreach($citations as $citation){
        echo '"citation": "'.html_entity_decode($citation['citation']).'", "auteur": "'.html_entity_decode($citation['auteur_citation']).'"';
    }
    echo'}]}';

}else if($request == "agenda" and isset( $_GET["mode"])){
    
    $agendas = get_diary($_GET["mode"]);

    echo '{"agenda":'.html_entity_decode(json_encode($agendas)).'}';

}else if($request != "all_tables"){

    $order='';
    if($request=='message')
        $order='date_message DESC LIMIT 30';

    $data = afficher_database_table($request,$order);
        echo '{"'.$request .'":'.json_encode($data).'}';

}else{

$i=0;
echo '{';
foreach($database_tabe_list as $table){
    $data = afficher_database_table($table);
        echo '"'.$table .'":'.html_entity_decode(json_encode($data));
    $i++;
    if($i!=sizeof($database_tabe_list))   echo ',';
}
echo '}';

}


?>


