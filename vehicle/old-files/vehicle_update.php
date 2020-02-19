  <?php  
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
    
    if( !empty($_POST) ){
        $vv_id = $_POST['vv_id'];
        $vehicle_reg_no = $_POST['vehicle_reg_no'];
        $category = $_POST['category'];
        $company_id = $_POST['company'];
        $brand = $_POST['brand'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $yearPurchased = $_POST['yearPurchased'];
        $capacity = $_POST['capacity'];
        
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
 ?>