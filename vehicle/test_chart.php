<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";
$comp_name = itemName("SELECT name FROM company WHERE id='$select_c'");

ob_start();
selectYear('year_select',$year_select,'submit()','','form-control','','');
$html_year_select = ob_get_clean();

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

function get_insurance_data($company, $year){ //sum insured & premium amount
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id        
        WHERE YEAR(vi_insurance_dueDate)='".$year."'";
    
    if (!empty($company)){
        $query .= " AND company_id='$company'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $data_monthly_premium = []; //show premium data by month for selected company
    $data_monthly_sum_insured = []; //show sum_insured data by month for selected company
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        if (!empty($company)) {
            $ins_due_date = $row['vi_insurance_dueDate'];
            $ins_month = date_parse_from_format("Y-m-d", $ins_due_date);
            $ins_m = $ins_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $ins_m){
                    //premium
                    if (isset($data_monthly_premium[$m])){
                        $data_monthly_premium[$m] += $row['vi_premium_amount'];
                    }else{
                        $data_monthly_premium[$m] = $row['vi_premium_amount'];
                    }
                    
                    //sum  insured
                    if (isset($data_monthly_sum_insured[$m])){
                        $data_monthly_sum_insured[$m] += $row['vi_sum_insured'];
                    }else{
                        $data_monthly_sum_insured[$m] = $row['vi_sum_insured'];
                    }
                }
            }
        }
        $data[$row['code']][] = array(
            'premium' => $row['vi_premium_amount'],
            'sum_insured' => $row['vi_sum_insured']
        );
    }
    
    $result = array(
        'all_data' => $data,
        'data_monthly_premium' => $data_monthly_premium,
        'data_monthly_sum_insured' => $data_monthly_sum_insured
    );
    return $result;
}

function get_roadtax_data( $company, $year ){
    global $conn_admin_db;
    $query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vrt_roadTax_fromDate, vrt_roadTax_dueDate, vrt_roadTax_period, vrt_amount FROM vehicle_vehicle 
            INNER JOIN vehicle_roadtax ON vehicle_vehicle.vv_id = vehicle_roadtax.vv_id
            WHERE YEAR(vrt_roadTax_dueDate)='".$year."'";
    
    if (!empty($company)){
        $query .= " AND company_id='$company'";
    }
    $sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
    $data = []; //show all company
    $data_monthly_roadtax = []; //show roadtax data by month for selected company
    $month = 12;
    while($row = mysqli_fetch_assoc($sql_result)){
        if(!empty($company)){
            $rt_due_date = $row['vrt_roadTax_dueDate'];
            $rt_month = date_parse_from_format("Y-m-d", $rt_due_date);
            $rt_m = $rt_month["month"];
            for ( $m=1; $m<=$month; $m++ ){
                if($m == $rt_m){
                    //premium
                    if (isset($data_monthly_roadtax[$m])){
                        $data_monthly_roadtax[$m] += $row['vrt_amount'];
                    }else{
                        $data_monthly_roadtax[$m] = $row['vrt_amount'];
                    }
                }
            }
        }               
        $data[$row['code']][] = array(
            'roadtax' => $row['vrt_amount']            
        );
    }
    
    $result = array(
        'all_data' => $data,
        'data_monthly_roadtax' => $data_monthly_roadtax
    );
    return $result;
}

$data_roadtax = get_roadtax_data($select_c, $year_select);
$rt_all_data = $data_roadtax['all_data'];

$data_monthly_roadtax = $data_roadtax['data_monthly_roadtax'];
$arr_monthly_roadtax = array_replace($month_map, $data_monthly_roadtax);

$roadtax = array_values($arr_monthly_roadtax);
$data_roadtax_monthly = implode(",", $roadtax);

$arr_roadtax = [];
foreach ($rt_all_data as $key => $value) {
    $rt_company[] = $key;
    foreach ($value as $val) {
        if(isset($arr_roadtax[$key])){
            $arr_roadtax[$key] += $val['roadtax'];
        }else{
            $arr_roadtax[$key] = $val['roadtax'];
        } 
    }
    
}
$rt_company_str = !empty($rt_company) ? implode("','",$rt_company) : "";
// $data_rt = array_values($arr_roadtax);
// $data_rtx = implode(",", $data_rt);

$data_insurance = get_insurance_data($select_c, $year_select);
$ins_data_all = $data_insurance['all_data'];
$data_monthly_premium = $data_insurance['data_monthly_premium'];
$data_monthly_sum_insured = $data_insurance['data_monthly_sum_insured'];
// var_dump($data_monthly_sum_insured);

$arr_monthly_premium = array_replace($month_map, $data_monthly_premium);
$arr_monthly_sum_insured = array_replace($month_map, $data_monthly_sum_insured);

$premium = array_values($arr_monthly_premium);
$data_premium_monthly = implode(",", $premium);

