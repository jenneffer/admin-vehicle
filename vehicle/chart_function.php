<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;
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

function get_sum_insured($category){ //compare with 3 years before
    global $conn_admin_db;
    $query = "SELECT YEAR(vi_insurance_dueDate)AS v_year,vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id";
    
    if(!empty($category)){
        $query .=" WHERE vv_category='$category'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data_yearly = []; //show all company
    $data_monthly = [];
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        
        $data_yearly[$row['code']][$row['v_year']][] = $row['vi_sum_insured'];
        
//         $data_monthly[$row['code']][] = $row;
    }
    //yearly
    $arr_sum_insured = [];
    $ins_company = [];
    foreach ($data_yearly as $key => $value) {
        

        foreach ($value as $year => $data){
//         foreach ($value as $val) {
//             if(isset($arr_sum_insured[$key])){
//                 $arr_sum_insured[$key] += $val['yearly_sum_insured'];
//             }else{
//                 $arr_sum_insured[$key] = $val['yearly_sum_insured'];
//             }
            
//         }
//             $datasets[$key][] = array(
//                 'label' => $year,
//                 'data' => [ 65, 59, 80, 81, 56, 55, 45 ],
//                 'borderColor' => randomColor(),
//                 'borderWidth' => "0",
//                 'backgroundColor' => randomColor()
//             );
            
        }
    }
    
    //monthly
    $data_monthly_premium = [];
    $data_monthly_sum_insured = [];
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
    return array(
        'premium_yearly' => $arr_premium,
        'sum_insured_yearly' => $data_yearly,
        'premium_monthly' => $data_monthly_premium,
        'sum_insured_monthly' => $data_monthly_sum_insured,
        'company_label' => $ins_company
    );
    
}

function get_premium_sum_insured($year, $category){ //yearly & monthly
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
            'yearly_sum_insured' => $row['vi_sum_insured']
        );
        
        $data_monthly[$row['code']][] = $row;
    }
    
    //yearly
    $arr_premium = [];
    $arr_sum_insured = [];
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
            //sum insured
            if(isset($arr_sum_insured[$key])){
                $arr_sum_insured[$key] += $val['yearly_sum_insured'];
            }else{
                $arr_sum_insured[$key] = $val['yearly_sum_insured'];
            }
        }
    }
    
    //monthly
    $data_monthly_premium = [];
    $data_monthly_sum_insured = [];
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
    return array(
        'premium_yearly' => $arr_premium,
        'sum_insured_yearly' => $arr_sum_insured,
        'premium_monthly' => $data_monthly_premium,
        'sum_insured_monthly' => $data_monthly_sum_insured,
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
//             'borderColor' => randomColor(),
//             'lineTension' => 0,
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
            'backgroundColor' => 'transparent',
            'borderColor' => randomColor(),
            'lineTension' => 0,
            'borderWidth' => 3,
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