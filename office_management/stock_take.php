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
                                <strong class="card-title">Stock Out</strong>
                            </div>     
                           <div class="card-body">                            
                            <button type="button" class="btn btn-sm btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem">
                               Add New 
							</button>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
											<th>Department</th>
											<th>Staff Name</th>
											<th>Item</th>
											<th>Quantity</th>
											<th>Date</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM om_stock_take"; 
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $department = itemName("SELECT department_name FROM stationary_department WHERE department_id='".$row['department_id']."'");
                                                    $item = itemName("SELECT item_name FROM om_stock_item WHERE id='".$row['item_id']."'")
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$department?></td>
                                                        <td><?=$row['staff_name']?></td>
                                                        <td><?=$item?></td>
                                                        <td><?=$row['quantity']?></td>
                                                        <td><?=dateFormatRev($row['date_taken'])?></td>                                                        
                                                        <td class="text-center">
                                                        	<span id="<?=$row['id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	<span id="<?=$row['id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
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
        
        <!-- Modal Add new department -->
        <div id="addItem" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New</h4>
                    </div>
                    <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form"> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                    		<label for="staff_name" class=" form-control-label"><small class="form-text text-muted">Staff Name</small></label>
                            <input type="text" id="staff_name" name="staff_name" class="form-control">
                    	</div>
                    	<div class="col-sm-12">
                            <label for="department" class=" form-control-label"><small class="form-text text-muted">Department</small></label>
                            <div>
                                <?php
                                $department = mysqli_query ( $conn_admin_db, "SELECT department_id, department_code FROM stationary_department");
                                db_select ($department, 'department', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>
                    </div>                   
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="item" class=" form-control-label"><small class="form-text text-muted">Item</small></label>
                            <div>
                                <?php
                                $item = mysqli_query ( $conn_admin_db, "SELECT si.id AS id, item_name FROM om_stock ss
                                                              INNER JOIN om_stock_item si ON si.id = ss.item_id GROUP BY si.id");
                                db_select ($item, 'item', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="quantity" class=" form-control-label"><small class="form-text text-muted">Quantity</small></label>
                            <input type="text" id="quantity" name="quantity" class="form-control">
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12"> 
                        <div class="col-sm-6">
                            <label for="date_taken" class="form-control-label"><small class="form-text text-muted">Date taken</small></label>
                            <div class="input-group">
                                <input id="date_taken" name="date_taken" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
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
        <!-- Modal edit department  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Stock Take</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group row col-sm-12">
                        <div class="col-sm-12">
                    		<label for="staff" class=" form-control-label"><small class="form-text text-muted">Staff Name</small></label>
                            <input type="text" id="staff" name="staff" class="form-control">
                    	</div>
                    	<div class="col-sm-12">
                            <label for="department" class=" form-control-label"><small class="form-text text-muted">Department</small></label>
                            <div>
                                <?php
                                $department_code = mysqli_query ( $conn_admin_db, "SELECT department_id, department_code FROM stationary_department");
                                db_select ($department_code, 'department_code', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>
                        </div>                   
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="item" class=" form-control-label"><small class="form-text text-muted">Item</small></label>
                                <div>
                                    <?php
                                    $item_name = mysqli_query ( $conn_admin_db, "SELECT id, item_name FROM om_stock_item");
                                    db_select ($item_name, 'item_name', '','','-select-','form-control','');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="qty" class=" form-control-label"><small class="form-text text-muted">Quantity</small></label>
                                <input type="text" id="qty" name="qty" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12"> 
                            <div class="col-sm-6">
                                <label for="date" class="form-control-label"><small class="form-text text-muted">Date taken</small></label>
                                <div class="input-group">
                                    <input id="date" name="date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
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
    	var select2 = $("#item").select2({
//     		placeholder: "select option",
    	    selectOnClose: true
        });
    	select2.data('select2').$selection.css('height', '38px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da');
        
        $('#item-data-table').DataTable({
        	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "80%", "targets": 1 },
//         	    { "width": "10%", "targets": 2 }
        	  ]
  	  	});

  	  	$(document).on('change', '#quantity', function(){  	  	  	
  	  	  	//get the stock balance 
  	  	  	
  	  	});
        
        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");       	
        	$.ajax({
        			url:"stock.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_stock_take', id:id},
        			dataType:"json",
        			success:function(data){            			 
            			var date = dateFormat(data.date_taken);        			
        				$('#id').val(id);					
                        $('#department_code').val(data.department_id);    
                        $('#item_name').val(data.item_id);     
                        $('#qty').val(data.quantity);    
                        $('#date').val(date);                        
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
    			url:"function.ajax.php",
    			method:"POST",    
    			data:{action:'delete_department', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#department').val() == ""){  
               alert("Department name is required");  
          }     
          else{  
               $.ajax({  
                    url:"function.ajax.php",  
                    method:"POST",  
                    data:{action:'update_department', data: $('#update_form').serialize()},  
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
            if($('#item').val() == ""){  
                 alert("Item is required");  
            }
            else if($('#department').val() == ""){  
                alert("Department is required");  
           	}  
            else if($('#quantity').val() == ""){  
                 alert("Quantity in is required");  
            } 
            else if($('#date_taken').val() == ""){  
                alert("Date is required");  
            }    
            else{  
                 $.ajax({  
                      url:"stock.ajax.php",  
                      method:"POST",  
                      data:{action:'add_stock_take', data: $('#add_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);
                           location.reload();  
                      }  
                 });  
            }  
          });
        
        $('#date_taken').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });
        
        
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
