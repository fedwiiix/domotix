<?php require ('../parametre/security.php'); 

$initial_directory = $_SESSION["cloudDir"];
		  
if(isset( $_GET["file"]))
{
  $file_name = urldecode($_GET["file"]);
	$file = $initial_directory.$file_name;	
} 
if (strpos($file, '../')) 
  die('error file denied');

$extension = pathinfo($file, PATHINFO_EXTENSION);

$extEdit = array('', 'md', 'ino','txt','css','js','php','h','c','py','sh','ini','html');
$extEditE = 0;
foreach($extEdit as $ext){
  if($extension==$ext){
    $extEditE = 1;
} }

$contenu=file_get_contents($file);
//$contenu = utf8_decode($contenu);
?>
<input type="hidden" id="initial_directory" value="<?php echo $fichier ?>" />

<div id="titre_pages"><img onclick="afficher_fichier('<?php echo urlencode($file_name) ?>')" height="30px" src="img/cloud/precedent.png" style="float:left; cursor:pointer; padding-top:5px; padding-right:20px;"><?php

$titre = explode('/',$file_name);
echo substr( $titre[sizeof($titre)-1],0,-1-strlen ($extension));
?>

<button id="bp_editer" style="margin-left:10px; vertical-align:top;" onclick="sauvegarder_cloud('<?php echo urlencode($file_name) ?>', '<?php echo urlencode($extension) ?>')">Sauver</button>
<span id="save_result" style="font-size:15px; margin-left:10px;" ></span>
</div>
<?php
if( $extEditE == 1 && $extension!='html'){  //********************************************************************************************************************************************
?>

<!--<div id="espace_affichage">
  <textarea id="code" cols="120" rows="35" ><?php // echo $contenu ?></textarea>
</div>
-->
<div id="espace_affichage">
  <textarea id="text_editor"><?php echo $contenu ?></textarea>
</div>

<?php
} else if($extension=='html'){  //********************************************************************************************************************************************
?>

<div class="editeur">

  <div class="commande_editeur">
 
    
  <a href="<?php echo 'filedownload.php?directory='.$directory_sans_caracteres.'&fichier='.$fichier_sans_caracteres; ?>"  ><input type="button" value="Word" ></a>
  <a href="<?php echo $file_sans_caracteres ?>" download="<?php echo $fichier_sans_caracteres ?>"><input type="button" value="Html" ></a>
    
  <input type="button" value="G" style="font-weight: bold;" onclick="commande('bold');" />
  <input type="button" value="I" style="font-style: italic;" onclick="commande('italic');" />
  <input type="button" value="S" style="text-decoration: underline;" onclick="commande('underline');" /> 
  <input type="button" value="S" style="text-decoration: line-through;" onclick="commande('strikeThrough');" />

  <input type="button" value="--" style="text-decoration: line-through;" onclick="commande('insertHorizontalRule');" />
  <input type="button" value="RF" onclick="commande('removeFormat');" />


  <input type="button" value="F" onclick="commande('justifyFull');" />
  <input type="button" value="L" onclick="commande('justifyLeft');" />
  <input type="button" value="C" onclick="commande('justifyCenter');" />
  <input type="button" value="R" onclick="commande('justifyRight');" />

  <input type="button" value="undo" onclick="commande('undo');" /> 
  <input type="button" value="redo" onclick="commande('redo');" /> 
  <input type="button" value="delete" onclick="commande('delete');" />  

  <input type="button" value="A" style="font-size:1.1 em;" onclick="commande('decreaseFontSize');" />
  <input type="button" value="A" style="font-size:0.7em;" onclick="commande('increaseFontSize');" />

  <input type="button" value="x²" onclick="commande('superscript');" /> 
  <input type="button" value="x₂" onclick="commande('subscript');" /> 

  <input type="button" value="Liste" onclick="commande('insertOrderedList');" />

  <input type="button" value=">" onclick="commande('indent');" />
  <input type="button" value="<" onclick="commande('outdent');" />

  <input type="button" value="Lien" onclick="commande('createLink');" />
  <input type="button" value="unlink" style="text-decoration: ;" onclick="commande('unlink');" />  
  <input type="button" value="Image" onclick="commande('insertImage');" />

  <select onchange="commande('fontSize', this.value); this.selectedIndex = 0;">
    <option value="">FontSize</option>
    <option value="1px">10</option>
    <option value="2px">12</option>
    <option value="3px">14</option>
    <option value="4px">16</option>
    <option value="5px">18</option>
    <option value="6px">20</option>
    <option value="7px">22</option>
  </select>
  <select onchange="commande('heading', this.value); this.selectedIndex = 0;">
    <option value="">Titre</option>
    <option value="h1">Titre 1</option>
    <option value="h2">Titre 2</option>
    <option value="h3">Titre 3</option>
    <option value="h4">Titre 4</option>
    <option value="h5">Titre 5</option>
    <option value="h6">Titre 6</option>
  </select> 

  <input type="button" id="police" value="Police" style="border-radius:5px 0 0 5px; margin-right:-3px;" onclick="commande('foreColor', this.backColor);" />
  <input type="button" value=">" style="border-radius:0 5px 5px 0;" onclick="afficher_couleur('p');" />
    
  <input type="button" id="font" value="Font" style="border-radius:5px 0 0 5px; margin-right:-3px;" onclick="commande('backColor', this.backColor);" />
  <input type="button" value=">" style="border-radius:0 5px 5px 0;" onclick="afficher_couleur('f');" />
    
  </div>
  
  
<div class="couleur_edit">
        <?php
      $couleur = array('#E6B0AA', '#CD6155', '#C0392B', '#A93226', '#922B21', '#7B241C', '#641E16',
                       '#F5B7B1', '#EC7063', '#E74C3C', '#CB4335', '#B03A2E', '#943126', '#78281F',
                       '#D2B4DE', '#A569BD', '#8E44AD', '#7D3C98', '#6C3483', '#5B2C6F', '#4A235A',
                       '#A9CCE3', '#5499C7', '#2980B9', '#2471A3', '#1F618D', '#1A5276', '#154360',
                       '#AED6F1', '#5DADE2', '#3498DB', '#2E86C1', '#2874A6', '#21618C', '#1B4F72',
                       '#A3E4D7', '#48C9B0', '#1ABC9C', '#17A589', '#148F77', '#117864', '#0E6251',
                       '#A2D9CE', '#45B39D', '#16A085', '#138D75', '#117A65', '#0E6655', '#0B5345',
                       '#A9DFBF', '#52BE80', '#27AE60', '#229954', '#1E8449', '#196F3D', '#145A32',
                       '#ABEBC6', '#58D68D', '#2ECC71', '#28B463', '#239B56', '#1D8348', '#186A3B',
                       '#FFFF8D', '#FFEA00', '#FFD600', '#FDD835', '#FBC02D', '#F9A825', '#F57F17',
                       '#EDBB99', '#DC7633', '#D35400', '#BA4A00', '#A04000', '#873600', '#6E2C00',
                       '#CCD1D1', '#99A3A4', '#7F8C8D', '#707B7C', '#616A6B', '#515A5A', '#424949');
    ?>

    <div id="couleur_auto" onclick="changer_couleur('auto')">Couleur Automatique</div>
    <table style="border-top: 1px solid;"><?php
      for($i=0;$i<7;$i++){
       ?><tr><?php 
        for($j=0;$j<12;$j++){
          ?><td style="background-color: <?php echo $couleur[$j*7+$i]; ?>;" onclick="changer_couleur('<?php echo $couleur[$j*7+$i]; ?>')"></td><?php
        } 
      ?></tr><?php
      } ?>
    </table> 
    <div id="couleur_auto" style="border-top: 1px solid;">
      <table> 
        <td style="background-color: darkred;" onclick="changer_couleur('darkred')"></td>
        <td style="background-color: red;" onclick="changer_couleur('red')"></td>
        <td style="background-color: #4A235A;" onclick="changer_couleur('#4A235A')"></td>
        <td style="background-color: #2E86C1;" onclick="changer_couleur('#2E86C1')"></td>
        <td style="background-color: blue;" onclick="changer_couleur('blue')"></td>
        <td style="background-color: #154360;" onclick="changer_couleur('#154360')"></td>
        <td style="background-color: #239B56;" onclick="changer_couleur('#239B56')"></td>
        <td style="background-color: green;" onclick="changer_couleur('green')"></td>
        <td style="background-color: yellow;" onclick="changer_couleur('yellow')"></td>
        <td style="background-color: orange;" onclick="changer_couleur('orange')"></td>
        <td style="background-color: #D35400;" onclick="changer_couleur('#D35400')"></td>
        <td style="background-color: grey;" onclick="changer_couleur('grey')"></td>
      </table> 
    </div>
    <div id="couleur_auto">
      <table> 
        <td id="couleur_0" onclick="changer_couleur('couleur_recent[0]')"></td>
        <td id="couleur_1" onclick="changer_couleur('couleur_recent[1]')"></td>
        <td id="couleur_2" onclick="changer_couleur('couleur_recent[2]')"></td>
        <td id="couleur_3" onclick="changer_couleur('couleur_recent[3]')"></td>
        <td id="couleur_4" onclick="changer_couleur('couleur_recent[4]')"></td>
        <td id="couleur_5" onclick="changer_couleur('couleur_recent[5]')"></td>
        <td id="couleur_6" onclick="changer_couleur('couleur_recent[6]')"></td>
        <td id="couleur_7" onclick="changer_couleur('couleur_recent[7]')"></td>
        <td id="couleur_8" onclick="changer_couleur('couleur_recent[8]')"></td>
        <td id="couleur_9" onclick="changer_couleur('couleur_recent[9]')"></td>
        <td id="couleur_10" onclick="changer_couleur('couleur_recent[10]')"></td>
        <td id="couleur_11" onclick="changer_couleur('couleur_recent[11]')"></td>   
      </table> 
    </div>
  </div>
<div class="masquer_couleur_edit" onclick="afficher_couleur('');"></div>

<div id="espace_affichage" style="height:84%; top:15%;">
  <div id="text_editor" contentEditable><?php echo $contenu ?></div>
</div>

  <input hidden type="button" onclick="resultat();" value="Obtenir le HTML" />
  <textarea hidden id="resultat"></textarea>

</div>

<?php
} ?>


