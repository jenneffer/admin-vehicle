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
                
                if( !empty($data) ){                    
                    $params = array();
                    parse_str($data, $params); //unserialize jquery string data   
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
//                     $permit_type = $params['permit_type'];
//                     $permit_no = $params['permit_no'];
//                     $license_ref_no = $params['license_ref_no'];
//                     $lpkp_permit_due_date = $params['lpkp_permit_due_date'];
                    $vehicle_status = $params['vehicle_status'];
                    
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
                    //update permit table   
                    
//                     $query2 = "UPDATE vehicle_permit 
//                         SET vpr_type = '$permit_type',
//                         vpr_no = '$permit_no',
//                         vpr_license_ref_no = '$license_ref_no',
//                         vpr_due_date = '".dateFormat($lpkp_permit_due_date)."' WHERE vv_id='$vv_id'";
                 
//                     $result2 = mysqli_query($conn_admin_db, $query2) or die(mysqli_error($conn_admin_db));
                        
                    alert ("Updated successfully","vehicle.php");
                } 
                break;
                
            case 'delete_vehicle': 
                //also inactive the insurance if roadtax is deleted
                if(!empty($_POST)){
                    $updated_id = $_POST['id'];
                
                    //update roadtax table
                    $query = "UPDATE vehicle_vehicle SET status = 0 WHERE vv_id = '".$updated_id."' ";
                    $result = mysqli_query($conn_admin_db, $query);
                    
                    if ($result) {
                        alert ("Deleted successfully", "vehicle.php");
                    }
                    
                }
                break;
                
            case 'display_vehicle':
               
                break;
                
            case 'retrive_vehicle':
                
                if(isset($_POST["vehicle_id"])){
                    
                    $query = "SELECT * FROM vehicle_vehicle
                        INNER JOIN company ON company.id = vehicle_vehicle.company_id
                        INNER JOIN vehicle_category ON vehicle_category.vc_id = vehicle_vehicle.vv_category
                        LEFT JOIN vehicle_permit vp ON vp.vv_id = vehicle_vehicle.vv_id
                        WHERE vehicle_vehicle.vv_id = '".$_POST['vehicle_id']."'";
                    
                        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                        $row = mysqli_fetch_array($result);
                        
                        echo json_encode($row);
                }
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
            default:
                break;
        }
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
        
        //add new runner claim
        $query = "UPDATE vehicle_runner_claim SET
                vehicle_id='$vehicle_id',
                runner_id='$runner_id',
                bill_no='$bill_no',
                invoice_no='$invoice_no',
                invoice_amount='$invoice_amount',
                inspection_charge='$inspection_charge',
                service_charge='$service_charge',
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
        
        //add new runner claim
        $query = "INSERT INTO vehicle_runner_claim SET
                vehicle_id='$vehicle_id',
                runner_id='$runner_id',
                bill_no='$bill_no',
                invoice_no='$invoice_no',
                invoice_amount='$invoice_amount',
                inspection_charge='$inspection_charge',
                service_charge='$service_charge',
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
    

    
?>