<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){        
        $vehicle_reg_no = $_POST['vehicle_reg_no'];        
        $date = dateFormat($_POST['date']);        
        $ref_no = $_POST['ref_no'];
        $amount = $_POST['amount'];
        $desc = $_POST['desc'];
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_maintenance SET
                            vv_id = '".$vehicle_reg_no."',
                            vm_date = '".$date."',
                            vm_description = '".$desc."',
                            vm_amount = '".$amount."',
                            vm_ref_no = '".$ref_no."',
                            vm_date_added = NOW()");
        
        if($sql_insert){
            alert ("Added successfully","maintenance.php");
        }        
    }
?>