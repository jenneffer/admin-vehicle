<?php 
    require_once('../assets/config/database.php');
    require_once('../function.php');
    global $conn_admin_db;
    session_start();
    
    $action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
    $data = isset($_POST['data']) ? $_POST['data'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
    $fe_status = isset($_POST['fe_status']) ? $_POST['fe_status'] : "";
    $company = isset($_POST['company']) ? $_POST['company'] : "";
    $pic = isset($_POST['pic']) ? $_POST['pic'] : "";
    
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
                master_listing( $date_start, $date_end, $fe_status, $company, $pic );
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
                
            case 'update_renewal_date':
                update_renewal_date($data);
                break;
            default:
                break;
        }
    }
    
    function update_renewal_date($data){
        global $conn_admin_db;
        if(!empty($data)){
            $param = array();
            parse_str($_POST['data'], $param); //unserialize jquery string data
            $fe_id = $param['fe_id'];
            //get all the previous info
            $query = "SELECT * FROM fe_master_listing WHERE id='$fe_id'";
            $rst = mysqli_query($conn_admin_db, $query) or mysqli_errno($conn_admin_db);
            $row = mysqli_fetch_assoc($rst);
            $new_date = dateFormat($param['new_date']);
            
            //insert new records
            $insert_new_query = "INSERT INTO fe_master_listing (model_id, company_id, location_id, person_incharge_id, serial_no, expiry_date)
                                VALUES(".$row['model_id'].", ".$row['company_id'].", ".$row['location_id'].", ".$row['person_incharge_id'].", '".$row['serial_no']."' ,".$new_date.")";

            mysqli_query($conn_admin_db, $insert_new_query) or mysqli_error($conn_admin_db);
            
            //update previous status
            $update_status = mysqli_query($conn_admin_db, "UPDATE fe_master_listing SET status='3' WHERE id='$fe_id'"); 
            
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
            $company = $param['company_edit'];
            $pic = $param['pic'];
            $remark = $param['remark'];
            $location = $param['location'];
            $fe_status = $param['fe_status'];
            
            $query = "UPDATE fe_master_listing
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
        
        $query = "SELECT fli.id, model_id, company_id, fli.location_id, person_incharge_id, serial_no, expiry_date, fli.status, c.code, fpi.pic_name, pic_contact_no,fm.id FROM fe_master_listing fli
                INNER JOIN fe_location flo ON flo.location_id = fli.location_id
                INNER JOIN company c ON c.id = fli.company_id
                INNER JOIN fe_person_incharge fpi ON fli.person_incharge_id = fpi.pic_id 
                INNER JOIN fe_model fm ON fm.id = fli.model_id
                WHERE fli.id = '$id'";
        
        $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
        
        $row = mysqli_fetch_assoc($rst);
        echo json_encode($row);
    }
    
    function delete_listing($id) {
        global $conn_admin_db;
        $query = "UPDATE fe_master_listing SET status = 0 WHERE id = '".$id."' ";
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
            
            $query = "INSERT INTO fe_person_incharge SET
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
    
    function master_listing( $date_start, $date_end, $status, $company, $pic ){
        global $conn_admin_db;
        $query = "SELECT fli.id, serial_no, expiry_date, fli.`status`, remark, location_name,c.code,pic_name, pic_contact_no, fm.name  FROM fe_master_listing fli
                INNER JOIN fe_location flo ON flo.location_id = fli.location_id
                INNER JOIN company c ON c.id = fli.company_id
                INNER JOIN fe_person_incharge fpi ON fli.person_incharge_id = fpi.pic_id 
                INNER JOIN fe_model fm ON fm.id = fli.model_id WHERE fli.status !='3'";
        
        if(!empty($date_start) && !empty($date_end)){
            $query .= " AND fli.expiry_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' ";
            
        }
        if(!empty($status)){
            $query .=" AND fli.status='$status'";
        }
        if(!empty($company)){
            $query .=" AND fli.company_id='$company'";
        }
        if(!empty($pic)){
            $query .=" AND fli.person_incharge_id='$pic'";
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

                $status = ( $row['status']==1 ) ? "ACTIVE":"EXPIRED";
                $phone_no = !empty($row['pic_contact_no']) ? "(".$row['pic_contact_no'].")" : "";
                $count++;
                $action = '<span id='.$row['id'].' data-toggle="modal" class="edit_data" data-target="#editItem"><i class="menu-icon fa fa-edit"></i>
                                </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <span id='.$row['id'].' data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="menu-icon fa fa-trash-alt"></i>
                                </span>';
                
                $serial_no = '<a href="#updateRenewal" id='.$row['id'].' role="button" class="btn update_date" data-toggle="modal" data-value="'.$row['serial_no'].'">'.$row['serial_no'].'</a>';
                
                
                $data = array(
                    $count.".",
                    $row['name'],
                    $row['code'],
                    $row['location_name'],
                    $row['pic_name']."<br>" .$phone_no,
                    $serial_no,
                    dateFormatRev($row['expiry_date']), 
                    $status,
                    $row['remark'],                    
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
            
            $query = "INSERT INTO fe_location SET
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
            
            $query = "INSERT INTO fe_listing SET
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
            
            $query = "INSERT INTO fe_supplier SET
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