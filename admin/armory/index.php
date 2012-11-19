<?php
	$pageheader = "Armory Groups";
	require "../includes/header.inc.php";

	dbOpen();
		$qryGroups = dbSelect("* from armoryGroups ag join armoryCategory ac on ag.categoryID=ac.categoryID order by ac.categoryID,ag.groupSort");
	dbClose();

	echo '<p align="center"><a href="groupAdd.php">Add New Group</a> | <a href="matrix.php">Status Matrix</a></p>';
	echo '<table align="center" cellspacing="0" cellpadding="3" border="1"><tr><th>Category</th><th>Sort</th><th>Name</th><th colspan="3">&nbsp;</th></tr>';
	$old_categoryID = 0;
	while ($row = mysql_fetch_assoc($qryGroups)) {
		echo '<tr class="group">';
	    if ($old_categoryID == $row['categoryID']){
	    	echo '	<td>&nbsp;</td>';
	    }else{
		    echo '	<td>' . $row['category'] . '</td>';
    	}
	    echo '	<td align="right">' . $row['groupSort'] . '</td>';
	    echo '	<td>' . $row['groupName'] . '</td>';
	    echo '	<td><a href="groupEdit.php?groupID=' . $row['groupID'] . '">Edit</a></td>';
	    echo '	<td><a href="groupDelete.php?groupID=' . $row['groupID'] . '">Delete</a></td>';
	    echo '	<td><a href="groupItems.php?groupID=' . $row['groupID'] . '">View Items</a></td>';
		echo '</tr>';

		$old_categoryID = $row['categoryID'];
	}
	echo '</table>';

	require "../includes/footer.inc.php";
?>
