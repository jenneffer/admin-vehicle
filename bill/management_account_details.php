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
                        <div class="card">
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
                                	</div>
                            	</form> 
                            	<div class="custom-tab">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="custom-nav-management-fee-tab" data-toggle="tab" href="#custom-nav-management-fee" role="tab" aria-controls="custom-nav-home" aria-selected="true">Management Fee</a>
                                            <a class="nav-item nav-link" id="custom-nav-water-bill-tab" data-toggle="tab" href="#custom-nav-water-bill" role="tab" aria-controls="custom-nav-profile" aria-selected="false">Water Bill</a>
                                            <a class="nav-item nav-link" id="custom-nav-late-interest-charge-tab" data-toggle="tab" href="#custom-nav-late-interest-charge" role="tab" aria-controls="custom-nav-contact" aria-selected="false">Late Interest Charge</a>
                                            <a class="nav-item nav-link" id="custom-nav-quit-rent-tab" data-toggle="tab" href="#custom-nav-quit-rent" role="tab" aria-controls="custom-nav-contact" aria-selected="false">Quit Rent</a>
                                            <a class="nav-item nav-link" id="custom-nav-insurance-tab" data-toggle="tab" href="#custom-nav-insurance" role="tab" aria-controls="custom-nav-contact" aria-selected="false">Insurance Premium</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="custom-nav-management-fee" role="tabpanel" aria-labelledby="custom-nav-management-fee-tab">
                                        <div class="content">   
                                        	<br>                                       	
                                        	<div class="col-sm-12">  
                                        		<button type="button" class="btn btn btn-primary button_add" data-toggle="modal" data-target="#addManagementFee">Add New Record</button>                                                                                     	
                                            </div>
                                            <br>
                                            <table class="table table-striped table-bordered">                                                
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
                                                </tr>
                                            	<?php }?>
                                            	</tbody>  
                                            	<tfoot>
                                            	<tr>
                                                    <th class="text-center" colspan="3">TOTAL</th>                                                    
                                                    <th class="text-right"><?=number_format($total_mf,2)?></th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-right">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>   
                                                    <th class="text-center">&nbsp;</th>                                                                                        
                                                </tr>
                                            	</tfoot>                                             	                                                                                                       
                                            </table>
                                        </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-nav-water-bill" role="tabpanel" aria-labelledby="custom-nav-water-bill-tab">
                                            <div class="content">
                                            	<br>
                                                <div class="col-sm-12">  
                                            		<button type="button" class="btn btn btn-primary button_add" onclick="window.open('add_new_water_bill.php?id=<?=$acc_id?>')"">Add New Record</button>                                                                                     	
                                                </div>
                                                <br>
                                                <table class="table table-striped table-bordered">                                                
                                                <thead> 
                                                	<tr>
                                                		<th>Description</th>
                                                		<th colspan="3" class="text-center">Meter Reading</th>
                                                		<th colspan="2" class="text-center">Period Date</th>
                                                		<th rowspan="2">Payment Mode</th>
                                                		<th rowspan="2">Amount (RM)</th>
                                                		<th rowspan="2">OR No.</th>
                                                		<th rowspan="2">Payment Date</th>
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
                                            	if(!empty($arr_data_wb)){
                                            	    foreach ($arr_data_wb as $data){?>
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
                                                                                                
                                                </tr>
                                            	<?php }
                                            	}?>
                                            	</tbody>  
                                            	<tfoot>
                                            	<?php if(!empty($arr_data_wb)){?>
                                            	<tr>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
        											<th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-right">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>   
                                                    <th class="text-center">&nbsp;</th>                
                                                    <th class="text-center">&nbsp;</th>                                                                                        
                                                </tr>
                                                <?php }
                                                else{?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No records found.</td>                                                                                                                                          
                                                </tr>
                                                <?php }?>
                                            	</tfoot>                                            	                                                                                                      
                                            </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-nav-late-interest-charge" role="tabpanel" aria-labelledby="custom-nav-late-interest-charge-tab">
                                        	<div class="content">
                                            	<br>
                                                <div class="col-sm-12">  
                                            		<button type="button" class="btn btn btn-primary button_add" onclick="window.open('add_late_interest_charge.php?id=<?=$acc_id?>')">Add New Record</button>                                                                                     	
                                                </div>
                                                <br>
                                                <table class="table table-striped table-bordered">                                                
                                                <thead>                                            
                                                    <tr>
                                                    	<th>Bill Date</th>
                                                    	<th>Invoice No.</th>
                                                    	<th>Due Date</th>
                                                    	<th>Description</th>
                                                    	<th>Amount (RM)</th>
                                                    	<th>Payment Mode</th>         
                                                    	<th>OR No.</th>                                            	                                             	                               	
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
                                                </tr>
                                            	<?php }
                                            	}?>
                                            	</tbody>  
                                            	<tfoot>
                                            	<?php if(!empty($arr_data_wb)){?>
                                            	<tr>
                                                    <th colspan="4">Total</th>
                                                    <th class="text-right"><?=number_format($li_total,2)?></th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>                                                                                      
                                                </tr>
                                                <?php }
                                                else{?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No records found.</td>                                                                                                                                          
                                                </tr>
                                                <?php }?>
                                            	</tfoot>                                            	                                                                                                      
                                            </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-nav-quit-rent" role="tabpanel" aria-labelledby="custom-nav-quit-rent-tab">
                                        	<div class="content">
                                            	<br>
                                                <div class="col-sm-12">  
                                            		<button type="button" class="btn btn btn-primary button_add" onclick="window.open('add_quit_rent_billing.php?id=<?=$acc_id?>')">Add New Record</button>                                                                                     	
                                                </div>
                                                <br>
                                                <table class="table table-striped table-bordered">                                                
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
                                                </tr>
                                            	<?php }
                                            	}?>
                                            	</tbody>  
                                            	<tfoot>
                                            	<?php if(!empty($arr_data_wb)){?>
                                            	<tr>
                                                    <th colspan="2" class="text-center">Total</th>
        											<th class="text-right"><?=number_format($total_qr,2)?></th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-right">&nbsp;</th>     
                                                    <th class="text-right">&nbsp;</th>     
                                                    <th class="text-right">&nbsp;</th>                                                                                      
                                                </tr>
                                                <?php }
                                                else{?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No records found.</td>                                                                                                                                          
                                                </tr>
                                                <?php }?>
                                            	</tfoot>                                            	                                                                                                      
                                            </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-nav-insurance" role="tabpanel" aria-labelledby="custom-nav-insurance-tab">
                                        	<div class="content">
                                            	<br>
                                                <div class="col-sm-12">  
                                            		<button type="button" class="btn btn btn-primary button_add" onclick="window.open('add_premium_insurance.php?id=<?=$acc_id?>')">Add New Record</button>                                                                                     	
                                                </div>
                                                <br>
                                                <table class="table table-striped table-bordered">                                                
                                                <thead>                                            
                                                    <tr>
                                                    	<th>Premium Date</th>
                                                    	<th>Invoice No.</th>
                                                    	<th>Description</th>                                                    	
                                                    	<th>Amount (RM)</th>
                                                    	<th>Payment Mode</th>                                                    	
                                                    	<th>Payment Date</th>                                                    	       
                                                    	<th>OR No.</th>                                                         	                                            	                                             	                               	
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
                                                </tr>
                                            	<?php }
                                            	}?>
                                            	</tbody>  
                                            	<tfoot>
                                            	<?php if(!empty($arr_data_ip)){?>
                                            	<tr>
                                                    <th colspan="3">Total</th>
                                                    <th class="text-right"><?=number_format($total_ip,2)?></th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>                                                                                                                                               
                                                </tr>
                                                <?php }
                                                else{?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No records found.</td>                                                                                                                                          
                                                </tr>
                                                <?php }?>
                                            	</tfoot>                                            	                                                                                                      
                                            </table>
                                            </div>
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
        <!-- Modal add new mf -->
        <div class="modal fade" id="addManagementFee">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form_mf">  
                    <input type="hidden" id="acc_id" name="acc_id" value="">    
                    <div class="form-group row col-sm-12">                    	
                    	<div class="col-sm-6">
                            <label for="payment_date_mf" class=" form-control-label"><small class="form-text text-muted">Payment date</small></label>                                            
                            <div class="input-group">
                                <input id="payment_date_mf" name="payment_date_mf" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>       
                        <div class="col-sm-6">
                            <label for="received_date_mf" class=" form-control-label"><small class="form-text text-muted">Received date</small></label>                                            
                            <div class="input-group">
                                <input id="received_date_mf" name="received_date_mf" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>
                    </div>                                                    
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="invoice_no_mf" class=" form-control-label"><small class="form-text text-muted">Invoice No.</small></label>
                            <input type="text" id="invoice_no_mf" name="invoice_no_mf" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="description_mf" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                            <textarea id="description_mf" name="description_mf" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="payment_mf" class=" form-control-label"><small class="form-text text-muted">Payment Amount (RM)</small></label>
                            <input type="text" id="payment_mf" name="payment_mf" class="form-control">
                        </div>        
                        <div class="col-sm-6">
                            <label for="payment_mode_mf" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>
                            <input type="text" id="payment_mode_mf" name="payment_mode_mf" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">  
                    	<div class="col-sm-6">
                            <label for="cheque_no_mf" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                            <input type="text" id="cheque_no_mf" name="cheque_no_mf"class="form-control">
                        </div>                                   	
                        <div class="col-sm-6">
                            <label for="or_no_mf" class=" form-control-label"><small class="form-text text-muted">Official Receipt No.</small></label>
                            <input type="text" id="or_no_mf" name="or_no_mf" class="form-control">
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
    	<div class="modal fade" id="addWaterBill">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form_wb">  
                    <input type="hidden" id="acc_id" name="acc_id" value="">    
                    <div class="form-group row col-sm-12">                    	
                    	<div class="col-sm-6">
                            <label for="payment_date_mf" class=" form-control-label"><small class="form-text text-muted">Payment date</small></label>                                            
                            <div class="input-group">
                                <input id="payment_date_mf" name="payment_date_mf" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>       
                        <div class="col-sm-6">
                            <label for="received_date_mf" class=" form-control-label"><small class="form-text text-muted">Received date</small></label>                                            
                            <div class="input-group">
                                <input id="received_date_mf" name="received_date_mf" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>  
                        </div>
                    </div>                                                    
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="invoice_no_mf" class=" form-control-label"><small class="form-text text-muted">Invoice No.</small></label>
                            <input type="text" id="invoice_no_mf" name="invoice_no_mf" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="description_mf" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                            <textarea id="description_mf" name="description_mf" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="payment_mf" class=" form-control-label"><small class="form-text text-muted">Payment Amount (RM)</small></label>
                            <input type="text" id="payment_mf" name="payment_mf" class="form-control">
                        </div>        
                        <div class="col-sm-6">
                            <label for="payment_mode_mf" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>
                            <input type="text" id="payment_mode_mf" name="payment_mode_mf" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group col-sm-12">  
                    	<div class="col-sm-6">
                            <label for="cheque_no_mf" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                            <input type="text" id="cheque_no_mf" name="cheque_no_mf"class="form-control">
                        </div>                                   	
                        <div class="col-sm-6">
                            <label for="or_no_mf" class=" form-control-label"><small class="form-text text-muted">Official Receipt No.</small></label>
                            <input type="text" id="or_no_mf" name="or_no_mf" class="form-control">
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
        $('#add_form_mf').on("submit", function(event){  
            event.preventDefault();  
             
        });

        $('#payment_date_mf, #received_date_mf, #paid_date, #due_date').datepicker({
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