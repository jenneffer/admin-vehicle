<?php 
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    session_start();

    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";    
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
   
    if( $action != "" ){
        switch ($action){
            
            case 'update_puspakom':
                var_dump($_POST);die;
                if( !empty($_POST) ){
                    $vp_id = isset($_POST['vp_id']) ? $_POST['vp_id'] : "";
                    $vehicle_reg_no = isset($_POST['vehicle_reg_no']) ? $_POST['vehicle_reg_no'] : "";
                    $fitness_due_date = isset($_POST['fitness_date']) ? $_POST['fitness_date'] : "";
                    $roadtax_due_date = isset($_POST['roadtax_due_date']) ? $_POST['roadtax_due_date'] : "";
                    $runner = isset($_POST['runner']) ? $_POST['runner'] : "";
                    
                    
                    $query = "UPDATE vehicle_puspakom
                            SET vv_id = '$vehicle_reg_no',
                            vp_fitnessDate = '$fitness_due_date',
                            vp_roadtaxDueDate = '$roadtax_due_date',
                            vp_runner = '$runner',
                            vp_lastUpdated = now(),
                            vp_updatedBy = '".$_SESSION['cr_id']."',
                            vp_lastUpdated = now()
                            WHERE vp_id='".$vp_id."'";
                    
                    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                    
                    alert ("Updated successfully","puspakom.php");                    
                } 
                break;
                
            case 'delete_puspakom': 
                
                if(!empty($_POST)){
                    $updated_id = $_POST['id'];

                    $query = "UPDATE vehicle_puspakom SET status = 0 WHERE vp_id = '".$updated_id."' ";
                    $result = mysqli_query($conn_admin_db, $query);
                    if ($result) {
                        alert ("Deleted successfully", "puspakom.php");
                    }
                    
                }
                break;
                
            case 'display_puspakom':
                
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
                break;
                
            case 'retrive_puspakom':
                
                if(!empty($_POST)){
                        $vp_id = isset($_POST["vp_id"]) ? $_POST["vp_id"] : "";
                        $query = "SELECT * FROM vehicle_puspakom WHERE vp_id = '".$vp_id."'";
                    
                        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
                        $row = mysqli_fetch_assoc($result);
                        echo json_encode($row);
                }
                break;
            default:
                break;
        }
    }
    
?>