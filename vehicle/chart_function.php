<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;
//vehicle company map - initialize each company value to 0
//company_id => value
$company_map = array(
    1 => 0,
    3 => 0,
    4 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
    12 => 0,
    13 => 0,
    16 => 0,
    19 => 0,
    20 => 0,
    22 => 0,
    28 => 0,
    33 => 0,
);

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

$month = array(
    1=> "Jan",
    2=> "Feb",
    3=> "Mar",
    4=> "Apr",
    5=> "May",
    6=> "Jun",
    7=> "Jul",
    8=> "Aug",
    9=> "Sep",
    10=> "Oct",
    11=> "Nov",
    12=> "Dec"
);
function get_roadtax($year, $category){ //yearly & monthly
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vrt_roadTax_fromDate, vrt_roadTax_dueDate, vrt_roadTax_period, vrt_amount FROM vehicle_vehicle
            INNER JOIN vehicle_roadtax ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
            WHERE YEAR(vrt_roadTax_dueDate)='".$year."'";
    
    if(!empty($category)){
        $query .=" AND vv_category='$category'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_rt = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //yearly
        $data[$row['code']][] = array(
            'roadtax' => $row['vrt_amount']
        );
        //monthly
        $arr_data_rt[$row['code']][] = $row;
    }
    
    //form array data for roadtax monthly
    $month = 12; 
    $data_monthly_roadtax = [];
    foreach ($arr_data_rt as $code => $val){
        foreach ($val as $v){
            $vrt_due_date = $v['vrt_roadTax_dueDate'];
            $vrt_month = date_parse_from_format("Y-m-d", $vrt_due_date);
            $ins_m = $vrt_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ins_m){
                    //premium
                    if (isset($data_monthly_roadtax[$code][$m])){
                        $data_monthly_roadtax[$code][$m] += (double)$v['vrt_amount'];
                    }else{
                        $data_monthly_roadtax[$code][$m] = (double)$v['vrt_amount'];
                    }
                }
            }
            
        }
    }
    
    return array(
        'roadtax_yearly' => $data,
        'roadtax_monthly' => $data_monthly_roadtax
    );    
}

function get_roadtax_byCompany($year, $category, $company){ // monthly by company 
    global $conn_admin_db;
    global $month_map;
    
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vrt_roadTax_fromDate, vrt_roadTax_dueDate, vrt_roadTax_period, vrt_amount FROM vehicle_vehicle
            INNER JOIN vehicle_roadtax ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
            WHERE YEAR(vrt_roadTax_dueDate)='".$year."'";

    if(!empty($category)){
        $query .=" AND vv_category='$category'";
    }
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    
    $data_monthly_roadtax = []; //show roadtax data by month for selected company
    $arr_data_rt = [];
    $month = 12;  
    while($row = mysqli_fetch_assoc($sql_result)){
        $arr_data_rt[$row['code']][] = $row;
    }
    //form array data for roadtax monthly
    foreach ($arr_data_rt as $code => $val){
        foreach ($val as $v){
            $vrt_due_date = $v['vrt_roadTax_dueDate'];
            $vrt_month = date_parse_from_format("Y-m-d", $vrt_due_date);
            $ins_m = $vrt_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ins_m){
                    //premium
                    if (isset($data_monthly_roadtax[$code][$m])){
                        $data_monthly_roadtax[$code][$m] += (double)$v['vrt_amount'];
                    }else{
                        $data_monthly_roadtax[$code][$m] = (double)$v['vrt_amount'];
                    }
                }
            }
            
        }
    }
    
    foreach ($data_monthly_roadtax as $label => $data){
        $month_data = array_replace($month_map, $data);
        $datasets_roadtax_monthly[] = array(
            'label' => $label,
            'backgroundColor' => randomColor(),
//             'borderColor' => randomColor(),
//             'lineTension' => 0,
            'borderWidth' => 0,
            'data' => array_values($month_data)
        );
    }
    $datasets_roadtax_monthly = json_encode($datasets_roadtax_monthly);
    
    return $datasets_roadtax_monthly;
}

function get_sum_insured($year_to, $category){ //compare existing years
    //get 3 years comparison
    $year_from = $year - 2;
    global $conn_admin_db;
    $query = "SELECT YEAR(vi_insurance_dueDate)AS v_year,vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id
        WHERE YEAR(vi_insurance_dueDate) BETWEEN '$year_from' AND '$year_to'";

    if(!empty($category)){
        $query .=" AND vv_category='$category'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data_yearly = []; //show all company
    $data_monthly = [];
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        
        $data_yearly[$row['v_year']][$row['company_id']][] = $row['vi_sum_insured'];
    }
    
    //yearly
    $ins_company = [];
    $arr_sum_insured = [];
    foreach ($data_yearly as $year => $value) {
        foreach ($value as $company => $data){
            $ins_company[] = $company;
            foreach ($data as $val) {                
                if(isset($arr_sum_insured[$year][$company])){
                    $arr_sum_insured[$year][$company] += (double)$val;
                }else{
                    $arr_sum_insured[$year][$company] = (double)$val;
                }
                
            }
        }
    }

    return $arr_sum_insured;
 
    
}
function get_sum_insured_monthly($year, $category){
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id
        WHERE YEAR(vi_insurance_dueDate)='".$year."'";
    
    if(!empty($category)){
        $query .=" AND vv_category='$category'";
    }

    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data_monthly = [];
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        $data_yearly[$row['code']][] = array(            
            'yearly_sum_insured' => $row['vi_sum_insured']
        );
        
        $data_monthly[$row['code']][] = $row;
    }
    //monthly
    $data_monthly_sum_insured = [];
    foreach ($data_monthly as $code => $val){
        foreach ($val as $v){
            $ins_due_date = $v['vi_insurance_dueDate'];
            $ins_month = date_parse_from_format("Y-m-d", $ins_due_date);
            $ins_m = $ins_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ins_m){
                    //sum  insured
                    if (isset($data_monthly_sum_insured[$code][$m])){
                        $data_monthly_sum_insured[$code][$m] += (double)$v['vi_sum_insured'];
                    }else{
                        $data_monthly_sum_insured[$code][$m] = (double)$v['vi_sum_insured'];
                    }
                }
            }
            
        }
    }
    return $data_monthly_sum_insured;
}

