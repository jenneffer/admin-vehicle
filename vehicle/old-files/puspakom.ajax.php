<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    
    $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('01-m-Y');
    $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date('t-m-Y');
    
	$sql_query = "SELECT * FROM vehicle_puspakom
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_puspakom.vv_id
                INNER JOIN company ON company.id = vehicle_vehicle.company_id
                WHERE vp_fitnessDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND vehicle_puspakom.status='1'";
		
	$rst  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
	
	$arr_result = array(
			'sEcho' => 0,
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'aaData' => array()
	);
	$arr_data = array();
	$total_found_rows = 0;
	if ( mysqli_num_rows($rst) ){
	    $count = 0;
		while( $row = mysqli_fetch_assoc( $rst ) ){
		    $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
			$total_found_rows = $row_found[0];
			$count++;
			$action = '<span id='.$row['vp_id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span id='.$row['vp_id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                        </span>';
			$data = array(
			        $count,
					$row['vv_vehicleNo'],
					$row['code'],					
			        dateFormatRev($row['vp_fitnessDate']),
			        dateFormatRev($row['vp_roadtaxDueDate']),
			        $row['vp_runner'],
					$action
		
			);
			$arr_data[] = $data;
		}
		
	}

	$arr_result = array(
			'sEcho' => 0,
			'iTotalRecords' => $total_found_rows,
			'iTotalDisplayRecords' => $total_found_rows,
			'aaData' => $arr_data
	);

	echo json_encode($arr_result);
?>