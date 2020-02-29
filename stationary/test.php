<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;

$query = "SELECT sst.department_id, sst.item_id, date_added, date_taken, item_name, department_name, SUM(quantity) as quantity FROM stationary_stock_take sst 
INNER JOIN stationary_item si ON si.id = sst.item_id
INNER JOIN stationary_department sd ON sd.department_id = sst.department_id
GROUP BY sst.department_id, sst.item_id";

$result = mysqli_query ( $conn_admin_db,$query);
$arr_data = array();
while($row = mysqli_fetch_assoc($result)){ 
    $arr_data[$row['department_id']][] = $row;
}


?>