<?php
require_once('../assets/config/database.php');
require_once('../check_login.php');
global $conn_admin_db;
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
$select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";

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
                <div class="row">

                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">Insurance</strong>
                            </div>
                            <div class="card-body">                            	
                                <table id="insurance_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th rowspan="2">No.</th>
											<th rowspan="2">Company</th>
                                            <th rowspan="2">Reg No.</th>
											<th rowspan="2">LPKP (date)</th>											
											<th colspan="2" style="text-align: center">Period of Insurance</th>
											<th rowspan="2">Premium (RM)</th>
											<th rowspan="2">NCD (%)</th>
											<th rowspan="2">Sum Insured (RM)</th>
											<th rowspan="2">Excess</th>
											<th rowspan="2"></th>
                                        </tr>
                                        <tr>
                                            <th>From</th>
											<th>To</th>											
                                        </tr>
                                    </thead>
                                    <tbody>                                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-right font-weight-bold">TOTAL(RM)</td>
                                            <td class="text-right font-weight-bold">Premium Total</td>
                                            <td>&nbsp;</td>
                                            <td class="text-right font-weight-bold">Sum Insured Total</td>                                            
                                            <td class="text-right font-weight-bold">Excess Total</td>  
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
        <!-- Modal edit Insurance  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Insurance</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vi_id" name="vi_id" value="">
                        <div class="form-group row col-sm-12">
					      	<div class="col-sm-12">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.<span class="color-red">*</span></small></label>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','','required');
                                ?>
                            </div> 
                        </div>
                    	<div class="form-group row col-sm-12"> 
                        	<div class="col-sm-6">
                                <label for="insurance_from_date" class="form-control-label"><small class="form-text text-muted">Insurance from date<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="insurance_from_date" name="insurance_from_date" class="form-control" autocomplete="off" required>
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>                                                
                                </div>                                                                                        
                            </div>
                            <div class="col-sm-6">
                                <label for="insurance_due_date" class="form-control-label"><small class="form-text text-muted">Insurance due date<span class="color-red">*</span></small></label>
                                <div class="input-group">
                                    <input id="insurance_due_date" name="insurance_due_date" class="form-control" autocomplete="off" required>
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>                                                
                                </div>                                           
                            </div>
                    	</div>
                    	<div class="form-group row col-sm-12"> 
                        	<div class="col-sm-6">
                                <label for="premium_amount" class=" form-control-label"><small class="form-text text-muted">Premium (RM)<span class="color-red">*</span></small></label>
                                <input type="text" id="premium_amount" name="premium_amount" onkeypress="return isNumberKey(event)" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="ncd" class=" form-control-label"><small class="form-text text-muted">NCD (%)</small></label>
                                <input type="text" id="ncd" name="ncd" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                    	</div>
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="sum_insured" class=" form-control-label"><small class="form-text text-muted">Sum Insured (RM)</small></label>
                                <input type="text" id="sum_insured" name="sum_insured" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="excess_paid" class=" form-control-label"><small class="form-text text-muted">Excess Paid (RM)</small></label>
                                <input type="text" id="excess_paid" name="excess_paid" onkeypress="return isNumberKey(event)" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="insurance_status" class=" form-control-label"><small class="form-text text-muted">Insurance Status</small></label>
                                <select name="insurance_status" id="insurance_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
                    <h5 class="modal-title" id="staticModalLabel">Delete Insurance</h5>
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
    <!-- from right panel page -->
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
            var table = $('#insurance_table').DataTable({
//                 "paging": true,
//              	"processing": true,
         		"searching": true,
//          		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax":{
                 "url": "insurance.ajax.php",     
                 "type":"POST",      	
                 "data" : function ( data ){	
                	 		data.action = 'get_insurance_listing';		                	 							
                     }
                },
                "footerCallback": function( tfoot, data, start, end, display ) {
    				var api = this.api(), data;
    				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;

					api.columns([6,8,9], { page: 'current'}).every(function() {
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
    			'columnDefs': [
                	  {
                	      "targets": [6,8,9], // your case first column
                	      "className": "text-right", 
                	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
                	 },
                	 {
               	      "targets": [7,9], // your case first column
               	      "className": "text-center",                	                  	                      	        	     
               	 	}
				],
// 				"dom": 'Bfrtip',
// 	            "buttons": [ 
// 	             { 
// 	            	extend: 'excelHtml5', 
// 	            	messageTop: 'General Table',
// 	            	footer: true 
// 	             },
// 	             {
// 	            	extend: 'print',
// 	            	messageTop: 'General Table',
// 	            	footer: true,
// 	            	customize: function ( win ) {
// 	                    $(win.document.body)
// 	                        .css( 'font-size', '10pt' );
	            
// 	                    $(win.document.body).find( 'table' )
// 	                        .addClass( 'compact' )
// 	                        .css( 'font-size', 'inherit' );
// 	                }
// 	             }
// 	            ],
            });
          //retrieve data
            $(document).on('click', '.edit_data', function(){
    			var vi_id = $(this).attr("id");
    			$.ajax({
    					url:"insurance.ajax.php",
    					method:"POST",
    					data:{action:'retrive_insurance', vi_id:vi_id},
    					dataType:"json",
    					success:function(data){	
    	  					console.log(data);
//     	  					var lpkp_date = data.vrt_lpkpPermit_dueDate!= null ? dateFormat(data.vrt_lpkpPermit_dueDate) : "";
    	  					var insurance_from_date = data.vi_insurance_fromDate != null ? dateFormat(data.vi_insurance_fromDate) : "";
    	  					var insurance_due_date = data.vi_insurance_dueDate != null ? dateFormat(data.vi_insurance_dueDate) : "";
//     	  					var roadtax_from_date = data.vrt_roadTax_fromDate != null ? dateFormat(data.vrt_roadTax_fromDate) : "";
//     	  					var roadtax_due_date = data.vrt_roadTax_dueDate != null ? dateFormat(data.vrt_roadTax_dueDate) : "";
    	  					
                          $('#vi_id').val(data.vi_id);					
                          $('#vehicle_reg_no').val(data.vv_id);  
//                           $('#lpkp_date').val(lpkp_date);  
                          $('#insurance_from_date').val(insurance_from_date);  
                          $('#insurance_due_date').val(insurance_due_date);  
//                           $('#roadtax_from_date').val(roadtax_from_date);  
//                           $('#roadtax_due_date').val(roadtax_due_date);  
                          $('#premium_amount').val(data.vi_premium_amount);    
                          $('#ncd').val(data.vi_ncd);  
                          $('#sum_insured').val(data.vi_sum_insured);  
                          $('#excess_paid').val(data.vi_excess);  
//                           $('#roadtax_amount').val(data.vrt_amount);  
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
          		url:"insurance.ajax.php",
          		method:"POST",    
          		data:{action:'delete_insurance', id:ID},
          		success:function(data){	  						
          			$('#deleteItem').modal('hide');		
          			location.reload();		
          		}
          	});
          });
          
  		//update form
          $('#update_form').on("submit", function(event){  
            event.preventDefault();  
            $.ajax({  
                url:"insurance.ajax.php",  
                method:"POST",  
                data:{action:'update_insurance', data: $('#update_form').serialize()},
                success:function(data){   
                     $('#editItem').modal('hide');  
                     $('#bootstrap-data-table').html(data);  
                     location.reload();		 
                }  
            });  

         }); 

		//get filtered report
        $('#myform').on("submit", function(event){  
        	table.clear();
  			table.ajax.reload();
  			table.draw();     
        }); 
        $('#insurance_from_date, #insurance_due_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });
      });
        
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
