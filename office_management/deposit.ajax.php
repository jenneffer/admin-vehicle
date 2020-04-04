<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";
$data = isset($_POST['data']) ? $_POST['data'] : "";
$id = isset($_POST['id']) ? $_POST['id'] : "";

if($action !=""){
    switch ($action){
        case 'update_request':
            update_request($data);
            break;
            
        case 'add_new_deposit':
            add_new_deposit($data);
            break;
            
        case 'retrieve_request':
            retrieve_request($id);
            break;
            
        case 'confirm_request':
            confirm_request($id);
            break;
            
        case 'delete_request':
            delete_request($id);
            break;
            
        default:
            break;
    }
}

function delete_request($id){
    global $conn_admin_db;
    if(!empty($id)){
        //check the request status. if confirm or approved, disable delete
        $status = checkStatus($id);
        $data = array();
        if($status != 'Confirm' && $status != 'Approved'){
            $query = "DELETE FROM om_pcash_request WHERE id='$id'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));            
            if ($result) {
                $data = array(
                    'message' => "Request Deleted!",
                    'url' => "request_list.php"
                );
            }
        }else{
            $data = array(
                'message' => "Not allowed to delete confirmed request!",
                'url' => "request_list.php"
            );
        }
        echo json_encode($data);
    }
}

function confirm_request($id){
    global $conn_admin_db;   
    if (!empty($id)) {
        $query = "UPDATE om_pcash_request SET workflow_status = 'Confirm', updated_at = NOW() WHERE id='$id'";
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        if ($result) {
            alert("Request Confirmed!", "request_list.php");
        }            
    }    
}

function update_request($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($_POST['data'], $param); //unserialize jquery string data
        
    }
}

function add_new_deposit($data){
    global $conn_admin_db;
    $user_id = $_SESSION['cr_id'];
    if (!empty($data)) {
        $param = array();
        parse_str($_POST['data'], $param); //unserialize jquery string data

        $date = $param['date'];
        $pv_no = $param['pv_no'];
        $amount = $param['amount'];
        $remark = $param['remark'];       
        
        $query = "INSERT INTO om_pcash_deposit SET 
            date='".dateFormat($date)."', 
            pv_no='$pv_no',
            amount='$amount', 
            remark='$remark',                    
            user_id='$user_id', 
            date_added = NOW(),
            date_updated = NOW()";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        if ($result) {
            alert("Successfully added!", "deposit.php");
        }
    }
}

function retrieve_request($id){
    global $conn_admin_db;
    if (!empty($id)) {
        
        $query = "SELECT * FROM om_pcash_request WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

?>