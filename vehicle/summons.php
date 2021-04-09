<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');
	require_once('../check_login.php');
	global $conn_admin_db;

?>

<!doctype html>
<html class="no-js" lang=""> 
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
                <div class="row" >
                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">Vehicle Summons</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>No.</th>
											<th>Vehicle No.</th>
                                            <th>Summons No</th>
											<th>Driver name</th>
											<th>Company</th>
											<th>Summon Type</th>
											<th>PV No</th>
											<th>Reimburse Amount (RM)</th>								
                                            <th>Balance</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
										<?php 
                                        $sql_query = "SELECT vs_id, vv_vehicleNo, vs_summon_no, vs_driver_name, company.code AS vs_code, st_name, 
                                                 IF(vs_summon_type=3, vs_summon_type_desc, NULL) AS summon_desc, 
                                                vs_pv_no, vs_reimbursement_amt, vs_balance  FROM vehicle_summons
                                                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_summons.vv_id
                                                INNER JOIN company ON company.id = vehicle_vehicle.company_id
                                                INNER JOIN vehicle_summon_type ON vehicle_summon_type.st_id = vehicle_summons.vs_summon_type
                                                WHERE vehicle_summons.status='1'";
                                        
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $summon_type = $row['summon_desc'] != NULL ? $row['st_name'] ." ( ". $row['summon_desc'] ." ) " : $row['st_name'];
                                                    ?>
                                                    <tr>
                                                    	<td><?=$count?></td>
                                                        <td><?=strtoupper($row['vv_vehicleNo'])?></td>
                                                        <td><?=$row['vs_summon_no']?></td>
                                                        <td><?=$row['vs_driver_name']?></td>
                                                        <td><?=$row['vs_code']?></td>
                                                        <td><?=$summon_type?></td>
                                                        <td><?=$row['vs_pv_no']?></td>
                                                        <td><?=number_format($row['vs_reimbursement_amt'], 2)?></td>
                                                        <td><?=number_format($row['vs_balance'], 2)?></td>
                                                        <td>
                                                        	<span id="<?=$row['vs_id']?>" data-toggle="modal" class="add_payment" data-target="#addPayment"><i class="menu-icon fas fa-money-check-alt"></i></span><br>
                                                        	<span id="<?=$row['vs_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i></span><br>
                                                        	<span id="<?=$row['vs_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i></span>
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
        
        <!-- Modal edit summon  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Summon</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="summon_id" name="summon_id" value="">
                    	<div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','', 'required');
                                ?>
                            </div>
                            <div class="col-sm-6">
                            	<label for="driver_name" class=" form-control-label"><small class="form-text text-muted">Driver's Name</small></label>
                                <input type="text" id="driver_name" name="driver_name" placeholder="Enter driver's name" class="form-control" required>
                                
                            </div>                                        
                        </div>
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="summon_no" class=" form-control-label"><small class="form-text text-muted">Summon's No.</small></label>
                                <input type="text" id="summon_no" name="summon_no" placeholder="Enter summon number" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                	<label for="summon_type" class=" form-control-label"><small class="form-text text-muted">Summon's Type</small></label>                                             
                                    <?php
                                        $summon_type = mysqli_query ( $conn_admin_db, "SELECT st_id, st_name FROM vehicle_summon_type");
                                        db_select ($summon_type, 'summon_type', '','','-select-','form-control','','required');
                                    ?>
                                </div>
                                <div id="desc">
                                    <label for="summon_desc" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                            		<textarea id="summon_desc" name="summon_desc" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- Only appear when summon type selected is others -->
                            
                        </div>
                        
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-6">
                                <label for="pv_no" class=" form-control-label">PV No.</label>
                                <input type="text" id="pv_no" name="pv_no" placeholder="Enter PV number" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="reimburse_amt" class=" form-control-label"><small class="form-text text-muted">Reimburse Amount(RM)</small></label>
                                <input type="text" id="reimburse_amt" name="reimburse_amt" placeholder="e.g 500.00" class="form-control" required>
                            </div>                                         
                        </div>
                        <div class="form-group row col-sm-12">                                          
                            <div class="form-group col-sm-6">
                                <label class="form-control-label"><small class="form-text text-muted">Summon's Date</small></label>
                                <div class="input-group input-inline">
                                    <input class="form-control" id="summon_date" name="summon_date" value="" required>
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                                
                            </div> 
							<div class="col-sm-6">
                            	<div class="col-sm-12">     
                            		<label class="form-control-label"><small class="form-text text-muted">Payment borne by<span class="color-red">*</span></small></label>
                            	</div>
                            	<div class="form-group row col-sm-12">     
                            		<div class="col-sm-6">
                            			<input type="checkbox" id="driver_borne" name="driver_borne">&nbsp;&nbsp;<label class="form-control-label"><small>Driver</small></label>
                            		</div>
                            		<div class="borne_by_driver col-sm-6">
                            			<select name="driver_b" id="driver_b" class="form-control form-control-sm">
                            				<option value="half">Half</option>
                            				<option value="full">Full</option>
                            			</select>
                            		</div>                                                                                   
                                </div>
                                <div class="form-group row col-sm-12">     
                            		<div class="col-sm-6">
                            			<input type="checkbox" id="company_borne" name="company_borne">&nbsp;&nbsp;<label class="form-control-label"><small>Company</small></label>
                            		</div>
                            		<div class="borne_by_company col-sm-6">
                            			<select name="company_b" id="company_b" class="form-control form-control-sm">
                            				<option value="half">Half</option>
                            				<option value="full">Full</option>
                            			</select>
                            		</div>                                                                                   
                                </div>
                        	</div>                                                                  
                        </div>
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-6">
                                <label for="offence_details" class=" form-control-label"><small class="form-text text-muted">Offense Details</small></label>                                             
                                <textarea name="offence_details" id="offence_details" name="offence_details" rows="5" placeholder="Offense details..." class="form-control"></textarea>
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
    
    <!-- Modal add summon's payment-->
        <div id="addPayment" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Summon's Payment</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" id="update_payment_form" class="form-horizontal">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vs_id" name="vs_id" value="">
                        <input type="hidden" id="reimburseAmount" name="reimburseAmount" value="">
                    	<div class="row form-group col-sm-12">
                            <div class="col col-md-4"><label class=" form-control-label"><small class="form-text text-muted">Vehicle No.</small></label></div>
                            <div class="col-12 col-md-8">
                                <p class="form-control-static"><span id="vehicleNo"></span></p>
                            </div>
                        </div>
                        <div class="row form-group col-sm-12">
                            <div class="col col-md-4"><label class=" form-control-label"><small class="form-text text-muted">Summon No.</small></label></div>
                            <div class="col-12 col-md-8">
                                <p class="form-control-static"><span id="summonNo"></span></p>
                            </div>
                        </div>
                        <div class="row form-group col-sm-12">
                            <div class="col col-md-4"><label class=" form-control-label"><small class="form-text text-muted">Driver Name</small></label></div>
                            <div class="col-12 col-md-8">
                                <p class="form-control-static"><span id="driverName"></span></p>
                            </div>
                        </div>
                        <div class="row form-group col-sm-12">
                            <div class="col col-md-4"><label class=" form-control-label"><small class="form-text text-muted">Reimburse Amount (RM)</small></label></div>
                            <div class="col-12 col-md-8">
                                <p class="form-control-static"><span id="reimburseAmt"></span></p>
                            </div>
                        </div>
                        <div class="row form-group col-sm-12">
                            <div class="col col-md-4"><label class=" form-control-label"><small class="form-text text-muted">Balance (RM)</small></label></div>
                            <div class="col-12 col-md-8">
                                <p class="form-control-static"><span id="balance"></span></p>
                            </div>
                        </div>
                        <div id="payment_section">
                            <div class="form-group row col-sm-12">
                                <div class="col-sm-6">
                                    <label class=" form-control-label"><small class="form-text text-muted">Payment Date</small></label>
                                    <div class="input-group input-inline">
                                        <input class="form-control" id="payment_date" name="payment_date" value="" autocomplete="off">
                                        <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class=" form-control-label"><small class="form-text text-muted">Payment Amount(RM)</small></label>
                                    <input type="text" id="payment_amount" name="payment_amount" placeholder="e.g 500.00" class="form-control">
                                </div>                                        
                            </div>
                            <div class="form-group row col-sm-12">
                                <div class="col-sm-6">
                                    <label class=" form-control-label"><small class="form-text text-muted">Bank-in Date</small></label>
                                    <div class="input-group input-inline">
                                        <input class="form-control" id="bankin_date" name="bankin_date" value="" autocomplete="off">
                                        <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class=" form-control-label"><small class="form-text text-muted">Bank-in Amount(RM)</small></label>
                                    <input type="text" id="bankin_amount" name="bankin_amount" placeholder="e.g 500.00" class="form-control">
                                </div>                                        
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary update_payment ">Update</button>
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
                        <h5 class="modal-title" id="staticModalLabel">Delete Summon</h5>
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
	
	<script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
          $('#desc').hide(); 
          $('#summon_type').change(function(){
              if($('#summon_type').val() == 3) {
                  $('#desc').show(); 
              } else {
                  $('#desc').hide(); 
              } 
          });

          

