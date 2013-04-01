<?php
	include_once $_SERVER["DOCUMENT_ROOT"] . "/custom/settings.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/phpincludes/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/security-check.php";

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_POST["pageID"]);

		$dirBase = $_SERVER["DOCUMENT_ROOT"] . "/content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";

		foreach($_POST["deleteList"] as $key=>$value){
			$qryPhoto = mysql_fetch_assoc(dbSelect("imageFilename from cms_pagePhotos where photoID=" . $value));	// get the filename

			unlink($dirBase . "large/" . $qryPhoto["imageFilename"]);	// delete large
			unlink($dirBase . "thumb/" . $qryPhoto["imageFilename"]);	// delete thumb

			dbDelete('cms_pagePhotos where photoID=' . $value);	// delete DB entry
		}
	dbClose();

	header('Location: /admin/pages/photos/delete.php?pageID=' . $_POST['pageID'] . '&msgType=info&msg=File(s) ' . $imageFileName . ' deleted, at ' . now());
?>
