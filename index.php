<?php
	require_once('assets/config/database.php');
	require_once('function.php');
	require_once('check_login.php');
	global $conn_admin_db;
// 	// checking if log in or not
// 	session_start();
// 	if(isset($_SESSION['cr_id'])) {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$query = parse_url($url, PHP_URL_QUERY);
// 		parse_str($query, $params);
		
// 		// get id
// 		$userId = $_SESSION['cr_id'];
// 		$name = $_SESSION['cr_name'];
// 	} else {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$PrevURL= $url;
// 		header("Location: login.php?RecLock=".$PrevURL);
// 	}
	
	//get the access module of current user
	$cr_access_module = itemName("SELECT cr_access_module FROM credential WHERE cr_id = '".$_SESSION['cr_id']."'");	
	//get the system list
	$query = "SELECT * FROM admin_system WHERE sid IN (".$cr_access_module.")";
	$rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
	if ( mysqli_num_rows($rst) > 0 ){
	    $data = array();
	    while( $row = mysqli_fetch_assoc( $rst ) ){
	        $data[] = $row;
	    }
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
            text-align: center;
            
        }
    </style>
</head>

<body>
    <!--Left Panel -->
	<?php //include('assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php //include('assets/nav/indexRightNav.php')?>
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
										<?php foreach ($data as $item){?>
										    <div class="homeHover offset-lg-1 btn" onclick="onClickSystem('<?=$item['sid']?>', '<?=$item['first_page_url']?>')"><i class="<?=$item['icon']?>"></i><br><span><strong><?=$item['sname']?></strong></span></div>
										<?php }?>										
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
	<script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/init/datatables-init.js"></script>
    <script src="assets/js/script/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">

    $(document).ready(function() {
			
    });

    function onClickSystem(system_id, first_page){
	    $.ajax({
	        url: 'set_var.php',
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            id: system_id
	        }
	    }).done(function(res) {
            if (res.valid) {
                document.location.href = first_page;                
            }
        });
    }
    </script>
</body>
</html>
