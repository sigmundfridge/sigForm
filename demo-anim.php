<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
 require_once("$root/template/head_top.php"); ?>

	<title>SigFrid | Nick Jones</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

<?php require_once("$root/template/scripts.php");?>
<script type="text/javascript" src="files/demo/js/sigForm.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="files/demo/css/sfbase.css">
	<script type="text/javascript">
	$(document).ready(function(){
		$('#demo_form').sigForm({
			ajaxHandler :'files/demo/control/ajaxValid.php',
			formHandler:'files/demo/control/mailForm.php',
			animate:true
		})
	})
	</script>
<?php require_once("$root/template/head_bot.php");?>

<?php require_once("$root/template/top-contact.php");?>
	<h2>SigForm Demonstration</h2>
	<p><a href = "index.php"><- Back</a></p>
	<p>Click the tab below to open the contact form.</p>
	<div id = "demo_form">
	</div>
	
<?php require_once("$root/template/bottom.php") ?>