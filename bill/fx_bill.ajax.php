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
        case 'add_new_account':
            add_new_account($data);
            break;
            
        case 'retrieve_account':
            retrieve_account($id);
            break;
            
        case 'delete_account':
            delete_account($id);
            break;
            
        case 'add_new_bill':
            add_new_bill($data);
            break;
            
        default:
            break;
    }
}


function add_new_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($_POST['data'], $param); //unserialize jquery string data       
        $acc_id = $param['acc_id'];
        $date_entered = $param['date'];
        $full_color = $param['full_color'];
        $black_white = $param['black_white'];
        $color_a3 = $param['color_a3'];
        $copy = $param['copy'];
        $print = $param['print'];
        $fax = $param['fax'];
        $total = 0;
        if(!empty($full_color) && !empty($black_white)){
            $total = $full_color + $black_white;
        }
        elseif (!empty($copy) || !empty($print) || !empty($fax)){
            $total = $copy + $print + $fax;
        }
        
        $query = "INSERT INTO bill_fuji_xerox SET acc_id = '$acc_id',
            date = '".dateFormat($date_entered)."',
            full_color = '$full_color',
            black_white = '$black_white',
            color_a3 = '$color_a3',
            copy = '$copy',
            print = '$print',
            fax = '$fax',
            total = '$total'";
        
        mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    
    }
    
    
}

function add_new_account($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data        
        $company =  mysqli_real_escape_string( $conn_admin_db,$param['company']);
        $serial_no =  mysqli_real_escape_string( $conn_admin_db,$param['acc_no']);
        $location =  mysqli_real_escape_string( $conn_admin_db,$param['location']);        
        $remark =  mysqli_real_escape_string( $conn_admin_db,$param['remark']);
        $query_insert_telekom = "INSERT INTO bill_fuji_xerox_account SET
                        company='$company',
                        serial_no='$serial_no',                        
                        remark='$remark',                        
                        location='$location'";
        
        mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));              
    }    
}
function retrieve_account($id){
    global $conn_admin_db;
    if (!empty($id)) {        
        $query = "SELECT * FROM bill_fuji_xerox_account WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

function delete_account($id){
    global $conn_admin_db;
    if (!empty($id)) {
        $query = "UPDATE bill_fuji_xerox_account SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "telekom_setup.php");
        }
    }
}

//to round up0.05
function round_up($x){
    return round($x * 2, 1) / 2;
}
?>