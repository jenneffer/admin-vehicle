<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
// 	session_start();
// 	global $conn_admin_db;
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
                                <strong class="card-title">Add Supplier</strong>
                            </div>
                            <form id="supplier_form" role="form" action="" method="post">
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="supplier_name" class=" form-control-label"><small class="form-text text-muted">Supplier Name</small></label>
                                            <input type="text" id="supplier_name" name="supplier_name" placeholder="Enter supplier name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="supplier_contact_no" class=" form-control-label"><small class="form-text text-muted">Supplier Contact Name</small></label>
                                            <input type="text" id="supplier_contact_person" name="supplier_contact_person" placeholder="Enter supplier contact name" class="form-control">
                                        </div>                                        
                                    </div>
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6">
                                            <label for="supplier_contact_person" class=" form-control-label"><small class="form-text text-muted">Supplier Contact Number</small></label>
                                            <input type="text" id="supplier_contact_no" name="supplier_contact_no" placeholder="Enter supplier contact number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="supplier_address" class=" form-control-label"><small class="form-text text-muted">Address</small></label>
                                            <textarea id="supplier_address" name="supplier_address" placeholder="Enter supplier address" class="form-control" rows="3"></textarea>
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
    	//insert data
        $('#supplier_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#supplier_name').val() == ""){  
                 alert("Supplier name is required");  
            }  
            else if($('#supplier_contact_person').val() == ''){  
                 alert("Supplier contact person is required");  
            }  
            else if($('#supplier_contact_no').val() == ''){  
                 alert("Supplier contact number is required");  
            }  
            else if($('#supplier_address').val() == ''){  
                 alert("Supplier address is required");  
            }          
            else{  
                 $.ajax({  
                      url:"function.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_supplier', data : $('#supplier_form').serialize()},  
                      success:function(data){ 
                          location.reload();                                                        	 
                      }  
                 });  
            }  
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
