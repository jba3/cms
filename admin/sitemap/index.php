<?php
	function hasMusic($param){
		return(($param == 0) ? '&nbsp;' : dspIcon("music"));
	}

	function hasPasskey($param){
		return(($param == "") ? '&nbsp;' : dspIcon("lock"));
	}



	$pageheader = "Site Content";
	require "../includes/header.inc.php";
?>

<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<?php
	dbOpen();
		$result = dbSelect("
				g.groupID, g.groupFolder, g.groupName, g.groupSortOrder, g.groupDateCreated, g.groupDateUpdated,
				s.sectionID, s.sectionName, s.sectionFolder, s.sectionSortOrder, s.sectionDateCreated, s.sectionDateUpdated,
				p.pageID, p.parentPageID, p.pageFolder, p.menuText, p.pageTitle, p.pageSortOrder, p.hasMusic, p.pageHits, p.pageDateCreated, p.pageDateUpdated, p.passkey,
				p.tags,
			(select count(imageID) from cms_pageImages sub_i where sub_i.pageid=p.pageid) as countImages,
			(select count(photoID) from cms_pagePhotos sub_p where sub_p.pageid=p.pageid) as countPhotos,
			(select count(photoID) from cms_pagePhotos sub_pp1 where sub_pp1.pageid=p.pageid and sub_pp1.validThumb=0) as uncheckedThumb,
			(select count(photoID) from cms_pagePhotos sub_pp2 where sub_pp2.pageid=p.pageid and sub_pp2.validLarge=0) as uncheckedLarge,
			(select count(downloadID) from cms_pageDownloads sub_d where sub_d.pageid=p.pageid) as countDownloads,
			(select count(commentID) from cms_pageComments sub_c where sub_c.pageid=p.pageid) as countComments
			from cms_groups g
			left outer join cms_sections s on g.groupid=s.groupid
			left outer join cms_pages p on s.sectionid=p.sectionid
			where (parentPageID=0 or parentPageID is null)
			order by groupSortOrder, groupFolder, sectionSortOrder, sectionFolder, parentPageID asc, pageSortOrder
		");
		$qryTabs = dbSelect("groupID,groupName from cms_groups order by groupSortOrder");
		$qryCountGroups = mysql_fetch_assoc(dbSelect("count(groupID) as result from cms_groups"));
		$qryCountSections = mysql_fetch_assoc(dbSelect("count(sectionID) as result from cms_sections"));
		$qryCountPages = mysql_fetch_assoc(dbSelect("count(pageID) as result from cms_pages"));

		$old_groupID = 0;
		$old_sectionID = 0;

		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		echo '<tr>';
		echo '<td width="100%" valign="top">';
		echo '	<span style="background-color:#f99;">&nbsp;&nbsp;&nbsp;&nbsp;</span> means the page has not had the photo gallery picture sizes validated; click ' . dspIcon("detail") . ' the magnifying glass to validate them and remove the warning.<br/>';
		echo 	dspIcon("lock") . ' means the page has a password and can not be viewed without it<br/>';
		echo 	dspIcon("music") . ' means the page has music on it<br/>';
		echo '<br/>';
		echo '<a href="/admin/groups/add.php">' . dspIcon("add") . ' Add New Group</a></p>';
		echo '</td>';
		echo '<td valign="top" nowrap="nowrap">';
		echo '	<table>';
		echo '		<tr><td align="right"><strong>' . $qryCountGroups["result"] . '</strong></td><td> groups(s)</td></tr>';
		echo '		<tr><td align="right"><strong>' . $qryCountSections["result"] . '</strong></td><td> section(s)</td></tr>';
		echo '		<tr><td align="right"><strong>' . $qryCountPages["result"] . '</strong></td><td> page(s)</td></tr>';
		echo '	</table>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';

		echo '<div id="tabs">';
			echo '	<ul>';
				while ($rowTabs = mysql_fetch_assoc($qryTabs)) {
					echo '<li><a href="#tabs-' . $rowTabs["groupID"] . '">' .$rowTabs["groupName"]. '</a></li>';
				}
			echo '	</ul>';

			while ($row = mysql_fetch_assoc($result)) {
				if ($row["groupID"] <> $old_groupID){
					if ($old_groupID <> 0){
						echo '</table>';
						echo '</div>';
					}

					echo '<div id="tabs-' . $row["groupID"] . '">';
					echo '<table class="sitemap">';
					echo '<tr class="group">';
					echo '	<td rowspan="2" width="30" align="right">' . $row["groupSortOrder"] . '</td>';
					echo '	<td rowspan="2" colspan="4">' . $row["groupName"] . '</td>';
					echo '	<td rowspan="2" nowrap><a href="/admin/groups/edit.php?groupID=' . $row["groupID"] . '">' . dspIcon("edit") . ' Edit Group</a></td>';
					echo '	<td rowspan="2" nowrap><a href="/admin/sections/add.php?groupID=' . $row["groupID"] . '">' . dspIcon("add") . ' Add Section</a></td>';
					echo '	<td rowspan="2" colspan="8">&nbsp;</td>';
					echo '	<td align="center" colspan="2">DIRECT LINK URL</td>';
					echo '	<td align="center">Created</td>';
					echo '	<td align="center">Updated</td>';
					echo '</tr>';
					echo '<tr class="group">';
				    echo '	<td><a target="_blank" href="/' . $row['groupFolder'] . '">' . dspIcon("go") . ' /' . $row['groupFolder'] . '</a></td>';
					echo '	<td nowrap><a href="/admin/groups/changeUrl.php?groupID=' . $row["groupID"] . '">' . dspIcon("folder") . ' Change URL</a></td>';
					echo '	<td align="right">' . date("n/j/Y", strtotime($row["groupDateCreated"])) . '</td>';
					echo '	<td align="right">' . date("n/j/Y", strtotime($row["groupDateUpdated"])) . '</td>';
					echo '</tr>';
				}

				if ($row["sectionID"] <> $old_sectionID && $row["sectionID"] > 0){
					echo '<tr class="section">';
					echo '	<td class="transparent">&nbsp;</td>';
					echo '	<td width="30" align="right">' . $row["sectionSortOrder"] . '</td>';
					echo '	<td colspan="3">' . $row["sectionName"] . '</td>';
					echo '	<td nowrap><a href="/admin/sections/edit.php?sectionID=' . $row["sectionID"] . '">' . dspIcon("edit") . ' Edit Section</a></td>';
					echo '	<td nowrap><a href="/admin/pages/add.php?sectionID=' . $row["sectionID"] . '&parentPageID=0">' . dspIcon("add") . ' Add Page</a></td>';
					echo '	<td align="center" width="70">Private</td>';
					echo '	<td align="center" width="70">Music</td>';
					echo '	<td align="center" width="70">Images</td>';
					echo '	<td align="center" width="70">Photos</td>';
					echo '	<td align="center" width="70">Downloads</td>';
					echo '	<td align="center" width="70">Comments</td>';
					echo '	<td align="center" width="70">Hits</td>';
					echo '	<td align="center" width="70">Tags</td>';
					echo '	<td><a target="_blank" href="/' . $row['groupFolder'] . '/' . $row['sectionFolder'] . '">' . dspIcon("go") . ' /' . $row['groupFolder'] . '/' . $row['sectionFolder'] . '</a></td>';
					echo '	<td nowrap><a href="/admin/sections/changeUrl.php?sectionID=' . $row["sectionID"] . '">' . dspIcon("folder") . ' Change URL</a></td>';
					echo '	<td align="right">' . date("n/j/Y", strtotime($row["sectionDateCreated"])) . '</td>';
					echo '	<td align="right">' . date("n/j/Y", strtotime($row["sectionDateUpdated"])) . '</td>';
					echo '</tr>';
				}

					if ($row["pageID"] > 0){
						echo '<tr class="page">';
			//		    echo '<td style="background-color:#f90;"><a href="page-photos-add.php?pageID=' . $row["pageID"] . '">*QUICKBUILDER*</a></td>';// QUICKBUILDER SHORTCUT
			//		    echo '<td style="background-color:#f90;"><a href="insert-images-by-page.php?pageID=' . $row["pageID"] . '">*IMAGES*</a></td>';// IMAGES INSERT SHORTCUT
						echo '	<td colspan="2" class="transparent">&nbsp;</td>';
						echo '	<td width="30" align="right">'.$row['pageSortOrder'].'</td>';
						echo '	<td colspan="2">'.$row['pageTitle'] . '</td>';
						echo '	<td nowrap><a href="/admin/pages/edit.php?pageID=' . $row["pageID"] . '">' . dspIcon("edit") . ' Edit Page</a></td>';
						echo '	<td nowrap><a href="/admin/pages/add.php?sectionID=' . $row["sectionID"] . '&parentPageID=' . $row["pageID"] . '">' . dspIcon("add") . ' Add Subpage</a></td>';
						echo '	<td align="center">' . hasPasskey($row["passkey"]) . '</td>';
						echo '	<td align="center">' . hasMusic($row["hasMusic"]) . '</td>';
						echo '	<td align="right"><a href="/admin/pages/images.php?pageID=' . $row["pageID"] . '">' . $row["countImages"] . ' ' . dspIcon("images") . '</a></td>';

						$photoClass = "";
						if ($row["countPhotos"] > 0 && $row["uncheckedThumb"] > 0){
							$photoClass = "photosNeedValidation";
							$checkThumb = true;
						}else{
							$checkThumb = false;
						}
						if ($row["countPhotos"] > 0 && $row["uncheckedLarge"] > 0){
							$photoClass = "photosNeedValidation";
							$checkLarge = true;
						}else{
							$checkLarge = false;							
						}

						echo '	<td nowrap align="right" class="' . $photoClass . '"><a href="/admin/pages/photos/index.php?pageID=' . $row["pageID"] . '">' . $row["countPhotos"] . ' ' . dspIcon("photos") . '</a>';
						if ($checkThumb){
							echo '<br/><a href="/admin/pages/photos/fix-thumb-dimensions.php?pageID=' . $row["pageID"] . '">Check Thumbs (' . $row['uncheckedThumb'] . ')' . dspIcon("detail") . '</a>';
						}
						if ($checkLarge){
							echo '<br/><a href="/admin/pages/photos/fix-large-dimensions.php?pageID=' . $row["pageID"] . '">Check Large ('  . $row['uncheckedLarge'] . ')' . dspIcon("detail") . '</a>';
						}
						echo '	</td>';
						echo '	<td align="right"><a href="/admin/pages/downloads.php?pageID=' . $row["pageID"] . '">' . $row["countDownloads"] . ' ' . dspIcon("download") . '</a></td>';
						echo '	<td align="right"><a href="/admin/pages/comments.php?pageID=' . $row["pageID"] . '">' . $row["countComments"] . ' ' . dspIcon("comments") . '</a></td>';
						echo '	<td align="right">' . $row["pageHits"] . '</td>';
						echo '	<td>'.$row['tags'] . '</td>';
						echo '	<td><a target="_blank" href="/' . $row['groupFolder'] . '/' . $row['sectionFolder'] . '/' . $row['pageFolder'] . '">' . dspIcon("go") . ' /' . $row['groupFolder'] . '/' . $row['sectionFolder'] . '/' . $row['pageFolder'] . '</a></td>';
						echo '	<td nowrap><a href="/admin/pages/changeUrl.php?pageID=' . $row["pageID"] . '">' . dspIcon("folder") . ' Change URL</a></td>';
						echo '	<td align="right" nowrap>' . date("n/j/Y", strtotime($row["pageDateCreated"])) . '</td>';
						echo '	<td align="right" nowrap>' . date("n/j/Y", strtotime($row["pageDateUpdated"])) . '</td>';
						echo '</tr>';

						$childPages = mysql_query("
							select
								g.groupID, g.groupFolder, g.groupName, g.groupSortOrder, g.groupDateCreated, g.groupDateUpdated,
								s.sectionID, s.sectionName, s.sectionFolder, s.sectionSortOrder, s.sectionDateCreated, s.sectionDateUpdated,
								p.pageID, p.parentPageID, p.pageFolder, p.menuText, p.pageTitle, p.pageSortOrder, p.hasMusic, p.pageHits, p.pageDateCreated, p.pageDateUpdated, p.passkey, p.photoSizeValidated,
								p.tags,
							(select count(imageID) from cms_pageImages sub_i where sub_i.pageid=p.pageid) as countImages,
							(select count(photoID) from cms_pagePhotos sub_p where sub_p.pageid=p.pageid) as countPhotos,
							(select count(downloadID) from cms_pageDownloads sub_d where sub_d.pageid=p.pageid) as countDownloads,
							(select count(commentID) from cms_pageComments sub_c where sub_c.pageid=p.pageid) as countComments
							from cms_groups g
							left outer join cms_sections s on g.groupid=s.groupid
							left outer join cms_pages p on s.sectionid=p.sectionid
							where p.parentPageID=" . $row["pageID"] . " order by pageSortOrder asc"
						);

						while ($rowInner = mysql_fetch_assoc($childPages)) {
						    echo '<tr class="page">';
			//			    echo '<td style="background-color:#f90;"><a href="page-photos-add.php?pageID=' . $rowInner["pageID"] . '">*SHORTCUT*</a></td>';// QUICKBUILDER SHORTCUT
			//			    echo '<td style="background-color:#f90;"><a href="insert-images-by-page.php?pageID=' . $rowInner["pageID"] . '">*IMAGES*</a></td>';// IMAGES INSERT SHORTCUT
						    echo '	<td colspan="2" class="transparent">&nbsp;</td>';
						    echo '	<td class="transparent">&nbsp;</td>';
						    echo '	<td width="30" align="right">'.$rowInner['pageSortOrder'].'</td>';
						    echo '	<td colspan="1">'.$rowInner['pageTitle'] . '</td>';
						    echo '	<td nowrap><a href="/admin/pages/edit.php?pageID=' . $rowInner["pageID"] . '">' . dspIcon("edit") . ' Edit Page</a></td>';
						    echo '	<td>&nbsp;</td>';
							echo '	<td align="center">' . hasPasskey($rowInner["passkey"]) . '</td>';
							echo '	<td align="center">' . hasMusic($rowInner["hasMusic"]) . '</td>';
							echo '	<td align="right"><a href="/admin/pages/images.php?pageID=' . $rowInner["pageID"] . '">' . $rowInner["countImages"] . ' ' . dspIcon("images") . '</a></td>';

							$photoClass = "";
							if ($rowInner["countPhotos"] > 0 && $rowInner["uncheckedThumb"] > 0){
								$photoClass = "photosNeedValidation";
								$checkThumb = true;
							}else{
								$checkThumb = false;
							}
							if ($rowInner["countPhotos"] > 0 && $rowInner["uncheckedLarge"] > 0){
								$photoClass = "photosNeedValidation";
								$checkLarge = true;
							}else{
								$checkLarge = false;							
							}

							echo '	<td nowrap align="right" class="' . $photoClass . '"><a href="/admin/pages/photos/index.php?pageID=' . $rowInner["pageID"] . '">' . $rowInner["countPhotos"] . ' ' . dspIcon("photos") . '</a>';
							if ($checkThumb){
								echo '<br/><a href="/admin/pages/photos/fix-thumb-dimensions.php?pageID=' . $rowInner["pageID"] . '">Check Thumbs (' . $rowInner['uncheckedThumb'] . ')' . dspIcon("detail") . '</a>';
							}
							if ($checkLarge){
								echo '<br/><a href="/admin/pages/photos/fix-large-dimensions.php?pageID=' . $rowInner["pageID"] . '">Check Large ('  . $rowInner['uncheckedLarge'] . ')' . dspIcon("detail") . '</a>';
							}

							echo '	</td>';
							echo '	<td align="right"><a href="/admin/pages/downloads.php?pageID=' . $rowInner["pageID"] . '">' . $rowInner["countDownloads"] . ' ' . dspIcon("download") . '</a></td>';
							echo '	<td align="right"><a href="/admin/pages/comments.php?pageID=' . $rowInner["pageID"] . '">' . $rowInner["countComments"] . ' ' . dspIcon("comments") . '</a></td>';
							echo '	<td align="right">' . $rowInner["pageHits"] . '</td>';
							echo '	<td>' . $rowInner["tags"] . '</td>';
							echo '	<td><a target="_blank" href="/' . $rowInner['groupFolder'] . '/' . $rowInner['sectionFolder'] . '/' . $rowInner['pageFolder'] . '">' . dspIcon("go") . ' /' . $rowInner['groupFolder'] . '/' . $rowInner['sectionFolder'] . '/' . $rowInner['pageFolder'] . '</a></td>';
							echo '	<td nowrap><a href="/admin/pages/changeUrl.php?pageID=' . $rowInner["pageID"] . '">' . dspIcon("folder") . ' Change URL</a></td>';
							echo '	<td align="right" nowrap>' . date("n/j/Y", strtotime($rowInner["pageDateCreated"])) . '</td>';
							echo '	<td align="right" nowrap>' . date("n/j/Y", strtotime($rowInner["pageDateUpdated"])) . '</td>';
							echo '</tr>';
						}
				}

				$old_groupID = $row["groupID"];
				$old_sectionID = $row["sectionID"];

			};

		echo '</table>';
		echo '</div>';
		echo '</div>';
	dbClose();



	require $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/footer.inc.php";
?>
