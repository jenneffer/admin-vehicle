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
                                <strong class="card-title">Requisition List</strong>
                            </div>     
                           <div class="card-body">
                           <br>                            
<!--                             <button type="button" class="btn btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#addItem"> -->
<!--                                Add New  -->
<!-- 							</button> -->
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Request Date</th>
											<th>Recipient</th>
											<th>Company</th>
											<th>Serial No.</th>
											<th>Particular</th>
											<th>Total (RM)</th>
											<th>Status</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $sql_query = "SELECT * FROM om_requisition
                                                        INNER JOIN om_requisition_item ON om_requisition.id = om_requisition_item.rq_id"; //only show active vehicle 
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){                                                       
                                                    $count++;
                                                    $status = $row['status'];
                                                    $comp_name = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
                                                    if( $status == 0 ) {
                                                        $status = "Pending";
                                                    }
                                                    else if( $status == 1 ) {
                                                        $status = "Confirm";
                                                    }
                                                    else if( $status == 2 ) {
                                                        $status = "Processed"; //sent to account
                                                    }
                                                    
                                                    $display = ( $row['status'] == 2 ) ? "none" : "block";
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=dateFormatRev($row['date'])?></td>
                                                        <td><?=$row['recipient']?></td>
                                                        <td><?=$comp_name?></td>
                                                        <td><?=$row['serial_no']?></td>
                                                        <td><?=$row['particular']?></td>
                                                        <td><?=$row['total']?></td>                                                        
                                                        <td><?=$status?></td>
                                                        <td>
                                                        <span onclick="window.open('requisition_preview.php?status=<?=$row['status']?>&rq_id=<?=$row['id']?>');"><button type="button" class="btn btn-info btn-sm">View</button></span><br></br>                                      	
                                            			<span id=<?=$row['id']?> style="display:<?=$display?>;" data-toggle="modal" class="update_status" data-target="#updateStatus"><button type="button" class="btn btn-success btn-sm">Update RF Status</button></span>                                                        	                                                      	
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
    <!-- confirm request -->
    <div class="modal fade" id="updateStatus">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">                 	               
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Payment request have been processed by Accounts?
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
    	$('[data-toggle="modal"]').tooltip();   
    	// Initialize select2
//     	var select2 = $("#item").select2({
//     		placeholder: "select option",
//     	    selectOnClose: true
//         });
//     	select2.data('select2').$selection.css('height', '38px');
//     	select2.data('select2').$selection.css('border', '1px solid #ced4da');
        
        $('#item-data-table').DataTable({
        	"columnDefs": [
        		{
          	      "targets": [6], // your case first column
          	      "className": "text-right", 
          	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
          	 	},
          	 	{
        	      "targets": [8], // your case first column
        	      "className": "text-center"        	                	                      	        	     
        	 	}           	 	
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

        $(document).on('click', '.update_status', function(){
        	var id = $(this).attr("id");
        	$('#confirm_record').data('id', id); //set the data attribute on the modal button
        
        });

        $( "#confirm_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"request.ajax.php",
    			method:"POST",    
    			data:{action:'update_rq_status', id:ID},
    			success:function(data){	
        			if(data){
        				$('#confirmItem').modal('hide');		
        				location.reload();	
        			}  							
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
