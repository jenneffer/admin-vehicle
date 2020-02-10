<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    
    $sql_query = "SELECT * FROM vehicle_summons
                INNER JOIN vehicle_summon_type ON vehicle_summon_type.st_id = vehicle_summons.vs_summon_type
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_summons.vv_id
                INNER JOIN company ON company.id = vehicle_vehicle.company_id
                INNER JOIN vehicle_summon_payment ON vehicle_summons.vs_id = vehicle_summon_payment.summon_id";

	
    
	$rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
	
	$arr_result = array(
			'sEcho' => 0,
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'aaData' => array()
	);
	$arr_data = array();
	if ( mysqli_num_rows($rst) ){
	    $count = 0;
		while( $row = mysqli_fetch_assoc( $rst ) ){
		    
		    $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
			$total_found_rows = $row_found[0];
			$count++;
			$arr_data[$row['vs_id']][] = $row;
// 			$arr_data[$row['vs_id']][] = array(
// 			    'vs_id' => $row['vs_id'],
// 			    'vv_id' => $row['vv_id'],
// 			    'vs_summon_no' => $row['vs_summon_no'],
// 			    'vs_pv_no' => $row['vs_pv_no'],
// 			    'vs_reimbursement_amt' => $row['vs_reimbursement_amt'],
// 			    'vs_balance' => $row['vs_balance'],
// 			    'vs_remarks' => $row['vs_remarks'],
// 			    'vs_summon_type' => $row['vs_summon_type'],
// 			    'vs_summon_type_desc' => $row['vs_summon_type_desc'],
// 			    'vs_driver_name' => $row['vs_driver_name'],
// 			    'vs_summon_date' => $row['vs_summon_date'],
// 			    'vs_description' => $row['vs_description'],
// 			    'vs_remarks' => $row['vs_remarks'],
// 			    'vs_summon_type' => $row['vs_summon_type'],
// 			    'st_name' => $row['st_name'],
// 			    'vs_summon_type_desc' => $row['vs_summon_type_desc'],
// 			    'id' => $row['id'],
// 			    'code' => $row['code'],
// 			    'name' => $row['name'],
// 			    'payment_amount' => $row['payment_amount'],
// 			    'bankin_amount' => $row['bankin_amount'],
// 			    'payment_date' => $row['payment_date'],
// 			    'bankin_date' => $row['bankin_date'],
// 			);
			
// 			$data = array(
// 			        $count,
// 					$row['vv_vehicleNo'],
// 					$row['code'],					
// 			        dateFormatRev($row['vp_fitnessDate']),
// 			        dateFormatRev($row['vp_roadtaxDueDate']),
// 			        $row['vp_runner'],
		
// 			);
// 			$arr_data[] = $data;
		}
	
	}
	
	
	foreach ($arr_data as $key => $data){
	    
	    foreach ($data as $value){
	        if ($key == $value['vs_id']) {
	            var_dump($value['vs_id']);
	        }
	    }
	}

	
// 	$arr_result = array(
// 			'sEcho' => 0,
// 			'iTotalRecords' => $total_found_rows,
// 			'iTotalDisplayRecords' => $total_found_rows,
// 			'aaData' => $arr_data
// 	);

// 	echo json_encode($arr_result);
?>