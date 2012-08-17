<html>
<head>
	<title>SigFrid | Nick Jones</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" src="js/sigForm.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/sfbase.css">

<script type="text/javascript">
	$(document).ready(function(){
		$('#demo_form').sigForm({
			ajaxHandler :'control/ajaxValid.php',
			formHandler:'control/mailForm.php'	
		})
	})
</script>
</head>
<body>
	<h2>SigForm Demo</h2>
	<div id = "demo_form">
	</div>
</body>
</html>