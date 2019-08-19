<?php 
require ('../parametre/security.php');
$_SESSION["page"] = basename(__FILE__, '.php');
require ('../parametre/acces_page.php');

$initial_directory = $_SESSION['cloudDir'];
$cloudTrashDir = $_SESSION['cloudTrashDir'];
$cloudInitDir = $_SESSION['cloudInitDir']; ?>

		<div id="cloud_music_lecteur"></div>
		<div id="cloud_affichage" align="center"></div>

<!-- ********************************************************* dedut menu *********************************************************************************************************** -->

		<div id="volet" align="center" oncontextmenu="return monmenu(this,'')">
      <li class="mv-item"><a onclick="afficher_dossier('<?php echo urlencode($cloudInitDir); ?>',1)" ><?php echo $cloudInitDir; ?></a></li> 
			<?php 
			$directory= $initial_directory;
			$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
			foreach ($dir as $element) {   
				if($element != '.' && $element != '..' && $element[0] != '.') {
					if (is_dir($directory.'/'.$element)) {
						if( $element!=$cloudInitDir && $element!=$cloudTrashDir ){
							?><li class="mv-item"><a onclick="afficher_dossier('<?php echo urlencode($element); ?>',1)"><?php echo $element ?></a></li><?php
						}
					}
				}		
			}
			?>
		  <li class="mv-item"><a onclick="afficher_dossier('<?php echo urlencode($cloudTrashDir); ?>',1)" ><?php echo $cloudTrashDir; ?></a></li> 
		  <li class="mv-item"><a onclick="afficher_upload()" >Upload</a></li> 
      
      <label class="switch">
        <input id="displayMode" type="checkbox" hidden onclick="cloudDisplayMode()" <?php if($_SESSION["displayMode"]=="true"){ echo "checked"; } ?>>
        <span class="slider"></span>
      </label>
			
			<div id="cloud_icon" style="width:35%; margin-top:0px; margin-left:-50%;">
				<img id="cloud_music_lecteur_icon" class="app_menu" src="img/menu/musique.png" onclick="reduire_music_lecteur();" style="width:50px;"/>
				<img id="cloud_affichage_icon" class="app_menu" src="img/menu/fichier.png" onclick="reduire_cloud_affichage();" style="width:50px; margin-top:10px;"/>
        
			</div>
			
		  <input type="search" id="recherche" placeholder="Search" ></input>
		</div>
	

<!-- ************************************************************** fin menu ****************************************************************************************************** -->

<div class="big-container"><?php require ('cloud_liste.php'); ?></div>

	
<!-- ******************************************************************************************************************************************************************** -->

<script type="text/javascript">


/////////////////////////////////////////////////////////////////////////////////////////// cloud ///////////////////////////////////////////////////////////

var formats_cloud_editeur = new Array("txt", "html", "php", "css", "js","py","sh");

var initial_directory ="<?php echo $initial_directory ?>";
var actif_dir ="<?php echo $cloudInitDir ?>";
var trashDir = "<?php echo $cloudTrashDir ?>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

clickDetect=0;
function afficher_dossier(link,force){
  if(link==undefined){
    clickDetect=1
    setTimeout(function() { clickDetect=0; }, 150);
  }else if(clickDetect || force){
    window.stop() // reset of navigator download
    actif_dir = link;	
    $(".big-container").load("cloud/cloud_liste.php?dossier="+encodeURIComponent(link));
    reduire_cloud_affichage(1)	
  }
}

function afficher_fichier(link){

  if(link==undefined){
    clickDetect=1
    setTimeout(function() { clickDetect=0; }, 150);
  }else if(clickDetect){
    window.stop() // reset of navigator download
    link=actif_dir+"/"+link
    if(link.indexOf(".mp3")!=-1 || link.indexOf(".m4a")!=-1 || link.indexOf(".MP3")!=-1 ){
      link = caracteres_special(link);
      $("#cloud_music_lecteur").load("cloud/cloud_affichage.php?file="+encodeURIComponent(link)+'&music=true');	
      $("[id=cloud_music_lecteur_icon]").css('display', 'block');
      $("#cloud_music_lecteur").css('display', 'block');
    } else {
      $('#cloud_affichage').css('display', 'block');
      $("#cloud_affichage").load("cloud/cloud_affichage.php?file="+encodeURIComponent(link));	
      $("[id=cloud_affichage_icon]").css('display', 'block');	
    }
  }
}

function cloud_editer(link){
	$("#cloud_affichage").css('display', 'block');
	$("#cloud_affichage").load("cloud/cloud_editer.php?file="+encodeURIComponent(link));
}

function seach(cloud_recherche){
	$(".big-container").load("cloud/cloud_liste.php?dossier="+encodeURIComponent(actif_dir)+"&recherche="+encodeURIComponent(cloud_recherche));
}

