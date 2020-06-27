<?php
	include('../assets/config/database.php');
	include('../function.php');
	session_start();
	
	global $conn_admin_db;
	if(isset($_POST['save'])) {
	    
	    $name = isset($_POST['name']) ? $_POST['name'] : "";
	    $username = isset($_POST['username']) ? $_POST['username'] : "";
	    $password = isset($_POST['password']) ? $_POST['password'] : "";
	    $email = isset($_POST['email']) ? $_POST['email'] : "";
	    $system = isset($_POST['system']) ? implode(',', $_POST['system']) : "";
// 	    $cr_addUser = isset($_POST['cr_addUser']) ? 1 : 0;
// 	    $cr_vehicle = isset($_POST['cr_vehicle']) ? 1 : 0;
// 	    $cr_safety = isset($_POST['cr_safety']) ? 1 : 0;
// 	    $cr_telekomANDinternet = isset($_POST['cr_telekomANDinternet']) ? 1 : 0;
// 	    $cr_security = isset($_POST['cr_security']) ? 1 : 0;
// 	    $cr_farmMaintenance = isset($_POST['cr_farmMaintenance']) ? 1 : 0;
// 	    $cr_assetManagement = isset($_POST['cr_assetManagement']) ? 1 : 0;
	    
	    $query = "INSERT INTO credential SET
                    cr_name='$name',
                    cr_username='$username',
                    cr_email='$email',
                    cr_password='".md5($password)."',
                    cr_access_module='".$system."'";

	    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db)); 
	    if($result){
	        alert("Successfully added!","/admin/manage_user/user_list.php");
	    }
		
	} else { // if submit button does not clicked
		
	}

?>