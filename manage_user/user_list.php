<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;
	
	$arr_item_unit = array(
	  'pieces' => 'Pieces',
	  'packet' => 'Packet',
	  'box' => 'Box'
	);
	
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">List of User</strong>
                            </div>     
                           <div class="card-body">
                           <br>                                                        
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
											<th>Name</th>
											<th>Email</th>
											<th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM credential"; //only show active vehicle                                         
                                        $count = 0;
                                        $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                            while($row = mysqli_fetch_array($sql_result)){ 
                                                $count++;                                                    
                                                ?>
                                                <tr>
                                                    <td><?=$count?>.</td>
                                                    <td><?=$row['cr_name']?></td>
                                                    <td><?=$row['cr_email']?></td>
                                                    <td>
                                                    	<span id="<?=$row['cr_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                    	<span id="<?=$row['cr_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                    </td>
                                                </tr>
                                <?php
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
       
        <!-- Modal edit item  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="card-body card-block">
                        	<div class="form-group row col-sm-12">
                        		<div class="col-sm-6">
                                    <label for="name" class=" form-control-label"><small class="form-text text-muted">Name</small></label>
                                    <input type="text" id="name" name="name" placeholder="Enter name" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label for="username" class=" form-control-label"><small class="form-text text-muted">Username</small></label>
                                    <input type="text" id="username" name="username" placeholder="Enter username" class="form-control">
                                </div>                    
                            </div>
                            <div class="form-group row col-sm-12">
<!--                             	<div class="col-sm-6"> -->
<!--                                     <label for="password" class=" form-control-label"><small class="form-text text-muted">Password</small></label> -->
<!--                                     <input type="text" id="password" name="password" placeholder="Enter password" class="form-control"> -->
<!--                                 </div> -->
                                <div class="col-sm-6">
                                    <label for="email" class=" form-control-label"><small class="form-text text-muted">Email</small></label>
                                    <input type="text" id="email" name="email" placeholder="Enter email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="col col-md-1"><label class=" form-control-label"><strong>Access</strong></label></div>
                                <!-- Populate the checkbox based on the module/system in the database -->
                                <?php 
                                $query = "SELECT * FROM admin_system";
                                $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
                                while($row = mysqli_fetch_assoc($sql_result)){?>
                                      <div class="form-check form-group col-sm-12">
                                        <input type="checkbox" class="form-check-input" id="system[]" name="system[]" value="<?=$row['sid'];?>">
                                        <label class="form-check-label"><?=$row['sname']?></label>
                                      </div>
                                <?php }
                                ?>
                                
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
                    <h5 class="modal-title" id="staticModalLabel">Delete User</h5>
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
	
	<script type="text/javascript">
    $(document).ready(function() {
        $('#item-data-table').DataTable({
        	"columnDefs": [
        	    { "width": "10%", "targets": 0 },
        	    { "width": "60%", "targets": 1 },
        	    { "width": "20%", "targets": 2 },
        	    { "width": "10%", "targets": 3 }
        	  ]
  	  	});
        
        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");        	
        	$.ajax({
        			url:"user.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_user', id:id},
        			dataType:"json",
        			success:function(data){  
            			var access_module = data.cr_access_module;
            			var res = access_module.split(",");
            			res.forEach(function(value){
                			console.log(value);
            				$(":checkbox[value="+value+"]").prop("checked","true");
            			});
            			console.log(res);	         			
        				$('#id').val(id);					
                        $('#name').val(data.cr_name); 
//                         $('#password').val(data.cr_password);      
                        $('#username').val(data.cr_username);        
                        $('#email').val(data.cr_email);   
                        
                        $('#editItem').modal('show');
        			}
        		});
        });

        //reset the modal to it original form -- checkbox issue
        $('#editItem').on('hidden.bs.modal', function () {
            $('#editItem form')[0].reset();
        });
        
        $(document).on('click', '.delete_data', function(){
        	var id = $(this).attr("id");
        	$('#delete_record').data('id', id); //set the data attribute on the modal button
        
        });
      	
    	$( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"user.ajax.php",
    			method:"POST",    
    			data:{action:'delete_user', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#name').val() == ""){  
               alert("Item name is required");  
          }     
          else if($('#username').val == ""){
        	  alert("Username is required");  
          }
          else if($('#email').val == ""){
        	  alert("Email is required");  
          }
          else{  
               $.ajax({  
                    url:"user.ajax.php",  
                    method:"POST",  
                    data:{action:'update_user', data: $('#update_form').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data);
                         location.reload();  
                    }  
               });  
          }  
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
