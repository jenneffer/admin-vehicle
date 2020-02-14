<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();
    $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('01-m-Y');
    $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date('t-m-Y');
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $task = isset($_POST['task']) ? $_POST['task'] : "";

	$sql_query = "SELECT * FROM (SELECT vrt.vrt_id AS id, c.code AS company_code, vv.vv_vehicleNo AS vehicle_no, 
                vrt.vrt_amount AS var1, vrt.vrt_roadTax_fromDate AS var2, vrt.vrt_roadTax_dueDate AS var3, 'Road Tax' AS task, 
                vrt.vrt_roadTax_dueDate AS n_date, vrt.vrt_next_dueDate AS next_due_date 
                FROM vehicle_vehicle vv
                INNER JOIN vehicle_roadtax vrt ON vrt.vv_id = vv.vv_id
                INNER JOIN company c ON c.id = vv.company_id
                
                UNION ALL 
                
                SELECT vi.vi_id AS id, c.code AS company_code, vv.vv_vehicleNo AS vehicle_no, 
                vi.vi_sum_insured AS var1, vi.vi_ncd AS var2, '' AS var3, 'Insurance' AS task, 
                vi.vi_insurance_dueDate AS n_date, vi.vi_next_dueDate AS next_due_date
                FROM vehicle_vehicle vv
                INNER JOIN vehicle_insurance vi ON vi.vv_id = vv.vv_id
                INNER JOIN company c ON c.id = vv.company_id
                
                UNION ALL

                SELECT vp.vp_id AS id, c.code AS company_code, vv.vv_vehicleNo AS vehicle_no, 
                vp.vp_runner AS var1, '' AS var2, '' AS var3, 'Fitness Test' 
                AS task, vp.vp_fitnessDate AS n_date, vp.vp_next_dueDate AS next_due_date
                FROM vehicle_vehicle vv
                INNER JOIN vehicle_puspakom vp ON vp.vv_id = vv.vv_id
                INNER JOIN company c ON c.id = vv.company_id)t
                WHERE t.n_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' ";
	
	if (!empty($id) && !empty($task)) {
	    $sql_query .= " AND t.id='".$id."' AND t.task='".$task."' ";
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
			
			$var1 = $row['var1']; //amount
			$var2 = $row['var2']; //road tax date start or ncd
			$var3 = $row['var3']; //road tax date end
			
			if (DateTime::createFromFormat('Y-m-d', $var2) !== FALSE) {
			    $diff = abs(strtotime($var2) - strtotime($var3));
			    $years = floor($diff / (365*60*60*24));
			    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			    
			    $year = !empty($years) ? $years ." Year" : "";
			    $month = !empty($months) ? $months ." Month" : "";
			    $day = !empty($days) ? $days ." days" : "";
			    
			    $variable2 = " - ". $year.  $month . $day ;			    
			    
			}else{
			    $variable2 = $var2;
			}
			
			
			$variable2 = !empty($variable2) && is_numeric($variable2)  ? " - ".$variable2 ." %" : $variable2;
			$variable1 = is_numeric($var1) ? "RM ".number_format($var1, 2): $var1;
			
			
			$remark = $variable1 .$variable2;
			
			$action = '<span id='.$row['id'].' data-toggle="modal"  class="edit_data" data-target="#editItem" onclick="editFunction('.$row['id'].', '."'".$row['task']."'".')"><i class="menu-icon fa fa-edit"></i>
                        </span>';
			$data = array(
			        $count,
					$row['company_code'],
					$row['vehicle_no'],		
			        $remark,
    			    $row['task'],
			        dateFormatRev($row['n_date']),	
			        dateFormatRev($row['next_due_date']),	
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