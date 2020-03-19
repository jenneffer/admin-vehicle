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
        .button_add{
            position: absolute;
            left:    0;
            bottom:   0;
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
                                <strong class="card-title">Add Quit Rent Billing</strong>
                            </div>
                            <form id="add_quit_rent_billing" role="form" action="" method="post">
                                <div class="card-body card-block">
                                    <div class="form-group row col-sm-12">                                        	
                                        <div class="col-sm-4">
                                            <label for="invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice No.</small></label>                                            
                                            <div class="input-group">
                                                <input id="invoice_no" name="invoice_no" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>  
                                        <div class="col-sm-4">
                                            <label for="invoice_date" class=" form-control-label"><small class="form-text text-muted">Invoice Date</small></label>                                            
                                            <div class="input-group">
                                                <input id="invoice_date" name="invoice_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>  
                                        <div class="col-sm-4">
                                            <label for="paid_date" class=" form-control-label"><small class="form-text text-muted">Paid Date</small></label>                                            
                                            <div class="input-group">
                                                <input id="paid_date" name="paid_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>                               
                                    </div>                                                                         
									<div class="form-group row col-sm-12 date">										  
                                        <div class="col-sm-4">
                                            <label for="charged_amt" class=" form-control-label"><small class="form-text text-muted">Payment (RM)</small></label>                                            
                                            <div class="input-group">
                                                <input id="charged_amt" name="charged_amt" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>                                            
                                            <select id="payment_mode" name="payment_mode" class="form-control">
                                        		<option value="">- Select -</option>
                                        		<option value="cash">Cash</option>
                                        		<option value="ibg">IBG</option>
                                        	</select>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="or_no" class=" form-control-label"><small class="form-text text-muted">OR No.</small></label>                                            
                                            <div class="input-group">
                                                <input id="or_no" name="or_no" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>                                       
									</div>   
									<div class="form-group row col-sm-12 date">
										<div class="col-sm-4">
                                            <label for="due_date" class=" form-control-label"><small class="form-text text-muted">Due Date</small></label>                                            
                                            <div class="input-group">
                                                <input id="due_date" name="due_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="received_date" class=" form-control-label"><small class="form-text text-muted">Received Date</small></label>                                            
                                            <div class="input-group">
                                                <input id="received_date" name="received_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remarks</small></label>                                            
                                            <div class="input-group">
                                                <textarea id="remark" name="remark" class="form-control" autocomplete="off"></textarea>                                               
                                            </div>  
                                        </div>
									</div>                                                                                                                                 
                                    <div class="card-body">
                                        <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                                        <button type="button" id="cancel" name="cancel" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>
        </div>
        <div>
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
        $('#add_quit_rent_billing').on("submit", function(event){  
            event.preventDefault();                        
            $.ajax({  
                url:"add_bill.ajax.php",  
                method:"POST",  
                data:{action:'add_quit_rent_billing', data : $('#add_quit_rent_billing').serialize()},  
                success:function(data){ 
                    location.reload();                                                        	 
                }  
           });    
        });

        $('#invoice_date, #due_date, #received_date,#paid_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
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
<style>
.table{
    font-size:14px;
}
</style>
</html>