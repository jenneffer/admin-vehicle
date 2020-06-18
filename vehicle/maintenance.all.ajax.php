<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');    
    session_start();

    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";    
    $id = isset($_POST['vm_id']) ? $_POST['vm_id'] : "";    
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    if( $action != "" ){
        switch ($action){
            
            case 'retrieve_data':                
                retrieve_data($id);                
                break;
                
            case 'delete_data':
                delete_data($id);
                break;
                
            case 'update_data':
                update_data($data);
                break;
            default:
                break;
        }
    }
    
    function update_data($data){
        global $conn_admin_db;
        if(!empty($data)){
            $params = array();
            parse_str($data, $params); //unserialize jquery string data               
            $date = dateFormat($params['date']);
            $ref_no = $params['ref_no'];
            $amount = $params['amount'];
            $desc = $params['desc'];
            
            $sql_insert = mysqli_query($conn_admin_db, "UPDATE vehicle_maintenance SET
                            vm_date = '".$date."',
                            vm_description = '".$desc."',
                            vm_amount = '".$amount."',
                            vm_ref_no = '".$ref_no."'");
            
            if($sql_insert){
                alert ("Added successfully","maintenance.php");
            }        
        }
    }
    
    function retrieve_data($id){
        global $conn_admin_db;
        if(!empty($id)){
            
            $query = "SELECT vm_id, vm.vv_id,vv_vehicleNo, vm_date, vm_description, vm_amount, vm_ref_no, company_id,
                    (SELECT NAME FROM company WHERE id=vv.company_id) AS company_name FROM vehicle_maintenance vm
                    INNER JOIN vehicle_vehicle vv ON vv.vv_id = vm.vv_id WHERE vm_id='$id'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            $row = mysqli_fetch_assoc($result);
            
            echo json_encode($row);
        }
    }
    
    function delete_data($id){
        global $conn_admin_db;
        if(!empty($id)){            
            $query = "UPDATE vehicle_maintenance SET vm_status = 0 WHERE vm_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            
            if ($result) {
                alert ("Deleted successfully", "maintenance.php");
            }            
        }
    }
    
?>