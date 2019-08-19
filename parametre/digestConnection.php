
<?php

//utilisateur => mot de passe

$filePath=getcwd();
if(basename($filePath)!="domotix"){
  $filePath.="/..";
}  

$iniUser=parse_ini_file( $filePath."/parametre/server.ini");
$users= array($iniUser["user"] => $iniUser["pass"]);
//echo $iniUser["user"];
//$users = array('aiaUser' => 'aecoenplaienghdjk198sd56');

$realm = 'Restricted area';
if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

    die('button escape use');
}
// analyse la variable PHP_AUTH_DIGEST
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('no identity!');

// Génération de réponse valide
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('bad identity!');

// ok, utilisateur & mot de passe valide
//echo 'good : ' . $data['username'];

// fonction pour analyser l'en-tête http auth
function http_digest_parse($txt)
{
    // protection contre les données manquantes
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));
 
    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }
    return $needed_parts ? false : $data;
}
?>
