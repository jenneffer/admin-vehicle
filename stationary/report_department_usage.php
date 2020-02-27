<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;

$query = "SELECT * FROM stationary_stock_take sst
INNER JOIN stationary_department sd ON sd.department_id = sst.department_id
INNER JOIN stationary_item si ON si.id = sst.item_id";

$sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error());
$arr_data = [];
while($row = mysqli_fetch_array($sql_result)){
    $arr_data[$row['department_id']][] = $row;
}

var_dump($arr_data);
?>