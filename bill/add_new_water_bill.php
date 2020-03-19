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
                                <strong class="card-title">Add New Water Bill</strong>
                            </div>
                            <form id="add_water_bill" role="form" action="" method="post">
                                <div class="card-body card-block">
                                    <div class="form-group row col-sm-12"> 
                                        <div class="col-sm-3">
                                            <label for="invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice No.</small></label>                                            
                                            <div class="input-group">
                                                <input id="invoice_no" name="invoice_no" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>  
                                        <div class="col-sm-3">
                                            <label for="invoice_date" class=" form-control-label"><small class="form-text text-muted">Invoice date</small></label>                                            
                                            <div class="input-group">
                                                <input id="invoice_date" name="invoice_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>  
                                        <div class="col-sm-3">
                                            <label for="receive_date" class=" form-control-label"><small class="form-text text-muted">Received date</small></label>                                            
                                            <div class="input-group">
                                                <input id="receive_date" name="receive_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>  
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>                                            
                                            <select id="payment_mode" name="payment_mode" class="form-control">
                                        		<option value="">- Select -</option>
                                        		<option value="cash">Cash</option>
                                        		<option value="ibg">IBG</option>
                                        	</select>  
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
									<div class="form-group row col-sm-12 date">
										<div class="col-sm-3">
                                            <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>                                            
                                            <div class="input-group">
                                                <input id="description" name="description" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>  
                                        <div class="col-sm-3">
                                            <label for="previous_mr" class=" form-control-label"><small class="form-text text-muted">Previous Meter Reading</small></label>                                            
                                            <div class="input-group">
                                                <input id="previous_mr" name="previous_mr" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div> 
                                        <div class="col-sm-3">
                                            <label for="current_mr" class=" form-control-label"><small class="form-text text-muted">Current Meter Reading</small></label>                                            
                                            <div class="input-group">
                                                <input id="current_mr" name="current_mr" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="charged_amt" class=" form-control-label"><small class="form-text text-muted">Charged Amount (RM)</small></label>                                            
                                            <div class="input-group">
                                                <input id="charged_amt" name="charged_amt" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div> 
									</div>       
									<div class="form-group row col-sm-12 date">
										<div class="col-sm-3">
                                            <label for="surcharge" class=" form-control-label"><small class="form-text text-muted">Surcharge</small></label>                                            
                                            <div class="input-group">
                                                <input id="surcharge" name="surcharge" class="form-control" autocomplete="off">                                                
                                            </div>  
                                        </div>  
<!--                                         <div class="col-sm-3"> -->
<!--                                             <label for="adjustment" class=" form-control-label"><small class="form-text text-muted">Adjustment</small></label>                                             -->
<!--                                             <div class="input-group"> -->
<!--                                                 <input id="adjustment" name="adjustment" class="form-control" autocomplete="off">                                                 -->
<!--                                             </div>   -->
<!--                                         </div>  -->
                                        
                                        <div class="col-sm-3">
                                            <label for="or_no" class=" form-control-label"><small class="form-text text-muted">OR No.</small></label>                                            
                                            <div class="input-group">
                                                <input id="or_no" name="or_no" class="form-control" autocomplete="off">                                                
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
        //declare empty array to temporary save the data in table
        var TELEPHONE_LIST = [];
        
    	$('.billing').hide();
    	$('#bill_type').change(function(){
    		$('.billing').hide();
			$('#'+$(this).val()).show();

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
    	
        $('#add_water_bill').on("submit", function(event){  
            event.preventDefault();     
            console.log(TELEPHONE_LIST);         
            $.ajax({  
                url:"add_bill.ajax.php",  
                method:"POST",  
                data:{action:'add_water_bill', data : $('#add_water_bill').serialize(), telefon_list:TELEPHONE_LIST},  
                success:function(data){ 
//                     location.reload();                                                        	 
                }  
           });    
        });

        $('#from_date, #to_date, #paid_date, #due_date, #invoice_date, #receive_date').datepicker({
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