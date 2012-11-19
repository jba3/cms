<?php
	echo '<table width="100%" class="data">';
	echo '<tr>';
	echo '	<td width="25%" align="center">';

	if (is_dir($dirBase.'thumb') && is_dir($dirBase.'large')){
		// if the folders are there, nada
		echo 'THUMB and LARGE folders already exist';
	}else{
		// if the folders aren't there, put a link for them
		echo '		<a href="/admin/pages/photosFolders.php?pageID=' . $_GET["pageID"] . '">CREATE THE large and THUMB FOLDERS</a>';
	}
	echo '	</td>';
	echo '	<td width="25%" align="center"><a href="/admin/pages/photosAdd.php?pageID=' . $_GET["pageID"] . '">QuickBuilder - Add uploaded photos to this page</a></td>';
	echo '	<td width="25%" align="center"><a href="/admin/pages/photosThumbnails.php?pageID=' . $_GET["pageID"] . '">Make thumbnails for this gallery</a></td>';
	echo '	<td width="25%" align="center"><a href="/admin/pages/photosOrder.php?pageID=' . $_GET["pageID"] . '">Change Photo display order</a></td>';
	echo '</tr>';
	echo '</table>';

	echo '<br/>';
?>
