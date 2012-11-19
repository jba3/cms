<?php
	$pageheader = "Armory Group Item (Add)";
	require "../includes/header.inc.php";

	dbOpen();
		$qryGroup = mysql_fetch_assoc(dbSelect("* from armoryGroups where groupID=" . $_GET['groupID']));
		$qryGroups = dbSelect("* from armoryGroups");
		$qryMaterials = dbSelect("* from armoryMaterial order by materialSort");
		$qryStatus = dbSelect("* from armoryStatus");
		$qryMakers = dbSelect("* from armoryMaker");
	dbClose();

	echo '<h2 align="center">Adding in: ' . $qryGroup['groupName'] . '</h2>';
?>

<form action="groupItemAddSave.php" method="post">
	<input type="hidden" name="groupID" value="<?php echo $_GET['groupID'] ?>">
	<input type="hidden" name="armoryID" value="<?php echo $_GET['armoryID'] ?>">

	Maker:<select name="armoryMakerID">
	<?php
		while ($row = mysql_fetch_assoc($qryMakers)) {
			echo '<option value="' . $row['armoryMakerID'] . '">' . $row['armoryMaker'] . '</option>';
		}
	?>
	</select><br>
	Status:<select name="armoryStatusID">
	<?php
		while ($row = mysql_fetch_assoc($qryStatus)) {
			echo '<option value="' . $row['armoryStatusID'] . '">' . $row['armoryStatus'] . '</option>';
		}
	?>
	</select><br>
	Material:<select name="materialID">
	<?php
		while ($row = mysql_fetch_assoc($qryMaterials)) {
			echo '<option value="' . $row['materialID'] . '">' . $row['material'] . '</option>';
		}
	?>
	</select><br>
	<br>
	Description:<input type="text" name="description" size="64" maxlength="64"><br>
	Sort:<input type="text" name="sortOrder" size="2" maxlength="2"><br>
	Functional? 0 or 1<input type="text" name="isFunctional" size="1" maxlength="1"><br>
	Historical? 0 or 1<input type="text" name="isHistorical" size="1" maxlength="1"><br>
	Cost<input type="text" name="cost" size="8" maxlength="8"><br>
	Purchase Date<input type="text" name="purchaseDate" size="10" maxlength="10"><br>
	Purchase Link<input type="text" name="purchaseLink" size="128" maxlength="512"><br>
	hasPicture? 0 or 1<input type="text" name="hasPicture" size="1" maxlength="1"><br>
	isPurchased? 0 or 1<input type="text" name="isPurchased" size="1" maxlength="1"><br>

	<br>
	<strong>WEAPONS ONLY:</strong><br>
	<br>

	lengthOverall<input type="text" name="lengthOverall" size="8" maxlength="8"><br>
	lengthBlade<input type="text" name="lengthBlade" size="8" maxlength="8"><br>
	widthGuard<input type="text" name="widthGuard" size="8" maxlength="8"><br>
	widthBlade<input type="text" name="widthBlade" size="8" maxlength="8"><br>
	thicknessBlade<input type="text" name="thicknessBlade" size="8" maxlength="8"><br>

	<input type="submit">
</form>

<?php
	require "../includes/footer.inc.php";
?>
