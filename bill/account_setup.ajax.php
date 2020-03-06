<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 

if( $action != "" ){
    switch ($action){
        case 'add_new_account':            
            if (!empty($data)) {
                $param = array();
                parse_str($_POST['data'], $param); //unserialize jquery string data
                //insert into billing - common details
                $bill_type = $param['bill_type'];
                $company = $param['company'];
                $location = $param['location'];
                $acc_no = $param['acc_no'];
                $deposit = $param['deposit'];
                $tariff = $param['tariff'];
                $owner = $param['owner'];
                $reference = $param['reference'];
                $position = $param['position'];
                $user = $param['user'];
                $hp_no = $param['hp_no'];
                $celcom_limit = $param['celcom_limit'];
                $package = $param['package'];
                $latest_package = $param['latest_package'];
                $limit_rm = $param['limit_rm'];
                $data = $param['data'];
                $remark = $param['remark'];
                $serial_no = $param['serial_no'];
                $owner_ref = $param['owner_ref'];
                $unit_no = $param['unit_no'];
                $property_type = $param['property_type'];
                
                
                $query_insert_common = "INSERT INTO bill_account_setup 
                                SET bill_type = '$bill_type', 
                                company_id = '$company', 
                                location_id = '$location',
                                account_no = '$acc_no',
                                deposit = '$deposit',
                                tariff = '$tariff',
                                owner = '$owner',
                                hp_no = '$hp_no',
                                reference = '$reference',
                                position = '$position',
                                user = '$user',
                                celcom_limit = '$celcom_limit',
                                package = '$package',
                                latest_package = '$latest_package',
                                limit_rm = '$limit_rm',
                                data = '$data',
                                remark = '$remark',
                                owner_ref = '$owner_ref',
                                serial_no = '$serial_no',
                                unit_no = '$unit_no',
                                property_type = '$property_type'";
                
                $result = mysqli_query($conn_admin_db, $query_insert_common) or die(mysqli_error($conn_admin_db));
                if($result){
                    alert("Successfully added!", "account_setup.php");
                }
                
                
                
            }
            
            break;
        default:
            break;
    }
}

?>