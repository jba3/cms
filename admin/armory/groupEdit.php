<?php
	$pageheader = "Armory Groups (Edit)";
	require "../includes/header.inc.php";

	dbOpen();
		$qryCategories = dbSelect("* from armoryCategory");
		$qryRecord = mysql_fetch_assoc(dbSelect("* from armoryGroups where groupID=" . $_GET['groupID']));
	dbClose();
?>

<form action="groupEditSave.php" method="post">
	<input type="hidden" name="groupID" value="<?php echo $_GET['groupID'] ?>">
	Name:<input type="text" name="groupName" value="<?php echo $qryRecord['groupName'] ?>"><br>
	Sort:<input type="text" name="groupSort" value="<?php echo $qryRecord['groupSort'] ?>"><br>
	Category:<select name="categoryID">
	<?php
		while ($row = mysql_fetch_assoc($qryCategories)) {
			echo '<option value="' . $row['categoryID'] . '"';
			if ($row['categoryID'] == $qryRecord['categoryID']){
				echo ' selected ';
			}
			echo '>' . $row['category'] . '</option>';
		}
	?>
	</select><br>
	<br>
	<input type="submit">
</form>

<?php
	require "../includes/footer.inc.php";
?>
