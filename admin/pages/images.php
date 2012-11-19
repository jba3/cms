<?php
	$pageheader = "Page Images";
	require "../includes/header.inc.php";



	dbOpen();
		$qryImages = mysql_query("select imageID,filesize,filename,imagedtsadd,pageID from cms_pageImages where pageID=" . $_GET["pageID"] . " order by filename");
		$qryPage = mysql_fetch_assoc(mysql_query("select pageFolder,sectionFolder,groupFolder from cms_pages p join cms_sections s on p.sectionid=s.sectionid join cms_groups g on s.groupid=g.groupid where pageID=" . $_GET["pageID"]));
	dbClose();

	$path = "/content/" . $qryPage["groupFolder"] . '/' . $qryPage["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/images/';

	$qryImagesCount = mysql_num_rows($qryImages);

	echo '<p align="center"><strong>' . $qryImagesCount . '</strong> images available.</p>';

	echo '<form action="/admin/pages/imagesSubmit.php" method="post" enctype="multipart/form-data" id="frmAdmin">';
	echo '	<input type="hidden" name="pageID" value="' . $_GET["pageID"] . '">';
	echo '	<table align="center" class="form">';
	echo '		<tr>';
	echo '			<td class="label">Image:</td>';
	echo '			<td class="required"><input type="file" name="image"></td>';
	echo '			<td class="transparent">';
	echo dspButtonSave("Upload Image");
	echo '			</td>';
	echo '		</tr>';
	echo '	</table>';
	echo '</form>';

	if ($qryImagesCount > 0){
		echo '<table align="center" class="data">';
		echo '<tr>';
		echo '	<th>Preview</th>';
		echo '	<th>Filename</th>';
		echo '	<th>Size</th>';
		echo '	<th>Added</th>';
		echo '	<th>&nbsp;</th>';
		echo '</tr>';
		while ($rowImages = mysql_fetch_assoc($qryImages)){
			echo '<tr>';
			echo '	<td align="right"><img src="' . $path . $rowImages["filename"] . '" height="100"></td>';
			echo '	<td>' . $rowImages["filename"] . '</td>';
			echo '	<td align="right">' . number_format($rowImages["filesize"] / 1024, 0) . ' kb</td>';
			echo '	<td align="right">' . $rowImages["imagedtsadd"] . '</td>';
			echo '	<td align="right">';
			echo dspButtonDeleteWithId('/admin/pages/imagesDelete.php?pageID=' . $_GET["pageID"] . '&imageID=' . $rowImages["imageID"], 'delete'.$rowImages['imageID']);
			echo '	</td>';
			echo '</tr>';
		}
		echo '</table>';
	}



	require "../includes/footer.inc.php";
?>
