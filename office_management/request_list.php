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
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Request List</strong>
                            </div>     
                           <div class="card-body">
                           <br>                            
                            <button type="button" class="btn btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem">
                               Add New 
							</button>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Request Date</th>
											<th>Item</th>
											<th>Details</th>
											<th>Quantity</th>
											<th>Unit cost</th>
											<th>Total cost</th>
											<th>Status</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $sql_query = "SELECT * FROM om_pcash_request"; //only show active vehicle 
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$row['request_date']?></td>
                                                        <td><?=$row['title']?></td>
                                                        <td><?=$row['details']?></td>
                                                        <td><?=$row['quantity']?></td>
                                                        <td><?=$row['cost_per_unit']?></td>
                                                        <td><?=$row['total_cost']?></td>
                                                        <td><?=$row['workflow_status']?></td>
                                                        <td>
                                                        	<span id="<?=$row['id']?>" data-toggle="modal" class="confirm_data" data-target="#confirmItem"><i class="fas fa-paper-plane"></i></span>
                                                        	&nbsp;&nbsp;<span id="<?=$row['id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	&nbsp;&nbsp;<span id="<?=$row['id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
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
        
        <!-- Modal Add new request -->
        <div id="addItem" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Request</h4>
                    </div>
                    <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">                    
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="company" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                            <div>
                                <?php
                                    $company = mysqli_query ( $conn_admin_db, "SELECT id, name FROM company");
                                    db_select ($company, 'company', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="request_date" class=" form-control-label"><small class="form-text text-muted">Request Date</small></label>
                            <div class="input-group">
                                <input id="request_date" name="request_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>   
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="title" class=" form-control-label"><small class="form-text text-muted">Title</small></label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                            <textarea rows="3" id="description" name="description" class="form-control"></textarea>
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="quantity" class=" form-control-label"><small class="form-text text-muted">Quantity</small></label>
                            <input type="text" id="quantity" name="quantity" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="cost_per_unit" class=" form-control-label"><small class="form-text text-muted">Cost per Unit</small></label>
                            <input type="text" id="cost_per_unit" name="cost_per_unit" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="total_cost" class=" form-control-label"><small class="form-text text-muted">Total Cost</small></label>
                            <input type="text" id="total_cost" name="total_cost" class="form-control">
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
                    <h4 class="modal-title">Edit Request</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="item" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                            <div>
                                <?php
                                    $company = mysqli_query ( $conn_admin_db, "SELECT id, name FROM company");
                                    db_select ($company, 'company_id', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>
                        </div>
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="date" class=" form-control-label"><small class="form-text text-muted">Request Date</small></label>
                                <div class="input-group">
                                    <input id="date" name="date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>   
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="item_title" class=" form-control-label"><small class="form-text text-muted">Title</small></label>
                                <input type="text" id="item_title" name="item_title" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="desc" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                                <textarea id="desc" row="3" name="desc" class="form-control"></textarea>
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="qty" class=" form-control-label"><small class="form-text text-muted">Quantity</small></label>
                                <input type="text" id="qty" name="qty" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="unit_cost" class=" form-control-label"><small class="form-text text-muted">Cost per Unit</small></label>
                                <input type="text" id="unit_cost" name="unit_cost" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="total" class=" form-control-label"><small class="form-text text-muted">Total Cost</small></label>
                                <input type="text" id="total" name="total" class="form-control">
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
        	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "80%", "targets": 1 },
//         	    { "width": "10%", "targets": 2 }
        	  ]
  	  	});
        
        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");          		
        	$.ajax({
        			url:"request.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_request', id:id},
        			dataType:"json",
        			success:function(data){ 
            			console.log(data);    
        				$('#id').val(id);					
                        $('#company_id').val(data.company_id);        
                        $('#date').val(data.request_date);      
                        $('#item_title').val(data.title);					
                        $('#desc').val(data.details);        
                        $('#qty').val(data.quantity);     
                        $('#unit_cost').val(data.cost_per_unit);        
                        $('#total').val(data.total_cost);                     
                        $('#editItem').modal('show');       			        			
        				
        			}
        		});
        });
    
        $(document).on('click', '.delete_data', function(){
        	var id = $(this).attr("id");
        	$('#delete_record').data('id', id); //set the data attribute on the modal button
        
        });

        $(document).on('click', '.confirm_data', function(){
        	var id = $(this).attr("id");
        	$('#confirm_record').data('id', id); //set the data attribute on the modal button
        
        });

        $( "#confirm_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"request.ajax.php",
    			method:"POST",    
    			data:{action:'confirm_request', id:ID},
    			success:function(data){	  						
    				$('#confirmItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
      	
    	$( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"request.ajax.php",
    			method:"POST",    
    			data:{action:'delete_request', id:ID},
    			success:function(data){	         							
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#company_id').val() == ""){  
              alert("Company is required");  
          }  
          else if($('#date').val() == ""){  
              alert("Request date is required");  
          } 
          else if($('#item_title').val() == ""){  
              alert("Title is required");  
          } 
          else if($('#desc').val() == ""){  
              alert("Description is required");  
          } 
          else if($('#qty').val() == ""){  
              alert("Quantity is required");  
          }   
          else if($('#unit_cost').val() == ""){  
              alert("Cost per unit is required");  
          }   
          else{  
               $.ajax({  
                    url:"request.ajax.php",  
                    method:"POST",  
                    data:{action:'update_request', data: $('#update_form').serialize()},  
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
            if($('#company').val() == ""){  
                alert("Company is required");  
            }  
            else if($('#request_date').val() == ""){  
                alert("Request date is required");  
            } 
            else if($('#title').val() == ""){  
                alert("Title is required");  
            } 
            else if($('#description').val() == ""){  
                alert("Description is required");  
            } 
            else if($('#quantity').val() == ""){  
                alert("Quantity is required");  
            }   
            else if($('#cost_per_unit').val() == ""){  
                alert("Cost per unit is required");  
            }     
            else{  
                 $.ajax({  
                      url:"request.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_request', data: $('#add_form').serialize()},  
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
