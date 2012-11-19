<?php
	$pageheader = "Armory Group Item (Add)";
	require "../includes/header.inc.php";

	dbOpen();
		dbInsert("
			armory(
				armoryStatusID,
				armoryMakerID,
				description,
				isFunctional,
				isHistorical,
				materialID,
				cost,
				purchaseDate,
				groupID,
				purchaseLink,
				lengthOverall,
				lengthBlade,
				widthGuard,
				thicknessBlade,
				widthBlade,
				hasPicture,
				sortOrder,
				isPurchased
			)values(
				$_POST[armoryStatusID],
				$_POST[armoryMakerID],
				'$_POST[description]',
				$_POST[isFunctional],
				$_POST[isHistorical],
				$_POST[materialID],
				$_POST[cost],
				" . ((is_null($_POST[purchaseDate])) ? NULL : $_POST[purchaseDate]) . ",
				$_POST[groupID],
				'$_POST[purchaseLink]',
				$_POST[lengthOverall],
				$_POST[lengthBlade],
				$_POST[widthGuard],
				$_POST[thicknessBlade],
				$_POST[widthBlade],
				$_POST[hasPicture],
				$_POST[sortOrder],
				$_POST[isPurchased]
			)
		");
	dbClose();
?>

<p align="center"><a href="groupItems.php?groupID=<?php echo $_POST['groupID'] ?>">Added group item</a></p>

<?php
	require "../includes/footer.inc.php";
?>
