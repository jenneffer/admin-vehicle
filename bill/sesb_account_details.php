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
    
    $query = "SELECT * FROM bill_sesb_account WHERE bill_sesb_account.id = '$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc($result);
    $acc_id = $row['id'];
    $company = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
    $location = $row['location'];
    $deposit = $row['deposit'] + $row['additional_deposit'];
    $account_no = $row['account_no'];
    $tarif = $row['tarif'];
    
    //get the telefon_list
    
    $details_query = "SELECT MONTH(date_end) AS month_to_name, meter_reading_from, meter_reading_to, 
            total_usage, current_usage, kwtbb, penalty,power_factor,additional_deposit, other_charges,adjustment,date_start, date_end,
            amount,due_date, cheque_no,paid_date FROM bill_sesb WHERE acc_id = '$acc_id' AND YEAR(date_end) = '$year_select'ORDER BY month_to_name ASC";
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
                                <strong class="card-title">Account Details</strong>
                            </div>     
                            <div class="card-body">                                       
                                <div style="font-weight: bold;">
                                    <div class="col-sm-12">
                                        <label class=" form-control-label">Company : <?=$company?></label>                                        
                                    </div>
                                    <div class="col-sm-12">
                                    	<label class=" form-control-label">Location : <?=$location?></label>                                    
                                    </div>
                                    <div class="col-sm-12">
                                    	<label class=" form-control-label">Account No. : <?=$account_no?></label>                                    
                                    </div>                                   
                                    <div class="col-sm-12">
                                    	<label class=" form-control-label">Deposit : RM <?=$deposit?></label>                                    	
                                    </div>
                                    <div class="col-sm-12">
                                    	<label class=" form-control-label">Tarif : <?=$tarif?></label>                                    	
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
                                    	<div class="col-sm-4">
                                    		<button type="button" class="btn btn-sm btn-primary button_add" data-toggle="modal" data-target="#addItem">Add New Record</button>
                                    	</div>
                                	</div>
                            	</form>                            	
                            	<div>     
                                    <table id="sesb-table"  class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                        	<th>Description</th>
											<th colspan="3" class="text-center" >Meter Reading</th>
                                            <th rowspan="2">Current Usage (RM)</th>
											<th rowspan="2">KWTBB (RM)</th>
											<th rowspan="2">Penalty (RM)</th>											
