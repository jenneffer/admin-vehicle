  <?php  
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
    
    if(isset($_POST["vrt_id"])){  
      $query = "SELECT * FROM vehicle_roadtax
            INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
            LEFT JOIN vehicle_insurance ON vehicle_insurance.vi_vrt_id = vehicle_roadtax.vrt_id
            WHERE vehicle_roadtax.vrt_id='".$_POST['vrt_id']."'";
      
      $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));  
      $row = mysqli_fetch_array($result);  
      
      echo json_encode($row);  
    }  
 ?>