<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');
	require_once('../check_login.php');
	global $conn_admin_db;
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
	
	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : '';
	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
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
        .button_search{
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
                <div class="row" >
                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">Road Tax</strong>
                            </div>
                            <!-- Filter -->
<!--                             <div class="card-body"> -->
<!--                             <form id="myform" enctype="multipart/form-data" method="post" action="">                	                    -->
<!--                 	            <div class="form-group row col-sm-12"> -->
<!--                                     <div class="col-sm-3"> -->
<!--                                         <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                         <input type="text" id="date_start" name="date_start" class="form-control" value="<?=$date_start?>" autocomplete="off">
<!--                                           <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div> -->
<!--                                         </div>                             -->
<!--                                     </div> -->
<!--                                     <div class="col-sm-3"> -->
<!--                                         <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                          <input type="text" id="date_end" name="date_end" class="form-control" value="<?=$date_end?>" autocomplete="off">
<!--                                           <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></div> -->
<!--                                         </div>                              -->
<!--                                     </div> -->
<!--                                     <div class="col-sm-4">                                    	 -->
<!--                                     	<button type="submit" class="btn btn-primary button_search ">View</button> -->
<!--                                     </div> -->
<!--                                  </div>     -->
<!--                             </form> -->
<!--                             </div> -->
<!--                             <hr> -->
                            <div class="card-body">
                                <table id="roadtax_datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th rowspan="2">No.</th>
											<th rowspan="2">Vehicle No.</th>
                                            <th>Use Under</th>
											<th>LPKP Permit</th>
<!-- 											<th>Fitness Test</th> -->
											<th colspan="2" style="text-align: center">Insurance</th>
											<th colspan="4" style="text-align: center">Road Tax</th>
                                            <th rowspan="2">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <th>Company</th>
											<th>Due Date</th>
<!-- 											<th>Due Date</th> -->
											<th>Due</th>
											<th>Status</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Period</th>
                                            <th>Amount(RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                                              										            
                                    </tbody>
<!--                                     <tfoot> -->
<!--                                         <tr> -->
<!--                                             <td colspan="9" class="text-right font-weight-bold">Total</td> -->
<!--                                             <td class="text-right font-weight-bold">3304.00</td> -->
<!--                                         </tr> -->
<!--                                     </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        <!-- Modal edit Roadtax  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Road Tax</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vrt_id" name="vrt_id" value="">
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <label for="lpkp_date" class="form-control-label"><small class="form-text text-muted">LPKP Permit due date</small></label>
                                <div class="input-group">
                                  <input type="text" id="lpkp_date" name="lpkp_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                            
                            </div>
                        </div>    

                        <!-- <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="insurance_from_date" class="form-control-label"><small class="form-text text-muted">Insurance from date</small></label>    
                                <div class="input-group">
                                  <input type="text" id="insurance_from_date" name="insurance_from_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                                                                        
                            </div>
                            <div class="col-sm-6">
                                <label for="insurance_due_date" class="form-control-label"><small class="form-text text-muted">Insurance due date</small></label> 
                                <div class="input-group">
                                  <input type="text" id="insurance_due_date" name="insurance_due_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                                                                           
                            </div>
                        </div> -->
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="roadtax_from_date" class="form-control-label"><small class="form-text text-muted">Roadtax from date</small></label>  
                                <div class="input-group">
                                  <input type="text" id="roadtax_from_date" name="roadtax_from_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                               
                            </div>
                            <div class="col-sm-6">
                                <label for="roadtax_due_date" class="form-control-label"><small class="form-text text-muted">Roadtax due date</small></label>
                                <div class="input-group">
                                  <input type="text" id="roadtax_due_date" name="roadtax_due_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                               
                            </div>
                        </div>

                        <!-- <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="premium_amount" class=" form-control-label"><small class="form-text text-muted">Premium (RM)</small></label>
                                <input type="text" id="premium_amount" name="premium_amount" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="ncd" class=" form-control-label"><small class="form-text text-muted">NCD (%)</small></label>
                                <input type="text" id="ncd" name="ncd" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                        </div> -->

                        <!-- <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="sum_insured" class=" form-control-label"><small class="form-text text-muted">Sum Insured (RM)</small></label>
                                <input type="text" id="sum_insured" name="sum_insured" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="excess_paid" class=" form-control-label"><small class="form-text text-muted">Excess Paid (RM)</small></label>
                                <input type="text" id="excess_paid" name="excess_paid" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                        </div> -->
                        
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="roadtax_amount" class=" form-control-label"><small class="form-text text-muted">Roadtax Amount(RM)</small></label>
                                <input type="text" id="roadtax_amount" name="roadtax_amount" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                            <!-- <div class="col-sm-6 ">
                                <label for="insurance_status" class=" form-control-label"><small class="form-text text-muted">Insurance Status</small></label>
                                <select name="insurance_status" id="insurance_status" class="form-control col-sm-4">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div> -->
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
                    <h5 class="modal-title" id="staticModalLabel">Delete Road Tax</h5>
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
        	var table = $('#roadtax_datatable').DataTable({
             	"processing": true,
//              	"serverSide": true,
             	"searching": true,
             	"paging":true,
             	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
//              	"pageLength": 5,
                "ajax":{
               	 	"url": "roadtax.all.ajax.php",   
               	 	"type":"POST",       	        	
               	 	"data" : function ( data ) {
                   		data.date_start = '<?=$date_start?>';
        				data.date_end = '<?=$date_end?>';  
        				data.action = 'display_roadtax';				
           	        }
       	      },
      			'columnDefs': [
              	  {
              	      "targets": [9], // your case first column
              	      "className": "text-right", 
              	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
              	  },
              	  {
                  	  "targets":[1,2,5,10],
                  	  "className": "text-center",
                  }],
       	     });

          //retrieve data
          $(document).on('click', '.edit_data', function(){
  			var vrt_id = $(this).attr("id");
  			$.ajax({
  					url:"roadtax.all.ajax.php",
  					method:"POST",
  					data:{action:'retrive_roadtax', vrt_id:vrt_id},
  					dataType:"json",
  					success:function(data){	
  	  					console.log(data);
  	  					var lpkp_date = data.vrt_lpkpPermit_dueDate!= null ? dateFormat(data.vrt_lpkpPermit_dueDate) : "";
  	  					var insurance_from_date = data.vi_insurance_fromDate != null ? dateFormat(data.vi_insurance_fromDate) : "";
  	  					var insurance_due_date = data.vi_insurance_dueDate != null ? dateFormat(data.vi_insurance_dueDate) : "";
  	  					var roadtax_from_date = data.vrt_roadTax_fromDate != null ? dateFormat(data.vrt_roadTax_fromDate) : "";
  	  					var roadtax_due_date = data.vrt_roadTax_dueDate != null ? dateFormat(data.vrt_roadTax_dueDate) : "";
  	  					
                        $('#vrt_id').val(data.vrt_id);					
                        $('#vehicle_reg_no').val(data.vv_id);  
                        $('#lpkp_date').val(lpkp_date);  
                        $('#insurance_from_date').val(insurance_from_date);  
                        $('#insurance_due_date').val(insurance_due_date);  
                        $('#roadtax_from_date').val(roadtax_from_date);  
                        $('#roadtax_due_date').val(roadtax_due_date);  
                        $('#premium_amount').val(data.vi_premium_amount);    
                        $('#ncd').val(data.vi_ncd);  
                        $('#sum_insured').val(data.vi_sum_insured);  
                        $('#excess_paid').val(data.vi_excess);  
                        $('#roadtax_amount').val(data.vrt_amount);  
                        $('#insurance_status').val(data.vi_insuranceStatus); 
                        $('#editItem').modal('show');
	  				}
  				});
        });

        //delete records
        $(document).on('click', '.delete_data', function(){
        	var vrt_id = $(this).attr("id");
        	$('#delete_record').data('id', vrt_id); //set the data attribute on the modal button
        
        });
    	
        $( "#delete_record" ).click( function() {
        	var ID = $(this).data('id');
        	$.ajax({
        		url:"roadtax.all.ajax.php",
        		method:"POST",    
        		data:{action:'delete_roadtax', id:ID},
        		success:function(data){	  						
        			$('#deleteItem').modal('hide');		
        			location.reload();		
        		}
        	});
        });
        
		//update form
        $('#update_form').on("submit", function(event){  
            event.preventDefault();  
//             if($('#vehicle_reg_no').val() == ""){  
//                  alert("Vehicle number is required");  
//             }  
//             else if($('#lpkp_date').val() == ''){  
//                  alert("LPKP date is required");  
//             }  
//             else if($('#insurance_from_date').val() == ''){  
//                  alert("Insurance from date is required");  
//             }  
//             else if($('#insurance_due_date').val() == ''){  
//                  alert("Insurance due date is required");  
//             }  
//             else if($('#roadtax_from_date').val() == ''){  
//                  alert("Roadtax from date is required");  
//             }  
//             else if($('#roadtax_due_date').val() == ''){  
//                  alert("Roadtax due date is required");  
//             }   
//             else if($('#premium_amount').val() == ''){  
//                  alert("Premium amount is required");  
//             } 
//             else if($('#ncd').val() == ''){  
//                  alert("NCD % is required");  
//             } 
//             else if($('#sum_insured').val() == ''){  
//                  alert("Sum insured amount is required");  
//             } 
//             else if($('#excess_paid').val() == ''){  
//                  alert("Excess paid amount is required");  
//             } 
//             else if($('#roadtax_amount').val() == ''){  
//                  alert("Roadtax amount is required");  
//             } 
//             else{  
                 $.ajax({  
                      url:"roadtax.all.ajax.php",  
                      method:"POST",  
                      data:{action:'update_roadtax', data: $('#update_form').serialize()},
                      success:function(data){   
                           $('#editItem').modal('hide');  
                           $('#bootstrap-data-table').html(data);  
                           location.reload();		 
                      }  
                 });  
//             }  
       }); 

       $('#lpkp_date,#insurance_from_date,#insurance_due_date,#roadtax_from_date,#roadtax_due_date,#date_start, #date_end').datepicker({
    	   format: "dd-mm-yyyy",          
           autoclose: true,
           orientation: "top left",
           todayHighlight: true
       });
       
       $( ".button_search" ).click(function( event ) {
     		table.clear();
     		table.ajax.reload();
     		table.draw();  		
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
