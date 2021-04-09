<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();

    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";   
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";
//     $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
//     $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
   
    if( $action != "" ){
        switch ($action){
            
            case 'update_vehicle':
                update_vehicle($data);                
                break;
                
            case 'delete_vehicle': 
                delete_vehicle($id);
                break;
                
            case 'display_vehicle':
               
                break;
                
            case 'retrive_vehicle':                
                retrive_vehicle($id);
                break;  
            
            case 'retrive_vehicle_total_lost':
                retrive_vehicle_total_lost($id);
                break;
                
            case 'delete_vehicle_total_loss':
                delete_vehicle_total_loss($id);
                break;
                
            case 'add_new_permit':
                add_new_permit($data);
                break;
                
            case 'get_vehicle_no':
                get_vehicle_no($id);
                break;
                
            case 'retrive_permit':
                retrieve_permit($id);
                break;
                
            case 'delete_permit':
                delete_permit($id);
                break;
                
            case 'add_new_runner':
                add_new_runner($data);
                break;
                
            case 'retrieve_runner':
                retrieve_runner($id);
                break;
                
            case 'update_runner':
                update_runner($data);
                break;
                
            case 'delete_runner':
                delete_runner($id);
                break;
                
            case 'add_new_claim':
                add_new_claim($data);
                break;
                
            case 'retrieve_runner_claim':
                retrieve_runner_claim($id);
                break;
                
            case 'update_runner_claim':
                update_runner_claim($data);
                break;
                
            case 'delete_runner_claim';
                delete_runner_claim($id);
                break;
                
            case 'add_new_workshop':
                add_new_workshop($data);
                break;
                
            case 'delete_workshop':
                delete_workshop($id);
                break;
            case 'retrieve_workshop':
                retrieve_workshop($id);
                break;
                
            case 'update_workshop':
                update_workshop($data);
                break;
            case 'add_new_third_party_claim':
                add_new_third_party_claim($data);
                break;
                
            case 'retrive_vehicle_third_party':
                retrive_vehicle_third_party($id);
                break;
                
            case 'update_vehicle_third_party':
                update_vehicle_third_party($data);
                break;
                
            case 'delete_vehicle_third_party':
                delete_vehicle_third_party($id);
                break;
                
            default:
                break;
        }
    }
    
    function delete_vehicle_third_party($id){
        global $conn_admin_db;
        if(!empty($id)){
            //update roadtax table
            $query = "UPDATE vehicle_third_party_claim SET status = 0 WHERE vtp_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            echo json_encode($result);
            
        }        
    }
    
    function update_vehicle_third_party($data){
        global $conn_admin_db;
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        
        $vtp_id = $param['vtp_id'];
        $vehicle_id = $param['vehicle_reg_no'];
        $insurance = $param['insurance'];
        $amount = $param['amount'];
        $offer_letter_date = $param['offer_letter_date'];
        $payment_advice_date = $param['payment_advice_date'];
        $beneficiary_bank = $param['beneficiary_bank'];
        $transaction_ref_no = $param['transaction_ref_no'];
        $driver = $param['driver'];
        $v_remark = $param['v_remark'];
        
        
        $sql_update = mysqli_query($conn_admin_db, "UPDATE vehicle_third_party_claim SET
                                        vtp_insurance = '".$insurance."',
                                        vtp_offer_letter_date = '".dateFormat($offer_letter_date)."',
                                        vtp_payment_advice_date = '".dateFormat($payment_advice_date)."',
                                        vv_id = '".$vehicle_id."',
                                        vtp_amount = '".$amount."',
                                        vtp_beneficiary_bank = '".$beneficiary_bank."',
                                        vtp_trans_ref_no = '".$transaction_ref_no."',
                                        vtp_driver = '".$driver."',
                                        vtp_remark = '".$v_remark."' WHERE vtp_id='$vtp_id'");
        
        echo json_encode($sql_update);
    }
    
    function retrive_vehicle_third_party($id){
        global $conn_admin_db;
        $query = "SELECT * FROM vehicle_third_party_claim vtp
            INNER JOIN vehicle_vehicle vv ON vtp.vv_id = vv.vv_id
            INNER JOIN company c ON c.id = vv.company_id WHERE vtp.vtp_id='$id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        $row = mysqli_fetch_array($result);
        
        echo json_encode($row);
    }
    
    function delete_vehicle($id){
        global $conn_admin_db;
        if(!empty($id)){           
            //update roadtax table
            $query = "UPDATE vehicle_vehicle SET status = 0 WHERE vv_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            echo json_encode($result);
            
        }
    }
    
    function update_vehicle($data){
        
        global $conn_admin_db;
        if( !empty($data) ){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data

            //vehicle table
            $vv_id = $params['vv_id'];
            $vehicle_reg_no = $params['vehicle_reg_no'];
            $category = $params['category'];
            $company_id = $params['company'];
            $brand = $params['brand'];
            $model = $params['model'];
            $yearMade = $params['yearMade'];
            $engine_no = $params['engine_no'];
            $capacity = $params['capacity'];
            $chasis_no = $params['chasis_no'];
            $bdm = $params['bdm'];
            $btm = $params['btm'];
            $dispose = $params['dispose'];
            $driver = $params['driver'];
            $finance = $params['finance'];
            $v_remark = $params['v_remark'];
            $vehicle_status = $params['vehicle_status'];

            //permit table
            $permit_type = $params['permit_type'];
            $permit_no = $params['permit_no'];
            $license_ref_no = $params['license_ref_no'];
            $lpkp_permit_due_date = isset($params['lpkp_permit_due_date']) ? dateFormat($params['lpkp_permit_due_date']) : "";
            
            //update vehicle table
            $query = "UPDATE vehicle_vehicle
                        SET vv_vehicleNo='$vehicle_reg_no',
                        vv_category='$category',
                        company_id='$company_id',
                        vv_brand= '$brand',
                        vv_model = '$model',
                        vv_yearMade = '$yearMade',
                        vv_engine_no = '$engine_no',
                        vv_capacity = '$capacity',
                        vv_chasis_no = '$chasis_no',
                        vv_bdm = '$bdm',
                        vv_btm = '$btm',
                        vv_disposed = '$dispose',
                        vv_finance = '$finance',
                        vv_driver = '$driver',
                        vv_remark = '$v_remark',
                        vv_status = '$vehicle_status'
                        WHERE vv_id='".$vv_id."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));

            //check if exist - insert new if not
            $exist = mysqli_query($conn_admin_db, "SELECT * FROM vehicle_permit WHERE vv_id='$vv_id'");
            if(mysqli_num_rows($exist) > 0){
                //update exsiting permit
                $query2 = "UPDATE vehicle_permit SET 
                vpr_type = '$permit_type',
                vpr_no = '$permit_no', 
                vpr_license_ref_No = '$license_ref_no', 
                vpr_due_date = '$lpkp_permit_due_date' WHERE vv_id = '$vv_id'";
            
            }
            else{
                //insert new
                if(!empty($permit_type)){
                    $query2 = "INSERT INTO vehicle_permit(vv_id, vpr_type, vpr_no, vpr_license_ref_No, vpr_due_date)
                    VALUES ($vv_id, '$permit_type', '$permit_no', '$license_ref_no', '$lpkp_permit_due_date')";
                }
                
            }
            
            $result2 = mysqli_query($conn_admin_db, $query2) or die(mysqli_error($conn_admin_db));     
            // json_encode($result2);
        } 
    }
    function retrive_vehilce($args){
        global $conn_admin_db;
        if(isset($args["vehicle_id"])){            
            $query = "SELECT * FROM vehicle_vehicle
                        INNER JOIN company ON company.id = vehicle_vehicle.company_id
                        INNER JOIN vehicle_category ON vehicle_category.vc_id = vehicle_vehicle.vv_category
                        LEFT JOIN vehicle_permit vp ON vp.vv_id = vehicle_vehicle.vv_id
                        WHERE vehicle_vehicle.vv_id = '".$args['vehicle_id']."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
        }
    }
    function add_new_third_party_claim($data){
        global $conn_admin_db;
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        
        $vehicle_id = $param['vehicle_reg_no'];
        $insurance = $param['insurance'];
        $amount = $param['amount'];
        $offer_letter_date = $param['offer_letter_date'];
        $payment_advice_date = $param['payment_advice_date'];
        $beneficiary_bank = $param['beneficiary_bank'];
        $transaction_ref_no = $param['transaction_ref_no'];
        $driver = $param['driver'];
        $v_remark = $param['v_remark'];

        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_third_party_claim SET
                                        vtp_insurance = '".$insurance."',
                                        vtp_offer_letter_date = '".dateFormat($offer_letter_date)."',
                                        vtp_payment_advice_date = '".dateFormat($payment_advice_date)."',
                                        vv_id = '".$vehicle_id."',
                                        vtp_amount = '".$amount."',
                                        vtp_beneficiary_bank = '".$beneficiary_bank."',
                                        vtp_trans_ref_no = '".$transaction_ref_no."',
                                        vtp_driver = '".$driver."',
                                        vtp_remark = '".$v_remark."',
                                        date_added = now()");
        
        echo json_encode($sql_insert);
        
        
    }
    
    function add_new_workshop($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        $w_name = isset( $params['workshop_name'] ) ? $params['workshop_name'] : "";
        $w_status = isset( $params['workshop_status'] ) ? $params['workshop_status'] : "";
        
        //add new runner
        $query = "INSERT INTO vehicle_workshop SET
                name='$w_name',
                status='$w_status'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
    function delete_workshop($id){
        global $conn_admin_db;
        if(!empty($id)){
            //update runner claim table
            $query = "UPDATE vehicle_workshop SET status = 0 WHERE id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            echo json_encode($result);
        }
    }
    
    function retrieve_workshop($id){
        global $conn_admin_db;
        if(!empty($id)){
            $query = "SELECT * FROM vehicle_workshop WHERE id = '".$id."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            echo json_encode($row);
        }
    }
    
    function update_workshop($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        $workshop_id = isset($params['workshop_id']) ? $params['workshop_id'] : "";
        $name = isset( $params['workshop'] ) ? $params['workshop'] : "";
        $status = isset( $params['status'] ) ? $params['status'] : "";
        
        //update runner
        $query = "UPDATE vehicle_workshop SET
                name='$name',
                status='$status' WHERE id='$workshop_id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
    
    
    function delete_runner_claim($id){
        global $conn_admin_db;
        if(!empty($id)){
            //update runner claim table
            $query = "UPDATE vehicle_runner_claim SET status = 0 WHERE id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            echo json_encode($result);
        }
    }
    
    function retrieve_runner_claim($id){
        global $conn_admin_db;
        if(!empty($id)){
            $query = "SELECT * FROM vehicle_runner_claim WHERE id = '".$id."' AND status='1'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);          
            echo json_encode($row);
        }
    }
    
    function update_runner_claim($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        $claim_id = isset($params['claim_id']) ? $params['claim_id'] : "";
        $runner_id = isset($params['runner_up']) ? $params['runner_up'] : "";
        $vehicle_id = isset( $params['vehicle_reg_no_up'] ) ? $params['vehicle_reg_no_up'] : "";
        $bill_no = isset( $params['bill_no_up'] ) ? $params['bill_no_up'] : "";
        $invoice_no = isset($params['invoice_no_up']) ? $params['invoice_no_up'] : "";
        $invoice_amount = isset( $params['invoice_amount_up'] ) ? $params['invoice_amount_up'] : "";
        $invoice_date = isset( $params['invoice_date_up'] ) ? $params['invoice_date_up'] : "";
        $inspection_charge = isset($params['inspection_charge_up']) ? $params['inspection_charge_up'] : "";
        $service_charge = isset( $params['service_charge_up'] ) ? $params['service_charge_up'] : "";
        $puspakom_from = isset( $params['puspakom_from_up'] ) ? $params['puspakom_from_up'] : "";
        $puspakom_to = isset($params['puspakom_to_up']) ? $params['puspakom_to_up'] : "";
        $other_misc = isset( $params['other_misc_up'] ) ? $params['other_misc_up'] : "";
        $remark = isset( $params['remark_up'] ) ? $params['remark_up'] : "";
        $total_amount = $invoice_amount + $service_charge + $inspection_charge;
        
        //add new runner claim
        $query = "UPDATE vehicle_runner_claim SET
                vehicle_id='$vehicle_id',
                runner_id='$runner_id',
                bill_no='$bill_no',
                invoice_no='$invoice_no',
                invoice_amount='$invoice_amount',
                inspection_charge='$inspection_charge',
                service_charge='$service_charge',
                total_amount='$total_amount',
                other_misc='$other_misc',
                remark='$remark',
                puspakom_from='".dateFormat($puspakom_from)."',
                puspakom_to='".dateFormat($puspakom_to)."',
                invoice_date='".dateFormat($invoice_date)."' WHERE id='$claim_id'";

        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
        
    }
    
    function add_new_claim($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        $runner_id = isset($params['runner']) ? $params['runner'] : "";
        $vehicle_id = isset( $params['vehicle_reg_no'] ) ? $params['vehicle_reg_no'] : "";
        $bill_no = isset( $params['bill_no'] ) ? $params['bill_no'] : "";
        $invoice_no = isset($params['invoice_no']) ? $params['invoice_no'] : "";
        $invoice_amount = isset( $params['invoice_amount'] ) ? $params['invoice_amount'] : "";
        $invoice_date = isset( $params['invoice_date'] ) ? $params['invoice_date'] : "";
        $inspection_charge = isset($params['inspection_charge']) ? $params['inspection_charge'] : "";
        $service_charge = isset( $params['service_charge'] ) ? $params['service_charge'] : "";
        $puspakom_from = isset( $params['puspakom_from'] ) ? $params['puspakom_from'] : "";
        $puspakom_to = isset($params['puspakom_to']) ? $params['puspakom_to'] : "";
        $other_misc = isset( $params['other_misc'] ) ? $params['other_misc'] : "";
        $remark = isset( $params['remark'] ) ? $params['remark'] : "";
        $total_amount = $invoice_amount + $service_charge + $inspection_charge;
        
        //add new runner claim
        $query = "INSERT INTO vehicle_runner_claim SET
                vehicle_id='$vehicle_id',
                runner_id='$runner_id',
                bill_no='$bill_no',
                invoice_no='$invoice_no',
                invoice_amount='$invoice_amount',
                inspection_charge='$inspection_charge',
                service_charge='$service_charge',
                total_amount='$total_amount',
                other_misc='$other_misc',
                remark='$remark',
                puspakom_from='".dateFormat($puspakom_from)."',
                puspakom_to='".dateFormat($puspakom_to)."',
                invoice_date='".dateFormat($invoice_date)."'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
    
    function delete_runner($id){
        global $conn_admin_db;
        if(!empty($id)){
            //update vehicle permit table
            $query = "UPDATE vehicle_runner SET r_status = 0 WHERE r_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            echo json_encode($result);
        }
    }
    
    function update_runner($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        $runner_id = isset($params['runner_id']) ? $params['runner_id'] : "";
        $runner_name = isset( $params['r_name'] ) ? $params['r_name'] : "";
        $runner_status = isset( $params['r_status'] ) ? $params['r_status'] : "";
        
        //update runner
        $query = "UPDATE vehicle_runner SET
                r_name='$runner_name',
                r_status='$runner_status' WHERE r_id='$runner_id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
    
    function retrieve_runner($id){
        global $conn_admin_db;
        if(!empty($id)){
            $query = "SELECT * FROM vehicle_runner WHERE r_id = '".$id."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
        }
    }
    function add_new_runner($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data
        $runner_name = isset( $params['runner_name'] ) ? $params['runner_name'] : "";
        $runner_status = isset( $params['runner_status'] ) ? $params['runner_status'] : "";

        //add new runner
        $query = "INSERT INTO vehicle_runner SET
                r_name='$runner_name',
                r_status='$runner_status'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
        
    }
    
    function delete_permit($id){
        global $conn_admin_db;
        if(!empty($id)){
            //update vehicle permit table
            $query = "UPDATE vehicle_permit SET status = 0 WHERE vpr_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            if ($result) {
                alert ("Deleted successfully", "permit.php");
            }            
        }
    }
    
    function retrieve_permit($id){
        global $conn_admin_db;
        if(!empty($id)){            
            $query = "SELECT * FROM vehicle_permit
            INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_permit.vv_id            
            WHERE vehicle_permit.vpr_id = '".$id."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
        }
    }
    
    function get_vehicle_no($id){
        global $conn_admin_db;
        
        $query = "SELECT company_id, vv_vehicleNo FROM vehicle_vehicle WHERE company_id='$id'";
        $result = mysqli_query($conn_admin_db, $query);        
        $vehicle_arr = array();        
        while( $row = mysqli_fetch_array($result) ){
            $id = $row['company_id'];
            $code = $row['vv_vehicleNo'];
            
            $vehicle_arr[] = array("company_id" => $id, "vv_vehicleNo" => $code);
        }
        
        // encoding array to json format
        echo json_encode($vehicle_arr);
    }
    
    function add_new_permit($data){
        global $conn_admin_db;
        $params = array();
        parse_str($data, $params); //unserialize jquery string data 
        $vv_id = isset( $params['vv_id'] ) ? $params['vv_id'] : "";
        $vpr_id = isset( $params['vpr_id'] ) ? $params['vpr_id'] : "";
        $type = isset( $params['permit_type'] ) ? $params['permit_type'] : "";
        $permit_no = isset( $params['permit_no'] ) ? $params['permit_no'] : "";
        $ref_no = isset( $params['license_ref_no'] ) ? $params['license_ref_no'] : "";
        $due_date = isset( $params['lpkp_permit_due_date'] ) ? $params['lpkp_permit_due_date'] : "";
        
        //update renewal status of a previous permit
        //check if vpr_id exist in the table
        $exist = mysqli_query($conn_admin_db,"SELECT * FROM vehicle_permit WHERE vpr_id='$vpr_id'");
        if (mysqli_num_rows($exist) > 0) {
            $sql_query = "UPDATE vehicle_permit SET renewal_status='1' WHERE vpr_id='$vpr_id'";
            mysqli_query($conn_admin_db, $sql_query) or die(mysqli_error($conn_admin_db));
        }
                
        //add new permit
        $query = "INSERT INTO vehicle_permit SET 
                vv_id='$vv_id',
                vpr_type='$type',
                vpr_no='$permit_no',
                vpr_license_ref_No='$ref_no',
                vpr_due_date='".dateFormat($due_date)."'";

        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        if($result){
            alert ("Added successfully", "vehicle.php");
        }
    }
    
    function delete_vehicle_total_loss($id){
        global $conn_admin_db;        
        if(!empty($id)){
            
            $query = "UPDATE vehicle_total_loss SET status = 0 WHERE vt_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            if ($result) {
                alert ("Deleted successfully", "vehicle_total_loss.php");
            }
            
        }
    }
    
    function retrive_vehicle_total_lost($id){        
        global $conn_admin_db;
        
        if(!empty($id)){
            $query = "SELECT * FROM vehicle_vehicle vv 
                    INNER JOIN vehicle_total_loss vtl ON vtl.vt_vv_id = vv.vv_id
                    INNER JOIN company ON company.id = vv.company_id
                    WHERE vtl.vt_id='$id'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
        }
        
    }

    function retrive_vehicle($id){
        global $conn_admin_db;
        
        if(!empty($id)){
            $query = "SELECT * FROM vehicle_vehicle vv                    
                    INNER JOIN company ON company.id = vv.company_id
                    LEFT JOIN vehicle_permit ON vehicle_permit.vv_id = vv.vv_id
                    WHERE vv.vv_id='$id'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_array($result);
            
            echo json_encode($row);
        }
    }
    

    
?>