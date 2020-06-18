<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";
$comp_name = itemName("SELECT name FROM company WHERE id='$select_c'");

ob_start();
selectYear('year_select',$year_select,'submit()','','form-control','','');
$html_year_select = ob_get_clean();

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

function get_insurance_data($company, $year){ //sum insured & premium amount
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id        
        WHERE YEAR(vi_insurance_fromDate)='".$year."'";
    
    if (!empty($company)){
        $query .= " AND company_id='$company'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $data_monthly_premium = []; //show premium data by month for selected company
    $data_monthly_sum_insured = []; //show sum_insured data by month for selected company
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        if (!empty($company)) {
            $ins_due_date = $row['vi_insurance_dueDate'];
            $ins_month = date_parse_from_format("Y-m-d", $ins_due_date);
            $ins_m = $ins_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ins_m){
                    //premium
                    if (isset($data_monthly_premium[$m])){
                        $data_monthly_premium[$m] += $row['vi_premium_amount'];
                    }else{
                        $data_monthly_premium[$m] = $row['vi_premium_amount'];
                    }
                    
                    //sum  insured
                    if (isset($data_monthly_sum_insured[$m])){
                        $data_monthly_sum_insured[$m] += $row['vi_sum_insured'];
                    }else{
                        $data_monthly_sum_insured[$m] = $row['vi_sum_insured'];
                    }
                }
            }
        }
        $data[$row['code']][] = array(
            'premium' => $row['vi_premium_amount'],
            'sum_insured' => $row['vi_sum_insured']
        );
    }
    
    $result = array(
        'all_data' => $data,
        'data_monthly_premium' => $data_monthly_premium,
        'data_monthly_sum_insured' => $data_monthly_sum_insured
    );
    return $result;
}

function get_roadtax_data( $company, $year ){
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vrt_roadTax_fromDate, vrt_roadTax_dueDate, vrt_roadTax_period, vrt_amount FROM vehicle_vehicle 
            INNER JOIN vehicle_roadtax ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
            WHERE YEAR(vrt_roadTax_fromDate)='".$year."'";
    
    if (!empty($company)){
        $query .= " AND company_id='$company'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $data_monthly_roadtax = []; //show roadtax data by month for selected company
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        if(!empty($company)){
            $rt_due_date = $row['vrt_roadTax_dueDate'];
            $rt_month = date_parse_from_format("Y-m-d", $rt_due_date);
            $rt_m = $rt_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $rt_m){
                    //premium
                    if (isset($data_monthly_roadtax[$m])){
                        $data_monthly_roadtax[$m] += $row['vrt_amount'];
                    }else{
                        $data_monthly_roadtax[$m] = $row['vrt_amount'];
                    }
                }
            }
        }               
        $data[$row['code']][] = array(
            'roadtax' => $row['vrt_amount']            
        );
    }
    
    $result = array(
        'all_data' => $data,
        'data_monthly_roadtax' => $data_monthly_roadtax
    );
    return $result;
}

$data_roadtax = get_roadtax_data($select_c, $year_select);
$rt_all_data = $data_roadtax['all_data'];

$data_monthly_roadtax = $data_roadtax['data_monthly_roadtax'];
$arr_monthly_roadtax = array_replace($month_map, $data_monthly_roadtax);

$roadtax = array_values($arr_monthly_roadtax);
$data_roadtax_monthly = implode(",", $roadtax);

$arr_roadtax = [];
foreach ($rt_all_data as $key => $value) {
    $rt_company[] = $key;
    foreach ($value as $val) {
        if(isset($arr_roadtax[$key])){
            $arr_roadtax[$key] += $val['roadtax'];
        }else{
            $arr_roadtax[$key] = $val['roadtax'];
        } 
    }
    
}
$rt_company_str = !empty($rt_company) ? implode("','",$rt_company) : "";
// $data_rt = array_values($arr_roadtax);
// $data_rtx = implode(",", $data_rt);

$data_insurance = get_insurance_data($select_c, $year_select);
$ins_data_all = $data_insurance['all_data'];
$data_monthly_premium = $data_insurance['data_monthly_premium'];
$data_monthly_sum_insured = $data_insurance['data_monthly_sum_insured'];
// var_dump($data_monthly_sum_insured);

$arr_monthly_premium = array_replace($month_map, $data_monthly_premium);
$arr_monthly_sum_insured = array_replace($month_map, $data_monthly_sum_insured);

$premium = array_values($arr_monthly_premium);
$data_premium_monthly = implode(",", $premium);

$sum_insured = array_values($arr_monthly_sum_insured);
$data_sum_insured_monthly = implode(",", $sum_insured);
// var_dump($arr_monthly_sum_insured);
$arr_premium = [];
$arr_sum_insured = [];
// $arr_ncd = [];
// $arr_roadtax = [];

foreach ($ins_data_all as $key => $value) {    
    $ins_company[] = $key;
    foreach ($value as $val) {
        //premium
        if (isset($arr_premium[$key])){
            $arr_premium[$key] += $val['premium'];
        }else{
            $arr_premium[$key] = $val['premium'];            
        }
        //sum insured
        if(isset($arr_sum_insured[$key])){
            $arr_sum_insured[$key] += $val['sum_insured'];                        
        }else{
            $arr_sum_insured[$key] = $val['sum_insured'];            
        }       
    }  
}

$ins_company_str = !empty($ins_company) ? implode("','",$ins_company) : "";

$data_premium = array_values($arr_premium);
$data_premium = implode(",", $data_premium);

$data_sum_insured = array_values($arr_sum_insured);
$data_sum_insured = implode(",", $data_sum_insured);

$data_roadtax = array_values($arr_roadtax);
$data_roadtax = implode(",", $data_roadtax);

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

$backgroundColor = array(
    "#F7464A",
    "#46BFBD", 
    "#FDB45C", 
    "#949FB1", 
    "#4D5360",
    "#539afc",
    "#c953fc",
    "#51f5a8",
    "#f5d93d",
    "#f25e3d"
);

$backgroundColor = implode("','", $backgroundColor);

$hoverBackgroundColor = array(
    "#FF5A5E", 
    "#5AD3D1", 
    "#FFC870", 
    "#A8B3C5", 
    "#616774"
)

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
            		<div class="col-sm-3">
            			<label for="company_dd" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                		<?php
                            $select_company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company WHERE status='1'");
                            db_select ($select_company, 'select_company', $select_c,'submit()','All','form-control','');                        
                        ?>
                  	</div>
                  	<div class="col-sm-3">
                  		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                  		<?=$html_year_select?>
                  	</div>
            	</div>
        	</form>
        	<br>            	
    		<div class="row">
    		<div class="col-lg-12">            	
    			<div class="card">                	 
                    <div class="card-body">                         
    					<canvas id="pieChart"></canvas>                         
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

	//pie chart
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {    	
        type: 'pie',
        data: {
        labels: [ '<?php echo $ins_company_str;?>' ],
        datasets: [{
            data: [<?php echo $data_roadtax?>],
            backgroundColor: ['<?php echo $backgroundColor?>']           
        }]
        },
        options: {
        responsive: true,
        legend: {
            position: 'right',
            labels: {
              padding: 20,
              boxWidth: 20
            }
          },
          plugins: {
        	  labels: {
        		  render: 'value',
        		  precision: 0,
        		  fontSize: 12,
        		  arc: true
            	  }
            }
        }
    });

    
});            
</script>
</body>
</html>