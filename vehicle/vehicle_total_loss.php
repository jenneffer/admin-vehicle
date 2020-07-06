<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;
// 	session_start();
// 	if(isset($_SESSION['cr_id'])) {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$query = parse_url($url, PHP_URL_QUERY);
// 		parse_str($query, $params);
		
// 		// get id
// 		$userId = $_SESSION['cr_id'];
// 		$name = $_SESSION['cr_name'];
		
// 	} else {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$PrevURL= $url;
// 		header("Location: ../login.php?RecLock=".$PrevURL);
// 	}
	
	$select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";
	
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
                                <strong class="card-title">Vehicle Total Loss</strong>
                            </div>
                            <!-- Filter -->
                            <div class="card-body">
                            <form id="myform" enctype="multipart/form-data" method="post" action="">  
                            	<div class="form-group row col-sm-12">
                            	    <div class="col-sm-3">                                        
                                        <?php
                                            $select_company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE vehicle_used='1' ORDER BY name ASC");
                                            db_select ($select_company, 'select_company', $select_c,'submit()','All Company','form-control form-control-sm','');
                                        ?>                              
                                    </div>
                                    <div class="col-sm-1">                                    	
                                    	<button type="submit" class="btn btn-sm btn-primary button_search ">View</button>
                                    </div>
                            	</div>     
							</form>
							</div>
                            <div class="card-body" >
                                <table id="vehicle_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
											<th>Insurance</th>
                                            <th>Offer Letter Date</th>
                                            <th>Vehicle No.</th>
                                            <th>Company</th>
											<th>Amount(RM)</th>
											<th>Payment Advice Date</th>
											<th>Beneficiary Bank</th>
											<th>Transaction Reference No.</th>
											<th>Driver</th>																								
											<th>Remarks</th>
											<th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM vehicle_vehicle vv 
                                                    INNER JOIN vehicle_total_loss vtl ON vtl.vt_vv_id = vv.vv_id AND vtl.status = 1
                                                    INNER JOIN company ON company.id = vv.company_id"; //only show active vehicle 
                                        
                                        if(!empty($select_c)){
                                            $sql_query .= " WHERE company.id = '$select_c'";
                                        }
                                        
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_assoc($sql_result)){ 
                                                    $count++;
                                                    $company = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$row['vt_insurance']?></td>                                                        
                                                        <td><?=dateFormatRev($row['vt_offer_letter_date'])?></td>
                                                        <td><?=$row['vv_vehicleNo']?></td>
                                                        <td><?=$company?></td>
                                                        <td><?=number_format($row['vt_amount'],2)?></td>
                                                        <td><?=dateFormatRev($row['vt_payment_advice_date'])?></td>
                                                        <td><?=$row['vt_beneficiary_bank']?></td>
                                                        <td><?=$row['vt_trans_ref_no']?></td>
                                                        <td><?=$row['vt_driver']?></td>
                                                        <td><?=$row['vt_remark']?></td>
                                                        <td>
                                                        	<span id="<?=$row['vt_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	<span id="<?=$row['vt_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
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

        <!-- Modal edit vehicle total loss  -->
        <div id="editItem" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Vehicle Total Loss</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vt_id" name="vt_id" value="">
						<div class="form-group row col-sm-12">
                            <div class="col-sm-4">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <label for="insurance" class=" form-control-label"><small class="form-text text-muted">Insurance</small></label>
                                <input type="text" id="insurance" name="insurance" placeholder="Enter insurance name" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM)</small></label>
                        		<input type="text" id="amount" name="amount" onkeypress="return isNumberKey(event)" placeholder="e.g 50.00" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">                                        
                            <div class="col-sm-4">
                                <label for="offer_letter_date" class=" form-control-label"><small class="form-text text-muted">Offer Letter Date</small></label>
                                <div class="input-group">
                                    <input id="offer_letter_date" name="offer_letter_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="payment_advice_date" class=" form-control-label"><small class="form-text text-muted">Payment Advice Date</small></label>
                                <div class="input-group">
                                    <input id="payment_advice_date" name="payment_advice_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>
                            
                        </div>                                    
                        <div class="form-group row col-sm-12">                                        
                            <div class="col-sm-4">
                                <label for="beneficiary_bank" class=" form-control-label"><small class="form-text text-muted">Beneficiary Bank</small></label>
                                <input type="text" id="beneficiary_bank" name="beneficiary_bank" placeholder="Enter beneficiary bank" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="transaction_ref_no" class=" form-control-label"><small class="form-text text-muted">Transaction Reference No.</small></label>
                                <input type="text" id="transaction_ref_no" name="transaction_ref_no" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="driver" class=" form-control-label"><small class="form-text text-muted">Driver</small></label>
                                <input type="text" id="driver" name="driver" class="form-control">
                            </div>
                        </div>                                   
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-8">
                                <label for="v_remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>                                             
                                <textarea id="v_remark" name="v_remark" rows="3" class="form-control"></textarea>
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
                    <h5 class="modal-title" id="staticModalLabel">Delete Vehicle</h5>
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
        $('#vehicle_table').DataTable({
        	"paging": false,
        	"pageLength": 1,
        	"dom": 'Bfrtip',
            "buttons": [ 
           	 { 
   				extend: 'excelHtml5', 
   				messageTop: 'Vehicle Total Loss',
   				footer: true 
   			 },
                {
   				extend: 'print',
   				messageTop: 'Vehicle Total Loss',
   				footer: true,
   				customize: function ( win ) {
                       $(win.document.body)
                           .css( 'font-size', '10pt' );

                       $(win.document.body).find( 'table' )
                           .addClass( 'compact' )
                           .css( 'font-size', 'inherit' );
                   }
                }
             ],         	 
         });
        
        $(document).on('click', '.edit_data', function(){
        	var vt_id = $(this).attr("id");
        	$.ajax({
        			url:"vehicle.all.ajax.php",
        			method:"POST",
        			data:{action:'retrive_vehicle_total_lost', id:vt_id},
        			dataType:"json",
        			success:function(data){	
            			console.log(data);
            			//vehicle total loss
            			
            			var pa_date = dateFormat(data.vt_payment_advice_date); 
            			var ol_date = dateFormat(data.vt_offer_letter_date);
            			
        				$('#vt_id').val(vt_id);					
                        $('#vehicle_reg_no').val(data.vv_id);  
                        $('#insurance').val(data.vt_insurance);  
                        $('#amount').val(data.vt_amount);  
                        $('#offer_letter_date').val(ol_date);  
                        $('#payment_advice_date').val(pa_date);  
                        $('#beneficiary_bank').val(data.vt_beneficiary_bank);  
                        $('#transaction_ref_no').val(data.vt_trans_ref_no);    
                        $('#driver').val(data.vt_driver);  
                        $('#v_remark').val(data.vt_remark);                          
                        $('#editItem').modal('show');
        			}
        		});
        });
    
        $(document).on('click', '.delete_data', function(){
        	var vehicle_id = $(this).attr("id");
        	$('#delete_record').data('id', vehicle_id); //set the data attribute on the modal button
        
        });
      	
    	$( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"vehicle.all.ajax.php",
    			method:"POST",    
    			data:{action:'delete_vehicle_total_loss', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#vehicle_reg_no').val() == ""){  
               alert("Vehicle Reg. number is required");  
          }  
          else if($('#category').val() == ''){  
               alert("Category is required");  
          }  
          else if($('#company').val() == ''){  
               alert("Company is required");  
          }  
          else if($('#brand').val() == ''){  
               alert("Make is required");  
          }  
          else if($('#model').val() == ''){  
               alert("Vehicle model is required");  
          }  
          else if($('#yearMade').val() == ''){  
               alert("Purchased year is required");  
          }   
          else{  
               $.ajax({  
                    url:"vehicle.all.ajax.php",  
                    method:"POST",  
                    data:{action:'update_vehicle', data: $('#update_form').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data);
//                          location.reload();  
                    }  
               });  
          }  
        }); 

        $('#payment_advice_date,#offer_letter_date').datepicker({
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
    
    function printDiv(divName) {
	     var printContents = document.getElementById(divName).innerHTML;
	     var originalContents = document.body.innerHTML;
	     document.body.innerHTML = printContents;
	     window.print();
	     document.body.innerHTML = originalContents;
	}
	
 	function fnExcelReport(){
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j=0;
        tab = document.getElementById('vehicle_table'); // id of table
        
        for(j = 0 ; j < tab.rows.length ; j++) 
        {     
         tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
         //tab_text=tab_text+"</tr>";
        }
        
        tab_text=tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
        
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE "); 
        
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
         txtArea1.document.open("txt/html","replace");
         txtArea1.document.write(tab_text);
         txtArea1.document.close();
         txtArea1.focus(); 
         sa=txtArea1.document.execCommand("SaveAs",true,"Department Summary.xls");
        }  
        else                 //other browser not tested on IE 11
         sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
        
        return (sa);
 	}
  </script>
</body>
</html>
