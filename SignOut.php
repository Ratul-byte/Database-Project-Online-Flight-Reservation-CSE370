<?php
	session_start();
	session_destroy();
	header("location: og_homepage.php");
?>