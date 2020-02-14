<?php
	include('assets/config/database.php');
	session_start();
	global $conn_admin_db;
// get reclock and redirect to it!
	if(isset($_POST['submit'])) {
		$username = $_POST['username'];
		$pass = md5($_POST['password']);
		
		$checksql = "SELECT * FROM credential WHERE BINARY cr_username = '$username' AND cr_password = '$pass' ";
		$rchecksql = mysqli_query($conn_admin_db, $checksql);
		$crchecksql = mysqli_num_rows($rchecksql); // check row $rchecksql
		
		if($crchecksql == '0') { // data enetered does not match to any row in database
			echo"<script>alert('Login FAILED! Please try again.');
			location.href='login.php';</script>";
		} else { // data entered match to any row in database
			$row = mysqli_fetch_assoc($rchecksql);
			$userid = $row['cr_id'];
			$nameUser = $row['cr_name'];
			
			// set session 
			$_SESSION['cr_id'] = $userid;
			$_SESSION['cr_name'] = $nameUser;
			// end of setting session
			header("Location: index.php");
			/*if(!$_GET['RecLock']) { // if reclock is not exist and head to home.php
				
			} else { // if get reclock exist
				$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$query = parse_url($url, PHP_URL_QUERY);
				parse_str($query, $params);
				if (isset($params["RecLock"])) {
					$RecLock = $_GET['RecLock'];
					header("Location:".$RecLock );
				}else{
					header("Location: index.php");
				}
			} // end of reclock exist*/
			
		} // end of data entered match to any row in database
	} else { // if submit button does not clicked
		
	}

?>