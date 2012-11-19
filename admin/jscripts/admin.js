/*******************************************************************************
********************************************************************************
global delete confirm window
********************************************************************************
*******************************************************************************/
function confirmDelete(url){
	$( "#divConfirmDelete" ).dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Delete": function() {
				location.href = url;
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
}



/*******************************************************************************
********************************************************************************
global document ready
********************************************************************************
*******************************************************************************/
$(function() {
	/*******************************************************************************
	********************************************************************************
	top menu nav buttons
	********************************************************************************
	*******************************************************************************/
	$("#btnMenuHome").button({icons:{primary:"ui-icon-home"}});
	$("#btnMenuHome").click(function(){location.href='/admin/index.php';});

	$("#btnMenuSite").button({icons:{primary:"ui-icon-folder-open"}});
	$("#btnMenuSite").click(function(){location.href='/admin/sitemap/index.php';});

	$("#btnMenuComments").button({icons:{primary:"ui-icon-comment"}});
	$("#btnMenuComments").click(function(){location.href='/admin/comments/all-pending-comments.php';});

	$("#btnMenuArmory").button({icons:{primary:"ui-icon-comment"}});
	$("#btnMenuArmory").click(function(){location.href='/admin/armory/index.php';});

	$("#btnMenuReports").button({icons:{primary:"ui-icon-script"}});
	$("#btnMenuReports").click(function(){location.href='/admin/reports/index.php';});

	$("#btnMenuLogout").button({icons:{primary:"ui-icon-power"}});
	$("#btnMenuLogout").click(function(){location.href='/admin/auth/log-out.php';});

	/*******************************************************************************
	********************************************************************************
	bValidator standard form validation
	********************************************************************************
	*******************************************************************************/
	$("#frmAdmin").bValidator();

	/*******************************************************************************
	********************************************************************************
	Form buttons
	********************************************************************************
	*******************************************************************************/
	$(".btnSave").button({
		icons:{primary:"ui-icon-disk"}
	});

	$(".btnDelete").button({
		icons:{primary:"ui-icon-circle-close"}
	});
});
