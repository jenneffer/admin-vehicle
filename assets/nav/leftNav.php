
<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;

$system_id = $_SESSION['system_id'];
//test populate menu from database
$query = "SELECT * FROM admin_system
            INNER JOIN main_menu ON main_menu.sid = admin_system.sid
            INNER JOIN sub_menu ON sub_menu.mid = main_menu.mid
            WHERE admin_system.sid='$system_id' AND status='1' ORDER BY main_menu.mid, sub_menu.position";

$rst  = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
if ( mysqli_num_rows($rst) > 0 ){
    $data = array();
    $menu_item = [];
    while( $row = mysqli_fetch_assoc( $rst ) ){
        $system_title = $row['sname'];
        $menu_item[$row['title']]['data'][]= array(
            'sub_menu_title' =>  $row['menu_title'],
            'sub_menu_url' =>  $row['menu_url'],
            'sub_menu_icon' =>  $row['menu_icon'],
        );
        $menu_item[$row['title']]['icon'] = $row['icon'];
    }
    $data[$system_title] = $menu_item;
}


?>
    <!-- Left Panel -->
   
   <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
			<div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                <?php foreach ($data as $sys_title => $item_menu){?>
        			<li class="menu-title"><?=$sys_title?></li><!-- /.menu-title -->
        			<?php foreach ($item_menu as $m_title => $sub_item){?>
        			<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon <?=$sub_item['icon'];?>"></i><?=$m_title?></a>
                        <ul class="sub-menu children dropdown-menu">
                            <?php foreach ($sub_item['data'] as $item ){?>
                            	<li><a href="<?=$item['sub_menu_url']?>"><i class="menu-icon <?=$item['sub_menu_icon']?>"></i><?=$item['sub_menu_title'];?></a></li>
                            <?php }?>
                        </ul>
                    </li>
        			    
        			<?php }?>            
    	
                <?php }?>

                    

<!--                     <li class="menu-item-has-children dropdown"> -->
<!--                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Listing</a> -->
<!--                         <ul class="sub-menu children dropdown-menu"> -->
<!--         					<li><a href="driver.php"><i class="menu-icon fa fa-users"></i>Driver </a></li> --> 
<!--                             <li><a href="vehicle.php"><i class="menu-icon fa fa-truck"></i>Vehicle List </a></li> -->
<!--                             <li><a href="puspakom.php"><i class="menu-icon fa fa-book"></i>Puspakom </a></li> -->
<!--                             <li><a href="roadtax.php"><i class="menu-icon fa fa-road"></i>Roadtax </a></li> -->
<!--                             <li><a href="summons.php"><i class="menu-icon fa fa-print"></i>Summons</a></li> -->
<!--                         </ul> -->
<!--                     </li> -->
<!--                     <li class="menu-item-has-children dropdown"> -->
<!--                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Reports</a> -->
<!--                         <ul class="sub-menu children dropdown-menu"> -->
<!--                             <li><a href="summons_vehicle_report.php"><i class="menu-icon fas fa-file-alt"></i>Vehicle Summons</a></li> -->
<!--                             <li><a href="roadtax_summary_report.php"><i class="menu-icon fas fa-book"></i>Road Tax Summary</a></li> -->
<!--                             <li><a href="renewing_vehicle_schedule_report.php"><i class="menu-icon fa fa-list-alt"></i>Renewing Schedule</a></li> -->
<!--                             <li><a href="general_table_report.php"><i class="menu-icon fa fa-table"></i>General Table</a></li> -->
<!--                         </ul> -->
<!--                     </li> -->
                    
                    <!--<li class="menu-title">Extras</li> /.menu-title -->
<!--                     <li class="menu-item-has-children dropdown"> -->
<!--                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i><strong>User</strong></a> -->
<!--                         <ul class="sub-menu children dropdown-menu"> -->
<!--                             <li><i class="menu-icon fa fa-sign-in"></i><a href="login.php">Login</a></li> -->
<!--                             <li><i class="menu-icon fa fa-sign-out"></i><a href="page-register.html">Logout</a></li> -->
<!--                             <li><i class="menu-icon fa fa-paper-plane"></i><a href="pages-forget.html">Forget Pass</a></li> -->
<!--                         </ul> -->
<!--                     </li> -->
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->