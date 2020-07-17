<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("01-m-Y");
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("31-m-Y");
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : "1";

$query = "SELECT department_id, SUM(quantity) AS quantity from stationary_stock_take 
        WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND item_id='$item_id'
        GROUP BY department_id";
// echo $query;
$item_name = itemName("SELECT item_name FROM stationary_item WHERE id='$item_id'");
$result = mysqli_query($conn_admin_db, $query);
$label = [];
$data = [];
$backgroundColor = [];
// $hoverBackgroundColor = [];
while ($row = mysqli_fetch_array($result)){
    $label[] = itemName("SELECT department_code FROM stationary_department WHERE department_id='".$row['department_id']."'");
    $data[] = $row['quantity'];
    $backgroundColor[] = randomColor();
//     $hoverBackgroundColor[] = randomColor();
}

$label = implode("','",$label);
$data = implode(",", $data);
$backgroundColor = implode("','", $backgroundColor);
// $hoverBackgroundColor = implode("','", $hoverBackgroundColor);

function randomColor(){
    //Create a loop.
    $rgbColor = array();
    foreach(array('r', 'g', 'b') as $color){
        //Generate a random number between 0 and 255.
        $rgbColor[$color] = mt_rand(0, 255);
    }
    $rgbColor = "rgba(".implode(",", $rgbColor).",0.8)";
    return $rgbColor;
}
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
    <div class="content">
    	<div class="col-sm-9">         
    		<canvas id="chart-item-usage"></canvas>   
    	</div>    
    </div>
    
<!--     <div id="right-panel" class="right-panel"> -->
<!--     <div class="content">             -->
<!--         <div class="animated fadeIn"> -->
<!--         	<div class="row"> -->
<!--         		<div class="col-sm-6">            	 -->
<!--         			<div class="card">                	  -->
<!--                         <div class="card-body">                          -->
<!--         					<canvas id="chart-item-usage"></canvas>                          -->
<!--                     	</div>  -->
<!--                     </div>                       -->
<!--                 </div> -->
<!--     		</div> -->
    					
<!--     	</div> -->
<!--     </div> -->
<!--     </div> -->

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

	//doughut chart
    var ctx = document.getElementById( "chart-item-usage" ).getContext('2d');
    ctx.height = 150;
    var myChart = new Chart( ctx, {
        type: 'doughnut',
        data: {
            datasets: [ {
                data: [ <?php echo $data?> ],
                backgroundColor: ['<?php echo $backgroundColor?>'],

                            } ],
            labels: ['<?php echo $label?>']
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: '<?=$item_name?>',
                fontSize : 18
            },
            legend: {
                position: 'right'
            }            
        }
    } );
	    
});            
</script>
</body>
</html>