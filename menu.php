<?php require ('parametre/security.php'); ?>

<div class="menu">			<!-- menu de gauche -->
	<?php 
	$droit = $_SESSION['droit'];
	$pages = $_SESSION['droit_page'];
	foreach ($pages as $page) { 
		if( $droit >= $page['utilisateur'] && $page['utilisateur']!=0 ){						//droit pour afficher les pages ou pas 
		?><img onclick="lancer_onglet('<?php echo $page['nom']; ?>')" title="<?php $f = preg_replace("#_#", " ", $page['nom']); echo $f; ?>" class="app_menu" src="<?php echo 'img/menu/'.$page['nom'].'.png'; ?>" /><?php 
		}
	}	?><br>
</div>

<bb id="bp_volet" ondblclick="" onclick="openVolet()"></bb>

<div class="menu_mobile">			<!-- phone menu, add modules -->
	<?php 
	$droit = $_SESSION['droit'];
	$pages = $_SESSION['droit_page'];
	$modules=$_SESSION['droit_module'];

	foreach ($modules as $module) { 
		if (file_exists('img/module/'.$module['nom_module'].'.png')){
			if( $droit >= $module['utilisateur_module'] && $module['utilisateur_module']!=0 ){						//droit pour afficher les pages ou pas 
				?><img onclick="lancer_modules('<?php echo $module['nom_module']; ?>')" title="<?php $f = preg_replace("#_#", " ", $module['nom_module']); echo $f; ?>" class="app_menu" src="<?php echo 'img/module/'.$module['nom_module'].'.png'; ?>" /><?php 
			}
		}
	}	
	foreach ($pages as $page) { 
		if( $droit >= $page['utilisateur'] && $page['utilisateur']!=0 && $page['nom']!='home' && $page['nom']!='modules' ){						//droit pour afficher les pages ou pas 
			?><img onclick="lancer_onglet('<?php echo $page['nom']; ?>')" title="<?php $f = preg_replace("#_#", " ", $page['nom']); echo $f; ?>" class="app_menu" src="<?php echo 'img/menu/'.$page['nom'].'.png'; ?>" /><?php 
		}
	}	
	?>
</div>

<script>
//////////////////////////////////////////////////////////////////////////////////////// js /////////////////////////////////////////////////

$( document ).ready(function() {

    $(".menu").animate({"left": "0px"},500);    // first launch
	  lancer_onglet("home")

  if( screen.width <= 800 ) {                   // phone menu event swiper
  
    $('body').on('touchstart', function(e) {
        $(this).data('p0', { x: e.originalEvent.touches[0].pageX, y: e.originalEvent.touches[0].pageY });
    }).on('touchend', function(e) {
        var p0 = $(this).data('p0'),
            p1 = { x: e.originalEvent.changedTouches[0].pageX, y: e.originalEvent.changedTouches[0].pageY },
            //d = Math.sqrt(Math.pow(p1.x - p0.x, 2) + Math.pow(p1.y - p0.y, 2));
            testSwipe = p0.x - p1.x

        if (testSwipe > 150) {                              // swipeleft
          if ($('#volet').length)
              $("#volet").animate(  {'left': '-80%'},500);
        }else if (testSwipe < -150) {                      // swiperight
          if ($('#volet').length) 
              $("#volet").animate(  {'left': '0%'},500);

              $('li').click(function() {                  // auto return menu
                if ($('#volet').length) 
                  $("#volet").animate(  {'left': '-80%'},500);
              });
        }
    })
  }

});

/********************************************************************************************************************/// modules and tab
  
  dj=0
  musicPlayer=0
	function lancer_onglet(onglet,sous_onglet){
		if(sous_onglet){
      $("#centre").load("pages/"+onglet+'.php?sous_onglet='+sous_onglet);
		}else	if(onglet=='dj'){
          if(!dj){
            dj++
            $("#centre").html("");
            $("#centre_dj").load("pages/"+onglet+'.php');
          }
          $("#centre_dj").css('display', 'block');
          $("#centre_musicPlayer").css('display', 'none');	
          $("#centre").css('display', 'none');	
      
			}else	if(onglet=='musicPlayer'){
          if(!musicPlayer){
            musicPlayer++
            $("#centre").html("");
            $("#centre_musicPlayer").load("pages/"+onglet+'.php');
          }
          $("#centre_musicPlayer").css('display', 'block');
          $("#centre_dj").css('display', 'none');	
          $("#centre").css('display', 'none');	
				
			}else{
				$("#centre").load("pages/"+onglet+'.php');	
        $("#centre").css('display', 'block');	
				$("#centre_dj").css('display', 'none');	
				$("#centre_musicPlayer").css('display', 'none');	
			}
	}
  function afficherOngletPpage(page, onglet){
    $(".big-container").load("pages/"+page+".php?onglet="+onglet);	
  }
  function lancer_modules(onglet){
		$("#centre").load("pages/"+'displayModule.php?onglet='+onglet);
	}
	
