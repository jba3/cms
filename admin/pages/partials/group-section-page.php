<?php
	dbOpen();
		$qryPage = mysql_fetch_assoc(dbSelect("sectionID,pageID,pageTitle from cms_pages where pageID=" . $_GET["pageID"]));
		$qrySection = mysql_fetch_array(dbSelect("groupID,sectionID,sectionName from cms_sections where sectionID=" . $qryPage["sectionID"]));
		$qryGroup = mysql_fetch_array(dbSelect("groupName from cms_groups where groupID=" . $qrySection["groupID"]));
	dbClose();

	echo '<table class="form">';
	echo '	<tr>';
	echo '		<td class="label">GROUP:</td><td>' . $qryGroup["groupName"] . '</td>';
	echo '		<td class="transparent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo '		<td class="label">SECTION:</td><td>' . $qrySection["sectionName"] . '</td>';
	echo '		<td class="transparent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo '		<td class="label">PAGE:</td><td>' . $qryPage["pageTitle"] . '</td>';
	echo '	</tr>';
	echo '</table>';
	echo '<br>';
?>