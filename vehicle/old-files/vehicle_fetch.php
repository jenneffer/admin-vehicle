  <?php  
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
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
 ?>