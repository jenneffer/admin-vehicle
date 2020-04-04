<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$monthto = 12;
$year = 2020;
var_dump($year);
function get_telekom_bill($acc_id, $year){
    global $conn_admin_db, $year,$monthto;
    $result = array();
    $query = "SELECT * FROM bill_telekom WHERE acc_id = '$acc_id' AND YEAR(date_start) = '$year'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    while($row = mysqli_fetch_assoc($rst)){
        $bt_id = $row['id'];
        $result = get_data($bt_id, $acc_id, $year, $monthto);
        
    }    
    return $result;
}
function get_data($bt_id,$acc_id, $year, $monthto){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_telefon_list WHERE bt_id= '$bt_id'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_data = array();
    while($row = mysqli_fetch_assoc($rst)){
        $arr_data[$row['tel_no']] = get_bill_monthly($row['tel_no'],$monthto);        
    }
    $arr_data['monthly_fee'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['rebate'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['credit_adjustment'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['gst_sst'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['adjustment'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['total'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['payment_due_date'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['cheque_no'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['payment_date'] = get_monthly_fee($acc_id,$monthto);
    
    return $arr_data;
}

function get_monthly_fee($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT monthly_bill FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }    
    return $result;
}
function get_rebate($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT rebate FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_credit_adjustment($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT credit_adjustment FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_gst_sst($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT gst_sst FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_adjustment($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT adjustment FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_total($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT amount FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_payment_due_date($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT due_date FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_cheque_no($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT cheque_no FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}
function get_payment_date($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT paid_date FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $amount;
    }
    return $result;
}

function get_bill_monthly($tel_no, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT usage_amt FROM bill_telefon_list
                    INNER JOIN bill_telekom ON bill_telekom.id = bill_telefon_list.bt_id
                    WHERE month(date_start)='$m' AND tel_no LIKE '%$tel_no%'");
        $result[$m] = $amount;
    }
    
    return $result;
    
}
// var_dump(get_monthly_bill(4, '2020', $monthto));

// $arr_result = array(
//     'sEcho' => 0,
//     'iTotalRecords' => 0,
//     'iTotalDisplayRecords' => 0,
//     'aaData' => array()
// );

$sql_query = "SELECT acc_id,account_no,user,position FROM bill_account_setup WHERE bill_type='3'";
$rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));

while ($row = mysqli_fetch_assoc($rst)) {
    $acc_id = $row['acc_id'];
    
    
    $arr_bills = get_monthly_bill($acc_id, $year, $monthto);
    var_dump($arr_bills);
//     $arr_bills_monthly[$acc_id] = $arr_bills;
}

// $total_found_rows = 0;
// $arr_data = array();
// foreach ($arr_bills_monthly as $id => $data){
//     $total_found_rows++;    
//     $user = itemName("SELECT user FROM bill_account_setup  WHERE acc_id='$id'");
//     $position = itemName("SELECT position FROM bill_account_setup  WHERE acc_id='$id'");
//     $acc_no = itemName("SELECT account_no FROM bill_account_setup  WHERE acc_id='$id'");
//     $total = 0;
//     for( $i=1; $i<=$monthto; $i++){
//         $total += $data[$i];
//     }
    
//     $datas = array(
//         $user,
//         $position,
//         $acc_no,
//         $data[1],
//         $data[2],
//         $data[3],
//         $data[4],
//         $data[5],
//         $data[6],
//         $data[7],
//         $data[8],
//         $data[9],
//         $data[10],
//         $data[11],
//         $data[12],
//         $total
        
//     );
//     $arr_data[] = $datas;
// }

// $arr_result = array(
//     'sEcho' => 0,
//     'iTotalRecords' => $total_found_rows,
//     'iTotalDisplayRecords' => $total_found_rows,
//     'aaData' => $arr_data
// );

// echo json_encode($arr_result);
?>