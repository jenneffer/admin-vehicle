<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$arr_item_unit = array(
    'pieces' => 'Pieces',
    'packet' => 'Packet',
    'box' => 'Box'
);

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
                                <strong class="card-title">Add New User</strong>
                            </div>     
                           <div class="card-body">
                           	<form action="add_user_process.php" method="post">
                                <div class="card-body card-block">
                                	<div class="form-group row col-sm-12">
                                		<div class="col-sm-6">
                                            <label for="name" class=" form-control-label"><small class="form-text text-muted">Name</small></label>
                                            <input type="text" id="name" name="name" placeholder="Enter name" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="username" class=" form-control-label"><small class="form-text text-muted">Username</small></label>
                                            <input type="text" id="username" name="username" placeholder="Enter username" class="form-control">
                                        </div>                    
                                    </div>
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-6">
                                            <label for="password" class=" form-control-label"><small class="form-text text-muted">Password</small></label>
                                            <input type="text" id="password" name="password" placeholder="Enter password" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email" class=" form-control-label"><small class="form-text text-muted">Email</small></label>
                                            <input type="text" id="email" name="email" placeholder="Enter email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="col col-md-1"><label class=" form-control-label"><strong>Access</strong></label></div>
                                        <!-- Populate the checkbox based on the module/system in the database -->
                                        <?php 
                                        $query = "SELECT * FROM admin_system";
                                        $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
                                        while($row = mysqli_fetch_assoc($sql_result)){?>
                                              <div class="form-check form-group col-sm-12">
                                                <input type="checkbox" class="form-check-input" name="system[]" value="<?=$row['sid'];?>">
                                                <label class="form-check-label"><?=$row['sname']?></label>
                                              </div>
                                        <?php }
                                        ?>
                                        
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
