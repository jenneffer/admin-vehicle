<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 
$id = isset($_POST['id']) ? $_POST['id'] : "";
$company = isset($_POST['company']) ? $_POST['company'] : "";

if( $action != "" ){
    switch ($action){
        case 'add_new_account':
            add_new_account($data);
            break;
            
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
            
        case 'add_new_bill':
            add_new_bill($data);
            break;
            
        case 'get_location':
            get_location($company);
            break;
            
        case 'delete_account_details_item':
            delete_account_details_item($id);
            break;
            
        case 'retrieve_account_details':
            retrieve_account_details($id);
            break;
        case 'update_account':
            update_account($data);
            break;
        default:
            break;
    }
}

function update_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $id = $param['id'];
        $company = isset($param['company_edit']) ? $param['company_edit'] : "";
        $acc_no =  isset($param['acc_no_edit']) ? $param['acc_no_edit'] : "";
        $location =  isset($param['location_edit']) ? $param['location_edit'] : "";
        $deposit =  isset($param['deposit_edit']) ? $param['deposit_edit'] : "";
        $tariff =  isset($param['tariff_edit']) ? $param['tariff_edit'] : "";
        $owner =  isset($param['owner_edit']) ? $param['owner_edit'] : "";
        $remark =  isset($param['remark_edit']) ? $param['remark_edit'] : "";
        $jenis_bacaan =  isset($param['jenis_bacaan_edit']) ? $param['jenis_bacaan_edit'] :"";
        $jenis_premis =  isset($param['jenis_premis_edit']) ? $param['jenis_premis_edit'] : "";
        
        $query = "UPDATE bill_jabatan_air_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    deposit='$deposit',
                    kod_tariff='$tariff',
                    remark='$remark',
                    jenis_bacaan='$jenis_bacaan',
                    jenis_premis='$jenis_premis' WHERE id='$id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
}

function retrieve_account_details($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "SELECT * FROM bill_jabatan_air WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account_details_item($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "DELETE FROM bill_jabatan_air WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "jabatan_air_setup.php");
        }
    }
}

function get_location($company){
    global $conn_admin_db;
    $query = "SELECT location,UPPER(location) AS location_name FROM bill_jabatan_air_account WHERE company_id='$company' AND status='1' GROUP BY location";
    $result = mysqli_query($conn_admin_db, $query);    
    $location_arr = array();   
    while( $row = mysqli_fetch_array($result) ){
        $location_arr[] = array(
            "loc" => $row['location'],
            "loc_name" => $row['location_name']
        );
    }
    
    // encoding array to json format
    echo json_encode($location_arr);
}

function add_new_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data       
        $cheque_no = $param['cheque_no'];
        $from_date = $param['from_date'];
        $to_date = $param['to_date'];
        $paid_date = $param['paid_date'];
        $due_date = $param['due_date'];
        $acc_id = $param['acc_id'];
        $read_from = $param['read_from'];
        $read_to = $param['read_to'];
        $usage_1 = $param['usage_1'];
        $usage_2 = $param['usage_2'];
        $rate_1 = $param['rate_1'];
        $rate_2 = $param['rate_2'];
        $credit = $param['credit'];
        $rate_70 = $usage_1 * $rate_1;
        $rate_71 = $usage_2 * $rate_2;
        $amount = $rate_70 + $rate_71;
        $rounded = round_up($amount);
        $adjustment = number_format(($rounded-$amount), 2);
        $total_amt = $amount + $adjustment;
        
        $query_insert_ja = "INSERT INTO bill_jabatan_air
                    SET acc_id = '$acc_id',
                    meter_reading_from = '$read_from',
                    meter_reading_to = '$read_to',
                    usage_70 = '$usage_1',
                    usage_71 = '$usage_2',
                    rate_1 = '$rate_1',
                    rate_2 = '$rate_2',
                    rate_70 = '$rate_70', 
                    rate_71 = '$rate_71',
                    credit_adjustment = '$credit',
                    amount = '$total_amt',
                    adjustment = '$adjustment',
                    cheque_no = '$cheque_no',
                    date_start = '".dateFormat($from_date)."',
                    date_end = '".dateFormat($to_date)."',
                    paid_date = '".dateFormat($paid_date)."',
                    due_date = '".dateFormat($due_date)."'";
       
        $result = mysqli_query($conn_admin_db, $query_insert_ja) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }   
}

function add_new_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location']);
        $deposit =  mysqli_real_escape_string( $conn_admin_db,$param['deposit']);
        $tariff =  mysqli_real_escape_string( $conn_admin_db,$param['tariff']);
        $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner']);        
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        $jenis_bacaan =  mysqli_real_escape_string( $conn_admin_db,$param['jenis_bacaan']);
        $jenis_premis =  mysqli_real_escape_string( $conn_admin_db,$param['jenis_premis']);
        
        $query = "INSERT INTO bill_jabatan_air_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    deposit='$deposit',
                    kod_tariff='$tariff',
                    remark='$remark',                    
                    jenis_bacaan='$jenis_bacaan',
                    jenis_premis='$jenis_premis'";

        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    }
}

function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_jabatan_air_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_jabatan_air_account SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "sesb_setup.php");
        }
    }
}

//to round up0.05
function round_up($x){
    return round($x * 2, 1) / 2;
}
?>