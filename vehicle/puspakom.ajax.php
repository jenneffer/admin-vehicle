<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    $month = isset($_POST['month']) ? $_POST['month'] : "";
    $company = isset($_POST['company']) ? $_POST['company'] : "";

	$sql_query = "SELECT * FROM vehicle_puspakom
                INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_puspakom.vv_id
                INNER JOIN company ON company.id = vehicle_vehicle.company_id";
	
	if(!empty($company) && !empty($month)){
	    $sql_query .= " WHERE company.id ='".$company."' AND MONTH(vehicle_puspakom.vp_fitnessDate)='".$month."'";
	}
	elseif (!empty($company)){
	    $sql_query .= " WHERE company.id ='".$company."'";
	}
	elseif (!empty($month)){
	    $sql_query .= " MONTH(vehicle_puspakom.vp_fitnessDate)='".$month."'";
	}	
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
			$action = '<span id='.$row['vp_id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-pencil"></i>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span id='.$row['vp_id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash"></i>
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