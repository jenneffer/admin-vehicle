<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    
    $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : '';
    $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : '';
    
    $sql_query = "SELECT * FROM vehicle_roadtax
            INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
            LEFT JOIN vehicle_insurance ON vehicle_insurance.vi_vrt_id = vehicle_roadtax.vrt_id
            INNER JOIN company ON company.id = vehicle_vehicle.company_id
            WHERE vehicle_roadtax.status='1' ";
    
    if (!empty($date_start) && !empty($date_end)) {
        $sql_query .= " AND vehicle_roadtax.vrt_roadTax_dueDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'" ;
    }
    
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
			$year = !empty($row['vrt_roadtaxPeriodYear']) ? $row['vrt_roadtaxPeriodYear'] ."Year(s)" : "";
			$month = !empty($row['vrt_roadtaxPeriodMonth']) ? $row['vrt_roadtaxPeriodMonth'] ."Month(s)" : "";
			$days = !empty($row['vrt_roadtaxPeriodDay']) ? $row['vrt_roadtaxPeriodDay'] ."Day(s)" : "";
			$period = $year ." ". $month ." ".$days;
			$insurance_status = $row['vi_insuranceStatus'] == 1 ? "Active" : "Inactive";
			
			$action = '<span id='.$row['vrt_id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
                        </span><br><span id='.$row['vrt_id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                        </span>';
			
			$data = array(
			        $count,
					$row['vv_vehicleNo'],
					$row['code'],					
			        dateFormatRev($row['vrt_lpkpPermit_dueDate']),
    			    dateFormatRev($row['vi_insurance_dueDate']),
			        $insurance_status,
    			    dateFormatRev($row['vrt_roadTax_fromDate']),
    			    dateFormatRev($row['vrt_roadTax_dueDate']),
    			    $period,
    			    number_format($row['vrt_amount'], 2),
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