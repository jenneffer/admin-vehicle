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

            $vehicle_reg_no = isset($params['vehicle_reg_no']) ? $params['vehicle_reg_no'] : "";
            $workshop = isset($params['workshop']) ? $params['workshop'] : "";
            $date = isset($params['date']) ? dateFormat($params['date']) : "";
            $irf_no = isset($params['irf_no']) ? $params['irf_no'] : "";
            $irf_date = $params['irf_date'] == '' ? NULL : dateFormat($params['irf_date']);
            $po_no = isset($params['po_no']) ? $params['po_no'] : "";
            $po_date = $params['po_date'] == '-' ? NULL : dateFormat($params['po_date']);
            $inv_no = isset($params['inv_no']) ? $params['inv_no'] : "";
            $user = isset($params['user']) ? $params['user'] : "";
            $amount = isset($params['amount']) ? $params['amount'] : 0;
            $desc = isset($params['desc']) ? $params['desc'] : "";
            $vm_id = $params['vm_id'];

            $sql_insert = mysqli_query($conn_admin_db, "UPDATE vehicle_maintenance SET
                            vv_id = '".$vehicle_reg_no."',
                            vm_date = '".$date."',
                            vm_description = '".$desc."',
                            vm_amount = '".$amount."',
                            vm_irf_no = '".$irf_no."',
                            vm_po_no = '".$po_no."',
                            vm_invoice_no = '".$inv_no."',
                            vm_irf_date = '".$irf_date."',
                            vm_po_date = '".$po_date."',
                            vm_user = '".$user."',
                            vm_workshop = '".$workshop."' WHERE vm_id='".$vm_id."'");
            
            if($sql_insert){
                alert ("Added successfully","maintenance.php");
            }        
        }
    }
    
    function retrieve_data($id){
        global $conn_admin_db;
        if(!empty($id)){
            
            $query = "SELECT vm_id, vm.vv_id,vv_vehicleNo, vm_date, vm_description, vm_amount, vm_irf_no, vm_po_no,vm_invoice_no, vm_po_date, vm_irf_date, vm_workshop, vm_user,
                    (SELECT code FROM company WHERE id=vv.company_id) AS company_name FROM vehicle_maintenance vm
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
            echo $result;
//             if ($result) {
//                 alert ("Deleted successfully", "maintenance.php");
//             }            
        }
    }
    
?>