<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;

$today = date( 'Y-m-d' );
$upcoming_renewal = date( 'Y-m-d', strtotime( "+30 days" ) );
$system_id = $_SESSION['system_id'];
$data = array();
if( $system_id != "" ){    
    switch ($system_id){
        case '1': //vehicle
            $data = vehicle_notification($today, $upcoming_renewal);
            break;  
            
        case '2': //stationary
            $data = stationary_notification($today, $upcoming_renewal);
            break; 
            
        case '3': //fire extinguisher
            $data = fire_extinguisher_notification($today, $upcoming_renewal);
            break;  
            
        case '4': //add user
            $data = add_user_notification($today, $upcoming_renewal);
            break;   
            
        case '5': //bill
            $data = bill_notification($today, $upcoming_renewal);
            break;   
            
        case '6': //office management
            $data = office_management_notification($today, $upcoming_renewal);
            break;  
            
        default:
            break;
            
        return $data;
    }
}

function stationary_notification($today, $upcoming_renewal){
    $count = 0;
    $datas = array();
    
    $arr_data = array(
        'data' => $datas,
        'count' => $count
    );
    return $arr_data;
}

function fire_extinguisher_notification($today, $upcoming_renewal){
//     $today = '2020-04-01';
//     $upcoming_renewal = '2020-12-31';

    global $conn_admin_db;
    $count = 0;
    $datas = array();
    
    $query = "SELECT fli.id, serial_no AS reference, expiry_date AS due_date, c.code AS company_code FROM fe_master_listing fli
        INNER JOIN fe_location flo ON flo.location_id = fli.location_id
        INNER JOIN company c ON c.id = fli.company_id        
        WHERE expiry_date BETWEEN '".$today."' AND '".$upcoming_renewal."' AND fli.status !='3'";
    
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    while( $row = mysqli_fetch_assoc( $rst ) ){
        $datas[] = $row;
    }
    
    $count = count($datas);
    $arr_data = array(
        'data' => $datas,
        'count' => $count
    );
    return $arr_data;
}

function add_user_notification($today, $upcoming_renewal){
    $count = 0;
    $datas = array();
    
    $arr_data = array(
        'data' => $datas,
        'count' => $count
    );
    return $arr_data;
}

function bill_notification($today, $upcoming_renewal){
    $count = 0;
    $datas = array();
    
    $arr_data = array(
        'data' => $datas,
        'count' => $count
    );
    return $arr_data;
}

function office_management_notification($today, $upcoming_renewal){
    $count = 0;
    $datas = array();
    
    $arr_data = array(
        'data' => $datas,
        'count' => $count
    );
    return $arr_data;
}

function vehicle_notification($today, $upcoming_renewal) {   
    global $conn_admin_db;
    
    $query = "SELECT vpr_id AS id, vpr_due_date AS due_date, vv_vehicleNo AS reference,
        (SELECT CODE FROM company WHERE id = vehicle_vehicle.company_id) AS company_code
        FROM vehicle_permit
        LEFT JOIN vehicle_vehicle ON vehicle_vehicle.vv_id = vehicle_permit.vv_id
        WHERE vpr_due_date BETWEEN '".$today."' AND '".$upcoming_renewal."' AND renewal_status=0";
    
    $rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));    
    $count = 0;
    $datas = array();
    if ( mysqli_num_rows($rst) > 0 ){
        while( $row = mysqli_fetch_assoc( $rst ) ){
            $datas[] = $row;
        }
        $count = count($datas);
    }
    
    $arr_data = array(
        'data' => $datas,
        'count' => $count
    );
    return $arr_data;
}



?>

<!-- <div id="right-panel" class="right-panel"> -->
        <!-- Header-->
	<div id="right-panel" class="right-panel">	
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../"><img src="../images/loginLogo.png" alt="Logo"></a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
			
			<div class="top-right">
                <div class="header-menu">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" style="text-decoration: underline; color:#f7c208; font-weight: bold;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $name?>&nbsp;<i class="fa fa-angle-down"></i>
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fas fa-user"></i>&nbsp;&nbsp;My Profile</a>
                            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Logout</a>
                        </div>
                    </div>
                </div>               
            </div>
         </header>
	</div>
            <!-- -->
