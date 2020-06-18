<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";
$data = isset($_POST['data']) ? $_POST['data'] : "";
$cv_item = isset($_POST['cv_item']) ? $_POST['cv_item'] : "";
$id = isset($_POST['id']) ? $_POST['id'] : "";
$arr_cv_id = isset($_POST['str_cv_id']) ? $_POST['str_cv_id'] : "";
$total_cv = isset($_POST['total_cv']) ? $_POST['total_cv'] : 0;

if($action !=""){
    switch ($action){
            
        case 'add_new_request':
            add_new_request($data, $rq_item);
            break;
            
        case 'confirm_cash_voucher':
            confirm_cash_voucher($id);
            break;
            
        case 'save_staff_claim':
            save_staff_claim($arr_cv_id, $total_cv);
            break;
            
        default:
            break;
    }
}

function save_staff_claim($string, $total_cv){   
    global $conn_admin_db;
    $user_id = $_SESSION['cr_id'];
    $arr_cv_id = [];
    if(!empty($string)){
        $arr_cv_id = explode(",", $string);
    }    
    $cv_id = implode("','", $arr_cv_id);
    
    //generate staff_claim_id
    $insert_query = mysqli_query($conn_admin_db, "INSERT INTO om_pcash_staff_claim (date_added, add_by, amount)
                    VALUES(NOW(),$user_id, $total_cv)") or mysqli_error($conn_admin_db);
    $last_insert_id = mysqli_insert_id($conn_admin_db);
    
    //update  staff_claim_id and workflow_status in pcash_voucher table
    if($insert_query){
        $update_query = "UPDATE om_pcash_voucher SET staff_claim_id='$last_insert_id', workflow_status='3' WHERE id IN ('".$cv_id."')";        
        $rst = mysqli_query($conn_admin_db, $update_query) or mysqli_error($conn_admin_db);
        echo json_encode($rst);
    }
}

function confirm_cash_voucher($id){
    global $conn_admin_db;
    $query = "UPDATE om_pcash_voucher SET workflow_status='1' WHERE id='$id'";
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
}

function add_new_request($data, $rq_item){    
    global $conn_admin_db;
    $user_id = $_SESSION['cr_id'];
    if (!empty($data)) {
        $param = array();
        parse_str($_POST['data'], $param); //unserialize jquery string data
        
        $company_id = $param['company_id'];
        $recipient = $param['to'];
        $prepared_by = $_SESSION['cr_id'];
        $serial_no = $param['serial_no'];
        $date = $param['date'];
        $paid_date = $param['paid_date'];
        
        
        $query = "INSERT INTO om_requisition SET
            company_id='$company_id',
            user_id='$prepared_by',
            recipient='$recipient',
            serial_no='$serial_no', 
            date='".dateFormat($date)."',    
            payment_date='".dateFormat($paid_date)."'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
        $last_id = mysqli_insert_id($conn_admin_db);
        
        $value = [];
        foreach ($rq_item as $item){
            $value[] = "($last_id,'".$item['particular']."','".$item['total']."', '".$item['remark']."')";
        }
        
        $values = implode(",", $value);
        
        $insert_query = "INSERT INTO om_requisition_item (rq_id, particular, total, remark) VALUES $values";
        $result2 = mysqli_query($conn_admin_db, $insert_query) or die(mysqli_error($conn_admin_db));
        
        if ($result) {
            alert("Successfully added!", "requisition_preview.php?rq_id&".$last_id);
        }
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
                    'url' => "requisition_list.php"
                );
            }
        }else{
            $data = array(
                'message' => "Not allowed to delete confirmed request!",
                'url' => "requisition_list.php"
            );
        }
        echo json_encode($data);
    }
}

// function confirm_request($id){
//     global $conn_admin_db;   
//     if (!empty($id)) {
//         $query = "UPDATE om_pcash_request SET workflow_status = 'Confirm', updated_at = NOW() WHERE id='$id'";
//         $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
//         if ($result) {
//             alert("Request Confirmed!", "request_list.php");
//         }            
//     }    
// }

function update_request($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($_POST['data'], $param); //unserialize jquery string data
        
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