<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){
        $vehicle_reg_no = $_POST['vehicle_reg_no'];
        $company_id = $_POST['company'];
        $category = $_POST['category'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $yearMade = $_POST['yearMade'];
        $engine_no = $_POST['engine_no'];
        $capacity = $_POST['capacity'];
        $chasis_no = $_POST['chasis_no'];
        $bdm = $_POST['bdm'];
        $btm = $_POST['btm'];
        $dispose = $_POST['dispose'];
        $driver = $_POST['driver'];
        $finance = $_POST['finance'];
        $v_remark = $_POST['v_remark'];
        $permit_type = $_POST['permit_type'];
        $permit_no = $_POST['permit_no'];
        $license_ref_no = $_POST['license_ref_no'];
        $lpkp_permit_due_date = $_POST['lpkp_permit_due_date'];
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_vehicle SET
                                            vv_vehicleNo = '".$vehicle_reg_no."',
                                            company_id = '".$company_id."',
                                            vv_category = '".$category."',
                                            vv_brand = '".$brand."',
                                            vv_model = '".$model."',
                                            vv_engine_no = '".$engine_no."',
                                            vv_chasis_no = '".$chasis_no."',
                                            vv_driver = '".$driver."',
                                            vv_bdm = '".$bdm."',
                                            vv_btm = '".$btm."',
                                            vv_finance = '".$finance."',
                                            vv_disposed = '".$dispose."',
                                            vv_remark = '".$v_remark."',
                                            vv_yearMade = '".$yearMade."',
                                            vv_capacity = '".$capacity."',
                                            date_added = now()");
        
        // get the vrt_id from vehicle table
        $last_insert_id = mysqli_insert_id($conn_admin_db);
        
        //insert into permit table
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_permit SET
                            vv_id = '".$last_insert_id."',
                            vpr_type = '".$permit_type."',
                            vpr_no = '".$permit_no."',
                            vpr_license_ref_no = '".$license_ref_no."',
                            vpr_due_date = '".dateFormat($lpkp_permit_due_date)."'");
                   
        alert ("Added successfully","vehicle.php");
    }
?>