<script type="text/javascript">


  
  //////////////////////////////////////////////////////////////////////////////////
  
  
  function commande(nom, argument) {
  if (typeof argument === 'undefined') {
    argument = '';
  }
  switch (nom) {
    case "createLink":
      argument = prompt("Quelle est l'adresse du lien ?");
      break;
    case "insertImage":
      argument = prompt("Quelle est l'adresse de l'image ?");
      break;
  }
  // Exécuter la commande
  document.execCommand(nom, false, argument);
}

function resultat() {
  document.getElementById("resultat").value = document.getElementById("text_editor").innerHTML;
}
  ////////////////////////////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  
 var type
  function afficher_couleur(type){
    if(type!=''){
      this.type=type;
      $(".masquer_couleur_edit").css({'display': 'block' });
      $(".couleur_edit").css({'display': 'block' });
    }else{
      $(".masquer_couleur_edit").css({'display': 'none' });
      $(".couleur_edit").css({'display': 'none' });
    }
  }
  
var couleur_recent = new Array;
var n_couleur=0;
function changer_couleur(couleur)
  {
    if(couleur=='auto'){
      if(type=='p')
        couleur='black';
      else if(type=='f')
        couleur='white';
    }
    
    couleur_recent[n_couleur]=couleur;
    $("#couleur_"+n_couleur).css({'background-color': couleur });
    n_couleur++;
    if(n_couleur>11)
      n_couleur=0;
    
    if(type=='p'){
      $("#police").css({'background-color': couleur });
      document.getElementById("police").backColor = couleur;	
    }else if(type=='f'){
      $("#font").css({'background-color': couleur });
      document.getElementById("font").backColor = couleur;	
    }
    $(".masquer_couleur_edit").css({'display': 'none' });
    $(".couleur_edit").css({'display': 'none' });
  }

</script>