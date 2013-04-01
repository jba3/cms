<?php
	$pageheader = "Delete Page";
	require "../includes/header.inc.php";

	dbOpen();
		$qryPath = dbSelect("groupFolder,sectionFolder,pageFolder from `cms_groups` g join `cms_sections` s on g.groupid=s.groupid join `cms_pages` p on s.sectionid=p.sectionid where pageID=" . $_GET["pageID"]);

		dbDelete("cms_pageComments  where pageID=" . $_GET["pageID"]);
		dbDelete("cms_pageDownloads  where pageID=" . $_GET["pageID"]);
		dbDelete("cms_pageHits  where pageID=" . $_GET["pageID"]);
		dbDelete("cms_pageImages  where pageID=" . $_GET["pageID"]);
		dbDelete("cms_pagePhotos  where pageID=" . $_GET["pageID"]);
		dbDelete("cms_pages  where pageID=" . $_GET["pageID"]);
	dbClose();



	$dirBase = "../../content/" . mysql_result($qryPath, 0, 0) . "/" . mysql_result($qryPath, 0, 1) . "/" . mysql_result($qryPath, 0, 2) . "/";
	$dirDownloads = $dirBase . "downloads/";
	$dirImages = $dirBase . "images/";
	$dirPhotosLarge = $dirBase . "large/";
	$dirPhotosThumb = $dirBase . "thumb/";

	echo '<p align="center">Deleting files from ' . $dirBase . '...';

	if (file_exists($dirDownloads)){
		if ($dh = opendir($dirDownloads)) {
			while (($file = readdir($dh)) !== false) {
				if (filetype($dirDownloads . $file) == 'file'){
					unlink($dirDownloads . $file);
				}
			}
			closedir($dh);
		}
	}

	if (file_exists($dirImages)){
		if ($dh = opendir($dirImages)) {
			while (($file = readdir($dh)) !== false) {
				if (filetype($dirImages . $file) == 'file'){
					unlink($dirImages . $file);
				}
			}
			closedir($dh);
		}
	}

	if (file_exists($dirPhotosLarge)){
		if ($dh = opendir($dirPhotosLarge)) {
			while (($file = readdir($dh)) !== false) {
				if (filetype($dirPhotosLarge . $file) == 'file'){
					unlink($dirPhotosLarge . $file);
				}
			}
			closedir($dh);
		}
	}

	if (file_exists($dirPhotosThumb)){
		if ($dh = opendir($dirPhotosThumb)) {
			while (($file = readdir($dh)) !== false) {
				if (filetype($dirPhotosThumb . $file) == 'file'){
					unlink($dirPhotosThumb . $file);
				}
			}
			closedir($dh);
		}
	}

	if (file_exists($dirBase . "/music.mp3")){
		unlink($dirBase . "/music.mp3");
	}

	unlink($dirBase . "/content.php");

	rmdir($dirDownloads);
	rmdir($dirImages);
	rmdir($dirPhotosLarge);
	rmdir($dirPhotosThumb);
	rmdir($dirBase);

	echo '<p align="center">Page deleted!</p>';
	echo '<p align="center"><a href="/admin/sitemap/index.php">Site Content</a></p>';

	require "../includes/footer.inc.php";
?>
