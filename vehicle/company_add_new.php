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
                                <strong class="card-title">Add New Company</strong>
                            </div>
                            <form id="company_form" role="form" action="" method="post">
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                        <div class="col-sm-6">
                                            <label for="company_code" class=" form-control-label"><small class="form-text text-muted">Company Code</small></label>
                                            <input type="text" id="company_code" name="company_code" placeholder="Enter company code" class="form-control">
                                        </div>                                                                                
                                    </div>      
                                    <div class="form-group row col-sm-12">              
                                    	<div class="col-sm-6">
                                            <label for="company_name" class="form-control-label"><small class="form-text text-muted">Company Name</small></label>
                                            <input type="text" id="company_name" name="company_name" placeholder="Enter company name" class="form-control">                                          
                                        </div>     
                                    </div>   
                                    <div class="form-group row col-sm-12">              
                                    	<div class="col-sm-6">
                                            <label for="company_reg_no" class="form-control-label"><small class="form-text text-muted">Company Reg. No.</small></label>
                                            <input type="text" id="company_reg_no" name="company_reg_no" placeholder="Enter company registration no." class="form-control">                                          
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

        $('#company_form').on("submit", function(event){  
            event.preventDefault();  
            if($('#company_code').val() == ""){  
                 alert("Company code is required");  
            }  
            else if($('#company_name').val() == ''){  
                 alert("Company name is required");  
            } 
            else if($('#company_reg_no').val() == ''){  
                alert("Company registration number is required");  
           	}                     
            else{  
                 $.ajax({  
                      url:"company.ajax.php",  
                      method:"POST",  
                      data:{action:'add_new_company', data : $('#company_form').serialize()},  
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
