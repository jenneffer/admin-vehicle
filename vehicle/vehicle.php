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
                                <strong class="card-title">List of Vehicle</strong>
                            </div>
<!--                             <button type="button" class="btn btn-primary mb-1 col-md-2" data-toggle="modal" data-target="#modalLoginForm"> -->
<!--                                 Small -->
<!--                             </button> -->
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
											<th>Vehicle No.</th>
                                            <th>Company</th>
                                            <th>Brand</th>
											<th>Name</th>
											<th>Description</th>
											<th>Purchased Year</th>
											<th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT * FROM vehicle_vehicle
                                        INNER JOIN company ON company.id = vehicle_vehicle.company_id WHERE vehicle_vehicle.status='1'"; //only show active vehicle 
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
                                                        <td><?=$row['vv_brand']?></td>
                                                        <td><?=$row['vv_name']?></td>
                                                        <td><?=$row['vv_description']?></td>
                                                        <td><?=$row['vv_yearPurchased']?></td>
                                                        <td>
                                                        	<span id="<?=$row['vv_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                        	<span id="<?=$row['vv_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
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

        <!-- Modal edit vehicle  -->
        <div id="editItem" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Vehicle</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vv_id" name="vv_id" value="">
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                <div>
                                	<input type="text" id="vehicle_reg_no" name="vehicle_reg_no" placeholder="Enter vehicle registration number" class="form-control">
                            	</div>
                            </div>
                            <div class="col-sm-6">
                                <label for="category" class=" form-control-label"><small class="form-text text-muted">Vehicle Category</small></label>
                                <div>
                                <?php
                                    $cat = mysqli_query ( $conn_admin_db, "SELECT vc_id, vc_type FROM vehicle_category");
                                    db_select ($cat, 'category', '','','-select-','form-control','');
                                ?>
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
                                <label class="control-label"><small class="form-text text-muted">Year Purchased</small></label>
                                <div>
                                	<input type="text" id="yearPurchased" name="yearPurchased" value="" class="form-control">                               
                                </div>
                            </div>
                        </div>                    
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label class="control-label"><small class="form-text text-muted">Brand</small></label>
                                <div>
                                	<input type="text" id="brand" name="brand" value="" class="form-control">                               
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label"><small class="form-text text-muted">Name</small></label>
                                <div>
                                	<input type="text" id="name" name="name" value="" class="form-control">                               
                                </div>
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-6">
                                <label class="control-label"><small class="form-text text-muted">Description</small></label>
                                <div>
                                	<textarea id="description" name="description" class="form-control"></textarea>                               
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label"><small class="form-text text-muted">Vehicle Capacity(CC)</small></label>
                                <div>
                                	<input type="text" id="capacity" name="capacity" class="form-control">                               
                                </div>
                            </div>
                        </div>
<!--                         <div class="form-group"> -->
<!--                             <div> -->
<!--                                 <div class="checkbox"> -->
<!--                                     <label> -->
<!--                                         <input type="checkbox" name="remember"> Remember Me -->
<!--                                     </label> -->
<!--                                 </div> -->
<!--                             </div> -->
<!--                         </div> -->
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
        $('#bootstrap-data-table-export').DataTable();
        
        $(document).on('click', '.edit_data', function(){
        	var vehicle_id = $(this).attr("id");
        	$.ajax({
        			url:"vehicle.all.ajax.php",
        			method:"POST",
        			data:{action:'retrive_vehicle', vehicle_id:vehicle_id},
        			dataType:"json",
        			success:function(data){	
        				$('#vv_id').val(data.vv_id);					
                        $('#vehicle_reg_no').val(data.vv_vehicleNo);  
                        $('#category').val(data.vv_category);  
                        $('#company').val(data.company_id);  
                        $('#brand').val(data.vv_brand);  
                        $('#name').val(data.vv_name);  
                        $('#description').val(data.vv_description);  
                        $('#yearPurchased').val(data.vv_yearPurchased);    
                        $('#capacity').val(data.vv_capacity);  
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
    			data:{action:'delete_vehicle', id:ID},
    			success:function(data){	  						
    				$('#deleteItem').modal('hide');		
    				location.reload();		
    			}
    		});
    	});
    
        $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#vehicle_reg_no').val() == "")  
          {  
               alert("Vehicle number is required");  
          }  
          else if($('#category').val() == '')  
          {  
               alert("Category is required");  
          }  
          else if($('#company').val() == '')  
          {  
               alert("Company is required");  
          }  
          else if($('#brand').val() == '')  
          {  
               alert("Brand is required");  
          }  
          else if($('#name').val() == '')  
          {  
               alert("Vehicle name is required");  
          }  
          else if($('#yearPurchased').val() == '')  
          {  
               alert("Purchased year is required");  
          }   
          else  
          {  
               $.ajax({  
                    url:"vehicle.all.ajax.php",  
                    method:"POST",  
                    data:{action:'update_vehicle', data: $('#update_form').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data);
                         location.reload();  
                    }  
               });  
          }  
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
