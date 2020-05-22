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
                                <strong class="card-title">Add New Bill</strong>
                            </div>
                            <form id="add_new_bill" role="form" action="" method="post">
                                <div class="card-body card-block">
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label class="control-label "><small class="form-text text-muted">Bill Type</small></label>                                  
                                            <?php                                            
                                                $arr_bill_type = mysqli_query ( $conn_admin_db, "SELECT id, name FROM bill_billtype");
                                                db_select ($arr_bill_type, 'bill_type','','','-select-','form-control','');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label "><small class="form-text text-muted">Account No.</small></label>                                  
                                            <select id="sel_account" name="sel_account" class="form-control">
                                               <option value="0">- select -</option>
                                            </select>
                                        </div> 
                                        <div class="col-sm-4" id="cheque_no">
                                            <label for="cheque_no" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                                            <input type="text" id="cheque_no" name="cheque_no" placeholder="Enter cheque number" class="form-control">
                                        </div>                                
                                    </div>                                   
                                    <div class="form-group row col-sm-12 date">
                                    	<div class="col-sm-12">
                                        	<label class=" form-control-label"><small class="form-text text-muted">Period</small></label>       
                                        </div>
                                    	<div class="col-sm-3">
                                            <label for="from_date" class=" form-control-label"><small class="form-text text-muted">From date</small></label>                                            
                                            <div class="input-group">
                                                <input id="from_date" name="from_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>       
                                        <div class="col-sm-3">
                                            <label for="to_date" class=" form-control-label"><small class="form-text text-muted">To date</small></label>                                            
                                            <div class="input-group">
                                                <input id="to_date" name="to_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>  
                                        <div class="col-sm-3">
                                            <label for="paid_date" class=" form-control-label"><small class="form-text text-muted">Paid date</small></label>                                            
                                            <div class="input-group">
                                                <input id="paid_date" name="paid_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>       
                                        <div class="col-sm-3">
                                            <label for="due_date" class=" form-control-label"><small class="form-text text-muted">Due date</small></label>                                            
                                            <div class="input-group">
                                                <input id="due_date" name="due_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>                                     
                                    </div>  
                                    <!-- div for sesb -->
                                    <div id="1" class="billing">
                                        <div class="col-sm-12">
                                        	<label class=" form-control-label"><small class="form-text text-muted">Meter Reading</small></label>       
                                        </div>
                                        <div class="row form-group col-sm-12">                                            
                                            <div class="col-sm-3">
                                                <label for="reading_from" class=" form-control-label"><small class="form-text text-muted">From</small></label>
                                                <input type="text" id="reading_from" name="reading_from" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="reading_to" class=" form-control-label"><small class="form-text text-muted">To</small></label>
                                                <input type="text" id="reading_to" name="reading_to" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="current_usage" class=" form-control-label"><small class="form-text text-muted">Current Usage (RM)</small></label>
                                                <input type="text" id="current_usage" name="current_usage" placeholder="Enter current usage" class="form-control">
                                            </div>        
                                            <div class="col-sm-3">
                                                <label for="kwtbb" class=" form-control-label"><small class="form-text text-muted">KWTBB (RM)</small></label>
                                                <input type="text" id="kwtbb" name="kwtbb" placeholder="Enter KWTBB" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group col-sm-12">                                     	
                                            <div class="col-sm-3">
                                                <label for="penalty" class=" form-control-label"><small class="form-text text-muted">Penalty (RM)</small></label>
                                                <input type="text" id="penalty" name="penalty" placeholder="Enter penalty amount" class="form-control">
                                            </div>        
                                            <div class="col-sm-3">
                                                <label for="power_factor" class=" form-control-label"><small class="form-text text-muted">Power Factor (<0.85)</small></label>
                                                <input type="text" id="power_factor" name="power_factor" placeholder="Enter power factor unit" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="additional_depo" class=" form-control-label"><small class="form-text text-muted">Additional Deposit (RM)</small></label>
                                                <input type="text" id="additional_depo" name="additional_depo" placeholder="Enter additional amount" class="form-control">
                                            </div>        
                                            <div class="col-sm-3">
                                                <label for="other_charges" class=" form-control-label"><small class="form-text text-muted">Other Charges (RM)</small></label>
                                                <input type="text" id="other_charges" name="other_charges" placeholder="Enter other charges" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- div for jabatan air -->
                                    <div id="2" class="billing">
                                        <div class="col-sm-12">
                                        	<label class=" form-control-label"><small class="form-text text-muted">Meter Reading</small></label>       
                                        </div>
                                        <div class="row form-group col-sm-12">
                                            <div class="col-sm-3">
                                                <label for="read_from" class=" form-control-label"><small class="form-text text-muted">From</small></label>
                                                <input type="text" id="read_from" name="read_from" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="read_to" class=" form-control-label"><small class="form-text text-muted">To</small></label>
                                                <input type="text" id="read_to" name="read_to" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="usage_1" class=" form-control-label"><small class="form-text text-muted">M3 (0-70)</small></label>
                                                <input type="text" id="usage_1" name="usage_1" class="form-control">
                                            </div>        
                                            <div class="col-sm-3">
                                                <label for="usage_2" class=" form-control-label"><small class="form-text text-muted">M3 (>70)</small></label>
                                                <input type="text" id="usage_2" name="usage_2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group col-sm-12">                                     	
                                            <div class="col-sm-3">
                                                <label for="credit" class=" form-control-label"><small class="form-text text-muted">Credit (RM)</small></label>
                                                <input type="text" id="credit" name="credit" class="form-control">
                                            </div>        
                                        </div>
                                    </div>
                                    <!-- div for telekom -->     
                                    <div id="3" class="billing">
                                    	<div class="row form-group col-sm-12">                                     	
                                            <div class="col-sm-3" id="bill_no">
                                                <label for="bill_no" class=" form-control-label"><small class="form-text text-muted">Bill No.</small></label>
                                                <input type="text" id="bill_no" name="bill_no" class="form-control">
                                            </div>  
                                            <div class="col-sm-3">
                                                <label for="monthly_fee" class=" form-control-label"><small class="form-text text-muted">Monthly (RM)</small></label>
                                                <input type="text" id="monthly_fee" name="monthly_fee" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="rebate" class=" form-control-label"><small class="form-text text-muted">Rebate (RM)</small></label>
                                                <input type="text" id="rebate" name="rebate" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="cr_adjustment" class=" form-control-label"><small class="form-text text-muted">Credit Adjustment (RM)</small></label>
                                                <input type="text" id="cr_adjustment" name="cr_adjustment" class="form-control">
                                            </div>      
                                        </div>
                                        <div class="row form-group col-sm-12">
                                        	<div class="col-sm-3">
                                            	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_phone">Add telephone bill</button>
                                            </div>
                                        </div>
                                        <br/>
                                        <table id="telefon_list" class="table table-bordered data-table">
                                        <thead>
                                          <th>Telephone No.</th>
                                          <th>Type</th>
                                          <th>Usage (RM)</th>
                                          <th width="200px">Action</th>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                        </table>
                                    </div>  
                                    <!-- div for celcom -->  
                                    <div id="4" class="billing">
                                    <div class="row form-group col-sm-12"> 
                                    	<div class="col-sm-3">
                                            <label for="date_entered" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                                            <div class="input-group">
                                                <input type="text" id="date_entered" name="date_entered" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    	<div class="col-sm-3">
                                            <label for="bill_amount" class=" form-control-label"><small class="form-text text-muted">Bill Amount (RM)</small></label>
                                            <input type="text" id="bill_amount" name="bill_amount" class="form-control">
                                        </div>                                        
                                    </div>
                                    </div>  
                                    <!-- div for fujixerox -->  
                                    <div id="5" class="billing">
                                    <div class="row form-group col-sm-12">
                                    	<div class="col-sm-3">
                                    		<label class=" form-control-label">Meter Reading (Based on Machine)</label>
                                    	</div>                                    	
                                    </div>    
                                    <div class="row form-group col-sm-12">
                                    	<div class="col-sm-4">
                                            <label for="date_entered_fx" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                                            <div class="input-group">
                                                <input type="text" id="date_entered_fx" name="date_entered_fx" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>                                                                    	 
                                    <div class="row form-group col-sm-12">
                                    	<div class="col-sm-4">
                                            <label for="full_color" class=" form-control-label"><small class="form-text text-muted">Full Color</small></label>
                                            <input type="text" id="full_color" name="full_color" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="black_white" class=" form-control-label"><small class="form-text text-muted">B/W</small></label>
                                            <input type="text" id="black_white" name="black_white" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="color_a3" class=" form-control-label"><small class="form-text text-muted">Color A3</small></label>
                                            <input type="text" id="color_a3" name="color_a3" class="form-control" autocomplete="off">
                                        </div>                                    
                                    </div>
                                    <div class="row form-group col-sm-12">
                                    	<div class="col-sm-4">
                                            <label for="copy" class=" form-control-label"><small class="form-text text-muted">Copy</small></label>
                                            <input type="text" id="copy" name="copy" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="print" class=" form-control-label"><small class="form-text text-muted">Print</small></label>
                                            <input type="text" id="print" name="print" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="fax" class=" form-control-label"><small class="form-text text-muted">Fax</small></label>
                                            <input type="text" id="fax" name="fax" class="form-control" autocomplete="off">
                                        </div>                                    
                                    </div>
                                    </div>       
                                    <!-- div for management fee -->  
                                    <div id="6" class="billing">
                                    	<div class="row form-group col-sm-12">
                                        	<div class="col-sm-4">
                                                <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                                                <input type="text" id="description" name="description" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="payment" class=" form-control-label"><small class="form-text text-muted">Payment (RM)</small></label>
                                                <input type="text" id="payment" name="payment" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="col-sm-4">
                                            	<label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>
                                            	<select id="payment_mode" name="payment_mode" class="form-control">
                                            		<option value="">- Select -</option>
                                            		<option value="cash">Cash</option>
                                            		<option value="ibg">IBG</option>
                                            	</select>
                                            </div>                                 
                                        </div>
                                        <div class="row form-group col-sm-12">
                                        <div class="col-sm-4">
                                                <label for="insurance_premium" class=" form-control-label"><small class="form-text text-muted">Insurance Premium</small></label>
                                                <input type="text" id="insurance_premium" name="insurance_premium" class="form-control" autocomplete="off">
                                            </div>
                                        	<div class="col-sm-4">
                                                <label for="interest_charges" class=" form-control-label"><small class="form-text text-muted">Interest Charge</small></label>
                                                <input type="text" id="interest_charges" name="interest_charges" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="or_no" class=" form-control-label"><small class="form-text text-muted">Official Receipt No.</small></label>
                                                <input type="text" id="or_no" name="or_no" class="form-control" autocomplete="off">
                                            </div>                                                                                
                                        </div>    
                                        <div class="row form-group col-sm-12">
                                        	<div class="col-sm-4">
                                                <label for="bill_invoice_no" class=" form-control-label"><small class="form-text text-muted">Bill No. / Invoice No.</small></label>
                                                <input type="text" id="bill_invoice_no" name="bill_invoice_no" class="form-control" autocomplete="off">
                                            </div>
                                        	<div class="col-sm-4">
                                                <label for="payment_date" class=" form-control-label"><small class="form-text text-muted">Payment Date</small></label>
                                                <div class="input-group">
                                                    <input type="text" id="payment_date" name="payment_date" class="form-control" autocomplete="off">
                                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="receive_date" class=" form-control-label"><small class="form-text text-muted">Received Date</small></label>
                                                <div class="input-group">
                                                    <input type="text" id="receive_date" name="receive_date" class="form-control" autocomplete="off">
                                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                                </div>
                                            </div>                                            
                                        </div>                                    	
                                    </div>  
                                    <!-- div for water bill(housing) -->
                                    <div id="7" class="billing">
                                    	
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
        <!-- Modal add telefon list  -->
        <div id="add_phone" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Telephone List</h4>
                </div>
                <div class="modal-body">
                    <form id="telefon_bill">        
                        <div class="row form-group col-sm-12">
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Telephone No.</small></label>
                                <input type="text" name="telefon" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Type</small></label>
                                <input type="text" name="type" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Usage (RM)</small></label>
                                <input type="text" name="usage" class="form-control">
                            </div>  
                            <div class="col-sm-1">
                            	<button type="submit" class="btn btn-success button_add">Add</button>                            	
                            </div> 
                            <div class="col-sm-1">
                            	<button type="button" data-dismiss="modal" class="btn btn-secondary button_add">Cancel</button>
                            </div>                         
                        </div>                                                                             
                  	</form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
        //declare empty array to temporary save the data in table
        var TELEPHONE_LIST = [];
        
    	$('.billing').hide();
    	$('#bill_type').change(function(){
    		$('.billing').hide();
			$('#'+$(this).val()).show();
			if($(this).val() == 4 || $(this).val() == 5){
				$('.date, #cheque_no').hide();
			}
			else if($(this).val() == 6){
				$('.date, #cheque_no').hide();
			}
        });

        $('#telefon_bill').on("submit", function(e){ 
            e.preventDefault();
            var telefon = $("input[name='telefon']").val();
            var type = $("input[name='type']").val();
         	var usage = $("input[name='usage']").val();
         	
            $(".data-table tbody").append("<tr data-telefon='"+telefon+"' data-type='"+type+"' data-usage='"+usage+"'><td>"+telefon+"</td><td>"+type+"</td><td>"+usage+"</td><td><button class='btn btn-info btn-xs btn-edit'>Edit</button><button class='btn btn-danger btn-xs btn-delete'>Delete</button></td></tr>");

            //push data into array
            TELEPHONE_LIST.push({
				telefon: telefon,
				type: type,
				usage: usage
            });
            console.log(TELEPHONE_LIST);
            $("input[name='telefon']").val('');
            $("input[name='type']").val('');
            $("input[name='usage']").val('');
        });
    	
        $('#add_new_bill').on("submit", function(event){  
            event.preventDefault();     
            console.log(TELEPHONE_LIST);         
            $.ajax({  
                url:"add_bill.ajax.php",  
                method:"POST",  
                data:{action:'add_new_bill', data : $('#add_new_bill').serialize(), telefon_list:TELEPHONE_LIST},  
                success:function(data){ 
                    location.reload();                                                        	 
                }  
           });    
        });

        $('#from_date, #to_date, #paid_date, #due_date, #date_entered, #payment_date, #receive_date, #date_entered_fx').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });

        //onchange billtype
        $("#bill_type").change(function(){
            var bill_type = $(this).val();

            $.ajax({
                url: 'get_account.ajax.php',
                type: 'post',
                data: {bill_type:bill_type},
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    var len = response.length;
                    $("#sel_account").empty();
                    for( var i = 0; i<len; i++){
                        var acc_id = response[i]['acc_id'];
                        var description = response[i]['description'];
                        
                        $("#sel_account").append("<option value='"+acc_id+"'>"+description+"</option>");

                    }
                }
            });
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
