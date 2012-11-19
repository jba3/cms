<?php
	$pageheader = "Armory Group Item (Edit)";
	require "../includes/header.inc.php";

	dbOpen();
		$qryRecord = mysql_fetch_assoc(dbSelect("* from armory where armoryID=" . $_GET['armoryID']));
		$qryGroup = mysql_fetch_assoc(dbSelect("* from armoryGroups where groupID=" . $_GET['groupID']));
		$qryGroups = dbSelect("* from armoryGroups where categoryID=" . $qryGroup['categoryID']);
		$qryStatus = dbSelect("* from armoryStatus");
		$qrySlots = dbSelect("* from armorySlot order by armorySlotSortOrder");
		$qryMaterials = dbSelect("* from armoryMaterial order by materialSort");
		$qryMakers = dbSelect("* from armoryMaker");
	dbClose();

	echo '<h2 align="center">Currently in: ' . $qryGroup['groupName'] . '</h2>';
?>

<form action="groupItemEditSave.php" method="post">
	<input type="hidden" name="groupID" value="<?php echo $_GET['groupID'] ?>">
	<input type="hidden" name="armoryID" value="<?php echo $_GET['armoryID'] ?>">

	<table border="1" cellspacing="0" cellpadding="10" align="center">
		<tr>
			<td valign="top">
				Description:<input type="text" name="description" size="64" maxlength="64" value="<?php echo $qryRecord['description'] ?>"><br>
				Maker:<select name="armoryMakerID">
				<?php
					while ($row = mysql_fetch_assoc($qryMakers)) {
						echo '<option value="' . $row['armoryMakerID'] . '"';
						if ($row['armoryMakerID'] == $qryRecord['armoryMakerID']){
							echo ' selected ';
						}
						echo '>' . $row['armoryMaker'] . '</option>';
					}
				?>
				</select><br>
				Group:<select name="groupID">
				<?php
					while ($row = mysql_fetch_assoc($qryGroups)) {
						echo '<option value="' . $row['groupID'] . '"';
						if ($row['groupID'] == $qryRecord['groupID']){
							echo ' selected ';
						}
						echo '>' . $row['groupName'] . '</option>';
					}
				?>
				</select><br>
				Status:<select name="armoryStatusID">
				<?php
					while ($row = mysql_fetch_assoc($qryStatus)) {
						echo '<option value="' . $row['armoryStatusID'] . '"';
						if ($row['armoryStatusID'] == $qryRecord['armoryStatusID']){
							echo ' selected ';
						}
						echo '>' . $row['armoryStatus'] . '</option>';
					}
				?>
				</select><br>
				Material:<select name="materialID">
				<?php
					while ($row = mysql_fetch_assoc($qryMaterials)) {
						echo '<option value="' . $row['materialID'] . '"';
						if ($row['materialID'] == $qryRecord['materialID']){
							echo ' selected ';
						}
						echo '>' . $row['material'] . '</option>';
					}
				?>
				</select><br>
				Sort:<input type="text" name="sortOrder" size="2" maxlength="2" value="<?php echo $qryRecord['sortOrder'] ?>"><br>
				Functional? 0 or 1<input type="text" name="isFunctional" size="1" maxlength="1" value="<?php echo $qryRecord['isFunctional'] ?>"><br>
				Historical? 0 or 1<input type="text" name="isHistorical" size="1" maxlength="1" value="<?php echo $qryRecord['isHistorical'] ?>"><br>
				Cost<input type="text" name="cost" size="8" maxlength="8" value="<?php echo $qryRecord['cost'] ?>"><br>
				Purchase Date<input type="text" name="purchaseDate" size="10" maxlength="10" value="<?php echo $qryRecord['purchaseDate'] ?>"><br>
				Purchase Link<input type="text" name="purchaseLink" size="64" maxlength="512" value="<?php echo $qryRecord['purchaseLink'] ?>"><br>
				hasPicture? 0 or 1<input type="text" name="hasPicture" size="1" maxlength="1" value="<?php echo $qryRecord['hasPicture'] ?>"><br>
				isPurchased? 0 or 1<input type="text" name="isPurchased" size="1" maxlength="1" value="<?php echo $qryRecord['isPurchased'] ?>"><br>
			</td>
			<td valign="top">
				<strong>ARMOR ONLY:</strong><br>
				<br>

				<?php
					// terrible method, but it's an admin screen for 1 user .... good enough
					dbOpen();
						while ($row = mysql_fetch_assoc($qrySlots)) {
							$qryIsSlotUsed = dbSelectAssoc("* from armoryItemSlots where armoryID=" . $_GET['armoryID'] . " and armorySlotID=" . $row['armorySlotID']);

							echo '<input type="checkbox" name="armorySlotID[]" value="' . $row['armorySlotID'] . '"';
							if (empty($qryIsSlotUsed) == 0){
								echo ' checked';
							}
							echo '>' . $row['armorySlot'] . '<br>';
						}
					dbClose();
				?>
			</td>
			<td valign="top">
				<strong>WEAPONS ONLY:</strong><br>
				<br>

				<input type="text" name="lengthOverall" size="1" maxlength="8" value="<?php echo $qryRecord['lengthOverall'] ?>">lengthOverall<br>
				<input type="text" name="lengthBlade" size="1" maxlength="8" value="<?php echo $qryRecord['lengthBlade'] ?>">lengthBlade<br>
				<input type="text" name="widthGuard" size="1" maxlength="8" value="<?php echo $qryRecord['widthGuard'] ?>">widthGuard<br>
				<input type="text" name="widthBlade" size="1" maxlength="8" value="<?php echo $qryRecord['widthBlade'] ?>">widthBlade<br>
				<input type="text" name="thicknessBlade" size="1" maxlength="8" value="<?php echo $qryRecord['thicknessBlade'] ?>">thicknessBlade<br>
			</td>
		</tr>
		<tr><td colspan="3" align="center">Item Notes:<br><textarea style="width:100%;height:64px;" name="notes"><?php echo $qryRecords['notes'] ?></textarea></td></tr>
	</table>

	<p align="center">
		<input type="submit">
	</p>
</form>

<?php
	require "../includes/footer.inc.php";
?>
