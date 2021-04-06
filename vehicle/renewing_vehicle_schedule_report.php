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
                                <strong class="card-title">Renewing Vehicle Schedule</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">
                    	            	<div class="col-sm-3">
                                			<label for="company_dd" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                                    		<?php
                                                $select_company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE vehicle_used='1' AND status='1' ORDER BY name ASC");
                                                db_select ($select_company, 'select_company', $select_c,'submit()','All','form-control form-control-sm','');                        
                                            ?>
                                      	</div>
                                        <div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">                                              
                                            </div>                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_end" name="date_end" class="form-control form-control-sm" value="<?=$date_end?>" autocomplete="off">                                              
                                            </div>                             
                                        </div>
                                        <div class="col-sm-3">                                    	
                                        	<button type="submit" class="btn btn-sm btn-primary button_search ">View</button>
                                        </div>
                                     </div>    
                                </form>
                            </div>
                            <hr>
                            <div class="card-body" >
                                <table id="vehicle_schedule" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>No.</th>
                                            <th>Company</th>
											<th>Vehicle No.</th>
											<th>R-Tax, Sum & NCD</th>
											<th>Task</th>
											<th>Due Date</th>
                                            <th>Remarks</th>
                                            <th>Action</th>            
                                            <th>&nbsp;</th>                                
                                        </tr>
                                    </thead>
                                    <tbody>									           
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        <!-- Modal edit next due date  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="task" name="task" value="">
                        <div class="form-group row col-sm-12">
                            <label for="remark" class="form-control-label"><small class="form-text text-muted">Remark</small></label>  
                            <div class="input-group">
                              <input type="text" id="remark" name="remark" class="form-control" autocomplete="off">                              
                            </div>                            
                        </div>
                        <div class="form-group row col-sm-12">
                            <label for="action" class="form-control-label"><small class="form-text text-muted">Action</small></label>  
                            <div class="input-group">
                              <input type="text" id="action" name="action" class="form-control" autocomplete="off">                              
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
    	  var table = $('#vehicle_schedule').DataTable({
              "processing": true,
              "serverSide": true,
              "searching":false,
              "ajax":{
               "url": "renewing.vehicle.schedule.ajax.php",  
               "type": "POST",         	
               "data" : function ( data ){
						data.date_start = '<?=$date_start?>';
						data.date_end = '<?=$date_end?>';
						data.action = 'renewing_vehicle_schedule';
						data.select_company = '<?=$select_c?>';
                   }
              },
              "columnDefs": [
            	  {
            	      "targets": 7, // your case first column
            	      "className": "text-center",                	     
            	 }],
            "dom": 'Bfrtip',
            "buttons": [ 
             { 
            	extend: 'excelHtml5', 
            	messageTop: 'Renewing Vehicle Schedule',
            	footer: true 
             },
             {
            	extend: 'print',
            	messageTop: 'Renewing Vehicle Schedule',
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
        //update form
          $('#update_form').on("submit", function(event){  
              event.preventDefault();  
              if($('#next_due_date').val() == ""){  
                   alert("Date is required");  
              }                 
              else{  
                   $.ajax({  
                        url:"renewing.vehicle.schedule.ajax.php",  
                        method:"POST",  
                        data:{action:'update_renewal_status', data:$('#update_form').serialize()},  
                        success:function(data){   
                             $('#editItem').modal('hide');  
                             $('#vehicle_schedule').html(data);
                             location.reload();  
                        }  
                   });  
              }  
         });
      	$('#next_due_date').datepicker({
      		format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
            });
      });
      $('#date_start, #date_end').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
          orientation: "top left",
          todayHighlight: true
      });

       $('#myform').on("submit", function(event){  
    	   	table.clear();
  			table.ajax.reload();
  			table.draw();      
       });

      function editFunction(id, task){	
            $('#id').val(id);	
            $('#task').val(task);
    		$.ajax({
    				url:"renewing.vehicle.schedule.ajax.php",
    				method:"POST",
    				data:{action :'retrieve_data', id:id, task: task},
    				dataType:"json",
    				success:function(data){	        				  	
        				console.log(data);  					
      					$('#remark').val(data.remark);	
      					$('#action').val(data.renewal_status);		
                    	$('#editItem').modal('show');
    			}
    		});
      }
  </script>
</body>
</html>
