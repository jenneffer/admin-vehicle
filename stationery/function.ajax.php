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
                
            case 'add_department':
                add_department($data);
                break;
                
            case 'retrieve_department':
                retrieve_department($id);
                break;
                
            case 'update_department':
                update_department($data);
                break;
                
            case 'delete_department':
                delete_department($id);
                break;
            
            default:
                break;
        }
    }
    
    //ITEM
    function delete_item($id){
        global $conn_admin_db;
        if (!empty($id)) {
            //check the id if exist in stock out
            $exist = mysqli_query($conn_admin_db, "SELECT * FROM stationary_stock_take WHERE item_id='$id'");            
            if(mysqli_num_rows($exist) > 0){                
                $result = false;
            }else{
                $query = "UPDATE stationary_item SET status = 0 WHERE id = '".$id."' ";
                $result = mysqli_query($conn_admin_db, $query);
                
            }            
            
        }   

        
        echo json_encode($result);
    }
    
    function update_item($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            $id = $param['id'];
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['name']);
            $category =  mysqli_real_escape_string( $conn_admin_db,$param['cat']);
            $unit = $param['unit'];
            
            $query = "UPDATE stationary_item SET item_name='$name', unit='$unit', category_id='$category' WHERE id='$id'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully updated!", "item.php");
            }
        }
    }
    
    function retrieve_item($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM stationary_item WHERE id = '$id'";
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
            $category =  mysqli_real_escape_string( $conn_admin_db,$param['category']);
            $unit = $param['item_unit'];
            
            $query = "INSERT INTO stationary_item SET item_name='$name', category_id='$category', unit='$unit'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "item.php");
            } else {
				alert("Item is not added. Please try again!");
			}
        }
    }
    
    //DEPARTMENT
    function delete_department($id){
        global $conn_admin_db;
        if (!empty($id)) {
            $query = "UPDATE stationary_department SET status = 0 WHERE id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            if ($result) {
                alert ("Deleted successfully", "department.php");
            }
        }
        
    }
    
    function update_department($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            $id = $param['id'];           
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['department']);
            
            $query = "UPDATE stationary_department SET department_code='$name' WHERE department_id='$id'";          
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully updated!", "department.php");
            }
        }
    }
    
    function retrieve_department($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM stationary_department WHERE department_id = '$id'";
            $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
            
            $row = mysqli_fetch_assoc($rst);
            echo json_encode($row);
        }
    }
    
    function add_department($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['department_code']);
            
            $query = "INSERT INTO stationary_department SET department_code='$name'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "department.php");
            }
        }
    }
?>