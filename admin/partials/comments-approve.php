<?php
	if ($qryCommentsCount > 0){
		echo '<form action="' . $formAction . '" method="post" enctype="multipart/form-data">';
		if (isset($_GET["pageID"])){
			echo '	<input type="hidden" name="pageID" value="' . $_GET["pageID"] . '">';
		}

		echo '	<p align="center"><input type="submit" value="Save Changes"></p>';

		echo '<table align="center" border="1" cellspacing="0" cellpadding="0" class="data">';
		echo '<tr>';
		echo '	<th colspan="3">Approved</th>';
		echo '	<th>Name</th>';
		echo '	<th>Email</th>';
		echo '	<th>Hide<br>Email?</th>';
		echo '	<th>Comment</th>';
		echo '	<th>Date</th>';
		echo '</tr>';
		while ($rowComments = mysql_fetch_assoc($qryComments)){
			echo '<tr>';
			if ($rowComments["isApproved"] == 1){
				echo '	<td valign="top" align="center" colspan="3">' . dspIcon("check") . '</td>';
			}else{
				echo '	<td valign="top" align="center" nowrap="nowrap"><input type="radio" name="action' . $rowComments["commentID"] . '" value="-1" checked> Ignore for now</td>';
				echo '	<td valign="top" align="center" nowrap="nowrap"><input type="radio" name="action' . $rowComments["commentID"] . '" value="0"> Deny &amp; Remove</td>';
				echo '	<td valign="top" align="center" nowrap="nowrap"><input type="radio" name="action' . $rowComments["commentID"] . '" value="1"> Approve</td>';
			}
			echo '	<td valign="top">' . $rowComments["entryName"] . '</td>';
			echo '	<td valign="top">' . $rowComments["entryEmail"] . '</td>';
			echo '	<td valign="top" align="center">' . (($rowComments["entryEmailHide"]==1) ? 'Yes' : 'No') . '</td>';
			echo '	<td valign="top">' . $rowComments["entryComment"] . '</td>';
			echo '	<td valign="top" align="right" nowrap="nowrap">' . $rowComments["entryDtsAdd"] . '</td>';
			echo '</tr>';
		}
		echo '	</table>';
		echo '	<p align="center"><input type="submit" value="Save Changes"></p>';
		echo '</form>';
	}
?>
