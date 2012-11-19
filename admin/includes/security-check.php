<?php
	if (!isset($_COOKIE["adminAuthenticated"])){
		header('Location: /admin/auth/login.php?expired=true');
	}
?>
