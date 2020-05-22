<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 
$id = isset($_POST['id']) ? $_POST['id'] : "";

$telco_acc_id = isset($_POST['telco_acc_id']) ? $_POST['telco_acc_id'] : "";

$telefon_list = isset($_POST['telefon_list']) ? $_POST['telefon_list'] : "";

if( $action != "" ){
    switch ($action){
        case 'add_new_account':
            add_new_account($data, $telefon_list);
            break;
            
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
            
        case 'add_new_bill':
            add_new_bill($data, $telco_acc_id);
            break;
            
        default:
            break;
    }
}

function add_new_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $telco_acc_id = $param['telco_acc_id'];
        $date = $param['date_entered'];
        $bill_amount = $param['bill_amount'];
        
        $query = "INSERT INTO bill_telco_billing SET
            telco_acc_id = '$telco_acc_id',
            date='".dateFormat($date)."',
            amount_rm='$bill_amount'";
        
        mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    }    
}

function add_new_account($data, $telefon_list){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data        
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location']);
        $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner']);
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        $ref_no =  mysqli_real_escape_string( $conn_admin_db,$param['ref_no']);
        $service_no =  mysqli_real_escape_string( $conn_admin_db,$param['service_no']);
        
        $query_insert_telekom = "INSERT INTO bill_telekom_account SET
                        company='$company',
                        account_no='$acc_no',
                        owner='$owner',
                        remark='$remark',
                        ref_no='$ref_no',
                        location='$location',
                        service_no='$service_no'";
        
        mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));
        
        $last_insert_id = mysqli_insert_id($conn_admin_db);
        
        $values = [];
        if(!empty($telefon_list)){
            foreach ($telefon_list as $tel){
                $telefon = $tel['telefon'];
                $type = $tel['type'];                
                
                $values[] = "('$last_insert_id', '$telefon', '$type')";
                
            }
            
            $values = implode(",", $values);
            $query = "INSERT INTO bill_telefon_list (bt_id, tel_no, phone_type) VALUES" .$values;
            mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        }        
    }    
}
function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_telco_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_telekom_account SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "telekom_setup.php");
        }
    }
}

//to round up0.05
function round_up($x){
    return round($x * 2, 1) / 2;
}
?>