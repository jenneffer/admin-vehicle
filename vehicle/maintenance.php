<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');
	require_once('../check_login.php');
	global $conn_admin_db;
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
                                <strong class="card-title">VEHICLE MAINTENANCE RECORD</strong>
                            </div>
                            <div class="card-body">
                                <table id="maintenance-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>No.</th>
											<th>Vehicle No.</th>    											                                        
											<th>Company</th>
											<th>Workshop</th>
											<th>IRF No.</th>
											<th>IRF Date</th>
											<th>P.O No.</th>
											<th>P.O Date</th>
											<th>Invoice No.</th>											
											<th>Amount (RM)</th>
											<th>Date</th>
											<th>User</th>
											<th>Remarks</th>								                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
										<?php 
                                        $sql_query = "SELECT vm_id, vm.vv_id,vv_vehicleNo, vm_date, vm_description, vm_amount, vm_invoice_no, vm_irf_no, vm_po_no, vm_po_date, vm_irf_date, vm_workshop, vm_user,
                                                (SELECT code FROM company WHERE id=vv.company_id) AS company_name FROM vehicle_maintenance vm
                                                INNER JOIN vehicle_vehicle vv ON vv.vv_id = vm.vv_id WHERE vm.vm_status='1' ";
                                        
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;   
                                                    
                                                    $workshop = itemName("SELECT name FROM vehicle_workshop WHERE id='".$row['vm_workshop']."'");
                                                    ?>
                                                    <tr>
                                                    	<td><?=$count?>.</td>
                                                        <td><?=strtoupper($row['vv_vehicleNo'])?></td>
                                                        <td><?=$row['company_name']?></td>  
                                                        <td><?=$workshop?></td>                                                        
                                                        <td><?=$row['vm_irf_no']?></td>
                                                        <td><?=(empty($row['vm_irf_date']) || $row['vm_irf_date'] === '0000-00-00') ? '-' : $row['vm_irf_date']  ?></td>
                                                        <td><?=$row['vm_po_no']?></td>
                                                        <td><?=(empty($row['vm_po_date']) || $row['vm_po_date'] === '0000-00-00' ) ? '-' : $row['vm_po_date']?></td>
                                                        <td><?=$row['vm_invoice_no']?></td>                                        
                                                        <td><?=$row['vm_amount']?></td>
                                                        <td><?=$row['vm_date']?></td>
                                                        <td><?=$row['vm_user']?></td>
                                                        <td><?=$row['vm_description']?></td>                                                         
                                                        <td class="text-center">                                                        	
                                                        	<span id="<?=$row['vm_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i></span>
                                                        	<span id="<?=$row['vm_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i></span>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                            }
                                    ?>             
                                    </tbody> 
                                    <tfoot>
                                        <tr>
                                        	<th colspan="9">Total</th>
                                        	<th></th>
                                        	<th></th>
                                        	<th></th>
                                        	<th></th>
                                        	<th>&nbsp;</th>
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
        
        <!-- Modal edit vehicle maintenance  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Maintenance</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" id="vm_id" name="vm_id" value="">
                    	<div class="card-body card-block">
                        	<div class="form-group row col-sm-12">
                        		<div class="col-sm-4">
                                    <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.<span class="color-red">*</span></small></label>
                                    <?php
                                        $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                        db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control form-control-sm','','required');
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.<span class="color-red">*</span></small></label>
                                    <?php
                                        $workshop = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM vehicle_workshop");
                                        db_select ($workshop, 'workshop', '','','-select-','form-control form-control-sm','','required');
                                    ?>
                                </div>
                                <div class="col-sm-4"> 
                            		<label for="date" class=" form-control-label"><small class="form-text text-muted">Invoice Date<span class="color-red">*</span></small></label>
                                    <div class="input-group">
                                        <input id="date" name="date" class="form-control form-control-sm" autocomplete="off" required>                                        
                                    </div>
                            	</div>									
                            </div>
                            
                            <div class="form-group row col-sm-12">
                            	<div class="col-sm-6"> 
                                    <label for="irf_no" class=" form-control-label"><small class="form-text text-muted">IRF No.<span class="color-red">*</span></small></label>
                                    <input type="text" id="irf_no" name="irf_no" class="form-control form-control-sm" required>
                            	</div>
                            	<div class="col-sm-6"> 
                                    <label for="irf_date" class=" form-control-label"><small class="form-text text-muted">IRF Date</small></label>
                                    <input type="text" id="irf_date" name="irf_date" class="form-control form-control-sm">
                            	</div>
                            </div>
                            <div class="form-group row col-sm-12">
                            	<div class="col-sm-6"> 
                                    <label for="po_no" class=" form-control-label"><small class="form-text text-muted">P.O No.<span class="color-red">*</span></small></label>
                                    <input type="text" id="po_no" name="po_no" class="form-control form-control-sm" required>
                            	</div>
                            	<div class="col-sm-6"> 
                                    <label for="po_date" class=" form-control-label"><small class="form-text text-muted">P.O Date</small></label>
                                    <input type="text" id="po_date" name="po_date" class="form-control form-control-sm">
                            	</div>                                    	                                    	
                            </div>
                             <div class="form-group row col-sm-12">
                             	<div class="col-sm-6">                                        
                                    <label for="inv_no" class=" form-control-label"><small class="form-text text-muted">Invoice No.<span class="color-red">*</span></small></label>
                            		<input type="text" id="inv_no" name="inv_no" class="form-control form-control-sm" required>
                            	</div>
                            	<div class="col-sm-6">                                        
                                    <label for="amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM)<span class="color-red">*</span></small></label>
                            		<input type="text" id="amount" name="amount" onkeypress="return isNumberKey(event)" class="form-control form-control-sm" required>
                            	</div>
                             </div>
                            <div class="form-group row col-sm-12">
                                <div class="col-sm-6">                                        
                                        <label for="user" class=" form-control-label"><small class="form-text text-muted">User<span class="color-red">*</span></small></label>
                            		<input type="text" id="user" name="user" class="form-control form-control-sm" required>
                            	</div>
                            	<div class="col-sm-6"> 
                                    <label for="desc" class=" form-control-label"><small class="form-text text-muted">Remarks<span class="color-red"></span></small></label>
                                    <textarea id="desc" name="desc" class="form-control form-control-sm"></textarea>
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
                    <h5 class="modal-title" id="staticModalLabel">Delete Summon</h5>
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
          $('#maintenance-table').DataTable({
				"searching":true,
				"paging":true,
				"columnDefs": [
					{
						"targets": [9], // your case first column
	              	    "className": "text-right", 
	              	    "render": $.fn.dataTable.render.number(',', '.', 2, '')  
					}
				],
	            "footerCallback": function( tfoot, data, start, end, display ) {
	            	var api = this.api(), data;
	            	var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;            
	        		api.columns([9], { page: 'current'}).every(function() {
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

          $(document).on('click', '.edit_data', function(){
  			var vm_id = $(this).attr("id");
  			$.ajax({
  					url:"maintenance.all.ajax.php",
  					method:"POST",
  					data:{ action:'retrieve_data', vm_id:vm_id},
  					dataType:"json",
  					success:function(data){	
//   	  					console.log(data);   	  	  					
  						var vm_amount = parseFloat(data.vm_amount).toFixed(2);
  						var vm_date = dateFormat(data.vm_date);
  						var vm_irf_date = ( data.vm_irf_date == null ) || (data.vm_irf_date == '0000-00-00')  ? '-' : dateFormat(data.vm_irf_date) ;
  						var vm_po_date = ( data.vm_po_date ==null ) || (data.vm_po_date == '0000-00-00') ? '-' : dateFormat(data.vm_po_date);
						  	  				 	
  						$('#vm_id').val(data.vm_id);					
                        $('#vehicle_reg_no').val(data.vv_id);                           
                        $('#date').val(vm_date);  
                        $('#irf_date').val(vm_irf_date);  
                        $('#po_date').val(vm_po_date);  
                        $('#irf_no').val(data.vm_irf_no);
                        $('#po_no').val(data.vm_po_no);
                        $('#inv_no').val(data.vm_invoice_no);
                        $('#workshop').val(data.vm_workshop);
                        $('#user').val(data.vm_user);
                        $('#desc').val(data.vm_description);
                        $('#amount').val(vm_amount);      
                        $('#editItem').modal('show');
  					}
  				});
        });        
		//delete item
        $(document).on('click', '.delete_data', function(){
			var vm_id = $(this).attr("id");			
			$('#delete_record').data('id', vm_id ); //set the data attribute on the modal button

    	});
        $( "#delete_record" ).click( function() {
    		var ID = $(this).data('id');
    		$.ajax({
    			url:"maintenance.all.ajax.php",
    			method:"POST",    
    			data:{action:'delete_data', vm_id:ID},
    			success:function(data){	  						
					if(data){
						$('#deleteItem').modal('hide');	
						location.reload();		
						alert("Deleted Successfully!!");
					}	
    			}
    		});
    	});
    	
		//update summon form submit
        $('#update_form').on("submit", function(event){  
            event.preventDefault();  
            $.ajax({  
                url:"maintenance.all.ajax.php",  
                method:"POST",  
                data:{action:'update_data', data:$('#update_form').serialize()},  
                success:function(data){   
                    $('#editItem').modal('hide');  
                    $('#maintenance-table').html(data);  
                    location.reload();	
                }  
            }); 
       });
        
        $('#date, #irf_date, #po_date').datepicker({
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
