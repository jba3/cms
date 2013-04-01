<?php
	setcookie("adminAuthenticated", "");

	header('Location: /admin/auth/login.php?logout=true');
?>
