  <?php  
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    
    if( !empty($_POST) ){
        $vrt_id = $_POST['vrt_id'];
        $vehicle_reg_no = $_POST['vehicle_reg_no'];
        $lpkp_date = $_POST['lpkp_date'];
        $insurance_from_date = $_POST['insurance_from_date'];
        $insurance_due_date = $_POST['insurance_due_date'];
        $roadtax_from_date = $_POST['roadtax_from_date'];
        $roadtax_due_date = $_POST['roadtax_due_date'];
        $premium_amount = $_POST['premium_amount'];
        $ncd = $_POST['ncd'];
        $sum_insured = $_POST['sum_insured'];
        $excess_paid = $_POST['excess_paid'];
        $roadtax_amount = $_POST['roadtax_amount'];
        $insurance_status = $_POST['insurance_status'];
        $insurance_amount = $_POST['insurance_amount'];
        
        //calculate the roadtax period
        $diff = abs(strtotime($roadtax_due_date) - strtotime($roadtax_from_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
        //update roadtax
        $query = "UPDATE vehicle_roadtax
            SET vv_id = '$vehicle_reg_no',
            vrt_lpkpPermit_dueDate = '$lpkp_date',
            vrt_roadTax_fromDate = '$roadtax_from_date',
            vrt_roadTax_dueDate = '$roadtax_due_date',
            vrt_roadtaxPeriodYear = '$years',        
            vrt_roadtaxPeriodMonth = '$months',     
            vrt_roadtaxPeriodDay = '$days',                
            vrt_amount = '$roadtax_amount',
            vrt_updatedBy = '".$_SESSION['cr_id']."',
            vrt_lastUpdated = now()
            WHERE vrt_id='".$vrt_id."'"; 
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));  

        //update insurance
         $query2 = "UPDATE vehicle_insurance
                SET vv_id = '".$vehicle_reg_no."',
                WHERE vrt_id='".$vrt_id."',
                vi_insurance_fromDate = '".$insurance_from_date."',
                vi_insurance_dueDate = '".$insurance_due_date."',
                vi_insuranceStatus = '".$insurance_status."',
                vi_amount = '".$insurance_amount."',
                vi_premium_amount='".$premium_amount."',
                vi_ncd='".$ncd."',
                vi_sum_insured='".$sum_insured."',
                vi_excess_paid='".$excess_paid."',
                vi_lastUpdated = now(),
                vi_updatedBy = '".$_SESSION['cr_id']."'";
        
         $result2 = mysqli_query($conn_admin_db, $query2) or die(mysqli_error($conn_admin_db));  
      
      alert ("Updated successfully","roadtax.php");
    }  
 ?>