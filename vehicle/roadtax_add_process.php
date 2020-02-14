<?php
    require_once('../assets/config/database.php');
    require_once('./function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){
        $vehicle_reg_no = $_POST['vehicle_reg_no'];        
        $lpkp_date = dateFormat($_POST['lpkp_date']);
        $insurance_from_date = dateFormat($_POST['insurance_from_date']);
        $insurance_due_date = dateFormat($_POST['insurance_due_date']);
        $insurance_status = $_POST['insurance_status'];
        $roadtax_from_date = dateFormat($_POST['roadtax_from_date']);
        $roadtax_due_date = dateFormat($_POST['roadtax_due_date']);
        $premium_amount = $_POST['premium_amount'];
        $ncd = $_POST['ncd'];
        $sum_insured = $_POST['sum_insured'];
        $excess_paid = $_POST['excess_paid'];
        $roadtax_amount = $_POST['roadtax_amount'];
        $insurance_amount = $_POST['insurance_amount'];
        
        //calculate the roadtax period
        $diff = abs(strtotime($roadtax_due_date) - strtotime($roadtax_from_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        //insert into roadtax table
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_roadtax SET
                            vv_id = '".$vehicle_reg_no."',
                            vrt_lpkpPermit_dueDate = '".$lpkp_date."',                            
                            vrt_roadTax_fromDate = '".$roadtax_from_date."',
                            vrt_roadTax_dueDate = '".$roadtax_due_date."',
                            vrt_roadtaxPeriodYear = '".$years."',
                            vrt_roadtaxPeriodMonth = '".$months."',
                            vrt_roadtaxPeriodDay = '".$days."',
                            vrt_amount = '".$roadtax_amount."', 
                            vrt_updatedBy = '".$_SESSION['cr_id']."',                        
                            vrt_lastUpdated = now()") or  die(mysqli_error($conn_admin_db));
        
        // get the vrt_id from roadtax table and insert into insurance table
        $last_insert_id = mysqli_insert_id($conn_admin_db);
        
        $sql_insert_ins = mysqli_query($conn_admin_db,"INSERT INTO vehicle_insurance SET
                            vv_id = '".$vehicle_reg_no."',
                            vrt_id ='".$last_insert_id."',
                            vi_insurance_fromDate = '".$insurance_from_date."',
                            vi_insurance_dueDate = '".$insurance_due_date."',
                            vi_insuranceStatus = '".$insurance_status."',
                            vi_amount = '".$insurance_amount."',
                            vi_premium_amount='".$premium_amount."',
                            vi_ncd='".$ncd."',
                            vi_sum_insured='".$sum_insured."',
                            vi_excess_paid='".$excess_paid."',
                            vi_lastUpdated = now(),
                            vi_updatedBy = '".$_SESSION['cr_id']."'") or die(mysqli_error($conn_admin_db));
        
        if ($sql_insert && $sql_insert_ins) {
            alert ("Added successfully","roadtax.php");
        }
    }
?>