<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$filter = isset($_POST['filter']) ? $_POST['filter'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$telco_type = isset($_POST['telco_type']) ? $_POST['telco_type'] : "";

if( $action != "" ){
    switch ($action){
        case 'report_sesb':   
            get_report_sesb($filter, $year);
            break;
            
//         case 'report_jabatan_air':
//             get_report_jabatan_air($filter, $year);
//             break;
            
        case 'report_celcom':
            get_report_celcom($filter, $year, $telco_type);
            break;
            
//         case 'report_photocopy_machine':
//             get_report_photocopy_machine($filter, $year);
//             break;
            
        case 'report_management_fee':
            get_report_management_fee($filter, $year);
            break;
            
        case 'report_monthly_telekom':
            get_monthly_bill_telekom($filter,$year);
            break;
            
        case 'report_water_bill':
            get_report_water_bill($year);
            break;
            
        case 'late_interest_charge':
            get_late_interest_charge($year);
            break;
            
        case 'quit_rent_billing':
            get_quit_rent_billing($year);
            break;
            
        case 'insurance_premium':
            get_insurance_premium($year);
            break;
            
        case 'report_photocopy':
            get_monthly_bill_photocopy($filter, $year);
            break;
            
        case 'report_monthly_jabatan_air':
            get_monthly_jabatan_air($filter, $year);
            break;
            
        case 'report_monthly_sesb':
            get_report_monthly_sesb($filter, $year);
            break;
            
        default:
            break;
    }
}

function get_report_monthly_sesb($filter, $year){
    global $conn_admin_db;
    $monthto = 12;
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    
    $sql_query = "SELECT id,company_id, owner,account_no,location FROM bill_sesb_account WHERE status='1'";
    if(!empty($filter)){
        $sql_query .= " AND company_id = '".$filter."' ";
    }
    $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
    
    while ($row = mysqli_fetch_assoc($rst)) {
        $acc_id = $row['id'];
        $arr_bills = get_monthly_bill_sesb($acc_id, $year, $monthto);
        $arr_bills_monthly[$acc_id] = $arr_bills;
    }
    $total_found_rows = 0;
    $arr_data = array();
    $count = 0;
    foreach ($arr_bills_monthly as $id => $data){
        if( array_sum($data) !=0 ){
            $count++;
            $total_found_rows++;
            $acc_no = itemName("SELECT account_no FROM bill_sesb_account  WHERE id='$id'");
            $owner = itemName("SELECT owner FROM bill_sesb_account  WHERE id='$id'");
            $location = itemName("SELECT location FROM bill_sesb_account  WHERE id='$id'");
            $code = itemName("SELECT code FROM company WHERE id IN(SELECT company_id FROM bill_sesb_account  WHERE id='$id')");
            $total = 0;
            for( $i=1; $i<=$monthto; $i++){
                $total += $data[$i];
            }
            
            $datas = array(
                $acc_no."<br>(".$code.")",
                $owner,
                $location,
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $total
                
            );
            $arr_data[] = $datas;
        }        
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_monthly_jabatan_air($filter, $year){
    global $conn_admin_db;
    $monthto = 12;
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    
    $sql_query = "SELECT id,company_id, owner,account_no,location FROM bill_jabatan_air_account";
    if(!empty($filter)){
        $sql_query .= " WHERE company_id = '".$filter."' ";
    }
    $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
    
    while ($row = mysqli_fetch_assoc($rst)) {
        $acc_id = $row['id'];
        $arr_bills = get_monthly_bill_jabatan_air($acc_id, $year, $monthto);
        $arr_bills_monthly[$acc_id] = $arr_bills;
    }
    $total_found_rows = 0;
    $arr_data = array();
    $count = 0;
    foreach ($arr_bills_monthly as $id => $data){
        if( array_sum($data) !=0 ){
            $count++;
            $total_found_rows++;
            $acc_no = itemName("SELECT account_no FROM bill_jabatan_air_account  WHERE id='$id'");
            $owner = itemName("SELECT owner FROM bill_jabatan_air_account  WHERE id='$id'");
            $location = itemName("SELECT location FROM bill_jabatan_air_account  WHERE id='$id'");
            $total = 0;
            for( $i=1; $i<=$monthto; $i++){
                $total += $data[$i];
            }
            
            $datas = array(
                $acc_no,
                $owner,
                $location,
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $total
                
            );
            $arr_data[] = $datas;            
        }        
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_monthly_bill_photocopy($filter, $year){
    global $conn_admin_db;
    $monthto = 12;
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    
    $sql_query = "SELECT id,company,serial_no,location FROM bill_fuji_xerox_account";
    if(!empty($filter)){
        $sql_query .= " WHERE company = '".$filter."' ";
    }
    $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
    
    while ($row = mysqli_fetch_assoc($rst)) {
        $acc_id = $row['id'];
        $arr_bills = get_monthly_bill_fx($acc_id, $year, $monthto);
        $arr_bills_monthly[$acc_id] = $arr_bills;
    }
    $total_found_rows = 0;
    $arr_data = array();
    $count = 0;
    foreach ($arr_bills_monthly as $id => $data){
        if( array_sum($data) !=0 ){
            $count++;
            $total_found_rows++;
            $serial_no = itemName("SELECT serial_no FROM bill_fuji_xerox_account  WHERE id='$id'");
            $location = itemName("SELECT location FROM bill_fuji_xerox_account  WHERE id='$id'");
            $total = 0;
            for( $i=1; $i<=$monthto; $i++){
                $total += $data[$i];
            }
            
            $datas = array(
                $serial_no,
                $location,
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $total
                
            );
            $arr_data[] = $datas;
            
        }        
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_insurance_premium($year){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_insurance_premium WHERE YEAR(date_from) = '$year'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $total_found_rows = 0;
    $arr_data = array();
    if ( mysqli_num_rows($rst) ){
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];
            $data = array(
                $row['date_from'],
                $row['date_to'],
                $row['invoice_no'],
                $row['description'],
                $row['payment'],
                $row['date_paid'],
                strtoupper($row['payment_mode']),                
                $row['or_no'],
            );
            
            $arr_data[] = $data;
        }
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_quit_rent_billing($year){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_quit_rent_billing WHERE YEAR(invoice_date) = '$year'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $total_found_rows = 0;
    $arr_data = array();
    if ( mysqli_num_rows($rst) ){
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];
            $data = array(
                $row['remarks'],
                $row['inv_no'],
                $row['invoice_date'],
                $row['payment'],
                $row['date_paid'],
                strtoupper($row['payment_mode']),
                $row['or_no'],
                $row['due_date'],
                $row['date_received']                
            );
            
            $arr_data[] = $data;
        }
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_late_interest_charge($year){    
    global $conn_admin_db;
    $query = "SELECT * FROM bill_late_interest_charge WHERE YEAR(bill_date) = '$year'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $total_found_rows = 0;
    $arr_data = array();
    if ( mysqli_num_rows($rst) ){
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];
            $data = array(
                $row['bill_date'],
                $row['inv_no'],
                $row['payment_due_date'],
                $row['description'],
                $row['amount'],
                strtoupper($row['payment_mode']),
                $row['or_no']                
            );
            
            $arr_data[] = $data;
        }
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_report_water_bill($year){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_water WHERE YEAR(due_date) = '$year'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $total_found_rows = 0;
    $arr_data = array();
    if ( mysqli_num_rows($rst) ){
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];
            $data = array(
                $row['date_from'] ." to ".$row['date_to'],
                $row['invoice_no'],
                $row['invoice_date'],
                $row['due_date'],
                $row['description'],
                $row['previous_mr'],
                $row['previous_mr'],
                $row['total_consume'],
                $row['charged_amount'],
                $row['surcharge'],
                $row['adjustment'],
                $row['total'],
                $row['paid_date'],
                $row['payment_mode'],
                $row['or_no'],
                $row['received_date']
            );
            
            $arr_data[] = $data;
        }
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_report_telekom($filter, $year){
    global $conn_admin_db;
    $query = "SELECT (DATE_FORMAT(date_end,'%M')) month_name, date_start, date_end, bill_no, monthly_bill, rebate, credit_adjustment, gst_sst,
              adjustment, amount, paid_date, due_date, cheque_no FROM bill_telekom
              INNER JOIN bill_account_setup ON bill_account_setup.acc_id = bill_telekom.acc_id";
    
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $total_found_rows = 0;
    $arr_data = array();
    if ( mysqli_num_rows($rst) ){
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];
            
            $data = array(
                $row['month_name'],
                $row['date_start'] ." - ".$row['date_end'],
                $row['bill_no'],
                $row['monthly_bill'],
                $row['rebate'],
                $row['credit_adjustment'],
                $row['gst_sst'],
                $row['adjustment'],
                $row['amount'],
                $row['due_date'],
                $row['cheque_no'],
                $row['paid_date']
            );
            
            $arr_data[] = $data;
        }
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_management_monthly_bill($acc_id, $year, $monthto){
    $result = array();
    
    for($m = 1; $m <= $monthto; $m++){
        //management_fee
        $amount_mf = itemName("SELECT SUM(payment_amount) FROM bill_management_fee WHERE acc_id='$acc_id' AND YEAR(received_date)='$year' AND MONTH(received_date)='$m'");
        //water bill
        $amount_wb = itemName("SELECT SUM(total) FROM bill_management_water WHERE acc_id='$acc_id' AND YEAR(received_date)='$year' AND MONTH(received_date)='$m'");
        //late interest charge
        $amount_li = itemName("SELECT SUM(amount) FROM bill_management_late_interest_charge WHERE acc_id='$acc_id' AND YEAR(bill_date)='$year' AND MONTH(bill_date)='$m'");
        //quit rent
        $amount_qr = itemName("SELECT SUM(payment) FROM bill_management_quit_rent WHERE acc_id='$acc_id' AND YEAR(date_received)='$year' AND MONTH(date_received)='$m'");
        //insurance premium        
        $amount_ip = itemName("SELECT SUM(payment) FROM bill_management_insurance WHERE acc_id='$acc_id' AND YEAR(date_from)='$year' AND MONTH(date_from)='$m'");
        
        $total_amount = $amount_mf + $amount_wb + $amount_li + $amount_qr + $amount_ip;
        
        $result[$m] = $total_amount;
    }
    
    return $result;
}

function get_report_management_fee($filter, $year){
    global $conn_admin_db;
    $monthto = 12;
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $sql_query = "SELECT id,account_no,owner FROM bill_management_account";
    if(!empty($filter)){
        $sql_query .= " WHERE company_id = '".$filter."' ";
    }
    $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
    
    while ($row = mysqli_fetch_assoc($rst)) {
        $acc_id = $row['id'];
        $arr_bills = get_management_monthly_bill($acc_id, $year, $monthto);        
        $arr_bills_monthly[$acc_id] = $arr_bills;
    }
    $total_found_rows = 0;
    $arr_data = array();
    $count = 0;    
    foreach ($arr_bills_monthly as $id => $data){
        if(array_sum($data) !=0){
            
            $count++;
            $total_found_rows++;
            $location = itemName("SELECT location FROM bill_management_account WHERE id='$id'");
            $owner = itemName("SELECT IFNULL(owner,owner_ref) FROM bill_management_account WHERE id='$id'");
            $company = itemName("SELECT code FROM company WHERE id IN (SELECT company_id FROM bill_management_account WHERE bill_management_account.id='$id' )");
            $total = 0;
            for( $i=1; $i<=$monthto; $i++){
                $total += $data[$i];
            }
            
            $datas = array(
                $location,
                $company,
                $owner,
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $total
                
            );
            $arr_data[] = $datas;
            
        }        
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);

}

// function get_report_photocopy_machine($filter, $year){
//     global $conn_admin_db;
//     $query = "SELECT (DATE_FORMAT(date,'%M')) month_name, full_color, black_white, color_a3, copy, print, fax, date  FROM bill_photocopy_machine
//             INNER JOIN bill_account_setup ON bill_account_setup.acc_id = bill_photocopy_machine.acc_id WHERE bill_photocopy_machine.acc_id = '$filter'
//             AND DATE_FORMAT(date,'%Y') = '$year'";
    
//     $query .= " ORDER BY date ASC";
      
//     $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => 0,
//         'iTotalDisplayRecords' => 0,
//         'aaData' => array()
//     );
//     $total_found_rows = 0;
//     $arr_data = array();
//     if ( mysqli_num_rows($rst) ){
//         while( $row = mysqli_fetch_assoc( $rst ) ){
//             $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
//             $total_found_rows = $row_found[0];
//             $total = $row['full_color'] + $row['black_white'] + $row['copy'] + $row['print'] + $row['fax'];
            
//             $data = array(
//                 $row['month_name'],
//                 $row['full_color'],
//                 $row['black_white'],
//                 $row['color_a3'],
//                 $row['copy'],
//                 $row['print'],
//                 $row['fax'],
//                 $total,
//                 $row['date']
//             );
            
//             $arr_data[] = $data;
//         }
        
//     }
    
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => $total_found_rows,
//         'iTotalDisplayRecords' => $total_found_rows,
//         'aaData' => $arr_data
//     );
    
//     echo json_encode($arr_result);
// }

function get_report_celcom($filter, $year, $telco_type){
    global $conn_admin_db;
    $monthto = 12;
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    
    $sql_query = "SELECT id,account_no,user,position FROM bill_telco_account";
    if(!empty($filter)){
        $sql_query .= " WHERE company_id = '".$filter."' ";
    }
    if(!empty($telco_type)){
        $sql_query .=" AND telco_type='$telco_type'";
    }
        
    $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
    
    while ($row = mysqli_fetch_assoc($rst)) {
        $acc_id = $row['id'];
        $arr_bills = get_monthly_bill_celcom($acc_id, $year, $monthto);
        $arr_bills_monthly[$acc_id] = $arr_bills;
    }
    $total_found_rows = 0;
    $arr_data = array();
    $count = 0;
    foreach ($arr_bills_monthly as $id => $data){
//         if(array_sum($data)){
//             $count++;
            $total_found_rows++;
            $user = itemName("SELECT user FROM bill_telco_account  WHERE id='$id'");
            $position = itemName("SELECT position FROM bill_telco_account  WHERE id='$id'");
            $acc_no = itemName("SELECT account_no FROM bill_telco_account  WHERE id='$id'");
            $hp_no = itemName("SELECT hp_no FROM bill_telco_account  WHERE id='$id'");
            $total = 0;
            for( $i=1; $i<=$monthto; $i++){
                $total += $data[$i];
            }
            
            $datas = array(
                $user,
                $position,
                $hp_no,
                $acc_no,
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $total
                
            );
            $arr_data[] = $datas;
//         }        
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

// function get_report_jabatan_air($filter, $year){
//     global $conn_admin_db;
//     $query = "SELECT (DATE_FORMAT(date_end,'%M')) month_name, meter_reading_from, meter_reading_to, 
//             (meter_reading_to - meter_reading_from) AS total_usage, usage_70, rate_70,usage_71, rate_71,credit_adjustment, 
//             adjustment,date_start, date_end,amount,due_date, cheque_no,paid_date  FROM bill_jabatan_air
//             INNER JOIN bill_account_setup ON bill_account_setup.acc_id = bill_jabatan_air.acc_id WHERE bill_jabatan_air.acc_id = '$filter' AND DATE_FORMAT(date_end,'%Y') = '$year'";
    
//     $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => 0,
//         'iTotalDisplayRecords' => 0,
//         'aaData' => array()
//     );
//     $total_found_rows = 0;
//     $arr_data = array();
//     if ( mysqli_num_rows($rst) ){
//         while( $row = mysqli_fetch_assoc( $rst ) ){
//             $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
//             $total_found_rows = $row_found[0];
            
//             $data = array(
//                 $row['month_name'],
//                 $row['meter_reading_from'],
//                 $row['meter_reading_to'],
//                 $row['total_usage'],
//                 $row['usage_70'],
//                 $row['rate_70'],
//                 $row['usage_71'],
//                 $row['rate_71'],
//                 $row['credit_adjustment'],
//                 $row['adjustment'],
//                 $row['date_start'],
//                 $row['date_end'],
//                 $row['cheque_no'],
//                 $row['paid_date'],
//                 $row['amount']
//             );
            
//             $arr_data[] = $data;
//         }
        
//     }
    
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => $total_found_rows,
//         'iTotalDisplayRecords' => $total_found_rows,
//         'aaData' => $arr_data
//     );
    
//     echo json_encode($arr_result);
// }

// function get_report_sesb($filter, $year){
//     global $conn_admin_db;
    
//     $query = "SELECT (DATE_FORMAT(date_end,'%M')) month_name, meter_reading_from, meter_reading_to, 
//             total_usage, current_usage, kwtbb, penalty,power_factor,additional_deposit, other_charges,adjustment,date_start, date_end,
//             amount,due_date, cheque_no,paid_date  FROM bill_sesb
//             INNER JOIN bill_account_setup ON bill_account_setup.acc_id = bill_sesb.acc_id WHERE bill_sesb.acc_id = '$filter' AND DATE_FORMAT(date_end,'%Y') = '$year'";
    
    
//     $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => 0,
//         'iTotalDisplayRecords' => 0,
//         'aaData' => array()
//     );
//     $total_found_rows = 0;
//     $arr_data = array();
//     if ( mysqli_num_rows($rst) ){
//         while( $row = mysqli_fetch_assoc( $rst ) ){
//             $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
//             $total_found_rows = $row_found[0];
            
//             $data = array(
//                 $row['month_name'],
//                 $row['meter_reading_from'],
//                 $row['meter_reading_to'],
//                 $row['total_usage'],
//                 $row['current_usage'],
//                 $row['kwtbb'],
//                 $row['penalty'],
// //                 $row['power_factor'],
//                 $row['additional_deposit'],
//                 $row['other_charges'],
//                 $row['adjustment'],
//                 $row['date_start'],
//                 $row['date_end'],
//                 $row['amount'],
//                 $row['due_date'],
//                 $row['cheque_no'],
//                 $row['paid_date']
//             );
            
//             $arr_data[] = $data;
//         }
        
//     }

//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => $total_found_rows,
//         'iTotalDisplayRecords' => $total_found_rows,
//         'aaData' => $arr_data
//     );
    
//     echo json_encode($arr_result);
// }

function get_monthly_bill_telekom($filter, $year){
    global $conn_admin_db;
    $monthto = 12;
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $sql_query = "SELECT id,account_no,owner FROM bill_telekom_account";
    if(!empty($filter)){
        $sql_query .= " WHERE company_id = '".$filter."' ";
    }
    $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
    
    while ($row = mysqli_fetch_assoc($rst)) {
        $acc_id = $row['id'];
        $arr_bills = get_telekom_monthly_bill($acc_id, $year, $monthto);
        $arr_bills_monthly[$acc_id] = $arr_bills;
    }
    $total_found_rows = 0;
    $arr_data = array();
    $count = 0;
    foreach ($arr_bills_monthly as $id => $data){
        if(array_sum($data) !=0){
            $count++;
            $total_found_rows++;
            $acc_no = itemName("SELECT account_no FROM bill_telekom_account  WHERE id='$id'");
            $owner = itemName("SELECT owner FROM bill_telekom_account WHERE id='$id'");
            $company = itemName("SELECT code FROM company WHERE id IN (SELECT company_id FROM bill_telekom_account WHERE bill_telekom_account.id='$id' )");
            $total = 0;
            for( $i=1; $i<=$monthto; $i++){
                $total += $data[$i];
            }
            
            $datas = array(
                $acc_no,
                $company,
                $owner,
                $data[1],
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                $data[11],
                $data[12],
                $total
                
            );
            $arr_data[] = $datas;            
        }        
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function get_telekom_monthly_bill($acc_id, $year, $monthto){ // telekom
    $result = array();
    
    for($m = 1; $m <= $monthto; $m++){        
        $amount = itemName("SELECT amount FROM bill_telekom WHERE acc_id='$acc_id' AND year(date_end)='$year' AND month(date_end)='$m'");
        $result[$m] = $amount;
    }
    
    return $result;
}

function get_monthly_bill_celcom($acc_id, $year, $monthto){
    $result = array();
    
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT amount_rm FROM bill_telco_billing WHERE telco_acc_id='$acc_id' AND year(date)='$year' AND month(date)='$m'");
        $result[$m] = $amount;
    }
    return $result;
}

function get_monthly_bill_fx($acc_id, $year, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT amount FROM bill_fuji_xerox_invoice WHERE acc_id='$acc_id' AND year(invoice_date)='$year' AND month(invoice_date)='$m'");
        $result[$m] = $amount;
    }
    return $result;
}

function get_monthly_bill_jabatan_air($acc_id, $year, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT amount FROM bill_jabatan_air WHERE acc_id='$acc_id' AND year(date_end)='$year' AND month(date_end)='$m'");
        $result[$m] = $amount;
    }
    return $result;
}

function get_monthly_bill_sesb($acc_id, $year, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT amount FROM bill_sesb WHERE acc_id='$acc_id' AND year(date_end)='$year' AND month(date_end)='$m'");
        $result[$m] = $amount;
    }
    return $result;
}

//breakdown function for telekom
function get_telekom_bill($acc_id, $year, $monthto){
    global $conn_admin_db;
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
    
    $arr_data['Monthly Fee'] = get_monthly_fee($acc_id,$monthto);
    $arr_data['Rebate'] = get_rebate($acc_id,$monthto);
    $arr_data['Credit Adjustment'] = get_credit_adjustment($acc_id,$monthto);
    $arr_data['GST/SST %'] = get_gst_sst($acc_id,$monthto);
    $arr_data['Adjustment'] = get_adjustment($acc_id,$monthto);
    $arr_data['Total (RM)'] = get_total($acc_id,$monthto);
    $arr_data['Payment Due Date'] = get_payment_due_date($acc_id,$monthto);
    $arr_data['Cheque No'] = get_cheque_no($acc_id,$monthto);
    $arr_data['Payment Date'] = get_payment_date($acc_id,$monthto);
    
    return $arr_data;
}

function get_monthly_fee($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT monthly_bill FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = number_format($amount,2);
    }
    return $result;
}
function get_rebate($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT rebate FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = number_format($amount,2);
    }
    return $result;
}
function get_credit_adjustment($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT credit_adjustment FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = number_format($amount,2);
    }
    return $result;
}
function get_gst_sst($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT gst_sst FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = number_format($amount,2);
    }
    return $result;
}
function get_adjustment($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT adjustment FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = number_format($amount,2);
    }
    return $result;
}
function get_total($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT amount FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = number_format($amount,2);
    }
    return $result;
}
function get_payment_due_date($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $due_date = itemName("SELECT due_date FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $due_date;
    }
    return $result;
}
function get_cheque_no($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $cheque_no = itemName("SELECT cheque_no FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $cheque_no;
    }
    return $result;
}
function get_payment_date($acc_id, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $paid_date = itemName("SELECT paid_date FROM bill_telekom WHERE MONTH(date_start) = '$m' AND acc_id='$acc_id'");
        $result[$m] = $paid_date;
    }
    return $result;
}

function get_bill_monthly($tel_no, $monthto){
    $result = array();
    for($m = 1; $m <= $monthto; $m++){
        $amount = itemName("SELECT usage_amt FROM bill_telefon_list
                    INNER JOIN bill_telekom ON bill_telekom.id = bill_telefon_list.bt_id
                    WHERE month(date_start)='$m' AND tel_no LIKE '%$tel_no%'");
        $result[$m] = number_format($amount,2);
    }
    
    return $result;    
}



?>