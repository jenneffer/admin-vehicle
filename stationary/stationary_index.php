<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Stationary</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- link to css -->
	<?php include('../allCSS1.php')?>	
   <style>
    .myDiv {
      border: 5px outset #ffc107;
      background-color: lightblue;    
      text-align: center;
      padding:10px;      
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
                <div class="row" >
                    <div class="col-md-12">
                    	<div class="form-group col-sm-12 text-center myDiv">
                    		<h2>Welcome to</h2>
                    		<h2>Stationary Information System</h2>
                    	</div>                        
                        <div class="form-group row col-sm-12 text-center">
                            <div class="col-sm-2">&nbsp;</div>
                            <div class="col-sm-8">
                            	A system to keep track on the stationary stock movement. This system ease in monitoring the stock balance.
                            </div>
                            <div class="col-sm-2">&nbsp;</div>
                        </div>  
                        <div class="form-group col-sm-12 text-center color-red">  
                        	<div>*** Check the descriptions of each menu below for your reference:- ***</div>         
                        </div>
                        <div class="form-group col-sm-12 text-center">                      
                            <div><b>LISTING</b></div>
                            <div>To view the list of data entered for DEPARTMENT and ITEM. Able to ADD, and UPDATE data.</div>
                        </div>
                        <div class="form-group col-sm-12 text-center">                      
                            <div><b>ANALYSIS</b></div>
                            <div>To view the analysis of item usage by item and department and also the stock take summary.</div>
                        </div>
                        <div class="form-group col-sm-12 text-center">                      
                            <div><b>STOCK</b></div>
                            <div>To view the list of data entered for STOCK IN and STOCK OUT. Able to ADD, and UPDATE data.</div>
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

	
});
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