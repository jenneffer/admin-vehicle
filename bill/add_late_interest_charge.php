<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;
	
	$acc_id = isset($_GET['id']) ? $_GET['id'] : "";
	
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
                                <strong class="card-title">Add Late Interest Charge</strong>
                            </div>
                            <form id="add_late_interest_charge" role="form" action="" method="post">
                            <input type="hidden" id="acc_id" name="acc_id" class="form-control">
                                <div class="card-body card-block">
                                    <div class="form-group row col-sm-12"> 
                                       	<div class="col-sm-4">
                                            <label for="bill_date" class=" form-control-label"><small class="form-text text-muted">Bill Date</small></label>                                            
                                            <div class="input-group">
                                                <input id="bill_date" name="bill_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>   
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice No.</small></label>                                            
                                            <div class="input-group">
                                                <input id="invoice_no" name="invoice_no" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>  
                                        <div class="col-sm-4">
                                            <label for="payment_due_date" class=" form-control-label"><small class="form-text text-muted">Payment due date</small></label>                                            
                                            <div class="input-group">
                                                <input id="payment_due_date" name="payment_due_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>                                 
                                    </div>                                                                         
									<div class="form-group row col-sm-12 date">										  
                                        <div class="col-sm-4">
                                            <label for="charged_amt" class=" form-control-label"><small class="form-text text-muted">Amount (RM)</small></label>                                            
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
                                            <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>                                            
                                            <div class="input-group">
                                                <textarea id="description" name="description" class="form-control" autocomplete="off"></textarea>                                               
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
        
    	var acc_id = '<?=$acc_id?>';
    	  	
        $('#add_late_interest_charge').on("submit", function(event){  
            event.preventDefault();  

            $('#acc_id').val(acc_id); 
            
            if($('#bill_date').val() == ""){  
                alert("Bill date is required");  
            }
            else if($('#invoice_no').val() == ""){  
                alert("Invoice number is required");  
            }
            else if($('#payment_due_date').val() == ""){  
                alert("Payment due date is required");  
            }
            else if($('#charged_amt').val() == ""){  
                alert("Charge amount is required");  
            }
            else if($('#or_no').val() == ""){  
                alert("Official receipt number is required");  
            }
            else if($('#payment_mode').val() == ""){  
                alert("Payment mode is required");  
            }
            else if($('#description').val() == ""){  
                alert("Description is required");  
            }
            else{
            	$.ajax({  
                    url:"add_bill.ajax.php",  
                    method:"POST",  
                    data:{action:'add_late_interest_charge', data : $('#add_late_interest_charge').serialize()},  
                    success:function(data){ 
                        location.reload();                                                        	 
                    }  
                });
            }                       
                
        });

        $('#bill_date, #payment_due_date').datepicker({
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