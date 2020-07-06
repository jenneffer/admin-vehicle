<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 
$id = isset($_POST['id']) ? $_POST['id'] : "";
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date("01-m-Y");
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date("t-m-Y");

if( $action != "" ){
    switch ($action){
        case 'add_new_account':
            add_new_account($data);
            break;
            
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
            
        case 'add_new_bill':
            add_new_bill($data);
            break;
            
        case 'update_account':
            update_account($data);
            break;
            
        case 'add_new_invoice':
            add_new_invoice($data);
            break;
        case 'get_serial_no':
            get_serial_no($id);
            break;
            
        case 'display_invoice_list':
            display_invoice_list($date_start, $date_end);
            break;
            
        default:
            break;
    }
}

function display_invoice_list($date_start, $date_end){
    global $conn_admin_db;
    $qry = "SELECT  MONTHNAME(date_added) AS month_name,YEAR(date_added) AS years,date_added, acc_id,company_id, invoice_date, SUM(amount) amount, serial_no FROM bill_fuji_xerox_invoice bfi
            INNER JOIN bill_fuji_xerox_account bfa ON bfa.id = bfi.acc_id
            WHERE date_added BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'
            GROUP BY company_id,month_name, years
            ORDER BY date_added";

    $rst = mysqli_query($conn_admin_db, $qry) or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $total_found_rows = 0;
    $data_monthly = [];
    if ( mysqli_num_rows($rst) ){
        while ($row = mysqli_fetch_assoc($rst)) {
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];
            $company = itemName("SELECT name FROM company WHERE id='".$row['company_id']."'");
            $serial_no = '<a style="color:blue;" href="fx_print.php?month='.$row['month_name'].'&acc_id='.$row['acc_id'].'&year='.$row['years'].'&date_added='.$row['date_added'].'">'.$row['serial_no'].'</a>';
            $data = array(
                $serial_no,
                $company,
                number_format($row['amount'],2)                
            );
            $data_monthly[] = $data;
        }
    }
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $data_monthly
    );
    
    echo json_encode($arr_result);
}

function get_serial_no($company_id){
    global $conn_admin_db;
    $query = "SELECT id, serial_no FROM bill_fuji_xerox_account WHERE company='$company_id' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query);    
    $serial_arr = array();    
    while( $row = mysqli_fetch_array($result) ){
        $acc_id = $row['id'];
        $descprition = $row['serial_no'];        
        $serial_arr[] = array("id" => $acc_id, "serial_no" => $descprition);
    }    
    // encoding array to json format
    echo json_encode($serial_arr);
}

function add_new_invoice($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data  
        $company_id = isset($param['company_add']) ? $param['company_add'] : "";
        $acc_id = isset($param['serial_no_add']) ? $param['serial_no_add'] : "";
        $inv_date = isset($param['inv_date']) ? dateFormat($param['inv_date']) : "";
        $inv_no = isset($param['inv_no']) ? $param['inv_no'] : "";
        $amount = isset($param['amount']) ? $param['amount'] : "";
        $particular = isset($param['particular']) ? $param['particular'] : "";
        $remark = isset($param['remark_add']) ? $param['remark_add'] : "";
        $added_by = isset($_SESSION['cr_id']) ? $_SESSION['cr_id'] : "";
        
        $query = "INSERT INTO bill_fuji_xerox_invoice (acc_id, company_id,invoice_date, date_added, invoice_no, particular, amount, remark, added_by)
                VALUES ('$acc_id','$company_id', '$inv_date', NOW(), '$inv_no','$particular', '$amount', '$remark','$added_by')";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($result);
    }
}

function update_account($data){
   global $conn_admin_db;
   if (!empty($data)) {
       $param = array();
       parse_str($data, $param); //unserialize jquery string data  
       $company = isset($param['company_edit']) ? $param['company_edit'] : "";
       $serial_no = isset($param['serial_no_edit']) ? $param['serial_no_edit'] : "";
       $acc_no = isset($param['acc_no_edit']) ? $param['acc_no_edit'] : "";
       $location = isset($param['location_edit']) ? $param['location_edit'] : "";
       $remark =  isset($param['remark_edit']) ? $param['remark_edit'] : "";
       $id = isset($param['id']) ? $param['id'] : "";
       
       $query_insert_telekom = "UPDATE bill_fuji_xerox_account SET
                        company='$company',
                        serial_no='$serial_no',
                        acc_no='$acc_no',
                        remark='$remark',
                        location='$location'
                        WHERE id='$id'";
       
       mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));   
   }
}


function add_new_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($_POST['data'], $param); //unserialize jquery string data       
        $acc_id = $param['acc_id'];
        $date_entered = $param['date'];
        $full_color = $param['full_color'];
        $black_white = $param['black_white'];
        $color_a3 = $param['color_a3'];
        $copy = $param['copy'];
        $print = $param['print'];
        $fax = $param['fax'];
        $total = 0;
        if(!empty($full_color) && !empty($black_white)){
            $total = $full_color + $black_white;
        }
        elseif (!empty($copy) || !empty($print) || !empty($fax)){
            $total = $copy + $print + $fax;
        }
        
        $query = "INSERT INTO bill_fuji_xerox SET acc_id = '$acc_id',
            date = '".dateFormat($date_entered)."',
            full_color = '$full_color',
            black_white = '$black_white',
            color_a3 = '$color_a3',
            copy = '$copy',
            print = '$print',
            fax = '$fax',
            total = '$total'";
        
        mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    
    }
    
    
}

function add_new_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data        
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company']);
        $serial_no =  mysqli_real_escape_string( $conn_admin_db,$param['serial_no']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location']);        
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        
        $query_insert_telekom = "INSERT INTO bill_fuji_xerox_account SET
                        company='$company',
                        serial_no='$serial_no',  
                        acc_no='$acc_no',                        
                        remark='$remark',                        
                        location='$location'";
        
        mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));              
    }    
}
function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_fuji_xerox_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_fuji_xerox_account SET status = 0 WHERE id = '".$id."' ";
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