/**************************************** affichage  ************************************************************/
function quitter_music_lecteur(){
window.stop() // reset of navigator download
$("#cloud_music_lecteur").html('');
$("[id=cloud_music_lecteur_icon]").css('display', 'none');
}

function reduire_music_lecteur(){
if($('#cloud_music_lecteur').css('display') == 'none')
	{	
		$("#cloud_music_lecteur").css('display', 'block');
	} else {	
		$("#cloud_music_lecteur").css('display', 'none');	
	}
}
function reduire_cloud_affichage(n){
	if($('#cloud_affichage').css('display') == 'none' && !n)
	{	
		$("#cloud_affichage").css('display', 'block');	
	} else {	
		$("#cloud_affichage").css('display', 'none');	
	}
}
function quitter_cloud_affichage(){
  window.stop() // reset of navigator download
	$("#cloud_affichage").html('');	
	$("#cloud_affichage").css('display', 'none');	
	$("[id=cloud_affichage_icon]").css('display', 'none');
}
function afficher_upload(){
	if($('#quitter_upload').css('display') == 'none'){
		$('#quitter_upload').css('display', 'block');		
		$('#fileupload').css('display', 'block');
	} else {
		$('#quitter_upload').css('display', 'none');
		$('#fileupload').css('display', 'none');
    $(".big-container").load("cloud/cloud_liste.php?dossier="+encodeURIComponent(actif_dir));
	}
}

