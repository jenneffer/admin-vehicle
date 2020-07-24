<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');	
    
    $acc_id = isset($_GET['id']) ? $_GET['id']: "";
    $item_id = isset($_GET['item_id']) ? $_GET['item_id']: "";
    $header_title = !empty($item_id) ? "Edit Premium Insurance" : "Add Premium Insurance";
    
    $query = "SELECT * FROM bill_management_insurance WHERE id='$item_id'";
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $invoice_no = $row['invoice_no'];
        $date_paid = dateFormatRev($row['date_paid']);
        $description = $row['description'];
        $payment = $row['payment'];
        $payment_mode = $row['payment_mode'];
        $or_no = $row['or_no'];
        $date_from = dateFormatRev($row['date_from']);
        $date_to = dateFormatRev($row['date_to']);
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
	<?php include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <!-- /#header -->
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title"><?=$header_title?></strong>
                            </div>
                            <form id="add_premium_insurance" role="form" action="" method="post">
                                <input type="hidden" id="acc_id" name="acc_id" class="form-control">
                                <input type="hidden" id="item_id" name="item_id" class="form-control">
                                <div class="card-body card-block">
                                    <div class="form-group row col-sm-12">                                        	                                          
                                        <div class="col-sm-4">
                                            <label for="date_from" class=" form-control-label"><small class="form-text text-muted">Date From <span class="color-red">*</span></small></label>                                            
                                            <div class="input-group">
                                                <input id="date_from" name="date_from" value="<?=$date_from?>" class="form-control" autocomplete="off" required>
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>  
                                        <div class="col-sm-4">
                                            <label for="date_to" class=" form-control-label"><small class="form-text text-muted">Date To <span class="color-red">*</span></small></label>                                            
                                            <div class="input-group">
                                                <input id="date_to" name="date_to" value="<?=$date_to?>" class="form-control" autocomplete="off" required>
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice No. <span class="color-red">*</span></small></label>                                            
                                            <div class="input-group">
                                                <input id="invoice_no" name="invoice_no" value="<?=$invoice_no?>" class="form-control" autocomplete="off" required>                                                
                                            </div>  
                                        </div>                              
                                    </div>                                                                         
									<div class="form-group row col-sm-12">										  
                                        <div class="col-sm-4">
                                            <label for="charged_amt" class=" form-control-label"><small class="form-text text-muted">Payment (RM) <span class="color-red">*</span></small></label>                                            
                                            <div class="input-group">
                                                <input id="charged_amt" name="charged_amt" value="<?=$payment?>" class="form-control" autocomplete="off" required>                                                
                                            </div>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>                                            
                                            <select id="payment_mode" name="payment_mode" class="form-control">
                                        		<option value="">- Select -</option>
                                        		<option value="cash"<?php if($payment_mode == "cash") echo "selected"?>>Cash</option>
                                        		<option value="ibg" <?php if($payment_mode == "ibg") echo "selected"?>>IBG</option>
                                        	</select>  
                                        </div> 
                                        <div class="col-sm-4">
                                            <label for="or_no" class=" form-control-label"><small class="form-text text-muted">OR No. <span class="color-red">*</span></small></label>                                            
                                            <div class="input-group">
                                                <input id="or_no" name="or_no" value="<?=$or_no?>" class="form-control" autocomplete="off" required>                                                
                                            </div>  
                                        </div>                                       
									</div>   
									<div class="form-group row col-sm-12">	
										<div class="col-sm-4">
                                            <label for="paid_date" class=" form-control-label"><small class="form-text text-muted">Paid Date</small></label>                                            
                                            <div class="input-group">
                                                <input id="paid_date" name="paid_date" value="<?=$date_paid?>" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>	
										<div class="col-sm-4">
                                            <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>                                            
                                            <div class="input-group">
                                                <textarea id="description" name="description" class="form-control" autocomplete="off"><?=$description?></textarea>                                               
                                            </div>  
                                        </div>
									</div>                                                                                                                                
                                    <div class="card-body">
                                        <?php if(!empty($item_id)){?>
                                        <button type="submit" id="update" name="update" class="btn btn-primary">Update</button>
                                        <?php }else{?>
                                            <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                                        <?php }?>
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
        var item_id = '<?=$item_id?>';  	
        $('#add_premium_insurance').on("submit", function(event){  
        	$('#acc_id').val(acc_id); 
        	$('#item_id').val(item_id);
        	event.preventDefault();  
        	var action = ( item_id!='' ) ? 'update_premium_insurance' : 'add_premium_insurance';      	           	                                    
            $.ajax({  
                url:"add_bill.ajax.php",  
                method:"POST",  
                data:{action:action, data : $('#add_premium_insurance').serialize()},  
                success:function(data){ 
                    if(data){
                    	alert("Successfully added!");
						window.location.replace("management_account_details.php?id="+acc_id);                                                   	 
                	}  
                }
			});          	  
        });

        $('#date_from, #date_to, #paid_date').datepicker({
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