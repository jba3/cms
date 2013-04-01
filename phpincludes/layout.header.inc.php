<!doctype html>
 
<html lang="en">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title><?php echo $siteTitle ?></title>
	<!-- core css/jscripts for all sites -->
	<script type="text/javascript" src="/jscripts/core.js"></script>
	<link rel="stylesheet" href="/css/core.css">

	<!-- jQuery library -->
	<?php
		if (!strpos($_SERVER['SERVER_NAME'], '.local') == true){// PRODUCTION
			// CDN jquery, for production
			echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />';
			echo '<script src="http://code.jquery.com/jquery-1.8.3.js"></script>';
			echo '<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>';
		}else{// LOCAL
			echo '<link rel="stylesheet" href="/css/jquery-ui-1.9.2.custom.css">';
			echo '<script type="text/javascript" src="/jscripts/jquery-1.8.3.js"></script>';
			echo '<script type="text/javascript" src="/jscripts/jquery-ui-1.9.2.custom.min.js"></script>';
		}
	?>

	<!-- fancybox - jQuery plugin - for inline image zooming -->
	<script type="text/javascript" src="/jscripts//jquery.fancybox-1.3.4.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/jquery.fancybox-1.3.4.css" media="screen" /></head>

	<style>
		/* Demo styles */
		.content{color:#777;font:12px/1.4 "helvetica neue",arial,sans-serif;width:620px;margin:20px auto;}
		.cred{margin-top:20px;font-size:11px;}

		/* This rule is read by Galleria to define the gallery height: */
		#galleria{height:320px}
	</style>

	<!-- load Galleria -->
	<script src="/jscripts/galleria-1.2.9.min.js"></script>

	<!-- site specific -->
	<?php
		if ($siteCSS == 'true'){
			echo '<link rel="stylesheet" href="/custom/css/style.css">';
		}
	?>
<body>

<?php
	if (!strpos($_SERVER['SERVER_NAME'], '.local') == true){// PRODUCTION
		echo '<div id="fb-root"></div>';
		echo '<script>';
		echo '	(function(d, s, id) {';
		echo '		var js, fjs = d.getElementsByTagName(s)[0];';
		echo '		if (d.getElementById(id)) return;';
		echo '		js = d.createElement(s); js.id = id;';
		echo '		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";';
		echo '		fjs.parentNode.insertBefore(js, fjs);';
		echo "	}(document, 'script', 'facebook-jssdk'));";
		echo '</script>';
	}

	require $_SERVER["DOCUMENT_ROOT"] . "/custom/layout.header.inc.php";
?>
