<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add New Summon</strong>
                            </div>
                            <form action="summon_add_process.php" method="post">
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
                                        	<label for="driver_name" class=" form-control-label"><small class="form-text text-muted">Driver's Name<span class="color-red">*</span></small></label>
                                            <input type="text" id="driver_name" name="driver_name" placeholder="Enter driver's name" class="form-control" required>
                                            
                                        </div>                                        
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="summon_no" class=" form-control-label"><small class="form-text text-muted">Summon's No.<span class="color-red">*</span></small></label>
                                            <input type="text" id="summon_no" name="summon_no" placeholder="Enter summon number" class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="summon_type" class=" form-control-label"><small class="form-text text-muted">Summon's Type<span class="color-red">*</span></small></label>                                             
                                            <?php
                                                $summon_type = mysqli_query ( $conn_admin_db, "SELECT st_id, st_name FROM vehicle_summon_type");
                                                db_select ($summon_type, 'summon_type', '','','-select-','form-control','','required');
                                            ?>
                                        </div>
                                        <!-- Only appear when summon type selected is others -->
                                        <div class="col-sm-4" id="desc">
                                            <label for="summon_desc" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                                    		<textarea id="summon_desc" name="summon_desc" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-4">
                                            <label for="pv_no" class=" form-control-label"><small class="form-text text-muted">PV No.<span class="color-red">*</span></small></label>
                                            <input type="text" id="pv_no" name="pv_no" placeholder="Enter PV number" class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="reimburse_amt" class=" form-control-label"><small class="form-text text-muted">Reimburse Amount(RM)<span class="color-red">*</span></small></label>
                                            <input type="text" id="reimburse_amt" name="reimburse_amt" onkeypress="return isNumberKey(event)" placeholder="e.g 500.00" class="form-control" required>
                                        </div>                                        
                                    </div>
                                    <div class="form-group col-sm-12">
                                    	<div class="col-sm-12">     
                                    		<label class="form-control-label"><small class="form-text text-muted">Payment borne by<span class="color-red">*</span></small></label>
                                    	</div>
                                    	<div class="form-group row col-sm-4">     
                                    		<div class="col-sm-4">
                                    			<input type="checkbox" id="driver_borne" name="driver_borne">&nbsp;&nbsp;<label class="form-control-label"><small>Driver</small></label>
                                    		</div>
                                    		<div class="borne_by_driver col-sm-8" style="display: none;">
                                    			<select name="driver_b" id="driver_b" class="form-control form-control-sm">
                                    				<option value="half">Half</option>
                                    				<option value="full">Full</option>
                                    			</select>
                                    		</div>                                                                                   
                                        </div>
                                        <div class="form-group row col-sm-4">     
                                    		<div class="col-sm-4">
                                    			<input type="checkbox" id="company_borne" name="company_borne">&nbsp;&nbsp;<label class="form-control-label"><small>Company</small></label>
                                    		</div>
                                    		<div class="borne_by_company col-sm-8" style="display: none;">
                                    			<select name="company_b" id="company_b" class="form-control form-control-sm">
                                    				<option value="half">Half</option>
                                    				<option value="full">Full</option>
                                    			</select>
                                    		</div>                                                                                   
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">                                          
                                        <div class="col-sm-4">
                                            <label for="summon_date" class=" form-control-label"><small class="form-text text-muted">Summon's Date<span class="color-red">*</span></small></label>
                                            <div class="input-group">
                                                <input id="summon_date" name="summon_date" class="form-control" autocomplete="off" required>
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <label for="offence_details" class=" form-control-label"><small class="form-text text-muted">Offense Details</small></label>                                             
                                            <textarea name="offence_details" id="offence_details" name="offence_details" rows="5" placeholder="Offense details..." class="form-control"></textarea>
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
        	
          $('#desc').hide(); 
          $('#summon_type').change(function(){
              if($('#summon_type').val() == 3) {
                  $('#desc').show(); 
              } else {
                  $('#desc').hide(); 
              } 
          });

          $('#company_borne').change(function(){
        	  $('.borne_by_company').toggle();
          });

          $('#driver_borne').change(function() {
              $('.borne_by_driver').toggle();
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
