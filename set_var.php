<?php 
require_once('assets/config/database.php');
session_start();
    if(isset($_POST['id'])){  
        $_SESSION['system_id']=$_POST['id'];
        $result['valid'] = TRUE;
    }
    echo json_encode($result);
    exit();
 ?>