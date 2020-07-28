<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "year";
$select_company = isset($_POST['company']) ? $_POST['company'] : "";
$select_acc = isset($_POST['account_no']) ? $_POST['account_no'] : "";
ob_start();
selectYear('year_select',$year_select,'submit()','','form-control form-control-sm','','');
$html_year_select = ob_get_clean();

$arr_report_type = array(
    "year" => "Yearly",
    "month" => "Monthly",
    "comparison" => "Comparison"
);

$comp_name = itemName("SELECT UPPER(name) FROM company WHERE id='".$select_company."'");

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
    global $conn_admin_db;
    
    $query = "SELECT * FROM bill_telekom_account
        INNER JOIN bill_telekom ON bill_telekom_account.id = bill_telekom.acc_id
        WHERE YEAR(date_end)='$year'";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        $data[$row['company_id']][] = array(
            'telekom_data' => $row['amount']
        );
    }
    
    $datasets_telekom_yearly = [];
    foreach ($data as $key => $value) {
        $code = itemName("SELECT code FROM company WHERE id='$key'");
        $company[] = $code;
        foreach ($value as $val) {
            if(isset($datasets_telekom_yearly[$key])){
                $datasets_telekom_yearly[$key] += $val['telekom_data'];
            }else{
                $datasets_telekom_yearly[$key] = $val['telekom_data'];
            }
        }
    }
    return array(
        'telekom_yearly' => $datasets_telekom_yearly,
        'company_str' => $company
    );
    
}

function get_telekom_data_monthly($year, $company, $account_no){
    global $conn_admin_db;
    global $month_map;
    
    $query = "SELECT * FROM bill_telekom_account
        INNER JOIN bill_telekom ON bill_telekom_account.id = bill_telekom.acc_id
        WHERE YEAR(date_end)='$year' AND status='1'";
    
    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    if(!empty($account_no)){
        $query .=" AND bill_telekom_account.id = '$account_no'";
    }
    
    $query .= " ORDER BY date_end ASC";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_telekom = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_telekom[$row['company_id']][] = $row;
    }
    
    //form array data for telekom monthly
    $month = 12;
    $data_monthly = [];
    if(!empty($company)){
        foreach ($arr_data_telekom as $key => $val){
            $code = itemName("SELECT code FROM company WHERE id='$key'");
            foreach ($val as $v){
                $acc_no = $v['account_no'];
                $date_end = $v['date_end'];
                $telekom_month = date_parse_from_format("Y-m-d", $date_end);
                $t_m = $telekom_month["month"];
                for ( $m=1; $m<=$month; $m++ ){
                    if($m == $t_m){
//                         if(!empty($account_no)){
                            if (isset($data_monthly[$code][$acc_no][$m])){
                                $data_monthly[$code][$acc_no][$m] += (double)$v['amount'];
                            }else{
                                $data_monthly[$code][$acc_no][$m] = (double)$v['amount'];
                            }
//                         }
//                         else{
//                             if (isset($data_monthly[$code][$m])){
//                                 $data_monthly[$code][$m] += (double)$v['amount'];
//                             }else{
//                                 $data_monthly[$code][$m] = (double)$v['amount'];
//                             }
//                         }
                    }
                }
            }
        }
    }
    
    //telekom monthly
    $datasets_telekom_monthly = [];
    foreach ($data_monthly as $code => $data){
//         if(!empty($account_no)){
            foreach ($data as $acc_no => $val){
                $month_data = array_replace($month_map, $val);
                $datasets_telekom_monthly[] = array(
                    'label' => $acc_no,
                    'backgroundColor' => 'transparent',
                    'borderColor' => randomColor(),
                    'lineTension' => 0,
                    'borderWidth' => 3,
                    'data' => array_values($month_data)
                );
            }
//         }
//         else{
//             $month_data = array_replace($month_map, $data);
//             $datasets_telekom_monthly[] = array(
//                 'label' => $code,
//                 'backgroundColor' => 'transparent',
//                 'borderColor' => randomColor(),
//                 'lineTension' => 0,
//                 'borderWidth' => 3,
//                 'data' => array_values($month_data)
//             );
//         }
    }
    
    return array(
        'telekom_monthly' => $datasets_telekom_monthly
    );
}

