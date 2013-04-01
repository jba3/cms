<?php
	if (mysql_num_rows($qrySubpages) > 0){
		echo '<h2>Other Pages in this Section</h2>';
		while ($rowSubpages = mysql_fetch_assoc($qrySubpages)) {
			if ($rowSubpages["pageID"] != $qryPage["pageID"]){
				echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("page") . ' <a href="/' . $rowSubpages["groupFolder"] . '/' . $rowSubpages["sectionFolder"] . '/' . $rowSubpages["pageFolder"] . '/">' . $rowSubpages["menuText"] . '</a></p>';
			}else{
				echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("page") . ' ' . $rowSubpages["menuText"] . '</p>';
			}
		}
		if ($qryPage["parentPageID"] > 0){
			echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dspIcon("back") . ' <a href="">Back to parent page</a></p>';
		}
	}
?>
