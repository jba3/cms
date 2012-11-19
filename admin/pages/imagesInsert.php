<?php
	$pageheader = "cms_pageImages BASE INSERT INTO DB - from images in folder";
	require "includes/header.inc.php";

	mysql_connect($application_dbserver, $application_dbuser, $application_dbpass) or die(mysql_error());
	mysql_select_db($application_dbname) or die(mysql_error());
	$qryPath = mysql_query("select groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]) or die(mysql_error());

	$dir = "../content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/images/";
	$countAddedImages = 0;

	echo '<p align="center">Adding images for pageID=' . $_GET["pageID"] . ' from &quot;' . $dir . "&quot;...</p>";

	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if (filetype($dir . $file) == 'file'){
				// check for DB entry
				$qryCheckDB = mysql_query("select imageID from cms_pageImages where pageID=" . $_GET["pageID"] . " and filename='" . $file . "'");

				// add if not found
				if (empty($qryCheckDB) || mysql_num_rows($qryCheckDB) == 0){
					mysql_query("
						insert into cms_pageImages(
							filesize,
							filename,
							imagedtsadd,
							pageID
						)values(
							" . filesize($dir . $file) . ",
							'" . $file . "',
							CURDATE(),
							" . $_GET["pageID"] . "
						)
					");

					$countAddedImages += 1;

					echo "Added: $file<br/>";
				}
			}
		}
		closedir($dh);
	}

	echo '<p align="center">' . $countAddedImages . ' images added.</p>';

	mysql_close();

	require "includes/footer.inc.php";
?>
