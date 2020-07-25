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
    .select2-container{ 
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
                                <strong class="card-title">Add deposit</strong>
                            </div>     
                           <div class="card-body">                          
                            <button type="button" class="btn btn-sm btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem">
                               Add New 
							</button>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date</th>
											<th>PV No.</th>
											<th>Amount (RM)</th>
											<th>Remark</th>											
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $sql_query = "SELECT * FROM om_pcash_deposit"; //only show active vehicle 
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$row['date']?></td>
                                                        <td><?=$row['pv_no']?></td>
                                                        <td><?=$row['amount']?></td>
                                                        <td><?=$row['remark']?></td>                                                        
                                                    </tr>
                                    <?php
                                                }
                                            }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        
        <!-- Modal Add new request -->
        <div id="addItem" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Deposit</h4>
                    </div>
                    <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">                                        
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="date" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                            <div class="input-group">
                                <input id="date" name="date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>   
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="pv_no" class=" form-control-label"><small class="form-text text-muted">PV No.</small></label>
                            <input type="text" id="pv_no" name="pv_no" class="form-control">
                        </div>
                    </div>                     
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM)</small></label>
                            <input type="text" id="amount" name="amount" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                            <textarea row="3" id="remark" name="remark" class="form-control"></textarea>
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
        <!-- Modal edit department  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Deposit</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="deposit_date" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                                <div class="input-group">
                                    <input id="deposit_date" name="deposit_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>   
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="deposit_pv_no" class=" form-control-label"><small class="form-text text-muted">PV No.</small></label>
                                <input type="text" id="deposit_pv_no" name="deposit_pv_no" class="form-control">
                            </div>
                        </div>                     
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="deposit_amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM)</small></label>
                                <input type="text" id="amount" name="amount" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="deposit_remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                                <textarea row="3" id="deposit_remark" name="deposit_remark" class="form-control"></textarea>
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
                    <h5 class="modal-title" id="staticModalLabel">Delete Deposit</h5>
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
    <!-- confirm request -->
    <div class="modal fade" id="confirmItem">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Confirm Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Are you sure you want to confirm this request?
                   </p>
               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirm_record" class="btn btn-primary">Confirm</button>
            	</div>
        	</div>
    	</div>
    </div>1

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
//     	var select2 = $("#item").select2({
//     		placeholder: "select option",
//     	    selectOnClose: true
//         });
//     	select2.data('select2').$selection.css('height', '38px');
//     	select2.data('select2').$selection.css('border', '1px solid #ced4da');
        
        $('#item-data-table').DataTable({
            'columnDefs': [                	    
        	    {
            	      "targets": [3], // your case first column
            	      "className": "text-center", 
            	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
            	 }
        	],
  	  	});
        
        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");          		
        	$.ajax({
        			url:"deposit.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_deposit', id:id},
        			dataType:"json",
        			success:function(data){ 
            			console.log(data);    
        				$('#id').val(id);					
                        $('#deposit_date').val(data.date);        
                        $('#deposit_pv_no').val(data.pv_no);      
                        $('#deposit_amount').val(data.amount);					
                        $('#deposit_remark').val(data.remark);                           
                        $('#editItem').modal('show');       			        			
        				
        			}
        		});
        });
    
        $(document).on('click', '.delete_data', function(){
        	var id = $(this).attr("id");
        	$('#delete_record').data('id', id); //set the data attribute on the modal button
        
        });

//         $(document).on('click', '.confirm_data', function(){
//         	var id = $(this).attr("id");
//         	$('#confirm_record').data('id', id); //set the data attribute on the modal button
        
//         });

//         $( "#confirm_record" ).click( function() {
//     		var ID = $(this).data('id');
//     		$.ajax({
//     			url:"deposit.ajax.php",
//     			method:"POST",    
//     			data:{action:'confirm_request', id:ID},
//     			success:function(data){	  						
//     				$('#confirmItem').modal('hide');		
//     				location.reload();		
//     			}
//     		});
//     	});
      	
    	$( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"deposit.ajax.php",
    			method:"POST",    
    			data:{action:'delete_deposit', id:ID},
    			success:function(data){	         							
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#deposit_date').val() == ""){  
              alert("Deposit date is required");  
          } 
          else if($('#deposit_pv_no').val() == ""){  
              alert("PV No. is required");  
          } 
          else if($('#deposit_amount').val() == ""){  
              alert("Amount is required");  
          }              
          else{  
               $.ajax({  
                    url:"deposit.ajax.php",  
                    method:"POST",  
                    data:{action:'update_deposit', data: $('#update_form').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data);
                         location.reload();  
                    }  
               });  
          }  
        }); 
        
        $('#add_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#date').val() == ""){  
                alert("Deposit date is required");  
            } 
            else if($('#pv_no').val() == ""){  
                alert("PV No. is required");  
            } 
            else if($('#amount').val() == ""){  
                alert("Amount is required");  
            }    
            else{  
                 $.ajax({  
                      url:"deposit.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_deposit', data: $('#add_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);
                           location.reload();  
                      }  
                 });  
            }  
          });

        $('#request_date, #date').datepicker({
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