$sum_insured = array_values($arr_monthly_sum_insured);
$data_sum_insured_monthly = implode(",", $sum_insured);
// var_dump($arr_monthly_sum_insured);
$arr_premium = [];
$arr_sum_insured = [];
// $arr_ncd = [];
// $arr_roadtax = [];

foreach ($ins_data_all as $key => $value) {    
    $ins_company[] = $key;
    foreach ($value as $val) {
        //premium
        if (isset($arr_premium[$key])){
            $arr_premium[$key] += $val['premium'];
        }else{
            $arr_premium[$key] = $val['premium'];            
        }
        //sum insured
        if(isset($arr_sum_insured[$key])){
            $arr_sum_insured[$key] += $val['sum_insured'];                        
        }else{
            $arr_sum_insured[$key] = $val['sum_insured'];            
        }       
    }  
}

$ins_company_str = !empty($ins_company) ? implode("','",$ins_company) : "";

$data_premium = array_values($arr_premium);
$data_premium = implode(",", $data_premium);

$data_sum_insured = array_values($arr_sum_insured);
$data_sum_insured = implode(",", $data_sum_insured);

$data_roadtax = array_values($arr_roadtax);
$data_roadtax = implode(",", $data_roadtax);

$month = array(
    1=> "Jan", 
    2=> "Feb", 
    3=> "Mar", 
    4=> "Apr", 
    5=> "May", 
    6=> "Jun", 
    7=> "Jul", 
    8=> "Aug", 
    9=> "Sep", 
    10=> "Oct",
    11=> "Nov",
    12=> "Dec"
);

$month_str = implode("','", $month);

?>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<?php require_once('../allCSS1.php')?>
<link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">
</head>
<body>
    <!--Left Panel -->
	<?php include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <div id="right-panel" class="right-panel">
    <div class="content">        
        <div class="animated fadeIn">
        	<form action="" method="post">
            	<div class="form-group row col-sm-12">
            		<div class="col-sm-3">
            			<label for="company_dd" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                		<?php
                            $select_company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company WHERE status='1'");
                            db_select ($select_company, 'select_company', $select_c,'submit()','All','form-control','');                        
                        ?>
                  	</div>
                  	<div class="col-sm-3">
                  		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                  		<?=$html_year_select?>
                  	</div>
            	</div>
        	</form>
        	<br>
            <div class="row">
                <div class="col-sm-6 premium">            	
                    <div class="card">                	
                        <div class="card-body">                        
                            <canvas id="chart1"></canvas>                        
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 sum_insured">
                    <div class="card">
                        <div class="card-body">                        
                            <canvas id="sales-chart"></canvas>
                        </div>
                    </div>
                </div>
    		</div>
    		<div class="row">
    			<div class="col-sm-6 roadtax">           	
                    <div class="card">                	
                        <div class="card-body">                        
                            <canvas id="chart-roadtax"></canvas>                        
                        </div>
                    </div>                    
                </div>                
    		</div>
    		<div class="row">
    		<div class="col-sm-12 company-monthly">            	
        			<div class="card">                	 
                        <div class="card-body">                         
        					<canvas id="chart-company-monthly"></canvas>                         
                    	</div> 
                    </div>                      
                </div>
    		</div>			
    	</div>
    </div>
    </div>

<!-- link to the script-->
<?php require_once ('../allScript2.php')?>
    <!-- Datatables -->
	<script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/jszip.min.js"></script>
    <script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../assets/js/init/datatables-init.js"></script>
    <script src="../assets/js/script/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            var select_company = '<?=$select_c?>';
            $('.company-monthly').hide();
            $('.premium, .sum_insured, .roadtax').show();
            if(select_company != ''){
            	$('.company-monthly').show();
            	$('.premium, .sum_insured, .roadtax').hide();
            }
        	//company expenses yearly
        	var ctx = document.getElementById( "chart1" );        	
            ctx.height = 'auto';
            var chart1 = new Chart( ctx, {
                type: 'line',
                data: {
                    labels: [ '<?php echo $ins_company_str;?>' ], //Company
                    type: 'line',
                    defaultFontFamily: 'Montserrat',
                    datasets: [ 
                        {
                            label: "Premium (RM)",
                            data: [ <?php echo $data_premium;?> ], //premium
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(220,53,69,0.75)',
                            borderWidth: 3,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBorderColor: 'transparent',
                            pointBackgroundColor: 'rgba(220,53,69,0.75)',
						},						
					]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Montserrat',
                        bodyFontFamily: 'Montserrat',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Montserrat',
                        },
                    },
                    scales: {
                        xAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                        } ],
                        yAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            }
                        } ]
                    },
                    title: {
                        display: true,
                        text: 'Premium (RM)'
                    },
                    
                }
            } );
