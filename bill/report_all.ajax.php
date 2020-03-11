<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$filter = isset($_POST['filter']) ? $_POST['filter'] : "";

if( $action != "" ){
    switch ($action){
        case 'report_sesb':   
            get_report_sesb($filter);
            break;
        case 'report_jabatan_air':
            get_report_jabatan_air($filter);
            break;
        case 'report_celcom':
            get_report_celcom($filter);
            break;
        default:
            break;
    }
}

function get_report_celcom($filter){
    global $conn_admin_db;
    $query = "";
}

function get_report_jabatan_air($filter){
    global $conn_admin_db;
    $query = "SELECT (DATE_FORMAT(date_end,'%M')) month_name, meter_reading_from, meter_reading_to, 
            (meter_reading_to - meter_reading_from) AS total_usage, usage_70, rate_70,usage_71, rate_71,credit_adjustment, 
            adjustment,date_start, date_end,amount,due_date, cheque_no,paid_date  FROM bill_jabatan_air
            INNER JOIN bill_account_setup ON bill_account_setup.acc_id = bill_jabatan_air.acc_id WHERE bill_jabatan_air.acc_id = '$filter' ";
    
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
                $row['meter_reading_from'],
                $row['meter_reading_to'],
                $row['total_usage'],
                $row['usage_70'],
                $row['rate_70'],
                $row['usage_71'],
                $row['rate_71'],
                $row['credit_adjustment'],
                $row['adjustment'],
                $row['date_start'],
                $row['date_end'],
                $row['cheque_no'],
                $row['paid_date'],
                $row['amount']
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

function get_report_sesb($filter){
    global $conn_admin_db;
    
    $query = "SELECT (DATE_FORMAT(date_end,'%M')) month_name, meter_reading_from, meter_reading_to, 
            total_usage, current_usage, kwtbb, penalty,power_factor,additional_deposit, other_charges,adjustment,date_start, date_end,
            amount,due_date, cheque_no,paid_date  FROM bill_sesb
            INNER JOIN bill_account_setup ON bill_account_setup.acc_id = bill_sesb.acc_id WHERE bill_sesb.acc_id = '$filter'";
    
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
                $row['meter_reading_from'],
                $row['meter_reading_to'],
                $row['total_usage'],
                $row['current_usage'],
                $row['kwtbb'],
                $row['penalty'],
//                 $row['power_factor'],
                $row['additional_deposit'],
                $row['other_charges'],
                $row['adjustment'],
                $row['date_start'],
                $row['date_end'],
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

?>