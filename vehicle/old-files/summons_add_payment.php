  <?php  
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
    
    if( !empty($_POST) ){
        $vs_id = $_POST['vs_id'];
        $payment_date = $_POST['payment_date'];
        $payment_amount = $_POST['payment_amount'];
        $bankin_date = $_POST['bankin_date'];
        $bankin_amount = $_POST['bankin_amount'];
        $reimburse_amt = $_POST['reimburseAmount'];
        
        //insert the payment details into table - 1 summon id can have many payment
        $query = "INSERT INTO vehicle_summon_payment
            SET summon_id = '$vs_id',
            payment_amount = '$payment_amount',
            bankin_amount = '$bankin_amount',
            payment_date = '".dateFormat($payment_date)."',
            bankin_date = '".dateFormat($bankin_date)."',                       
            date_added = now()";   

        $result = mysqli_query($conn_admin_db, $query);  
        
        //get the total paid in the vehicle_summon_payment table
        $paid_amount = itemName("SELECT SUM(payment_amount) FROM vehicle_summon_payment WHERE summon_id='".$vs_id."'");
        $payment_balance = $reimburse_amt - $paid_amount;
        
        
        //update the balance in vehicle_summons
        $update_query = "UPDATE vehicle_summons SET vs_balance = '".$payment_balance."' WHERE vs_id='".$vs_id."' ";
        $result_update = mysqli_query($conn_admin_db, $update_query);  
      
        alert ("Updated successfully","summons.php");
    }  
 ?>