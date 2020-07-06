<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$tariff = isset($_POST['tariff']) ? $_POST['tariff'] : "";
$select_company = isset($_POST['company']) ? $_POST['company'] : "1";
$select_location = isset($_POST['location']) ? $_POST['location'] : "";
ob_start();
selectYear('year_select',$year_select,'submit()','','form-control','','');
$html_year_select = ob_get_clean();

$query = "SELECT * FROM bill_jabatan_air_account 
        INNER JOIN bill_jabatan_air ON bill_jabatan_air_account.id = bill_jabatan_air.acc_id 
        WHERE YEAR(date_end)='$year_select' AND company_id='$select_company'";

if(!empty($tariff)){
    $query .=" AND bill_jabatan_air_account.kod_tariff = '$tariff'";
}

if(!empty($select_location)){
    $query .=" AND bill_jabatan_air_account.location = '$select_location'";
}

$query .= " ORDER BY date_end ASC";

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

$rst = mysqli_query($conn_admin_db, $query);
$arr_data = [];
$data_monthly = [];
$month = 12;
while ($row = mysqli_fetch_array($rst)) {    
    $date_end = $row['date_end'];
    $month_data = date_parse_from_format("Y-m-d", $date_end);
    $ins_m = $month_data["month"];   
    
    for ( $m=1; $m<=$month; $m++ ){               
        if($m == $ins_m){
            if (isset($arr_data[$row['location']][$m])){
                $arr_data[$row['location']][$m] += $row['amount'];
            }else{
                $arr_data[$row['location']][$m] = $row['amount'];
            }            
        }
    }
    $data_monthly = $arr_data;    
}

$datasets = [];
foreach ($data_monthly as $label => $data){
    $month_data = array_replace($month_map, $data);
    
    $datasets[] = array(
        'label' => $label,
        'backgroundColor' => 'transparent',
        'borderColor' => randomColor(),
        'borderWidth' => 3,
        'lineTension' => 0,
        'data' => array_values($month_data)
    );
}

$datasets = json_encode($datasets);

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
        	<form action="" method="post">
            	<div class="form-group row col-sm-12">
            		<div class="col-sm-2">
                  		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                  		<?=$html_year_select?>
                  	</div>
<!--                   	<div class="col-sm-2"> -->
<!--             			<label for="tariff" class="form-control-label"><small class="form-text text-muted">Tariff</small></label> -->
<!--                 		<select name="tariff" id="tariff" class="form-control" onchange="this.form.submit()"> -->
<!--                 			<option value="">All</option> -->
<!--                			<option value="CM1" <?php if($tariff=="CM1") echo "selected"; else echo ""; ?>>CM1</option>
<!--                			<option value="DM" <?php if($tariff=="DM") echo "selected"; else echo ""; ?>>DM</option>
<!--                			<option value="ID1" <?php if($tariff=="ID1") echo "selected"; else echo ""; ?>>ID1</option>
<!--                			<option value="ID2" <?php if($tariff=="ID2") echo "selected"; else echo ""; ?>>ID2</option>
<!--                 		</select> -->
<!--                   	</div> -->
            	    <div class="col-sm-4">
            		<label for="tariff" class="form-control-label"><small class="form-text text-muted">Company</small></label>
            		<?php                                            
                        $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE status='1' ORDER BY name ASC ");
                        db_select ($company, 'company',$select_company,'submit()','-select-','form-control','');
                    ?>
            		</div>
            		<div class="col-sm-4">
            		<label for="location" class="form-control-label"><small class="form-text text-muted">Account No./Location</small></label>
            		<?php 
            		
                        $location = mysqli_query ( $conn_admin_db, "SELECT location,UPPER(location) FROM bill_jabatan_air_account WHERE company_id='$select_company' AND status='1' GROUP BY location");
                        db_select ($location, 'location',$select_location,'submit()','All','form-control','');
                    ?>
            		</div>            		
            	</div>
        	</form>
        	<br>
            <div class="row">
                <div class="col-sm-12 sesb">            	
                    <div class="card">                	
                        <div class="card-body">                        
                            <canvas id="chart1"></canvas>                        
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
	<script type="text/javascript">
        $(document).ready(function() {
        	var select_company = '<?=$comp_name?>'; 
			var year = '<?=$year_select?>';         	
        	var ctx = document.getElementById( "chart1" );        	
            ctx.height = 'auto';
            var chart1 = new Chart( ctx, {
                type: 'line',
                data: {   
                	labels: [ '<?php echo $month_str;?>' ],
                	defaultFontFamily: 'Montserrat',         	
                    datasets: JSON.parse('<?=$datasets?>')
                        
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
                                labelString: 'Usage (RM)'
                            }
                        } ]
                    },
                    title: {
                        display: true,
                        text: 'WATER USAGE BY '+select_company+ ' for YEAR ' +year
                    },
                    
                }
            } );
        });            
</script>
</body>
</html>