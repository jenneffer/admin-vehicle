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
            
            case 'update_vehicle':
                
                if( !empty($_POST) ){
                    
                    $params = array();
                    parse_str($_POST['data'], $params); //unserialize jquery string data   
                    
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
                    $permit_type = $params['permit_type'];
                    $permit_no = $params['permit_no'];
                    $license_ref_no = $params['license_ref_no'];
                    $lpkp_permit_due_date = $params['lpkp_permit_due_date'];
                    
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
                        vv_remark = '$v_remark'
                        WHERE vv_id='".$vv_id."'";

                        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                    //update permit table   
                    
                    $query2 = "UPDATE vehicle_permit 
                        SET vpr_type = '$permit_type',
                        vpr_no = '$permit_no',
                        vpr_license_ref_no = '$license_ref_no',
                        vpr_due_date = '".dateFormat($lpkp_permit_due_date)."' WHERE vv_id='$vv_id'";
                 
                    $result2 = mysqli_query($conn_admin_db, $query2) or die(mysqli_error($conn_admin_db));
                        
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
            default:
                break;
        }
    }
    
?>