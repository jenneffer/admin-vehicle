<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : "";
$data = isset($_POST['data']) ? $_POST['data'] : "";
$id = isset($_POST['id']) ? $_POST['id'] : "";
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : "";
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

switch ($action){
    case 'get_chart_data':
        get_chart_data($id, $date_start, $date_end);
        break;
        
    case 'get_department_usage':
        get_department_usage($id, $year);
        break;
        
    default:
        break;
}

function get_department_usage($department_id, $year){
    global $conn_admin_db;
    $query = "SELECT * FROM stationary_stock_take WHERE YEAR(date_taken)='".$year."' AND department_id='$department_id' ORDER BY date_taken ASC";
   
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $arr_result = [];
    $data_monthly = [];
    $month = 12;
    while ($row = mysqli_fetch_assoc($result)) {
        $date_taken = $row['date_taken'];
        $month_data = date_parse_from_format("Y-m-d", $date_taken);
        $mo = $month_data["month"];
        
        for ( $m=1; $m<=$month; $m++ ){
            if($m == $mo){
                if (isset($arr_result[$row['item_id']][$m])){
                    $arr_result[$row['item_id']][$m] += $row['quantity'];
                }else{
                    $arr_result[$row['item_id']][$m] = $row['quantity'];
                }
            }
        }
        $data_monthly = $arr_result;
    }
    
    //initialise monthly value
    $month_map = array(
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
        9 => 0,
        10 => 0,
        11 => 0,
        12 => 0
    );
    
    $datasets = [];
    foreach ($data_monthly as $label => $data){
        $month_data = array_replace($month_map, $data);
        $itemName = itemName("SELECT item_name FROM stationary_item WHERE id='$label'");        
        $datasets[] = array(
            'label' => $itemName,
            'backgroundColor' => 'transparent',
            'borderColor' => randomColor(),
            'borderWidth' => 3,
            'lineTension' => 0,
            'data' => array_values($month_data)
        );
    }
    $department = itemName("SELECT department_name FROM stationary_department WHERE department_id='$department_id'");
    $data = array(
        'department' => $department,
        'datasets' => $datasets
    );
    
    echo json_encode($data);
}


// get_chart_data(20, '01-06-2020', '31-06-2020');
function get_chart_data($item_id, $date_start, $date_end){
    global $conn_admin_db;
    
    $query = "SELECT department_id, SUM(quantity) AS quantity from stationary_stock_take
        WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND item_id='$item_id'
        GROUP BY department_id";
    // echo $query;
    $item_name = itemName("SELECT item_name FROM stationary_item WHERE id='$item_id'");
    $result = mysqli_query($conn_admin_db, $query);    
    $arr_data = [];    
    $item_summary = get_item_summary($item_id, $date_start, $date_end);
    
    // $hoverBackgroundColor = [];
    while ($row = mysqli_fetch_array($result)){
        $department = itemName("SELECT department_name FROM stationary_department WHERE department_id='".$row['department_id']."'");
        
        //get the item summary
        
        $arr_data[] = array(
            'item_name' => $item_name,
            'label' => $department,
            'data' => $row['quantity'],
            'backgroundColor' => randomColor()
        );        
    }

    
    $data = array(
        'chart_data' => $arr_data,
        'item_summary' => $item_summary
    );
//     var_dump($data);
    echo json_encode($data);
    
//     $label = implode("','",$label);
//     $data = implode(",", $data);
//     $backgroundColor = implode("','", $backgroundColor);
    // $hoverBackgroundColor = implode("','", $hoverBackgroundColor);    
}

function get_item_summary($item_id, $date_start, $date_end){
    global $conn_admin_db;
    
    $query = "SELECT * from stationary_stock_take
        WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND item_id='".$item_id."' ORDER BY quantity DESC";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => 0,
//         'iTotalDisplayRecords' => 0,
//         'aaData' => array()
//     );
    $arr_summary = [];
//     $total_found_rows = 0;
    if ( mysqli_num_rows($result) ){
//         $count = 0;
        while ($row = mysqli_fetch_array($result)) {
//             $count++;
//             $row_found = mysqli_fetch_row(mysqli_query($conn_admin_db,"SELECT FOUND_ROWS()"));
//             $total_found_rows = $row_found[0];
            $dept_name = itemName("SELECT department_name FROM stationary_department WHERE department_id='".$row['department_id']."'");
            $dept = ($row['staff_name'] == NULL) ? $dept_name : $row['staff_name']."(".$dept_name.")";
            
            $data = array(
                $dept,
                dateFormatRev($row['date_taken']),
                $row['quantity']
            );
            
            $arr_summary[] = $data;
        }
    }
//     $arr_result = array(
//         'sEcho' => 0,
//         'iTotalRecords' => $total_found_rows,
//         'iTotalDisplayRecords' => $total_found_rows,
//         'aaData' => $arr_summary
//     );
    return $arr_summary;
}

// function randomColor(){
//     //Create a loop.
//     $rgbColor = array();
//     foreach(array('r', 'g', 'b') as $color){
//         //Generate a random number between 0 and 255.
//         $rgbColor[$color] = mt_rand(0, 255);
//     }
//     $rgbColor = "rgba(".implode(",", $rgbColor).",0.8)";
//     return $rgbColor;
// }

?>