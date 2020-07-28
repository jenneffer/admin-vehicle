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
    
    $query = "SELECT * FROM bill_management_account WHERE bill_management_account.id = '$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc($result);

    $acc_id = $row['id'];
    $company = $row['company'];
    $management_name = $row['paid_to'];
    $owner = $row['owner'];
    $owner_ref = $row['owner_ref'];
    $location = $row['location'];
    $account_no = $row['account_no'];
    $unit_no = $row['unit_no'];
    
    
    //Management fee
    $details_query = "SELECT MONTHNAME(received_date) AS month_name,bill_management_fee.* FROM bill_management_fee WHERE acc_id = '$acc_id' AND YEAR(payment_date) = '$year_select' ORDER BY received_date";
    $result_mf = mysqli_query($conn_admin_db, $details_query) or die(mysqli_error($conn_admin_db));
    $arr_data_mf = [];
    while ($rows = mysqli_fetch_assoc($result_mf)){
        $arr_data_mf[] = $rows;
    }
    
    //Water bill
    $wb_query = "SELECT MONTHNAME(payment_date) AS month_name, bill_management_water.* FROM bill_management_water WHERE acc_id = '$acc_id' AND YEAR(payment_date) = '$year_select' ORDER BY received_date";
    $result_wb = mysqli_query($conn_admin_db, $wb_query) or die(mysqli_error($conn_admin_db));
    $arr_data_wb = [];
    while ($rows = mysqli_fetch_assoc($result_wb)){
        $arr_data_wb[] = $rows;
    }
    //Late interest charge 
    $li_query = "SELECT * FROM bill_management_late_interest_charge WHERE acc_id = '$acc_id' AND YEAR(bill_date) = '$year_select' ORDER BY bill_date";
    $result_li = mysqli_query($conn_admin_db, $li_query) or die(mysqli_error($conn_admin_db));
    $arr_data_li = [];
    while ($rows = mysqli_fetch_assoc($result_li)){
        $arr_data_li[] = $rows;
    }
    //Quit rent
    $qr_query = "SELECT * FROM bill_management_quit_rent WHERE acc_id = '$acc_id' AND YEAR(date_received) = '$year_select' ORDER BY date_received";
    $result_qr = mysqli_query($conn_admin_db, $qr_query) or die(mysqli_error($conn_admin_db));
    $arr_data_qr = [];
    while ($rows = mysqli_fetch_assoc($result_qr)){
        $arr_data_qr[] = $rows;
    }
    //Insurance Premium
    $ip_query = "SELECT * FROM bill_management_insurance WHERE acc_id = '$acc_id' AND YEAR(date_from) = '$year_select' ORDER BY date_from";
    $result_ip = mysqli_query($conn_admin_db, $ip_query) or die(mysqli_error($conn_admin_db));
    $arr_data_ip = [];
    while ($rows = mysqli_fetch_assoc($result_ip)){
        $arr_data_ip[] = $rows;
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
                                <div class="col-sm-12">
                                    <label class=" form-control-label"><small class="form-text text-muted">Management : <?=$management_name?></small></label>                                        
                                </div>                                
                                <div class="col-sm-12">
                                	<label class=" form-control-label"><small class="form-text text-muted">Location : <?=$location?></small></label>                                    	
                                </div>
                                <div class="col-sm-12">
                                	<label class=" form-control-label"><small class="form-text text-muted">Owner Reference: <?=$owner_ref?></small></label>                                    
                                </div>
                                <div class="col-sm-12">
                                	<label class=" form-control-label"><small class="form-text text-muted">Company : <?=$company?></small></label>                                    
                                </div>                                                                                                    
                            	<hr>
                            	<form action="" method="post">
                                	<div class="form-group row col-sm-12">           
                                    	<div class="col-sm-4">
                                    		<b>Expenses</b>
                                    	</div>                                    	
                                    	<div class="col-sm-4">
                                    		<?=$html_year_select?>
                                    	</div>
                                    	<div class="col-sm-4">
                                    		<button type="button" class="btn btn-sm btn btn-info" onClick="window.close();">Back</button>
                                    	</div>
                                	</div>
                            	</form> 
                            	<div class="tabs">
                                    <ul class="tab-links">
                                        <li id="t1"><a href="#tab1" class="tab1a">Management Fee</a></li>
                                        <li id="t2"><a href="#tab2" class="tab2a">Water Bill</a></li>
                                        <li id="t3"><a href="#tab3" class="tab3a">Late Interest Charge</a></li>
                                        <li id="t4"><a href="#tab4" class="tab4a">Quit Rent</a></li>
                                        <li id="t5"><a href="#tab5" class="tab5a">Insurance Premium</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab active" id="tab1">
                                            <table id="table-mfee" class="table table-striped table-bordered">                                               
                                                <thead>                                            
                                                    <tr>
                                                    	<th>Month</th>
                                                    	<th>Reference No.</th>
                                                    	<th>Description</th>
                                                    	<th>Payment (RM)</th>
                                                    	<th>Payment Date</th>
                                                    	<th>Payment Mode</th> 
                                                    	<th>Official Receipt No.</th>
                                                    	<th>Received Date</th>     
                                                    	<th>Remarks</th>      
                                                    	<th>Action</th>                                          	                               	
                                                    </tr>										
                                            	</thead>   
                                            	<tbody>
												<?php 
												$total_mf = 0;
                                            	foreach ($arr_data_mf as $data){
                                            	    $total_mf += $data['payment_amount'];
                                            	    ?>
                                            	<tr>
                                                    <td class="text-left"><?=$data['month_name']?></td>
                                                    <td class="text-left"><?=$data['ref_no']?></td>
        											<td class="text-left"><?=$data['description']?></td>
                                                    <td class="text-right"><?=number_format($data['payment_amount'],2)?></td> 
                                                    <td class="text-center"><?=dateFormatRev($data['payment_date'])?></td>                                              
                                                    <td class="text-center"><?=strtoupper($data['payment_mode'])?></td>
                                                    <td class="text-center"><?=$data['official_receipt_no']?></td>                                                            
                                                    <td class="text-center"><?=dateFormatRev($data['received_date'])?></td> 
                                                    <td class="text-center"><?=$data['remark']?></td>    
                                                    <td class="text-center">
                                                    	<span onclick="window.open('add_new_management.php?id=<?=$acc_id?>&item_id=<?=$data['id']?>')"><i class="fa fa-edit"></i></span>
                                                    	<span id="<?=$data['id']?>" data-toggle="modal" data="bill_management_fee" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                    </td>                                         
                                                </tr>
                                            	<?php }?>
                                            	</tbody>  
                                            	<tfoot>
                                            	<?php if(!empty($arr_data_mf)){?>
                                                	<tr>
                                                        <th class="text-center" colspan="3">TOTAL</th>                                                    
                                                        <th class="text-right"><?=number_format($total_mf,2)?></th>
                                                        <th class="text-center">&nbsp;</th>
                                                        <th class="text-center">&nbsp;</th>
                                                        <th class="text-right">&nbsp;</th>
                                                        <th class="text-center">&nbsp;</th>   
                                                        <th class="text-center">&nbsp;</th>    
                                                        <th class="text-center">&nbsp;</th>                                                                                    
                                                    </tr>
                                            	<?php }?>
                                            	</tfoot>                                             	                                                                                                       
                                            </table>
                                        </div>
                                        <div class="tab" id="tab2">                                            
                                            <table id="table-water-bill" class="table table-striped table-bordered">                                                
                                            <thead> 
                                            	<tr>
                                            		<th>Description</th>
                                            		<th colspan="3" class="text-center">Meter Reading</th>
                                            		<th colspan="2" class="text-center">Period Date</th>
                                            		<th rowspan="2">Payment Mode</th>
                                            		<th rowspan="2">Amount (RM)</th>
                                            		<th rowspan="2">OR No.</th>
                                            		<th rowspan="2">Payment Date</th>
                                            		<th rowspan="2">Action</th>
                                            	</tr>                                           
                                                <tr>
                                                	<th>Month</th>
                                                	<th>Previous</th>
                                                	<th>Current</th>
                                                	<th>Total Usage</th>
                                                	<th>From</th>
                                                	<th>To</th>                                                     	                                             	                               	
                                                </tr>										
                                        	</thead>   
                                        	<tbody>
                                        	<?php 
                                        	$total_consume = 0;
                                        	$total_amount = 0;
                                        	if(!empty($arr_data_wb)){
                                        	    foreach ($arr_data_wb as $data){
                                        	        $total_consume +=$data['total_consume'];
                                        	        $total_amount +=$data['total'];
                                        	        ?>
                                        	<tr>
                                                <td class="text-left"><?=$data['month_name']?></td>
                                                <td class="text-left"><?=$data['previous_mr']?></td>
    											<td class="text-left"><?=$data['current_mr']?></td>
                                                <td class="text-center"><?=$data['total_consume']?></td>                                            
                                                <td class="text-left"><?=dateFormatRev($data['date_from'])?></td>
                                                <td class="text-left"><?=dateFormatRev($data['date_to'])?></td>  
                                                <td class="text-center"><?=strtoupper($data['payment_mode'])?></td> 
                                                <td class="text-right"><?=number_format($data['total'],2)?></td> 
                                                <td class="text-center"><?=$data['or_no']?></td>         
                                                <td class="text-center"><?=dateFormatRev($data['payment_date'])?></td> 
                                                <td class="text-center">
                                                	<span onclick="window.open('add_new_water_bill.php?id=<?=$acc_id?>&item_id=<?=$data['id']?>')"><i class="fa fa-edit"></i></span>
                                                	<span id="<?=$data['id']?>" data-toggle="modal" data="bill_management_water" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                </td>
                                                                                            
                                            </tr>
                                        	<?php }
                                        	}?>
                                        	</tbody>  
                                        	<tfoot>
                                        	<?php if(!empty($arr_data_wb)){?>
                                        	<tr>
                                                <th class="text-center" colspan="3">TOTAL</th>
                                                <th class="text-center"><?=$total_consume?></th>
                                                <th class="text-center">&nbsp;</th>
                                                <th class="text-center">&nbsp;</th>
                                                <th class="text-right">&nbsp;</th>
                                                <th class="text-right"><?=number_format($total_amount,2)?></th>   
                                                <th class="text-center">&nbsp;</th>                
                                                <th class="text-center">&nbsp;</th>  
                                                <th class="text-center">&nbsp;</th>                                                                                        
                                            </tr>
                                            <?php } ?>
                                        	</tfoot>                                            	                                                                                                      
                                        </table>
									</div>
                                        <div class="tab" id="tab3">                                        	
                                            <table id="table-late-interest" class="table table-striped table-bordered">                                                
                                            <thead>                                            
                                                <tr>
                                                	<th>Bill Date</th>
                                                	<th>Invoice No.</th>
                                                	<th>Due Date</th>
                                                	<th>Description</th>
                                                	<th>Amount (RM)</th>
                                                	<th>Payment Mode</th>         
                                                	<th>OR No.</th>       
                                                	<th>Action</th>                                     	                                             	                               	
                                                </tr>										
                                        	</thead>   
                                        	<tbody>
                                        	<?php 
                                        	$li_total = 0;
                                        	if(!empty($arr_data_li)){
                                        	    foreach ($arr_data_li as $data){
                                        	        $li_total += $data['amount'];
                                        	        ?>
                                        	<tr>
                                                <td class="text-left"><?=dateFormatRev($data['bill_date'])?></td>
                                                <td class="text-left"><?=$data['inv_no']?></td>
    											<td class="text-left"><?=dateFormatRev($data['payment_due_date'])?></td>
                                                <td class="text-left"><?=$data['description']?></td>  
                                                <td class="text-right"><?=number_format($data['amount'],2)?></td>                                          
                                                <td class="text-center"><?=strtoupper($data['payment_mode'])?></td>  
                                                <td class="text-center"><?=$data['or_no']?></td> 
                                                <td class="text-center">
                                                	<span onclick="window.open('add_late_interest_charge.php?id=<?=$acc_id?>&item_id=<?=$data['id']?>')"><i class="fa fa-edit"></i></span>
                                                	<span id="<?=$data['id']?>" data-toggle="modal" data="bill_management_late_interest_charge" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                </td>                                                                                                       
                                            </tr>
                                        	<?php }
                                        	}?>
                                        	</tbody>  
                                        	<tfoot>
                                        	<?php if(!empty($arr_data_wb)){?>
                                        	<tr>
                                                <th class="text-center" colspan="4">TOTAL</th>
                                                <th class="text-right"><?=number_format($li_total,2)?></th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>                                                                                      
                                            </tr>
                                            <?php }?>
                                        	</tfoot>                                            	                                                                                                      
                                        </table>
									</div>
                                        <div class="tab" id="tab4">                                            
                                            <table id="table-quit-rent" class="table table-striped table-bordered">                                                
                                            <thead>                                            
                                                <tr>
                                                	<th>Invoice Date</th>
                                                	<th>Invoice No.</th>                                                    	
                                                	<th>Amount (RM)</th>
                                                	<th>Payment Mode</th>
                                                	<th>Due Date</th>
                                                	<th>Payment Date</th>
                                                	<th>Received Date</th>         
                                                	<th>OR No.</th>     
                                                	<th>Remarks</th>   
                                                	<th>Action</th>                                         	                                             	                               	
                                                </tr>										
                                        	</thead>   
                                        	<tbody>
                                        	<?php 
                                        	$total_qr = 0;
                                        	if(!empty($arr_data_qr)){
                                        	    foreach ($arr_data_qr as $data){
                                        	        $total_qr += $data['payment'];?>
                                        	<tr>
                                                <td class="text-left"><?=dateFormatRev($data['invoice_date'])?></td>
                                                <td class="text-center"><?=strtoupper($data['inv_no'])?></td>
    											<td class="text-right"><?=number_format($data['payment'],2)?></td>
                                                <td class="text-right"><?=strtoupper($data['payment_mode'])?></td>  
                                                <td class="text-center"><?=dateFormatRev($data['due_date'])?></td>                                          
                                                <td class="text-center"><?=dateFormatRev($data['date_paid'])?></td>  
                                                <td class="text-center"><?=dateFormatRev($data['date_received'])?></td>                                
                                                <td class="text-center"><?=strtoupper($data['or_no'])?></td>         
                                                <td class="text-center"><?=$data['remarks']?></td>  
                                                <td class="text-center">
                                                	<span onclick="window.open('add_quit_rent_billing.php?id=<?=$acc_id?>&item_id=<?=$data['id']?>')"><i class="fa fa-edit"></i></span>
                                                	<span id="<?=$data['id']?>" data-toggle="modal" data="bill_management_quit_rent" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                </td>                                                                               
                                            </tr>
                                        	<?php }
                                        	}?>
                                        	</tbody>  
                                        	<tfoot>
                                        	<?php if(!empty($arr_data_qr)){?>
                                        	<tr>
                                                <th colspan="2" class="text-center">TOTAL</th>
    											<th class="text-right"><?=number_format($total_qr,2)?></th>
                                                <th class="text-center">&nbsp;</th>
                                                <th class="text-center">&nbsp;</th>
                                                <th class="text-center">&nbsp;</th>
                                                <th class="text-right">&nbsp;</th>     
                                                <th class="text-right">&nbsp;</th>     
                                                <th class="text-right">&nbsp;</th>                                                                                      
                                            </tr>
                                            <?php }?>                                                
                                        	</tfoot>                                            	                                                                                                      
                                        </table>
									</div>
                                    <div class="tab" id="tab5">                                        
                                        <table id="table-insurance" class="table table-striped table-bordered">                                                
                                        <thead>                                            
                                            <tr>
                                            	<th>Premium Date</th>
                                            	<th>Invoice No.</th>
                                            	<th>Description</th>                                                    	
                                            	<th>Amount (RM)</th>
                                            	<th>Payment Mode</th>                                                    	
                                            	<th>Payment Date</th>                                                    	       
                                            	<th>OR No.</th>  
                                            	<th>Action</th>                                                         	                                            	                                             	                               	
                                            </tr>										
                                    	</thead>   
                                    	<tbody>
                                    	<?php 
                                    	if(!empty($arr_data_ip)){
                                    	    $total_ip = 0;
                                    	    foreach ($arr_data_ip as $data){
                                    	        $total_ip += $data['payment'];
                                    	        ?>
                                    	<tr>
                                            <td class="text-left"><?=$data['date_from']."~".$data['date_to']?></td>
                                            <td class="text-left"><?=$data['invoice_no']?></td>
											<td class="text-left"><?=$data['description']?></td>
                                            <td class="text-right"><?=number_format($data['payment'],2)?></td>  
                                            <td class="text-center"><?=strtoupper($data['payment_mode'])?></td>                                          
                                            <td class="text-center"><?=$data['date_paid']?></td>                                                                                  
                                            <td class="text-center"><?=$data['or_no']?></td>    
                                            <td class="text-center">
                                            	<span onclick="window.open('add_premium_insurance.php?id=<?=$acc_id?>&item_id=<?=$data['id']?>')"><i class="fa fa-edit"></i></span>
                                            	<span id="<?=$data['id']?>" data-toggle="modal" data="bill_management_insurance" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                            </td>                                                                                                                                             
                                        </tr>
                                    	<?php }
                                    	}?>
                                    	</tbody>  
                                    	<tfoot>
                                    	<?php if(!empty($arr_data_ip)){?>
                                    	<tr>
                                            <th colspan="3" class="text-center">TOTAL</th>
                                            <th class="text-right"><?=number_format($total_ip,2)?></th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>   
                                            <th>&nbsp;</th>                                                                                                                                              
                                        </tr>
                                        <?php }?>                                                
                                    	</tfoot>                                            	                                                                                                      
                                    </table>
								</div>
								</div>
                                </div>                           	                            	                                                                                                                                      	 
                           	</div> 
                           	<br>                      
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        <div class="modal fade" id="deleteItem">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Are you sure you want to delete?
                   </p>
               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="delete_record" class="btn btn-primary">Confirm</button>
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
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/js/select2.min.js"></script>
	
	<script type="text/javascript">
    $(document).ready(function() {		
		var acc_id = '<?=$id?>';			
        $('#table-mfee').DataTable({
            "bInfo" : false,
            "bLengthChange": false,
            "searching": false,
            "dom": "lBtipr",
            "buttons": {
              "buttons": [
                {
                  text: "Add New Record",
                  action: function(e, dt, node, config) {
                    //trigger the bootstrap modal
                      window.open('add_new_management.php?id=<?=$acc_id?>');
                  }
                }
              ],
              "dom": {
                "button": {
                  tag: "button",
                  className: "btn btn-primary"
                },
                "buttonLiner": {
                  tag: null
                }
              }
            }
        });
        $('#table-water-bill').DataTable({
            "bInfo" : false,
            "bLengthChange": false,
            "searching": false,
            "dom": "lBtipr",
            "buttons": {
              "buttons": [
                {
                  text: "Add New Record",
                  action: function(e, dt, node, config) {
                    //trigger the bootstrap modal
                      window.open('add_new_water_bill.php?id=<?=$acc_id?>');
                  }
                }
              ],
              "dom": {
                "button": {
                  tag: "button",
                  className: "btn btn-primary"
                },
                "buttonLiner": {
                  tag: null
                }
              }
            }
        });
        $('#table-late-interest').DataTable({
            "bInfo" : false,
            "bLengthChange": false,
            "searching": false,
            "dom": "lBtipr",
            "buttons": {
              "buttons": [
                {
                  text: "Add New Record",
                  action: function(e, dt, node, config) {
                    //trigger the bootstrap modal
                      window.open('add_late_interest_charge.php?id=<?=$acc_id?>');
                  }
                }
              ],
              "dom": {
                "button": {
                  tag: "button",
                  className: "btn btn-primary"
                },
                "buttonLiner": {
                  tag: null
                }
              }
            }
        });
        $('#table-quit-rent').DataTable({
            "bInfo" : false,
            "bLengthChange": false,
            "searching": false,
            "dom": "lBtipr",
            "buttons": {
              "buttons": [
                {
                  text: "Add New Record",
                  action: function(e, dt, node, config) {
                    //trigger the bootstrap modal
                      window.open('add_quit_rent_billing.php?id=<?=$acc_id?>');
                  }
                }
              ],
              "dom": {
                "button": {
                  tag: "button",
                  className: "btn btn-primary"
                },
                "buttonLiner": {
                  tag: null
                }
              }
            }
        });
        $('#table-insurance').DataTable({
            "bInfo" : false,
            "bLengthChange": false,
            "searching": false,
            "dom": "lBtipr",
            "buttons": {
              "buttons": [
                {
                  text: "Add New Record",
                  action: function(e, dt, node, config) {
                    //trigger the bootstrap modal
                      window.open('add_premium_insurance.php?id=<?=$acc_id?>');
                  }
                }
              ],
              "dom": {
                "button": {
                  tag: "button",
                  className: "btn btn-primary"
                },
                "buttonLiner": {
                  tag: null
                }
              }
            }
        });
        $(document).on('click', '.delete_data', function(){
        	var id = $(this).attr("id");
        	var database = $(this).attr("data");
        	
        	$('#delete_record').data('id', id); //set the data attribute on the modal button
        	$('#delete_record').data('database', database);
        
        });
      	
    	$( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		var DB = $(this).data('database');
    		$.ajax({
    			url:"management.ajax.php",
    			method:"POST",    
    			data:{action:'delete_account_details', id:ID, database:DB},
    			success:function(data){	
        			if(data){
        				$('#deleteItem').modal('hide');		
        				location.reload();		
            		}  						    				
    			}
    		});
    	});

        $('#payment_date_mf, #received_date_mf, #paid_date, #due_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });

        $(".tabs").tabs();
        var currentTab = $('.ui-state-active a').index();
        if(localStorage.getItem('activeTab') != null){
        	 $('.tabs > ul > li:nth-child('+ (parseInt(localStorage.getItem('activeTab')) + 1)  +')').find('a').click();
        }

         $('.tabs > ul > li > a').click(function(e) {
          var curTab = $('.ui-tabs-active');         
          curTabIndex = curTab.index();          
          localStorage.setItem('activeTab', curTabIndex);
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
        //format to dd-mm-yy
        function dateFormat(dates){
            var date = new Date(dates);
        	var day = date.getDate();
    	  	var monthIndex = date.getMonth()+1;
    	  	var year = date.getFullYear();

    	  	return (day <= 9 ? '0' + day : day) + '-' + (monthIndex<=9 ? '0' + monthIndex : monthIndex) + '-' + year ;
        }
    });
  </script>
</body>
</html>