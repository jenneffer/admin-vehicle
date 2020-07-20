<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
ob_start();
selectYear('year_select',$year_select,'submit()','','form-control','','');
$html_year_select = ob_get_clean();

$select_department = isset($_POST['department']) ? $_POST['department'] : "1";
$select_item = isset($_POST['item']) ? $_POST['item'] : "All";

$dept_name = itemName("SELECT department_name FROM stationary_department WHERE department_id='$select_department'");
$item_name = itemName("SELECT item_name FROM stationary_item WHERE id='$select_item'");

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

$query = "SELECT * FROM stationary_stock_take WHERE YEAR(date_taken)='".$year_select."' AND department_id='$select_department'";
if(!empty($select_item)){
    $query .=" AND item_id='$select_item'";
}
$query .= " ORDER BY date_taken ASC";

$result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
$arr_result = [];
$data_monthly = [];
$month = 12;
while ($row = mysqli_fetch_assoc($result)) {
    $date_taken = $row['date_taken'];
    $month_data = date_parse_from_format("Y-m-d", $date_taken);
    $mo = $month_data["month"];
    
    for ( $m=1; $m<=$month; $m++ ){
        if($m == $mo){
            if (isset($arr_result[$row['item_id']][$m])){
                $arr_result[$row['item_id']][$m] += $row['quantity'];
            }else{
                $arr_result[$row['item_id']][$m] = $row['quantity'];
            }
        }
    }
    $data_monthly = $arr_result;
}

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

$datasets = [];
foreach ($data_monthly as $label => $data){
    $month_data = array_replace($month_map, $data);
    $itemName = itemName("SELECT item_name FROM stationary_item WHERE id='$label'");
    $datasets[] = array(
        'label' => $itemName,
        'backgroundColor' => 'transparent',
        'borderColor' => randomColor(),
        'borderWidth' => 3,
        'lineTension' => 0,
        'data' => array_values($month_data)
    );
}

$datasets = json_encode($datasets);

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
.select2-selection__rendered {
    margin: 5px;
}
.select2-selection__arrow {
    margin: 5px;    
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
    <div class="content" >
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="printableArea">
                        <div class="card-header">
                            <strong class="card-title">Department Usage</strong>
                        </div>                                                
                        <div class="card-body">
                            <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                	            <div class="form-group row col-sm-12">
                                    <div class="col-sm-3">
                                  		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                                  		<?=$html_year_select?>
                                  	</div>
                                  	<div class="col-sm-3">
                                  		<label for="department" class="form-control-label"><small class="form-text text-muted">Department</small></label>
                                  		<?php 
          		                            $department = mysqli_query ( $conn_admin_db, "SELECT department_id, department_name FROM stationary_department WHERE status='1'");
          		                            db_select ($department, 'department', $select_department,'submit()','','form-control form-control-sm','');  
                                  		?>                                  		  
                                  	</div>
                                  	<div class="col-sm-3">
                                  		<label for="item" class="form-control-label"><small class="form-text text-muted">Item</small></label>
                                  		<?php 
          		                            $item = mysqli_query ( $conn_admin_db, "SELECT item_id, (SELECT item_name FROM  stationary_item WHERE id=stationary_stock_take.item_id)AS item_name FROM stationary_stock_take WHERE department_id='".$select_department."' GROUP BY item_id");
          		                            db_select ($item, 'item', $select_item,'submit()','All','form-control form-control-sm','');  
                                  		?>
                                  	</div>
                                 </div>    
                            </form>
                        </div>
                        <hr>
                        <div class="row">
                        	<div class="col-sm-12">
                        		<canvas id="chart-item-usage"></canvas> 
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
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
<script src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	// Initialize select2
	var select2 = $("#item").select2({
	    selectOnClose: true
    });
	select2.data('select2').$selection.css('height', '38px');
	select2.data('select2').$selection.css('border', '1px solid #ced4da');
	

	var select3 = $("#department").select2({
	    selectOnClose: true
    });
	select3.data('select2').$selection.css('height', '38px');
	select3.data('select2').$selection.css('border', '1px solid #ced4da');
	

	var dept_name = '<?=$dept_name?>';
	var year = '<?=$year_select?>';
	var item_name = '<?=$item_name?>';
	if(item_name == '') item_name = 'All item';
	
	var ctx = document.getElementById( "chart-item-usage" );
    ctx.height = 150;
    myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [ '<?php echo $month_str?>' ],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: JSON.parse('<?=$datasets?>')
        },
        options: {
        	layout: {
                padding: {
                   bottom: 100  //set that fits the best
                }
             },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 10,
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
                        labelString: 'Quantity'
                    }
                        } ]
            },
            title: {
                display: true,
                text: item_name+" usage by "+dept_name +" ( "+ year +" )"
            },
            
        }
    });
    
});            
</script>
</body>
</html>