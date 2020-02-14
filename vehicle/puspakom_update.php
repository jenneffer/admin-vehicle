  <?php  
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    
    if( !empty($_POST) ){
        $vp_id = $_POST['vp_id'];
        $vehicle_reg_no = $_POST['vehicle_reg_no'];
        $fitness_due_date = $_POST['fitness_date'];
        $roadtax_due_date = $_POST['roadtax_due_date'];
        $runner = $_POST['runner'];
        
        
        $query = "UPDATE vehicle_puspakom
            SET vv_id = '$vehicle_reg_no',
            vp_fitnessDate = '$fitness_due_date',
            vp_roadtaxDueDate = '$roadtax_due_date',
            vp_runner = '$runner',
            vp_lastUpdated = now(),
            vp_updatedBy = '".$_SESSION['cr_id']."',            
            vp_lastUpdated = now()
            WHERE vp_id='".$vp_id."'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db)); 
      
        alert ("Updated successfully","puspakom.php");
      
    }  
 ?>