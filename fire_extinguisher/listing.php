<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');
	require_once('../check_login.php');
	global $conn_admin_db;
	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-01-Y');
	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-12-Y');
	$status = isset($_POST['status']) ? $_POST['status'] : "";
	$select_pic = isset($_POST['person_incharge']) ? $_POST['person_incharge'] : "";
	$select_company = isset($_POST['company']) ? $_POST['company'] : "";
	
	$arr_status = array(
	    '0' => 'All',
	    '1' => 'Active',
	    '2' => 'Expired',
	);
	
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
        .select2-selection__rendered {
          margin: 5px;
        }
        .select2-selection__arrow {
          margin: 5px;
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
                            <div class="card-body">
                            <form id="myform" enctype="multipart/form-data" method="post" action="">       
                            	<div class="form-group row col-sm-12">       
                                	<div class="col-sm-3">
                                        <label for="company" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                                        <div>
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE status='1' ORDER BY name");
                                                db_select ($company, 'company', $select_company,'submit()','-select-','form-control form-control-sm','');
                                            ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-2">
                                        <label for="person_incharge" class=" form-control-label"><small class="form-text text-muted">Person incharge</small></label>
                                        <div>
                                            <?php
                                                $pic = mysqli_query ( $conn_admin_db, "SELECT pic_id, UPPER(pic_name) FROM fe_person_incharge");
                                                db_select ($pic, 'person_incharge', $select_pic,'submit()','-select-','form-control form-control-sm','');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                        <div class="input-group">
                                          <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">                                          
                                        </div>                            
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                        <div class="input-group">
                                        <input type="text" id="date_end" name="date_end" class="form-control form-control-sm" value="<?=$date_end?>" autocomplete="off">                                          
                                        </div>                             
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="status" class="form-control-label"><small class="form-text text-muted">Status</small></label>
                                        <select name="status" id="status" class="form-control form-control-sm">
                                        	<?php foreach($arr_status as $key => $value) {
                                        	    
                                        	    $selected = ($status == $key) ? 'selected' : '';
                                        	    echo "<option value='$key' $selected>$value</option>";
                                        	}?>
                                        </select>                              
                                    </div>
                                    <div class="col-sm-1">                                    	
                                    	<button type="submit" class="btn btn-sm btn-primary button_search ">Submit</button>
                                    </div>
                            	</div> 	                                   	               
                            </form>
                            </div>
                            <hr>
                            <div class="card-body"  id="printableArea">
                                <table id="master_listing" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Model</th>
											<th>Company</th>
											<th>Location</th>
											<th>Person incharge</th>                                            
                                            <th>Serial No.</th>											
											<th>Expiry Date</th>
											<th>Status</th>
											<th>Remark</th>											
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
        <!-- Modal update expiry date -->
        <div id="updateRenewal" class="modal fade">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Renewal Date</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="" id="update_renewal_date">                        
                        <input type="hidden" id="fe_id" name="fe_id" value="">
                        <div class="form-group row col-sm-12">                            
                            <div class="col-sm-12">
                                <label for="expiry_date" class="form-control-label"><small class="form-text text-muted">New Date</small></label>
                                <div class="input-group">
                                    <input id="new_date" name="new_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>                                            
                            </div>                                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary update_renewal_date ">Update</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
        <!-- Modal edit master listing  -->
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
                                <label for="model" class=" form-control-label"><small class="form-text text-muted">Model</small></label>
                                <div>
                                    <?php
                                        $model = mysqli_query ( $conn_admin_db, "SELECT id, name FROM fe_model");
                                        db_select ($model, 'model', '','','-select-','form-control','');
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="insurance_status" class=" form-control-label"><small class="form-text text-muted">Status</small></label>
                                <select name="fe_status" id="fe_status" class="form-control">                                    
                                    <option value="1">Active</option>
                                    <option value="2">Expired</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row col-sm-12">
                            <div class="col-sm-6">
                                <label class="control-label"><small class="form-text text-muted">Company</small></label>
                                <div>
                                    <?php
                                        $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                        db_select ($company, 'company_edit','','','-select-','form-control','');
                                    ?>
                                </div>
                            </div> 
                            <div class="col-sm-6">
                                <label class="control-label"><small class="form-text text-muted">Person in charge</small></label>
                                 <div class="input-group">
                                    <?php
                                    $pic = mysqli_query ( $conn_admin_db, "SELECT pic_id, pic_name FROM fe_person_incharge");
                                    db_select ($pic, 'pic', '','','-select-','form-control','');
                                ?>
                                </div>
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
                                        $location = mysqli_query ( $conn_admin_db, "SELECT location_id, location_name FROM fe_location");
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
    <script src="../assets/js/select2.min.js"></script>

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
         	"bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,  	
            "ajax":{
                "url": "function.ajax.php",    
                "type":"POST",       	
                "data" : function ( data ) {  
                    data.action = 'master_listing';	
                    data.date_start = '<?=$date_start?>';
                    data.date_end = '<?=$date_end?>';		
                    data.fe_status = '<?=$status?>';
                    data.company = '<?=$select_company?>';
                    data.pic = '<?=$select_pic?>';	
       	        }
       	    },
       		"rowCallback": function(row, data, index){
       			var new_date = dateFormatRev(data[6]);
       			var numDays = calcDay( new Date(), new_date);
       		    if(numDays <= 30){
       		    	$(row).css('background-color', '#f4bebe');
//        		    	$(row).css('color', 'white');       		    	
       		    }
//        		    if(data[7] == "Active"){
//        		    	$(row).css('background-color', 'green');
//        		    	$(row).css('color', 'white');
//            		}
       		  }
   	     });

      	//retrieve data
        $(document).on('click', '.edit_data', function(){
			var id = $(this).attr("id");
			$.ajax({
					url:"function.ajax.php",
					method:"POST",
					data:{action:'retrieve_listing', id:id},
					dataType:"json",
					success:function(data){	
						console.log(data);
                        var expiryDate = dateFormat(data.expiry_date);                       
                        $('#id').val(id);					
                        $('#model').val(data.model_id);  
                        $('#expiry_date').val(expiryDate);   
                        $('#serial_no').val(data.serial_no);    
                        $('#remark').val(data.remark); 
                        $('#status').val(data.status); 
                        $('#location').val(data.location_id); 
                        $('#company_edit').val(data.company_id); 
                        $('#pic').val(data.person_incharge_id);   
//                         $('#fe_status').val(data.fe_status);                       
                        $('#editItem').modal('show');
	  				}
				});
      });
        $(document).on('click', '.update_date', function(){
        	var fe_id = $(this).attr("id");
        	$('#update_renewal_date').data('id', fe_id); 
        });

      //delete records
      $(document).on('click', '.delete_data', function(){
      	var vp_id = $(this).attr("id");
      	$('#delete_record').data('id', vp_id); //set the data attribute on the modal button
      
      });
  	
      $( "#delete_record" ).click( function() {
      	var ID = $(this).data('id');
      	alert(ID);
      	$.ajax({
      		url:"function.ajax.php",
      		method:"POST",    
      		data:{action:'delete_listing', id:ID},
      		success:function(data){	  						
      			$('#deleteItem').modal('hide');		
      			location.reload();		
      		}
      	});
      });
      
		//update form
      $('#update_form').on("submit", function(event){  
          event.preventDefault();  
          if($('#serial_no').val() == ""){  
               alert("Serial number is required");  
          }  
          else if($('#expiry_date').val() == ''){  
               alert("Expiry date is required");  
          }  
          else if($('#company_edit').val() == ''){  
               alert("Company is required");  
          }  
          else if($('#pic').val() == ''){  
               alert("Person in charge is required");  
          }  
          else if($('#location').val() == ''){  
              alert("Location is required");  
          }         
          else{  
               $.ajax({  
                    url:"function.ajax.php",  
                    method:"POST",  
                    data:{action:'update_master_listing', data : $('#update_form').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data); 
                         location.reload();		 
                    }  
               });  
          }  
     }); 
		//update renewal date
      $('#update_renewal_date').on("submit", function(event){  
    	  var ID = $(this).data('id');
    	  $('#fe_id').val(ID);
          event.preventDefault();            
          if($('#new_date').val() == ""){  
               alert("Date is required");  
          }                     
          else{  
               $.ajax({  
                    url:"function.ajax.php",  
                    method:"POST",  
                    data:{action:'update_renewal_date', data : $('#update_renewal_date').serialize()},  
                    success:function(data){   
                         $('#editItem').modal('hide');  
                         $('#bootstrap-data-table').html(data); 
                         location.reload();		 
                    }  
               });  
          }  
     }); 
      
     $( ".button_search" ).click(function( event ) {
  		table.clear();
  		table.ajax.reload();
  		table.draw();  		
  		});	

     $('#expiry_date, #date_start, #date_end, #new_date').datepicker({
         format: "dd-mm-yyyy",
         autoclose: true,
         orientation: "top left",
         todayHighlight: true
     });
    });

    //format to dd-mm-yy
    function dateFormat(dates){
        var date = new Date(dates);
    	var day = date.getDate();
	  	var monthIndex = date.getMonth()+1;
	  	var year = date.getFullYear();

	  	return (day <= 9 ? '0' + day : day) + '-' + (monthIndex<=9 ? '0' + monthIndex : monthIndex) + '-' + year ;
    }
    //yy-mm-dd
    function dateFormatRev(dates){
        var date = dates.split("-");
        var day = date[0];
        var month = date[1];
        var year = date[2];

        return year + '-' + month + '-' + day ;
    }

    //calculate date  difference between current date and renewal date
	function calcDay( current_date, renewal_date ){
        var renewal_date = new Date(renewal_date);
        var millisecondsPerDay = 1000 * 60 * 60 * 24;

        var millisBetween = renewal_date.getTime() - current_date.getTime();
        var days = Math.floor(millisBetween / millisecondsPerDay);

        return days;
    }
	
  </script>
</body>
<style>
 #printableArea{ 
     font-size:14px; 
     margin:0px; 
     padding:.5rem; 
} 
</style>
</html>
