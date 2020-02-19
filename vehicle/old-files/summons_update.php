  <?php  
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
    
    if( !empty($_POST) ){
        $vs_id = $_POST['summon_id'];
        $vehicle_reg_no = $_POST['vehicle_reg_no'];
        $driver_name = $_POST['driver_name'];
        $summon_no = $_POST['summon_no'];
        $summon_type = $_POST['summon_type'];
        $summon_desc = $_POST['summon_desc'];
        $pv_no = $_POST['pv_no'];
        $reimburse_amt = $_POST['reimburse_amt'];
        $summon_date = $_POST['summon_date'];
        $offence_details = $_POST['offence_details'];
        
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
            vs_date_added = now()
            WHERE vs_id='".$vs_id."'";      
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));  
      
      alert ("Updated successfully","summons.php");
    }  
 ?>