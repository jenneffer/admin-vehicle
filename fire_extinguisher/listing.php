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
	
	
// 	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
// 	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
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
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Fire Extinguisher Master Listing</strong>
                            </div>
                            <!-- Filter -->
<!--                             <div class="card-body"> -->
<!--                             <form id="myform" enctype="multipart/form-data" method="post" action="">                	                    -->
<!--                 	            <div class="form-group row col-sm-12"> -->
<!--                                     <div class="col-sm-3"> -->
<!--                                         <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                          <input type="text" id="date_start" name="date_start" class="form-control" value="<?=$date_start?>" autocomplete="off">
<!--                                           <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
<!--                                         </div>                             -->
<!--                                     </div> -->
<!--                                     <div class="col-sm-3"> -->
<!--                                         <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label> -->
<!--                                         <div class="input-group"> -->
<!--                                         <input type="text" id="date_end" name="date_end" class="form-control" value="<?=$date_end?>" autocomplete="off">
<!--                                           <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
<!--                                         </div>                              -->
<!--                                     </div> -->
<!--                                     <div class="col-sm-4">                                    	 -->
<!--                                     	<button type="submit" class="btn btn-primary button_search ">Submit</button> -->
<!--                                     </div> -->
<!--                                  </div>     -->
<!--                             </form> -->
<!--                             </div> -->
<!--                             <hr> -->
                            <div class="card-body">
                                <table id="master_listing" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
											<th>Serial No.</th>
                                            <th>Company</th>
                                            <th>Supplier</th>
											<th>Location</th>
											<th>Expiry Date</th>
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
        </div>
        <!-- Modal edit puspakom  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Master Listing</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                            <label for="serial_no" class=" form-control-label"><small class="form-text text-muted">Serial No.</small></label>
                            <input type="text" id="serial_no" name="serial_no" placeholder="Enter serial number" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="expiry_date" class="form-control-label"><small class="form-text text-muted">Expiry date</small></label>
                            <div class="input-group">
                                <input id="expiry_date" name="expiry_date" class="form-control" autocomplete="off">
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>                                            
                        </div>                                        
                    </div>
                    <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                            <label class="control-label"><small class="form-text text-muted">Company</small></label>
                            <div>
                                <?php
                                    $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                    db_select ($company, 'company', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label"><small class="form-text text-muted">Supplier</small></label>
                            <div>
                                <?php
                                    $supplier = mysqli_query ( $conn_admin_db, "SELECT supplier_id, supplier_name FROM fireextinguisher_supplier");
                                    db_select ($supplier, 'supplier', '','','-select-','form-control','');
                                ?>
                            </div>
                        </div>                                         
                    </div>
                    <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                            <label for="requisition_no" class="form-control-label"><small class="form-text text-muted">Requisition No.</small></label>
                            <input type="text" id="requisition_no" name="requisition_no" placeholder="Enter requisition number" class="form-control">                                           
                        </div>
                        <div class="col-sm-6">
                            <label for="invoice_no" class="form-control-label"><small class="form-text text-muted">Invoice No.</small></label>
                            <input type="text" id="invoice_no" name="invoice_no" placeholder="Enter invoice number" class="form-control">                                           
                        </div>
                    </div>                                    
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6">
                            <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                            <textarea id="remark" name="remark" placeholder="Enter remark" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label"><small class="form-text text-muted">Location</small></label>
                            <div>
                                <?php
                                    $location = mysqli_query ( $conn_admin_db, "SELECT location_id, location_name FROM fireextinguisher_location");
                                    db_select ($location, 'location', '','','-select-','form-control','');
                                ?>
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

	<script type="text/javascript">
    $(document).ready(function() {

        $("#month").change(function () {
            var month = this.value;           
            $('#month').val(month);
        });

        $("#company").change(function () {
            var company = this.value;
            $('#company').val(company);
        });

        
    	var table = $('#master_listing').DataTable({
         	"processing": true,
         	"serverSide": true,
         	"searching": false,
            "ajax":{
           	 "url": "function.ajax.php",    
           	 "type":"POST",       	
           	 "data" : function ( data ) {  
				data.action = 'master_listing';				
   	        }
   	      },
   	     });
  	     

      	//retrieve data
        $(document).on('click', '.edit_data', function(){
			var vp_id = $(this).attr("id");
			$.ajax({
					url:"puspakom.all.ajax.php",
					method:"POST",
					data:{action:'retrive_puspakom', vp_id:vp_id},
					dataType:"json",
					success:function(data){	
                        var fitnessDate = dateFormat(data.vp_fitnessDate);
                        var rTaxdueDate = dateFormat(data.vp_roadtaxDueDate);
                        $('#vp_id').val(data.vp_id);					
                        $('#vehicle_reg_no').val(data.vv_id);  
                        $('#fitness_date').val(fitnessDate);  
                        $('#roadtax_due_date').val(rTaxdueDate);  
                        $('#runner').val(data.vp_runner);                        
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
          else if($('#runner').val() == ''){  
               alert("Runner name is required");  
          }          
          else{  
               $.ajax({  
                    url:"puspakom.all.ajax.php",  
                    method:"POST",  
                    data:{action:'update_puspakom', data : $('#update_form').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data); 
                         location.reload();		 
                    }  
               });  
          }  
     }); 
      
//      $( ".button_search" ).click(function( event ) {
//   		table.clear();
//   		table.ajax.reload();
//   		table.draw();  		
//   		});	

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
