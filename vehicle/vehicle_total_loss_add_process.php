<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;

	if(isset($_POST['save'])){

	    $vehicle_reg_no = isset($_POST['vehicle_reg_no']) ? $_POST['vehicle_reg_no'] : "";
	    $insurance = isset($_POST['insurance']) ? $_POST['insurance'] : "";
	    $amount = isset($_POST['amount']) ? $_POST['amount'] : "";
	    $offer_letter_date = isset($_POST['offer_letter_date']) ? $_POST['offer_letter_date'] : "";
	    $payment_advice_date = isset($_POST['payment_advice_date']) ? $_POST['payment_advice_date'] : "";
	    $beneficiary_bank = isset($_POST['beneficiary_bank']) ? $_POST['beneficiary_bank'] : "";
	    $transaction_ref_no = isset($_POST['transaction_ref_no']) ? $_POST['transaction_ref_no'] : "";
	    $driver = isset($_POST['driver']) ? $_POST['driver'] : "";
	    $v_remark = isset($_POST['v_remark']) ? $_POST['v_remark'] : "";
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_total_loss SET
                                        vt_insurance = '".$insurance."',
                                        vt_offer_letter_date = '".dateFormat($offer_letter_date)."',
                                        vt_payment_advice_date = '".dateFormat($payment_advice_date)."',
                                        vt_vv_id = '".$vehicle_reg_no."',
                                        vt_amount = '".$amount."',
                                        vt_beneficiary_bank = '".$beneficiary_bank."',
                                        vt_trans_ref_no = '".$transaction_ref_no."',
                                        vt_driver = '".$driver."',
                                        vt_remark = '".$v_remark."',
                                        date_added = now()") or die (mysqli_error($conn_admin_db)); 
        
        if($sql_insert){
            alert("Added successfully!", "vehicle_total_loss.php");
        }    
	}

?>
