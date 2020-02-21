<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();
    
    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    if( $action != "" ){
        switch ($action){            
            case 'add_new_supplier': 
                add_new_supplier($data);
                break;
                
            case 'add_new_listing':
                add_new_listing($data);
                break;
                
            case 'supplier_listing':
                supplier_listing();
                break;
                
            case 'master_listing':
                master_listing();
                break;
                
            case 'add_new_location':
                add_new_location($data);
                break;
                
            default:
                break;
        }
    }
    
    function master_listing(){
        global $conn_admin_db;
        
        $query = "SELECT * FROM fireextinguisher_listing fli
                INNER JOIN fireextinguisher_location flo ON flo.location_id = fli.location
                INNER JOIN fireextinguisher_supplier fs ON fs.supplier_id = fli.supplier_id
                INNER JOIN company c ON c.id = fli.company_id
                LEFT JOIN fireextinguisher_requisition_form frf ON frf.rq_id = fli.requisition_id";
        
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
                $action = '<span id='.$row['id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
                                </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span id='.$row['id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                                </span>';
                $data = array(
                    $count,
                    $row['serial_no'],
                    $row['code'],
                    $row['supplier_name'],
                    $row['location_name'],
                    dateFormatRev($row['expiry_date']),                    
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
    
    function supplier_listing(){
        
    }
    
    function add_new_location($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $location_code = $param['location_code'];
            $location_name = mysqli_real_escape_string( $conn_admin_db, $param['location_name'] );
            
            $query = "INSERT INTO fireextinguisher_location SET
                location_code = '".$location_code."',
                location_name = '".$location_name."',
                date_added = now(),
                added_by = '".$_SESSION['cr_id']."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "location_add_new.php");
            }
        }        
    }
    
    function add_new_listing($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $serial_no = $param['serial_no'];
            $expiry_date = $param['expiry_date'];
            $company = $param['company'];
            $supplier = $param['supplier'];
            $requisition_no = $param['requisition_no'];
            $invoice_no = $param['invoice_no'];
            $remark = mysqli_real_escape_string( $conn_admin_db, $param['remark'] );
            $location = $param['location'];
            
            $query = "INSERT INTO fireextinguisher_listing SET
                serial_no = '".$serial_no."',
                location = '".$location."',
                company_id = '".$company."',
                supplier_id = '".$supplier."',
                invoice_no = '".$invoice_no."',
                requisition_id = '".$requisition_no."',
                expiry_date = '".dateFormat($expiry_date)."',
                date_added = now(),
                added_by = '".$_SESSION['cr_id']."',
                approved_by = '',
                remark = '".$remark."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "listing_add_new.php");
            }
        }
    }
    
    function add_new_supplier($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $supplier_name = mysqli_real_escape_string( $conn_admin_db, $param['supplier_name'] );
            $supplier_contact_person = mysqli_real_escape_string( $conn_admin_db, $param['supplier_contact_person'] );
            $supplier_contact_no = $param['supplier_contact_no'];
            $supplier_address = mysqli_real_escape_string( $conn_admin_db, $param['supplier_address'] );
            
            $query = "INSERT INTO fireextinguisher_supplier SET
                supplier_name = '".$supplier_name."',
                supplier_contact_person = '".$supplier_contact_person."',
                supplier_contact_no = '".$supplier_contact_no."',
                supplier_address = '".$supplier_address."',
                added_by = '".$_SESSION['cr_id']."',
                date_added = now()";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "supplier_add_new.php");
            }

        }
        
    }
?>