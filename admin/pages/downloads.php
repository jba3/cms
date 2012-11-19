<?php
	$pageheader = "Page Downloads";
	require "../includes/header.inc.php";



	dbOpen();
		$qryDownloads = dbSelect("downloadID,filename,downloadText,filesize,filedtsadd,filedtsmod from cms_pageDownloads where pageID=" . $_GET["pageID"] . " order by filedtsadd");
		$qryPage = mysql_fetch_assoc(dbSelect("pageFolder,sectionFolder,groupFolder from cms_pages p join cms_sections s on p.sectionid=s.sectionid join cms_groups g on s.groupid=g.groupid where pageID=" . $_GET["pageID"]));
	dbClose();

	$path = "../../content/" . $qryPage["groupFolder"] . '/' . $qryPage["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/downloads/';

	$qryDownloadCount = mysql_num_rows($qryDownloads);

	echo '<p align="center"><strong>' . $qryDownloadCount . '</strong> downloads available.</p>';

	echo '<form action="/admin/pages/downloadsSubmit.php" method="post" enctype="multipart/form-data" id="frmAdmin">';
	echo '	<input type="hidden" name="pageID" value="' . $_GET["pageID"] . '">';
	echo '	<table align="center" class="form">';
	echo '		<tr>';
	echo '			<td class="label">Download Link Text:</td>';
	echo '			<td class="required"><input type="text" name="downloadText"></td>';
	echo '			<td class="transparent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo '			<td class="label">File:</td>';
	echo '			<td class="required"><input type="file" name="download"></td>';
	echo '			<td class="transparent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo '			<td class="transparent">' . dspButtonSave("Upload File") . '</td>';
	echo '		</tr>';
	echo '	</table>';
	echo '</form>';

	if ($qryDownloadCount > 0){
		echo '<table align="center" class="data">';
		echo '<tr>';
		echo '	<th>Filename</th>';
		echo '	<th>Download Text</th>';
		echo '	<th>Size</th>';
		echo '	<th>Added</th>';
		echo '	<th>Updated</th>';
		echo '	<th>&nbsp;</th>';
		echo '</tr>';
		while ($rowDownloads = mysql_fetch_assoc($qryDownloads)){
			echo '<tr>';
			echo '	<td>' . $rowDownloads["filename"] . '</td>';
			echo '	<td>' . $rowDownloads["downloadText"] . '</td>';
			echo '	<td align="right">' . number_format($rowDownloads["filesize"] / 1024, 0) . ' kb</td>';
			echo '	<td align="right">' . $rowDownloads["filedtsadd"] . '</td>';
			echo '	<td align="right">' . $rowDownloads["filedtsmod"] . '</td>';
			echo '	<td align="right">' . dspButtonDeleteWithId('/admin/pages/downloadsDelete.php?pageID=' . $_GET["pageID"] . '&downloadID=' . $rowDownloads["downloadID"], $rowDownloads["downloadID"]) . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	require "../includes/footer.inc.php";
?>
