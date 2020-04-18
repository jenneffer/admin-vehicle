<?php 
require_once('assets/config/database.php');
require_once('function.php');
require_once('check_login.php');
global $conn_admin_db;

$query ="SELECT * FROM permit";
$sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
while($row = mysqli_fetch_array($sql_result)){ 
    $permit_due_date = $row['permit_due_date'];
    
    $date = explode(".", $permit_due_date);
//     var_dump($date);
    $day = $date[0];
    $month = $date[1];
    $year = $date[2];
    
    $new_date = $year."-".$month."-".$day;
    
//     var_dump($new_date);
    
    $qry = "UPDATE permit SET permit_due_date='$new_date' WHERE id='".$row['id']."'";
    mysqli_query($conn_admin_db, $qry)or die(mysqli_error($conn_admin_db));
}



?>