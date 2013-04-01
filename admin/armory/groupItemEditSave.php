<?php
	$pageheader = "Armory Group Item (Edit)";
	require "../includes/header.inc.php";

	dbOpen();
		$strSql = "
			armory
			set		armoryStatusID=$_POST[armoryStatusID],
					cost=$_POST[cost],
					purchaseDateMM=$_POST[purchaseDateMM],
					purchaseDateDD=$_POST[purchaseDateDD],
					purchaseDateYYYY=$_POST[purchaseDateYYYY],
					purchaseLink='$_POST[purchaseLink]',
					sortOrder=$_POST[sortOrder],
					description='$_POST[description]',
					groupID=$_POST[groupID],
					armoryMakerID=$_POST[armoryMakerID],
					materialID=$_POST[materialID],";
		if ($_POST['style'] != ''){
			$strSql = $strSql . "style=$_POST[style],";
		}
		if ($_POST['century'] != ''){
			$strSql = $strSql . "century=$_POST[century],";
		}
		if ($_POST['isGarniture'] != ''){
			$strSql = $strSql . "isGarniture=$_POST[isGarniture],";
		}
		if ($_POST['weightLbs'] != ''){
			$strSql = $strSql . "weightLbs=$_POST[weightLbs],";
		}
		if ($_POST['weightOz'] != ''){
			$strSql = $strSql . "weightOz=$_POST[weightOz],";
		}
		$strSql = $strSql . "
					isFunctional=$_POST[isFunctional],
					isHistorical=$_POST[isHistorical],
					notes='$_POST[notes]',
					notesHistorical='$_POST[notesHistorical]'";
			if ($_POST['categoryID'] == 1 || $_POST['categoryID'] == 3){// weapon
				$strSql .= "
					,lengthOverall=$_POST[lengthOverall]
					,lengthBlade=$_POST[lengthBlade]
					,widthGuard=$_POST[widthGuard]
					,thicknessBlade=$_POST[thicknessBlade]
					,widthBlade=$_POST[widthBlade]
				";
			}
			$strSql .= "
			where	armoryID=$_POST[armoryID]
		";

		dbUpdate($strSql);

		if ($_POST['categoryID'] == 2 || $_POST['categoryID'] == 4){// armor
			dbDelete("armoryItemSlots where armoryID = " . $_POST[armoryID]);

			if (isset($_POST[armorySlotID])){
			    for($i=0; $i < count($_POST[armorySlotID]); $i++){
			    	dbInsert('armoryItemSlots(armoryID, armorySlotID) values (' . $_POST[armoryID] . ',' . $_POST[armorySlotID][$i] . ')');
			    }
		    }

			dbDelete("armoryHarnesses where armoryID = " . $_POST[armoryID]);

			if (isset($_POST[armoryHarnessID])){
			    for($j=0; $j < count($_POST[armoryHarnessID]); $j++){
			    	dbInsert('armoryHarnesses(armoryID, armoryGroupID) values (' . $_POST[armoryID] . ',' . $_POST[armoryHarnessID][$j] . ')');
			    }
		    }
		}
	dbClose();
?>

<p align="center"><a href="groupItems.php?groupID=<?php echo $_POST['groupID'] ?>">Back to group items</a></p>
<p align="center"><a href="matrixFull.php">Go to Full Matrix</a></p>

<?php
	require "../includes/footer.inc.php";
?>
