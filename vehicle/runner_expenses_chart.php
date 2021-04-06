<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
// $tariff = isset($_POST['tariff']) ? $_POST['tariff'] : "CM1";

$select_runner = isset($_POST['runner']) ? $_POST['runner'] : "";
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "year";
ob_start();
selectYear('year_select',$year_select,'submit()','','form-control form-control-sm','','');
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

function get_runner_data_yearly($year, $runner){
    global $conn_admin_db;
    
    $query = "SELECT * FROM vehicle_runner_claim vrc
        INNER JOIN vehicle_vehicle vv ON vrc.vehicle_id = vv.vv_id 
        WHERE YEAR(invoice_date) ='$year' AND vrc.`status`='1'";
    
    if(!empty($runner)){
        $query .=" AND vrc.runner_id='$runner'";
    }
    
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        $data[$row['company_id']][] = array(
            'runner_data' => $row['total_amount']
        );
    }
    $datasets_runner_yearly = [];
    foreach ($data as $key => $value) {
        $code = itemName("SELECT code FROM company WHERE id='$key'");
        $company[] = $code;
        foreach ($value as $val) {
            if(isset($datasets_runner_yearly[$key])){
                $datasets_runner_yearly[$key] += $val['runner_data'];
            }else{
                $datasets_runner_yearly[$key] = $val['runner_data'];
            }
        }
    }
    
    return array(
        'runner_yearly' => $datasets_runner_yearly,
        'company_str' => $company
    );

}

function get_runner_data_monthly($year, $runner){
    global $conn_admin_db;
    global $month_map;
    
    $query = "SELECT * FROM vehicle_runner_claim vrc
        INNER JOIN vehicle_vehicle vv ON vrc.vehicle_id = vv.vv_id 
        WHERE YEAR(invoice_date) ='$year' AND vrc.`status`='1'";

    if(!empty($runner)){
        $query .=" AND vrc.runner_id='$runner'";
    }
     
    $query .= " ORDER BY invoice_date ASC";
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $arr_data_runner = [];
    while($row = mysqli_fetch_assoc($sql_result)){
        //monthly
        $arr_data_runner[$row['company_id']][] = $row;
    }
    //form array data for runner monthly
    $month = 12;
    $data_monthly = [];
    foreach ($arr_data_runner as $key => $val){
        $code = itemName("SELECT code FROM company WHERE id='$key'");
        foreach ($val as $v){  
            $invoice_date = $v['invoice_date'];
            $runner_month = date_parse_from_format("Y-m-d", $invoice_date);
            $runner_m = $runner_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $runner_m){
                        if (isset($data_monthly[$code][$m])){
                            $data_monthly[$code][$m] += (double)$v['total_amount'];
                        }else{
                            $data_monthly[$code][$m] = (double)$v['total_amount'];
                        }
                    
                }
            }
        }
    }
    
    //runner monthly
    $datasets_runner_monthly = [];

    foreach ($data_monthly as $code => $data){
        $month_data = array_replace($month_map, $data);
        $datasets_runner_monthly[] = array(
            'label' => $code,
            'backgroundColor' => randomColor(),
            'data' => array_values($month_data)
        );
    }
   
    return array(
        'runner_monthly' => $datasets_runner_monthly
    );
}

//get yearly data
$yearly_data = get_runner_data_yearly($year_select, $select_runner);
$data_runner = array_values($yearly_data['runner_yearly']);
$data_runner_yearly = implode(",", $data_runner);
$company_str = !empty($yearly_data['company_str']) ? implode("','",$yearly_data['company_str']) : "";

//get monthly data
$monthly_data = get_runner_data_monthly($year_select, $select_runner);
$data_runner_month = $monthly_data['runner_monthly'];
$datasets_runner_monthly = json_encode($data_runner_month);

?>
<html>
<head>
<style>
body, html{
  background: #181E24;
  padding-top: 10px;
}

