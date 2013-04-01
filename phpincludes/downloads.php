<?php
	if (mysql_num_rows($qryDownloads) > 0){
		echo '<h2>Downloads</h2>';
		while ($rowDownloads = mysql_fetch_assoc($qryDownloads)) {
			echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("download") . ' <a href="/' . $qryPagePath . '/downloads/' . $rowDownloads["filename"] . '">' . $rowDownloads["downloadText"] . '</a></p>';
		}
	}
?>
