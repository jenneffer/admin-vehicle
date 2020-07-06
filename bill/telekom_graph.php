<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "year";
$select_company = isset($_POST['company']) ? $_POST['company'] : "";
ob_start();
selectYear('year_select',$year_select,'','','form-control','','');
$html_year_select = ob_get_clean();

$arr_report_type = array(
    "year" => "Yearly",
    "month" => "Monthly"
);

//initialise monthly value
$month_map = array(
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
    9 => 0,
    10 => 0,
    11 => 0,
    12 => 0
);

$month = array(
    1=> "Jan",
    2=> "Feb",
    3=> "Mar",
    4=> "Apr",
    5=> "May",
    6=> "Jun",
    7=> "Jul",
    8=> "Aug",
    9=> "Sep",
    10=> "Oct",
    11=> "Nov",
    12=> "Dec"
);

$month_str = implode("','", $month);

function get_telekom_data_yearly($year){
    
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
        .hide{
            display:none
        }
        .button_search{
            position: absolute;
            left:    0;
            bottom:   0;
        }
    </style>
</head>

<body>
    <!--Left Panel -->
	<?php  include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <!-- /#header -->
    <!-- /#header -->
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">Telekom</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
									<div class="form-group row col-sm-12">
										<div class="col-sm-2">
                    						<label for="report_type" class="form-control-label"><small class="form-text text-muted">Report Type</small></label>
                    						<select name="report_type" id="report_type" class="form-control" onchange="this.form.submit()">
                    						<?php foreach ($arr_report_type as $key => $rt){						
                    						    $selected = ($key == $report_type) ? 'selected' : '';						    
                    						    echo "<option $selected value='$key'>".$rt."</option>";
                                            }?>
                                            </select>
                    					</div>
                                        <div class="col-sm-2">
                                        	<label for="acc_no" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                                        	<?=$html_year_select;?>
                                        </div>
                                        <div class="col-sm-4 monthly-div">
                                    		<label for="company" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                                    		<?php                                            
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE status='1' ORDER BY name ASC");
                                                db_select ($company, 'company',$select_company,'submit()','','form-control','');
                                            ?>
                                    	</div>
                                        <div class="col-sm-4">                                    	
                                        	<button type="submit" class="btn btn-primary button_search ">Submit</button>
                                        </div>
                                     </div>
                                </form>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 telekom-yearly">            	
                                        <div class="card">                	
                                            <div class="card-body">                        
                                                <canvas id="sesb-yearly"></canvas>                        
                                            </div>
                                        </div>
                                    </div>           
                                    <div class="col-sm-12 telekom-monthly">            	
                                        <div class="card">                	
                                            <div class="card-body">                        
                                                <canvas id="sesb-monthly"></canvas>                        
                                            </div>
                                        </div>
                                    </div>     
                        		</div> 
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
    var company_name = '<?=$company_name;?>';
    var year = '<?=$year_select;?>';          
    var report_type = '<?=$report_type?>';

    $('.monthly-div').hide();                    
	$('.telekom-yearly').show();
	$('.telekom-monthly').hide();
    if(report_type == 'month'){   
	    $('.monthly-div').show();
	    $('.telekom-monthly').show();
	    $('.telekom-yearly').hide();
    }
});
</script>
</body>
</html>