<!-- 											<th rowspan="2">Power Factor Below 0.85</th> -->
											<th rowspan="2">Additional Deposit (RM)</th>
											<th rowspan="2">Other Charges (RM)</th>											
                                            <th rowspan="2">Adjustment</th>
                                            <th colspan="2" class="text-center">Period Date</th>
                                            <th rowspan="2">Amount (RM)</th>
                                            <th rowspan="2">Due Date</th>
                                            <th rowspan="2">Cheque No.</th>
                                            <th rowspan="2">Payment Date</th>
                                        </tr>
                                        <tr>
                                        	<th>Month</th>
                                        	<th>From</th>
                                        	<th>To</th>
                                        	<th>Total Usage (KWH)</th>
                                        	<th>From</th>
                                        	<th>To</th>                                        	
                                        </tr>										
                                    </thead>  
                                    <tbody>
                                    <?php 
                                    foreach ($arr_data as $data){
                                    ?>
                                    <tr>
                                        <td><?php 
                                        if($data['month_to_name'] == '1') {
                                        	echo "<span style='display:none'>1</span> January";
                                        } else if($data['month_to_name'] == '2') {
                                        	echo "<span style='display:none'>2</span> February";
                                        } else if($data['month_to_name'] == '3') {
                                        	echo "<span style='display:none'>3</span> March";
                                        } else if($data['month_to_name'] == '4') {
                                        	echo "<span style='display:none'>4</span> April";
                                        } else if($data['month_to_name'] == '5') {
                                        	echo "<span style='display:none'>5</span> May";
                                        } else if($data['month_to_name'] == '6') {
                                        	echo "<span style='display:none'>6</span> June";
                                        } else if($data['month_to_name'] == '7') {
                                        	echo "<span style='display:none'>7</span> Jully";
                                        } else if($data['month_to_name'] == '8') {
                                        	echo "<span style='display:none'>8</span> August";
                                        } else if($data['month_to_name'] == '9') {
                                        	echo "<span style='display:none'>9</span> September";
                                        } else if($data['month_to_name'] == '10') {
                                        	echo "<span style='display:none'>10</span> October";
                                        } else if($data['month_to_name'] == '11') {
                                        	echo "<span style='display:none'>11</span> November";
                                        } else {
                                        	echo "<span style='display:none'>12</span> December";
                                        }
                                        /*echo $data['month_name']*/?></td>
                                        <td><?=$data['meter_reading_from']?></td>
										<td><?=$data['meter_reading_to']?></td>
                                        <td><?=$data['total_usage']?></td>
                                        <td><?=$data['current_usage']?></td>
                                        <td><?=$data['kwtbb']?></td>
                                        <td><?=$data['penalty']?></td>
                                        <td><?=$data['additional_deposit']?></td>
                                        <td><?=number_format($data['other_charges'],2)?></td>
                                        <td><?=number_format($data['adjustment'],2)?></td>
                                        <td><?=$data['date_start']?></td>
                                        <td><?=$data['date_end']?></td>
                                        <td><?=$data['amount']?></td>     
                                        <td><?=$data['due_date']?></td> 
                                        <td><?=$data['cheque_no']?></td>                                            
                                        <td><?=$data['paid_date']?></td>                                        
                                    </tr>
                                        
                                    <?php }
                                    ?>
                                    </tbody>                                     	
                                    <tfoot>
                                    	<tr>
                                    		<th>TOTAL</th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
                                    		<th></th>
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
        <!-- Modal add new telekom bill -->
        <div class="modal fade" id="addItem">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">  
                    <input type="hidden" id="acc_id" name="acc_id" value="">                        
                    <div class="col-sm-12">
                    	<label class=" form-control-label"><small class="form-text text-muted">Period</small></label>       
                    </div>
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="from_date" class=" form-control-label"><small class="form-text text-muted">From date <span class="color-red">*</span></small></label>                                            
                            <div class="input-group">
                                <input id="from_date" name="from_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>       
                        <div class="col-sm-6">
                            <label for="to_date" class=" form-control-label"><small class="form-text text-muted">To date <span class="color-red">*</span></small></label>                                            
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
                        <div class="col-sm-4">
                            <label for="reading_from" class=" form-control-label"><small class="form-text text-muted">From <span class="color-red">*</span></small></label>
                            <input type="text" id="reading_from" name="reading_from" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="reading_to" class=" form-control-label"><small class="form-text text-muted">To <span class="color-red">*</span></small></label>
                            <input type="text" id="reading_to" name="reading_to" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="current_usage" class=" form-control-label"><small class="form-text text-muted">Current Usage (RM) <span class="color-red">*</span></small></label>
                            <input type="text" id="current_usage" name="current_usage" class="form-control">
                        </div>                                
                    </div>
                    <div class="row form-group col-sm-12">      
                        <div class="col-sm-4">
                            <label for="kwtbb" class=" form-control-label"><small class="form-text text-muted">KWTBB (RM)</small></label>
                            <input type="text" id="kwtbb" name="kwtbb" class="form-control" value="0">
                        </div> 
                         <div class="col-sm-4">
                            <label for="penalty" class=" form-control-label"><small class="form-text text-muted">Penalty (RM)</small></label>
                            <input type="text" id="penalty" name="penalty" class="form-control" value="0">
                        </div>        
                        <div class="col-sm-4">
                            <label for="power_factor" class=" form-control-label"><small class="form-text text-muted">Power Factor (<0.85)</small></label>
                            <input type="text" id="power_factor" name="power_factor" class="form-control" value="0">
                        </div>
                    </div>                    
                    <div class="row form-group col-sm-12">                                     	                       
                        <div class="col-sm-4">
                            <label for="additional_depo" class=" form-control-label"><small class="form-text text-muted">Additional Deposit (RM)</small></label>
                            <input type="text" id="additional_depo" name="additional_depo" class="form-control" value="0">
                        </div>        
                        <div class="col-sm-4">
                            <label for="other_charges" class=" form-control-label"><small class="form-text text-muted">Other Charges (RM)</small></label>
                            <input type="text" id="other_charges" name="other_charges" class="form-control" value="0">
                        </div>
                        <div class="col-sm-4" id="cheque_no">
                        <label for="cheque_no" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                        <input type="text" id="cheque_no" name="cheque_no" class="form-control">
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
			
        $('#sesb-table').DataTable({
            "bInfo" : false,
            "bLengthChange": false,
            "searching": false,
            "ordering": false,
            "paging" : false,
            "footerCallback": function( tfoot, data, start, end, display ) {
            	var api = this.api(), data;
            	var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;
            
            	api.columns([4,5,6,7,8,9,12], { page: 'current'}).every(function() {
            		var sum = this
            	    .data()
            	    .reduce(function(a, b) {
            	    var x = parseFloat(a) || 0;
            	    var y = parseFloat(b) || 0;
            	    	return x + y;
            	    }, 0);			
            	       
            	    $(this.footer()).html(numFormat(sum));
            	}); 
            },
            
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
//             else if($('#paid_date').val() == ""){  
//                 alert("Paid date is required");  
//             }
//             else if($('#due_date').val() == ""){  
//                 alert("Due date is required");  
//             }
            else if($('#reading_from').val() == ""){  
                alert("Meter reading from is required");  
            }
            else if($('#reading_to').val() == ""){  
                alert("Meter reading to is required");  
            }
            else if($('#current_usage').val() == ""){  
                alert("Current usage is required");  
            }
//             else if($('#kwtbb').val() == ""){  
//                 alert("KWTBB is required");  
//             }
//             else if($('#cheque_no').val() == ""){  
//                  alert("Cheque number is required");  
//             }                                          
            else{  
                 $.ajax({  
                      url:"sesb_bill.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_bill', data: $('#add_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
//                            $('#bootstrap-data-table').html(data);
                           location.reload();  
                      }  
                 });  
            }  
          });

        $('#from_date, #to_date, #due_date,#paid_date').datepicker({
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