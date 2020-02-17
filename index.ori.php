<?php
	require_once('assets/config/database.php');
	
	// checking if log in or not
	session_start();
	if(isset($_SESSION['cr_id'])) {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $params);
		
		// get id
		$userId = $_SESSION['cr_id'];
		$name = $_SESSION['cr_name'];
	} else {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$PrevURL= $url;
		header("Location: login.php?RecLock=".$PrevURL);
	}
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Insurance</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- link to css -->
	<?php include('allCSS.php')?>
   <style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
		
		.homeHover
		{
		}
		
		.homeHover:hover 
		{
			box-shadow: 0 0 21px rgba(33,33,33,.5); 
			cursor: pointer;
		}
		.btn{/*dent around button*/
            display: inline-block;
            position: relative;
            text-decoration: none;
            color: #f7c208;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            text-align: center;
            
        }
    </style>
</head>

<body>
    <!--Left Panel -->
	<?php //include('assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('assets/nav/indexRightNav.php')?>
        <!-- /#header -->
        <!-- Content -->
		<div class="content">
            <div class="animated fadeIn">

                <div class="ui-typography">
                    <div class="row">
                        <div class="col-md-12">
							<div class="card">
                                

								<div class="card-body"><!-- Aaron HERE -->
									<div class="typo-articles">
										<h3 style="color:#f7c208; text-decoration: underline; text-align:center"><b>Categories</b></h3><br>
										<div class="row">
											<div class="homeHover offset-lg-1 btn" onclick="location.href = 'vehicle/vehicle.php';"><i class="fas fa-taxi fa-10x"></i><br><span><strong>V E H I C L E</strong></span></div>
										
											<div class="homeHover offset-lg-1 btn"><img src="images/car.png" style="height:250px;"></div>
										
											<div class="homeHover offset-lg-1 btn"></div>
										</div>
										&nbsp;
										<div class="row">
										
											<div class="homeHover col-lg-3 offset-lg-1" style="height:250px; border:1px solid black"></div>
											
											<div class="homeHover col-lg-3 offset-lg-1" style="height:250px; border:1px solid black"></div>
											
											<div class="homeHover col-lg-3 offset-lg-1" style="height:250px; border:1px solid black"></div>
										</div>
										<div class="row">
										
											<div class="col-lg-3 offset-lg-1" style="display: flex; justify-content: center; align-items: center; ">
												<br><center><a href="#" style="color:green">Security</a><center>
											</div>
											
											<div class="col-lg-3 offset-lg-1" style="display: flex; justify-content: center; align-items: center; ">
												<br><center><a href="#" style="color:green">Farm Maintenance</a><center>
											</div>
											
											<div class="col-lg-3 offset-lg-1" style="display: flex; justify-content: center; align-items: center; ">
												<br><center><a href="#" style="color:green">Asset Management</a><center>
											</div>
										</div>
									</div> <!-- End of typo-articles -->
                                </div> <!-- End of card-body -->
								
							</div><!-- End of card -->
						</div> <!-- class md-lg-12 -->
					</div><!-- end of row-->
				</div><!-- end of typography -->
				
			</div><!-- .animated -->
		</div><!-- .content -->
		
		
		<!-- END OF CONTENT-->
                
        <div class="clearfix"></div>
        <!-- Footer -->
        <?PHP include('footer.php')?>
        <!-- /.site-footer -->
     <!-- from right panel page </div>-->
    <!-- /#right-panel -->

    <!-- link to the script-->
	<?php include ('allScript.php')?>
</body>
</html>
