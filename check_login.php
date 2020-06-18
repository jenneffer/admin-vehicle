<?php 
require_once('assets/config/database.php');
require_once('function.php');
session_start();
if(isset($_SESSION['cr_id'])) {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $query = parse_url($url, PHP_URL_QUERY);
    parse_str($query, $params);
    
    // get id
    $userId = $_SESSION['cr_id'];
    $name = $_SESSION['cr_name'];
    
} else {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $PrevURL= $url;
    header("Location: /admin/login.php?RecLock=".$PrevURL);
	exit();
}
?>