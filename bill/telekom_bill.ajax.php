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
$telefon_list = isset($_POST['telefon_list']) ? $_POST['telefon_list'] : "";
$acc_id = isset($_POST['acc_id']) ? $_POST['acc_id'] : "";
$company = isset($_POST['company']) ? $_POST['company'] : "";

if( $action != "" ){
    switch ($action){
        case 'add_new_account':
            add_new_account($data, $telefon_list);
            break;
            
        case 'update_account':
            update_account($data);
            break;
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
            
        case 'add_new_telefon':
            add_new_telefon($acc_id, $telefon_list);
            break;
            
        case 'retrieve_telefon_list':
            retrieve_telefon_list($acc_id);
            break;
            
        case 'add_new_bill':
            add_new_bill($data);
            break;
            
        case 'get_account':
            get_account($company);
            break;
            
        case 'compare_data':
            compare_data($data);
            break;
            
        case 'retrieve_item_data':
            retrieve_item_data($id);
            break;
            
        case 'update_bill':
            update_bill($data);
            break;
            
        case 'delete_item_data':
            delete_item_data($id);
            
        default:
            break;
    }
}

function delete_item_data($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_telekom SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        echo json_encode($result);        
    }
}

function retrieve_item_data($id){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_telekom WHERE id='$id'";
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc($result);    
    //retrieve telephone usage
    $tel_usage = get_telefon_usage($row['id']);

    $arr_data = array(
        'row_data' => $row,
        'tel_usage' => $tel_usage
    );
    echo json_encode($arr_data);
}

