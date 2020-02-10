<?php
    require_once('../assets/config/database.php');
    require_once('./function.php');
    session_start();
    global $conn_admin_db;
    if(isset($_POST['save'])){
        $vehicle_reg_no = $_POST['vehicle_reg_no'];
        $company_id = $_POST['company'];
        $category = $_POST['category'];
        $brand = $_POST['brand'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $yearPurchased = $_POST['yearPurchased'];
        $capacity = $_POST['capacity'];

        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_vehicle SET
								   vv_vehicleNo = '".$vehicle_reg_no."',
								   company_id = '".$company_id."',
                                   vv_category = '".$category."',
								   vv_brand = '".$brand."',
								   vv_name = '".$name."',
								   vv_description = '".$description."',
								   vv_yearPurchased = '".$yearPurchased."',
                                   vv_capacity = '".$capacity."',
                                   date_added = now()");
                                   
        alert ("Added successfully","vehicle.php");
    }
?>