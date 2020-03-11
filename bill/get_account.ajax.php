<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();
    
    $bill_type = $_POST['bill_type'];

    
    if($bill_type == 1 || $bill_type == 2 || $bill_type == 3){ //sesb//ja//telekom
        $query = "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id),' - ',bill_account_setup.account_no ) AS comp_acc FROM bill_account_setup WHERE bill_type='$bill_type'";
    }
    else if($bill_type == 4){ //celcom
        $query = "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id), ' - ',bill_account_setup.user , ' (',bill_account_setup.account_no,')') AS comp_acc FROM bill_account_setup WHERE bill_type='$bill_type'";
    }
    else if($bill_type == 5){ //fujixerox
        $query = "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id), ' - ', bill_account_setup.serial_no ) AS comp_acc FROM bill_account_setup WHERE bill_type='$bill_type'";
    }
    else if($bill_type == 6){ //management fee
        $query = "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id),' (',IF(bill_account_setup.owner_ref = '', bill_account_setup.unit_no, bill_account_setup.owner_ref),')',' - ', IF(property_type = 2,'HOUSE', 'SHOP LOT')) AS comp_acc FROM bill_account_setup WHERE bill_type='$bill_type'";
    }
    
    $result = mysqli_query($conn_admin_db, $query);
    
    $account_arr = array();
    
    while( $row = mysqli_fetch_array($result) ){
        $acc_id = $row['acc_id'];
        $descprition = $row['comp_acc'];
        
        $account_arr[] = array("acc_id" => $acc_id, "description" => $descprition);
    }
    
    // encoding array to json format
    echo json_encode($account_arr);
    
?>