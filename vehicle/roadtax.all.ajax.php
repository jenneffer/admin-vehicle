<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();

    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";    
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');    
    $company = isset($_POST['select_company']) ? $_POST['select_company'] : "";
    if( $action != "" ){
        switch ($action){
            case 'create_roadtax':
                create_roadtax($_POST['data']);
                break;
            case 'update_roadtax':                
                update_roadtax($_POST);
                break;
                
            case 'delete_roadtax': 
                delete_roadtax($_POST);
                break;
                
            case 'display_roadtax':
                display_roadtax($date_start, $date_end);                
                break;
                
            case 'retrive_roadtax':
                retrieve_roadtax($_POST);
                break;
                
            case 'roadtax_summary':                
                roadtax_summary_report( $date_start, $date_end, $company );
                break;
            default:
                break;
        }
    }
    
    function create_roadtax($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        
        $vehicle_reg_no = $params['vehicle_reg_no'];
        $roadtax_from_date = dateFormat($params['roadtax_from_date']);
        $roadtax_due_date = dateFormat($params['roadtax_due_date']);
        $roadtax_amount = $params['roadtax_amount'];
        $period = $params['roadtax_period'];
        
        //insert into roadtax table
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_roadtax SET
                            vv_id = '".$vehicle_reg_no."',
                            vrt_roadTax_fromDate = '".$roadtax_from_date."',
                            vrt_roadTax_dueDate = '".$roadtax_due_date."',
                            vrt_amount = '".$roadtax_amount."',
                            vrt_roadTax_period = '".$period."',
                            vrt_updatedBy = '".$_SESSION['cr_id']."',
                            vrt_lastUpdated = now()") or  die(mysqli_error($conn_admin_db));
        
        echo json_encode($sql_insert);
        
    }
    
    function delete_roadtax($args){
        global $conn_admin_db;
        
        //also inactive the insurance if roadtax is deleted
        if(!empty($args)){
            $updated_id = $args['id'];
            
            //update roadtax table
            $query = "UPDATE vehicle_roadtax SET status = 0 WHERE vrt_id = '".$updated_id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            //update insurance table
            $query_ins = "UPDATE vehicle_insurance SET vi_status = 0 WHERE vi_vrt_id = '".$updated_id."' ";
            $result_ins = mysqli_query($conn_admin_db, $query_ins);
            
            if ($result && $result_ins) {
                alert ("Deleted successfully", "roadtax.php");
                
            }
            
        }
    }
    
    function roadtax_summary_report( $date_start, $date_end, $company){
        global $conn_admin_db;
        
        $sql_query = "SELECT * FROM vehicle_roadtax
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
                INNER JOIN company ON company.id = vehicle_vehicle.company_id
                LEFT JOIN vehicle_puspakom ON vehicle_puspakom.vv_id = vehicle_vehicle.vv_id AND vehicle_puspakom.status='1'
                LEFT JOIN vehicle_insurance ON vehicle_insurance.vv_id = vehicle_vehicle.vv_id
                WHERE vrt_roadTax_fromDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' ";
        
        if(!empty($company)){
            $sql_query .=" AND vehicle_vehicle.company_id = '$company'";    
        }
        
        $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
        
        $arr_result = array(
            'sEcho' => 0,
            'iTotalRecords' => 0,
            'iTotalDisplayRecords' => 0,
            'aaData' => array()
        );
        $arr_data = array();
        $total_found_rows = 0;
        if ( mysqli_num_rows($rst) ){
            $count = 0;
            while( $row = mysqli_fetch_assoc( $rst ) ){
                $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
                $total_found_rows = $row_found[0];
                $count++;
                $insurance_status = $row['vi_insuranceStatus'] == 1 ? "Active" : "Inactive";
                $period = $row['vrt_roadTax_period'];
                
                $fitness_date = !empty($row['vp_fitnessDate']) ? dateFormatRev($row['vp_fitnessDate']) : '-';
                
                $data = array(
                    $count .".",
                    $row['vv_vehicleNo'],
                    $row['code'],
                    $row['vrt_lpkpPermit_dueDate'] != NULL ? dateFormatRev($row['vrt_lpkpPermit_dueDate']) : "-",
                    $fitness_date,
                    $row['vi_insurance_dueDate'] != NULL ? dateFormatRev($row['vi_insurance_dueDate']) : "-",
                    $insurance_status,
                    $row['vrt_roadTax_fromDate'] != NULL ? dateFormatRev($row['vrt_roadTax_fromDate']) : "-",
                    $row['vrt_roadTax_dueDate'] != NULL ? dateFormatRev($row['vrt_roadTax_dueDate']) : "-",
                    $period,
                    number_format($row['vrt_amount'],2),
                    
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
    
    function display_roadtax($date_start, $date_end){
        global $conn_admin_db;
        $sql_query = "SELECT * FROM vehicle_roadtax
                        INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
                        LEFT JOIN vehicle_insurance ON vehicle_insurance.vv_id = vehicle_roadtax.vv_id
                        INNER JOIN company ON company.id = vehicle_vehicle.company_id
                        WHERE vehicle_roadtax.status='1' ";
        
        if (!empty($date_start) && !empty($date_end)) {
            $sql_query .= " AND vehicle_roadtax.vrt_roadTax_dueDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'" ;
        }
        
        $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
        
        $arr_result = array(
            'sEcho' => 0,
            'iTotalRecords' => 0,
            'iTotalDisplayRecords' => 0,
            'aaData' => array()
        );
        $arr_data = array();
        $total_found_rows = 0;
        if ( mysqli_num_rows($rst) ){
            $count = 0;
            while( $row = mysqli_fetch_assoc( $rst ) ){
   
                $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
                $total_found_rows = $row_found[0];
                
                $count++;
//                 $year = !empty($row['vrt_roadtaxPeriodYear']) ? $row['vrt_roadtaxPeriodYear'] ."Year(s)" : "";
//                 $month = !empty($row['vrt_roadtaxPeriodMonth']) ? $row['vrt_roadtaxPeriodMonth'] ."Month(s)" : "";
//                 $days = !empty($row['vrt_roadtaxPeriodDay']) ? $row['vrt_roadtaxPeriodDay'] ."Day(s)" : "";
                $period = $row['vrt_roadTax_period'];
                $insurance_status = $row['vi_insuranceStatus'] == 1 ? "Active" : "Inactive";
                
                $action = '<span id='.$row['vrt_id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
                        </span><br><span id='.$row['vrt_id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                        </span>';
                
                $data = array(
                    $count.".",
                    $row['vv_vehicleNo'],
                    $row['code'],
                    $row['vrt_lpkpPermit_dueDate'] != NULL ? dateFormatRev($row['vrt_lpkpPermit_dueDate']) : "-",
                    $row['vi_insurance_dueDate'] != NULL ? dateFormatRev($row['vi_insurance_dueDate']) : "-",
                    $insurance_status,
                    $row['vrt_roadTax_fromDate'] != NULL ? dateFormatRev($row['vrt_roadTax_fromDate']) : "-",
                    $row['vrt_roadTax_dueDate'] != NULL ? dateFormatRev($row['vrt_roadTax_dueDate']) : "-",
                    $period,
                    number_format($row['vrt_amount'], 2),
                    $action
                    
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
    
    function update_roadtax($args){
        global $conn_admin_db;
        if( !empty($args) ){            
            $params = array();
            parse_str($args['data'], $params); //unserialize jquery string data
            
            $vrt_id = $params['vrt_id'];
            $vehicle_reg_no = $params['vehicle_reg_no'];
            $lpkp_date = dateFormat($params['lpkp_date']);
            // $insurance_from_date = dateFormat($params['insurance_from_date']);
            // $insurance_due_date = dateFormat($params['insurance_due_date']);
            $roadtax_from_date = $params['roadtax_from_date'];
            $roadtax_due_date = $params['roadtax_due_date'];
            // $premium_amount = $params['premium_amount'];
            // $ncd = $params['ncd'];
            // $sum_insured = $params['sum_insured'];
            // $excess_paid = $params['excess_paid'];
            $roadtax_amount = $params['roadtax_amount'];
            // $insurance_status = $params['insurance_status'];
            // $insurance_amount = $params['insurance_amount'];
            
            
            //calculate the roadtax period
            // $diff = abs(strtotime($roadtax_due_date) - strtotime($roadtax_from_date));
            // $years = floor($diff / (365*60*60*24));
            // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            
            //update roadtax
            $query = "UPDATE vehicle_roadtax
                            SET vv_id = '$vehicle_reg_no',
                            vrt_lpkpPermit_dueDate = '$lpkp_date',
                            vrt_roadTax_fromDate = '".dateFormat($roadtax_from_date)."',
                            vrt_roadTax_dueDate = '".dateFormat($roadtax_due_date)."',
                            -- vrt_roadtaxPeriodYear = '$years',
                            -- vrt_roadtaxPeriodMonth = '$months',
                            -- vrt_roadtaxPeriodDay = '$days',
                            vrt_amount = '$roadtax_amount',
                            vrt_updatedBy = '".$_SESSION['cr_id']."',
                            vrt_lastUpdated = now()
                            WHERE vrt_id='".$vrt_id."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
            //update insurance
            // $query2 = "UPDATE vehicle_insurance
            //                 SET vv_id = '".$vehicle_reg_no."',
            //                 vi_insurance_fromDate = '".$insurance_from_date."',
            //                 vi_insurance_dueDate = '".$insurance_due_date."',
            //                 vi_insuranceStatus = '".$insurance_status."',
            //                 vi_amount = '".$insurance_amount."',
            //                 vi_premium_amount='".$premium_amount."',
            //                 vi_ncd='".$ncd."',
            //                 vi_sum_insured='".$sum_insured."',
            //                 vi_excess='".$excess_paid."',
            //                 vi_lastUpdated = now(),
            //                 vi_updatedBy = '".$_SESSION['cr_id']."'
            //                 WHERE vi_vrt_id='".$vrt_id."'";
            
            
            // $result2 = mysqli_query($conn_admin_db, $query2) or die(mysqli_error($conn_admin_db));
            
            alert ("Updated successfully","roadtax.php");
        }
    }
    
    function retrieve_roadtax($args) {
        global $conn_admin_db;
        
        if(isset($args["vrt_id"])){
            $query = "SELECT vrt_id, vehicle_vehicle.vv_id,vi_premium_amount,vi_ncd,vi_sum_insured, vi_excess, vrt_amount,vi_insuranceStatus, vrt_lpkpPermit_dueDate,vi_insurance_fromDate,vi_insurance_dueDate,vrt_roadTax_fromDate,vrt_roadTax_dueDate 
                FROM vehicle_roadtax
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
                LEFT JOIN vehicle_insurance ON vehicle_insurance.vv_id = vehicle_roadtax.vv_id
                WHERE vehicle_roadtax.vrt_id='".$args['vrt_id']."'";           
                            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
        }
    }
    
?>