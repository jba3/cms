<?php
	echo '<h1>This page is password protected</h1>';
	if (isset($_GET["failed"]) && $_GET["failed"]){
		echo '<p align="center"><strong><em>INVALID PASSWORD</em></strong></p><hr>';
	}
	echo '<p align="center">This page is password protected. Please enter the password below to view it.</p>';
	echo '<form action="/password-check.php" method="post">';
	echo '	<input type="hidden" name="pageID" value="' . $qryPage["pageID"] . '">';
	echo '	<input type="hidden" name="returnToPath" value="/' . $qryPage["groupFolder"] . '/' . $qryPage["sectionFolder"] . '/' . $qryPage["pageFolder"] . '/">';
	echo '	<p align="center">';
	echo '		<input type="text" name="passkey" maxlength="16" length="16">';
	echo '		<input type="submit" value="OK">';
	echo '	</p>';
	echo '</form>';
?>
