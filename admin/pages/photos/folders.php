<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);
	dbClose();

	$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";

	mkdir($dirBase . "large/") or die('Cannot find the right path to make the LARGE folder');
	mkdir($dirBase . "thumb/") or die('Cannot find the right path to make the THUMB folder');

	chmod($dirBase . "large/", 0777) or die('Cannot find the right path to set priviledges on the LARGE folder');
	chmod($dirBase . "thumb/", 0777) or die('Cannot find the right path to set priviledges on the THUMB folder');


	header('Location: /admin/pages/photos/index.php?pageID=' . $_GET["pageID"] . '&msgType=info&msg=LARGE and THUMB folders successfully created');
?>
