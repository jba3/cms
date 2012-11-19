<html>
<head>
	<title>Website Admin</title>
	<!-- jQuery core -->
	<script type="text/javascript" src="/admin/jscripts/jquery.js"></script>
	<!-- jQuery UI -->
	<script type="text/javascript" src="/admin/jscripts/jquery-ui-1.8.18.custom.min.js"></script>
	<link rel="stylesheet" href="/admin/css/jquery-ui-1.8.18.custom.css" type="text/css" />
	<!-- jQuery wysiwyg -->
	<script type="text/javascript" src="/admin/jscripts/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="/admin/jscripts/jquery.wysiwyg.table.js"></script>
	<script type="text/javascript" src="/admin/jscripts/jquery.wysiwyg.image.js"></script>
	<script type="text/javascript" src="/admin/jscripts/jquery.wysiwyg.link.js"></script>
	<link rel="stylesheet" href="/admin/css/jquery.wysiwyg.css" type="text/css" />
	<!-- bValidator plugin -->
	<script type="text/javascript" src="/admin/jscripts/jquery.bvalidator.js"></script>
	<link rel="stylesheet" href="/admin/css/bvalidator.css" type="text/css" />
	<link rel="stylesheet" href="/admin/css/bvalidator.theme.gray2.css" type="text/css" />
	<!-- global generic css/js -->
	<link rel="stylesheet" href="/admin/css/style.css">
	<script type="text/javascript" src="/admin/jscripts/admin.js"></script>
	<script>
		$(function() {
			$( "#btnLogin" ).button();
			$( "#btnLogin" ).click(function() { $("#frmLogin").submit(); });
		});
	</script>
</head>

<body>

<?php
	if (isset($_GET["failed"])){
		echo '<p align="center"><strong><em>INVALID USERNAME AND/OR PASSWORD</em></strong></p><hr>';
	}elseif (isset($_GET["expired"])){
		echo '<p align="center"><strong><em>YOUR LOGIN AUTHENTICATION HAS EXPIRED. PLEASE LOG IN AGAIN.</em></strong></p><hr>';
	}elseif (isset($_GET["logout"])){
		echo '<p align="center"><strong><em>YOU HAVE BEEN LOGGED OUT.</em></strong></p><hr>';
	}

	echo '<form action="/admin/auth/login-submit.php" method="post" id="frmLogin">';
	echo '	<p align="center">';
	echo '		Username:<input type="text" name="username" size="16" maxlength="16"><br/>';
	echo '		Password:<input type="password" name="password" size="16" maxlength="16"><br/>';
	echo '		<br/>';
	echo '		<button id="btnLogin">Log In</button>';
	echo '	</p>';
	echo '</form>';
?>

</body>
</html>
