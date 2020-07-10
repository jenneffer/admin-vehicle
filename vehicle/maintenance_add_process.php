<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){  
        $vehicle_reg_no = isset($_POST['vehicle_reg_no']) ? $_POST['vehicle_reg_no'] : ""; 
        $workshop = isset($_POST['workshop']) ? $_POST['workshop'] : "";
        $date = isset($_POST['date']) ? dateFormat($_POST['date']) : "";        
        $irf_no = isset($_POST['irf_no']) ? $_POST['irf_no'] : "";
        $irf_date = $_POST['irf_date'] ? dateFormat($_POST['irf_date']) : "";
        $po_no = isset($_POST['po_no']) ? $_POST['po_no'] : "";
        $po_date = isset($_POST['po_date']) ? dateFormat($_POST['po_date']) : "";
        $inv_no = isset($_POST['inv_no']) ? $_POST['inv_no'] : "";
        $user = isset($_POST['user']) ? $_POST['user'] : "";
        $amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
        $desc = isset($_POST['desc']) ? $_POST['desc'] : "";
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_maintenance SET
                            vv_id = '".$vehicle_reg_no."',
                            vm_date = '".$date."',
                            vm_description = '".$desc."',
                            vm_amount = '".$amount."',
                            vm_irf_no = '".$irf_no."',
                            vm_po_no = '".$po_no."',
                            vm_invoice_no = '".$inv_no."',
                            vm_irf_date = '".$irf_date."',
                            vm_po_date = '".$po_date."',
                            vm_user = '".$user."',
                            vm_workshop = '".$workshop."',
                            vm_date_added = NOW()") or die (mysqli_error($conn_db_admin));

        if($sql_insert){
            alert ("Added successfully","maintenance.php");
        }        
    }
?>