function get_telefon_usage($bt_id){
    global $conn_admin_db;
    $query = "SELECT bill_telefon_usage.id, usage_rm, tel_no, phone_type FROM bill_telefon_usage 
            INNER JOIN bill_telefon_list ON bill_telefon_list.id = bill_telefon_usage.telefon_id
            WHERE bill_telefon_usage.bt_id='".$bt_id."'";  

    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    
    return $data;
}
function get_telekom_data_monthly_compare($year, $company, $account_no){
    global $conn_admin_db;
    global $month_map;
    $month = 12;
    $query = "SELECT * FROM bill_telekom_account
        INNER JOIN bill_telekom ON bill_telekom_account.id = bill_telekom.acc_id
        WHERE YEAR(date_end)='$year' AND status='1'";
    
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    if(!empty($account_no)){
        $query .=" AND bill_telekom_account.id = '$account_no'";
    }
    
    $query .= " ORDER BY date_end ASC";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_telekom = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_telekom[$row['company_id']][] = $row;
    }
    //form array data for telekom monthly
    $month = 12;
    $data_monthly = [];
    if(!empty($company)){
        foreach ($arr_data_telekom as $key => $val){
            $code = itemName("SELECT code FROM company WHERE id='$key'");
            foreach ($val as $v){
                $acc_no = $v['account_no'];
                $date_end = $v['date_end'];
                $telekom_month = date_parse_from_format("Y-m-d", $date_end);
                $t_m = $telekom_month["month"];
                for ( $m=1; $m<=$month; $m++ ){
                    if($m == $t_m){
                        if(!empty($account_no)){
                            if (isset($data_monthly[$code][$acc_no."-".$year][$m])){
                                $data_monthly[$code][$acc_no."-".$year][$m] += (double)$v['amount'];
                            }else{
                                $data_monthly[$code][$acc_no."-".$year][$m] = (double)$v['amount'];
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
    }
    //telekom monthly
    foreach ($data_monthly as $code => $data){
        if(!empty($account_no)){
            foreach ($data as $acc_no => $val){
                $month_data = array_replace($month_map, $val);
                $datasets_telekom_monthly = array(
                    'label' => $acc_no,
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
            $datasets_telekom_monthly = array(
                'label' => $code,
                'backgroundColor' => 'transparent',
                'borderColor' => randomColor(),
                'lineTension' => 0,
                'borderWidth' => 3,
                'data' => array_values($month_data)
            );
        }
    }
    
    return $datasets_telekom_monthly;
    
}

function compare_data($data){
    global $conn_admin_db;
    $arr_data = [];
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $year = $param['year_select'];
        $company = $param['company'];
        $account_no = $param['account_no'];
        $count = count($year); //get the array count
        for($i=1; $i<=$count; $i++){
            $result = get_telekom_data_monthly_compare($year[$i], $company[$i], $account_no[$i]);
            if(!empty($result) && $result != NULL){
                $arr_data[] = $result;
            }
        }
    }
    
    echo json_encode($arr_data);
}

function get_account($company){
    global $conn_admin_db;
    $query = "SELECT id,UPPER(account_no) as account_no FROM bill_telekom_account WHERE company_id='$company' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query);
    $acc_arr = array();
    $acc_list = [];
    if(mysqli_num_rows($result) > 0){
        while( $row = mysqli_fetch_array($result) ){
            $acc_arr[$row['id']] = $row['account_no'];
            $acc_list = $acc_arr;
        }
        $arr_result[$company] = $acc_list;
    }
    
    $result = array(
        'result' => $arr_result
    );    
    // encoding array to json format
    echo json_encode($result);
}
function update_account($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    $acc_id = $param['id'];
    $company =  mysqli_real_escape_string( $conn_admin_db,$param['company_edit']);
    $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no_edit']);
    $location =  mysqli_real_escape_string( $conn_admin_db,$param['location_edit']);
    $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner_edit']);
    $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark_edit']);
    $ref_no =  mysqli_real_escape_string( $conn_admin_db,$param['ref_no_edit']);
    $service_no =  mysqli_real_escape_string( $conn_admin_db,$param['service_no_edit']);
    
    $query = "UPDATE bill_telekom_account SET
                        company_id='$company',
                        account_no='$acc_no',
                        owner='$owner',
                        remark='$remark',
                        ref_no='$ref_no',
                        location='$location',
                        service_no='$service_no' WHERE id='$acc_id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function update_bill($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data 
    
    $id = $param['id'];
    $tel_count = $param['tel_count_edit'];
    $from_date = dateFormat($param['from_date_edit']);
    $to_date = dateFormat($param['to_date_edit']);
    $paid_date = dateFormat($param['paid_date_edit']);
    $due_date = dateFormat($param['due_date_edit']);
    $bill_no = $param['bill_no_edit'];
    $monthly_fee = $param['monthly_fee_edit'];
    $cr_adj = $param['cr_adjustment_edit'];
    $rebate = $param['rebate_edit'];
    $cheque_no = $param['cheque_no_edit'];
    $other_charges = $param['other_charges_edit'];
    $phone_data = [];
    $total_phone_usage = 0;
    for ($i=1; $i <= $tel_count; $i++){
        $total_phone_usage += $param['name_'.$i];
        $phone_data[$param['phone_'.$i]] = $param['name_'.$i];
    }
    
    $gst_sst = number_format(($monthly_fee + $other_charges + $total_phone_usage) * 6/100, 2);
    $amount = $monthly_fee + $other_charges + $total_phone_usage + $gst_sst + $rebate + $cr_adj;
    $rounded = round_up($amount);
    $adjustment = number_format(($rounded-$amount), 2);
    $total_amt = $amount + $adjustment;
    $query = "UPDATE bill_telekom SET 
            bill_no='$bill_no',
            cheque_no='$cheque_no', 
            date_start='$from_date', 
            date_end='$to_date', 
            paid_date='$paid_date', 
            due_date='$due_date', 
            monthly_bill='$monthly_fee', 
            credit_adjustment='$cr_adj',
            gst_sst='$gst_sst', 
            amount='$total_amt', 
            rebate='$rebate', 
            adjustment='$adjustment', 
            other_charges='$other_charges' WHERE id='$id'";
             
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    if(!empty($phone_data) && $result){
        foreach ($phone_data as $key => $value){
            $qry = "UPDATE bill_telefon_usage SET usage_rm='$value' WHERE id='$key'";
            $rst = mysqli_query($conn_admin_db, $qry) or die(mysqli_error($conn_admin_db));
        }
        
        echo json_encode($rst);
    }
}

function add_new_bill($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data 

    $acc_id = $param['acc_id'];
    $tel_count = $param['tel_count'];
    $from_date = dateFormat($param['from_date']);
    $to_date = dateFormat($param['to_date']);
    $paid_date = dateFormat($param['paid_date']);
    $due_date = dateFormat($param['due_date']);
    $bill_no = $param['bill_no'];
    $monthly_fee = $param['monthly_fee'];
    $cr_adj = $param['cr_adjustment'];
    $rebate = $param['rebate'];
    $cheque_no = $param['cheque_no'];
    $other_charges = $param['other_charges'];    
    $phone_usage = [];
    $total_phone_usage = 0;
    for ($i=1; $i <= $tel_count; $i++){
        $total_phone_usage += $param['name_'.$i];
        $phone_usage[$param['phone_'.$i]] = $param['name_'.$i];
    }

    $gst_sst = number_format(($monthly_fee + $other_charges + $total_phone_usage) * 6/100, 2);
    $amount = $monthly_fee + $other_charges + $total_phone_usage + $gst_sst + $rebate + $cr_adj;
    $rounded = round_up($amount);
    $adjustment = number_format(($rounded-$amount), 2);
    $total_amt = $amount + $adjustment;
    $query = "INSERT INTO bill_telekom (acc_id, bill_no, cheque_no, date_start, date_end, paid_date, due_date, monthly_bill, credit_adjustment,gst_sst, amount, rebate, adjustment, other_charges)
             VALUES('$acc_id','$bill_no', '$cheque_no','$from_date', '$to_date','$paid_date', '$due_date', '$monthly_fee', '$cr_adj','$gst_sst','$total_amt', '$rebate', '$adjustment','$other_charges')";

    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $last_insert_id = mysqli_insert_id($conn_admin_db);
    if(!empty($phone_usage) && $result){
        $value = [];
        foreach ($phone_usage as $telefon_id => $telefon_usage){
            $value[] = "('$telefon_id', '$last_insert_id', '$to_date',now(), '$telefon_usage')";
        }
        $values = implode(",", $value);
        $qry = "INSERT INTO bill_telefon_usage (telefon_id, bt_id, date, date_added, usage_rm) VALUES".$values;
        
        $rst = mysqli_query($conn_admin_db, $qry) or die(mysqli_error($conn_admin_db));
        
        echo json_encode($rst);
    }
    
}

function retrieve_telefon_list($acc_id){
    global $conn_admin_db;
    $query = "SELECT * FROM bill_telefon_list WHERE acc_id='$acc_id' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function add_new_telefon($acc_id, $telefon_list){
    global $conn_admin_db;
    foreach ($telefon_list as $tel){
        $telefon = $tel['telefon'];
        $type = $tel['type'];
        
        
        $values[] = "('$acc_id', '$telefon', '$type')";
        
    }
    
    $values = implode(",", $values);
    $query = "INSERT INTO bill_telefon_list (acc_id, tel_no, phone_type) VALUES" .$values;
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function add_new_account($data, $telefon_list){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data        
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location']);
        $owner =  mysqli_real_escape_string( $conn_admin_db,$param['owner']);
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        $ref_no =  mysqli_real_escape_string( $conn_admin_db,$param['ref_no']);
        $service_no =  mysqli_real_escape_string( $conn_admin_db,$param['service_no']);
        
        $query_insert_telekom = "INSERT INTO bill_telekom_account SET
                        company_id='$company',
                        account_no='$acc_no',
                        owner='$owner',
                        remark='$remark',
                        ref_no='$ref_no',
                        location='$location',
                        service_no='$service_no'";
        
        mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));
        
        $last_insert_id = mysqli_insert_id($conn_admin_db);
        
        $values = [];
        if(!empty($telefon_list)){
            foreach ($telefon_list as $tel){
                $telefon = $tel['telefon'];
                $type = $tel['type'];                
                
                $values[] = "('$last_insert_id', '$telefon', '$type')";
                
            }
            
            $values = implode(",", $values);
            $query = "INSERT INTO bill_telefon_list (bt_id, tel_no, phone_type) VALUES" .$values;
            mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        }        
    }    
}
function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_telekom_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_telekom_account SET status = 0 WHERE id = '".$id."' ";
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