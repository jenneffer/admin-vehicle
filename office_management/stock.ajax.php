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
                
            case 'retrieve_stock':
                retrieve_stock($id);
                break;
                
            case 'add_stock_take':
                add_stock_take($data);
                break;
                
            case 'retrieve_stock_take':
                retrieve_stock_take($id);
                break;
                
            case 'delete_stock':
                delete_stock($id);
                break;
                
            case 'update_stock':
                update_stock($data);
                break;
            
            default:
                break;
        }
    }
    
    function update_stock($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $id = $param['id'];
            $stock_in =  mysqli_real_escape_string( $conn_admin_db,$param['stk_in']);
            
            $query = "UPDATE om_stock
                    SET stock_in='$stock_in' WHERE id='$id'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        }
    }
    
    function delete_stock($id){
        global $conn_admin_db;
        if (!empty($id)) {
            $query = "UPDATE om_stock SET status = 0 WHERE id = '".$id."' ";
            $result = mysqli_query($conn_admin_db, $query);
            if ($result) {
                alert ("Deleted successfully", "stock.php");
            }
        }
    }
    
    function retrieve_stock($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM om_stock WHERE id = '$id'";
            $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
            
            $row = mysqli_fetch_assoc($rst);
            echo json_encode($row);
        }
    }
    
    function retrieve_stock_take($id){
        global $conn_admin_db;
        if (!empty($id)) {
            
            $query = "SELECT * FROM om_stock_take WHERE id = '$id'";
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
            
            $query = "INSERT INTO om_stock 
                    SET item_id='$item_id',
                    stock_in='$stock_in',
                    date_added = now()";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
            //check the item_id if exist in stock balance table          
            $query = "SELECT * FROM om_stock_balance WHERE item_id='$item_id'";
            if(mysqli_num_rows(mysqli_query($conn_admin_db,$query)) > 0){
                //if ada, get the previous balance plus the new 1.
                $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
                $row = mysqli_fetch_array($sql_result);
                //calculate the stock 
                $total = $row['stock_balance'] + $stock_in;
                //update stock balance
                $query_update =  "UPDATE om_stock_balance 
                                SET stock_balance='$total', 
                                last_updated= now(), 
                                updated_by ='".$_SESSION['cr_id']."' 
                                WHERE item_id='$item_id'";
             
                mysqli_query($conn_admin_db,$query_update);
            }
            //insert new if belum exist
            else{
                $query_insert = "INSERT INTO om_stock_balance 
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
            
            $query = "INSERT INTO om_stock_take
                    SET item_id='$item_id',
                    department_id='$department_id',
                    quantity='$quantity',
                    date_taken='".dateFormat($date_taken)."',
                    date_added = now()";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
            //check the item_id if exist in stock balance table
            $query = "SELECT * FROM om_stock_balance WHERE item_id='$item_id'";
            if(mysqli_num_rows(mysqli_query($conn_admin_db,$query)) > 0){
                //if ada, get the previous balance - the new 1.
                $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
                $row = mysqli_fetch_array($sql_result);
                //calculate the stock
                $total = $row['stock_balance'] - $quantity;
                //update stock balance
                $query_update =  "UPDATE om_stock_balance
                                SET stock_balance='$total',
                                last_updated= now(),
                                updated_by ='".$_SESSION['cr_id']."'
                                WHERE item_id='$item_id'";
                
                mysqli_query($conn_admin_db,$query_update);
            }
            
            
        }
    }    
?>