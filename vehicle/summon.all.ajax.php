<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();

    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";    
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
   
    if( $action != "" ){
        switch ($action){
            
            case 'update_summon':                
                if( !empty($_POST) ){
                    $params = array();
                    parse_str($_POST['data'], $params); //unserialize jquery string data                                    
                    $vs_id = isset($params['summon_id']) ? $params['summon_id'] : "";
                    $vehicle_reg_no = isset($params['vehicle_reg_no']) ? $params['vehicle_reg_no'] : "";
                    $driver_name = isset($params['driver_name']) ? $params['driver_name'] : "";
                    $summon_no = isset($params['summon_no']) ? $params['summon_no'] : "";
                    $summon_type = isset($params['summon_type']) ? $params['summon_type'] : "";
                    $summon_desc = isset($params['summon_desc']) ? $params['summon_desc'] : "";
                    $pv_no = isset($params['pv_no']) ? $params['pv_no'] : "";
                    $reimburse_amt = isset($params['reimburse_amt']) ? $params['reimburse_amt'] : "";
                    $summon_date = isset($params['summon_date']) ? dateFormat($params['summon_date']) : "";
                    $offence_details = $params['offence_details'];
                    $driver_borne = isset($params['driver_borne']) ? $params['driver_borne'] : "";
                    $company_borne = isset($params['company_borne']) ? $params['company_borne'] : "";
                    
                    $driver_b = "";
                    $company_b = "";
                    if($driver_borne == "on"){
                        $driver_b = isset($params['driver_b']) ? $params['driver_b'] : "";
                    }
                    if($company_borne == "on"){
                        $company_b = isset($params['company_b']) ? $params['company_b'] : "";
                    }
                    
                    $query = "UPDATE vehicle_summons
                        SET vv_id = '$vehicle_reg_no',
                        vs_driver_name = '$driver_name',
                        vs_summon_no = '$summon_no',
                        vs_summon_type = '$summon_type',
                        vs_summon_type_desc = '$summon_desc',
                        vs_summon_date = '$summon_date',
                        vs_pv_no = '$pv_no',
                        vs_reimbursement_amt = '$reimburse_amt',
                        vs_description = '$offence_details',
                        vs_driver_borne = '".$driver_b."',
                        vs_company_borne = '".$company_b."',
                        vs_date_added = now()
                        WHERE vs_id='".$vs_id."'";
                    
                        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                        
                        alert ("Updated successfully","summons.php");
                }
                break;
                
            case 'delete_summon': 
                //also inactive the insurance if roadtax is deleted
                if(!empty($_POST)){
                    $updated_id = $_POST['id'];
                
                    //update roadtax table
                    $query = "UPDATE vehicle_summons SET status = 0 WHERE vs_id = '".$updated_id."' ";
                    $result = mysqli_query($conn_admin_db, $query);
                    
                    if ($result) {
                        alert ("Deleted successfully", "roadtax.php");
                    }
                    
                }
                break;
                
            case 'display_summon':
               
                break;
                
            case 'retrive_summon':
                
                if(isset($_POST["summon_id"])){
                    
                    $query = "SELECT *
                        FROM vehicle_summons
                        INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_summons.vv_id
                        INNER JOIN company ON company.id = vehicle_vehicle.company_id
                        INNER JOIN vehicle_summon_type ON vehicle_summon_type.st_id = vehicle_summons.vs_summon_type WHERE vs_id = '".$_POST['summon_id']."'";
                        
                        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                        $row = mysqli_fetch_assoc($result);
                        
                        echo json_encode($row);
                } 
                break;
                
            case 'add_payment':
                
                if( !empty($_POST) ){
                    $params = array();
                    parse_str($_POST['data'], $params); //unserialize jquery string data           
                    
                    $vs_id = $params['vs_id'];
                    $payment_date = $params['payment_date'];
                    $payment_amount = $params['payment_amount'];
                    $bankin_date = $params['bankin_date'];
                    $bankin_amount = $params['bankin_amount'];
                    $reimburse_amt = $params['reimburseAmount'];
                    
                    //insert the payment details into table - 1 summon id can have many payment
                    $query = "INSERT INTO vehicle_summon_payment
                        SET summon_id = '$vs_id',
                        payment_amount = '$payment_amount',
                        bankin_amount = '$bankin_amount',
                        payment_date = '".dateFormat($payment_date)."',
                        bankin_date = '".dateFormat($bankin_date)."',
                        date_added = now()";
                    
                    $result = mysqli_query($conn_admin_db, $query);
                    
                    //get the total paid in the vehicle_summon_payment table
                    $paid_amount = itemName("SELECT SUM(payment_amount) FROM vehicle_summon_payment WHERE summon_id='".$vs_id."'");
                    $payment_balance = $reimburse_amt - $paid_amount;
                    
                    
                    //update the balance in vehicle_summons
                    $update_query = "UPDATE vehicle_summons SET vs_balance = '".$payment_balance."' WHERE vs_id='".$vs_id."' ";
                    $result_update = mysqli_query($conn_admin_db, $update_query);
                    
                    if ($result_update) {
                        alert ("Updated successfully","summons.php");
                    }                    
                }
                break;
                
            default:
                break;
        }
    }
    
?>