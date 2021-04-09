<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();
    
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
    $company = isset($_POST['select_company']) ? $_POST['select_company'] : "";
    $action = isset($_POST['action']) ? $_POST['action'] : "";
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    
    if( $action != "" ){
        switch ($action){
            
            case 'get_insurance_summary_report':
                get_insurance_summary_report($date_start, $date_end, $company);
                break;
                
            case 'get_insurance_listing':
                get_insurance_listing();
                break;
                
            case 'create_insurance':
                create_insurance($data);
                break;
                
            case 'retrive_insurance':
                retrive_insurance($_POST);
                break;
                
            case 'update_insurance':
                update_insurance($data);
                break;

            case 'add_payment':
                add_payment($data);
                break;

            case 'delete_insurance':
                delete_insurance($id);
                break;
                
            default:
                break;
        }
    }

    function add_payment($data){
        global $conn_admin_db;
        if( !empty($data) ){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data
            $vi_id = $params['insurance_id'];
            $payment_date = dateFormat($params['payment_date']);            
            $insurer = $params['insurer'];
            $cover_type = $params['cover_type'];
            $payment_method = $params['payment_method'];
            $pv_no = $params['pv_no'];
            $policy_no = $params['policy_no'];
            
            $result = mysqli_query($conn_admin_db,"UPDATE vehicle_insurance SET
                                vi_payment_date = '".$payment_date."',
                                vi_insurer = '".$insurer."',
                                vi_cover_type = '".$cover_type."',
                                vi_payment_method='".$payment_method."',
                                vi_pv_no='".$pv_no."',
                                vi_policy_no='".$policy_no."',                                
                                vi_lastUpdated = now(),
                                vi_updatedBy = '".$_SESSION['cr_id']."' WHERE vi_id='$vi_id'") or die(mysqli_error($conn_admin_db));
            
            echo json_encode($result);
        }
    }
    
    function retrive_insurance($args){
        global $conn_admin_db;
        
        if(isset($args["vi_id"])){
            $query = "SELECT * FROM vehicle_insurance vi 
                    INNER JOIN vehicle_vehicle vv on vv.vv_id = vi.vv_id
                    WHERE vi.vi_status='1'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
            
        }
    }
    
    function update_insurance($data){
        global $conn_admin_db;
        if( !empty($data) ){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data
            $vi_id = $params['vi_id'];
            $insurance_from_date = dateFormat($params['insurance_from_date']);
            $insurance_due_date = dateFormat($params['insurance_due_date']);
            $insurance_status = $params['insurance_status'];
            $premium_amount = $params['premium_amount'];
            $ncd = $params['ncd'];
            $sum_insured = $params['sum_insured'];
            $excess_paid = $params['excess_paid'];
            $vehicle_no = $params['vehicle_reg_no'];
            
            $result = mysqli_query($conn_admin_db,"UPDATE vehicle_insurance SET
                                vv_id = '".$vehicle_no."',
                                vi_insurance_fromDate = '".$insurance_from_date."',
                                vi_insurance_dueDate = '".$insurance_due_date."',
                                vi_insuranceStatus = '".$insurance_status."',
                                vi_premium_amount='".$premium_amount."',
                                vi_ncd='".$ncd."',
                                vi_sum_insured='".$sum_insured."',
                                vi_excess='".$excess_paid."',
                                vi_lastUpdated = now(),
                                vi_updatedBy = '".$_SESSION['cr_id']."' WHERE vi_id='$vi_id'") or die(mysqli_error($conn_admin_db));
            
            echo json_encode($result);
        }
    }
    
    function create_insurance($data){
        global $conn_admin_db;
        if( !empty($data) ){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data
            $insurance_from_date = dateFormat($params['insurance_from_date']);
            $insurance_due_date = dateFormat($params['insurance_due_date']);
            $insurance_status = $params['insurance_status'];
            $premium_amount = $params['premium_amount'];
            $ncd = $params['ncd'];
            $sum_insured = $params['sum_insured'];
            $excess_paid = $params['excess_paid'];
            $vehicle_no = $params['vehicle_reg_no'];

            $sql_insert_ins = mysqli_query($conn_admin_db,"INSERT INTO vehicle_insurance SET
                                vv_id = '".$vehicle_no."',
                                vi_insurance_fromDate = '".$insurance_from_date."',
                                vi_insurance_dueDate = '".$insurance_due_date."',
                                vi_insuranceStatus = '".$insurance_status."',
                                vi_premium_amount='".$premium_amount."',
                                vi_ncd='".$ncd."',
                                vi_sum_insured='".$sum_insured."',
                                vi_excess='".$excess_paid."',
                                vi_lastUpdated = now(),
                                vi_updatedBy = '".$_SESSION['cr_id']."'") or die(mysqli_error($conn_admin_db));
            
            echo json_encode($sql_insert_ins);
        }
    }
    
    function get_insurance_listing(){
        global $conn_admin_db;
        
        $sql_query = "SELECT * FROM vehicle_insurance vi 
                    INNER JOIN vehicle_vehicle vv on vv.vv_id = vi.vv_id
                    WHERE vi.vi_status='1'";
        
        $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
        
        $arr_result = array(
            'sEcho' => 0,
            'iTotalRecords' => 0,
            'iTotalDisplayRecords' => 0,
            'aaData' => array()
        );
        $total_found_rows = 0;
        $arr_data = array();
        if ( mysqli_num_rows($rst) ){
            $count = 0;
            while( $row = mysqli_fetch_assoc( $rst ) ){
                $pv_no = $row['vi_pv_no'];
                $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
                $total_found_rows = $row_found[0];
                $count++;
                //check if pv no exist. if not show the button to add payment
                $show_payment_icon = '';
                if(empty($pv_no)) $show_payment_icon = '<span id='.$row['vi_id'].' data-toggle="modal" class="add_payment btn_link" data-target="#addPayment" style="color:#FFC107;"><i class="menu-icon fa fa-comments-dollar fa-2x"></i></span><br>';
                $action = $show_payment_icon.'<span id='.$row['vi_id'].' data-toggle="modal" class="edit_data btn_link" data-target="#editItem" style="color:#17A2B8;"><i class="menu-icon fa fa-edit fa-2x"></i>
                        </span><br><span id='.$row['vi_id'].' data-toggle="modal" class="delete_data btn_link" data-target="#deleteItem" style="color:#DC3545;"><i class="menu-icon fa fa-trash-alt fa-2x"></i>
                        </span>';
                $comp_name = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
                
                $data = array(
                    $count .".",
                    $comp_name,
                    $row['vv_vehicleNo'],
                    '-',
                    dateFormatRev($row['vi_insurance_fromDate']),
                    dateFormatRev($row['vi_insurance_dueDate']),
                    $row['vi_premium_amount'],
                    $row['vi_ncd'] ." %",
                    $row['vi_sum_insured'],                    
                    $row['vi_excess'],
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
    
    function get_insurance_summary_report($date_start, $date_end, $company){
        global $conn_admin_db;
        $sql_query = "SELECT * FROM vehicle_vehicle  vv
                INNER JOIN company c ON c.id = vv.company_id
                INNER JOIN vehicle_insurance vi ON vi.vv_id = vv.vv_id
                WHERE vi.vi_insurance_dueDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'";
        
        if(!empty($company)){
            $sql_query .=" AND vv.company_id='$company'";
        }
        
        $rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
        
        $arr_result = array(
            'sEcho' => 0,
            'iTotalRecords' => 0,
            'iTotalDisplayRecords' => 0,
            'aaData' => array()
        );
        $total_found_rows = 0;
        $arr_data = array();
        if ( mysqli_num_rows($rst) ){
            $count = 0;
            while( $row = mysqli_fetch_assoc( $rst ) ){
                $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
                $total_found_rows = $row_found[0];
                $count++;
                
                // 			$year = !empty($row['vrt_roadtaxPeriodYear']) ? $row['vrt_roadtaxPeriodYear'] ." Year(s)" : "";
                // 			$month = !empty($row['vrt_roadtaxPeriodMonth']) ? $row['vrt_roadtaxPeriodMonth'] ." Month(s)" : "";
                // 			$days = !empty($row['vrt_roadtaxPeriodDay']) ? $row['vrt_roadtaxPeriodDay'] ." Day(s)" : "";
                // 			$period = $year ." ". $month ." ".$days;
                //             $period = $row['vrt_roadTax_period'];
                // 			$fitness_test = !empty($row['vp_fitnessDate']) ? dateFormatRev($row['vp_fitnessDate']) : "-";
                $payment_details = "<span><b>Date</b> : ".$row['vi_payment_date']."</span><br>
                <span><b>PV No.</b> : ".$row['vi_pv_no']."</span><br>
                <span><b>Payment Mode</b> : ".$row['vi_payment_method']."</span><br>";
                $data = array(
                    dateFormatRev($row['vi_insurance_fromDate']),
                    dateFormatRev($row['vi_insurance_dueDate']),
                    $row['vv_vehicleNo'],
                    $row['code'],
                    $row['vi_premium_amount'],
                    $row['vi_sum_insured'],
                    $row['vi_ncd'] ." %",
                    $row['vi_excess'],
                    $row['vi_cover_type'],
                    $payment_details
                    
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

    function delete_insurance($id){
        global $conn_admin_db;

        if(!empty($id)){            
            //update insurance table
            $query_ins = "UPDATE vehicle_insurance SET vi_status = 0 WHERE vi_id = '".$id."' ";
            $result_ins = mysqli_query($conn_admin_db, $query_ins);
            echo json_encode($result_ins);
        }
    }
	
?>