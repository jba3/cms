<?php
	if ($qryPage["allowPageComments"]){
		echo '<h2>Page Comments</h2>';
		echo '<table class="pageComments">';
		while ($rowComments = mysql_fetch_assoc($qryComments)) {
			echo '<tr>';
			echo '<td class="label" align="left" width="100%"><strong>' . $rowComments["entryName"];
			if ($rowComments["entryEmailHide"] == 1){
				echo ' (' . $rowComments["entryEmail"] . ')';
			}
			echo '</strong></td>';
			echo '<td class="label" align="right" nowrap="nowrap">' . $rowComments["entryDtsAdd"] . '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td colspan="2">' . $rowComments["entryComment"] . '</td>';
			echo '</tr>';
			echo '<tr><td colspan="2" class="transparent">&nbsp;</td></tr>';
		}
		echo '</table>';

		echo '<p style="text-align:center"><button onclick="jQuery(\'#cms-page-comments-form\').toggle();">Add a comment on this page</button></p>';
		echo '<div id="cms-page-comments-form" style="display:none;">';
		echo '<form name="addComment" method="post" action="/comment-submit.php" onsubmit="return validateFormComment();">';
		echo '<input type="hidden" name="pageID" value="' . $qryPage["pageID"] . '">';
		echo '<table class="formComment" align="center">';
		echo '<tr>';
		echo '	<td class="label">Name:</td>';
		echo '	<td><input type="text" name="entryName" maxlength="64" style="width:320px;"></td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td class="label">Email:</td>';
		echo '	<td>';
		echo '		<input type="text" name="entryEmail" maxlength="128" style="width:320px;"><br/>';
		echo '		<input type="checkbox" name="entryEmailHide" value="1"> Check this box to hide your email address';
		echo '	</td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td class="label">Comment:</td>';
		echo '	<td><textarea name="entryComment" style="width:320px;"></textarea></td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td align="center" colspan="2">';
		echo '		<a href="#" onclick="document.getElementById(\'captcha\').src = \'/securimage/securimage_show.php?\' + Math.random(); return false"><img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" /></a><br/>';
		echo '		<em>Click the picture for a different image</em>';
		echo '	</td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td class="label" colspan="2" style="text-align:center;">Enter the orange text from above:</td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td colspan="2" align="center"><input type="text" name="captcha_code" maxlength="6" /></td>';
		echo '</tr>';
		echo '</table>';
		echo '<p style="text-align:center"><input type="submit" value="Submit Comment"></p>';
		echo '</form>';
		echo '</div>';

		echo '';
	}
?>