menu=0;  
function openVolet(){
	if(!menu){
		$("[id=volet]").animate(  {"left": "10%"},100);
		$(".quitter_volet").animate(  {"opacity": "0"},1000);	
		setTimeout(function() { $(".quitter_volet").css('display', 'none'); }, 1000);
    menu=1
	}else{
		$("[id=volet]").animate(  {"left": "-80%"},100);	
		$(".quitter_volet").css('display', 'block');
		$(".quitter_volet").animate(  {"opacity": "0.3"},1000);	
    menu=0
	}
}
	
/********************************************************************************************************************/
  
var timeout1, timeout2
function afficherMessage(message){    // message
	if(message){
    
    $('.message').clearQueue().finish();
    clearTimeout(timeout1);
    clearTimeout(timeout2);
		$('.message').text(message);
		$(".message").animate(  {'top': '0px'},500);
    timeout1 = setTimeout("$('.message').animate(  {'top': '-200px'},400);",'2000');
		timeout2 = setTimeout("$('.message').text(''); $('.message').css('top', '-70px');",'2400');
	}
}

function ConfirmBox(message, yesCallback, noCallback) { // confirmBox
  $('.message').html(message);
	$('.message').append( "<br><button id='btnYes'>Oui</button>&nbsp;&nbsp;&nbsp;&nbsp;<button id='btnNo'>Non</button>" )
	$(".message").animate(  {'top': '0px'},00);
    var dialog = $('#modal_dialog').dialog();
	$('#btnYes').focus()

    $('#btnYes').click(function() {
        dialog.dialog('close');
        yesCallback();
		  $('.message').animate(  {'top': '-200px'},40);
		  $('.message').text(''); 
		  $('.message').css('top', '-70px');
    });
    $('#btnNo').click(function() {
		  $('.message').animate(  {'top': '-200px'},400);
		  setTimeout("$('.message').text(''); $('.message').css('top', '-70px');",'400');
    });
	
}
function PromptBox(message,value, yesCallback) {  // PromptBox
    $('.message').html(message);
	$('.message').append( "<br><input id='PromptBox' class='PromptBox' type='text' onkeypress='if (event.keyCode==13) PromptBoxValid();'>" )
	$('.message').append( "<br><button id='btnYes'>Valider</button>&nbsp;&nbsp;&nbsp;&nbsp;<button id='btnNo'>Annuler</button>" )
	$(".message").animate(  {'top': '0px'},00);
    var dialog = $('#modal_dialog').dialog();
	$('#PromptBox').focus().val("").val(value);

    $('#btnYes').click(function() {
        dialog.dialog('close');
        yesCallback();
		  $('.message').animate(  {'top': '-200px'},40);
		  $('.message').css('top', '-70px');
    });
    $('#btnNo').click(function() {
		  $('.message').animate(  {'top': '-200px'},400);
		  setTimeout("$('.message').text(''); $('.message').css('top', '-70px');",'400');
    });
}
function PromptBoxValid(){
	$('#btnYes').click()
}

/********************************************************************************************************************/

function cleanHTML(input) {                   // remove html entities
  // 1. remove line breaks / Mso classes
  var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g; 
  var output = input.replace(stringStripper, ' ');
  // 2. strip Word generated HTML comments
  var commentSripper = new RegExp('<!--(.*?)-->','g');
  var output = output.replace(commentSripper, '');
  //var tagStripper = new RegExp('<(/)*(strong|html|body|div|object|img|ol|ol|li|ul|fieldset|form||tfoot|thead|th|td|menu|output|audio|video|pre|t|code|meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
  var tagStripper = new RegExp('<(/)*>','gi');
  // 3. remove tags leave content if any
  output = output.replace(tagStripper, '');
  // 4. Remove everything in between and including tags '<style(.)style(.)>'
  var badTags = ['style', 'script','applet','embed','noframes','noscript'];
  
  for (var i=0; i< badTags.length; i++) {
    tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
    output = output.replace(tagStripper, '');
  }
  // 5. remove attributes ' style="..."'
  var badAttributes = ['style', 'start'];
  for (var i=0; i< badAttributes.length; i++) {
    var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
    output = output.replace(attributeStripper, '');
  }
  return output;
}

  
  
</script>
