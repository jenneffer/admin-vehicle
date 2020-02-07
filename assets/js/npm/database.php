<?php
//=============== FILE HOST ====================
$Server_Host = '192.168.9.32';

//============== Local DB (For test purpose only) =============
$db_hqost = 'localhost'; // Server Name
$db_uqser = 'root'; // Username
$db_pqass = ''; // Password
$db_nqame = 'suzie'; // Database Name

$conn_ins_db = mysqli_connect($db_hqost, $db_uqser, $db_pqass, $db_nqame);
if (!$conn_ins_db) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
} else {
	// echo "Checking aaronthisone database!";
}
?>