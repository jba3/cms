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
				purchaseDateMM,
				purchaseDateDD,
				purchaseDateYYYY,
				groupID,
				purchaseLink,
				sortOrder
			)values(
				$_POST[armoryStatusID],
				$_POST[armoryMakerID],
				'$_POST[description]',
				$_POST[isFunctional],
				$_POST[isHistorical],
				$_POST[materialID],
				$_POST[cost],
				'$_POST[purchaseDateMM]',
				'$_POST[purchaseDateDD]',
				'$_POST[purchaseDateYYYY]',
				$_POST[groupID],
				'$_POST[purchaseLink]',
				$_POST[sortOrder]
			)
		");
	dbClose();
?>

<p align="center"><a href="groupItems.php?groupID=<?php echo $_POST['groupID'] ?>">Added group item</a></p>

<?php
	require "../includes/footer.inc.php";
?>
