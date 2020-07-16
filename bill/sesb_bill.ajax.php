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
            
        case 'compare_data':
            compare_data($data);
            break;
            
        case 'get_location':
            get_location($company);
            break;
        default:
            break;
    }
}

function get_location($company){
    global $conn_admin_db;
    $query = "SELECT location,UPPER(location) AS location_name FROM bill_jabatan_air_account WHERE company_id='$company' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query);
    $location_arr = array();
    $location_list = [];
    if(mysqli_num_rows($result) > 0){
        while( $row = mysqli_fetch_array($result) ){
            $location_arr[] = $row['location_name'];
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

function get_sesb_data_monthly_compare($year, $company, $location){
    global $conn_admin_db;
    global $month_map;
    $month = 12;
    $query = "SELECT * FROM bill_sesb_account
    INNER JOIN bill_sesb ON bill_sesb_account.id = bill_sesb.acc_id
    WHERE YEAR(date_end)='$year'";
    
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    if(!empty($location)){
        $query .=" AND bill_sesb_account.location = '$location'";
    }
    
    $query .= " ORDER BY date_end ASC";

    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $data_monthly = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        $code = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
        $loc = $row['location'];
        $date_end = $row['date_end'];
        $sesb_month = date_parse_from_format("Y-m-d", $date_end);
        $sesb_m = $sesb_month["month"];        
        if (!empty($location)){
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $sesb_m){
                    if( $location == $loc){
                        if (isset($data_monthly[$code][$m])){
                            $data_monthly[$code."-".$year][$m] += (double)$row['amount'];
                        }else{
                            $data_monthly[$code."-".$year][$m] = (double)$row['amount'];
                        }
                    }
                }
            }
        }
        else{
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $sesb_m){
                    if (isset($data_monthly[$code][$m])){
                        $data_monthly[$code."-".$year][$m] += (double)$row['amount'];
                    }else{
                        $data_monthly[$code."-".$year][$m] = (double)$row['amount'];
                    }
                }
            }
        }
    }
    if (!empty($data_monthly)) {
        foreach ($data_monthly as $code => $data){
            $month_data = array_replace($month_map, $data);
            $datasets_sesb_monthly = array(
                'label' => $code,
                'backgroundColor' => 'transparent',
                'borderColor' => randomColor(),
                'lineTension' => 0,
                'borderWidth' => 3,
                'data' => array_values($month_data)
            );
        }
        return $datasets_sesb_monthly;
    }    
}

function compare_data($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
     
        $year = $param['year_select'];
        $company = $param['company'];
        $location = $param['location'];
        $count = count($year); //get the array count
        
        for($i=1; $i<=$count; $i++){
            $result = get_sesb_data_monthly_compare($year[$i], $company[$i], $location[$i]);
            if(!empty($result) && $result != NULL){
                $arr_data[] = $result;
            }            
        }
    }

    echo json_encode($arr_data);
}

function update_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $id = $param['id'];
        $company = isset($param['company_edit']) ? $param['company_edit'] :"";
        $acc_no = isset($param['acc_no_edit']) ? $param['acc_no_edit'] :"";
        $location = isset($param['location_edit']) ? $param['location_edit'] :"";
        $deposit = isset($param['deposit_edit']) ? $param['deposit_edit'] :"";
        $tariff = isset($param['tariff_edit']) ? $param['tariff_edit'] : "";
        $owner = isset($param['owner_edit']) ? $param['owner_edit']: "";
        $pic = isset($param['pic_edit']) ? $param['pic_edit'] :"";
        $remark = isset($param['remark_edit']) ? $param['remark_edit']:"";
        
        $query = "UPDATE bill_sesb_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    deposit='$deposit',
                    tarif='$tariff',
                    remark='$remark',
                    person_in_charge='$pic' WHERE id='$id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($result);
    }
}

function add_new_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        
        $cheque_no = isset($param['cheque_no']) ? $param['cheque_no'] : "";
        $from_date = isset($param['from_date']) ? $param['from_date'] : "";
        $to_date = isset($param['to_date']) ? $param['to_date'] : "";
        $paid_date = isset($param['paid_date']) ? $param['paid_date'] : "";
        $due_date = isset($param['due_date']) ? $param['due_date'] : "";
        $acc_id = isset($param['acc_id']) ? $param['acc_id'] : "";
        $reading_from = isset($param['reading_from']) ? $param['reading_from'] : "";
        $reading_to = isset($param['reading_to']) ? $param['reading_to'] : "";
        $current_usage = isset($param['current_usage']) ? $param['current_usage'] : "";
        $kwtbb = isset($param['kwtbb']) ? $param['kwtbb'] : 0;
        $penalty = isset($param['penalty']) ? $param['penalty'] : 0;
        $additional_depo = isset($param['additional_depo']) ? $param['additional_depo'] : 0;
        $other_charges = isset($param['other_charges']) ? $param['other_charges'] : 0;
        $total_usage = $reading_to - $reading_from;
        $power_factor = isset($param['power_factor']) ? $param['power_factor'] : 0;
        $amount = $current_usage + $kwtbb + $penalty + $additional_depo + $other_charges;
        $rounded = round_up($amount);
        $adjustment = number_format(($rounded-$amount), 2);
        $total_amt = $amount + $adjustment;
        
        
        $query_insert_sesb = "INSERT INTO bill_sesb
                        SET acc_id = '$acc_id',
                        meter_reading_from = '$reading_from',
                        meter_reading_to = '$reading_to',
                        total_usage = '$total_usage',
                        current_usage = '$current_usage',
                        kwtbb = '$kwtbb',
                        penalty = '$penalty',
                        power_factor = '$power_factor',
                        additional_deposit = '$additional_depo',
                        other_charges = '$other_charges',
                        amount = '$total_amt',
                        adjustment = '$adjustment',
                        cheque_no = '$cheque_no',
                        date_start = '".dateFormat($from_date)."',
                        date_end = '".dateFormat($to_date)."',
                        paid_date = '".dateFormat($paid_date)."',
                        due_date = '".dateFormat($due_date)."'";           
        mysqli_query($conn_admin_db, $query_insert_sesb) or die(mysqli_error($conn_admin_db));
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
        $pic =  mysqli_real_escape_string( $conn_admin_db,$param['pic']);
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        
        $query = "INSERT INTO bill_sesb_account
                    SET company_id='$company',
                    account_no='$acc_no',
                    owner='$owner',
                    location='$location',
                    deposit='$deposit',
                    tarif='$tariff',
                    remark='$remark',
                    person_in_charge='$pic'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    }
}

function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_sesb_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_sesb_account SET status = 0 WHERE id = '".$id."' ";
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