<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;

$today = date( 'Y-m-d' );
$upcoming_renewal = date( 'Y-m-d', strtotime( "+10 days" ) );
//get the data of upcoming fire extinguisher renewal

$query = "SELECT * FROM fireextinguisher_listing fli
        INNER JOIN fireextinguisher_location flo ON flo.location_id = fli.location
        INNER JOIN fireextinguisher_supplier fs ON fs.supplier_id = fli.supplier_id
        INNER JOIN company c ON c.id = fli.company_id
        INNER JOIN credential cr ON cr.cr_id = fli.added_by
        LEFT JOIN fireextinguisher_requisition_form frf ON frf.rq_id = fli.requisition_id
        WHERE expiry_date BETWEEN '".$today."' AND '".$upcoming_renewal."'";

$rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
if ( mysqli_num_rows($rst) > 0 ){
    $data = array();
    while( $row = mysqli_fetch_assoc( $rst ) ){
        
        $email = $row['cr_email'];
        
        $data[$email][] = $row;
    }
    
    foreach ($data as $cr_email => $fe_data){
        $str_fe_data = [];
        foreach ($fe_data as $d){
            $name = $d['cr_name'];
            $str_fe_data[] = "<a>".$d['serial_no']."</a>";
        }
        $str_fe_data = implode("<br/>", $str_fe_data);
        
        mail($cr_email,"Test Email",$str_fe_data);
    }
}

//send email and register to db for email sent


//register sent email to db

?>