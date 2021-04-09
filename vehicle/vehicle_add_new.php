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
            <form action="vehicle_add_process.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add New Vehicle</strong>
                            </div>                            
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No. <span class="color-red">*</span></small></label>
                                            <input type="text" id="vehicle_reg_no" name="vehicle_reg_no" placeholder="Enter vehicle registration no." class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="category" class=" form-control-label"><small class="form-text text-muted">Vehicle Category <span class="color-red">*</span></small></label>
                                            <?php
                                                $cat = mysqli_query ( $conn_admin_db, "SELECT vc_id, vc_type FROM vehicle_category");
                                                db_select ($cat, 'category', '','','-select-','form-control','','required');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="company" class=" form-control-label"><small class="form-text text-muted">Company <span class="color-red">*</span></small></label>
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE vehicle_used='1'");
                                                db_select ($company, 'company', '','','-select-','form-control','','required');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="brand" class=" form-control-label"><small class="form-text text-muted">Make <span class="color-red">*</span></small></label>
                                            <input type="text" id="brand" name="brand" placeholder="Enter vehicle brand" class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="model" class=" form-control-label"><small class="form-text text-muted">Model <span class="color-red">*</span></small></label>
                                            <input type="text" id="model" name="model" placeholder="Enter vehicle model" class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="yearMade" class=" form-control-label"><small class="form-text text-muted">Year Made <span class="color-red">*</span></small></label>
                                    		<input type="text" id="yearMade" name="yearMade" onkeypress="return isNumberKey(event)" placeholder="e.g 2010" class="form-control" required>
                                        </div>
                                    </div>                                    
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="engine_no" class=" form-control-label"><small class="form-text text-muted">Engine No. <span class="color-red">*</span></small></label>
                                            <input type="text" id="engine_no" name="engine_no" placeholder="Enter engine no." class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="chasis_no" class=" form-control-label"><small class="form-text text-muted">Chasis No. <span class="color-red">*</span></small></label>
                                            <input type="text" id="chasis_no" name="chasis_no" placeholder="Enter chasis no." class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="capacity" class=" form-control-label"><small class="form-text text-muted">Goods Capacity (CC) <span class="color-red">*</span></small></label>
                                            <input type="text" id="capacity" name="capacity" class="form-control" required>
                                        </div>
                                    </div>      
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="bdm" class=" form-control-label"><small class="form-text text-muted">B.D.M/B.G.K</small></label>
                                            <input type="text" id="bdm" name="bdm" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="btm" class=" form-control-label"><small class="form-text text-muted">B.T.M</small></label>
                                            <input type="text" id="btm" name="btm" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="dispose" class=" form-control-label"><small class="form-text text-muted">Dispose</small></label>
                                            <input type="text" id="dispose" name="dispose" class="form-control">
                                        </div> 
                                    </div>  
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="driver" class=" form-control-label"><small class="form-text text-muted">Driver</small></label>
                                            <input type="text" id="driver" name="driver" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="finance" class=" form-control-label"><small class="form-text text-muted">Finance</small></label>
                                            <input type="text" id="finance" name="finance" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="finance" class="form-control-label"><small class="form-text text-muted">Vehicle Status</small></label>
                                            <select id="vehicle_status" name="" class="form-control">
                                              <option value="active">Active</option>
                                              <option value="inactive">Inactive</option>
                                              <option value="not_sure">Not Sure</option>
                                              <option value="total_loss">Total Loss</option>
                                            </select>
                                        </div>
                                         
                                    </div>                              
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-8">
                                            <label for="v_remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>                                             
                                            <textarea id="v_remark" name="v_remark" rows="3" class="form-control"></textarea>
                                        </div>                                                                              
                                    </div>                                    
                                </div>                            
                        </div>                                                
                    </div>
                    <div class="col-md-12">
                    	<div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add LPKP Permit</strong>
                            </div>                            
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                		<div class="col-sm-6"> 
                                            <label for="permit_type" class=" form-control-label"><small class="form-text text-muted">Type</small></label>
                                            <input type="text" id="permit_type" name="permit_type" placeholder="Enter permit type" class="form-control">
                                        </div>
										<div class="col-sm-6">                                        
                                            <label for="permit_no" class=" form-control-label"><small class="form-text text-muted">No.</small></label>
                                    		<input type="text" id="permit_no" name="permit_no" onkeypress="return isNumberKey(event)" class="form-control">
                                    	</div>
                                    </div>
                                    
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6"> 
                                            <label for="license_ref_no" class=" form-control-label"><small class="form-text text-muted">License Ref No.</small></label>
                                            <input type="text" id="license_ref_no" name="license_ref_no" placeholder="Enter license ref no." class="form-control">
                                    	</div>
                                    	<div class="col-sm-6"> 
                                    		<label for="lpkp_permit_due_date" class=" form-control-label"><small class="form-text text-muted">Due Date</small></label>
                                            <div class="input-group">
                                                <input id="lpkp_permit_due_date" name="lpkp_permit_due_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
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
    	var select2 = $("#company").select2({
//     		placeholder: "select option",
    	    selectOnClose: true
        });
    	select2.data('select2').$selection.css('height', '38px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da');

        $('#lpkp_permit_due_date').datepicker({
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
