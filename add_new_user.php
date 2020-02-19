<?php
    require_once('assets/config/database.php');
    require_once('function.php');
	
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
    <title>Eng Peng Vehicle</title>
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

    </style>
</head>

<body>
    <!--Left Panel -->
	<?php  //include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('assets/nav/IndexRightNav.php')?>
    <!-- /#header -->
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add New User</strong>
                            </div>
                            <form action="summon_add_process.php" method="post">
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                		<div class="col-sm-6">
                                            <label for="name" class=" form-control-label"><small class="form-text text-muted">Name</small></label>
                                            <input type="text" id="name" name="name" placeholder="Enter name" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="username" class=" form-control-label"><small class="form-text text-muted">Username</small></label>
                                            <input type="text" id="username" name="username" placeholder="Enter username" class="form-control">
                                        </div>                    
                                    </div>
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6">
                                            <label for="password" class=" form-control-label"><small class="form-text text-muted">Password</small></label>
                                            <input type="text" id="password" name="password" placeholder="Enter password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group col-sm-12">
                                        <div class="col col-md-1"><label class=" form-control-label">Access</label></div>
                                        <div class="col col-md-3">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_addUser" name="cr_addUser" value="" class="form-check-input">Add User
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_vehicle" name="cr_vehicle" value="" class="form-check-input"> Vehicle
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_safety" name="cr_safety" value="" class="form-check-input"> Safety
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-3">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_telekomANDinternet" name="cr_telekomANDinternet" value="" class="form-check-input">Bill
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_security" name="cr_security" value="" class="form-check-input"> Security
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_farmMaintenance" name="cr_farmMaintenance" value="" class="form-check-input"> Farm Maintenance
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-md-3">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <label class="form-check-label ">
                                                        <input type="checkbox" id="cr_assetManagement" name="cr_assetManagement" value="" class="form-check-input">Asset Management
                                                    </label>
                                                </div>                                                
                                            </div>
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
        <?PHP include('footer.php')?>
        <!-- /.site-footer -->
    <!-- from right panel page -->
    <!-- /#right-panel -->

    <!-- link to the script-->
	<?php include ('allScript.php')?>
	<!-- Datatables -->
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
          
          $('#desc').hide(); 
          $('#summon_type').change(function(){
              if($('#summon_type').val() == 3) {
                  $('#desc').show(); 
              } else {
                  $('#desc').hide(); 
              } 
          });

          $('#summon_date').datepicker({
        	  	format: 'dd-mm-yyyy',
              	autoclose: true,
              	todayHighlight: true,       
           });
          
      });

    function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 
		&& (charCode < 48 || charCode > 57))
		return false;
		return true;
	}  
	
	function isNumericKey(evt){
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 
		&& (charCode < 48 || charCode > 57))
		return true;
		return false;
	} 
  </script>
</body>
</html>
