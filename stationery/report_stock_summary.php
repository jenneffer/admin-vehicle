<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');

$query = "SELECT si.id, si.item_name, (SELECT name FROM stationary_category WHERE id=si.category_id) AS category,SUM(quantity) AS stock_out, (SELECT IF(SUM(stock_in) IS NULL, 0,SUM(stock_in)) 
        FROM stationary_stock WHERE item_id = si.id AND date_added BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' ) AS selected_month_stock,
        (SELECT IF(SUM(stock_in) IS NULL,0,SUM(stock_in)) FROM stationary_stock WHERE date_stock_in BETWEEN '2020-01-01' AND '".dateFormat($date_start)."' AND item_id=si.id ) AS prev_stock_in, 
        (SELECT IF(SUM(quantity) IS NULL, 0, SUM(quantity)) FROM stationary_stock_take WHERE date_taken BETWEEN '2020-01-01' AND '".dateFormat($date_start)."' AND item_id=si.id ) AS prev_stock_out, 
        si.unit 
        FROM stationary_item si
        LEFT JOIN stationary_stock_take sst ON sst.item_id = si.id AND sst.date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'
        GROUP BY si.id
        ORDER BY stock_out DESC";

$sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
$arr_data = [];
while($row = mysqli_fetch_assoc($sql_result)){
    $arr_data[] = $row;
}

$arr_item_unit = array(
    'pieces' => 'Pieces',
    'packet' => 'Packet',
    'box' => 'Box'
);

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
        <div class="content" >
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">Stock Take Summary</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">
                                        <div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">
<!--                                               <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
                                            </div>                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_end" name="date_end" class="form-control form-control-sm" value="<?=$date_end?>" autocomplete="off">
<!--                                               <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
                                            </div>                             
                                        </div>
                                        <div class="col-sm-4">                                    	
                                        	<button type="submit" class="btn btn-sm btn-primary button_search ">View</button>
                                        </div>
                                     </div>    
                                </form>
                            </div>
                            <hr>
                            <div class="card-body">
                                <table id="stock_summary" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>No.</th>
											<th>Item</th>
											<th>Category</th>
                                            <th>Current Stock</th>
											<th>Stock Out</th>
											<th style="text-align: right">Stock Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                    <?php 
                                    $count = 0;
                                    foreach ($arr_data as $data){
                                        $unit = !empty($data['unit']) && !empty($data['stock_balance']) ? $arr_item_unit[$data['unit']] : "";
                                        $current_stock = ($data['prev_stock_in'] - $data['prev_stock_out']) + $data['selected_month_stock'];
                                        $stock_balance = $current_stock - $data['stock_out'];
                                        $count++;
                                        echo "<tr>";
                                        echo "<td>".$count.".</td>";
                                        echo "<td>".strtoupper($data['item_name'])."</td>";
                                        echo "<td>".strtoupper($data['category'])."</td>";
                                        echo "<td style='text-align:center;'>".$current_stock."</td>";
                                        echo "<td style='text-align:center;'>".$data['stock_out']."</td>";
                                        echo "<td style='text-align:right;'>".$stock_balance." ".$unit."</td>";                                        
                                        echo "</tr>";
                                    }
                                    ?>                                                  
                                    </tbody>   
                                    <?php if(empty($arr_data)){?>
                                    	<tfoot>
                                    		<tr>
                                    			<td colspan="13" style="text-align: center">No records found...</td>
                                    		</tr>
                                    	</tfoot>    
                                    <?php }?>                                 
                                </table>
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
          $('#stock_summary').DataTable({
              "searching": true,
              "paging": true,
        	  "dom": 'Bfrtip',
              "buttons": [ 
               { 
              	extend: 'excelHtml5', 
              	messageTop: 'Vehicle Summon ',
              	footer: true 
               },
               {
              	extend: 'print',
              	messageTop: 'Stock Summary ',
              	footer: true,
              	customize: function ( win ) {
                      $(win.document.body)
                          .css( 'font-size', '10pt' );
              
                      $(win.document.body).find( 'table' )
                          .addClass( 'compact' )
                          .css( 'font-size', 'inherit' );
                  }
               }
              ],
           });
    	  $('#date_start, #date_end').datepicker({
              format: "dd-mm-yyyy",
              autoclose: true,
              orientation: "top left",
              todayHighlight: true
          });
      });
  </script>
</body>
</html>