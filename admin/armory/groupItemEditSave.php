<?php
	$pageheader = "Armory Group Item (Edit)";
	require "../includes/header.inc.php";

	dbOpen();
		dbUpdate("
			armory
			set		armoryStatusID=$_POST[armoryStatusID],
					armoryMakerID=$_POST[armoryMakerID],
					notes='$_POST[notes]',
					description='$_POST[description]',
					isFunctional=$_POST[isFunctional],
					isHistorical=$_POST[isHistorical],
					materialID=$_POST[materialID],
					cost=$_POST[cost],
					purchaseDate=$_POST[purchaseDate],
					groupID=$_POST[groupID],
					purchaseLink='$_POST[purchaseLink]',
					lengthOverall=$_POST[lengthOverall],
					lengthBlade=$_POST[lengthBlade],
					widthGuard=$_POST[widthGuard],
					thicknessBlade=$_POST[thicknessBlade],
					widthBlade=$_POST[widthBlade],
					hasPicture=$_POST[hasPicture],
					sortOrder=$_POST[sortOrder],
					isPurchased=$_POST[isPurchased]
			where	armoryID=$_POST[armoryID]
		");

		dbDelete("armoryItemSlots where armoryID = " . $_POST[armoryID]);

		if (isset($_POST[armorySlotID])){
		    for($i=0; $i < count($_POST[armorySlotID]); $i++){
		    	dbInsert('armoryItemSlots(armoryID, armorySlotID) values (' . $_POST[armoryID] . ',' . $_POST[armorySlotID][$i] . ')');
		    }
	    }
	dbClose();
?>

<p align="center"><a href="groupItems.php?groupID=<?php echo $_POST['groupID'] ?>">Updated group item</a></p>

<?php
	require "../includes/footer.inc.php";
?>
