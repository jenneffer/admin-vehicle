<?php  
    require_once('../assets/config/database.php');
    require_once('./function.php');
    global $conn_admin_db;
    
    if(!empty($_POST)){
        $table_name = $_POST['table_name'];
        $updated_id = $_POST['id'];
        $col_identifier = $_POST['col_identifier'];
        $reload_loc = $_POST['reload_location'];
        $query = "UPDATE $table_name SET status = 0 WHERE $col_identifier = '".$updated_id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", $reload_loc);
        }
        
    }
    
?>