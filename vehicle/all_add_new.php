<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;
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
// 		header("Location: ../login.php?RecLock=".$PrevURL);
//     }
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
        .submit-button{
            text-align: center;
        }
        .select2-selection__rendered {
          margin: 5px;
        }
        .select2-selection__arrow {
          margin: 5px;
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
            <form action="all_add_process.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Road Tax</strong>
                            </div>
                            <div class="card-body">
						      	<div class="form-group row col-sm-12">
    						      	<div class="col-sm-12">
                                        <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.<span class="color-red">*</span></small></label>
                                        <?php
                                            $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                            db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','','required');
                                        ?>
                                    </div> 
<!--                                     <div class="col-sm-6"> -->
<!--                                         <label for="lpkp_date" class="form-control-label"><small class="form-text text-muted">LPKP Permit due date</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                             <input id="lpkp_date" name="lpkp_date" class="form-control" autocomplete="off"> -->
<!--                                             <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
<!--                                         </div>                                             -->
<!--                                     </div> -->
						      	</div>
						      	<div class="form-group row col-sm-12">
						      	<div class="col-sm-6">
                                    <label for="roadtax_from_date" class="form-control-label"><small class="form-text text-muted">Roadtax from date<span class="color-red">*</span></small></label>
                                    <div class="input-group">
                                        <input id="roadtax_from_date" name="roadtax_from_date" class="form-control" autocomplete="off" required>
                                        <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="roadtax_due_date" class="form-control-label"><small class="form-text text-muted">Roadtax due date<span class="color-red">*</span></small></label>
                                    <div class="input-group">
                                        <input id="roadtax_due_date" name="roadtax_due_date" class="form-control" autocomplete="off" required>
                                        <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                </div>   
						      	</div>
                                <div class="form-group row col-sm-12"> 
                                    <div class="col-sm-6">
                                        <label for="roadtax_amount" class=" form-control-label"><small class="form-text text-muted">Roadtax Amount(RM)<span class="color-red">*</span></small></label>
                                        <input type="text" id="roadtax_amount" name="roadtax_amount" onkeypress="return isNumberKey(event)" placeholder="e.g 50.00" class="form-control" required>
                                    </div> 
                                </div>                  
                            </div>
                        </div>
                        
<!--                         <div class="card"> -->
<!--                                 <div class="card-header"> -->
<!--                                     <strong class="card-title">Puspakom</strong> -->
<!--                                 </div> -->
<!--                                 <div class="card-body"> -->
<!--                                     <div class="form-group row col-sm-12">  -->
<!--                                     <div class="col-sm-6"> -->
<!--                                         <label for="fitness_date" class="form-control-label"><small class="form-text text-muted">Fitness due date</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                             <input id="fitness_date" name="fitness_date" class="form-control" autocomplete="off" > -->
<!--                                             <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
<!--                                         </div>                                             -->
<!--                                     </div> -->
<!--                                     <div class="col-sm-6"> -->
<!--                                         <label for="runner" class=" form-control-label"><small class="form-text text-muted">Runner</small></label> -->
<!--                                         <input type="text" id="runner" name="runner" placeholder="Enter runner's name" class="form-control"> -->
<!--                                     </div> -->
<!--                                     </div> -->
<!--                                 </div> -->
<!--                             </div> -->
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Insurance</strong>
                            </div>
                            <div class="card-body">
                            	<div class="form-group row col-sm-12"> 
                                	<div class="col-sm-6">
                                        <label for="insurance_from_date" class="form-control-label"><small class="form-text text-muted">Insurance from date<span class="color-red">*</span></small></label>
                                        <div class="input-group">
                                            <input id="insurance_from_date" name="insurance_from_date" class="form-control" autocomplete="off" required>
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>                                                
                                        </div>                                                                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="insurance_due_date" class="form-control-label"><small class="form-text text-muted">Insurance due date<span class="color-red">*</span></small></label>
                                        <div class="input-group">
                                            <input id="insurance_due_date" name="insurance_due_date" class="form-control" autocomplete="off" required>
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>                                                
                                        </div>                                           
                                    </div>
                            	</div>
                            	<div class="form-group row col-sm-12"> 
                                	<div class="col-sm-6">
                                        <label for="premium_amount" class=" form-control-label"><small class="form-text text-muted">Premium (RM)<span class="color-red">*</span></small></label>
                                        <input type="text" id="premium_amount" name="premium_amount" onkeypress="return isNumberKey(event)" placeholder="e.g 1000.00" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="ncd" class=" form-control-label"><small class="form-text text-muted">NCD (%)</small></label>
                                        <input type="text" id="ncd" name="ncd" onkeypress="return isNumberKey(event)" placeholder="e.g 25" class="form-control">
                                    </div>
                            	</div>
                                <div class="form-group row col-sm-12">
                                    <div class="col-sm-6">
                                        <label for="sum_insured" class=" form-control-label"><small class="form-text text-muted">Sum Insured (RM)</small></label>
                                        <input type="text" id="sum_insured" name="sum_insured" onkeypress="return isNumberKey(event)" placeholder="e.g 750.00" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="excess_paid" class=" form-control-label"><small class="form-text text-muted">Excess Paid (RM)</small></label>
                                        <input type="text" id="excess_paid" name="excess_paid" onkeypress="return isNumberKey(event)" placeholder="e.g 750.00" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <div class="col-sm-6">
                                        <label for="insurance_status" class=" form-control-label"><small class="form-text text-muted">Insurance Status</small></label>
                                        <select name="insurance_status" id="insurance_status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">&nbsp;</div>
                                <div class="form-group row col-sm-12">&nbsp;</div>
                                <div class="form-group row col-sm-12">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="submit-button">
                        	<button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                            <button type="button" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
                        </div>                        
                    </div>                   
                </div>
               </form>
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
	<script src="../assets/js/select2.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function() {
//             $('#bootstrap-data-table-export').DataTable();

			// Initialize select2
        	var select2 = $("#vehicle_reg_no").select2({
    //     		placeholder: "select option",
        	    selectOnClose: true
            });
        	select2.data('select2').$selection.css('height', '38px');
        	select2.data('select2').$selection.css('border', '1px solid #ced4da');
            
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
                                   
        });

        function isNumberKey(evt){
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) 
				return false;
			return true;
		}  
		
		function isNumericKey(evt){
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
				return true;
			return false;
		} 
  </script>
</body>
</html>
