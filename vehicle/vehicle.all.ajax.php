<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
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
                    $name = $params['name'];
                    $description = $params['description'];
                    $yearPurchased = $params['yearPurchased'];
                    $capacity = $params['capacity'];
                    
                    $query = "
                        UPDATE vehicle_vehicle
                        SET vv_vehicleNo='$vehicle_reg_no',
                        vv_category='$category',
                        company_id='$company_id',
                        vv_brand= '$brand',
                        vv_name = '$name',
                        vv_description = '$description',
                        vv_yearPurchased = '$yearPurchased',
                        vv_capacity = '$capacity',
                        date_added =  now()
                        WHERE vv_id='".$vv_id."'";
                    
                        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                        
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
                    
                    $query = "SELECT vv_id, company_id, vv_category,vc_type, vv_vehicleNo, vv_brand, vv_name, vv_description,
                        vv_yearPurchased, company.code AS vv_code, company.name AS com_name, vv_capacity FROM vehicle_vehicle
                        INNER JOIN company ON company.id = vehicle_vehicle.company_id
                        INNER JOIN vehicle_category ON vehicle_category.vc_id = vehicle_vehicle.vv_category
                        WHERE vv_id = '".$_POST['vehicle_id']."'";
                    
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