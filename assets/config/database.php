<?php
//=============== FILE HOST ====================
$Server_Host = '192.168.9.221';
$Server_Pswd = 'Ep492033';
//============== Local DB (For test purpose only) =============
$db_hqost = 'localhost'; // Server Name
$db_uqser = 'root'; // Username
$db_pqass = ''; // Password
$db_nqame = 'admin'; // Database Name 

$conn_admin_db = mysqli_connect($db_hqost, $db_uqser, $db_pqass, $db_nqame);
//var_dump($conn_admin_db);die;
if (!$conn_admin_db) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
} else {
	// echo "Checking aaronthisone database!";    
}
?>