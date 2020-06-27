<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$username = itemName("SELECT cr_name FROM credential WHERE cr_id='".$_SESSION['cr_id']."'");

?>

<!doctype html><html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Vehicle</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- link to css -->
	<?php include('../allCSS1.php')?>
   <style>
    .select2-selection__rendered {
      margin: 5px;
    }
    .select2-selection__arrow {
      margin: 5px;
    }
    .select2-container{ 
        width: 100% !important; 
    }
    .button_add{
        position: absolute;
        left:    0;
        bottom:   0;
    }
    .hideBorder {
        border: 0px;
        background-color: transparent;        
    }
    .hideBorder:hover {
        background: transparent;
        border: 1px solid #dee2e6;
    }
    form{
        margin: 20px 0;
    }
    form input, button{
        padding: 5px;
    }
    table{
        width: 100%;
        margin-bottom: 20px;
		border-collapse: collapse;
    }
    table, th, td{
        border: 1px solid #cdcdcd;
    }
    table th, table td{
        padding: 10px;
        text-align: left;
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
                <div class="card"  id="printableArea">
                    <div class="card-header">
                        <strong class="card-title">ABX Statement Form</strong>
                    </div>            
                    <form id="add_form">
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice Number</small></label>
                            <input type="text" id="invoice_no" name="invoice_no" placeholder="Enter invoice number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row col-sm-12">
                        <div class="col-sm-2">
                        	<label for="date" class=" form-control-label"><small class="form-text text-muted">Date</small></label>     
                        	<input type="text" id="date" class="form-control" name="date" autocomplete="off"/>  
                        </div>
                        <div class="col-sm-2">
                        	<label for="airbill_no" class=" form-control-label"><small class="form-text text-muted">Airbill No.</small></label>     
                        	<input type="text" class="form-control" id="airbill_no" name="airbill_no">
                        </div>
                        <div class="col-sm-2">
                        	<label for="particular" class=" form-control-label"><small class="form-text text-muted">Particular</small></label>     
                        	<input type="text" class="form-control" id="particular" name="particular">
                        </div>
                        <div class="col-sm-2">
                        	<label for="company_id" class=" form-control-label"><small class="form-text text-muted">Company</small></label>     
                        	<?php
                                $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(code) FROM company");
                                db_select ($company, 'company_id', '','','-select-','form-control','');
                            ?>
                        </div>
                        <div class="col-sm-2">
                        	<label for="requested_by" class=" form-control-label"><small class="form-text text-muted">Requested by</small></label>     
                        	<input type="text" class="form-control" id="requested_by" name="requested_by">
                        </div>
                        <div class="col-sm-2">
                        	<label for="charge" class=" form-control-label"><small class="form-text text-muted">Charge</small></label>     
                        	<input type="text" class="form-control" id="charge" name="charge" onkeypress="return isNumberKey(event)">
                        </div>                
                    </div>    
                    <div class="form-group row col-sm-12 text-right">
                    	<div class="col-sm-12">
                        	<label for="charge" class="form-control-label"><small class="form-text text-muted">&nbsp;</small></label>     
                        	<input type="button" class=" btn add-row btn-info" value="Add Row">    
                        </div>
                    </div>                                             				
                    <div class="col-sm-12">
                        <table id="mytable">
                            <thead>
                            	<tr>
                                    <th>Date</th>
                                    <th>Airbill No.</th>
                                    <th>Particular</th>
                                    <th>Company</th>
                                    <th>Requested by</th>
                                    <th>Charge</th>
                                    <th>Tax</th>
                                    <th>Amount(RM)</th>
                                </tr>
                            </thead>
                            <tbody>                            
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12" style="text-align: center;">
            			<button type="button" id="btn_save" name="btn_save" class="btn btn-primary">Save</button>
            			<button type="button" name="btn_reset" class="btn btn-secondary button_reset">Reset</button>
            		</div>
            		</form>
    			</div>
    		</div>
        	</div><!-- .animated -->
    	</div><!-- .content -->
    </div>
</div>
<div class="clearfix"></div>
<!-- Footer -->
<?PHP include('../footer.php')?>
    <!-- /.site-footer -->
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
	var TABLE_ABX_DATA = [];
    $(".add-row").click(function(){
        var date = $("#date").val();
        var airbill_no = $("#airbill_no").val();
        var particular = $("#particular").val();
        var company_id = $("#company_id").val();
        var requested_by = $("#requested_by").val();
        var charge = $("#charge").val();
        var tax = charge * 6/100;
        var amount = Number(charge) + Number(tax);

        if(date == ""){
        	alert("Date is required");  
        }
        else if(airbill_no == ""){
        	alert("Airbill number is required");  
        }
        else if(particular == ""){
        	alert("Particular is required");  
        }
        else if(company_id == ""){
        	alert("Company is required");  
        }
        else if(requested_by == ""){
        	alert("Requested by is required");  
        }
        else if(charge == ""){
        	alert("Charge is required");  
        }
        else{
        	var currentAbxData = new AbxData(date, airbill_no, particular, company_id, requested_by, charge, tax, amount);
            TABLE_ABX_DATA.push(currentAbxData);
            
            var markup = "<tr><td>"+date+"</td><td>"+airbill_no+"</td><td>"+particular+"</td><td>"+company_id+"</td><td>"+requested_by+"</td><td>"+charge+"</td><td>"+tax+"</td><td>"+amount+"</td></tr>";
            $("table tbody").append(markup);

		}
        
        //clear input fields after populated in the table
        $("#date").val('');
        $("#airbill_no").val('');
        $("#particular").val('');
        $("#company_id").val('');
        $("#requested_by").val('');
        $("#charge").val('');
    });

    $('#btn_save').on("click", function(event){ 
        var invoice_no = $('#invoice_no').val();
        if(invoice_no == ''){
			alert("Invoice number is required!");
        }
        else if(TABLE_ABX_DATA.length == 0){
			alert('Table data is empty!');
        }
        else{
        	$.ajax({  
                url:"abx.ajax.php",  
                method:"POST",                        
                data:{action:'add_new_statement', data: TABLE_ABX_DATA, invoice_no: invoice_no},  
                success:function(data){   
                    if(data){
                    	location.reload();  
                        window.location.href ="abx_statement_list.php";
					}                                                           
                }  
            });
		}                 
    });
    
    // Find and remove selected table rows
    $(".delete-row").click(function(){
        $("table tbody").find('input[name="record"]').each(function(){
        	if($(this).is(":checked")){
                $(this).parents("tr").remove();
            }
        });
    }); 
    $('#date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        orientation: "top left",
        todayHighlight: true
  	});
  	 
	function AbxData(date, airbill_no, particular, company_id, requested_by, charge, tax, amount){
		this.date = date;
		this.airbill_no = airbill_no;
		this.particular = particular;
		this.company_id = company_id;
		this.requested_by = requested_by;
		this.charge = charge;
		this.tax = tax;
		this.amount = amount;
	}  
	function isNumberKey(evt){
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	if (charCode != 46 && charCode > 31 
    	&& (charCode < 48 || charCode > 57))
    	return false;
    	return true;
    } 
});
</script>
</body>
<style>
 #printableArea{ 
     font-size:14px; 
     margin:0px; 
     padding:.5rem; 
} 
</style>
</html>
