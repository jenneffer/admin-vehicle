<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();
//initialise monthly value
$month_map = array(
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
    9 => 0,
    10 => 0,
    11 => 0,
    12 => 0
);
$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 
$id = isset($_POST['id']) ? $_POST['id'] : "";
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date("01-m-Y");
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date("t-m-Y");
$date_start_rq = isset($_POST['date_start_rq']) ? $_POST['date_start_rq'] : date("01-m-Y");
$date_end_rq = isset($_POST['date_end_rq']) ? $_POST['date_end_rq'] : date("t-m-Y");
$company = isset($_POST['company']) ? $_POST['company'] : "";
$str_inv_id = isset($_POST['str_inv_id']) ? $_POST['str_inv_id'] : "";

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
            display_invoice_list($date_start, $date_end, $company);
            break;
            
        case 'get_location':
            get_location($company);
            break;
            
        case 'compare_data':
            compare_data($data);
            break;
            
        case 'update_payment_request':
            update_payment_request($str_inv_id);
            break;
            
        case 'payment_request_list':
            payment_request_list($date_start, $date_end);
            break;
        default:
            break;
    }
}

function payment_request_list($date_start, $date_end){
    global $conn_admin_db;
    $query = "SELECT bill_fx_payment_request_list.id AS id, company_id, acc_id, payment_rq_date, SUM(amount) AS amount FROM bill_fuji_xerox_invoice
        INNER JOIN bill_fx_payment_request_list ON bill_fuji_xerox_invoice.payment_rq_id = bill_fx_payment_request_list.id 
        WHERE payment_rq_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'
        GROUP BY bill_fx_payment_request_list.id"; 

    $rst = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
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
            $acc_no = itemName("SELECT acc_no FROM bill_fuji_xerox_account WHERE id='".$row['acc_id']."'");
            $acc_no = '<a href="fx_print.php?company_id='.$row['company_id'].'&payment_rq_id='.$row['id'].'">'.$acc_no.'</a>';
            $data = array(
                $acc_no,
                $company,
                dateFormatRev($row['payment_rq_date']),
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

function update_payment_request($str_inv_id){
    global $conn_admin_db;
    $arr_inv_id = [];
    
    //insert into bill_fx_payment_request_list
    $qry = "INSERT INTO bill_fx_payment_request_list SET payment_rq_date=NOW()";
    $rst = mysqli_query($conn_admin_db, $qry)or die(mysqli_error($conn_admin_db));
    //get the last id
    $last_insert_id = mysqli_insert_id($conn_admin_db);
    
    if(!empty($str_inv_id)){
        $arr_inv_id = explode(",", $str_inv_id);
    }    
    $inv_id = implode("','", $arr_inv_id);
    
    $query = "UPDATE bill_fuji_xerox_invoice SET status='1', payment_rq_id='$last_insert_id' WHERE id IN ('".$inv_id."')";
    $result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function get_fx_data_monthly_compare($year, $company, $account_no){
    global $conn_admin_db;
    global $month_map;
    $month = 12;
    $query = "SELECT * FROM bill_fuji_xerox_account
        INNER JOIN bill_fuji_xerox_invoice ON bill_fuji_xerox_account.id = bill_fuji_xerox_invoice.acc_id
        WHERE YEAR(date_added)='$year'";
    
    if(!empty($company)){
        $query .=" AND company='$company'";
    }
    if(!empty($account_no)){
        $query .=" AND bill_fuji_xerox_account.id = '$account_no'";
    }
    
    $query .= " ORDER BY date_added ASC";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_fx = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_fx[$row['company']][] = $row;
    }
    //form array data for roadtax monthly
    $month = 12;
    $data_monthly = [];
    foreach ($arr_data_fx as $key => $val){
        $code = itemName("SELECT code FROM company WHERE id='$key'");
        foreach ($val as $v){
            $location = $v['location'];
            $date_added = $v['date_added'];
            $telco_month = date_parse_from_format("Y-m-d", $date_added);
            $sesb_m = $telco_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $sesb_m){
                    if(!empty($account_no)){
                        if (isset($data_monthly[$code][$location."-".$year][$m])){
                            $data_monthly[$code][$location."-".$year][$m] += (double)$v['amount'];
                        }else{
                            $data_monthly[$code][$location."-".$year][$m] = (double)$v['amount'];
                        }
                    }
                    else{
                        if (isset($data_monthly[$code."-".$year][$m])){
                            $data_monthly[$code."-".$year][$m] += (double)$v['amount'];
                        }else{
                            $data_monthly[$code."-".$year][$m] = (double)$v['amount'];
                        }
                    }
                }
            }
        }
    }
    
    //sesb monthly
    $datasets_fx_monthly = [];
    foreach ($data_monthly as $code => $data){
        if(!empty($account_no)){
            foreach ($data as $location => $val){
                $month_data = array_replace($month_map, $val);
                $datasets_fx_monthly = array(
                    'label' => $location,
                    'backgroundColor' => 'transparent',
                    'borderColor' => randomColor(),
                    'lineTension' => 0,
                    'borderWidth' => 3,
                    'data' => array_values($month_data)
                );
            }
        }
        else{
            $month_data = array_replace($month_map, $data);
            $datasets_fx_monthly = array(
                'label' => $code,
                'backgroundColor' => 'transparent',
                'borderColor' => randomColor(),
                'lineTension' => 0,
                'borderWidth' => 3,
                'data' => array_values($month_data)
            );
        }
        
    }
    
    return $datasets_fx_monthly;
    
}
function compare_data($data){
    global $conn_admin_db;
    $arr_data = [];
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $year = $param['year_select'];
        $company = $param['company'];
        $location = $param['location'];
        $count = count($year); //get the array count
        for($i=1; $i<=$count; $i++){
            $result = get_fx_data_monthly_compare($year[$i], $company[$i], $location[$i]);
            if(!empty($result) && $result != NULL){
                $arr_data[] = $result;
            }
        }
    }
    
    echo json_encode($arr_data);
}

function get_location($company){
    global $conn_admin_db;
    $query = "SELECT id,UPPER(location) AS location FROM bill_fuji_xerox_account WHERE company='$company' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $location_arr = array();
    $location_list = [];
    $arr_result = [];
    if(mysqli_num_rows($result) > 0){
        while( $row = mysqli_fetch_array($result) ){
            $location_arr[$row['id']] = $row['location'];
            $location_list = $location_arr;
        }
        $arr_result[$company] = $location_list;
    }
    $result = array(
        'result' => $arr_result
    );
    
    // encoding array to json format
    echo json_encode($result);
}

function display_invoice_list($date_start, $date_end, $company_id){
    global $conn_admin_db;
    $qry = "SELECT bfi.id, company_id, invoice_date, invoice_no, particular, amount, serial_no, acc_no FROM bill_fuji_xerox_invoice bfi
            INNER JOIN bill_fuji_xerox_account bfa ON bfa.id = bfi.acc_id
            WHERE invoice_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND bfi.status !='1'";
    if(!empty($company_id)){
        $qry .=" AND company_id='$company_id'";
    }
    
    $qry .=" ORDER BY date_added";

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
            $checkbox = "<input type='checkbox' name='inv_id[]' value='".$row['id']."'>";
            $data = array(
                $checkbox,
                $company,
                $row['invoice_date'],
                $row['invoice_no'],
                $row['particular'],                
                $row['serial_no'],
                $row['acc_no'],
                number_format($row['amount'],2),
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
       
       $result = mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));   
       echo json_encode($result);
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
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
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
        
        $result = mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db)); 
        echo json_encode($result);
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