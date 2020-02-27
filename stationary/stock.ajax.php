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
            case 'add_new_stock': 
                add_new_stock($data);
                break;
                
            case 'add_stock_take':
                add_stock_take($data);
                break;
                
            case 'retrieve_stock_take':
                retrieve_stock_take($id);
                break;
                
            
            
            default:
                break;
        }
    }
    
    //ITEM
    function delete_item($id){
        global $conn_admin_db;
        if (!empty($id)) {
            $query = "UPDATE stationary_item SET status = 0 WHERE id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            if ($result) {
                alert ("Deleted successfully", "item.php");
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
            
            $query = "UPDATE stationary_item SET item_name='$name' WHERE id='$id'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully updated!", "item.php");
            }
        }
    }
    
    function retrieve_stock_take($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM stationary_stock_take WHERE id = '$id'";
            $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
            
            $row = mysqli_fetch_assoc($rst);
            echo json_encode($row);
        }
    }
    
    function add_new_stock($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $item_id =  mysqli_real_escape_string( $conn_admin_db,$param['item']);
            $stock_in =  mysqli_real_escape_string( $conn_admin_db,$param['stock_in']);
            
            $query = "INSERT INTO stationary_stock 
                    SET item_id='$item_id',
                    stock_in='$stock_in',
                    date_added = now()";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
            //check the item_id if exist in stock balance table          
            $query = "SELECT * FROM stationary_stock_balance WHERE item_id='$item_id'";
            if(mysqli_num_rows(mysqli_query($conn_admin_db,$query)) > 0){
                //if ada, get the previous balance plus the new 1.
                $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error());
                $row = mysqli_fetch_array($sql_result);
                //calculate the stock 
                $total = $row['stock_balance'] + $stock_in;
                //update stock balance
                $query_update =  "UPDATE stationary_stock_balance 
                                SET stock_balance='$total', 
                                last_updated= now(), 
                                updated_by ='".$_SESSION['cr_id']."' 
                                WHERE item_id='$item_id'";
             
                mysqli_query($conn_admin_db,$query_update);
            }
            //insert new if belum exist
            else{
                $query_insert = "INSERT INTO stationary_stock_balance 
                                SET item_id='$item_id',
                                stock_balance='$stock_in',
                                last_updated = now(),
                                updated_by ='".$_SESSION['cr_id']."'";
                
                mysqli_query($conn_admin_db,$query_insert);
            }

        }
    }
    
    function add_stock_take($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $item_id =  mysqli_real_escape_string( $conn_admin_db,$param['item']);
            $department_id =  mysqli_real_escape_string( $conn_admin_db,$param['department']);
            $quantity =  mysqli_real_escape_string( $conn_admin_db,$param['quantity']);
            $date_taken = $param['date_taken'];
            
            $query = "INSERT INTO stationary_stock_take
                    SET item_id='$item_id',
                    department_id='$department_id',
                    quantity='$quantity',
                    date_taken='".dateFormat($date_taken)."',
                    date_added = now()";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
            //check the item_id if exist in stock balance table
            $query = "SELECT * FROM stationary_stock_balance WHERE item_id='$item_id'";
            if(mysqli_num_rows(mysqli_query($conn_admin_db,$query)) > 0){
                //if ada, get the previous balance - the new 1.
                $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error());
                $row = mysqli_fetch_array($sql_result);
                //calculate the stock
                $total = $row['stock_balance'] - $quantity;
                //update stock balance
                $query_update =  "UPDATE stationary_stock_balance
                                SET stock_balance='$total',
                                last_updated= now(),
                                updated_by ='".$_SESSION['cr_id']."'
                                WHERE item_id='$item_id'";
                
                mysqli_query($conn_admin_db,$query_update);
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
            
            $query = "UPDATE stationary_department SET department_name='$name' WHERE department_id='$id'";          
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
            
            $name =  mysqli_real_escape_string( $conn_admin_db,$param['department_name']);
            
            $query = "INSERT INTO stationary_department SET department_name='$name'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "department.php");
            }
        }
    }
?>