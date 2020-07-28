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
$telco_acc_id = isset($_POST['telco_acc_id']) ? $_POST['telco_acc_id'] : "";
$telefon_list = isset($_POST['telefon_list']) ? $_POST['telefon_list'] : "";
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
            
        case 'add_new_bill':
            add_new_bill($data, $telco_acc_id);
            break;
            
        case 'get_user':
            get_user($company);
            break;
            
        case 'compare_data':
            compare_data($data);
            break;
            
        default:
            break;
    }
}

function update_account($data){
    global $conn_admin_db;
    if(!empty($data)){
        $param = array();
        parse_str($data, $param); //unserialize jquery string data  
        
        $id = $param['id'];
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company_edit']);
        $telco_type =  mysqli_real_escape_string( $conn_admin_db,$param['telco_type_edit']);
        $acc_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no_edit']);
        $position =  mysqli_real_escape_string( $conn_admin_db,$param['position_edit']);
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark_edit']);
        $user =  mysqli_real_escape_string( $conn_admin_db,$param['user_edit']);
        $hp_no =  mysqli_real_escape_string( $conn_admin_db,$param['hp_no_edit']);
        $limit =  mysqli_real_escape_string( $conn_admin_db,$param['limit_edit']);
        $package =  mysqli_real_escape_string( $conn_admin_db,$param['package_edit']);
        $latest_package =  mysqli_real_escape_string( $conn_admin_db,$param['latest_package_edit']);
        $limit_rm =  mysqli_real_escape_string( $conn_admin_db,$param['limit_rm_edit']);
        $data =  mysqli_real_escape_string( $conn_admin_db,$param['data_edit']);
        
        $query = "UPDATE bill_telco_account SET
                        company_id='$company',
                        account_no='$acc_no',
                        position='$position',
                        remark='$remark',
                        hp_no='$hp_no',
                        telco_type='$telco_type',
                        package='$package',
                        latest_package='$latest_package',
                        limit_rm='$limit_rm',
                        data='$data',
                        user='$user',
                        limit_data='$limit' WHERE id='$id'";
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
}

function get_telco_data_monthly_compare($year, $company, $account_no){
    global $conn_admin_db;
    global $month_map;
    $month = 12;
    $query = "SELECT * FROM bill_telco_account
        INNER JOIN bill_telco_billing ON bill_telco_account.id = bill_telco_billing.telco_acc_id
        WHERE YEAR(DATE)='$year'";
    
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    if(!empty($account_no)){
        $query .=" AND bill_telco_account.id = '$account_no'";
    }
    
    $query .= " ORDER BY date ASC";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_telco = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_telco[$row['company_id']][] = $row;
    }
    
    //form array data for roadtax monthly
    $month = 12;
    $data_monthly = [];
    if(!empty($company)){
        foreach ($arr_data_telco as $key => $val){
            $code = itemName("SELECT code FROM company WHERE id='$key'");
            foreach ($val as $v){
                $acc_no = $v['user'];
                $date_end = $v['date'];
                $telco_month = date_parse_from_format("Y-m-d", $date_end);
                $sesb_m = $telco_month["month"];
                for ( $m=1; $m<=$month; $m++ ){
                    if($m == $sesb_m){
                        if(!empty($account_no)){
                            if (isset($data_monthly[$code][$acc_no."-".$year][$m])){
                                $data_monthly[$code][$acc_no."-".$year][$m] += (double)$v['amount_rm'];
                            }else{
                                $data_monthly[$code][$acc_no."-".$year][$m] = (double)$v['amount_rm'];
                            }
                        }
                        else{
                            if (isset($data_monthly[$code."-".$year][$m])){
                                $data_monthly[$code."-".$year][$m] += (double)$v['amount_rm'];
                            }else{
                                $data_monthly[$code."-".$year][$m] = (double)$v['amount_rm'];
                            }
                        }
                        
                    }
                }
            }
        }
    }
    
    //telco monthly
    $datasets_telco_monthly = [];
    foreach ($data_monthly as $code => $data){
        if(!empty($account_no)){
            foreach ($data as $location => $val){
                $month_data = array_replace($month_map, $val);
                $datasets_telco_monthly = array(
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
            $datasets_telco_monthly = array(
                'label' => $code,
                'backgroundColor' => 'transparent',
                'borderColor' => randomColor(),
                'lineTension' => 0,
                'borderWidth' => 3,
                'data' => array_values($month_data)
            );
        }
    }
    
    return $datasets_telco_monthly;
    
}
function compare_data($data){
    global $conn_admin_db;
    $arr_data = [];
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $year = $param['year_select'];
        $company = $param['company'];
        $user = $param['user'];
        $count = count($year); //get the array count
        for($i=1; $i<=$count; $i++){
            $result = get_telco_data_monthly_compare($year[$i], $company[$i], $user[$i]);
            if(!empty($result) && $result != NULL){
                $arr_data[] = $result;
            }
        }
    }
    
    echo json_encode($arr_data);
}

function get_user($company){
    global $conn_admin_db;
    $query = "SELECT id,UPPER(user) AS user_name FROM bill_telco_account WHERE company_id='$company' AND status='1'";
    $result = mysqli_query($conn_admin_db, $query);
    $user_arr = array();
    $user_list = [];
    if(mysqli_num_rows($result) > 0){
        while( $row = mysqli_fetch_array($result) ){
            $user_arr[$row['id']] = $row['user_name'];
            $user_list = $user_arr;
        }
        $arr_result[$company] = $user_list;
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
        $telco_acc_id = $param['telco_acc_id'];
        $date = $param['date_entered'];
        $bill_amount = $param['bill_amount'];
        
        $query = "INSERT INTO bill_telco_billing SET
            telco_acc_id = '$telco_acc_id',
            date='".dateFormat($date)."',
            amount_rm='$bill_amount'";
        
        mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    }    
}

function add_new_account($data, $telefon_list){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data     
        $company =  isset($param['company']) ? $param['company'] : "";
        $telco_type =  isset($param['telco_type']) ? $param['telco_type'] : "";
        $acc_no =  isset($param['acc_no']) ? $param['acc_no'] : "";
        $position =  isset($param['position']) ? $param['position'] : "";
        $remark =  isset($param['remark']) ? $param['remark'] : "";
        $user =  isset($param['user']) ? $param['user'] : "";
        $hp_no =  isset($param['hp_no']) ? $param['hp_no'] : "";
        $limit =  isset($param['limit']) ? $param['limit'] : "";
        $package =  isset($param['package']) ? $param['package'] :"";
        $latest_package =  isset($param['latest_package']) ? $param['latest_package'] : "";
        $limit_rm =  isset($param['limit_rm']) ? $param['limit_rm'] : 0;
        $data =  isset($param['data']) ? $param['data'] : "";
        
        $query = "INSERT INTO bill_telco_account SET
                        company_id='$company',
                        account_no='$acc_no',
                        position='$position',
                        remark='$remark',
                        hp_no='$hp_no',
                        telco_type='$telco_type',
                        package='$package',
                        latest_package='$latest_package',
                        limit_rm='$limit_rm',
                        data='$data',
                        user='$user',
                        limit_data='$limit'";
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }    
}
function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_telco_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_telco_account SET status = 0 WHERE id = '".$id."' ";
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