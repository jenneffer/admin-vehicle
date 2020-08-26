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
$company = isset($_POST['company']) ? $_POST['company'] : "";
$count = isset($_POST['count']) ? $_POST['count'] : 0;

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
            
        case 'get_location':
            get_location($company);
            break;
            
        case 'delete_account_details_item':
            delete_account_details_item($id);
            break;
            
        case 'retrieve_account_details':
            retrieve_account_details($id);
            break;
            
        case 'update_account_details':
            update_account_details($data);
            break;
            
        case 'compare_data':
            compare_data($data,$count);
            break;
        default:
            break;
    }
}

function get_ja_data_monthly_compare($year, $company, $location){
    global $conn_admin_db;
    global $month_map;
    $month = 12;
    $query = "SELECT * FROM bill_jabatan_air_account
    INNER JOIN bill_jabatan_air ON bill_jabatan_air_account.id = bill_jabatan_air.acc_id
    WHERE YEAR(date_end)='$year'";
    
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    if(!empty($location)){
        $query .=" AND bill_jabatan_air_account.id = '$location'";
    }
    
    $query .= " ORDER BY date_end ASC";

    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_data_ja = []; //show all company
    $data_monthly = [];
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_ja[$row['company_id']][] = $row;
    } 
    foreach ($arr_data_ja as $key => $val){
        $code = itemName("SELECT code FROM company WHERE id='$key'");
        foreach ($val as $v){
            $loc = $v['location'];
            $date_end = $v['date_end'];
            $ja_month = date_parse_from_format("Y-m-d", $date_end);
            $ja_m = $ja_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ja_m){
                    if(!empty($location)){
                        if (isset($data_monthly[$code."-".$year][$loc][$m])){
                            $data_monthly[$code."-".$year][$loc][$m] += (double)$v['amount'];
                        }else{
                            $data_monthly[$code."-".$year][$loc][$m] = (double)$v['amount'];
                        }
                    }else{
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
    if (!empty($data_monthly)) {
        foreach ($data_monthly as $code => $data){
            if(!empty($location)){
                foreach ($data as $location => $val){
                    $month_data = array_replace($month_map, $val);
                    $datasets_ja_monthly = array(
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
                $datasets_ja_monthly = array(
                    'label' => $code,
                    'backgroundColor' => 'transparent',
                    'borderColor' => randomColor(),
                    'lineTension' => 0,
                    'borderWidth' => 3,
                    'data' => array_values($month_data)
                );
            }
        }
        return $datasets_ja_monthly;
    }
}

function compare_data($data, $count){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $year = $param['year_select'];
        $company = $param['company'];
        $location = $param['location'];
        $count = count($year); //get the array count        
        for($i=1; $i<=$count; $i++){  
            $result = get_ja_data_monthly_compare($year[$i], $company[$i], $location[$i]);
            if(!empty($result) && $result != NULL){
                $arr_data[] = $result;
            }
            
        }
    } 
    echo json_encode($arr_data);
}

function update_account_details($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $id = $param['id'];
        $cheque_no = isset($param['cheque_no_edit']) ? $param['cheque_no_edit'] : "";
        $from_date = isset($param['from_date_edit']) ? $param['from_date_edit'] : "";
        $to_date = isset($param['to_date_edit']) ? $param['to_date_edit'] : "";
        $paid_date = isset($param['paid_date_edit']) ? $param['paid_date_edit'] : "";
        $due_date = isset($param['due_date_edit']) ? $param['due_date_edit'] : "";
        $acc_id = isset($param['acc_id_edit']) ? $param['acc_id_edit'] : "";
        $read_from = isset($param['read_from_edit']) ? $param['read_from_edit'] : "";
        $read_to = isset($param['read_to_edit']) ? $param['read_to_edit'] : "";
        $usage_1 = isset($param['usage_1_edit']) ? $param['usage_1_edit'] : 0;
        $usage_2 = isset($param['usage_2_edit']) ? $param['usage_2_edit'] : 0;
        $rate_1 = isset($param['rate_1_edit']) ? $param['rate_1_edit'] : 0;
        $rate_2 = isset($param['rate_2_edit']) ? $param['rate_2_edit'] : 0;
        $credit = isset($param['credit_adj_edit']) ? $param['credit_adj_edit'] : 0;
        $rate_70 = $usage_1 * $rate_1;
        $rate_71 = $usage_2 * $rate_2;
        $amount = $rate_70 + $rate_71;
        $rounded = round_up($amount);
        $adjustment = number_format(($rounded-$amount), 2);
        $total_amt = $amount + $adjustment + $credit;
        
        $query = "UPDATE bill_jabatan_air
                    SET meter_reading_from = '$read_from',
                    meter_reading_to = '$read_to',
                    usage_70 = '$usage_1',
                    usage_71 = '$usage_2',
                    rate_1 = '$rate_1',
                    rate_2 = '$rate_2',
                    rate_70 = '$rate_70',
                    rate_71 = '$rate_71',
                    credit_adjustment = '$credit',
                    amount = '$total_amt',
                    adjustment = '$adjustment',
                    cheque_no = '$cheque_no',
                    date_start = '".dateFormat($from_date)."',
                    date_end = '".dateFormat($to_date)."',
                    paid_date = '".dateFormat($paid_date)."',
                    due_date = '".dateFormat($due_date)."' WHERE id='$id'";
       
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($query));
        echo json_encode($result);
    }
}

function retrieve_account_details($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "SELECT * FROM bill_jabatan_air WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account_details_item($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "DELETE FROM bill_jabatan_air WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "jabatan_air_setup.php");
        }
    }
}

