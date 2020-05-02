<?php
	require_once('assets/config/database.php');
	session_start();
	

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
                    <form method="post" action="login_process.php"><!--  -->
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

    <!-- link to the script//include ('allScript.php')-->
	<?php include ('allScript.php')?>
</body>
</html>


