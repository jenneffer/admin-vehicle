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
        $insurance_status = dateFormat($_POST['insurance_status']);
        $roadtax_from_date = dateFormat($_POST['roadtax_from_date']);
        $roadtax_due_date = dateFormat($_POST['roadtax_due_date']);
        $premium_amount = $_POST['premium_amount'];
        $ncd = $_POST['ncd'];
        $sum_insured = $_POST['sum_insured'];
        $excess_paid = $_POST['excess_paid'];
        $roadtax_amount = $_POST['roadtax_amount'];
        
        //calculate the roadtax period
        $diff = abs(strtotime($roadtax_due_date) - strtotime($roadtax_from_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_roadtax SET
                            vv_id = '".$vehicle_reg_no."',
                            vrt_lpkpPermit_dueDate = '".$lpkp_date."',
                            vrt_insurance_fromDate = '".$insurance_from_date."',
                            vrt_insurance_dueDate = '".$insurance_due_date."',
                            vrt_insuranceStatus = '".$insurance_status."',
                            vrt_roadTax_fromDate = '".$roadtax_from_date."',
                            vrt_roadTax_dueDate = '".$roadtax_due_date."',
                            vrt_roadtaxPeriodYear = '".$years."',
                            vrt_roadtaxPeriodMonth = '".$months."',
                            vrt_roadtaxPeriodDay = '".$days."',
                            vrt_amount = '".$roadtax_amount."',
                            premium_amount='".$premium_amount."',
                            ncd='".$ncd."',
                            sum_insured='".$sum_insured."',
                            excess_paid='".$excess_paid."',
                            vrt_lastUpdated = now()");
                                   
        alert ("Added successfully","roadtax.php");
    }
?>