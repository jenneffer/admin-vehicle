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
    .button_add{
        position: absolute;
        left:    0;
        bottom:   0;
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
                                <strong class="card-title">TELEKOM</strong>
                            </div>     
                           <div class="card-body">                         
                            	<div class="form-group row col-sm-12">
    								<div class="col-sm-2">
    									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addItem">
                                           Add New Accounts
            							</button>
    								</div>
    								<div>
    									<span class="color-red"> ** To add new record of usage, please click the hyperlink in Reference No. column</span>
    								</div>								
    							</div>
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Reference No.</th>
											<th>Company</th>											
											<th>Owner</th>
											<th>Location</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM bill_telekom_account WHERE status ='1'"; 
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;        
                                                    $comp_name = itemName("SELECT UPPER(name) FROM company WHERE id='".$row['company_id']."'")
                                                    ?>
                                                    <tr>
                                                    	<td><a href="telekom_account_details.php?id=<?=$row['id']?>" target="_blank" style="color:blue;"><?=$row['account_no']?></a></td>                                                        
                                                        <td><?=$comp_name?></td>
                                                        <td><?=$row['owner']?></td>
                                                        <td><?=$row['location']?></td>                                                        
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
        <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="add_form">                    
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="company" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                            <div>
                                <?php
                                    $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE status='1' ORDER BY name");
                                    db_select ($company, 'company', '','','-select-','form-control','','required');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="acc_no" class=" form-control-label"><small class="form-text text-muted">Account No.</small></label>
                            <input type="text" id="acc_no" name="acc_no" placeholder="Enter Account number" class="form-control" required>
                        </div>
                    </div>                    
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-12">
                            <label for="location" class=" form-control-label"><small class="form-text text-muted">Location</small></label>
                            <textarea id="location" name="location" class="form-control"></textarea>
                        </div>
                    </div> 
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="service_no" class=" form-control-label"><small class="form-text text-muted">Service No.</small></label>
                            <input type="text" id="service_no" name="service_no" class="form-control">
                        </div>
                    	<div class="col-sm-6">
                            <label for="owner" class=" form-control-label"><small class="form-text text-muted">Owner</small></label>
                            <input type="text" id="owner" name="owner" class="form-control">
                        </div>
                        
                    </div>   
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="ref_no" class=" form-control-label"><small class="form-text text-muted">Reference No.</small></label>
                            <input type="text" id="ref_no" name="ref_no" class="form-control">
                        </div>
                    	<div class="col-sm-6">
                            <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                            <textarea id="remark" name="remark" class="form-control"></textarea>
                        </div>
                    </div>      
<!--                     <div class="row form-group col-sm-12"> -->
<!--                     	<div class="col-sm-3"> -->
<!--                         	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_phone">Add telephone bill</button> -->
<!--                         </div> -->
<!--                         <div class="col-sm-9 text-right"> -->
<!--                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
<!--                             <button type="submit" class="btn btn-primary save_data ">Save</button> -->
<!--                         </div> -->
<!--                     </div> -->
<!--                     <br/> -->
<!--                     <table id="telefon_list" class="table table-bordered data-table"> -->
<!--                     <thead> -->
<!--                       <th>Telephone No.</th> -->
<!--                       <th>Type</th>                       -->
<!--                     </thead> -->
<!--                     <tbody> -->
                    
<!--                     </tbody> -->
<!--                     </table>         -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary save_data ">Save</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Modal Add new sesb account -->
        
        <!-- Modal edit telekom account  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Account</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">                        
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="company_edit" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                            <div>
                                <?php
                                    $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company");
                                    db_select ($company, 'company_edit', '','','-select-','form-control','','required');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="acc_no_edit" class=" form-control-label"><small class="form-text text-muted">Account No.</small></label>
                            <input type="text" id="acc_no_edit" name="acc_no_edit" class="form-control" required>
                        </div>
                        </div>                    
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12">
                                <label for="location_edit" class=" form-control-label"><small class="form-text text-muted">Location</small></label>
                                <textarea id="location_edit" name="location_edit" class="form-control"></textarea>
                            </div>
                        </div> 
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-6">
                                <label for="service_no_edit" class=" form-control-label"><small class="form-text text-muted">Service No.</small></label>
                                <input type="text" id="service_no_edit" name="service_no_edit" class="form-control">
                            </div>
                        	<div class="col-sm-6">
                                <label for="owner_edit" class=" form-control-label"><small class="form-text text-muted">Owner</small></label>
                                <input type="text" id="owner_edit" name="owner_edit" class="form-control">
                            </div>
                            
                        </div>   
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-6">
                                <label for="ref_no_edit" class=" form-control-label"><small class="form-text text-muted">Reference No.</small></label>
                                <input type="text" id="ref_no_edit" name="ref_no_edit" class="form-control">
                            </div>
                        	<div class="col-sm-6">
                                <label for="remark_edit" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                                <textarea id="remark_edit" name="remark_edit" class="form-control"></textarea>
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
    <!-- Modal add telefon list  -->
        <div id="add_phone" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Telephone List</h4>
                </div>
                <div class="modal-body">
                    <form id="telefon_bill">        
                        <div class="row form-group col-sm-12">
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Telephone No.</small></label>
                                <input type="text" name="telefon" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Type</small></label>
                                <input type="text" name="type" class="form-control">
                            </div>  
                            <div class="col-sm-1">
                            	<button type="submit" class="btn btn-success button_add">Add</button>                            	
                            </div> 
                            <div class="col-sm-1">
                            	<button type="button" data-dismiss="modal" class="btn btn-secondary button_add">Cancel</button>
                            </div>                         
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
    	//declare empty array to temporary save the data in table
        var TELEPHONE_LIST = [];
    	// Initialize select2
    	var select2 = $("#company").select2({
//     		placeholder: "select option",
    	    selectOnClose: true
        });
    	select2.data('select2').$selection.css('height', '38px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da');
        
        $('#item-data-table').DataTable({
//         	'columnDefs': [
//           	  {
//           	      "targets": [5], // your case first column
//           	      "className": "text-right", 
//           	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
//           	 }
// 			],
  	  	});
        
        $(document).on('click', '.edit_data', function(){
        	var id = $(this).attr("id");        	
        	$.ajax({
        			url:"telekom_bill.ajax.php",
        			method:"POST",
        			data:{action:'retrieve_account', id:id},
        			dataType:"json",
        			success:function(data){
            			console.log(data);            			        			
        				$('#id').val(id);					
                        $('#company_edit').val(data.company_id);      
                        $('#acc_no_edit').val(data.account_no);  
                        $('#location_edit').val(data.location);          
                        $('#owner_edit').val(data.owner);    
                        $('#ref_no_edit').val(data.ref_no); 
                        $('#service_no_edit').val(data.service_no);   
                        $('#remark_edit').val(data.remark);                        
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
    			url:"telekom_bill.ajax.php",
    			method:"POST",    
    			data:{action:'delete_account', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          $.ajax({  
              url:"telekom_bill.ajax.php",  
              method:"POST",  
              data:{action:'update_account', data: $('#update_form').serialize()},  
              success:function(data){   
                   $('#editItem').modal('hide');                     
                   location.reload();  
              }  
         	});  
        }); 
        
        $('#add_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#company').val() == ""){  
                 alert("Company is required");  
            } 
            else if($('#acc_no').val() == ""){  
                 alert("Account number is required");  
            }    
            else if($('#location').val() == ""){  
                alert("Location is required");  
           	}             
//             else if($('#tariff').val() == ""){  
//                 alert("Tariff is required");  
//            	}                           
            else{  
                 $.ajax({  
                      url:"telekom_bill.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_account', data: $('#add_form').serialize()},  
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);
                           location.reload();  
                      }  
                 });  
            }  
          });

        $('#telefon_bill').on("submit", function(e){ 
            e.preventDefault();
            var telefon = $("input[name='telefon']").val();
            var type = $("input[name='type']").val();
         	
            $(".data-table tbody").append("<tr data-telefon='"+telefon+"' data-type='"+type+"'><td>"+telefon+"</td><td>"+type+"</td></td></tr>");

            //push data into array
            TELEPHONE_LIST.push({
				telefon: telefon,
				type: type,
            });
            console.log(TELEPHONE_LIST);
            $("input[name='telefon']").val('');
            $("input[name='type']").val('');
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
