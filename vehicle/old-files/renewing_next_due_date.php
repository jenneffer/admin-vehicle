<?php 
    require_once('../../assets/config/database.php');
    require_once('../../function.php');
    session_start();
    
    
    if( !empty($_POST) ){
        $id = isset($_POST['id']) ? $_POST['id'] : "";
        $task = isset($_POST['task']) ? $_POST['task'] : "";
        $new_date = isset($_POST['next_due_date']) ? $_POST['next_due_date'] : "";
        
        switch ($task) {
            case 'Road Tax':
                updateRoadTax($id, $new_date);
            break;
            case 'Insurance':
                updateInsurance($id, $new_date);
            break;
            case 'Fitness Test':
                updateFitnessTest($id, $new_date);
            break;            
            default:
            break;
        }
    }
    
    function updateRoadTax($id, $new_date){
        global $conn_admin_db;
        $sql_query = "UPDATE vehicle_roadtax SET vrt_next_dueDate='".dateFormat($new_date)."' WHERE vrt_id='".$id."'"; 
        
        $result = mysqli_query($conn_admin_db, $sql_query) or die(mysqli_error($conn_admin_db));   
        if ($result) {
            alert ("Updated successfully","renewing_vehicle_schedule_report.php");
        }
        
    }
    
    function updateInsurance($id, $new_date){
        global $conn_admin_db;
        $sql_query = "UPDATE vehicle_insurance SET vi_next_dueDate='".dateFormat($new_date)."' WHERE vi_id='".$id."'"; 
        
        $result = mysqli_query($conn_admin_db, $sql_query) or die(mysqli_error($conn_admin_db));
        if ($result) {
            alert ("Updated successfully","renewing_vehicle_schedule_report.php");
        }
    }
    
    function updateFitnessTest($id, $new_date){
        global $conn_admin_db;
        $sql_query = "UPDATE vehicle_puspakom SET vp_next_dueDate='".dateFormat($new_date)."' WHERE vp_id='".$id."'";        
        $result = mysqli_query($conn_admin_db, $sql_query) or die(mysqli_error($conn_admin_db));        
        if ($result) {
            alert ("Updated successfully","renewing_vehicle_schedule_report.php");
        }
        
    }
?>