<?php 
//============== Local DB (For test purpose only) =============
$db_hqost = '192.168.9.221'; // Server Name
$db_uqser = 'root'; // Username
$db_pqass = 'Ep492033'; // Password
$db_nqame = 'insurance_db'; // Database Name

$conn_admin_db = mysqli_connect($db_hqost, $db_uqser, $db_pqass, $db_nqame);

//var_dump($conn_admin_db);die;
if (!$conn_admin_db) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
} else {
    // echo "Checking aaronthisone database!";
}
// require_once('function.php');
// require_once('check_login.php');
global $conn_admin_db;

$query ="SELECT * FROM ins_period";
$sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
while($row = mysqli_fetch_array($sql_result)){ 
    $permit_due_date = $row['date_end'];
    if(!empty($permit_due_date) && $permit_due_date !='-' ){
//         var_dump($permit_due_date);
        $date = explode(".", $permit_due_date);
        //     var_dump($date);
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        
        $new_date = "20".$year."-".$month."-".$day;
//         var_dump($new_date);
//         $new_date = $year."-".$month."-".$day;
        
        //     var_dump($new_date);
        
        $qry = "UPDATE ins_period SET `date_end` ='$new_date' WHERE ins_period_id='".$row['ins_period_id']."'";
        mysqli_query($conn_admin_db, $qry)or die(mysqli_error($conn_admin_db));
    }
    
}



?>