function get_premium($year, $category){ //yearly & monthly
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id
        WHERE YEAR(vi_insurance_dueDate)='".$year."'";
    
    if(!empty($category)){
        $query .=" AND vv_category='$category'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data_yearly = []; //show all company
    $data_monthly = [];
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        $data_yearly[$row['code']][] = array(
            'yearly_premium' => $row['vi_premium_amount'],            
        );
        
        $data_monthly[$row['code']][] = $row;
    }
    
    //yearly
    $arr_premium = [];
    $ins_company = [];
    foreach ($data_yearly as $key => $value) {
        $ins_company[] = $key;
        foreach ($value as $val) {
            //premium
            if (isset($arr_premium[$key])){
                $arr_premium[$key] += $val['yearly_premium'];
            }else{
                $arr_premium[$key] = $val['yearly_premium'];
            }
        }
    }
    
    //monthly
    $data_monthly_premium = [];
    foreach ($data_monthly as $code => $val){
        foreach ($val as $v){
            $ins_due_date = $v['vi_insurance_dueDate'];
            $ins_month = date_parse_from_format("Y-m-d", $ins_due_date);
            $ins_m = $ins_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ins_m){
                    //premium
                    if (isset($data_monthly_premium[$code][$m])){
                        $data_monthly_premium[$code][$m] += (double)$v['vi_premium_amount'];
                    }else{
                        $data_monthly_premium[$code][$m] = (double)$v['vi_premium_amount'];
                    }                    
                }
            }
            
        }
    }   
    return array(
        'premium_yearly' => $arr_premium,
        'premium_monthly' => $data_monthly_premium,        
        'company_label' => $ins_company
    );
}

function get_premium_sum_insured_byCompany($year, $category, $company){    
    global $conn_admin_db;
    global $month_map;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id
        WHERE YEAR(vi_insurance_dueDate)='".$year."' ";
    
    if(!empty($category)){
        $query .=" AND vv_category='$category'";
    }
    
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));    
    $data_monthly_premium = []; //show premium data by month for selected company
    $data_monthly_sum_insured = []; //show sum_insured data by month for selected company    
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        $ins_due_date = $row['vi_insurance_dueDate'];
        $ins_month = date_parse_from_format("Y-m-d", $ins_due_date);
        $ins_m = $ins_month["month"];   
        for ( $m=1; $m<=$month; $m++ ){
            if($m == $ins_m){
                //premium
                if (isset($data_monthly_premium[$row['code']][$m])){
                    $data_monthly_premium[$row['code']][$m] += (double)$row['vi_premium_amount'];
                }else{
                    $data_monthly_premium[$row['code']][$m] = (double)$row['vi_premium_amount'];
                }
                
                //sum  insured
                if (isset($data_monthly_sum_insured[$row['code']][$m])){
                    $data_monthly_sum_insured[$row['code']][$m] += (double)$row['vi_sum_insured'];
                }else{
                    $data_monthly_sum_insured[$row['code']][$m] = (double)$row['vi_sum_insured'];
                }
            }
        }
    }
    
    $datasets_premium_monthly = [];
    foreach ($data_monthly_premium as $label => $data){
        $month_data = array_replace($month_map, $data);
        $datasets_premium_monthly[] = array(
            'label' => $label,
            'backgroundColor' => randomColor(),
            'borderWidth' => 0,
            'data' => array_values($month_data)
        );
    }
    $datasets_premium_monthly = json_encode($datasets_premium_monthly);
    
    $datasets_sum_insured_monthly = [];
    foreach ($data_monthly_sum_insured as $label => $data){
        $month_data = array_replace($month_map, $data);
        $datasets_sum_insured_monthly[] = array(
            'label' => $label,
            'backgroundColor' => randomColor(),            
            'borderWidth' => 0,
            'data' => array_values($month_data)
        );
    }
    $datasets_sum_insured_monthly = json_encode($datasets_sum_insured_monthly);
    
    
    return array(
        'monthly_premium_byCompany' => $datasets_premium_monthly,
        'monthly_sum_insured_byCompany' => $datasets_sum_insured_monthly
    );
}


?>