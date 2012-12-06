<!doctype html>
<html>
<head>
	<title><?php echo $siteTitle ?></title>
	<!-- jQuery library -->
	<script type="text/javascript" src="/jscripts/jquery-1.8.3.js"></script>
	<!-- jQueryUI library -->
	<link rel="stylesheet" href="/css/jquery-ui-1.9.2.custom.css">
	<script type="text/javascript" src="/jscripts/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="/jscripts/jquery.tools.min.js"></script>
	<!-- jQuery no-conflict -->
	<script type="text/javascript">
		jQuery.noConflict();
	</script>

	<!-- photo gallery needs these -->
	<script type="text/javascript" src="/jscripts/prototype.js"></script>
	<script type="text/javascript" src="/jscripts/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="/jscripts/lightbox.js"></script>
	<link rel="stylesheet" href="/css/lightbox.css" type="text/css" media="screen" />

	<!-- core css/jscripts for all sites -->
	<script type="text/javascript" src="/jscripts/core.js"></script>
	<link rel="stylesheet" href="/css/core.css">

	<!-- site specific -->
	<?php
		if ($siteCSS == 'true'){
			echo '<link rel="stylesheet" href="/custom/css/style.css">';
		}
	?>
</head>

<body>

<div id="fb-root"></div>
<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/layout.header.inc.php";
?>
