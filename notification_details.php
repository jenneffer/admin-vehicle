<?php 
require_once('assets/config/database.php');
require_once('function.php');
require_once('check_login.php');
global $conn_admin_db;
$id = $_GET['id'];//permit_id
//get the vehicle id of a permit
$vehicle_id = itemName("SELECT vv_id FROM vehicle_permit WHERE vpr_id='$id'");
$system_id = $_SESSION['system_id'];
$table = '';
switch ($system_id) {
    case '1':
        $table = vehicle_details($id);
        break;
    
    case '2':
        break;
        
    case '3':
        $table = fireextinguisher_details($id);
        break;
        
    default:
    break;
    
    return $table;
}

function fireextinguisher_details($id){
    global $conn_admin_db;
    $data = array();
    $query = "SELECT * FROM fe_master_listing 
            INNER JOIN fe_location ON fe_location.location_id = fe_master_listing.location_id
            INNER JOIN company ON company.id = fe_master_listing.company_id
            INNER JOIN fe_person_incharge ON fe_person_incharge.pic_id = fe_master_listing.person_incharge_id
            WHERE fe_master_listing.id='$id'";
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc( $rst );
    
    $serial_no = $row['serial_no'];
    $location_name = $row['location_name'];
    $company_name = $row['name'];
    $pic_name = $row['pic_name'];
    $pic_contact = $row['pic_contactNo'];
    $expiry_date = $row['expiry_date'];
    
    $table = '<tr>
                <td>Company</td>
                <td>'.$company_name.'</td>
              </tr>
              <tr>
                <td>Location</td>
                <td>'.$location_name.'</td>
              </tr>
              <tr>
                <td>Serial No.</td>
                <td>'.$serial_no.'</td>
              </tr>
              <tr>
                <td>Person in charge</td>
                <td>'.$pic_name.'</td>
              </tr>
              <tr>
                <td>Contact No.</td>
                <td>'.$pic_contact.'</td>
              </tr>
              <tr>
                <td>Expiry Date</td>
                <td>'.dateFormatRev($expiry_date).'</td>
              </tr>';
    
    return $table;
    
}

function vehicle_details($permit_id){
    global $conn_admin_db;
    $query = "SELECT vpr_id, vehicle_vehicle.vv_id, vpr_no, vpr_type, vpr_license_ref_no, vpr_due_date, vv_vehicleNo,
        (SELECT CODE FROM company WHERE id = vehicle_vehicle.company_id) AS company_code,
        (SELECT name FROM company WHERE id = vehicle_vehicle.company_id) AS company_name FROM vehicle_permit
        LEFT JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_permit.vv_id
        WHERE vpr_id = '$permit_id'";
    
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_assoc( $rst );
    
    $company_name = $row['company_name'];    
    $vehicle_no = $row['vv_vehicleNo'];
    $permit_type = $row['vpr_type'];
    $permit_no = $row['vpr_no'];
    $permit_ref_no = $row['vpr_license_ref_no'];
    $due_date = $row['vpr_due_date'];
    
    $table = '<tr>
                <td>Company</td>
                <td>'.$company_name.'</td>
              </tr>
              <tr>
                <td>Vehicle Registration No.</td>
                <td>'.$vehicle_no.'</td>
              </tr>
              <tr>
                <td>Permit Type</td>
                <td>'.$permit_type.'</td>
              </tr>
              <tr>
                <td>Permit No.</td>
                <td>'.$permit_no.'</td>
              </tr>
              <tr>
                <td>License Ref. No.</td>
                <td>'.$permit_ref_no.'</td>
              </tr>
              <tr>
                <td>Permit Due Date</td>
                <td>'.dateFormatRev($due_date).'</td>
              </tr>';
    
    return $table;
}

// var_dump($data);

