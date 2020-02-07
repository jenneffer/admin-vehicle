<?php
    require_once('../assets/config/database.php');
    require_once('./function.php');
	
	session_start();
	global $conn_admin_db;
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
		header("Location: ../login.php?RecLock=".$PrevURL);
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
	<?php include('../allCSS1.php')?>
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

    </style>
</head>

<body>
    <!--Left Panel -->
	<?php  include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <!-- /#header -->
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add New Vehicle</strong>
                            </div>
                            <form action="vehicle_add_process.php" method="post">
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="vehicle_reg_no" class=" form-control-label">Vehicle Reg No.</label>
                                            <input type="text" id="vehicle_reg_no" name="vehicle_reg_no" placeholder="Enter vehicle registration number" class="form-control col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="category" class=" form-control-label">Vehicle Category</label>
                                            <?php
                                                $cat = mysqli_query ( $conn_admin_db, "SELECT vc_id, vc_type FROM vehicle_category");
                                                db_select ($cat, 'category', '','','-select-','form-control col-sm-6','');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="company" class=" form-control-label">Company</label>
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                                db_select ($company, 'company', '','','-select-','form-control col-sm-6','');
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="yearPurchased" class=" form-control-label">Year Purchased</label>
                                    		<input type="text" id="yearPurchased" name="yearPurchased" placeholder="e.g 2010" class="form-control col-sm-6">
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="brand" class=" form-control-label">Brand</label>
                                            <input type="text" id="brand" name="brand" placeholder="Enter vehicle brand" class="form-control col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="name" class=" form-control-label">Name</label>
                                            <input type="text" id="name" name="name" placeholder="Enter vehicle name" class="form-control col-sm-6">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-12">
                                            <label for="description" class=" form-control-label">Description</label>                                             
                                            <textarea name="textarea-input" id="description" name="description" rows="3" placeholder="Description..." class="form-control col-sm-9"></textarea>
                                        </div>
                                        
                                    </div>
                                    <div class="card-body">
                                        <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                                        <button type="button" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        <div class="clearfix"></div>
        <!-- Footer -->
        <?PHP include('../footer.php')?>
        <!-- /.site-footer -->
    <!-- from right panel page -->
    <!-- /#right-panel -->

    <!-- link to the script-->
	<?php include ('../allScript2.php')?>
	
<!-- 	<script src="../assets/js/lib/data-table/datatables.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/jszip.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/vfs_fonts.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/buttons.html5.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/buttons.print.min.js"></script> -->
<!--     <script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script> -->
<!--     <script src="../assets/js/init/datatables-init.js"></script> -->

    <!-- Datepicker JQuery UI -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<script type="text/javascript">
        $(document).ready(function() {
//           $('#bootstrap-data-table-export').DataTable();
      } );
  </script>
</body>
</html>
