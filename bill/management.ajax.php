<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$filter = isset($_POST['filter']) ? $_POST['filter'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$id = isset($_POST['id']) ? $_POST['id'] : "";
$data = isset($_POST['data']) ? $_POST['data'] : "";
$database = isset($_POST['database']) ? $_POST['database'] : "";

if( $action != "" ){
    switch ($action){
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
        case 'update_account':
            update_account($data);
            break;
            
        case 'add_new_account':
            add_new_account($data);
            break;
            
        case 'retrieve_account_details':
            retrieve_account_details($id);
            break;
            
        case 'delete_account_details':
            delete_account_details($id, $database);
            break;
        default:
            break;
    }
}

function delete_account_details($id, $database){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "DELETE FROM $database WHERE id='$id'";
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
}

function retrieve_account_details($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "SELECT * FROM bill_management_fee WHERE id='$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function add_new_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $company = isset($param['company']) ? $param['company'] :"";
        $acc_no = isset($param['acc_no']) ? $param['acc_no'] :"";
        $location = isset($param['location']) ? $param['location'] :"";
        $owner = isset($param['owner']) ? $param['owner']: "";
        $management = isset($param['management']) ? $param['management'] :"";
        $unit_no = isset($param['unit_no']) ? $param['unit_no'] :"";
        $remark = isset($param['remark']) ? $param['remark']:"";
        $tenant = isset($param['tenant']) ? $param['tenant'] :"";
        $debtor_acc = isset($param['debtor_acc']) ? $param['debtor_acc']:"";
        
        $query = "INSERT INTO bill_management_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    remarks='$remark',
                    paid_to='$management',
                    unit_no='$unit_no',
                    tenant='$tenant',
                    debtor_account='$debtor_acc'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($result);
    }
}

function update_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data       
        $id = $param['id'];
        $company = isset($param['company_edit']) ? $param['company_edit'] :"";
        $acc_no = isset($param['acc_no_edit']) ? $param['acc_no_edit'] :"";
        $location = isset($param['location_edit']) ? $param['location_edit'] :"";
        $owner = isset($param['owner_edit']) ? $param['owner_edit']: "";
        $management = isset($param['management_edit']) ? $param['management_edit'] :"";
        $unit_no = isset($param['unit_no_edit']) ? $param['unit_no_edit'] :"";
        $remark = isset($param['remark_edit']) ? $param['remark_edit']:"";
        $tenant = isset($param['tenant_edit']) ? $param['tenant_edit'] :"";
        $debtor_acc = isset($param['debtor_acc_edit']) ? $param['debtor_acc_edit']:"";
        
        $query = "UPDATE bill_management_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',                    
                    remarks='$remark',
                    paid_to='$management',
                    unit_no='$unit_no',
                    tenant='$tenant',
                    debtor_account='$debtor_acc'
                    WHERE id='$id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($result);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_management_account SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        echo json_encode($result);
    }
}

function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "SELECT * FROM bill_management_account WHERE id='$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }   
}

?>