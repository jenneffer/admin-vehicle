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
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">List of Item</strong>
                            </div>     
                           <div class="card-body">                           
                            <button type="button" class="btn btn-sm btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem">
                               Add New Item
							</button>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
											<th>Item</th>
											<th>Unit</th>
											<th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM om_stock_item WHERE status='1'"; //only show active vehicle 
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $unit = !empty($row['unit']) ? $arr_item_unit[$row['unit']] : "";
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$row['item_name']?></td>
                                                        <td><?=$unit?></td>
                                                        <td>
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
        
        <!-- Modal Add new item -->
        <div id="addItem" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New</h4>
                    </div>
                    <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">
                    <input type="hidden" id="item_id" name="item_id" value="">
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="item_name" class=" form-control-label"><small class="form-text text-muted">Item </small></label>
                            <div>
                            	<input type="text" id="item_name" name="item_name" placeholder="Enter item name" class="form-control">
                        	</div>
                        </div>
                    </div>
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                    	<label for="unit" class=" form-control-label"><small class="form-text text-muted">Unit </small></label>
                    	<select name="item_unit" id="item_unit" class="form-control">
                    		<option value="0">-select-</option>
                            <option value="pieces">Pieces</option>
                            <option value="packet">Packet</option>
                            <option value="box">Box</option>
                        </select>
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
                    <h4 class="modal-title">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="name" class=" form-control-label"><small class="form-text text-muted">Item </small></label>
                                <div>
                                	<input type="text" id="name" name="name" class="form-control">
                            	</div>
                            </div>
                    	</div>
                    	<div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                        	<label for="unit" class=" form-control-label"><small class="form-text text-muted">Unit </small></label>
                        	<select name="unit" id="unit" class="form-control">
                        		<option value="0">-select-</option>
                                <option value="pieces">Pieces</option>
                                <option value="packet">Packet</option>
                                <option value="box">Box</option>
                            </select>
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
        			url:"item.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_item', id:id},
        			dataType:"json",
        			success:function(data){            			
        				$('#id').val(id);					
                        $('#name').val(data.item_name);        
                        $('#unit').val(data.unit);                        
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
    			url:"item.ajax.php",
    			method:"POST",    
    			data:{action:'delete_item', id:ID},
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
          else if($('#unit').val == ""){
        	  alert("Unit is required");  
          }
          else{  
               $.ajax({  
                    url:"item.ajax.php",  
                    method:"POST",  
                    data:{action:'update_item', data: $('#update_form').serialize()},  
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
            if($('#item_name').val() == ""){  
                 alert("Item name is required");  
            } 
            else if($('#item_unit').val == ""){
          	  alert("Unit is required");  
            }    
            else{  
                 $.ajax({  
                      url:"item.ajax.php",  
                      method:"POST",  
                      data:{action:'add_item', data: $('#add_form').serialize()},  
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
