<?php
require ('../../parametre/security.php');
?>
		<!-- The main CSS file -->
		<link href="assets/css/style.css" rel="stylesheet" />
		<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
			<div id="drop">
				Drop Here
				<a>Browse</a>
				<input type="file" name="upl" multiple />
			</div>
			<ul>
				<!-- The file uploads will be shown here -->
			</ul>
		</form>
        
		<!-- JavaScript Includes -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="assets/js/jquery.ui.widget.js"></script>
		<script src="assets/js/jquery.iframe-transport.js"></script>
		<script src="assets/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="assets/js/script.js"></script>
