<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;
	
	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
	$select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";

	$query = "SELECT * FROM om_pcash_voucher WHERE cv_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'";
	
	if(!empty($select_c)){
	    $query .= " AND company_id='$select_c'";
	}
	
	$result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
	$cv_data = array();	
	while($row = mysqli_fetch_array($result)){             
	    $cv_date = $row['cv_date'];
	    $cv_no = $row['cv_no'];
	    $recipient = $row['recipient'];
	    $company_name = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
	    $user = $_SESSION['cr_name'];
	    $cv_id = $row['id'];
	    $status = $row['workflow_status'];
	    
	    //get the data for cash voucher item
	    $cv_query = "SELECT * FROM om_pcash_voucher_item WHERE cv_id = '".$row['id']."'";
	    $rst = mysqli_query($conn_admin_db, $cv_query)or die(mysqli_error($conn_admin_db));
	    $cv_item = [];
	    $total = 0;
	    while($rows = mysqli_fetch_array($rst)){ 	       
	        $total += $rows['amount'];
	         $cv_item[] = array(
                'item_date' => $rows['item_date'],
	             'particular' => $rows['particular']
	         );
	    }
	    $cv_data[] = array(
	        'cv_id' => $cv_id,
            'cv_date' => $cv_date,
            'cv_no' => $cv_no,
            'recipient' => $recipient,
            'company_name' => $company_name,
            'user' => $user,
            'total' => $total,
	        'status' => $status,
	        'cv_item' => $cv_item
	    );	    
	}

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
                                <strong class="card-title">Cash Voucher List</strong>
                            </div> 
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">                    	            	
                        	            <div class="col-sm-3"> 
                        	            <label for="select_company" class="form-control-label"><small class="form-text text-muted">Company</small></label>                                       
                                            <?php
                                                $select_company = mysqli_query ( $conn_admin_db, "SELECT DISTINCT(company.id), code FROM company INNER JOIN om_pcash_voucher ON om_pcash_voucher.company_id = company.id WHERE status='1'");
                                                db_select ($select_company, 'select_company', $select_c,'submit()','All Company','form-control','');
                                            ?>                              
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_start" name="date_start" class="form-control" value="<?=$date_start?>" autocomplete="off">
                                              <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_end" name="date_end" class="form-control" value="<?=$date_end?>" autocomplete="off">
                                              <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>                             
                                        </div>
                                        
                                     </div> 
                                     <div class="form-group row col-sm-12 btn-group">
                                     	<div class="col-sm-1">                                    	
                                        	<button type="submit" class="btn btn-primary button_search ">Submit</button>
                                        </div>
                                        <div class="col-sm-2">                                    	
                                        	<input type="button" class="btn btn-primary button_staff_claim" value="Generate Staff Claim"/>                                        	
                                        </div>
