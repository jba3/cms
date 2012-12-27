<?php
	$pageheader = "Armory Spreadsheet output";
	require "../includes/header.inc.php";

	dbOpen();
		$qryGroups = dbSelect("
			a.armoryID,
			a.groupID,
			ag.categoryID,
			a.description,
			a.isFunctional,
			a.isHistorical,
			a.cost,
			a.purchaseDate,
			a.purchaseLink,
			a.lengthOverall,
			a.lengthBlade,
			a.widthGuard,
			a.thicknessBlade,
			a.widthBlade,
			a.hasPicture,
			a.sortOrder,
			a.isPurchased,
			a.notes,
			a.notesHistorical,
			a.weightLbs,
			a.weightOz,
			a.isGarniture,
			a.style,
			a.century,
			ast.armoryStatus,
			am.armoryMaker,
			am.armoryMakerURL,
			amat.material,
			ac.category,
			ag.groupName,
			(select count(armoryID) from armoryHarnesses where armoryID=a.armoryID) as groupCount
			from armory a
			left outer join armoryStatus ast on a.armoryStatusID=ast.armoryStatusID
			left outer join armoryMaker am on a.armoryMakerID=am.armoryMakerID
			left outer join armoryMaterial amat on a.materialID=amat.materialID
			left outer join armoryGroups ag on a.groupID=ag.groupID
			left outer join armoryCategory ac on ag.categoryID=ac.categoryID
			order by
				ac.category,
				ag.groupName,
				a.sortOrder,
				a.description
		");
	dbClose();
?>

<style type="text/css">
	table.ss{width:100%;border-collapse:collapse;border:1px solid #000;}
		table.ss *{font-size:10px;}
		table.ss tr th{border:1px solid #999;font-weight:bold;background-color:#ccc;text-align:center;}
		table.ss tr th.cat{background-color:#999;font-size:14px;}
		table.ss tr td{border:1px solid #999;background-color:#fff;}
</style>

<?php
	$old_cat = "";
	$old_grp = "";

	echo '<p>Click item name to edit</p>';

	echo '<table class="ss">';
	while ($row = mysql_fetch_assoc($qryGroups)) {
		if ($row['category'] != $old_cat){
			echo '<tr><th class="cat" colspan="26" nowrap>' . $row['category'] . '</th></tr>';
			echo '<tr>';
			echo '	<th>Group</th>';
			echo '	<th>Group<br>Count</th>';
			echo '	<th>Sort</th>';
			echo '	<th>Desc/Name</th>';
			echo '	<th>Func?</th>';
			echo '	<th>Hist?</th>';
			echo '	<th>Cost</th>';
			echo '	<th>Purch?</th>';
			echo '	<th>Purch<br>Date</th>';
			echo '	<th>Purch<br>Link</th>';

			echo '	<th>Length<br>Overall</th>';
			echo '	<th>Length<br>Blade</th>';
			echo '	<th>Width<br>Guard</th>';
			echo '	<th>Thickness<br>Blade</th>';
			echo '	<th>Width<br>Blade</th>';

			echo '	<th>HasPic</th>';
			echo '	<th>Notes</th>';
			echo '	<th>Notes<br>Hist</th>';
			echo '	<th>WtLbs</th>';
			echo '	<th>WtOz</th>';
			echo '	<th>isGarn</th>';
			echo '	<th>Style</th>';
			echo '	<th>Cent</th>';
			echo '	<th>Maker</th>';
			echo '	<th>Material</th>';
			echo '	<th>Status</th>';
			echo '</tr>';
		}

		echo '<tr class="group">';
		if ($row['groupName'] != $old_grp){
	    	echo '<td nowrap>' . $row['groupName'] . '</td>';
		}else{
	    	echo '<td>&nbsp;</td>';
		}
		if ($row['groupCount'] > 0){
	    	echo '<td align="right" nowrap>' . $row['groupCount'] . '</td>';
		}else{
			echo '<td>&nbsp;</td>';
		}
    	echo '<td align="right">' . $row['sortOrder'] . '</td>';
		echo '<td nowrap><a href="/admin/armory/groupItemEdit.php?groupID=' . $row['groupID'] . '&armoryID=' . $row['armoryID'] . '">' . $row['description'] . '</a>';
		if ($row['isFunctional']){
	    	echo '<td align="center">Y</td>';
	    }else{
	    	echo '<td>&nbsp;</td>';
	    }
		if ($row['isHistorical']){
	    	echo '<td align="center">Y</td>';
	    }else{
	    	echo '<td>&nbsp;</td>';
	    }
    	echo '<td align="right">' . $row['cost'] . '</td>';
    	if ($row['isPurchased']){
	    	echo '<td align="center">Y</td>';
	    }else{
	    	echo '<td>&nbsp;</td>';
	    }
    	if ($row['purchaseDate'] != "" && $row['purchaseDate'] != "0000-00-00"){
	    	echo '<td align="right" nowrap>' . $row['purchaseDate'] . '</td>';
    	}else{
	    	echo '<td>&nbsp;</td>';
    	}
		if ($row['purchaseLink'] != ""){
	    	echo '<td align="center"><a href="' . $row['purchaseLink'] . '">link</a></td>';
		}else{
	    	echo '<td>&nbsp;</td>';
		}

		if ($row['categoryID'] == 1 || $row['categoryID'] == 3){
	    	echo '<td align="right">' . $row['lengthOverall'] . '</td>';
	    	echo '<td align="right">' . $row['lengthBlade'] . '</td>';
	    	echo '<td align="right">' . $row['widthGuard'] . '</td>';
	    	echo '<td align="right">' . $row['thicknessBlade'] . '</td>';
	    	echo '<td align="right">' . $row['widthBlade'] . '</td>';
		}else{
			echo '<td colspan="5">&nbsp;</td>';
		}

    	echo '<td>' . $row['hasPicture'] . '</td>';
    	if ($row['notes'] != ""){
	    	echo '<td>YES</td>';
    	}else{
	    	echo '<td>&nbsp;</td>';
    	}
    	if ($row['notesHistorical'] != ""){
	    	echo '<td>YES</td>';
    	}else{
	    	echo '<td>&nbsp;</td>';
    	}
    	echo '<td>' . $row['weightLbs'] . '</td>';
    	echo '<td>' . $row['weightOz'] . '</td>';
    	if ($row['isGarniture'] == 1){
	    	echo '<td align="center">YES</td>';
    	}else{
	    	echo '<td>&nbsp;</td>';
    	}
    	echo '<td>' . $row['style'] . '</td>';
    	echo '<td>' . $row['century'] . '</td>';
    	if ($row['armoryMakerURL'] == ""){
	    	echo '<td>' . $row['armoryMaker'] . '</td>';
    	}else{
	    	echo '<td><a href="' . $row['armoryMakerURL'] . '">' . $row['armoryMaker'] . '</a></td>';
    	}
    	echo '<td>' . $row['material'] . '</td>';
	    echo '<td>' . $row['armoryStatus'] . '</td>';
//	    echo '<td>' . $row['armorySlot'] . '</td>';
		echo '</tr>';

		$old_cat = $row['category'];
		$old_grp = $row['groupName'];
	}
	echo '</table>';

	require "../includes/footer.inc.php";
?>