function cloudDisplayMode(){
  $(".big-container").load("cloud/cloud_liste.php?dossier="+encodeURIComponent(actif_dir)+"&displayMode="+$('#displayMode').is(":checked"));
  if( $('#case_dir').css('width')=='155px'){
    $('[id=case_dir]').css('width','48%')
    $('[id=case_file]').attr('id','case_file_allonger')
    $('[id=titre_case]').attr('width','auto')
  }else{
    $('[id=case_dir]').css('width','155px')
    $('[id=case_file_allonger]').attr('id','case_file')
    $('[id=titre_case]').attr('width','145px')
  }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//*******************************************************************************************************   recherche

$( "#recherche" ).mouseover(function() {
  $("#recherche").animate({'border-radius':'10%','width':'80%'},200);
});
$( "#recherche" ).mouseleave(function() {
	if($("#recherche").val()==''){
    setTimeout(function() {
      $("#recherche").stop().animate({'width':'32px','border-radius':'80%'},500);
    }, 1000);
	}
});
$("#recherche").keydown(function() { seach($("#recherche").val());  });
$("#recherche").keyup(function() {
        seach($("#recherche").val()); 
	if($("#recherche").val()==''){
    setTimeout(function() {
        $("#recherche").stop().animate({'width':'32px','border-radius':'80%'},500);
    }, 1000);
	}	
});

  
  
</script>
<?php if( $_SESSION['droit']>=2 ){   // if user right is good  ?> 
<script>  
//*******************************************************************************************************   menu

function sauvegarder_cloud(link,ext){

	if(ext=='html'){
		text = $("#text_editor").html();
	}else{
		text = $("#text_editor").val();
	}
	
	link=(link)
	text=(text)

	$.ajax({
			type: "POST",
			url: "./cloud/cloud_action.php",
			dataType: "json",
			data: {action: 'sauvegarder_cloud_editer' , link, text },
			"success": function(response){ $("#save_result").html(response.result); },
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
	});
	setTimeout(function() {	$("#save_result").html("");	}, 1000);
}


function cloud_action(act, file1, file2, overwrite ){

	//file1=encodeURIComponent(file1)	// gerer les injections
	//file2=encodeURIComponent(file2)

	$.ajax({
			type: "POST",
			url: "./cloud/cloud_action.php",
			dataType: "json",
			data: {action: act , file1, file2,overwrite },
			"success": function(response){  

        if(response.result=="412"){
          ConfirmBox('Le fichier existe, voulez-vous le remplacer ?', function() {
              cloud_action(act, file1, file2,'T' )
          })
          afficher_dossier(actif_dir,1);
        }else if(response.result=="409"){
          afficherMessage("ce nom est déjà utilisé");
          afficher_dossier(actif_dir,1);
        }else{
          afficherMessage(response.result);
          setTimeout(function() { afficher_dossier(actif_dir,1); }, 100);
          setTimeout(function() { afficher_dossier(actif_dir,1); }, 1000);			
        }
			},
			"error": function(jqXHR, textStatus){ alert('Request failed: ' + textStatus); }
	});
}

//*******************************************************************************************************   menu

var move_file="", move_link, move_action;

$(function() {
 var x = document.getElementById('ctxmenu1');
  if(x) x.parentNode.removeChild(x); 
});

var xMousePosition = 0;
var yMousePosition = 0;
document.onmousemove = function(e)
{
	xMousePosition = e.clientX + window.pageXOffset;
 	yMousePosition = e.clientY + window.pageYOffset;  
};
 
function monmenu(element,file)
{	
	
file=urldecode(file)
actif_dir=urldecode(actif_dir)

link=actif_dir+'/'+file
link_file= actif_dir

  var re = /(?:\.([^.]+))?$/;
  var extention = re.exec(file)[1]; 

  var x = document.getElementById('ctxmenu1');
  if(x) x.parentNode.removeChild(x);
  
  var d = document.createElement('div');
  d.setAttribute('class', 'ctxmenu');
  d.setAttribute('id', 'ctxmenu1');
  element.parentNode.appendChild(d);
  
  var xclass = 0;
  var yclass = 0;
	if(file!=''){
		xclass = $('.big-container').offset().left;
		yclass = $('.big-container').scrollTop();
	}
	d.style.left = xMousePosition - xclass + "px";
  d.style.top = yMousePosition + yclass  + "px"; 
  d.onmouseover = function(e) { this.style.cursor = 'pointer'; } 
  d.onclick = function(e) { element.parentNode.removeChild(d);  }
  document.body.onclick = function(e) { element.parentNode.removeChild(d);  }

  for(var i in formats_cloud_editeur)
  {
    if(formats_cloud_editeur[i]==extention)
      {
      var p = document.createElement('p');
      d.appendChild(p);
      p.onclick=function() { cloud_editer(link) };  
      p.setAttribute('class', 'ctxline');
      p.innerHTML = "Editer";
    }
  }
	if(extention=="zip")
	{
		var p = document.createElement('p');
		d.appendChild(p);
		p.onclick=function() { 
			
			cloud_action( 'dezipper', link, link_file)
		 };  
		p.setAttribute('class', 'ctxline');
		p.innerHTML = "Extraire ici";
	}  
  if(file!='' && file!='titre'){
    var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { move_file = file; move_link = link; move_action="copier" };
    p.setAttribute('class', 'ctxline');
    p.innerHTML = "Copier";

		var p = document.createElement('p');
		d.appendChild(p);
		p.onclick=function() { move_file = file; move_link = link; move_action="deplacer" };
		p.setAttribute('class', 'ctxline');
		p.innerHTML = "Couper";
  }
  if(move_file!=''){         
    var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { 

			link_file+="/"+move_file
			cloud_action( move_action, move_link, link_file )
		 };
    p.setAttribute('class', 'ctxline');
    p.innerHTML = "Coller";
  }
	if(file!='' && file!='titre'){
    var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { 
		PromptBox("Nouveau Nom:",file, function() {  
			var fichier = cleanHTML($('.PromptBox').val())
			new_link_file = link_file+'/'+fichier
			if(fichier)
				cloud_action('copier', link, new_link_file )
		})
	};
    p.setAttribute('class', 'ctxline');
    p.innerHTML = "Cloner";
  
    var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { 
		PromptBox("Nouveau Nom:",file, function() {  
			var fichier = cleanHTML($('.PromptBox').val())
			new_link_file = link_file+'/'+fichier
			if(fichier)
				cloud_action('renommer', link, new_link_file )
		})
	};
    p.setAttribute('class', 'ctxline');
    p.innerHTML = "Renommer";
   
    var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { 
			ConfirmBox('Ete vous sûre de vouloir supprimer ce fichier', function() {
				corbeille = trashDir+'/'+file
				cloud_action('deplacer', link, corbeille, 'T' )
			})
		 };  
    p.setAttribute('class', 'ctxline');
    p.innerHTML = "Supprimer"; 

		var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { };  
    p.setAttribute('class', 'ctxline');
    var lien = "cloud/cloud_action.php?action=cloud_download&file="+encodeURI(link_file)+"&file_name="+encodeURI(file);
    p.innerHTML = "<a href="+lien+" target='blank' style='text-decoration:none;'>Download</a>";
	}
		if( actif_dir == "Corbeille" ){
			var p = document.createElement('p');
			d.appendChild(p);
			p.onclick=function() {
				ConfirmBox('Ete vous sûre de vouloir vider la corbeille', function() {
					cloud_action('vider_la_corbeille' )
				})
			 };  
			p.setAttribute('class', 'ctxline');
			p.innerHTML = "Vider la Corbeille";
		}
	
    var p = document.createElement('p');
    d.appendChild(p);
    p.onclick=function() { 
		PromptBox("Nouveau fichier:",'', function() {  
			var fichier = cleanHTML($('.PromptBox').val())
			link_file = link_file+'/'+fichier
			if(fichier)
				cloud_action('nouveau', link_file )
		})
	};  
    p.setAttribute('class', 'ctxline');
    p.innerHTML = "Nouveau";

 
  return false;
}


function urldecode (str) {
  return decodeURIComponent((str + '').replace(/\+/g, '%20'));
}

</script>
<?php } ?>