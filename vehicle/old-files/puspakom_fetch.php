  <?php  
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    
    if(isset($_POST["vp_id"])){
        $query = "SELECT * FROM vehicle_puspakom WHERE vp_id = '".$_POST['vp_id']."'";
       
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));  
        $row = mysqli_fetch_assoc($result);          
        echo json_encode($row);  
    }  
 ?>