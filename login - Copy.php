<?php
	require_once('assets/config/database.php');
	
	// get reclock and redirect to it!
?>
<!doctype html>
<html class="no-js" lang=""> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Insurance</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- link to css -->
	<?php include('allCSS.php')?>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.php">
                        <img class="align-content" src="images/loginLogo.png" alt="" width="85%">
                    </a>
                </div>
                <div class="login-form">
					<!-- HERE FORM STARTED-->
                    <form action="login.php" method="post">
                        <div class="form-group">
							<label style="color:red" id="inuser" hidden>Incorrect Username!</label> <!-- if no such username found in the database -->
							<label style="color:red" id="inpass" hidden>Incorrect Password!</label> <!-- if no such password found in the database -->
							<label style="color:red" id="inboth" hidden>Incorrect Username and Password!</label> <!-- if no such username and also password found in the database -->
						</div>
						<div class="form-group">
                            <label>Username</label>
                            <input type="username" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-outline-warning btn-flat m-b-30 m-t-30" name="submit">Sign in</button>
                        
                    </form>
					
					<!-- HERE FORM ENDED-->
                </div>
            </div>
        </div>
    </div>

    <!-- link to the script-->
	<?php include ('allScript.php')?>

</body>
</html>

<?php
	// set pointer
	$point1 = "123";
	$point2 = "123";
	
	if(isset($_POST['submit'])) {
		$username = $_POST['username'];
		$pass = $_POST['password'];
		
		$checksql = "SELECT * FROM credential WHERE cr_username = '$username' AND cr_password = '$pass' ";
		$rchecksql = mysqli_query($conn_admin_db, $checksql);
		$crchecksql = mysqli_num_rows($rchecksql); // check row $rchecksql
		
		if($crchecksql == '0') { // check if data enetered does not match to any row in database
			// check username
			$unamesql = "SELECT * FROM credential WHERE cr_username = '$username'";
			$runamesql = mysqli_query($conn_admin_db, $unamesql);
			$crunamesql = mysqli_num_rows($runamesql);
			if($crunamesql != '0') {
				// echo"<script>alert('username exist')</script>";
			} else {
				$point1 = "0";
			}
			
			// check password
			$passsql = "SELECT * FROM credential WHERE cr_password = '$pass' ";
			$rpasssql = mysqli_query($conn_admin_db, $passsql);
			$crpasssql = mysqli_num_rows($rpasssql);
			if($crpasssql != '0') {
				// echo"<script>alert('password exist')</script>";
			} else {
				$point2 = "0";
			}
			
			// show the wrong input user made
			if($point1 == '0' && $point2 == '0') {
				echo "	<script>
							$('input[type='button']').click(function(){
								$('.inboth').show('fast');
							}
							$('input[type='button']').trigger('click');
							</script>";
			} else if($point1 != '0' && $point2 == '0') {
				echo "<script>
							$('input[type='button']').click(function(){
								$('.inpass').show('fast');
							}
							$('input[type='button']').trigger('click');
							</script>";
			} else if($point1 == '0' && $point2 != '0') {
				echo "<script>
							$('input[type='button']').click(function(){
								$('.inuser').show('fast');
							}
							$('input[type='button']').trigger('click');
							</script>";
			} else {
				// echo "";
			}
			
		} else {
			
		}
		//$firstname = $_POST['firstname'];
	} else {
		
	}
?>
