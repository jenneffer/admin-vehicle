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
                                <strong class="card-title">List of Vehicle</strong>
                            </div>
                            <!-- Filter -->
                            <div class="card-body">
                            <form id="myform" enctype="multipart/form-data" method="post" action="">  
                            	<div class="form-group row col-sm-12">
                            	    <div class="col-sm-3">                                        
                                        <?php
                                            $select_company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company WHERE status='1'");
                                            db_select ($select_company, 'select_company', $select_c,'','All Company','form-control','');
                                        ?>                              
                                    </div>
                                    <div class="col-sm-1">                                    	
                                    	<button type="submit" class="btn btn-primary button_search ">View</button>
                                    </div>
                                    <div class="col-sm-1">                                    	
                                    	<button type="button" class="btn btn-primary button_search" onclick="window.open('vehicle_print.php?company=<?php echo $select_c; ?>')">Print</button>
                                    </div>
                                    <div class="col-sm-1">                                    	
                                    	<button type="button" class="btn btn-primary button_search" onclick="fnExcelReport();">Export to Excel</button>
                                    </div>
                            	</div>     
							</form>
							</div>
                            <div class="card-body" >
                                <table id="vehicle_table" class="table table-striped responsive table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
											<th rowspan="2">Reg No.</th>
                                            <th rowspan="2">Company</th>
                                            <th rowspan="2">Category</th>
											<th rowspan="2">Make</th>
											<th rowspan="2">Model</th>
											<th rowspan="2">Engine No.</th>
											<th rowspan="2">Chasis No.</th>
											<th rowspan="2">B.D.M/B.G.K</th>
											<th rowspan="2">B.T.M</th>
											<th rowspan="2">Goods Capacity</th>
											<th rowspan="2">Year Made</th>
											<th rowspan="2">Finance</th>		
											<th colspan="4" style="text-align: center;">LPKP Permit</th>
											<th rowspan="2">Remarks</th>
											<th rowspan="2">&nbsp;</th>
                                        </tr>
                                        <tr>
                                        	<th>Type</th>
                                        	<th>No.</th>
                                        	<th>License Ref No.</th>
                                        	<th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql_query = "SELECT vv.vv_id,vv_vehicleNo,code,vv_category,vv_brand,vv_model,vv_engine_no,vv_chasis_no,vv_bdm,
                                                    vv_btm,vv_capacity,vv_yearMade,vv_finance,vpr_type, vpr_no,vpr_license_ref_no,vpr_due_date, 
                                                    vv_remark FROM vehicle_vehicle vv
                                                    INNER JOIN company ON company.id = vv.company_id 
                                                    LEFT JOIN vehicle_permit vp ON vp.vv_id = vv.vv_id
                                                    WHERE vv.status='1'"; //only show active vehicle 
                                        
                                        if (!empty($select_c)) {
                                            $sql_query .= " AND company.id='$select_c'";
                                        }
                                        
                                        if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                            $count = 0;
                                            $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                while($row = mysqli_fetch_array($sql_result)){ 
                                                    $count++;
                                                    $category = itemName("SELECT vc_type FROM vehicle_category WHERE vc_id='".$row['vv_category']."'");
                                                    ?>
                                                    <tr>
                                                        <td><?=$count?>.</td>
                                                        <td><?=$row['vv_vehicleNo']?></td>
                                                        <td><?=$row['code']?></td>
                                                        <td><?=$category?></td>
                                                        <td><?=$row['vv_brand']?></td>
                                                        <td><?=$row['vv_model']?></td>
                                                        <td><?=$row['vv_engine_no']?></td>
                                                        <td><?=$row['vv_chasis_no']?></td>
                                                        <td><?=$row['vv_bdm']?></td>
                                                        <td><?=$row['vv_btm']?></td>
                                                        <td><?=$row['vv_capacity']?></td>
                                                        <td><?=$row['vv_yearMade']?></td>
                                                        <td><?=$row['vv_finance']?></td>
                                                        <td><?=$row['vpr_type']?></td>
                                                        <td><?=$row['vpr_no']?></td>
                                                        <td><?=$row['vpr_license_ref_no']?></td>
                                                        <td><?=($row['vpr_due_date'] == '0000-00-00') || empty($row['vpr_due_date']) ? "-" : dateFormatRev($row['vpr_due_date'])?></td>
                                                        <td><?=$row['vv_remark']?></td>
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
        <div id="editItem" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
<!--                 <div class="modal-header"> -->
<!--                     <h4 class="modal-title">Edit Vehicle</h4> -->
<!--                 </div> -->
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_form">
                        <input type="hidden" name="_token" value="">
                        <input type="hidden" id="vv_id" name="vv_id" value="">
                        <hr>
                        <h5 style="text-align: center"><strong>Vehicle</strong></h5>
                        <hr>
                            <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.</small></label>
                                            <input type="text" id="vehicle_reg_no" name="vehicle_reg_no" placeholder="Enter vehicle registration no." class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="category" class=" form-control-label"><small class="form-text text-muted">Vehicle Category</small></label>
                                            <?php
                                                $cat = mysqli_query ( $conn_admin_db, "SELECT vc_id, vc_type FROM vehicle_category");
                                                db_select ($cat, 'category', '','','-select-','form-control','');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="company" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                                db_select ($company, 'company', '','','-select-','form-control','');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="brand" class=" form-control-label"><small class="form-text text-muted">Make</small></label>
                                            <input type="text" id="brand" name="brand" placeholder="Enter vehicle brand" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="model" class=" form-control-label"><small class="form-text text-muted">Model</small></label>
                                            <input type="text" id="model" name="model" placeholder="Enter vehicle model" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="yearMade" class=" form-control-label"><small class="form-text text-muted">Year Made</small></label>
                                    		<input type="text" id="yearMade" name="yearMade" onkeypress="return isNumberKey(event)" placeholder="e.g 2010" class="form-control">
                                        </div>
                                    </div>                                    
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="engine_no" class=" form-control-label"><small class="form-text text-muted">Engine No.</small></label>
                                            <input type="text" id="engine_no" name="engine_no" placeholder="Enter engine no." class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="chasis_no" class=" form-control-label"><small class="form-text text-muted">Chasis No.</small></label>
                                            <input type="text" id="chasis_no" name="chasis_no" placeholder="Enter chasis no." class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="capacity" class=" form-control-label"><small class="form-text text-muted">Goods Capacity (CC)</small></label>
                                            <input type="text" id="capacity" name="capacity" class="form-control">
                                        </div>
                                    </div>      
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="bdm" class=" form-control-label"><small class="form-text text-muted">B.D.M/B.G.K</small></label>
                                            <input type="text" id="bdm" name="bdm" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="btm" class=" form-control-label"><small class="form-text text-muted">B.T.M</small></label>
                                            <input type="text" id="btm" name="btm" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="dispose" class=" form-control-label"><small class="form-text text-muted">Dispose</small></label>
                                            <input type="text" id="dispose" name="dispose" class="form-control">
                                        </div> 
                                    </div>  
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label for="driver" class=" form-control-label"><small class="form-text text-muted">Driver</small></label>
                                            <input type="text" id="driver" name="driver" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="finance" class=" form-control-label"><small class="form-text text-muted">Finance</small></label>
                                            <input type="text" id="finance" name="finance" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="finance" class="form-control-label"><small class="form-text text-muted">Vehicle Status</small></label>
                                            <select id="vehicle_status" name="" class="form-control">
                                              <option value="active">Active</option>
                                              <option value="inactive">Inactive</option>
                                              <option value="not_sure">Not Sure</option>
                                              <option value="total_loss">Total Loss</option>
                                            </select>
                                        </div>
                                    </div>                              
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-8">
                                            <label for="v_remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>                                             
                                            <textarea id="v_remark" name="v_remark" rows="3" class="form-control"></textarea>
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
						<hr>
                        <h5 style="text-align: center"><strong>LPKP Permit</strong></h5>
                        <hr>
                        <div class="form-group row col-sm-12">
                    		<div class="col-sm-6"> 
                                <label for="permit_type" class=" form-control-label"><small class="form-text text-muted">Type</small></label>
                                <input type="text" id="permit_type" name="permit_type" placeholder="Enter permit type" class="form-control">
                            </div>
							<div class="col-sm-6">                                        
                                <label for="permit_no" class=" form-control-label"><small class="form-text text-muted">No.</small></label>
                        		<input type="text" id="permit_no" name="permit_no" onkeypress="return isNumberKey(event)" class="form-control">
                        	</div>
                        </div>
                        
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-6"> 
                                <label for="license_ref_no" class=" form-control-label"><small class="form-text text-muted">License Ref No.</small></label>
                                <input type="text" id="license_ref_no" name="license_ref_no" placeholder="Enter license ref no." class="form-control">
                        	</div>
                        	<div class="col-sm-6"> 
                        		<label for="lpkp_permit_due_date" class=" form-control-label"><small class="form-text text-muted">Due Date</small></label>
                                <div class="input-group">
                                    <input id="lpkp_permit_due_date" name="lpkp_permit_due_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
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
        	"responsive": true
         });
        
        $(document).on('click', '.edit_data', function(){
        	var vehicle_id = $(this).attr("id");
        	$.ajax({
        			url:"vehicle.all.ajax.php",
        			method:"POST",
        			data:{action:'retrive_vehicle', vehicle_id:vehicle_id},
        			dataType:"json",
        			success:function(data){	
            			console.log(data);
            			//vehicle
        				$('#vv_id').val(data.vv_id);					
                        $('#vehicle_reg_no').val(data.vv_vehicleNo);  
                        $('#category').val(data.vv_category);  
                        $('#company').val(data.company_id);  
                        $('#brand').val(data.vv_brand);  
                        $('#model').val(data.vv_model);  
                        $('#v_remark').val(data.vv_remark);  
                        $('#yearMade').val(data.vv_yearMade);    
                        $('#capacity').val(data.vv_capacity);  
                        $('#chasis_no').val(data.vv_chasis_no);  
                        $('#engine_no').val(data.vv_engine_no);  
                        $('#driver').val(data.vv_driver);  
                        $('#finance').val(data.vv_finance);                          
                        $('#dispose').val(data.vv_disposed);  
                        $('#btm').val(data.vv_btm);  
                        $('#bdm').val(data.vv_bdm);  
                        $('#vehicle_status').val(data.vv_status);  

                        //permit
                        var vpr_due_date = data.vpr_due_date != null ? dateFormat(data.vpr_due_date) : "";
                        $('#permit_type').val(data.vpr_type);
                        $('#permit_no').val(data.vpr_no);
                        $('#license_ref_no').val(data.vpr_license_ref_no);
                        $('#lpkp_permit_due_date').val(vpr_due_date);
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

        $('#lpkp_permit_due_date').datepicker({
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
        var tab_text="<table border='1px'><tr>";
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
