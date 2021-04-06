<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');    
    session_start();

    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";    
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');  
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    if( $action != "" ){
        switch ($action){
            
            case 'update_puspakom':                
                update_puspakom($data); 
                break;
                
            case 'delete_puspakom': 
                delete_puspakom($id);                
                break;
                
            case 'display_puspakom':
                display_puspakom($date_start, $date_end);
                break;
                
            case 'retrive_puspakom':
                retrieve_puspakom($id);
                break;
                
            case 'add_new_puspakom':                
                add_new_puspakom($data);
                break;
            default:
                break;
        }
    }
    
    function add_new_puspakom($data){
        global $conn_admin_db;
        if( !empty($data) ){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data
            
            $vehicle_reg_no = isset($params['vehicle_reg_no']) ? $params['vehicle_reg_no'] : "";
            $fitness_due_date = isset($params['fitness_date']) ? dateFormat($params['fitness_date']) : "";
            $roadtax_due_date = isset($params['roadtax_due_date']) ? dateFormat($params['roadtax_due_date']) : "";
            $remark = isset($params['remark']) ? $params['remark'] : "";
            
            $query = "INSERT INTO vehicle_puspakom
                            SET vv_id = '$vehicle_reg_no',
                            vp_fitnessDate = '$fitness_due_date',
                            vp_roadtaxDueDate = '$roadtax_due_date',
                            vp_remark = '$remark',
                            vp_updatedBy = '".$_SESSION['cr_id']."',
                            vp_lastUpdated = now()";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));            
            echo json_encode($result);
        }
    }
    
    function retrieve_puspakom($id){
        global $conn_admin_db;
        if(!empty($id)){           
            $query = "SELECT * FROM vehicle_puspakom WHERE vp_id = '".$id."'";            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        }
    }
    
    function display_puspakom($date_start, $date_end){
        global $conn_admin_db;
//         $sql_query = "SELECT * FROM vehicle_puspakom
//                                     INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_puspakom.vv_id
//                                     INNER JOIN company ON company.id = vehicle_vehicle.company_id
//                                     WHERE vp_fitnessDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND vehicle_puspakom.status='1'";
        
        $sql_query = "SELECT * FROM vehicle_puspakom
                                    INNER JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_puspakom.vv_id
                                    INNER JOIN company ON company.id = vehicle_vehicle.company_id
                                    WHERE vehicle_puspakom.status='1'";
        
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
                    $count.".",
                    $row['vv_vehicleNo'],
                    $row['code'],
                    dateFormatRev($row['vp_fitnessDate']),
                    dateFormatRev($row['vp_roadtaxDueDate']),
                    $row['vp_remark'],
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
    }
    
    function delete_puspakom($id){
        global $conn_admin_db;
        if(!empty($id)){
            $query = "UPDATE vehicle_puspakom SET status = 0 WHERE vp_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            if ($result) {
                alert ("Deleted successfully", "puspakom.php");
            }            
        }
    }
    
    function update_puspakom($data){
        global $conn_admin_db;
        if( !empty($data) ){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data
            $vp_id = isset($params['vp_id']) ? $params['vp_id'] : "";
            $vehicle_reg_no = isset($params['vehicle_reg_no']) ? $params['vehicle_reg_no'] : "";
            $fitness_due_date = isset($params['fitness_date']) ? dateFormat($params['fitness_date']) : "";
            $roadtax_due_date = isset($params['roadtax_due_date']) ? dateFormat($params['roadtax_due_date']) : "";
            $remark = isset($params['remark']) ? $params['remark'] : "";
            
            $query = "UPDATE vehicle_puspakom
                            SET vv_id = '$vehicle_reg_no',
                            vp_fitnessDate = '$fitness_due_date',
                            vp_roadtaxDueDate = '$roadtax_due_date',
                            vp_remark = '$remark',
                            vp_lastUpdated = now(),
                            vp_updatedBy = '".$_SESSION['cr_id']."'                           
                            WHERE vp_id='".$vp_id."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
            echo json_encode($result);
        }
    }
?>