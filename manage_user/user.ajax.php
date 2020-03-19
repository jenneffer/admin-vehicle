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
            case 'retrieve_user':
                retrieve_user($id);
                break;
                
            case 'delete_user':
                delete_user($id);
                break;
                
            case 'update_user':
                update_user($data);
                break;
            default:
                break;
        }
    }
    
    function retrieve_user($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM credential WHERE cr_id = '$id'";
            $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
            
            $row = mysqli_fetch_assoc($rst);
            echo json_encode($row);
        }
    }
    
    function delete_user($id){
        global $conn_admin_db;
        if (!empty($id)) {
            $query = "DELETE FROM credential WHERE cr_id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            if ($result) {
                alert ("Deleted successfully", "item.php");
            }
        }
        
    }
    
    function update_user($data){
        global $conn_admin_db;
        
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            $id = $param['id'];
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['name']);
            $username =  mysqli_real_escape_string( $conn_admin_db,$param['username']);
            $email = $param['email'];
            $system = implode(',', $param['system']);
            
            $query = "UPDATE credential SET cr_name='$name', cr_username='$username', cr_email = '$email', cr_access_module = '$system' WHERE cr_id='$id'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully updated!", "item.php");
            }
        }
    }
    ?>