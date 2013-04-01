<!--
			*
			from armoryCategory ac
			left outer join armoryGroups ag on ac.categoryID=ag.categoryID
			left outer join armory a on a.groupID=ag.groupID
			left outer join armoryStatus ast on a.armoryStatusID=ast.armoryStatusID
			left outer join armorySlot asl on asl.armorySlotID=a.armorySlotID
			where ag.categoryID in (2,4)
			order by
				ac.categoryID,
				ag.groupSort,
				asl.armorySlotSortOrder,
				a.sortOrder
-->
<?php
	$pageheader = "Harness Status Matrix";
	require "../includes/header.inc.php";

	dbOpen();
		$qryGroups = dbSelect("
			* 
			from armoryCategory ac
			join armoryGroups ag on ac.categoryID=ag.categoryID
			join armory a on a.groupID=ag.groupID
			join armoryItemSlots ais on ais.armoryID=a.armoryID
			join armoryStatus ast on a.armoryStatusID=ast.armoryStatusID
			join armorySlot asl on asl.armorySlotID=ais.armorySlotID
			where ag.categoryID in (2,4)
			order by
				ac.categoryID,
				ag.groupSort,
				asl.armorySlotSortOrder,
				a.sortOrder
		");
	dbClose();

	echo '<table align="center" cellspacing="0" cellpadding="3" border="1">';
	echo '<tr>';
	echo '	<th>Category</th>';
	echo '	<th>Group</th>';
	echo '	<th>Slot</th>';
	echo '	<th>Item</th>';
	echo '	<th>Status</th>';
	echo '</tr>';

	$old_categoryID = 0;
	$old_groupID = 0;
	while ($row = mysql_fetch_assoc($qryGroups)) {

		echo '<tr class="group">';
	    if ($old_categoryID <> $row['categoryID']){
	    	echo '<td>' . $row['category'] . '</td>';
	    }else{
	    	echo '<td bgcolor="#999999">&nbsp;</td>';
	    }
	    if ($old_groupID <> $row['groupID']){
	    	echo '<td>' . $row['groupName'] . '</td>';
	    }else{
	    	echo '<td bgcolor="#999999">&nbsp;</td>';
	    }
	    echo '	<td align="right">' . $row['armorySlot'] . '</td>';
	    echo '	<td>' . $row['description'] . '</td>';
	    echo '	<td>' . $row['armoryStatus'] . '</td>';
		echo '</tr>';

		$old_categoryID = $row['categoryID'];
		$old_groupID = $row['groupID'];
	}
	echo '</table>';

	require "../includes/footer.inc.php";
?>
