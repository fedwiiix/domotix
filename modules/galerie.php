<div class="container_long" style="background-color:black; position:relative;" >
	
<?php
require ('../parametre/security.php');
$_SESSION["module"] = basename(__FILE__, '.php');
require ('../parametre/acces_module.php');
?>  

  <div id="img_galerie" align="center" style="position:absolute; height:100%; width:100%;">
  <?php
  $directory=$_SESSION["initial_directory"]."Image/Galerie";
    
  	$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
	  $j=0;
  foreach ($dir as $element) {   
		if($element != '.' && $element != '..') {
		if (!is_dir($directory.'/'.$element)) {	

		$extension = pathinfo($element, PATHINFO_EXTENSION);
		$file=$directory.'/'.$element;
		
      if($extension=="jpeg" || $extension=="jpg" || $extension=="gif" || $extension=="png" || $extension=="JPG" || $extension=="PNG"){  //***************************
        $j++;

        //$data = file_get_contents($file); 
        //echo '<img  id="img_galerie_'.$j.'" src="data:image/png;base64,'.base64_encode($data).'" style="display:none; opacity:0.1; height:100%; max-width:100%; vertical-align:center; margin:0;">';

       /* ?><img id="<?php echo 'img_galerie_'.$j ?>" src="<?php echo $file ?>" style="display:none; opacity:0.1; height:100%; max-width:100%; vertical-align:center; margin:0;"><?php */
      }
    }}
	} 
  ?>
  </div>
  <div id="fleche_galerie" onclick="img_precedente();" style="background-color:; position:absolute; left:0; top:0; height:100%; width:50%;"></div>
  <div id="fleche_galerie" onclick="img_suivante_opacity();" style="background-color:; position:absolute; right:0; top:0; height:100%; width:50%;"></div>

</div>

<script type="text/javascript">
	
  var nb_image, n_image = 1;
  $(document).ready(function() {
		nb_image = <?php echo $j ?>;
		n_image = Math.floor((Math.random() * nb_image) + 1); 
    $('#img_galerie_'+n_image).css('display', 'block');
    $('#img_galerie_'+n_image).css('opacity', '1');
  });

  auto_img();
  var s, ss;
  function auto_img() {

    date = new Date;
    s = date.getSeconds();
    if (s % 10 == 0 && s != ss) {
      img_suivante_opacity()
      ss = s;
    }
    setTimeout('auto_img();', '1000');
  }

  function img_suivante_opacity() {
    $('#img_galerie_' + n_image).animate({
      'opacity': '0.1'
    }, 1000);
    setTimeout(function() {
      $('#img_galerie_' + n_image).css('display', 'none');
      if (n_image == nb_image)
        n_image = 0;
      n_image++;
      $('#img_galerie_' + n_image).css('display', 'block');
      $('#img_galerie_' + n_image).animate({
        'opacity': '1'
      }, 1000);
    }, 300);
  }
  function img_precedente() {
    $('#img_galerie_' + n_image).animate({
      'opacity': '0.1'
    }, 1000);
    setTimeout(function() {
      $('#img_galerie_' + n_image).css('display', 'none');
      n_image--;
      if (n_image == 0)
        n_image = nb_image;
      $('#img_galerie_' + n_image).css('display', 'block');
      $('#img_galerie_' + n_image).animate({
        'opacity': '1'
      }, 1000);
    }, 300);
  }

</script>