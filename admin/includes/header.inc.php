<?php
	/* include once to prevent function re-declaration errors if settings/functions file is included twice in SUBMIT pages */
	include_once $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/security-check.php";
?>



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
</head>

<body>

<div id="divMenubar">
	<button id="btnMenuHome">Home</button>
	<button id="btnMenuSite">Site Content</button>
	<button id="btnMenuComments">All Pending Comments</button>
	<?php
		if (strpos($_SERVER['SERVER_NAME'], 'james-anderson-iii') == false){
			echo '<button id="btnMenuArmory">Armory Admin</button>';
		}
	?>
	<button id="btnMenuReports">Reports</button>
	<button id="btnMenuLogout">Log Out</button>
</div>

<h1><?php echo $pageheader ?></h1>

<?php
	// --------------------------------------------------------------------------------
	// --------------------------------------------------------------------------------
	// global message handler based off URL variables
	// --------------------------------------------------------------------------------
	// --------------------------------------------------------------------------------
	if (isset($_GET['msgType']) && isset($_GET['msg'])){
		echo '<div style="width:400px;margin:0 auto;">';
		if ($_GET['msgType'] == 'info'){
			echo dspMsgInfo($_GET['msg']);
		}else if ($_GET['msgType'] == 'warning'){
			echo dspMsgWarning($_GET['msg']);
		}
		echo '</div>';
	}
?>

<div id="divContentAdmin">
