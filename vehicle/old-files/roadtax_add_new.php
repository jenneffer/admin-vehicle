<?php
    require_once('../assets/config/database.php');
    require_once('./function.php');
	global $conn_admin_db;
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
                                <strong class="card-title">Add New Roadtax</strong>
                            </div>
                            <form action="roadtax_add_process.php" method="post">
                                <div class="card-body card-block">
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                            <?php
                                                $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, vv_vehicleNo FROM vehicle_vehicle WHERE status='1'");
                                                db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control col-sm-6','');
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="lpkp_date" class="form-control-label"><small class="form-text text-muted">LPKP Permit due date</small></label>
                                            <div class="input-group">
                                                <input id="lpkp_date" name="lpkp_date" class="form-control col-sm-5" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div>
                                            </div>                                            
                                        </div>
                                    </div>    

                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="insurance_from_date" class="form-control-label"><small class="form-text text-muted">Insurance from date</small></label>
                                            <div class="input-group">
                                                <input id="insurance_from_date" name="insurance_from_date" class="form-control col-sm-5" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div>                                                
                                            </div>                                                                                        
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="insurance_due_date" class="form-control-label"><small class="form-text text-muted">Insurance due date</small></label>
                                            <div class="input-group">
                                                <input id="insurance_due_date" name="insurance_due_date" class="form-control col-sm-5" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div>                                                
                                            </div>                                           
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="roadtax_from_date" class="form-control-label"><small class="form-text text-muted">Roadtax from date</small></label>
                                            <div class="input-group">
                                                <input id="roadtax_from_date" name="roadtax_from_date" class="form-control col-sm-5" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roadtax_due_date" class="form-control-label"><small class="form-text text-muted">Roadtax due date</small></label>
                                            <div class="input-group">
                                                <input id="roadtax_due_date" name="roadtax_due_date" class="form-control col-sm-5" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="premium_amount" class=" form-control-label"><small class="form-text text-muted">Premium (RM)</small></label>
                                            <input type="text" id="premium_amount" name="premium_amount" onkeypress="return isNumberKey(event)" placeholder="e.g 1000.00" class="form-control col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="ncd" class=" form-control-label"><small class="form-text text-muted">NCD (%)</small></label>
                                            <input type="text" id="ncd" name="ncd" onkeypress="return isNumberKey(event)" placeholder="e.g 25" class="form-control col-sm-6">
                                        </div>
                                    </div>

                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="sum_insured" class=" form-control-label"><small class="form-text text-muted">Sum Insured (RM)</small></label>
                                            <input type="text" id="sum_insured" name="sum_insured" onkeypress="return isNumberKey(event)" placeholder="e.g 750.00" class="form-control col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="excess_paid" class=" form-control-label"><small class="form-text text-muted">Excess Paid (RM)</small></label>
                                            <input type="text" id="excess_paid" name="excess_paid" onkeypress="return isNumberKey(event)" placeholder="e.g 750.00" class="form-control col-sm-6">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="insurance_amount" class=" form-control-label"><small class="form-text text-muted">Insurance Amount(RM)</small></label>
                                            <input type="text" id="insurance_amount" name="insurance_amount" onkeypress="return isNumberKey(event)" placeholder="e.g 150.00" class="form-control col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roadtax_amount" class=" form-control-label"><small class="form-text text-muted">Roadtax Amount(RM)</small></label>
                                            <input type="text" id="roadtax_amount" name="roadtax_amount" onkeypress="return isNumberKey(event)" placeholder="e.g 50.00" class="form-control col-sm-6">
                                        </div>                                        
                                    </div>
                                    <div>
                                    <div class="col-sm-4 ">
                                        <label for="insurance_status" class=" form-control-label"><small class="form-text text-muted">Insurance Status</small></label>
                                        <select name="insurance_status" id="insurance_status" class="form-control col-sm-4">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
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
    <!-- /#right-panel -->

    <!-- link to the script-->
	<?php include ('../allScript2.php')?>
    <!-- Datatables -->
	<script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/jszip.min.js"></script>
    <script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../assets/js/init/datatables-init.js"></script>
    <script src="../assets/js/script/bootstrap-datepicker.min.js"></script>
	
	<script type="text/javascript">
        $(document).ready(function() {
//             $('#bootstrap-data-table-export').DataTable();

        	$('#lpkp_date').datepicker({
            	format: 'dd-mm-yyyy',
            	autoclose: true,
            	todayHighlight: true,
             });
            
            $('#insurance_from_date').datepicker({
            	format: 'dd-mm-yyyy',
            	autoclose: true,
            	todayHighlight: true,
             });
            $('#insurance_due_date').datepicker({
            	format: 'dd-mm-yyyy',
            	autoclose: true,
            	todayHighlight: true,
             });
            
            $('#roadtax_from_date').datepicker({
            	format: 'dd-mm-yyyy',
            	autoclose: true,
            	todayHighlight: true,
             });
            $('#roadtax_due_date').datepicker({
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
