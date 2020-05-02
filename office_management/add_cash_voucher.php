<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();
global $conn_admin_db;
if (isset($_POST['btn_save'])) {
    
    $company_id = isset($_POST['company_id']) ? $_POST['company_id'] : "";
    $recipient = isset($_POST['recipient']) ? $_POST['recipient'] : "";
    $voucher_no = isset($_POST['voucher_no']) ? $_POST['voucher_no'] : "";
    $date = isset($_POST['date']) ? $_POST['date'] : "";
    $item_date = isset($_POST['item_date']) ? $_POST['item_date'] : ""; //array
    $description = isset($_POST['description']) ? $_POST['description'] : ""; //array
    $amount = isset($_POST['amt']) ? $_POST['amt'] : ""; //array    
    
    $prepared_by = $_SESSION['cr_id'];
    
    $query = "INSERT INTO om_pcash_voucher SET
            company_id = '$company_id',
            user_id = '$prepared_by',
            recipient = '$recipient',
            cv_no = '$voucher_no',
            cv_date = '".dateFormat($date)."',
            created_at = NOW(),
            updated_at = NOW()";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    
    $last_id = mysqli_insert_id($conn_admin_db);
    
    $count = count($description);
    $value = [];
    for($i=0; $i<$count; $i++){
        if ($description[$i] !='' || $item_date[$i] !='' || $amount[$i] !=''){         
            $value[] = "($last_id,'".dateFormat($item_date[$i])."','".$description[$i]."', '".$amount[$i]."')";
        }
    }        
    $values = implode(",", $value);    
    $insert_query = "INSERT INTO om_pcash_voucher_item (cv_id, item_date, particular, amount) VALUES $values";    
    $result2 = mysqli_query($conn_admin_db, $insert_query) or die(mysqli_error($conn_admin_db));
    
    if ($result && $result2) {
        alert("Successfully added!", "pcash_voucher_preview.php?cv_id=".$last_id);
    }
    
}

?>