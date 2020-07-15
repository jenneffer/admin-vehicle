<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 
$id = isset($_POST['id']) ? $_POST['id'] : "";

$telefon_list = isset($_POST['telefon_list']) ? $_POST['telefon_list'] : "";
$acc_id = isset($_POST['acc_id']) ? $_POST['acc_id'] : "";
if( $action != "" ){
    switch ($action){
        case 'add_new_account':
            add_new_account($data, $telefon_list);
            break;
            
        case 'update_account':
            update_account($data);
            break;
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
            
        case 'add_new_telefon':
            add_new_telefon($acc_id, $telefon_list);
            break;
            
        case 'retrieve_telefon_list':
            retrieve_telefon_list($acc_id);
            break;
            
        case 'add_new_bill':
            add_new_bill($data);
            break;
        default:
            break;
    }
}

function update_account($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    $acc_id = $param['id'];
    $company =  mysqli_real_escape_string( $conn_admin_db,$param['company_edit']);
    $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no_edit']);
    $location =  mysqli_real_escape_string( $conn_admin_db,$param['location_edit']);
    $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner_edit']);
    $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark_edit']);
    $ref_no =  mysqli_real_escape_string( $conn_admin_db,$param['ref_no_edit']);
    $service_no =  mysqli_real_escape_string( $conn_admin_db,$param['service_no_edit']);
    
    $query = "UPDATE bill_telekom_account SET
                        company_id='$company',
                        account_no='$acc_no',
                        owner='$owner',
                        remark='$remark',
                        ref_no='$ref_no',
                        location='$location',
                        service_no='$service_no' WHERE id='$acc_id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}
function add_new_bill($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data 

    $acc_id = $param['acc_id'];
    $tel_count = $param['tel_count'];
    $from_date = dateFormat($param['from_date']);
    $to_date = dateFormat($param['to_date']);
    $paid_date = dateFormat($param['paid_date']);
    $due_date = dateFormat($param['due_date']);
    $bill_no = $param['bill_no'];
    $monthly_fee = $param['monthly_fee'];
    $cr_adj = $param['cr_adjustment'];
    $rebate = $param['rebate'];
    $cheque_no = $param['cheque_no'];
    $other_charges = $param['other_charges'];    
    $phone_usage = [];
    $total_phone_usage = 0;
    for ($i=1; $i <= $tel_count; $i++){
        $total_phone_usage += $param['name_'.$i];
        $phone_usage[$param['phone_'.$i]] = $param['name_'.$i];
    }

    $gst_sst = number_format(($monthly_fee + $other_charges + $total_phone_usage) * 6/100, 2);
    $amount = $monthly_fee + $other_charges + $total_phone_usage + $gst_sst + $rebate + $cr_adj;
    $rounded = round_up($amount);
    $adjustment = number_format(($rounded-$amount), 2);
    $total_amt = $amount + $adjustment;
    $query = "INSERT INTO bill_telekom (acc_id, bill_no, cheque_no, date_start, date_end, paid_date, due_date, monthly_bill, credit_adjustment,gst_sst, amount, rebate, adjustment, other_charges)
             VALUES('$acc_id','$bill_no', '$cheque_no','$from_date', '$to_date','$paid_date', '$due_date', '$monthly_fee', '$cr_adj','$gst_sst','$total_amt', '$rebate', '$adjustment','$other_charges')";

    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    
    if(!empty($phone_usage) && $result){
        $value = [];
        foreach ($phone_usage as $telefon_id => $telefon_usage){
            $value[] = "('$telefon_id', '$acc_id', '$to_date',now(), '$telefon_usage')";
        }
        $values = implode(",", $value);
        $qry = "INSERT INTO bill_telefon_usage (telefon_id, acc_id, date, date_added, usage_rm) VALUES".$values;
        
        $rst = mysqli_query($conn_admin_db, $qry) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($rst);
    }
    
}

function retrieve_telefon_list($acc_id){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_telefon_list WHERE bt_id='$acc_id' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function add_new_telefon($acc_id, $telefon_list){
    global $conn_admin_db;
    foreach ($telefon_list as $tel){
        $telefon = $tel['telefon'];
        $type = $tel['type'];
        
        
        $values[] = "('$acc_id', '$telefon', '$type')";
        
    }
    
    $values = implode(",", $values);
    $query = "INSERT INTO bill_telefon_list (bt_id, tel_no, phone_type) VALUES" .$values;
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
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
                        company_id='$company',
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
        $query = "SELECT * FROM bill_telekom_account WHERE id = '$id'";
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