//get yearly data
$yearly_data = get_telekom_data_yearly($year_select);
$data_telekom = array_values($yearly_data['telekom_yearly']);
$data_telekom_yearly = implode(",", $data_telekom);
$company_str = !empty($yearly_data['company_str']) ? implode("','",$yearly_data['company_str']) : "";

//get monthly data
$monthly_data = get_telekom_data_monthly($year_select, $select_company, $select_acc);
$data_telekom_month = $monthly_data['telekom_monthly'];
$datasets_telekom_monthly = json_encode($data_telekom_month);


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
	<?php include('../assets/nav/leftNav.php')?>
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
                                <h6><strong class="card-title">Telekom</strong></h6>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
									<div class="form-group row col-sm-12">
										<div class="col-sm-2">
                    						<label for="report_type" class="form-control-label"><small class="form-text text-muted">Report Type</small></label>
                    						<select name="report_type" id="report_type" class="form-control form-control-sm" onchange="this.form.submit()">
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
                                                $company = mysqli_query ( $conn_admin_db, "SELECT company_id, (SELECT UPPER(NAME) FROM company WHERE id=bill_telekom_account.company_id) AS company_name FROM bill_telekom_account WHERE status='1' GROUP BY company_id ORDER BY company_name ASC");
                                                db_select ($company, 'company',$select_company,'submit()','','form-control form-control-sm','');
                                            ?>
                                    	</div>
                                    	<div class="col-sm-4 monthly-div">
                                		<label for="account_no" class="form-control-label"><small class="form-text text-muted">Account No.</small></label>
                                		<?php                                            
                                            $account = mysqli_query ( $conn_admin_db, "SELECT id,UPPER(account_no) FROM bill_telekom_account WHERE company_id='$select_company' AND status='1'");
                                            db_select ($account, 'account_no',$select_acc,'submit()','All','form-control form-control-sm','');
                                        ?>
                                		</div>                                        
                                     </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 telekom-yearly">            	
                                        <canvas id="telekom-yearly"></canvas>         
                                    </div>           
                                    <div class="col-sm-12 telekom-monthly">            	
                                        <canvas id="telekom-monthly"></canvas>       
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
	else if ( report_type == 'comparison'){
		window.open("telekom_graph_compare.php", "_blank");
	}

  	//Telekom monthly                  	
	var ctx = document.getElementById( "telekom-monthly" );
    ctx.height = 100;
    var myChart = new Chart( ctx, {           
        type: 'line',        	            	
        data: {   
        	labels: [ '<?php echo $month_str;?>' ],
        	defaultFontFamily: 'Montserrat',         	
            datasets: <?=$datasets_telekom_monthly?>
                
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                display: false,
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [ {
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                        } ],
                yAxes: [ {
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount (RM)'
                    }
                        } ]
            },
            title: {
                display: true,
                text: 'MONTHLY USAGE FOR YEAR '+year
            }
        }
    } );
    
	//JA yearly
    var ctx = document.getElementById( "telekom-yearly" );        	
    ctx.height = 100;
    var chart1 = new Chart( ctx, {
        type: 'bar',
        data: {
            labels: [ '<?php echo $company_str;?>' ], //Company                    
            defaultFontFamily: 'Montserrat',
            datasets: [ 
                {
                    label: "Bill Amount (RM)",
                    data: [ <?php echo $data_telekom_yearly;?> ], //premium
                            backgroundColor: 'rgba(220,53,69,0.55)',
                            borderColor: 'rgba(220,53,69,0.75)',
                            borderWidth: 0                            
						},						
					]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Montserrat',
                        bodyFontFamily: 'Montserrat',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Montserrat',
                        },
                    },
                    scales: {
                        xAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                        } ],
                        yAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Amount (RM)'
                            }
                        } ]
                    },
                    title: {
                        display: true,
                        text: 'USAGE BY COMPANY FOR YEAR '+year
                    },
                    
                }
            } );
});
</script>
</body>
</html>
