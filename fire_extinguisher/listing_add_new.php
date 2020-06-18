<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;
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
//     }
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
                                <strong class="card-title">Add New Fire Extinguisher</strong>
                            </div>
                            <form id="fire_extinguisher" role="form" action="" method="post">
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                		<div class="col-sm-4">
                                            <label for="model" class=" form-control-label"><small class="form-text text-muted">Model</small></label>
                                            <input type="text" id="model" name="model" placeholder="Enter model name" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="serial_no" class=" form-control-label"><small class="form-text text-muted">Serial No.</small></label>
                                            <input type="text" id="serial_no" name="serial_no" placeholder="Enter serial number" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="expiry_date" class="form-control-label"><small class="form-text text-muted">Expiry date</small></label>
                                            <div class="input-group">
                                                <input id="expiry_date" name="expiry_date" class="form-control" autocomplete="off">
                                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>                                            
                                        </div>                                        
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label class="control-label "><small class="form-text text-muted">Company</small></label>                                  
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                                db_select ($company, 'company', '','','-select-','form-control','');
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label"><small class="form-text text-muted">Location</small></label>
                                            <div class="input-group">
                                                <?php
                                                $location = mysqli_query ( $conn_admin_db, "SELECT location_id, location_name FROM fe_location");
                                                db_select ($location, 'location', '','','-select-','form-control','');
                                            ?>
<!--                                             <div class="input-group-addon" data-toggle="modal" data-target="#add_new_location"><i class="fas fa-plus-circle"></i></div>  -->
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6">
                                            <label class="control-label"><small class="form-text text-muted">Person in charge</small></label>
                                             <div class="input-group">
                                                <?php
                                                $pic = mysqli_query ( $conn_admin_db, "SELECT pic_id, pic_name FROM fe_person_incharge");
                                                db_select ($pic, 'pic', '','','-select-','form-control','');
                                            ?>
<!--                                             <div class="input-group-addon add_new_pic" data-toggle="modal" data-target="#add_new_pic"><i class="fas fa-plus-circle"></i></div>  -->
                                            </div>
                                        </div>                                         
                                    </div>                                    
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6">
                                            <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                                            <textarea id="remark" name="remark" placeholder="Enter remark" class="form-control" rows="3"></textarea>
                                        </div>
                                        
                                    </div>                                    
                                    <div class="card-body">
                                        <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                                        <button type="button" id="cancel" name="cancel" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        
        <!-- Modal add new location -->
        <div id="add_new_location" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Location</h4>
                </div>
                <div class="modal-body">
                    <form id="location_form" role="form" action="" method="post">
                        <div class="card-body card-block">
                        	<div class="form-group row col-sm-12">
                                <div class="col-sm-6">
                                    <label for="location_code" class=" form-control-label"><small class="form-text text-muted">Location Code</small></label>
                                    <input type="text" id="location_code" name="location_code" placeholder="Enter location code" class="form-control">
                                </div> 
                                <div class="col-sm-6">
                                    <label for="location_name" class="form-control-label"><small class="form-text text-muted">Location Name</small></label>
                                    <input type="text" id="location_name" name="location_name" placeholder="Enter location name" class="form-control">                                          
                                </div>                                                                                 
                            </div>                                                                                
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                            <button type="button" id="cancel" name="cancel" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!-- Modal add new pic -->
        <div id="add_new_pic" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Person in charge</h4>
                </div>
                <div class="modal-body">
                    <form id="pic_form" role="form" action="" method="post">
                        <div class="card-body card-block">
                        	<div class="form-group row col-sm-12">
                                <div class="col-sm-6">
                                    <label for="pic_name" class=" form-control-label"><small class="form-text text-muted">Name</small></label>
                                    <input type="text" id="pic_name" name="pic_name" placeholder="Enter person in charge name" class="form-control">
                                </div>  
                                <div class="col-sm-6">
                                    <label for="pic_contact" class="form-control-label"><small class="form-text text-muted">Contact No.</small></label>
                                    <input type="text" id="pic_contact" name="pic_contact" placeholder="Enter person in charge contact number" class="form-control">                                          
                                </div>                                                                               
                            </div>                                                                                                          
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                            <button type="button" id="cancel" name="cancel" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
        <div class="clearfix"></div>
        <!-- Footer -->
        <?PHP include('../footer.php')?>
        <!-- /.site-footer -->
    <!-- from right panel page -->
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
    	var select2 = $("#company").select2({
    	    selectOnClose: true
        });
    	select2.data('select2').$selection.css('height', '38px');
    	select2.data('select2').$selection.css('border', '1px solid #ced4da');

        $('#fire_extinguisher').on("submit", function(event){  
            event.preventDefault();  
            if($('#serial_no').val() == ""){  
                 alert("Serial number is required");  
            }  
            else if($('#expiry_date').val() == ''){  
                 alert("Expiry date is required");  
            }  
            else if($('#company').val() == ''){  
                 alert("Company is required");  
            }  
            else if($('#supplier').val() == ''){  
                 alert("Supplier is required");  
            }  
            else if($('#requisition_no').val() == ""){  
                alert("Requisition number is required");  
           }  
           else if($('#invoice_no').val() == ''){  
                alert("Invoice number is required");  
           }               
           else if($('#location').val() == ''){  
                alert("Location is required");  
           }        
            else{  
                 $.ajax({  
                      url:"function.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_listing', data : $('#fire_extinguisher').serialize()},  
                      success:function(data){ 
                          location.reload();                                                        	 
                      }  
                 });  
            }  
        });

        $('#expiry_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });

        $(document).on('click', '.add_new_pic', function(){
        	$('#add_new_pic').modal('show');
        });
        
        $(document).on('click', '.add_new_location', function(){
        	$('#add_new_location').modal('show');
        });

		//add new location
        $('#location_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#location_code').val() == ""){  
                 alert("Location code is required");  
            }  
            else if($('#location_name').val() == ''){  
                 alert("Location name is required");  
            }                       
            else{  
            	submit_new_location();
            	$("#location_form").modal('hide');
            }  
       });

      //add new pic
        $('#pic_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#pic_name').val() == ""){  
                 alert("Person in charge name is required");  
            }  
            else if($('#pic_contact').val() == ''){  
                 alert("Contact number is required");  
            }                       
            else{  
                $.ajax({  
                    url:"function.ajax.php",  
                    method:"POST",  
                    data:{action:'add_new_pic', data : $('#pic_form').serialize()},  
                    success:function(data){ 
                    	$('#add_new_pic').modal('hide');                                                 	 
                    }  
               });  
            }  
       });


        
    });

    function submit_new_location(){
    	 $.ajax({  
             url:"function.ajax.php",  
             method:"POST",  
             data:{action:'add_new_location', data : $('#location_form').serialize()},  
             success:function(data){ 
             	$('#add_new_location').modal('hide');    
             	return false;                                          	 
             }  
        });  
    }
    
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

    function filterFunction() {
      	var input, filter, ul, li, a, i;
      	input = document.getElementById("myInput");
      	filter = input.value.toUpperCase();
      	div = document.getElementById("myDropdown");
      	a = div.getElementsByTagName("a");
      	for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
            } else {
              a[i].style.display = "none";
            }
        }
    }
  </script>
</body>
</html>
