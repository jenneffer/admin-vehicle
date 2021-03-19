<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;


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
        .select2-selection{
            width: 100% !important; 
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
                                <strong class="card-title">Runner Claim</strong>
                            </div>     
                           <div class="card-body">
                           <br>                            
                            <button type="button" class="btn btn-sm btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem">
                               Add New
							</button>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Runner</th>
											<th rowspan="2">Bill No.</th>
											<th rowspan="2">Vehicle No.</th>
											<th rowspan="2">Invoice No.</th>
											<th rowspan="2">Invoice Amount(RM)</th>
											<th rowspan="2">Inspection Charge(RM)</th>
											<th rowspan="2">Service Charge(RM)</th>
											<th rowspan="2">Other Misc</th>
											<th rowspan="2">Total (RM)</th>
											<th colspan="2">Puspakom Period</th>
											<th rowspan="2">Remark</th>
											<th rowspan="2">Action</th>
											
                                        </tr>
                                        <tr>                                         
                                        	<th>From</th>
                                        	<th>To</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM vehicle_runner_claim vrc
                                                INNER JOIN vehicle_vehicle vv ON vv.vv_id = vrc.vehicle_id
                                                INNER JOIN vehicle_runner vr ON vr.r_id = vrc.runner_id AND vrc.status='1'";
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $claim_id = $row['id'];
                                                    $runner_name = $row['r_name'];
                                                    $bill_no = $row['bill_no'];
                                                    $vehicle_no = $row['vv_vehicleNo'];
                                                    $invoice_no = $row['invoice_no'];
                                                    $invoice_amt = $row['invoice_amount'];
                                                    $inspection_charge = $row['inspection_charge'];
                                                    $service_charge = $row['service_charge'];
                                                    $other_misc = $row['other_misc'];
                                                    $total = $invoice_amt + $inspection_charge + $service_charge;
                                                    $puspakom_from = $row['puspakom_from'];
                                                    $puspakom_to = $row['puspakom_to'];
                                                    $remark = $row['remark'];
                                                    
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=strtoupper($runner_name)?></td>
                                                        <td><?=$bill_no?></td> 
                                                        <td><?=$vehicle_no?></td>    
                                                        <td><?=$invoice_no?></td>    
                                                        <td><?=number_format($invoice_amt,2)?></td>    
                                                        <td><?=number_format($inspection_charge,2)?></td>    
                                                        <td><?=number_format($service_charge,2)?></td>    
                                                        <td><?=$other_misc?></td>    
                                                        <td><?=number_format($total,2)?></td>    
                                                        <td><?=dateFormatRev($puspakom_from)?></td>  
                                                        <td><?=dateFormatRev($puspakom_to)?></td>   
                                                        <td><?=$remark?></td>                                                                                                               
                                                        <td>
                                                        	<span id="<?=$claim_id?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	<span id="<?=$claim_id?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                            }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        
        <!-- Modal Add new item -->
        <div id="addItem" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Claim</h4>
                    </div>
                    <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_new_claim">  
                    	<div class="form-group row col-sm-12">
                            <div class="form-group col-sm-6">
                                <label for="runner" class="form-control-label"><small class="form-text text-muted">Runner's Name<span class="color-red">*</span></small></label>
                                <div>
                                <?php
                                    $runner = mysqli_query ( $conn_admin_db, "SELECT r_id, UPPER(r_name) FROM vehicle_runner WHERE r_status='1'");
                                    db_select ($runner, 'runner', '','','-select-','form-control','','required');
                                ?>   
                                </div>   
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle No.<span class="color-red">*</span></small></label>
                                <div>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','','required');
                                ?>
                                </div>
                            </div>                                      
                        </div>                                  
                 		  
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="bill_no" class="form-control-label"><small class="form-text text-muted">Bill No.<span class="color-red">*</span></small></label>
                                <input type="text" id="bill_no" name="bill_no" class="form-control" autocomplete="off" required>                                           
                            </div>
                            <div class="col-sm-6">
                                <label for="invoice_no" class="form-control-label"><small class="form-text text-muted">Invoice No.<span class="color-red">*</span></small></label>
                                <input type="text" id="invoice_no" name="invoice_no" class="form-control" autocomplete="off" required>                                           
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="invoice_amount" class="form-control-label"><small class="form-text text-muted">Invoice Amount (RM)<span class="color-red">*</span></small></label>
                                <input type="text" id="invoice_amount" name="invoice_amount" class="form-control"  placeholder="0.00" autocomplete="off" required>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="invoice_date" class="form-control-label"><small class="form-text text-muted">Invoice Date<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="invoice_date" name="invoice_date" class="form-control" autocomplete="off" required>                                    
                                </div>
                            </div>  
                        </div>
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="inspection_charge" class="form-control-label"><small class="form-text text-muted">Inspection Charge (RM)<span class="color-red">*</span></small></label>
                                <input type="text" id="inspection_charge" name="inspection_charge" class="form-control"  placeholder="0.00" autocomplete="off" required>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="service_charge" class="form-control-label"><small class="form-text text-muted">Service Charge (RM)<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="service_charge" name="service_charge" class="form-control" placeholder="0.00" autocomplete="off" required>                                    
                                </div>
                            </div>  
                        </div>
                        
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="puspakom_from" class="form-control-label"><small class="form-text text-muted">Puspakom from date<span class="color-red">*</span></small></label>
                                <input type="text" id="puspakom_from" name="puspakom_from" class="form-control" autocomplete="off" required>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="puspakom_to" class="form-control-label"><small class="form-text text-muted">Puspakom end date<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="puspakom_to" name="puspakom_to" class="form-control" autocomplete="off" required>                                    
                                </div>
                            </div>  
                        </div>
                        
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="other_misc" class="form-control-label"><small class="form-text text-muted">Other Misc.<span class="color-red">*</span></small></label>
                                <textarea id="other_misc" name="other_misc" class="form-control" required></textarea>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="remark" class="form-control-label"><small class="form-text text-muted">Remark</small></label>
                                <div class="input-group">
                                    <textarea id="remark" name="remark" class="form-control" autocomplete="off"></textarea>                                  
                                </div>
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
        <!-- Modal edit item  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Runner Claim</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form"> 
                    <input type="hidden" name="claim_id" id="claim_id" value=""> 
                    	<div class="form-group row col-sm-12">
                            <div class="form-group col-sm-6">
                                <label for="runner_up" class="form-control-label"><small class="form-text text-muted">Runner's Name<span class="color-red">*</span></small></label>
                                <div>
                                <?php
                                    $runner = mysqli_query ( $conn_admin_db, "SELECT r_id, UPPER(r_name) FROM vehicle_runner WHERE r_status='1'");
                                    db_select ($runner, 'runner_up', '','','-select-','form-control','','required');
                                ?>   
                                </div>   
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="vehicle_reg_no_up" class=" form-control-label"><small class="form-text text-muted">Vehicle No.<span class="color-red">*</span></small></label>
                                <div>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no_up', '','','-select-','form-control','','required');
                                ?>
                                </div>
                            </div>                                      
                        </div>                                  
                 		  
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="bill_no_up" class="form-control-label"><small class="form-text text-muted">Bill No.<span class="color-red">*</span></small></label>
                                <input type="text" id="bill_no_up" name="bill_no_up" class="form-control" autocomplete="off" required>                                           
                            </div>
                            <div class="col-sm-6">
                                <label for="invoice_no_up" class="form-control-label"><small class="form-text text-muted">Invoice No.<span class="color-red">*</span></small></label>
                                <input type="text" id="invoice_no_up" name="invoice_no_up" class="form-control" autocomplete="off" required>                                           
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="invoice_amount_up" class="form-control-label"><small class="form-text text-muted">Invoice Amount (RM)<span class="color-red">*</span></small></label>
                                <input type="text" id="invoice_amount_up" name="invoice_amount_up" class="form-control" required>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="invoice_date_up" class="form-control-label"><small class="form-text text-muted">Invoice Date<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="invoice_date_up" name="invoice_date_up" class="form-control" autocomplete="off" required>                                    
                                </div>
                            </div>  
                        </div>
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="inspection_charge_up" class="form-control-label"><small class="form-text text-muted">Inspection Charge (RM)<span class="color-red">*</span></small></label>
                                <input type="text" id="inspection_charge_up" name="inspection_charge_up" class="form-control" required>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="service_charge_up" class="form-control-label"><small class="form-text text-muted">Service Charge (RM)<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="service_charge_up" name="service_charge_up" class="form-control" autocomplete="off" required>                                    
                                </div>
                            </div>  
                        </div>
                        
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="puspakom_from_up" class="form-control-label"><small class="form-text text-muted">Puspakom from date<span class="color-red">*</span></small></label>
                                <input type="text" id="puspakom_from_up" name="puspakom_from_up" class="form-control" required>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="puspakom_to_up" class="form-control-label"><small class="form-text text-muted">Puspakom end date<span class="color-red">*</span><span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="puspakom_to_up" name="puspakom_to_up" class="form-control" autocomplete="off" required>                                    
                                </div>
                            </div>  
                        </div>
                        
                        <div class="form-group row col-sm-12">  
                        	<div class="col-sm-6">
                                <label for="other_misc_up" class="form-control-label"><small class="form-text text-muted">Other Misc.<span class="color-red">*</span></small></label>
                                <textarea id="other_misc_up" name="other_misc_up" class="form-control" required></textarea>                                           
                            </div>
                        	<div class="col-sm-6">
                                <label for="remark_up" class="form-control-label"><small class="form-text text-muted">Remark</small></label>
                                <div class="input-group">
                                    <textarea id="remark_up" name="remark_up" class="form-control" autocomplete="off"></textarea>                                  
                                </div>
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary update_data ">Update</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
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
	<script src="../assets/js/select2.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function() {   
    	// Initialize select2
    	var select2 = $("#vehicle_reg_no").select2({
    	    selectOnClose: true
        });
    	select2.data('select2').$selection.css('height', '38px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da'); 	
        $('#item-data-table').DataTable({
//         	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "60%", "targets": 1 },
//         	    { "width": "20%", "targets": 2 },
//         	    { "width": "10%", "targets": 3 }
//         	  ]
  	  	});

        
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
              if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
              } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
              } else {
                this.value = "";
              }
            });
          };
        //filter input number
        $("#invoice_amount,#inspection_charge,#service_charge").inputFilter(function(value) {
        	  return /^-?\d*[.,]?\d*$/.test(value); 
        });

        $("#invoice_amount_up,#inspection_charge_up,#service_charge_up").inputFilter(function(value) {
      	  return /^-?\d*[.,]?\d*$/.test(value); 
      });

        $(document).on('click', '.edit_data', function(){
        	var claim_id = $(this).attr("id");
        	$.ajax({
        			url:"vehicle.all.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_runner_claim', id:claim_id},
        			dataType:"json",
        			success:function(data){        
            			console.log(data);  			
        				$('#claim_id').val(claim_id);					
                        $('#runner_up').val(data.runner_id);   
                        $('#vehicle_reg_no_up').val(data.vehicle_id);    
                        $('#bill_no_up').val(data.bill_no);   
                        $('#invoice_no_up').val(data.invoice_no);    
                        $('#invoice_amount_up').val(data.invoice_amount);   
                        $('#invoice_date_up').val(dateFormat(data.invoice_date));    
                        $('#inspection_charge_up').val(data.inspection_charge);   
                        $('#service_charge_up').val(data.service_charge);    
                        $('#puspakom_from_up').val(dateFormat(data.puspakom_from));   
                        $('#puspakom_to_up').val(dateFormat(data.puspakom_to));       
                        $('#other_misc_up').val(data.other_misc);   
                        $('#remark_up').val(data.remark);                                            
                        $('#editItem').modal('show');
        			}
        		});
        });
    
        $(document).on('click', '.delete_data', function(){
        	var id = $(this).attr("id");        	
        	$('#delete_record').data('id', id); //set the data attribute on the modal button
        
        });
      	
    	$( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');    		
    		$.ajax({
    			url:"vehicle.all.ajax.php",
    			method:"POST",    
    			data:{action:'delete_runner_claim', id:ID},
    			success:function(data){	 
    				if(data){  
    					$('#deleteItem').modal('hide');	
                        alert("Deleted Successfully!");
                        window.location = "runner_claim.php";  
                    }  							
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){    
          event.preventDefault();  
          $.ajax({  
              url:"vehicle.all.ajax.php",  
              method:"POST",  
              data:{action:'update_runner_claim', data: $('#update_form').serialize()},  
              success:function(data){ 
                    if(data){  
                        console.log(data);
                        $('#editItem').modal('hide');	
                        alert("Updated Successfully!");
                        window.location = "runner_claim.php";  
                    }                               
              }  
         });    
        }); 
        
        $('#add_new_claim').on("submit", function(event){  
            event.preventDefault();  
            $.ajax({  
                url:"vehicle.all.ajax.php",  
                method:"POST",  
                data:{action:'add_new_claim', data: $('#add_new_claim').serialize()},  
                success:function(data){ 
                      if(data){  
                          alert("Added Successfully!");
                          window.location = "runner_claim.php";  
                      }                               
                }  
           	});  
          });
        
        $('#invoice_date,#puspakom_from,#puspakom_to,#invoice_date_up,#puspakom_from_up,#puspakom_to_up').datepicker({
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
