<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
	session_start();
	global $conn_admin_db;
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
	<?php  //include('../assets/nav/leftNav.php')?>
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
                                    <div class="card-body">
                                        <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                                        <button type="button" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
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
	<script type="text/javascript">
    $(document).ready(function() {

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
  </script>
</body>
</html>
