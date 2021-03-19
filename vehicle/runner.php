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
            width: 100%;
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
                                <strong class="card-title">List of Runner</strong>
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
											<th>Name</th>
											<th>Status</th>
											<th>Action</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM vehicle_runner"; //only show active vehicle with permit
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $r_id = $row['r_id'];
                                                    $r_name = $row['r_name'];
                                                    $r_status = $row['r_status'] == 1 ? 'Active' : 'Inactive';
                                                    
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$r_name?></td>
                                                        <td><?=$r_status?></td>                                                                                                            
                                                        <td>
                                                        	<span id="<?=$r_id?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	<span id="<?=$r_id?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
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
                        <h4 class="modal-title">Add New Runner</h4>
                    </div>
                    <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_runner">                                    
                 		<div class="form-group row col-sm-12">                                     	
                        	<div class="col-sm-6">
                                <label for="runner_name" class="form-control-label"><small class="form-text text-muted">Runner's Name<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="runner_name" name="runner_name" class="form-control" autocomplete="off" >                                            
                                </div>                                            
                            </div>
                            <div class="col-sm-3">
                                <label for="runner_status" class="form-control-label"><small class="form-text text-muted">Status</small></label>
                                <div class="input-group">
                                    <select class="form-control" name="runner_status" id="runner_status">
                                    	<option value='0'>Inactive</option>
                                    	<option value='1' selected>Active</option>
                                    </select>                                           
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
                    <h4 class="modal-title">Edit Runner</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="runner_id" name="runner_id" value="">
                        <div class="form-group row col-sm-12">                                     	
                        	<div class="col-sm-6">
                                <label for="r_name" class="form-control-label"><small class="form-text text-muted">Runner's Name<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="r_name" name="r_name" class="form-control" autocomplete="off" >                                            
                                </div>                                            
                            </div>
                            <div class="col-sm-3">
                                <label for="r_status" class="form-control-label"><small class="form-text text-muted">Status</small></label>
                                <div class="input-group">
                                    <select class="form-control" name="r_status" id="r_status">
                                    	<option value='0'>Inactive</option>
                                    	<option value='1'>Active</option>
                                    </select>                                           
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
        $('#item-data-table').DataTable({
//         	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "60%", "targets": 1 },
//         	    { "width": "20%", "targets": 2 },
//         	    { "width": "10%", "targets": 3 }
//         	  ]
  	  	});

        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");
        	$.ajax({
        			url:"vehicle.all.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_runner', id:id},
        			dataType:"json",
        			success:function(data){  
            			console.log(data);          			
        				$('#runner_id').val(id);					
                        $('#r_name').val(data.r_name);   
                        $('#r_status').val(data.r_status);                                            
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
    			data:{action:'delete_runner', id:ID},
    			success:function(data){	 
    				if(data){  
    					$('#deleteItem').modal('hide');	
                        alert("Added Successfully!");
                        window.location = "runner.php";  
                    }  							
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){    
          event.preventDefault();  
          if($('#r_name').val() == ""){  
               alert("Runner name is required");  
          }    
          else{  
               $.ajax({  
                    url:"vehicle.all.ajax.php",  
                    method:"POST",  
                    data:{action:'update_runner', data: $('#update_form').serialize()},  
                    success:function(data){ 
                          if(data){  
                              alert("Updated Successfully!");
                              window.location = "runner.php";  
                          }                               
                    }  
               });  
          }  
        }); 
        
        $('#add_runner').on("submit", function(event){  
            event.preventDefault();  
            if($('#runner_name').val() == ""){  
                 alert("Runner name is required");  
            }    
            else{  
                 $.ajax({  
                      url:"vehicle.all.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_runner', data: $('#add_runner').serialize()},  
                      success:function(data){ 
                            if(data){  
                                alert("Added Successfully!");
                                window.location = "runner.php";  
                            }                               
                      }  
                 });  
            }  
          });
        
        $('#lpkp_permit_due_date').datepicker({
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
