<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;
	
	$acc_id = isset($_GET['id']) ? $_GET['id'] : "";
	$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';
	
	$header_title = !empty($item_id) ? "Edit Management Bill" : "Add New Management Bill";
	
	$query = "SELECT * FROM bill_management_fee WHERE id='$item_id'";
	$result  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
	if(mysqli_num_rows($result) > 0){
	    $row = mysqli_fetch_assoc($result);
	    $description = $row['description'];
	    $payment_amount = $row['payment_amount'];
	    $payment_mode = $row['payment_mode'];
	    $official_receipt_no = $row['official_receipt_no'];
	    $ref_no = $row['ref_no'];
	    $payment_date = dateFormatRev($row['payment_date']);
	    $received_date = dateFormatRev($row['received_date']);
	    $remark = $row['remark'];
	    $cheque_no = $row['cheque_no'];	    
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
                            <div class="modal-body">
                                <form role="form" method="POST" action="" id="add_form">  
                                <input type="hidden" id="acc_id" name="acc_id" value="">    
                                <input type="hidden" id="item_id" name="item_id" value=""> 
                                <div class="form-group row col-sm-12">                    	
                                	<div class="col-sm-6">
                                        <label for="payment_date" class=" form-control-label"><small class="form-text text-muted">Payment date <span class="color-red">*</span></small></label>                                            
                                        <div class="input-group">
                                            <input id="payment_date" name="payment_date" value="<?=$payment_date?>" class="form-control" autocomplete="off" required>
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        </div>  
                                    </div>       
                                    <div class="col-sm-6">
                                        <label for="receive_date" class=" form-control-label"><small class="form-text text-muted">Received date </small></label>                                            
                                        <div class="input-group">
                                            <input id="receive_date" name="receive_date" value="<?=$received_date?>" class="form-control" autocomplete="off">
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        </div>  
                                    </div>
                                </div>                                                    
                                <div class="row form-group col-sm-12">
                                    <div class="col-sm-6">
                                        <label for="invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice No. <span class="color-red">*</span></small></label>
                                        <input type="text" id="invoice_no" name="invoice_no" value="<?=$ref_no?>" class="form-control" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                                        <textarea id="description" name="description" class="form-control"><?=$description?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group col-sm-12">
                                    <div class="col-sm-6">
                                        <label for="payment" class=" form-control-label"><small class="form-text text-muted">Payment Amount (RM) <span class="color-red">*</span></small></label>
                                        <input type="text" id="payment" name="payment" value="<?=$payment_amount?>" class="form-control" required>
                                    </div>        
                                    <div class="col-sm-6">
                                        <label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>
                                        <select id="payment_mode" name="payment_mode" class="form-control" >
                                    		<option value="">- Select -</option>
                                    		<option value="cash"<?php if($payment_mode == "cash") echo "selected"?>>Cash</option>
                                    		<option value="ibg" <?php if($payment_mode == "ibg") echo "selected"?>>IBG</option>
                                    	</select>
                                    </div>
                                </div>
                                <div class="row form-group col-sm-12">  
                                	<div class="col-sm-6">
                                        <label for="cheque_no" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                                        <input type="text" id="cheque_no" name="cheque_no" value="<?=$cheque_no?>" class="form-control">
                                    </div>                                   	
                                    <div class="col-sm-6">
                                        <label for="or_no" class=" form-control-label"><small class="form-text text-muted">Official Receipt No.</small></label>
                                        <input type="text" id="or_no" name="or_no" value="<?=$official_receipt_no?>" class="form-control">
                                    </div>        
                                </div>    
                                <div class="row form-group col-sm-12"> 
                                	<div class="col-sm-6">
                                        <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                                        <textarea id="remark" name="remark" class="form-control"><?=$remark?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <?php if(!empty($item_id)){?>
                                    	<button type="submit" class="btn btn-primary save_data ">Update</button>
                                    <?php }else{?>
                                    	<button type="submit" class="btn btn-primary save_data ">Save</button>
                                    <?php }?>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>
        </div>
        <div>
        </div>
        <!-- Modal add telefon list  -->        
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
        $('#add_form').on("submit", function(event){  
            event.preventDefault();   
            $('#acc_id').val(acc_id);      
            $('#item_id').val(item_id); 
            var action = (item_id !='') ? 'update_management_bill' : 'add_management_bill';     
            $.ajax({  
                url:"add_bill.ajax.php",  
                method:"POST",  
                data:{action:action, data : $('#add_form').serialize()},  
                success:function(data){
                    if(data){
						alert("Successfully added!");						
						window.location.replace("management_account_details.php?id="+acc_id);
                	}                    
                }  
           });    
        });

        $('#payment_date, #receive_date').datepicker({
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
