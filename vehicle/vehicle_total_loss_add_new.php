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
            <form action="vehicle_total_loss_add_process.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Add New Total Loss</strong>
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
                                        <label for="insurance" class=" form-control-label"><small class="form-text text-muted">Insurance <span class="color-red">*</span></small></label>
                                        <input type="text" id="insurance" name="insurance" placeholder="Enter insurance name" class="form-control" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM)<span class="color-red">*</span></small></label>
                                		<input type="text" id="amount" name="amount" onkeypress="return isNumberKey(event)" placeholder="e.g 50.00" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">                                        
                                    <div class="col-sm-4">
                                        <label for="offer_letter_date" class=" form-control-label"><small class="form-text text-muted">Offer Letter Date<span class="color-red">*</span></small></label>
                                        <div class="input-group">
                                            <input id="offer_letter_date" name="offer_letter_date" class="form-control" autocomplete="off" required>
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="payment_advice_date" class=" form-control-label"><small class="form-text text-muted">Payment Advice Date<span class="color-red">*</span></small></label>
                                        <div class="input-group">
                                            <input id="payment_advice_date" name="payment_advice_date" class="form-control" autocomplete="off" required>
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                    
                                </div>                                    
                                <div class="form-group row col-sm-12">                                        
                                    <div class="col-sm-4">
                                        <label for="beneficiary_bank" class=" form-control-label"><small class="form-text text-muted">Beneficiary Bank<span class="color-red">*</span></small></label>
                                        <input type="text" id="beneficiary_bank" name="beneficiary_bank" placeholder="Enter beneficiary bank" class="form-control" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="transaction_ref_no" class=" form-control-label"><small class="form-text text-muted">Transaction Reference No.<span class="color-red">*</span></small></label>
                                        <input type="text" id="transaction_ref_no" name="transaction_ref_no" class="form-control" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="driver" class=" form-control-label"><small class="form-text text-muted">Driver</small></label>
                                        <input type="text" id="driver" name="driver" class="form-control">
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
    $(document).ready(function(){
    	// Initialize select2
        var select2 = $("#vehicle_reg_no").select2({   
            selectOnClose: true
        });
        select2.data('select2').$selection.css('height', '38px');
        select2.data('select2').$selection.css('border', '1px solid #ced4da');
        
        $('#offer_letter_date, #payment_advice_date').datepicker({
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
