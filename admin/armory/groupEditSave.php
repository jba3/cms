<?php
	$pageheader = "Armory Groups (Edit)";
	require "../includes/header.inc.php";

	dbOpen();
		dbUpdate("
			armoryGroups
			set		categoryID=$_POST[categoryID],
					groupName='$_POST[groupName]',
					groupSort=$_POST[groupSort]
			where	groupID=$_POST[groupID]
		");
	dbClose();
?>

<p align="center"><a href="index.php">Updated group</a></p>

<?php
	require "../includes/footer.inc.php";
?>
