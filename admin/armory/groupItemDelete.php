<?php
	$pageheader = "Armory Group Item (Add)";
	require "../includes/header.inc.php";

	dbOpen();
		dbDelete("
			armory
			where	armoryID = $_GET[armoryID]
		");
	dbClose();
?>

<p align="center"><a href="groupItems.php?groupID=<?php echo $_GET['groupID'] ?>">Deleted group item</a></p>

<?php
	require "../includes/footer.inc.php";
?>
