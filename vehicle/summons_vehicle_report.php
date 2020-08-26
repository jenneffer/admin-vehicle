<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');
	require_once('../check_login.php');
	global $conn_admin_db;
// 	if(isset($_SESSION['cr_id'])) {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$query = parse_url($url, PHP_URL_QUERY);
// 		parse_str($query, $params);
		
// 		// get id
// 		$userId = $_SESSION['cr_id'];
// 		$name = $_SESSION['cr_name'];
		
// 	} else {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$PrevURL= $url;
// 		header("Location: ../login.php?RecLock=".$PrevURL);
// 	}
	
	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
	
	//vehicle summon query
	$sql_query = "SELECT * FROM vehicle_summons
                INNER JOIN vehicle_summon_type ON vehicle_summon_type.st_id = vehicle_summons.vs_summon_type
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_summons.vv_id
                INNER JOIN company ON company.id = vehicle_vehicle.company_id
                WHERE vehicle_summons.vs_summon_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND vehicle_summons.status='1'";
	$rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
	$arr_data = array();
	if ( mysqli_num_rows($rst) ){
	    $count = 0;
	    while( $row = mysqli_fetch_assoc( $rst ) ){	        
	        $arr_payment = arr_payment($row['vs_id']);
	        $count++;
	        
	        $summon_type = $row['vs_summon_type'] == 3 ? $row['st_name'] ."(".$row['vs_summon_type_desc'] .")" : $row['st_name'];
	        
	        $arr_data[] = array(
	            'count' => $count,
	            'vs_id' => $row['vs_id'],
	            'vv_id' => $row['vv_id'],
	            'vehicle_no' => $row['vv_vehicleNo'],
	            'vs_summon_no' => $row['vs_summon_no'],
	            'vs_pv_no' => $row['vs_pv_no'],
	            'vs_reimbursement_amt' => $row['vs_reimbursement_amt'],
	            'vs_balance' => $row['vs_balance'],
	            'vs_remarks' => $row['vs_remarks'],
	            'vs_summon_type' => $row['vs_summon_type'],
	            'vs_summon_type_desc' => $row['vs_summon_type_desc'],
	            'vs_driver_name' => $row['vs_driver_name'],
	            'vs_summon_date' => $row['vs_summon_date'],
	            'vs_description' => $row['vs_description'],
	            'vs_remarks' => $row['vs_remarks'],
	            'vs_summon_type' => $summon_type,
	            'st_name' => $row['st_name'],
	            'vs_summon_type_desc' => $row['vs_summon_type_desc'],
	            'id' => $row['id'],
	            'code' => $row['code'],
	            'name' => $row['name'],
	            'payment_data' => $arr_payment
	        );
	        
	    }
	    
	}
	
	$payment_count = [];
	foreach ($arr_data as $data){	   
	    $payment_count[] = count($data['payment_data']);
	}
	$max_value = !empty($payment_count) ? max($payment_count) : 0;
	
	
	if( $max_value !=0 ){
	    $html_th = "<tr>"; 
	    for ($i = 1; $i <= $max_value; $i++) {
	        $html_th .= "<td style='text-align:center'><strong>".addOrdinalNumberSuffix($i)."</strong></td>";
	    }
	    $html_th .="</tr>";
	}	
	
	function arr_payment($summon_id){
	    global $conn_admin_db;
	    $query = "SELECT * FROM vehicle_summon_payment WHERE summon_id='".$summon_id."'";
	    $result  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
	    
	    $data_payment = array();
	    if ( mysqli_num_rows($result) ){
	        while( $row = mysqli_fetch_assoc( $result ) ){
	            $data_payment[] = $row;
	        }
	    }
	    
	    return $data_payment;
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
                                <strong class="card-title">Vehicle Summons</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">
                                        <div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">                                              
                                            </div>                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_end" name="date_end" class="form-control form-control-sm" value="<?=$date_end?>" autocomplete="off">                                              
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
                                <table id="vehicle_summon_table" class="table table-striped table-bordered">
                                    <thead>
                                    <?php if($max_value == 0){?>
                                        <tr>
                                        	<th>No.</th>
											<th>Vehicle No.</th>
                                            <th>Summon's No.</th>
                                            <th>Summon's date</th>
											<th>Driver's name</th>
											<th>Company</th>
											<th>Summon Type</th>
											<th>PV No.</th>
											<th>Reimburse Amount (RM)</th>  
											<th>Balance</th>
                                            <th>Remarks</th>                                      	
                                        </tr>	
                                        <?php }else{?>
                                        <tr>
                                        	<th rowspan="2">No.</th>
											<th rowspan="2">Vehicle No.</th>
                                            <th rowspan="2">Summon's No.</th>
                                            <th rowspan="2">Summon's date</th>
											<th rowspan="2">Driver's name</th>
											<th rowspan="2">Company</th>
											<th rowspan="2">Summon Type</th>
											<th rowspan="2">PV No.</th>
											<th rowspan="2">Reimburse Amount (RM)</th>
											<th id="payment_records" style="text-align: center" colspan='<?=$max_value?>'>Payment Records</th>									
                                            <th rowspan="2">Balance</th>
                                            <th rowspan="2">Remarks</th>
                                        </tr>
                                        <?=$html_th?>
                                        <?php }?>			
                                    </thead>
									<tbody>
									<?php                                     
                                        foreach ($arr_data as $summon_data){
                                        	echo "<tr>";
                                        	echo "<td>".$summon_data['count'].".</td>";
                                        	echo "<td>".strtoupper($summon_data['vehicle_no'])."</td>";
                                        	echo "<td>".strtoupper($summon_data['vs_summon_no'])."</td>";
                                        	echo "<td>".strtoupper($summon_data['vs_summon_date'])."</td>";
                                        	echo "<td>".strtoupper($summon_data['vs_driver_name'])."</td>";
                                        	echo "<td>".$summon_data['code']."</td>";
                                        	echo "<td>".$summon_data['vs_summon_type']."</td>";
                                        	echo "<td>".strtoupper($summon_data['vs_pv_no'])."</td>";
                                        	echo "<td class='text-right'>".number_format($summon_data['vs_reimbursement_amt'],2)."</td>";
                                        	
                                        	//itterate summon payment                                     
                                        	$html_td = "";
                                        	foreach ($summon_data['payment_data'] as $payment){
                                        		$html_td .= "<td><span style='font-size:12px'>".dateFormatRev($payment['payment_date'])."</span><br><span>".number_format($payment['payment_amount'],2)."</span></td>";
                                        	}                                        
                                        	//itterating empty td
                                        	for ($i = 0; $i < ($max_value - count($summon_data['payment_data'])); $i++) {
                                        		$html_td .= "<td>&nbsp;</td>";
                                        	}
                                        	
                                        	echo $html_td;
                                        	echo "<td class='text-right'>".number_format($summon_data['vs_balance'],2)."</td>";
                                        	echo "<td>".$summon_data['vs_remarks']."</td>";
                                        	echo "</tr>";
                                        }
                                    ?>
									</tbody>                                                                 
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
          $('#vehicle_summon_table').DataTable();
          
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
