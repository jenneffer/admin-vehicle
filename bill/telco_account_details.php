<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
    global $conn_admin_db;
    
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date('Y');
    ob_start();
    selectYear('year_select',$year_select,'submit()','','form-control form-control-sm','','');
    $html_year_select = ob_get_clean();
    
    $query = "SELECT * FROM bill_telco_account WHERE bill_telco_account.id = '$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_array($result);
    $telco_acc_id = $row['id'];
    $company = itemName("SELECT name FROM company WHERE id='".$row['company_id']."'");
    $user = $row['user'];
    $position = $row['position'];
    $account_no = $row['account_no'];
    
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
                    <div class="card" id="printableArea">
                        <div class="card-header">                            
                            <strong class="card-title">Account Details</strong>
                        </div>     
                        <div class="card-body">
                            <div style="font-weight: bold;">                                       
                                <div class="col-sm-12">
                                    <label for="company" class=" form-control-label">Company : <?=$company?></label>                                        
                                </div>
                                <div class="col-sm-12">
                                	<label for="account_no" class=" form-control-label">Account No. : <?=$account_no?></label>                                    
                                </div>   
                                <div class="col-sm-12">
                                	<label for="user" class=" form-control-label">User : <?=$user?></label>
                                    
                                </div>
                                <div class="col-sm-12">
                                	<label for="position" class=" form-control-label">Position : <?=$position?></label>                                    	
                                </div>
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
                                	<div class="row col-sm-4">
                                    	<div  class="col-sm-4">
                                    		<button type="button" class="btn btn-sm btn-primary button_add" data-toggle="modal" data-target="#addItem">Add New Record</button>
                                		</div>
                                		<div  class="col-sm-4">
                                			<button type="button" class="btn btn-sm btn btn-info" onClick="window.close();">Back</button>
                                		</div> 
                                	</div>
                            	</div>
                        	</form>                            	
                        	<div>     
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" width="40%">Month</th>
                                            <th scope="col" class="text-center">Amount(RM)</th>
                                    	</tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $total_amount = 0;
                                    if(!empty($arr_data)){
                                        foreach ($arr_data as $data){
                                            $total_amount += $data['amount_rm'];
                                        ?>                               
                                        <tr>
                                            <td class="text-center"><?=$data['month_name']?></td>
                                            <td class="text-right"><?=number_format($data['amount_rm'],2)?></td>

                                        </tr>                                             
                                        <?php } ?>
                                        <tr>
                                        	<th class="text-center">Total (RM)</th>
                                        	<th class="text-right"><?=number_format($total_amount,2)?></th>
                                        </tr>
                                    <?php }else {?>
                                    <tr>
                                    	<td colspan="2" class="text-center"> No records found.</td>
                                    </tr>                                        
                                    <?php }?>  
                                    </tbody>                                                                   
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
        <!-- Modal add new telco bill -->
        <div class="modal fade" id="addItem">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">  
                    <input type="hidden" id="telco_acc_id" name="telco_acc_id" value="">               
                    <div class="row form-group col-sm-12"> 
                    	<div class="col-sm-6">
                            <label for="date_entered" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                            <div class="input-group">
                                <input type="text" id="date_entered" name="date_entered" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    	<div class="col-sm-6">
                            <label for="bill_amount" class=" form-control-label"><small class="form-text text-muted">Bill Amount (RM)</small></label>
                            <input type="text" id="bill_amount" name="bill_amount" class="form-control">
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
        	  ],
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