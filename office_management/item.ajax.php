<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();
    
    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";

    
    if( $action != "" ){
        switch ($action){            
            case 'add_item': 
                add_item($data);
                break;
                
            case 'retrieve_item':
                retrieve_item($id);
                break;
                
            case 'update_item':
                update_item($data);
                break;
                
            case 'delete_item':
                delete_item($id);
                break;
                
            default:
                break;
        }
    }
    
    //ITEM
    function delete_item($id){
        global $conn_admin_db;
        if (!empty($id)) {
            $query = "UPDATE om_stock_item SET status = 0 WHERE id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            if ($result) {
                alert ("Deleted successfully", "item_list.php");
            }
        }
        
    }
    
    function update_item($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            $id = $param['id'];
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['name']);
            $unit = $param['unit'];
            
            $query = "UPDATE om_stock_item SET item_name='$name', unit='$unit' WHERE id='$id'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully updated!", "item_list.php");
            }
        }
    }
    
    function retrieve_item($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM om_stock_item WHERE id = '$id'";
            $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
            
            $row = mysqli_fetch_assoc($rst);
            echo json_encode($row);
        }
    }
    
    function add_item($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['item_name']);
            $unit = $param['item_unit'];
            
            $query = "INSERT INTO om_stock_item SET item_name='$name', unit='$unit'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "item_list.php");
            }
        }
    }    
?>