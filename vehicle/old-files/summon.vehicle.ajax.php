<?php 
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    global $conn_admin_db;
    session_start();
    
    $sql_query = "SELECT * FROM vehicle_summons
                INNER JOIN vehicle_summon_type ON vehicle_summon_type.st_id = vehicle_summons.vs_summon_type
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_summons.vv_id
                INNER JOIN company ON company.id = vehicle_vehicle.company_id";

	$rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
	
	$arr_result = array(
			'sEcho' => 0,
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'aaData' => array()
	);
	$arr_data = array();
	$data = array();
	if ( mysqli_num_rows($rst) ){
	    $count = 0;
		while( $row = mysqli_fetch_assoc( $rst ) ){
		    $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
			$total_found_rows = $row_found[0];
			$arr_payment = arr_payment($row['vs_id']);
			$count++;

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
			    'vs_summon_type' => $row['vs_summon_type'],
			    'st_name' => $row['st_name'],
			    'vs_summon_type_desc' => $row['vs_summon_type_desc'],
			    'id' => $row['id'],
			    'code' => $row['code'],
			    'name' => $row['name'],
			    'payment_data' => $arr_payment
			);
			
		}
	
	}

	foreach ($arr_data as $key => $datas){
	    $summon_type = $datas['vs_summon_type'] == 3 ? $datas['st_name'] ."(".$datas['vs_summon_type_desc'] .")" : $datas['st_name'];
	    
	    $data = array(
	        $datas['count'],
	        $datas['vehicle_no'],
	        $datas['vs_summon_no'],
	        $datas['vs_driver_name'],
	        $datas['code'],
	        $summon_type,
	        $datas['vs_pv_no'],
	        $datas['vs_reimbursement_amt'],
	        '1',
	        '2',
	        $datas['vs_balance'],
	        $datas['vs_remarks']
	        
	    );
	}

	
	$arr_result = array(
			'sEcho' => 0,
			'iTotalRecords' => $total_found_rows,
			'iTotalDisplayRecords' => $total_found_rows,
	        'aaData' => $data
	);

	echo json_encode($arr_result);

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