.wrapper{
  width:80%;
  display:block;
  overflow:hidden;
  margin:0 auto;
  padding: 60px 50px;
  background:#fff;
  border-radius:4px;
}

canvas{
  background:#fff;
  height:400px;
}

h1{
  font-family: Roboto;
  color: #fff;
  margin-top:50px;
  font-weight:200;
  text-align: center;
  display: block;
  text-decoration: none;
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
                        <strong class="card-title">RUNNER CLAIM</strong>
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
                        		<label for="runner" class="form-control-label"><small class="form-text text-muted">Runner</small></label>
                        		<?php                                            
                                    $runner = mysqli_query ( $conn_admin_db, "SELECT r_id,UPPER(r_name) FROM vehicle_runner WHERE r_status='1'");
                                    db_select ($runner, 'runner',$select_runner,'submit()','All','form-control form-control-sm','');
                                ?>
                        		</div>
                        	</div>
                    	</form>
                    	<br>
                        <div class="row">                            
                            <div class="wrapper" id="monthly_div">
                            	<canvas id="monthly_runner"></canvas>
                            	
                            </div>
                            <div class="wrapper" id="yearly_div">
                            	<canvas id="yearly_runner"></canvas>
                            	
                            </div>
                		</div>  
    				</div>
				</div>
			</div>
			</div>  					
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
<script src="../assets/js/script/jspdf.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var report_type = '<?=$report_type?>';
    var year = '<?=$year_select?>';
    var location = '<?=$select_location?>';
        
    $('#monthly_div').hide();
    $('#yearly_div').show();
    
    if(report_type == 'month'){   
        $('#monthly_div').show();
        $('#yearly_div').hide();
    }
    
    //Runner monthly                  	
    var ctx = document.getElementById("monthly_runner").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels:[ '<?php echo $month_str;?>' ],
        datasets: <?php echo $datasets_runner_monthly?>
        },
        options: {
        	tooltips: {
                mode: 'label',
                callbacks: {
                    afterTitle: function() {
                        window.total = 0;
                    },
                    label: function(tooltipItem, data) {
                        var corporation = data.datasets[tooltipItem.datasetIndex].label;
                        var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        window.total += valor;
                        return corporation + ": RM" + valor.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");             
                    },
                    footer: function() {
                        return "TOTAL: RM" + window.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                    }
                }
            },					
            scales: {
              xAxes: [{
                stacked: true,
                gridLines: {
                  display: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Months'
                }
              }],
              yAxes: [{
                stacked: true,
                ticks: {
                  beginAtZero: true,
                },
                type: 'linear',
                scaleLabel: {
                    display: true,
                    labelString: 'Amount (RM)'
                }
              }]
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: { position: 'bottom' },
            title: {
                display: true,
                text: 'MONTHLY RUNNER CLAIM FOR YEAR '+year
            },
    	}
    });
    
  	//Runner yearly                  	
    var ctx = document.getElementById( "yearly_runner" );        	
    var chart1 = new Chart( ctx, {
        type: 'bar',
        data: {
            labels: [ '<?php echo $company_str;?>' ], //Company                    
            datasets: [ 
                {
                    label: "Runner Claim (RM)",
                    data: [ <?php echo $data_runner_yearly;?> ], 
                            backgroundColor: 'rgba(220,53,69,0.55)',
                            borderColor: 'rgba(220,53,69,0.75)',
                            borderWidth: 0,                                                   
						},						
					]
                },
                options: {
                    responsive: true,                   
                    tooltips: {
                        mode: 'label',
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: true                            
                        },
                    },
                    scales: {
                        xAxes: [ {
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            },
                            barPercentage: 0.2
                        } ],
                        yAxes: [ {
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Amount (RM)'
                            }
                        } ]
                    },
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'YEARLY RUNNER CLAIM BY COMPANY FOR YEAR '+year
                    },
                    
                }
            } );
});          
</script>
</body>
</html>