<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";
$data = isset($_POST['data']) ? $_POST['data'] : "";
$id = isset($_POST['id']) ? $_POST['id'] : "";
$invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : "";

if($action !=""){
    switch ($action){
        case 'add_new_statement':
            add_new_statement($data, $invoice_no);
            break;
            
        case 'display_abx_statement_list':
            display_abx_statement_list();
            break;
            
        case 'delete_data':
            delete_data($id);
            break;
            
        default:
            break;
    }    
}

function delete_data($id){
    global $conn_admin_db;
    if(!empty($id)){
        $query = "UPDATE om_abx_statement SET status='0' WHERE id='$id'";
        $rst = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        
    }
}

function display_abx_statement_list(){
    global $conn_admin_db;
    $query = "SELECT abx_id, invoice_no, SUM(amount) AS total_amount, date_added FROM om_abx_statement
            INNER JOIN om_abx_statement_list ON om_abx_statement.id = om_abx_statement_list.abx_id
            WHERE om_abx_statement.status='1'
            GROUP BY abx_id";
    
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => 0,
        'iTotalDisplayRecords' => 0,
        'aaData' => array()
    );
    $arr_data = array();
    $total_found_rows = 0;
    if ( mysqli_num_rows($rst) ){
        $count = 0;
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
            $total_found_rows = $row_found[0];            
            $count++;
//             <span id='.$row['abx_id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
//             </span>
            $action = '<span id='.$row['abx_id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                        </span>';
            
            $invoice_no = '<a href="abx_statement_details.php?abx_id='.$row['abx_id'].'">'.$row['invoice_no'].'</a>';
            
            $data = array(
                $count.".",
                $invoice_no,
                $row['total_amount'],
                dateFormatRev($row['date_added']),
                $action
            );
            $arr_data[] = $data;
        }
    }
    
    $arr_result = array(
        'sEcho' => 0,
        'iTotalRecords' => $total_found_rows,
        'iTotalDisplayRecords' => $total_found_rows,
        'aaData' => $arr_data
    );
    
    echo json_encode($arr_result);
}

function add_new_statement($data, $invoice_no){    
    global $conn_admin_db;    
    if (!empty($data)) {          
        $query = "INSERT INTO om_abx_statement SET invoice_no = '$invoice_no', date_added = NOW()";
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_connect_error());
        $last_insert_id = mysqli_insert_id($conn_admin_db);
        foreach ($data as $value){            
            $values[] = "('$last_insert_id','".dateFormat($value['date'])."','".$value['airbill_no']."','".$value['particular']."','".$value['company_id']."','".$value['requested_by']."','".$value['charge']."','".$value['tax']."','".$value['amount']."')";         
        }        
        $valuee = implode(",", $values);        
    }
    
    $abx_query = "INSERT INTO om_abx_statement_list(abx_id, date, airbill_no, particular, company_id, requested_by, charge, tax, amount) VALUES ".$valuee;    
    $rst = mysqli_query($conn_admin_db, $abx_query) or die(mysqli_connect_error());
        
    echo json_encode($rst);
}

function retrieve_request($id){
    global $conn_admin_db;
    if (!empty($id)) {
        
        $query = "SELECT * FROM om_pcash_request WHERE id = '$id'";
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
}

?>