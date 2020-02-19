  <?php  
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
    
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
 ?>