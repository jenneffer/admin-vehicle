<?php
	require_once('assets/config/database.php');
    session_start();
	session_destroy();
header("Location: index.php");
	?>