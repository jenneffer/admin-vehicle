<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
// $tariff = isset($_POST['tariff']) ? $_POST['tariff'] : "CM1";
$select_company = isset($_POST['company']) ? $_POST['company'] : "1";
$select_acc = isset($_POST['account_no']) ? $_POST['account_no'] : "";
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "year";
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

function get_telco_data_yearly($year){
    global $conn_admin_db;
    
    $query = "SELECT * FROM bill_telco_account 
        INNER JOIN bill_telco_billing ON bill_telco_account.id = bill_telco_billing.telco_acc_id 
        WHERE YEAR(DATE)='$year'";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        $data[$row['company_id']][] = array(
            'telco_data' => $row['amount_rm']
        );
    }
    
    $datasets_telco_yearly = [];
    foreach ($data as $key => $value) {
        $code = itemName("SELECT code FROM company WHERE id='$key'");
        $company[] = $code;
        foreach ($value as $val) {
            if(isset($datasets_telco_yearly[$key])){
                $datasets_telco_yearly[$key] += $val['telco_data'];
            }else{
                $datasets_telco_yearly[$key] = $val['telco_data'];
            }
        }
    }   
    return array(
        'telco_yearly' => $datasets_telco_yearly,
        'company_str' => $company
    );

}

function get_telco_data_monthly($year, $company, $account_no){
    global $conn_admin_db;
    global $month_map;
    
    $query = "SELECT * FROM bill_telco_account
        INNER JOIN bill_telco_billing ON bill_telco_account.id = bill_telco_billing.telco_acc_id
        WHERE YEAR(DATE)='$year'";

    if(!empty($company)){
        $query .=" AND company_id='$company'";
    }
    if(!empty($account_no)){
        $query .=" AND bill_telco_account.id = '$account_no'";
    }
    
    $query .= " ORDER BY date ASC";
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_telco = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_telco[$row['company_id']][] = $row;
    }
    
    //form array data for roadtax monthly
    $month = 12;
    $data_monthly = [];    
    if(!empty($company)){
        foreach ($arr_data_telco as $key => $val){
            $code = itemName("SELECT code FROM company WHERE id='$key'");
            foreach ($val as $v){
                $acc_no = $v['user'];
                $date_end = $v['date'];
                $telco_month = date_parse_from_format("Y-m-d", $date_end);
                $sesb_m = $telco_month["month"];
                for ( $m=1; $m<=$month; $m++ ){
                    if($m == $sesb_m){
//                         if(!empty($account_no)){
                            if (isset($data_monthly[$code][$acc_no][$m])){
                                $data_monthly[$code][$acc_no][$m] += (double)$v['amount_rm'];
                            }else{
                                $data_monthly[$code][$acc_no][$m] = (double)$v['amount_rm'];
                            }
//                         }
//                         else{
//                             if (isset($data_monthly[$code][$m])){
//                                 $data_monthly[$code][$m] += (double)$v['amount_rm'];
//                             }else{
//                                 $data_monthly[$code][$m] = (double)$v['amount_rm'];
//                             }
//                         }
                        
                    }
                }
            }
        }
    }
    
    //telco monthly
    $datasets_telco_monthly = [];
    foreach ($data_monthly as $code => $data){
//         if(!empty($account_no)){
            foreach ($data as $location => $val){
                $month_data = array_replace($month_map, $val);
                $datasets_telco_monthly[] = array(
                    'label' => $location,
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
//             $datasets_telco_monthly[] = array(
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
        'telco_monthly' => $datasets_telco_monthly
    );
}

//get yearly data
$yearly_data = get_telco_data_yearly($year_select);
$data_telco = array_values($yearly_data['telco_yearly']);
$data_telco_yearly = implode(",", $data_telco);
$company_str = !empty($yearly_data['company_str']) ? implode("','",$yearly_data['company_str']) : "";

//get monthly data
$monthly_data = get_telco_data_monthly($year_select, $select_company, $select_acc);
$data_telco_month = $monthly_data['telco_monthly'];
$datasets_telco_monthly = json_encode($data_telco_month);

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
<?php require_once('../allCSS1.php')?>
<link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">
</head>
<body>
    <!--Left Panel -->
	<?php include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <div id="right-panel" class="right-panel">
    <div class="content">        
        <div class="animated fadeIn">
        <div class="row">
        <div class="col-md-12">
            <div class="card" id="printableArea">
                <div class="card-header text-center">
                    <strong class="card-title">TELCO USAGE</strong>
                </div>     
               <div class="card-body">
                <form action="" method="post">
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
                      		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                      		<?=$html_year_select?>
                      	</div>
                      	<div class="col-sm-4 monthly-div">
                		<label for="company" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                		<?php                                            
                            $company = mysqli_query ( $conn_admin_db, "SELECT company_id, (SELECT UPPER(NAME) FROM company WHERE id=bill_telco_account.company_id) AS company_name FROM bill_telco_account WHERE status='1' GROUP BY company_id ORDER BY company_name ASC");
                            db_select ($company, 'company',$select_company,'submit()','','form-control form-control-sm','');
                        ?>
                		</div>
                		<div class="col-sm-4 monthly-div">
                		<label for="location" class="form-control-label"><small class="form-text text-muted">Account No.</small></label>
                		<?php                                            
                    		$account_no = mysqli_query ( $conn_admin_db, "SELECT id, account_no FROM bill_telco_account WHERE company_id='$select_company' AND id IN (SELECT telco_acc_id FROM bill_telco_billing)");
                    		db_select ($account_no, 'account_no',$select_acc,'submit()','All','form-control form-control-sm','');
                        ?>
                		</div>
                	</div>
                </form>
                <br>
                <div class="row">
                    <div class="col-sm-12 ja-yearly">            	
<!--                         <div class="card">                	 -->
<!--                             <div class="card-body">                         -->
                                <canvas id="ja-yearly"></canvas>                        
<!--                             </div> -->
<!--                         </div> -->
                    </div>           
                    <div class="col-sm-12 ja-monthly">            	
<!--                         <div class="card">                	 -->
<!--                             <div class="card-body">                         -->
                                <canvas id="ja-monthly"></canvas>                        
<!--                             </div> -->
<!--                         </div> -->
                    </div>     
                </div>    
                </div>
                </div>
                </div></div>					
    	</div>
    </div>
    </div>

<!-- link to the script-->
<?php require_once ('../allScript2.php')?>
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
            var select_company = '<?=$comp_name?>'; 
            var report_type = '<?=$report_type?>';
            var year = '<?=$year_select?>';
            $('.monthly-div').hide();
            $('.ja-monthly').hide();
            $('.ja-yearly').show();
            if(report_type == 'month'){   
            	$('.monthly-div').show();
            	$('.ja-monthly').show();
            	$('.ja-yearly').hide();
			}
			else if ( report_type == 'year'){
				$('#company').val('');
			}
			else if ( report_type == 'comparison'){
				window.open("telco_graph_compare.php", "_blank");
			}
            //JA monthly                  	
        	var ctx = document.getElementById( "ja-monthly" );
            ctx.height = 100;
            var myChart = new Chart( ctx, {           
                type: 'line',        	            	
                data: {   
                	labels: [ '<?php echo $month_str;?>' ],
                	defaultFontFamily: 'Montserrat',         	
                    datasets: <?=$datasets_telco_monthly?>
                        
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
            var ctx = document.getElementById( "ja-yearly" );        	
            ctx.height = 100;
            var chart1 = new Chart( ctx, {
                type: 'bar',
                data: {
                    labels: [ '<?php echo $company_str;?>' ], //Company                    
                    defaultFontFamily: 'Montserrat',
                    datasets: [ 
                        {
                            label: "Bill Amount (RM)",
                            data: [ <?php echo $data_telco_yearly;?> ], //premium
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