?>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<?php require_once('allCSS.php')?>
</head>
<body>
<br>
<h4 style="text-align: center;">Notification Details</h4>
<br>
<table style="width:80%;" align="center">
<!--   <tr> -->
<!--     <th>Company</th> -->
<!--     <th>Contact</th> -->
<!--     <th>Country</th> -->
<!--   </tr> -->

  <?=$table?>
</table>
<br>
<div class="text-center">
	<button class="btn btn-primary btn_close">Close</button>
	<button class="btn btn-success btn_renew" id="<?=$vehicle_id?>" data-toggle="modal" class="add_data" data-target="#addPermit">Renew Permit</button>
</div>

<!-- Modal edit vehicle  -->
    <div id="addPermit" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Permit</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="" id="permit_new_form">
                    <input type="hidden" name="_token" value="">
                    <input type="hidden" id="vv_id" name="vv_id" value="">   
                    <input type="hidden" id="vpr_id" name="vpr_id" value="<?=$id;?>">   
                    <div class="form-group row col-sm-12">
                    	<div class="col-sm-6"> 
                            <label for="permit_type" class=" form-control-label"><small class="form-text text-muted">Vehicle No.</small></label>
                            <input type="text" id="vehicle_no" name="vehicle_no" class="form-control" readonly>
                        </div>
                    </div>                 
                    <div class="form-group row col-sm-12">
                		<div class="col-sm-6"> 
                            <label for="permit_type" class=" form-control-label"><small class="form-text text-muted">Type</small></label>
                            <input type="text" id="permit_type" name="permit_type" placeholder="Enter permit type" class="form-control">
                        </div>
						<div class="col-sm-6">                                        
                            <label for="permit_no" class=" form-control-label"><small class="form-text text-muted">Permit No.</small></label>
                    		<input type="text" id="permit_no" name="permit_no" placeholder="Enter permit number" onkeypress="return isNumberKey(event)" class="form-control">
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
                        <button type="submit" class="btn btn-primary add_new_permit">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- link to the script-->
<?php require_once ('allScript.php')?>
<!-- Datatables -->
<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/jszip.min.js"></script>
<script src="assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="assets/js/init/datatables-init.js"></script>
<script src="assets/js/script/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_close').on("click", function(event){  
		window.close();
	});

	//open modal to enter new details
    $(document).on('click', '.btn_renew', function(){
    	var vehicle_id = $(this).attr("id");
    	$.ajax({
    			url:"vehicle/vehicle.all.ajax.php",
    			method:"POST",
    			data:{action:'retrive_vehicle', vehicle_id:vehicle_id},
    			dataType:"json",
    			success:function(data){	
        			console.log(data);
        			//vehicle
    				$('#vv_id').val(data.vv_id);					
                    $('#vehicle_no').val(data.vv_vehicleNo);                      
                    $('#addPermit').modal('show');
                    //permit
//                     var vpr_due_date = data.vpr_due_date != null ? dateFormat(data.vpr_due_date) : "";
//                     $('#permit_type').val(data.vpr_type);
//                     $('#permit_no').val(data.vpr_no);
//                     $('#license_ref_no').val(data.vpr_license_ref_no);
//                     $('#lpkp_permit_due_date').val(vpr_due_date);
                    
    			}
    		});
    });
    $('#permit_new_form').on("submit", function(event){  
        event.preventDefault();  
        if($('#permit_type').val() == ''){  
             alert("Permit type is required");  
        }  
        else if($('#permit_no').val() == ''){  
             alert("Permit number is required");  
        }  
        else if($('#license_ref_no').val() == ''){  
             alert("License reference number is required");  
        }  
        else if($('#lpkp_permit_due_date').val() == ''){  
             alert("Permit due date is required");  
        }     
        else{  
             $.ajax({  
                  url:"vehicle/vehicle.all.ajax.php",  
                  method:"POST",  
                  data:{action:'add_new_permit', data: $('#permit_new_form').serialize()},  
                  success:function(data){   
                       $('#addPermit').modal('hide');  
                       $('#bootstrap-data-table').html(data);
                       location.reload();  
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
</script>
</body>
</html>