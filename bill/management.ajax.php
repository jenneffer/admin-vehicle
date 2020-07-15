<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$filter = isset($_POST['filter']) ? $_POST['filter'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

if( $action != "" ){
    switch ($action){
        case '':
        default:
            break;
    }
}


?>