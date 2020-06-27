<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$tariff = isset($_POST['tariff']) ? $_POST['tariff'] : "CM1";
$select_company = isset($_POST['company']) ? $_POST['company'] : "";
ob_start();
selectYear('year_select',$year_select,'submit()','','form-control','','');
$html_year_select = ob_get_clean();

$query = "SELECT * FROM bill_sesb_account
        INNER JOIN bill_sesb ON bill_sesb_account.id = bill_sesb.acc_id
        WHERE company='$select_company' AND YEAR(date_end)='$year_select'";
        
// if(!empty($tariff)){
//     $query .=" AND bill_sesb_account.tarif = '$tariff'";
// }

$query .= " ORDER BY date_end ASC";

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
while ($row = mysqli_fetch_assoc($rst)) {
    $date_end = $row['date_end'];
    $month_data = date_parse_from_format("Y-m-d", $date_end);
    $ins_m = $month_data["month"];   
    
    for ( $m=1; $m<=$month; $m++ ){               
        if($m == $ins_m){
            if (isset($arr_data[$row['tarif']][$row['location']][$m])){
                $arr_data[$row['tarif']][$row['location']][$m] += $row['amount'];
            }else{
                $arr_data[$row['tarif']][$row['location']][$m] = $row['amount'];
            }            
        }
    }
    $data_monthly = $arr_data;    
}

$datasets = [];
foreach ($data_monthly as $tariff => $data){  
    
    foreach ($data as $label => $da){
        $month_data = array_replace($month_map, $da);
        
        $datasets[$tariff][] = array(
            'label' => $label,
            'backgroundColor' => 'transparent',
            'borderColor' => randomColor(),
            'borderWidth' => 3,
            'lineTension' => 0,
            'data' => array_values($month_data)
        );        
    }    
}
// var_dump(array_keys($datasets));
$datasets = json_encode($datasets);
// echo $datasets;
// $chart_count = count($datasets);


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
	<?php //include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php //include('../assets/nav/rightNav.php')?>
    <div id="right-panel" class="right-panel">
    <div class="content">        
        <div class="animated fadeIn">
        	<form action="" method="post">
            	<div class="form-group row col-sm-12">
            		<div class="col-sm-4">
            		<label for="tariff" class="form-control-label"><small class="form-text text-muted">Company</small></label>
            		<?php                                            
                        $company = mysqli_query ( $conn_admin_db, "SELECT company,UPPER(company) FROM bill_sesb_account WHERE status='1' GROUP BY company ");
                        db_select ($company, 'company',$select_company,'submit()','','form-control','');
                    ?>
            		</div>
                  	<div class="col-sm-2">
                  		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                  		<?=$html_year_select?>
                  	</div>
            	</div>
        	</form>
        	<br>
            <div class="row">
                <div class="col-sm-12 sesb"> 
                <?php foreach ($datasets as $tariff => $d){?>           	
                    <div class="card">                	
                        <div class="card-body">                        
                            <canvas id="chart_<?=$tariff?>"></canvas>                        
                        </div>
                    </div>
                <?php }?>
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
            var select_company = '<?=$select_company?>';
            var tarif = '<?=$tariff?>';
            var year = '<?=$year_select?>';  
            var data = JSON.parse('<?=$datasets?>');

            $.each(data, function(index, value){
				console.log(index);
            });        	
        	

        });            
</script>
</body>
</html>