<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');
	require_once('../check_login.php');
	global $conn_admin_db;
	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');

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
                                <strong class="card-title">Puspakom</strong>
                            </div>
                            <!-- Filter -->
<!--                             <div class="card-body"> -->
<!--                             <form id="myform" enctype="multipart/form-data" method="post" action="">                	                    -->
<!--                 	            <div class="form-group row col-sm-12"> -->
<!--                                     <div class="col-sm-3"> -->
<!--                                         <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                          <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">                                          
<!--                                         </div>                             -->
<!--                                     </div> -->
<!--                                     <div class="col-sm-3"> -->
<!--                                         <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                          <input type="text" id="date_end" name="date_end" class="form-control form-control-sm " value="<?=$date_end?>" autocomplete="off">                                          
<!--                                         </div>                              -->
<!--                                     </div>                                     -->
<!--                                     <div class="col-sm-3">                                    	 -->
<!--                                     	<button type="submit" class="btn btn-sm btn-primary button_search ">View</button> -->
<!--                                     </div> -->
<!--                                  </div>     -->
<!--                             </form> -->
<!--                             </div> -->
                            <hr>
                            <div class="card-body">
                                <table id="puspakom_datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
											<th rowspan="2">Vehicle Reg No.</th>
                                            <th rowspan="2">Company</th>
											<th colspan="2" class="text-center">Task</th>
											<th rowspan="2">Remark</th>
											<th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
											<th>Puspakom</th>
                                            <th>Roadtax</th>
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
        </div>
        <!-- Modal edit puspakom  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Puspakom</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vp_id" name="vp_id" value="">
                        <div class="form-group row col-sm-12">
                            <div class="form-group col-6">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1' AND vv_category='2'"); //display lorry only
                                    db_select ($vehicle, 'vehicle_reg_no', $select_company,'submit()','-select-','form-control','');
                                ?>
                            </div>  
                            <div class="col-sm-6">
                                <label for="fitness_date" class="form-control-label"><small class="form-text text-muted">Fitness due date</small></label>
                                <div class="input-group">
                                  <input type="text" id="fitness_date" name="fitness_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                       
                            </div> 
                                                                 
                        </div>
                        <div class="form-group row col-sm-12">                            
                            <div class="col-sm-6">
                                <label for="roadtax_due_date" class="form-control-label"><small class="form-text text-muted">Roadtax due date</small></label>
                                <div class="input-group">
                                  <input type="text" id="roadtax_due_date" name="roadtax_due_date" class="form-control" autocomplete="off">
                                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div> 
                            </div>
                            <div class="form-group col-6">
                                <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                                <textarea id="remark" name="remark" class="form-control"></textarea>
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
                    <h5 class="modal-title" id="staticModalLabel">Delete Puspakom</h5>
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

    	// Initialize select2
    	var select2 = $("#vehicle_reg_no").select2({
//     		placeholder: "select option",
    	    selectOnClose: true
        });
    	select2.data('select2').$selection.css('height', '30px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da');
    	
        $("#month").change(function () {
            var month = this.value;           
            $('#month').val(month);
        });

        $("#company").change(function () {
            var company = this.value;
            $('#company').val(company);
        });
    	var table = $('#puspakom_datatable').DataTable({
    		"paging": false,
        	"pageLength": 1,
            "ajax":{
           	 "url": "puspakom.all.ajax.php",    
           	 "type":"POST",       	
           	 "data" : function ( data ) {
//           		data.date_start = '<?=$date_start?>';
//				data.date_end = '<?=$date_end?>';  				
				data.action = 'display_puspakom';				
   	        }
   	      },
   	     });
  	     

      	//retrieve data
        $(document).on('click', '.edit_data', function(){
			var vp_id = $(this).attr("id");
			$.ajax({
					url:"puspakom.all.ajax.php",
					method:"POST",
					data:{action:'retrive_puspakom', id:vp_id},
					dataType:"json",
					success:function(data){	
                        var fitnessDate = dateFormat(data.vp_fitnessDate);
                        var rTaxdueDate = dateFormat(data.vp_roadtaxDueDate);
                        $('#vp_id').val(data.vp_id);					
                        $('#vehicle_reg_no').val(data.vv_id);  
                        $('#fitness_date').val(fitnessDate);  
                        $('#roadtax_due_date').val(rTaxdueDate);  
                        $('#remark').val(data.vp_remark);                        
                        $('#editItem').modal('show');
	  				}
				});
      });

      //delete records
      $(document).on('click', '.delete_data', function(){
      	var vp_id = $(this).attr("id");
      	$('#delete_record').data('id', vp_id); //set the data attribute on the modal button
      
      });
  	
      $( "#delete_record" ).click( function() {
      	var ID = $(this).data('id');
      	$.ajax({
      		url:"puspakom.all.ajax.php",
      		method:"POST",    
      		data:{action:'delete_puspakom', id:ID},
      		success:function(data){	  						
      			$('#deleteItem').modal('hide');		
      			location.reload();		
      		}
      	});
      });
      
		//update form
      $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#vehicle_reg_no').val() == ""){  
               alert("Vehicle number is required");  
          }  
          else if($('#fitness_date').val() == ''){  
               alert("Fitness due date is required");  
          }  
          else if($('#roadtax_due_date').val() == ''){  
               alert("Road tax due date is required");  
          }                      
          else{  
               $.ajax({  
                    url:"puspakom.all.ajax.php",  
                    method:"POST",  
                    data:{action:'update_puspakom', data : $('#update_form').serialize()},  
                    success:function(data){   
                        console.log(data);
                        if(data){
                        	$('#editItem').modal('hide');  
                        	alert("Added Successfully!");
                        	location.reload();		
                            window.location = "puspakom.php";  
						}                             
                    }  
               });  
          }  
     }); 
      
     $( ".button_search" ).click(function( event ) {
  		table.clear();
  		table.ajax.reload();
  		table.draw();  		
  		});	

     $('#date_start, #date_end, #roadtax_due_date, #fitness_date').datepicker({
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
