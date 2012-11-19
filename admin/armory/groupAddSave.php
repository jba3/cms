<?php
	$pageheader = "Armory Groups (Add)";
	require "../includes/header.inc.php";

	dbOpen();
		dbInsert("
			armoryGroups(
				categoryID,
				groupName,
				groupSort
			)
			values(
				$_POST[categoryID],
				'$_POST[groupName]',
				$_POST[groupSort]
			)
		");
	dbClose();
?>

<p align="center"><a href="index.php">Added group</a></p>

<?php
	require "../includes/footer.inc.php";
?>
