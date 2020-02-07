<?php
	require_once('../assets/config/database.php');
	require_once('./function.php');
	global $conn_admin_db;
	session_start();
	if(isset($_SESSION['cr_id'])) {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $params);
		
		// get id
		$userId = $_SESSION['cr_id'];
		$name = $_SESSION['cr_name'];
		
	} else {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$PrevURL= $url;
		header("Location: ../login.php?RecLock=".$PrevURL);
	}
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Insurance</title>
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
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Puspakom</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
											<th rowspan="2">Vehicle Reg No.</th>
                                            <th rowspan="2">Company</th>
											<th colspan="2">Task</th>
											<th rowspan="2">Runner</th>
											<th rowspan="2">&nbsp;</th>
                                        </tr>
                                        <tr>
											<th>Puspakom</th>
                                            <th>Roadtax</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $sql_query = "SELECT * FROM vehicle_puspakom
                                                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_puspakom.vv_id
                                                INNER JOIN company ON company.id = vehicle_vehicle.company_id";
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error());
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?></td>
                                                        <td><?=$row['vv_vehicleNo']?></td>
                                                        <td><?=$row['code']?></td>
                                                        <td><?=dateFormatRev($row['vp_fitnessDate'])?></td>
                                                        <td><?=dateFormatRev($row['vp_roadtaxDueDate'])?></td>
                                                        <td><?=$row['vp_runner']?></td>                                                        
                                                        <td>
                                                        	<span id="<?=$row['vp_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-pencil"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        	<span id="<?=$row['vp_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash"></i></span>
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
        <!-- Modal edit Roadtax  -->
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
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, vv_vehicleNo FROM vehicle_vehicle");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','');
                                ?>
                            </div>   
                            <div class="form-group col-6">
                                <label for="runner" class=" form-control-label"><small class="form-text text-muted">Runner</small></label>
                                <input type="text" id="runner" name="runner" class="form-control">
                            </div>                                     
                        </div>
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="fitness_date" class="form-control-label"><small class="form-text text-muted">Fitness due date</small></label>
                                <div class="input-group " data-provide="datepicker">
                                    <input id="fitness_date" name="fitness_date" class="form-control">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                </div>                                
                            </div>
                            <div class="col-sm-6">
                                <label for="roadtax_due_date" class="form-control-label"><small class="form-text text-muted">Roadtax due date</small></label>
                                <div class="input-group " data-provide="datepicker">
                                    <input id="roadtax_due_date" name="roadtax_due_date" class="form-control">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
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
	
	<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();

      	//retrieve data
        $(document).on('click', '.edit_data', function(){
			var vp_id = $(this).attr("id");
			$.ajax({
					url:"puspakom_fetch.php",
					method:"POST",
					data:{vp_id:vp_id},
					dataType:"json",
					success:function(data){	
                      $('#vp_id').val(data.vp_id);					
                      $('#vehicle_reg_no').val(data.vv_id);  
                      $('#fitness_date').val(data.vp_fitnessDate);  
                      $('#roadtax_due_date').val(data.vp_roadtaxDueDate);  
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
      		url:"delete.php",
      		method:"POST",    
      		data:{id:ID, table_name : 'vehicle_puspakom', col_identifier:'vp_id'},
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
                    url:"puspakom_update.php",  
                    method:"POST",  
                    data:$('#update_form').serialize(),  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data);  
                    }  
               });  
          }  
     }); 
    });
  </script>
</body>
</html>
