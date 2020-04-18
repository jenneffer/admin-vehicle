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
                                <strong class="card-title">List of Permit</strong>
                            </div>     
                           <div class="card-body">
                           <br>                            
                            <button type="button" class="btn btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem">
                               Add New
							</button>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
											<th rowspan="2">Registration No.</th>
											<th rowspan="2">Status</th>
											<th rowspan="2">Category</th>
											<th colspan="4" class="text-center">LPKP Permit</th>
											<th rowspan="2">&nbsp;</th>
                                        </tr>
                                        <tr>
                                        	<th>Type</th>
                                        	<th>No.</th>
                                        	<th>License Ref. No.</th>
                                        	<th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT *, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) comp_name, 
                                                    (SELECT vc_type FROM vehicle_category WHERE vc_id=vehicle_vehicle.vv_category) category
                                                    FROM vehicle_permit 
                                                    INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_permit.vv_id
                                                    WHERE vehicle_permit.status='1'"; //only show active vehicle with permit
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $vpr_id = $row['vpr_id'];
                                                    $vehicle_no = $row['vv_vehicleNo'];
                                                    $status = $row['vv_status'];
                                                    $category = $row['category'];
                                                    $vpr_type = $row['vpr_type'];
                                                    $vpr_no = $row['vpr_no'];
                                                    $vpr_license_ref_no = $row['vpr_license_ref_No'];
                                                    $vpr_due_date = $row['vpr_due_date'];
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$vehicle_no?></td>
                                                        <td><?=$status?></td>
                                                        <td><?=$category?></td>
                                                        <td><?=$vpr_type?></td>
                                                        <td><?=$vpr_no?></td>
                                                        <td><?=$vpr_license_ref_no?></td>
                                                        <td><?=dateFormatRev($vpr_due_date)?></td>                                                        
                                                        <td>
                                                        	<span id="<?=$vpr_id?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	<span id="<?=$vpr_id?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
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
                    <div class="form-group row col-sm-12"> 
                 		<div class="col-sm-6">
                            <label class="control-label "><small class="form-text text-muted">Company</small></label>                                  
                            <?php                                            
                                $arr_company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                db_select ($arr_company, 'company','','','-select-','form-control','');
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label "><small class="form-text text-muted">Vehicle No.</small></label>                                  
                            <select id="vv_id" name="vv_id" class="form-control">
                               <option value="0">- select -</option>
                            </select>
                        </div>
                    </div>
					<div class="form-group row col-sm-12"> 
                 		<div class="col-sm-6">  
                             <label for="permit_type" class=" form-control-label"><small class="form-text text-muted">Type</small></label> 
                             <input type="text" id="permit_type" name="permit_type" placeholder="Enter permit type" class="form-control"> 
                         </div> 
						<div class="col-sm-6">                                         
                             <label for="permit_no" class=" form-control-label"><small class="form-text text-muted">No.</small></label> 
                    		<input type="text" id="permit_no" name="permit_no" onkeypress="return isNumberKey(event)" class="form-control">
                     	</div> 
                     </div>                         
                     <div class="form-group row col-sm-12"> 
                     	<div class="col-sm-6">  
                             <label for="license_ref_no" class=" form-control-label"><small class="form-text text-muted">License Ref No.</small></label> 
                             <input type="text" id="license_ref_no" name="license_ref_no" placeholder="Enter license ref no." class="form-control">
                     	</div> 
                     	<div class="col-sm-6"> 
                     		<label for="lpkp_permit_due_date" class=" form-control-label"><small class="form-text text-muted">Due Date</small></label> 
                             <div class="input-group"> 
                                 <input id="lpkp_permit_due_date" name="lpkp_permit_due_date" class="form-control" autocomplete="off"> 
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
        <!-- Modal edit item  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Permit</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="permit_id" name="permit_id" value="">
                        <div class="form-group row col-sm-12"> 
                 		<div class="col-sm-6">
                            <label class="control-label "><small class="form-text text-muted">Vehicle Reg No.</small></label>                                  
                            <?php                                            
                                $arr_vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, vv_vehicleNo FROM vehicle_vehicle");
                                db_select ($arr_vehicle, 'vehicle_reg_no','','','-select-','form-control','');
                            ?>
                        </div>
                        </div>
    					<div class="form-group row col-sm-12"> 
                     		<div class="col-sm-6">  
                                 <label for="type" class=" form-control-label"><small class="form-text text-muted">Type</small></label> 
                                 <input type="text" id="type" name="type" class="form-control"> 
                             </div> 
    						<div class="col-sm-6">                                         
                                 <label for="no" class=" form-control-label"><small class="form-text text-muted">No.</small></label> 
                        		<input type="text" id="no" name="no" onkeypress="return isNumberKey(event)" class="form-control">
                         	</div> 
                         </div>                         
                         <div class="form-group row col-sm-12"> 
                         	<div class="col-sm-6">  
                                 <label for="ref_no" class=" form-control-label"><small class="form-text text-muted">License Ref No.</small></label> 
                                 <input type="text" id="ref_no" name="ref_no" class="form-control">
                         	</div> 
                         	<div class="col-sm-6"> 
                         		<label for="due_date" class=" form-control-label"><small class="form-text text-muted">Due Date</small></label> 
                                 <div class="input-group"> 
                                     <input id="due_date" name="due_date" class="form-control" autocomplete="off"> 
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
        $('#item-data-table').DataTable({
//         	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "60%", "targets": 1 },
//         	    { "width": "20%", "targets": 2 },
//         	    { "width": "10%", "targets": 3 }
//         	  ]
  	  	});

        //onchange company
        $("#company").change(function(){
            var company = $(this).val();
            $.ajax({
                url: 'vehicle.all.ajax.php',
                type: 'post',
                data: {id:company, action:'get_vehicle_no'},
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    var len = response.length;
                    $("#vehicle_no").empty();
                    for( var i = 0; i<len; i++){
                        var vv_id = response[i]['company_id'];
                        var vv_code = response[i]['vv_vehicleNo'];
                        
                        $("#vehicle_no").append("<option value='"+vv_id+"'>"+vv_code+"</option>");

                    }
                }
            });
        });
        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");
        	$.ajax({
        			url:"vehicle.all.ajax.php",
        			method:"POST",
        			data:{action:'retrive_permit', id:id},
        			dataType:"json",
        			success:function(data){  
            			console.log(data);          			
        				$('#permit_id').val(id);					
                        $('#vehicle_reg_no').val(data.vv_id);        
                        $('#type').val(data.vpr_type);        
                        $('#no').val(data.vpr_no);        
                        $('#ref_no').val(data.vpr_license_ref_No);    
                        $('#due_date').val(data.vpr_due_date);                  
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
    			data:{action:'delete_permit', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#company').val() == ""){  
               alert("Company is required");  
          }     
          else if($('#vehicle_no').val == ""){
        	  alert("Vehicle No. is required");  
          }
          else if($('#permit_type').val == ""){
        	  alert("Permit Type is required");  
          }
          else if($('#permit_no').val == ""){
        	  alert("Permit No. is required");  
          }
          else if($('#license_ref_no').val == ""){
        	  alert("License ref No. is required");  
          }
          else if($('#lpkp_permit_due_date').val == ""){
        	  alert("LPKP due date is required");  
          }
          else{  
               $.ajax({  
                    url:"vehicle.all.ajax.php",  
                    method:"POST",  
                    data:{action:'add_new_permit', data: $('#update_form').serialize()},  
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
            else if($('#vehicle_no').val == ""){
              alert("Vehicle No. is required");  
            }
            else if($('#permit_type').val == ""){
              alert("Permit Type is required");  
            }
            else if($('#permit_no').val == ""){
              alert("Permit No. is required");  
            }
            else if($('#license_ref_no').val == ""){
              alert("License ref No. is required");  
            }
            else if($('#lpkp_permit_due_date').val == ""){
              alert("LPKP due date is required");  
            }    
            else{  
                 $.ajax({  
                	  url:"vehicle.all.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_permit', data: $('#add_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);
                           location.reload();  
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
