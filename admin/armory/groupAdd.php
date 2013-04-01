<?php
	$pageheader = "Armory Groups (Add)";
	require "../includes/header.inc.php";

	dbOpen();
		$qryCategories = dbSelect("* from armoryCategory");
	dbClose();
?>

<form action="groupAddSave.php" method="post">
	Name:<input type="text" name="groupName"><br>
	Sort:<input type="text" name="groupSort"><br>
	Category:<select name="categoryID">
	<?php
		while ($row = mysql_fetch_assoc($qryCategories)) {
			echo '<option value="' . $row['categoryID'] . '">' . $row['category'] . '</option>';
		}
	?>
	</select><br>
	<br>
	<input type="submit">
</form>

<?php
	require "../includes/footer.inc.php";
?>
