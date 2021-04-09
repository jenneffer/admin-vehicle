<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){
        $vehicle_reg_no = isset($_POST['vehicle_reg_no']) ? $_POST['vehicle_reg_no'] : "";        
        $summon_date = isset($_POST['summon_date']) ? dateFormat($_POST['summon_date']) : "";        
        $summon_no = isset($_POST['summon_no']) ? $_POST['summon_no'] : "";
        $driver_name = isset($_POST['driver_name']) ? $_POST['driver_name'] : "";
        $summon_type = isset($_POST['summon_type']) ? $_POST['summon_type'] : "";
        $summon_desc = isset($_POST['summon_desc']) ? $_POST['summon_desc'] : "";
        $offence_details = isset($_POST['offence_details']) ? $_POST['offence_details'] : "";
        $reimburse_amt = isset($_POST['reimburse_amt']) ? $_POST['reimburse_amt'] : "";
        $pv_no = isset($_POST['pv_no']) ? $_POST['pv_no'] : "";
        $driver_borne = isset($_POST['driver_borne']) ? $_POST['driver_borne'] : "";
        $company_borne = isset($_POST['company_borne']) ? $_POST['company_borne'] : "";
        
        $driver_b = "";
        $company_b = "";
        if($driver_borne == "on"){
            $driver_b = isset($_POST['driver_b']) ? $_POST['driver_b'] : "";
        }
        if($company_borne == "on"){
            $company_b = isset($_POST['company_b']) ? $_POST['company_b'] : "";
        }
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_summons SET
                            vv_id = '".$vehicle_reg_no."',
                            vs_summon_no = '".$summon_no."',
                            vs_pv_no = '".$pv_no."',
                            vs_reimbursement_amt = '".$reimburse_amt."',
                            vs_balance = '".$reimburse_amt."',
                            vs_summon_type_desc = '".$summon_desc."',
                            vs_driver_name = '".$driver_name."',
                            vs_summon_date = '".$summon_date."',
                            vs_summon_type = '".$summon_type."',
                            vs_description = '".$offence_details."',
                            vs_driver_borne = '".$driver_b."',
                            vs_company_borne = '".$company_b."',
                            vs_date_added = now()") or die (mysqli_error($conn_admin_db));
        
        if($sql_insert){
            alert ("Added successfully","summons.php");
        }        
    }
?>