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
    
    $query = "SELECT * FROM bill_jabatan_air_account WHERE bill_jabatan_air_account.id = '$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc($result);

    $jabatan_air_acc_id = $row['id'];
    $company = $row['company'];
    $owner = $row['owner'];
    $location = $row['location'];
    $account_no = $row['account_no'];
    $total_deposit = $row['deposit'] + $row['additional_deposit'];

    $details_query = "SELECT MONTHNAME(date_end) AS month_name, meter_reading_from, meter_reading_to, 
            (meter_reading_to - meter_reading_from) AS total_usage, usage_70, rate_70,usage_71, rate_71,credit_adjustment, 
            adjustment,date_start, date_end,amount,due_date, cheque_no,paid_date
            FROM bill_jabatan_air WHERE acc_id = '$jabatan_air_acc_id' AND YEAR(date_end) = '$year_select'";
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
                                <div class="col-sm-12">
                                    <label for="company" class=" form-control-label">Company : <?=$company?></label>                                        
                                </div>
                                <div class="col-sm-12">
                                	<label for="owner" class=" form-control-label">Owner : <?=$owner?></label>                                    
                                </div>
                                <div class="col-sm-12">
                                	<label for="location" class=" form-control-label">Location : <?=$location?></label>                                    	
                                </div>
                                <div class="col-sm-12">
                                	<label for="account_no" class=" form-control-label">Account No. : <?=$account_no?></label>                                    
                                </div>     
                                <div class="col-sm-12">
                                	<label for="deposit" class=" form-control-label">Deposit : RM<?=$total_deposit?></label>                                    
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
                                    		<button type="button" class="btn btn-sm btn btn-primary button_add" data-toggle="modal" data-target="#addItem">Add New Record</button>
                                    	</div>
                                	</div>
                            	</form>                            	
                            	<div>     
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                            	<th>Description</th>
    											<th colspan="3" class="text-center">Meter Reading</th>
                                                <th colspan="2" class="text-center">0-70</th>
    											<th colspan="2" class="text-center">>70</th>
    											<th rowspan="2">Credit</th>											
    											<th rowspan="2">Adjustment</th>
    											<th colspan="2" class="text-center">Period Date</th>											
                                                <th rowspan="2">Cheque No.</th>
                                                <th rowspan="2">Payment Date</th>
                                                <th rowspan="2">Amount (RM)</th>
                                            </tr>
                                            <tr>
                                            	<th>Month</th>
                                            	<th>From</th>
                                            	<th>To</th>
                                            	<th>Total Usage</th>
                                            	<th>M3</th>
                                            	<th>1.60</th> 
                                            	<th>M3</th>
                                            	<th>2.00</th>    
                                            	<th>From</th>
                                            	<th>To</th>                                     	
                                            </tr>										
                                    	</thead>   
                                    	<tbody>
                                    	<?php 
                                    	$sum_total_usage = 0;
                                    	$sum_rate1 = 0;
                                    	$sum_rate2 = 0;
                                    	$sum_credit_adjustment = 0;
                                    	$sum_adjustment = 0;
                                    	$sum_amount = 0;
                                    	foreach ($arr_data as $data){
                                    	$sum_total_usage += $data['total_usage'];
                                    	$sum_rate1 += $data['rate_70'];
                                    	$sum_rate2 += $data['rate_71'];
                                    	$sum_credit_adjustment += $data['credit_adjustment'];
                                    	$sum_adjustment += $data['adjustment'];
                                    	$sum_amount += $data['amount']
                                    	    ?>
                                    	<tr>
                                            <td class="text-left"><?=$data['month_name']?></td>
                                            <td class="text-right"><?=$data['meter_reading_from']?></td>
											<td class="text-center"><?=$data['meter_reading_to']?></td>
                                            <td class="text-right"><?=$data['total_usage']?></td>
                                            <td class="text-center"><?=$data['usage_70']?></td>
                                            <td class="text-right"><?=$data['rate_70']?></td>
                                            <td class="text-center"><?=$data['usage_71']?></td>
                                            <td class="text-right"><?=number_format($data['rate_71'],2)?></td>
                                            <td class="text-center"><?=number_format($data['credit_adjustment'],2)?></td>
                                            <td class="text-right"><?=number_format($data['adjustment'],2)?></td>
                                            <td class="text-center"><?=$data['date_start']?></td>
                                            <td class="text-right"><?=$data['date_end']?></td>
                                            <td class="text-center"><?=$data['cheque_no']?></td>                                            
                                            <td class="text-right"><?=$data['paid_date']?></td>
                                            <td class="text-center"><?=number_format($data['amount'],2)?></td>
                                        </tr>
                                    	<?php }?>
                                    	</tbody>  
                                    	<tfoot>
                                    	<tr>
                                            <th class="text-center">&nbsp;</th>
                                            <th class="text-center">&nbsp;</th>
											<th class="text-center">&nbsp;</th>
                                            <th class="text-right"><?=$sum_total_usage?></th>
                                            <th class="text-center">&nbsp;</th>
                                            <th class="text-right"><?=number_format($sum_rate1,2)?></th>
                                            <th class="text-center">&nbsp;</th>
                                            <th class="text-right"><?=number_format($sum_rate2,2)?></th>
                                            <th class="text-center"><?=number_format($sum_credit_adjustment,2)?></th>
                                            <th class="text-right"><?=number_format($sum_adjustment,2)?></th>
                                            <th class="text-center">&nbsp;</th>
                                            <th class="text-right">&nbsp;</th>
                                            <th class="text-center">&nbsp;</th>                                            
                                            <th class="text-right">&nbsp;</th>
                                            <th class="text-center"><?=number_format($sum_amount,2)?></th>
                                        </tr>
                                    	</tfoot>                                                                                                       
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
        <!-- Modal add new jabatan air bill -->
        <div class="modal fade" id="addItem">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New Record</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">  
                    <input type="hidden" id="acc_id" name="acc_id" value="">    
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
                    <div class="col-sm-12">
                    	<label class=" form-control-label"><small class="form-text text-muted">Meter Reading</small></label>       
                    </div>
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="read_from" class=" form-control-label"><small class="form-text text-muted">From</small></label>
                            <input type="text" id="read_from" name="read_from" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="read_to" class=" form-control-label"><small class="form-text text-muted">To</small></label>
                            <input type="text" id="read_to" name="read_to" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="usage_1" class=" form-control-label"><small class="form-text text-muted">M3 (0-70)</small></label>
                            <input type="text" id="usage_1" name="usage_1" class="form-control">
                        </div>        
                        <div class="col-sm-6">
                            <label for="usage_2" class=" form-control-label"><small class="form-text text-muted">M3 (>70)</small></label>
                            <input type="text" id="usage_2" name="usage_2" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">  
                    	<div class="col-sm-6">
                            <label for="cheque_no" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                            <input type="text" id="cheque_no" name="cheque_no"class="form-control">
                        </div>                                   	
                        <div class="col-sm-6">
                            <label for="credit" class=" form-control-label"><small class="form-text text-muted">Credit (RM)</small></label>
                            <input type="text" id="credit" name="credit" class="form-control">
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
		
		var acc_id = '<?=$id?>';
			
        $('#item-data-table').DataTable({
        	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "80%", "targets": 1 },
//         	    { "width": "10%", "targets": 2 }
        	  ]
  	  	});
        $('#add_form').on("submit", function(event){  
            event.preventDefault();  
            
            $('#acc_id').val(acc_id);

            if($('#from_date').val() == ""){  
                 alert("From date is required");  
            } 
            else if($('#to_date').val() == ""){  
                 alert("To date is required");  
            } 
            else if($('#paid_date').val() == ""){  
                alert("Paid date is required");  
           	}
            else if($('#due_date').val() == ""){  
                alert("Due date is required");  
           	}
            else if($('#read_from').val() == ""){  
                alert("Reading meter from is required");  
           	} 
            else if($('#read_to').val() == ""){  
                alert("Reading meter to is required");  
           	} 
            else if($('#usage_1').val() == ""){  
                alert("M3(0-70) is required");  
           	} 
            else if($('#usage_2').val() == ""){  
                alert("M3(>70) is required");  
            }
            else if($('#cheque_no').val() == ""){  
                alert("Cheque number is required");  
            }                                            
            else{  
                 $.ajax({  
                      url:"jabatan_air_bill.ajax.php",  
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

        $('#from_date, #to_date, #paid_date, #due_date').datepicker({
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