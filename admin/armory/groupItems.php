<?php
	$pageheader = "Armory Group Items";
	require "../includes/header.inc.php";

	dbOpen();
		$qryGroup = dbSelectAssoc("
			*
			from armoryGroups
			where groupID=" . $_GET['groupID']
		);
		$qryGroupItems = dbSelect("
			*
			from armory a
			left outer join armoryStatus ast on a.armoryStatusID=ast.armoryStatusID
			left outer join armoryMaker am on a.armoryMakerID=am.armoryMakerID
			where groupID=" . $_GET['groupID'] . "
			order by a.sortOrder
		");
	dbClose();

	// path references
	$thisPhotoDir = $_SERVER["DOCUMENT_ROOT"] . '/custom/armory/';




	echo '<h2 align="center">' . $qryGroup['groupName'] . '</h2>';
	echo '<p align="center"><a href="groupItemAdd.php?groupID=' . $_GET['groupID'] . '">Add New Group Item</a></p>';
	echo '<table align="center" cellspacing="0" cellpadding="3" border="1"><tr><th>Sort</th><th>Name</th><th>Maker</th><th>Status</th><th>Slot</th><th>ID</th><th>Photos</th><th colspan="3">&nbsp;</th></tr>';
	while ($row = mysql_fetch_assoc($qryGroupItems)) {
		dbOpen();
			$qrySlotUsed = dbSelect("* from armoryItemSlots ais join armorySlot asl on ais.armorySlotID=asl.armorySlotID where armoryID=" . $row['armoryID']);
		dbClose();

		// grab all files starting with the ID of the item
		$arrayPhotos = glob($thisPhotoDir . $row['armoryID'] . "-*.jpg");
		$countPhotos = count($arrayPhotos);

		echo '<tr class="group">';
	    echo '	<td valign="top" align="right">' . $row['sortOrder'] . '</td>';
	    echo '	<td valign="top">' . $row['description'] . '</td>';
	    echo '	<td valign="top">' . $row['armoryMaker'] . '</td>';
	    echo '	<td valign="top">' . $row['armoryStatus'] . '</td>';
	    echo '	<td valign="top">';
		while ($rowSlots = mysql_fetch_assoc($qrySlotUsed)) {
			echo $rowSlots['armorySlot'] . '<br>';
    	}
	    echo '	</td>';
	    echo '	<td>' . $row['armoryID'] . '</td>';
	    echo '	<td align="right">' . $countPhotos . '</td>';
	    echo '	<td><a href="groupItemEdit.php?groupID=' . $row['groupID'] . '&armoryID=' . $row['armoryID'] . '">Edit</a></td>';
	    echo '	<td><a href="groupItemDelete.php?groupID=' . $row['groupID'] . '&armoryID=' . $row['armoryID'] . '">Delete</a></td>';
	    echo '	<td><a href="groupItemImages.php?groupID=' . $row['groupID'] . '&armoryID=' . $row['armoryID'] . '">Photos</a></td>';
		echo '</tr>';

		mysql_free_result($qrySlotUsed);
	}
	echo '</table>';
	echo '<p align="center"><a href="index.php">Back to Groups</a></p>';

	require "../includes/footer.inc.php";
?>
