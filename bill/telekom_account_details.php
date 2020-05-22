<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
    global $conn_admin_db;
    
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date('Y');
    ob_start();
    selectYear('year_select',$year_select,'submit()','','form-control','','');
    $html_year_select = ob_get_clean();
    
    $query = "SELECT * FROM bill_telekom_account WHERE bill_telekom_account.id = '$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc($result);

    $telco_acc_id = $row['id'];
    $company = $row['company'];
    $owner = $row['owner'];
    $ref_no = $row['ref_no'];
    $account_no = $row['account_no'];
    
    //get the telefon_list
    
    $details_query = "SELECT MONTHNAME(DATE) AS month_name, amount_rm FROM bill_telco_billing WHERE telco_acc_id = '$telco_acc_id' AND YEAR(date) = '$year_select'";
    $result2 = mysqli_query($conn_admin_db, $details_query) or die(mysqli_error($conn_admin_db));
    $arr_data = [];
    while ($rows = mysqli_fetch_assoc($result2)){
        $arr_data[] = $rows;
    }
    
    
    
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
                                <strong class="card-title">Account Details</strong>
                            </div>     
                            <div class="card-body">                                       
                                <div class="col-sm-12">
                                    <label for="company" class=" form-control-label"><small class="form-text text-muted">Company : <?=$company?></small></label>                                        
                                </div>
                                <div class="col-sm-12">
                                	<label for="account_no" class=" form-control-label"><small class="form-text text-muted">Account No. : <?=$account_no?></small></label>                                    
                                </div>   
                                <div class="col-sm-12">
                                	<label for="owner" class=" form-control-label"><small class="form-text text-muted">Owner : <?=$owner?></small></label>
                                    
                                </div>
                                <div class="col-sm-12">
                                	<label for="ref_no" class=" form-control-label"><small class="form-text text-muted">Ref No. : <?=$ref_no?></small></label>                                    	
                                </div>                                                                    
                            	<hr>
                            	<form action="" method="post">
                                	<div class="form-group row col-sm-12">           
                                    	<div class="col-sm-4">
                                    		<b>Monthly Expenses</b>
                                    	</div>                                    	
                                    	<div class="col-sm-4">
                                    		<?=$html_year_select?>
                                    	</div>
                                    	<div class="col-sm-4">
                                    		<button type="button" class="btn btn btn-primary button_add" data-toggle="modal" data-target="#addItem">Add New Record</button>
                                    	</div>
                                	</div>
                            	</form>                            	
                            	<div>     
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th scope="col" class="text-center">Month</th>
                                            <th scope="col" class="text-center">Period</th>
                                            <th scope="col" class="text-center">Bill No.</th>
                                            <th scope="col" class="text-center">Monthly (RM)</th>
                                            <th scope="col" class="text-center">Rebate (RM)</th>
                                            <th scope="col" class="text-center">Credit Adj. (RM)</th>
                                            <th scope="col" class="text-center">GST/SST (6%)</th>
                                            <th scope="col" class="text-center">Adj.</th>
                                            <th scope="col" class="text-center">Total (RM)</th>
                                            <th scope="col" class="text-center">Due date</th>
                                            <th scope="col" class="text-center">Cheque No.</th>
                                            <th scope="col" class="text-center">Payment date</th>
                                        </tr>                                                                                                            
                                    </table>
                                </div>                                                                                                            
                          	 
                           	</div> 
                           	<br>                      
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        <!-- Modal add new telekom bill -->
        <div class="modal fade" id="addItem">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">  
                    <input type="hidden" id="telco_acc_id" name="telco_acc_id" value="">    
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                        	<label class=" form-control-label"><small class="form-text text-muted">Period</small></label>       
                        </div>
                    	<div class="col-sm-6">
                            <label for="from_date" class=" form-control-label"><small class="form-text text-muted">From date</small></label>                                            
                            <div class="input-group">
                                <input id="from_date" name="from_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>       
                        <div class="col-sm-6">
                            <label for="to_date" class=" form-control-label"><small class="form-text text-muted">To date</small></label>                                            
                            <div class="input-group">
                                <input id="to_date" name="to_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12"> 
                        <div class="col-sm-6">
                            <label for="paid_date" class=" form-control-label"><small class="form-text text-muted">Paid date</small></label>                                            
                            <div class="input-group">
                                <input id="paid_date" name="paid_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>       
                        <div class="col-sm-6">
                            <label for="due_date" class=" form-control-label"><small class="form-text text-muted">Due date</small></label>                                            
                            <div class="input-group">
                                <input id="due_date" name="due_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>                                     
                    </div>           
                    <div class="row form-group col-sm-12">                                     	
                        <div class="col-sm-6">
                            <label for="bill_no" class=" form-control-label"><small class="form-text text-muted">Bill No.</small></label>
                            <input type="text" id="bill_no" name="bill_no" class="form-control">
                        </div>  
                        <div class="col-sm-6">
                            <label for="monthly_fee" class=" form-control-label"><small class="form-text text-muted">Monthly (RM)</small></label>
                            <input type="text" id="monthly_fee" name="monthly_fee" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="rebate" class=" form-control-label"><small class="form-text text-muted">Rebate (RM)</small></label>
                            <input type="text" id="rebate" name="rebate" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="cr_adjustment" class=" form-control-label"><small class="form-text text-muted">Credit Adjustment (RM)</small></label>
                            <input type="text" id="cr_adjustment" name="cr_adjustment" class="form-control">
                        </div>      
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary save_data ">Save</button>
                    </div>
                    </form>
                </div>
                </div>
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
		
		var telco_acc_id = '<?=$id?>';
			
        $('#item-data-table').DataTable({
        	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "80%", "targets": 1 },
//         	    { "width": "10%", "targets": 2 }
        	  ]
  	  	});
        $('#add_form').on("submit", function(event){  
            event.preventDefault();  
            
            $('#telco_acc_id').val(telco_acc_id);

            if($('#date_entered').val() == ""){  
                 alert("Date is required");  
            } 
            else if($('#bill_amount').val() == ""){  
                 alert("Bill amount is required");  
            }                                          
            else{  
                 $.ajax({  
                      url:"telco_bill.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_bill', data: $('#add_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);
                           location.reload();  
                      }  
                 });  
            }  
          });

        $('#date_entered').datepicker({
              format: "dd-mm-yyyy",
              autoclose: true,
              orientation: "top left",
              todayHighlight: true
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
    });
  </script>
</body>
</html>