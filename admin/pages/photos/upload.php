<?php
	$pageheader = "Page Photos - Upload File(s)";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/photos.php';

	echo '<form method="post" action="/admin/pages/photos/uploadSave.php" enctype="multipart/form-data">';
	echo '	<input type="hidden" name="pageID" value="' . $_GET['pageID'] . '">';
	echo '	<table align="center" border="0" cellspacing="0" cellpadding="3">';
	echo '		<tr>';
	echo '			<td>';
	echo '				<p align="center">';
	echo '					Files:';
	echo '					<input name="upload[]" type="file" multiple="multiple" />';
	echo '					<input type="submit" value="Upload Photos">';
	echo '				</p>';
	echo '			</td>';
	echo '		</tr>';
	echo '	</table>';
	echo '</form>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>