//             ctx.onclick = function(evt) {
//                 var activePoints = chart1.getElementsAtEvent(evt);
                
//                 var firstPoint = activePoints[0];
//                 var secondPoint = activePoints[1];
//                 var thirdPoint = activePoints[2];
//                 var label = chart1.data.labels[firstPoint._index];
//                 console.log(label);
//                 var label2 = chart1.data.labels[secondPoint._index];
//                 var label3 = chart1.data.labels[thirdPoint._index];
//                 var value = chart1.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
//                 var value2 = chart1.data.datasets[secondPoint._datasetIndex].data[secondPoint._index];
//                 var value3 = chart1.data.datasets[thirdPoint._datasetIndex].data[thirdPoint._index];
// //                 if (firstPoint !== undefined)
// //                     alert(label + ": " + value);
// //                 if (secondPoint !== undefined)
// //                     alert(label2 + ": " + value2);
// //                 if (thirdPoint !== undefined)
// //                     alert(label3 + ": " + value3);

//             };
//             $( ".dropdown" ).change(function() {
//             	chart1.options.data[0].dataPoints = [];
//               var e = document.getElementById("dd");
//             	var selected = e.options[e.selectedIndex].value;
//               dps = jsonData[selected];
//               for(var i in dps) {
//               	var xVal = dps[i].x;
//               	chart1.options.data[0].dataPoints.push({x: new Date(xVal), y: dps[i].y});
//               }
//               chart1.render();
//             });


          //Sales chart
            var ctx = document.getElementById( "sales-chart" );
            ctx.height = 150;
            var myChart = new Chart( ctx, {
                type: 'line',
                data: {
                    labels: [ '<?php echo $ins_company_str;?>' ],
                    type: 'line',
                    defaultFontFamily: 'Montserrat',
                    datasets: [ {
                            label: "Sum Insured (RM)",
                            data: [ <?php echo $data_sum_insured?> ],
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(220,53,69,0.75)',
                            borderWidth: 3,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBorderColor: 'transparent',
                            pointBackgroundColor: 'rgba(220,53,69,0.75)',
                        }, 
                    ]
                },
                options: {
                    responsive: true,

                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Montserrat',
                        bodyFontFamily: 'Montserrat',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Montserrat',
                        },
                    },
                    scales: {
                        xAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                                } ],
                        yAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            }
                                } ]
                    },
                    title: {
                        display: true,
                        text: 'Sum Insured (RM)'
                    }
                }
            } );

          //roadtax
            var ctx = document.getElementById( "chart-roadtax" );
            ctx.height = 150;
            var myChart = new Chart( ctx, {
                type: 'line',
                data: {
                    labels: [ '<?php echo $rt_company_str;?>' ],
                    type: 'line',
                    defaultFontFamily: 'Montserrat',
                    datasets: [ {
                            label: "Road Tax (RM)",
                            data: [ <?php echo $data_roadtax?> ],
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(220,53,69,0.75)',
                            borderWidth: 3,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBorderColor: 'transparent',
                            pointBackgroundColor: 'rgba(220,53,69,0.75)',
                        }, 
                    ]
                },
                options: {
                    responsive: true,

                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Montserrat',
                        bodyFontFamily: 'Montserrat',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Montserrat',
                        },
                    },
                    scales: {
                        xAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                                } ],
                        yAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            }
                                } ]
                    },
                    title: {
                        display: true,
                        text: 'Road Tax (RM)'
                    }
                }
            } );

            //company by month premium, sum insured
            var ctx = document.getElementById( "chart-company-monthly" );
            ctx.height = 150;
            var myChart = new Chart( ctx, {
                type: 'line',
                data: {
                    labels: [ '<?php echo $month_str;?>' ], //month
                    type: 'line',
                    defaultFontFamily: 'Montserrat',
                    datasets: [ {
                            label: 'Premium (RM)',
                            data: [<?php echo $data_premium_monthly?>],
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(220,53,69,0.75)',
                            borderWidth: 3,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBorderColor: 'transparent',
                            pointBackgroundColor: 'rgba(220,53,69,0.75)',
                        },
                        {
                            label: 'Road Tax (RM)',
                            data: [<?php echo $data_roadtax_monthly?>],
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(40,167,69,0.75)',
                            borderWidth: 3,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBorderColor: 'transparent',
                            pointBackgroundColor: 'rgba(40,167,69,0.75)',
                        }
                         
                    ]
                },
                options: {
                    responsive: true,

                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Montserrat',
                        bodyFontFamily: 'Montserrat',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Montserrat',
                        },
                    },
                    scales: {
                        xAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                                } ],
                        yAxes: [ {
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            }
                                } ]
                    },
                    title: {
                        display: true,
                        text: '<?php echo $comp_name?>'
                    }
                }
            } );
            

            
        });            
</script>
</body>
</html>