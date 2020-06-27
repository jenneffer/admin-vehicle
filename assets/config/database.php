<?php
//=============== FILE HOST ====================
$DB_Host = '192.168.9.221';
$DB_Pswd = 'Ep492033';
//============== Local DB (For test purpose only) =============
$db_hqost = 'localhost'; // Server Name
$db_uqser = 'root'; // Username
$db_pqass = ''; // Password
$db_nqame = 'admin'; // Database Name 

$conn_admin_db = mysqli_connect($DB_Host, $db_uqser, $DB_Pswd, $db_nqame);
//var_dump($conn_admin_db);die;
if (!$conn_admin_db) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
} else {
	// echo "Checking aaronthisone database!";    
}
?>