function get_location($company){
    global $conn_admin_db;
    $query = "SELECT id,UPPER(location) AS location_name FROM bill_jabatan_air_account WHERE company_id='$company' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query);
    $location_arr = array();
    $location_list = [];
    if(mysqli_num_rows($result) > 0){
        while( $row = mysqli_fetch_array($result) ){
            $location_arr[$row['id']] = $row['location_name'];
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

function add_new_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data       
        $cheque_no = $param['cheque_no'];
        $from_date = $param['from_date'];
        $to_date = $param['to_date'];
        $paid_date = $param['paid_date'];
        $due_date = $param['due_date'];
        $acc_id = $param['acc_id'];
        $read_from = $param['read_from'];
        $read_to = $param['read_to'];
        $usage_1 = $param['usage_1'];
        $usage_2 = $param['usage_2'];
        $rate_1 = $param['rate_1'];
        $rate_2 = $param['rate_2'];
        $credit = $param['credit'];
        $rate_70 = $usage_1 * $rate_1;
        $rate_71 = $usage_2 * $rate_2;
        $amount = $rate_70 + $rate_71;
        $rounded = round_up($amount);
        $adjustment = number_format(($rounded-$amount), 2);
        $total_amt = $amount + $adjustment + $credit;
        
        $query_insert_ja = "INSERT INTO bill_jabatan_air
                    SET acc_id = '$acc_id',
                    meter_reading_from = '$read_from',
                    meter_reading_to = '$read_to',
                    usage_70 = '$usage_1',
                    usage_71 = '$usage_2',
                    rate_1 = '$rate_1',
                    rate_2 = '$rate_2',
                    rate_70 = '$rate_70', 
                    rate_71 = '$rate_71',
                    credit_adjustment = '$credit',
                    amount = '$total_amt',
                    adjustment = '$adjustment',
                    cheque_no = '$cheque_no',
                    date_start = '".dateFormat($from_date)."',
                    date_end = '".dateFormat($to_date)."',
                    paid_date = '".dateFormat($paid_date)."',
                    due_date = '".dateFormat($due_date)."'";
       
        $result = mysqli_query($conn_admin_db, $query_insert_ja) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }   
}

function add_new_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location']);
        $deposit =  mysqli_real_escape_string( $conn_admin_db,$param['deposit']);
        $tariff =  mysqli_real_escape_string( $conn_admin_db,$param['tariff']);
        $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner']);        
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        $jenis_bacaan =  mysqli_real_escape_string( $conn_admin_db,$param['jenis_bacaan']);
        $jenis_premis =  mysqli_real_escape_string( $conn_admin_db,$param['jenis_premis']);
        
        $query = "INSERT INTO bill_jabatan_air_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    deposit='$deposit',
                    kod_tariff='$tariff',
                    remark='$remark',                    
                    jenis_bacaan='$jenis_bacaan',
                    jenis_premis='$jenis_premis'";

        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    }
}

function update_account($data){
    
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $id = $param['id'];
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company_edit']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no_edit']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location_edit']);
        $deposit =  mysqli_real_escape_string( $conn_admin_db,$param['deposit_edit']);
        $tariff =  mysqli_real_escape_string( $conn_admin_db,$param['tariff_edit']);
        $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner_edit']);
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark_edit']);
        $jenis_bacaan =  mysqli_real_escape_string( $conn_admin_db,$param['jenis_bacaan_edit']);
        $jenis_premis =  mysqli_real_escape_string( $conn_admin_db,$param['jenis_premis_edit']);
        
        $query = "UPDATE bill_jabatan_air_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    deposit='$deposit',
                    kod_tariff='$tariff',
                    remark='$remark',
                    jenis_bacaan='$jenis_bacaan',
                    jenis_premis='$jenis_premis' WHERE id='$id'";

        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($result);
    }
}

function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_jabatan_air_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_jabatan_air_account SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "sesb_setup.php");
        }
    }
}

//to round up0.05
function round_up($x){
    return round($x * 2, 1) / 2;
}
?>