//           $('#summon_date').datepicker({
//           	dateFormat: 'dd-mm-yy'
//            });

          $(document).on('click', '.edit_data', function(){
  			var summon_id = $(this).attr("id");
  			$.ajax({
  					url:"summon.all.ajax.php",
  					method:"POST",
  					data:{ action:'retrive_summon', summon_id:summon_id },
  					dataType:"json",
  					success:function(data){	   	  	  					  	  					
  						var reimburse_amt = parseFloat(data.vs_reimbursement_amt).toFixed(2);
  						var summon_date = dateFormat(data.vs_summon_date);
  						var vs_driver_borne = data.vs_driver_borne;
  						var vs_company_borne = data.vs_company_borne;

  						//payment borne
  						if(vs_driver_borne != ""){
  	  						$('.borne_by_driver').show();
  	  						$("#driver_borne").prop("checked", true);
  	  						$('#driver_b').val(vs_driver_borne);
  						}else{
  							$('.borne_by_driver').hide();
  	  						$("#driver_borne").prop("checked", false);
  	  					}
  						if(vs_company_borne != ""){
  	  						$('.borne_by_company').show();
  	  						$("#company_borne").prop("checked", true);
  	  						$('#company_b').val(vs_company_borne);
  						}else{
  							$('.borne_by_company').hide();
  	  						$("#company_borne").prop("checked", false);  	  						
  	  					}

                        $('#company_borne').change(function(){
							$('.borne_by_company').toggle();
                        });
                        
                        $('#driver_borne').change(function() {
							$('.borne_by_driver').toggle();
                        });

  	  					var summon_desc = "";	
      	  				if(data.vs_summon_type == 3) {
      	                	$('#desc').show();
      	                	summon_desc = data.vs_summon_type_desc; 
          	            } else {
          	                $('#desc').hide(); 
          	            }
						
						          	             	
  						$('#summon_id').val(data.vs_id);					
                        $('#vehicle_reg_no').val(data.vv_id);  
                        $('#driver_name').val(data.vs_driver_name);  
                        $('#summon_no').val(data.vs_summon_no);  
                        $('#summon_type').val(data.vs_summon_type);  
                        $('#summon_desc').val(summon_desc);  
                        $('#pv_no').val(data.vs_pv_no);  
                        $('#reimburse_amt').val(reimburse_amt);   
                        $('#offence_details').val(data.vs_description);  
                        $('#summon_date').val(summon_date);  
                        $('#editItem').modal('show');
  					}
  				});
        });

          
		//add summon payment - retrieve then update
        $(document).on('click', '.add_payment', function(){
			var summon_id = $(this).attr("id");
			$.ajax({
					url:"summon.all.ajax.php",
					method:"POST",
					data:{ action:'retrive_summon', summon_id:summon_id },
					dataType:"json",
					success:function(data){	 
						var reimburse_amt = parseFloat(data.vs_reimbursement_amt).toFixed(2);
						var balance = parseFloat(data.vs_balance).toFixed(2);	
						var vehicle_no = data.vv_vehicleNo.toUpperCase();	
						var driver_name = data.vs_driver_name.toUpperCase();
										
                        $('#vs_id').val(data.vs_id);
                        $('#reimburseAmount').val(data.vs_reimbursement_amt);    				
                        $('#vehicleNo').html(vehicle_no);  
                        $('#summonNo').html(data.vs_summon_no);   
                        $('#driverName').html(driver_name);                         
                        $('#reimburseAmt').html(reimburse_amt);    
                        $('#balance').html(balance);                           
                        $('#addPayment').modal('show');

                      //hide payment section if balance is 0
                        if(data.vs_balance == null || data.vs_balance == 0){
                			$('#payment_section').hide();
                			$('.modal-footer').hide();
                        }
                        else{
                        	$('#payment_section').show();
                        	$('.modal-footer').show();
                        }
					}
				});
          });
		//delete item
        $(document).on('click', '.delete_data', function(){
			var summon_id = $(this).attr("id");
			$('#delete_record').data('id', summon_id); //set the data attribute on the modal button

    	});
        $( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"summon.all.ajax.php",
    			method:"POST",    
    			data:{action:'delete_summon', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    	
		//update summon form submit
        $('#update_form').on("submit", function(event){  
            event.preventDefault();  
//             if($('#vehicle_reg_no').val() == "")  
//             {  
//                  alert("Vehicle number is required");  
//             }  
//             else if($('#driver_name').val() == '')  
//             {  
//                  alert("Driver's name is required");  
//             }  
//             else if($('#summon_no').val() == '')  
//             {  
//                  alert("Summon's number is required");  
//             }  
//             else if($('#summon_type').val() == '')  
//             {  
//                  alert("Summon type is required");  
//             }  
//             else if($('#summon_date').val() == '')  
//             {  
//                  alert("Summon's date is required");  
//             }  
//             else if($('#reimburse_amt').val() == '')  
//             {  
//                  alert("Reimburse amount is required");  
//             }   
//             else  
//             {  
                 $.ajax({  
                      url:"summon.all.ajax.php",  
                      method:"POST",  
                      data:{action:'update_summon', data:$('#update_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);  
//                            location.reload();	
                      }  
                 });  
//             }  
       });

      //update add payment form submit
        $('#update_payment_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#payment_date').val() == "")  
            {  
                 alert("Payment date is required");  
            }  
            else if($('#payment_amount').val() == '')  
            {  
                 alert("Payment amount is required");  
            }  
            else if($('#bankin_date').val() == '')  
            {  
                 alert("Bank-in date is required");  
            }  
            else if($('#bankin_amount').val() == '')  
            {  
                 alert("Bank-in amount is required");  
            }    
            else  
            {  
                 $.ajax({  
                      url:"summon.all.ajax.php",  
                      method:"POST",  
                      data:{action:'add_payment', data:$('#update_payment_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data); 
                           location.reload(); 
                      }  
                 });  
            }  
       });
        
        $('#summon_date').datepicker({
        	format: "dd-mm-yyyy",            
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });
        $('#payment_date').datepicker({
        	format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });
        $('#bankin_date').datepicker({
        	format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });
      });


    function dateFormat(dates){
        var date = new Date(dates);
    	var day = date.getDate();
	  	var monthIndex = date.getMonth()+1;
	  	var year = date.getFullYear();

	  	return (day <= 9 ? '0' + day : day) + '-' + (monthIndex<=9 ? '0' + monthIndex : monthIndex) + '-' + year ;
    }
  </script>
</body>

</html>
