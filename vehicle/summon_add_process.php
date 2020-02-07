<?php
    require_once('../assets/config/database.php');
    require_once('./function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){
        $vehicle_reg_no = $_POST['vehicle_reg_no'];        
        $summon_date = dateFormat($_POST['summon_date']);        
        $summon_no = $_POST['summon_no'];
        $driver_name = $_POST['driver_name'];
        $summon_type = $_POST['summon_type'];
        $summon_desc = $_POST['summon_desc'];
        $offence_details = $_POST['offence_details'];
        $reimburse_amt = $_POST['reimburse_amt'];
        $pv_no = $_POST['pv_no'];
        
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_summons SET
                            vv_id = '".$vehicle_reg_no."',
                            vs_summon_no = '".$summon_no."',
                            vs_pv_no = '".$pv_no."',
                            vs_reimbursement_amt = '".$reimburse_amt."',
                            vs_summon_type_desc = '".$summon_desc."',
                            vs_driver_name = '".$driver_name."',
                            vs_summon_date = '".$summon_date."',
                            vs_summon_type = '".$summon_type."',
                            vs_description = '".$offence_details."',
                            vs_date_added = now()");
                                   
        alert ("Added successfully","summons.php");
    }
?>