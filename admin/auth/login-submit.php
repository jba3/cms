<?php
	require "../../custom/settings.inc.php";



	if ($_POST["username"] == $admin_username and $_POST["password"] == $admin_password){
		// persist until browser closed
		// PHP is *VERY* picky with cookies - the /admin/ sets it valid for the whole /admin/ path;
		// if that isn't used, it *ONLY* sets the cookie for the /admin/auth/ subdirectory....
		setcookie("adminAuthenticated", "true", 0, "/admin/");

		header('Location: /admin/index.php');
	}else{
		header('Location: /admin/auth/login.php?failed=true');
	}
?>
