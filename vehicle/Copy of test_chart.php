<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

// $select_company = isset($_POST['company']) ? $_POST['company'] : "";

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
ob_start();
selectYear('year_select',$year_select,'','','form-control col-sm-3','','');
$html_year_select = ob_get_clean();

$query = "SELECT vehicle_vehicle.vv_id, company_id, (SELECT code FROM company WHERE id=vehicle_vehicle.company_id) AS code, vv_vehicleNo, vi_insurance_fromDate,
        vi_insurance_dueDate, vi_premium_amount, vi_ncd, vi_sum_insured, vi_excess , vrt_roadTax_fromDate, vrt_roadTax_dueDate,vrt_amount
        FROM vehicle_vehicle
        INNER JOIN vehicle_insurance ON vehicle_vehicle.vv_id = vehicle_insurance.vv_id
        LEFT JOIN vehicle_roadtax ON vehicle_insurance.vv_id = vehicle_roadtax.vv_id";

$sql_result = mysqli_query($conn_admin_db, $query)or die(mysqli_error($conn_admin_db));
$data = array();
while($row = mysqli_fetch_array($sql_result)){
    $data[$row['code']][] = array(
        'premium' => $row['vi_premium_amount'],
        'sum_insured' => $row['vi_sum_insured'],
        //'ncd' => $row['vi_ncd']
        'roadtax' => !empty($row['vrt_amount']) ? $row['vrt_amount'] : 0
    );
}

$company = [];
$arr_premium = [];
$arr_sum_insured = [];
$arr_roadtax = [];

foreach ($data as $key => $value) {
    $company[] = $key;
    foreach ($value as $val) {
        //premium
        if(!isset($arr_premium[$key])) {
            $arr_premium[$key] = array(); //Declare it
        }
        $arr_premium[$key][] = $val['premium'];
        
        //sum insured
        if(!isset($arr_sum_insured[$key])) {
            $arr_sum_insured[$key] = array(); //Declare it
        }
        $arr_sum_insured[$key][] = $val['sum_insured'];
        
        //roadtax
        if(!isset($arr_roadtax[$key])) {
            $arr_roadtax[$key] = array(); //Declare it
        }
        $arr_roadtax[$key][]  = $val['roadtax'];
        
    }
}
// $company = array(
//     "EPCS",
//     "KFSB",
//     "EPPF",
//     "SMESB",
//     "JDSB",
//     "JNSB",
//     "PDUSB"
// );
$company = implode("','",$company);

$premiumData = [];
$premiumArray = [];
foreach ($arr_premium as $key=>$val){
    foreach ($val as $row){
        $premiumData[$key][] = (float)$row;
    }
    $premiumArray[] = array_sum($premiumData[$key]);
}
$data_premium = array_values($premiumArray);
$data_premium = implode(",", $data_premium);

$sumInsuredData = [];
$sumInsuredArray = [];
foreach ($arr_sum_insured as $key=>$val){
    foreach ($val as $row){
        $sumInsuredData[$key][] = (float)$row;
    }
    $sumInsuredArray[] = array_sum($sumInsuredData[$key]);
}
$data_sum_insured = array_values($sumInsuredArray);
$data_sum_insured = implode(",", $data_sum_insured);

$roadTaxData = [];
$roadTaxArray = [];
foreach ($arr_roadtax as $key=>$val){
    foreach ($val as $row){
        $roadTaxData[$key][] = (float)$row;
    }
    $roadTaxArray[] = array_sum($roadTaxData[$key]);
}
$data_roadtax = array_values($roadTaxArray);
$data_roadtax = implode(",", $data_roadtax);

$month = array(
    "JAN",
    "FEB",
    "MAR",
    "APR",
    "MAY",
    "JUN",
    "JUL",
    "AUG",
    "SEP",
    "OCT",
    "NOV",
    "DEC"
);

$month = implode("','", $month);

$data_premium_m = array(60, 30, 15, 110, 50, 63, 120, 12, 30, 10, 90, 78);
$data_premium_m = implode(",", $data_premium_m);

$data_sum_insured_m = array(12, 50, 40, 80, 35, 99, 80, 30, 36, 58, 12, 100);
$data_sum_insured_m = implode(",", $data_sum_insured_m);

$data_ncd_m = array(25, 60, 30, 95, 40, 55, 90, 80, 76, 40, 11, 32);
$data_ncd_m = implode(",", $data_ncd_m);
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
	<?php  //include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php //include('../assets/nav/rightNav.php')?>
    <div id="right-panel" class="right-panel">
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-6"><!-- Expenses by company monthly -->            	
                    <div class="card">                	
                        <div class="card-body">                        
                            <canvas id="chart1"></canvas>                        
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">                        
                            <canvas id="sales-chart"></canvas>
                        </div>
                    </div>
                </div><!-- /# column -->
    		</div>
    		<div class="row">
    			<div class="col-lg-6"><!-- Expenses by company monthly -->            	
                    <div class="card">                	
                        <div class="card-body">                        
                            <canvas id="chart-roadtax"></canvas>                        
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
        	//company expenses yearly
        	var ctx = document.getElementById( "chart1" );        	
            ctx.height = 'auto';
            var chart1 = new Chart( ctx, {
                type: 'line',
                data: {
                    labels: [ '<?php echo $company;?>' ], //Company
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
                    labels: [ '<?php echo $company;?>' ],
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

          //Sales chart
            var ctx = document.getElementById( "chart-roadtax" );
            ctx.height = 150;
            var myChart = new Chart( ctx, {
                type: 'line',
                data: {
                    labels: [ '<?php echo $company;?>' ],
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

            
        });            
</script>
</body>
</html>