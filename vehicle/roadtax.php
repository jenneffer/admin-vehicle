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
                                <strong class="card-title">Road Tax</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th rowspan="2">No.</th>
											<th rowspan="2">Vehicle No.</th>
                                            <th>Use Under</th>
											<th>LPKP Permit</th>
<!-- 											<th>Fitness Test</th> -->
											<th colspan="2">Insuranse</th>
											<th colspan="3">Road Tax</th>
                                            <th>Road Tax</th>
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
                                    <?php 
                                        $sql_query = "SELECT * FROM vehicle_roadtax
                                                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
                                                INNER JOIN company ON company.id = vehicle_vehicle.company_id";
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error());
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $year = !empty($row['vrt_roadtaxPeriodYear']) ? $row['vrt_roadtaxPeriodYear'] ."Year(s)" : "";
                                                    $month = !empty($row['vrt_roadtaxPeriodMonth']) ? $row['vrt_roadtaxPeriodMonth'] ."Month(s)" : "";
                                                    $days = !empty($row['vrt_roadtaxPeriodDay']) ? $row['vrt_roadtaxPeriodDay'] ."Day(s)" : "";
                                                    $period = $year ." ". $month ." ".$days;
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?></td>
                                                        <td><?=$row['vv_vehicleNo']?></td>
                                                        <td><?=$row['code']?></td>
                                                        <td><?=dateFormatRev($row['vrt_lpkpPermit_dueDate'])?></td>                                                        
                                                        <td><?=dateFormatRev($row['vrt_insurance_dueDate'])?></td>
                                                        <td><?=$row['vrt_insuranceStatus'] == 1 ? "Active" : "Inactive"?></td>  
                                                        <td><?=dateFormatRev($row['vrt_roadTax_fromDate'])?></td>
                                                        <td><?=dateFormatRev($row['vrt_roadTax_dueDate'])?></td>     
                                                        <td><?=$period?></td>  
                                                        <td class="text-right"><?=number_format($row['vrt_amount'], 2)?></td>                                               
                                                        <td>
                                                        	<span id="<?=$row['vrt_id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-pencil"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        	<span id="<?=$row['vrt_id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash"></i></span>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                            }
                                    ?>                                        										            
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
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, vv_vehicleNo FROM vehicle_vehicle");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <label for="lpkp_date" class="form-control-label"><small class="form-text text-muted">LPKP Permit due date</small></label>
                                <div class="input-group " data-provide="datepicker">
                                    <input id="lpkp_date" name="lpkp_date" class="form-control">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                </div>                               
                            </div>
                        </div>    

                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="insurance_from_date" class="form-control-label"><small class="form-text text-muted">Insurance from date</small></label>
                                <div class="input-group " data-provide="datepicker">
                                    <input id="insurance_from_date" name="insurance_from_date" class="form-control">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                                                
                                </div>                                                                           
                            </div>
                            <div class="col-sm-6">
                                <label for="insurance_due_date" class="form-control-label"><small class="form-text text-muted">Insurance due date</small></label>
                                <div class="input-group " data-provide="datepicker">
                                    <input id="insurance_due_date" name="insurance_due_date" class="form-control">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>                                                
                                </div>                                                                            
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="roadtax_from_date" class="form-control-label"><small class="form-text text-muted">Roadtax from date</small></label>
                                <div class="input-group " data-provide="datepicker">
                                    <input id="roadtax_from_date" name="roadtax_from_date" class="form-control">
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

                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="premium_amount" class=" form-control-label"><small class="form-text text-muted">Premium (RM)</small></label>
                                <input type="text" id="premium_amount" name="premium_amount" placeholder="e.g 1000.00" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="ncd" class=" form-control-label"><small class="form-text text-muted">NCD (%)</small></label>
                                <input type="text" id="ncd" name="ncd" placeholder="e.g 25" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="sum_insured" class=" form-control-label"><small class="form-text text-muted">Sum Insured (RM)</small></label>
                                <input type="text" id="sum_insured" name="sum_insured" placeholder="e.g 750.00" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="excess_paid" class=" form-control-label"><small class="form-text text-muted">Excess Paid (RM)</small></label>
                                <input type="text" id="excess_paid" name="excess_paid" placeholder="e.g 750.00" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label for="roadtax_amount" class=" form-control-label"><small class="form-text text-muted">Roadtax Amount(RM)</small></label>
                                <input type="text" id="roadtax_amount" name="roadtax_amount" placeholder="e.g 50.00" class="form-control">
                            </div>
                            <div class="col-sm-6 ">
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
  			var vrt_id = $(this).attr("id");
  			$.ajax({
  					url:"roadtax_fetch.php",
  					method:"POST",
  					data:{vrt_id:vrt_id},
  					dataType:"json",
  					success:function(data){	
                        $('#vrt_id').val(data.vrt_id);					
                        $('#vehicle_reg_no').val(data.vv_id);  
                        $('#lpkp_date').val(data.vrt_lpkpPermit_dueDate);  
                        $('#insurance_from_date').val(data.vrt_insurance_fromDate);  
                        $('#insurance_due_date').val(data.vrt_insurance_dueDate);  
                        $('#roadtax_from_date').val(data.vrt_roadTax_fromDate);  
                        $('#roadtax_due_date').val(data.vrt_roadTax_dueDate);  
                        $('#premium_amount').val(data.premium_amount);   
                        $('#ncd').val(data.ncd);  
                        $('#sum_insured').val(data.sum_insured);  
                        $('#excess_paid').val(data.excess_paid);  
                        $('#roadtax_amount').val(data.vrt_amount);  
                        $('#insurance_status').val(data.vrt_insuranceStatus); 
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
        		url:"delete.php",
        		method:"POST",    
        		data:{id:ID, table_name : 'vehicle_roadtax', col_identifier:'vrt_id'},
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
            else if($('#lpkp_date').val() == ''){  
                 alert("LPKP date is required");  
            }  
            else if($('#insurance_from_date').val() == ''){  
                 alert("Insurance from date is required");  
            }  
            else if($('#insurance_due_date').val() == ''){  
                 alert("Insurance due date is required");  
            }  
            else if($('#roadtax_from_date').val() == ''){  
                 alert("Roadtax from date is required");  
            }  
            else if($('#roadtax_due_date').val() == ''){  
                 alert("Roadtax due date is required");  
            }   
            else if($('#premium_amount').val() == ''){  
                 alert("Premium amount is required");  
            } 
            else if($('#ncd').val() == ''){  
                 alert("NCD % is required");  
            } 
            else if($('#sum_insured').val() == ''){  
                 alert("Sum insured amount is required");  
            } 
            else if($('#excess_paid').val() == ''){  
                 alert("Excess paid amount is required");  
            } 
            else if($('#roadtax_amount').val() == ''){  
                 alert("Roadtax amount is required");  
            } 
            else{  
                 $.ajax({  
                      url:"roadtax_update.php",  
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
