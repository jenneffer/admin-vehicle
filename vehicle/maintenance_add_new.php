<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;

?>

<!doctype html>
<html class="no-js" lang="">
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
            <form action="maintenance_add_process.php" method="post" id="maintenance_form">
                <div class="row">
                    <div class="col-md-12">
                    	<div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add Maintenance</strong>
                            </div>                            
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                		<div class="col-sm-4">
                                            <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.<span class="color-red">*</span></small></label>
                                            <?php
                                                $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                                db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','','required');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="workshop" class=" form-control-label"><small class="form-text text-muted">Workshop<span class="color-red">*</span></small></label>
                                            <?php
                                                $workshop = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM vehicle_workshop");
                                                db_select ($workshop, 'workshop', '','','-select-','form-control','','required');
                                            ?>
                                        </div>
                                        <div class="col-sm-4"> 
                                    		<label for="date" class=" form-control-label"><small class="form-text text-muted">Invoice Date<span class="color-red">*</span></small></label>
                                            <div class="input-group">
                                                <input id="date" name="date" class="form-control" autocomplete="off" required>
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                    	</div>									
                                    </div>
                                    
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6"> 
                                            <label for="irf_no" class=" form-control-label"><small class="form-text text-muted">IRF No.<span class="color-red">*</span></small></label>
                                            <input type="text" id="irf_no" name="irf_no" class="form-control" required>
                                    	</div>
                                    	<div class="col-sm-6"> 
                                            <label for="irf_date" class=" form-control-label"><small class="form-text text-muted">IRF Date</small></label>
                                            <input type="text" id="irf_date" name="irf_date" class="form-control">
                                    	</div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6"> 
                                            <label for="po_no" class=" form-control-label"><small class="form-text text-muted">P.O No.<span class="color-red">*</span></small></label>
                                            <input type="text" id="po_no" name="po_no" class="form-control" required>
                                    	</div>
                                    	<div class="col-sm-6"> 
                                            <label for="po_date" class=" form-control-label"><small class="form-text text-muted">P.O Date</small></label>
                                            <input type="text" id="po_date" name="po_date" class="form-control">
                                    	</div>                                    	                                    	
                                    </div>
                                     <div class="form-group row col-sm-12">
                                     	<div class="col-sm-6">                                        
                                            <label for="inv_no" class=" form-control-label"><small class="form-text text-muted">Invoice No.<span class="color-red">*</span></small></label>
                                    		<input type="text" id="inv_no" name="inv_no" class="form-control" required>
                                    	</div>
                                    	<div class="col-sm-6">                                        
                                            <label for="amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM)<span class="color-red">*</span></small></label>
                                    		<input type="text" id="amount" name="amount" onkeypress="return isNumberKey(event)" class="form-control" required>
                                    	</div>
                                     </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">                                        
                                                <label for="user" class=" form-control-label"><small class="form-text text-muted">User<span class="color-red">*</span></small></label>
                                    		<input type="text" id="user" name="user" class="form-control" required>
                                    	</div>
                                    	<div class="col-sm-6"> 
                                            <label for="desc" class=" form-control-label"><small class="form-text text-muted">Remarks<span class="color-red"></span></small></label>
                                            <textarea id="desc" name="desc" class="form-control"></textarea>
                                    	</div>
                                	</div> 
                                </div>                                                           
                        </div>  
                     </div>         
                </div>
                <div class="card-body">
                    <div class="submit-button">
                        <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                        <button type="button" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
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
    <!-- from right panel page -->
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
    	// Initialize select2 
    	var select2 = $("#vehicle_reg_no").select2({
    	    selectOnClose: true
        });
    	
    	select2.data('select2').$selection.css('height', '38px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da');

    	var select3 = $("#workshop").select2({
    	    selectOnClose: true
        });
    	select3.data('select2').$selection.css('height', '38px');
    	select3.data('select2').$selection.css('border', '1px solid #ced4da');

    	$('#date,#po_date, #irf_date').datepicker({
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
