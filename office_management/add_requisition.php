<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();
global $conn_admin_db;
if (isset($_POST['btn_save'])) { 
    $company_id = isset($_POST['company_id']) ? $_POST['company_id'] : "";
    $recipient = isset($_POST['recipient']) ? $_POST['recipient'] : "";
    $serial_no = isset($_POST['serial_no']) ? $_POST['serial_no'] : "";
    $date = isset($_POST['date']) ? $_POST['date'] : "";
    $payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] : "";
    $particular = isset($_POST['particular']) ? $_POST['particular'] : ""; //array
    $total = isset($_POST['total']) ? $_POST['total'] : ""; //array
    $remark = isset($_POST['remark']) ? $_POST['remark'] : ""; //array
    
    $staff_claim_id = isset($_POST['staff_claim_id']) ? $_POST['staff_claim_id'] : "";
    
    $prepared_by = $_SESSION['cr_id'];
    
    $query = "INSERT INTO om_requisition SET
            company_id='$company_id',
            user_id='$prepared_by',
            recipient='$recipient',
            serial_no='$serial_no',
            staff_claim_id='$staff_claim_id',
            date='".dateFormat($date)."',
            payment_date='".dateFormat($payment_date)."'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    
    $last_id = mysqli_insert_id($conn_admin_db);
    
    $count = count($particular);
    $value = [];
    for($i=0; $i<$count; $i++){
        if ($particular[$i] !='' || $total[$i] !='' || $remark[$i] !=''){         
            $value[] = "($last_id,'".$particular[$i]."','".$total[$i]."', '".$remark[$i]."')";
        }
    }        
    $values = implode(",", $value);    
    $insert_query = "INSERT INTO om_requisition_item (rq_id, particular, total, remark) VALUES $values";    
    $result2 = mysqli_query($conn_admin_db, $insert_query) or die(mysqli_error($conn_admin_db));
    
    if ($result && $result2) {
        alert("Successfully added!", "requisition_preview.php?rq_id=".$last_id);
    }
    
}

?>