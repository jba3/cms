<?php
	$pageheader = "Page Photos - Save Remote Image";
	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.inc.php";
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/group-section-page.php';
	require $_SERVER["DOCUMENT_ROOT"] . '/admin/pages/partials/photos.php';

	echo '<form method="post" action="/admin/pages/photos/remoteFileSave.php">';
	echo '	<input type="hidden" name="pageID" value="' . $_GET['pageID'] . '">';
	echo '	<table align="center" border="1" cellspacing="0" cellpadding="3">';
	echo '		<tr>';
	echo '			<td>';
	echo '				<p align="center">';
	echo '					Remote Image URL:';
	echo '					<input type="text" name="remoteURL" size="128">';
	echo '					<input type="submit" value="Save remote file">';
	echo '				</p>';
	echo '			</td>';
	echo '		</tr>';
	echo '	</table>';
	echo '</form>';

	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
