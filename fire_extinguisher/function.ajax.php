<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();
    
    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('31-12-Y');
    $fe_status = isset($_POST['fe_status']) ? $_POST['fe_status'] : "";
    
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
                master_listing( $date_start, $date_end, $fe_status );
                break;
                
            case 'add_new_location':
                add_new_location($data);
                break;
                
            case 'add_new_pic':
                add_new_pic($data);
                break;
                
            case 'delete_listing':
                delete_listing($id);
                break;
                
            case 'retrieve_listing':
                retrieve_listing($id);
                break;
                
            case 'update_master_listing':
                update_master_listing($data);
                break;
                
            default:
                break;
        }
    }
    
    function update_master_listing($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            $id = $param['id'];
            $serial_no = $param['serial_no'];
            $expiry_date = $param['expiry_date'];
            $company = $param['company'];
            $pic = $param['pic'];
            $remark = $param['remark'];
            $location = $param['location'];
            $fe_status = $param['fe_status'];
            
            $query = "UPDATE fireextinguisher_listing
                            SET serial_no = '$serial_no',
                            location = '$location',
                            company_id = '$company',
                            person_incharge = '$pic',
                            expiry_date = '".dateFormat($expiry_date)."',
                            remark = '".$remark."',
                            fe_status = '".$fe_status."'
                            WHERE id='".$id."'";
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            
        }
    }
    
    function retrieve_listing($id){
        global $conn_admin_db;
        
        $query = "SELECT * FROM fireextinguisher_listing fli
                INNER JOIN fireextinguisher_location flo ON flo.location_id = fli.location
                INNER JOIN company c ON c.id = fli.company_id
                INNER JOIN fireextinguisher_person_incharge fpi ON fli.person_incharge = fpi.pic_id AND fli.status=1
                WHERE fli.id = '$id'";
        
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
    
    function delete_listing($id) {
        global $conn_admin_db;
        $query = "UPDATE fireextinguisher_listing SET status = 0 WHERE id = '".$id."' ";
        $result = mysqli_query($conn_admin_db, $query);
        if ($result) {
            alert ("Deleted successfully", "listing.php");
        }
    }
    
    function add_new_pic($data){
        global $conn_admin_db;
        if (!empty($data)) {
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            
            $person_name = mysqli_real_escape_string( $conn_admin_db,$param['pic_name']);
            $person_contact = mysqli_real_escape_string( $conn_admin_db, $param['pic_contact'] );
            
            $query = "INSERT INTO fireextinguisher_person_incharge SET
                pic_name = '".$person_name."',
                pic_contactNo = '".$person_contact."',
                date_added = now(),
                added_by = '".$_SESSION['cr_id']."'";
            
            $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
            if ($result) {
                alert("Successfully added!", "location_add_new.php");
            }
        }      
    }
    
    function master_listing( $date_start, $date_end, $status ){
        global $conn_admin_db;
        $query = "SELECT fli.id AS fe_id, model, serial_no, expiry_date, remark, fli.fe_status AS fe_status, location_name, c.code AS comp_code, pic_name, pic_contactNo FROM fireextinguisher_listing fli
                INNER JOIN fireextinguisher_location flo ON flo.location_id = fli.location
                INNER JOIN company c ON c.id = fli.company_id
                INNER JOIN fireextinguisher_person_incharge fpi ON fli.person_incharge = fpi.pic_id AND fli.status=1";
        
        if(!empty($date_start) && !empty($date_end)){
            $query .= " WHERE fli.expiry_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' ";
            
        }
        if (!empty($status)){
            $query .= " AND fe_status='".$status."'";
        }
        $query .= " ORDER BY fli.expiry_date ASC, c.code";

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

                $status = "";
                switch ($row['fe_status']){
                    case 1:
                        $status = "Pending";
                        break;
                    case 2:
                        $status = "Active";
                        break;
                    case 3:
                        $status = "Reject";
                        break;
                    case 4:
                        $status = "Hold";
                        break;
                    case 5:
                        $status = "Expired";
                        break;
                    default:
                        break;
                }
                
                $count++;
                $action = '<span id='.$row['fe_id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
                                </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span id='.$row['fe_id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                                </span>';
                $data = array(
                    $count.".",
                    $row['model'],
                    $row['comp_code'],
                    $row['location_name'],
                    $row['pic_name'],
                    $row['serial_no'],
                    dateFormatRev($row['expiry_date']), 
                    $status,
                    $row['remark'],
                    $row['pic_contactNo'],
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
            $remark = mysqli_real_escape_string( $conn_admin_db, $param['remark'] );
            $location = $param['location'];
            $model = $param['model'];
            $person_incharge = $param['pic'];
            
            $query = "INSERT INTO fireextinguisher_listing SET
                serial_no = '".$serial_no."',
                location = '".$location."',
                company_id = '".$company."',
                person_incharge = '".$person_incharge."',
                model = '".$model."',
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