<!--                                      	<div class="col-sm-2">                                    	 -->
<!--                                         	<input type="button" class="btn btn-primary button_payment_rq" value="Generate Payment Requisition"/>                                        	 -->
<!--                                         </div> -->
                                     </div>   
                                </form>
                            </div>
                            <hr>    
                           <div class="card-body">
                           <br>                            
                                <table id="item-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date</th>
											<th>Recipient</th>
											<th>Company</th>
											<th>Cash Voucher No.</th>
											<th>Particular</th>
											<th>Amount (RM)</th>
											<th>Status</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $count = 0;
                                    foreach ($cv_data as $data){
                                        $count++;
                                        $status = $data['status'];
                                        $color="";
                                        if( $status == 0 ) {
                                            $status = "Pending";
                                            $color = "orange";
                                        }
                                        else if( $status == 1 ) {
                                            $status = "Confirm";
                                            $color = "green";
                                        }
                                        else if( $status == 2 ) {
                                            $status = "Rejected";
                                            $color = "red";
                                        }
                                        $cv_item_data = $data['cv_item'];
                                        $desc = [];
                                        foreach ($cv_item_data as $item_data){
                                            $desc[] = $item_data['particular'];
                                        }
                                        $particular = implode(", ", $desc);
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=dateFormatRev($data['cv_date'])?></td>
                                                        <td><?=$data['recipient']?></td>
                                                        <td><?=$data['company_name']?></td>
                                                        <td><?=strtoupper($data['cv_no'])?></td>
                                                        <td><?=ucfirst($particular)?></td>
                                                        <td><?=$data['total']?></td>                                                        
                                                        <td><a href="pcash_voucher_preview.php?cv_id=<?=$data['cv_id']?>&status=<?=$data['status']?>" target="_blank" style="color: <?=$color?>"><b><?=$status?></b></a></td>
                                                        <td>
                                                        	<span id="<?=$data['cv_id']?>" data-toggle="modal" class="confirm_data" data-target="#confirmItem"><i class="fas fa-paper-plane"></i></span>
                                                        	&nbsp;&nbsp;<span id="<?=$data['cv_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	&nbsp;&nbsp;<span id="<?=$data['cv_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    	<tr>
                                            <td colspan="5" class="text-right font-weight-bold">Total</td>
                                            <td class="text-right font-weight-bold">&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>                                                                                        
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>           
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
        var select_company = '<?=$select_c?>';
        $('#item-data-table').DataTable({
        	"paging": false,
        	"searching": false,
        	"columnDefs": [
        		{
          	      "targets": [5], // your case first column
          	      "className": "text-right", 
          	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
          	 	}
        	  ],
            "footerCallback": function( tfoot, data, start, end, display ) {
            	var api = this.api(), data;
            	var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;            
        		api.columns([5], { page: 'current'}).every(function() {
        				var sum = this
        			    .data()
        			    .reduce(function(a, b) {
        			    var x = parseFloat(a) || 0;
        			    var y = parseFloat(b) || 0;
        			    	return x + y;
        			    }, 0);			
        			       
        			    $(this.footer()).html(numFormat(sum));
        		});            
            },
  	  	});
        
//         $(document).on('click', '.edit_data', function(){
//         	var id = $(this).attr("id");          		
//         	$.ajax({
//         			url:"request.ajax.php",
//         			method:"POST",
//         			data:{action:'retrieve_request', id:id},
//         			dataType:"json",
//         			success:function(data){ 
//             			console.log(data);    
//         				$('#id').val(id);					
//                         $('#company_id').val(data.company_id);        
//                         $('#date').val(data.request_date);      
//                         $('#item_title').val(data.title);					
//                         $('#desc').val(data.details);        
//                         $('#qty').val(data.quantity);     
//                         $('#unit_cost').val(data.cost_per_unit);        
//                         $('#total').val(data.total_cost);                     
//                         $('#editItem').modal('show');       			        			
        				
//         			}
//         		});
//         });
    
        $(document).on('click', '.delete_data', function(){
        	var id = $(this).attr("id");
        	$('#delete_record').data('id', id); //set the data attribute on the modal button
        
        });

        $(document).on('click', '.confirm_data', function(){
        	var id = $(this).attr("id");
        	$('#confirm_record').data('id', id); //set the data attribute on the modal button
        
        });

//         $( "#confirm_record" ).click( function() {
//     		var ID = $(this).data('id');
//     		$.ajax({
//     			url:"request.ajax.php",
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
    			url:"request.ajax.php",
    			method:"POST",    
    			data:{action:'delete_request', id:ID},
    			success:function(data){	         							
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    	$('.button_staff_claim').click(function(){
        	if(select_company != ''){
        		window.open('staff_claim_form.php?company_id=<?=$select_c?>&date_start=<?=$date_start?>&date_end=<?=$date_end?>');
            }else{
				alert("Please select company name to generate staff claim");
            }		
        });
//     	$('.button_payment_rq').click(function(){
//         	if(select_company != ''){
        		window.open('requisition_form.php?company_id=<?=$select_c?>&date_start=<?=$date_start?>&date_end=<?=$date_end?>');
//             }else{
// 				alert("Please select company name to generate staff claim");
//             }		
//         });
//         $('#update_form').on("submit", function(event){  
//           event.preventDefault();  
//           if($('#company_id').val() == ""){  
//               alert("Company is required");  
//           }  
//           else if($('#date').val() == ""){  
//               alert("Request date is required");  
//           } 
//           else if($('#item_title').val() == ""){  
//               alert("Title is required");  
//           } 
//           else if($('#desc').val() == ""){  
//               alert("Description is required");  
//           } 
//           else if($('#qty').val() == ""){  
//               alert("Quantity is required");  
//           }   
//           else if($('#unit_cost').val() == ""){  
//               alert("Cost per unit is required");  
//           }   
//           else{  
//                $.ajax({  
//                     url:"request.ajax.php",  
//                     method:"POST",  
//                     data:{action:'update_request', data: $('#update_form').serialize()},  
//                     success:function(data){   
//                          $('#editItem').modal('hide');  
//                          $('#bootstrap-data-table').html(data);
//                          location.reload();  
//                     }  
//                });  
//           }  
//         }); 
        
//         $('#add_form').on("submit", function(event){  
//             event.preventDefault();  
//             if($('#company').val() == ""){  
//                 alert("Company is required");  
//             }  
//             else if($('#request_date').val() == ""){  
//                 alert("Request date is required");  
//             } 
//             else if($('#title').val() == ""){  
//                 alert("Title is required");  
//             } 
//             else if($('#description').val() == ""){  
//                 alert("Description is required");  
//             } 
//             else if($('#quantity').val() == ""){  
//                 alert("Quantity is required");  
//             }   
//             else if($('#cost_per_unit').val() == ""){  
//                 alert("Cost per unit is required");  
//             }     
//             else{  
//                  $.ajax({  
//                       url:"request.ajax.php",  
//                       method:"POST",  
//                       data:{action:'add_new_request', data: $('#add_form').serialize()},  
//                       success:function(data){   
//                            $('#editItem').modal('hide');  
//                            $('#bootstrap-data-table').html(data);
//                            location.reload();  
//                       }  
//                  });  
//             }  
//           });

        $('#date_start, #date_end').datepicker({
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
