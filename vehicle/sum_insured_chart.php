<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
require_once('chart_function.php');
global $conn_admin_db;
global $month_map;
global $month;
global $company_map;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "year";
$select_company = isset($_POST['company']) ? $_POST['company'] : "";

$company_name = itemName("SELECT code FROM company WHERE id='$select_company'");
ob_start();
selectYear('year_select',$year_select,'submit()','','form-control form-control-sm','','');
$html_year_select = ob_get_clean();

$arr_report_type = array(
    "year" => "Yearly",
    "month" => "Monthly",
    "company" => "By Company"
);
$select_category = isset($_POST['category']) ? $_POST['category'] : "";

$month_str = implode("','", $month);


$rt_company_str = !empty($rt_company) ? implode("','",$rt_company) : "";

//2. Sum insured
$sum_insured_data_yearly = get_sum_insured($year_select, $select_category);
$sum_insured_data_monthly = get_sum_insured_monthly($year_select, $select_category);

//sum insured monthly
$datasets_sum_insured_monthly = [];
foreach ($sum_insured_data_monthly as $label => $data){
    $month_data = array_replace($month_map, $data);
    $datasets_sum_insured_monthly[] = array(
        'label' => $label,
        'backgroundColor' => randomColor(),
        'borderWidth' => 0,
        'data' => array_values($month_data)
    );
}
$datasets_sum_insured_monthly = json_encode($datasets_sum_insured_monthly);

//yearly sum insured
$datasets_si_yearly = [];
//sort from low to high year
ksort($sum_insured_data_yearly);
foreach($sum_insured_data_yearly as $year => $comp_data){   
    $company_data = array_replace($company_map, $comp_data);      
    $datasets_si_yearly[] = array(            
        'label' => $year,
        'data' => array_values($company_data),
        'backgroundColor' => randomColor(),
        'borderWidth' => 0,
    );

}
//get the company name
$comp_name = [];
foreach($company_map as $comp_id => $val){
    $comp_name[] = itemName("SELECT code FROM company WHERE id='$comp_id'");

}
$comp_str = implode("','",$comp_name);
$comparison_datasets = json_encode($datasets_si_yearly);

//get monthly sum insured data by company
$data_byCompany = get_premium_sum_insured_byCompany($year_select, $select_category, $select_company);
$sum_insured_byCompany = $data_byCompany['monthly_sum_insured_byCompany'];

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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <!--Left Panel -->
	<?php include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>    
    <div id="right-panel" class="right-panel">
    <div class="content">            
        <div class="animated fadeIn">
        <div class="row">
        <div class="col-md-12">
            <div class="card" id="printableArea">
                <div class="card-header text-center">
                    <strong class="card-title">SUM INSURED</strong>
                </div>     
                <div class="card-body">
            	<form action="" method="post">
                	<div class="form-group row col-sm-12">
    					<div class="col-sm-3">
    						<label for="report_type" class="form-control-label"><small class="form-text text-muted">Report Type</small></label>
    						<select name="report_type" id="report_type" class="form-control form-control-sm" onchange="this.form.submit()">
    						<?php foreach ($arr_report_type as $key => $rt){						
    						    $selected = ($key == $report_type) ? 'selected' : '';						    
    						    echo "<option $selected value='$key'>".$rt."</option>";
                            }?>
                            </select>
    					</div>
    					<div class="col-sm-4 by_company">
                      		<label for="company" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                      		<?php
                                $company = mysqli_query ( $conn_admin_db, "SELECT id,UPPER(name) FROM company WHERE vehicle_used='1' ORDER BY name ASC ");
                                db_select ($company, 'company', $select_company,'submit()','All','form-control form-control-sm','','');
                            ?>
                      	</div>
                      	<div class="col-sm-2">
                      		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                      		<?=$html_year_select?>
                      	</div>
                      	<div class="col-sm-2">
                      		<label for="category" class="form-control-label"><small class="form-text text-muted">Category</small></label>
                      		<?php
                                $category = mysqli_query ( $conn_admin_db, "SELECT vc_id,UPPER(vc_type) FROM vehicle_category ORDER BY vc_type ASC ");
                                db_select ($category, 'category', $select_category,'submit()','All','form-control form-control-sm','','');
                            ?>
                      	</div>
                	</div>
            	</form>
            	<br>
                <div class="row">
                    <div class="col-sm-12 sum_insured">
                        <canvas id="sum-insured-yearly"></canvas>
                    </div>
        		</div>

        		<div class="row">
                    <div class="col-sm-12 company-monthly">            	
            			<canvas id="chart-sum-insured-monthly"></canvas>                        
                    </div>
        		</div>	

        		<div class="row">
                    <div class="col-sm-12 monthly-by-company">            	
            			<canvas id="chart-company-monthly-si"></canvas>                           
                    </div>
        		</div>	
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
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
function getDataset(index, data) { 
	return { 
    	label: 'Label '+ index, 
    	fillColor: 'rgba(220,220,220,0.2)', 
    	strokeColor: 'rgba(220,220,220,1)', 
    	pointColor: 'rgba(220,220,220,1)', 
    	pointStrokeColor: '#fff', 
    	pointHighlightFill: '#fff', 
    	pointHighlightStroke: 'rgba(220,220,220,1)', 
    	data: data 
    }; 
}
$(document).ready(function() {
    var report_type = '<?=$report_type?>';  
	var company_name = '<?=$company_name?>';
	var year = '<?=$year_select?>'
	
    $('.company-monthly').hide();
    $('.by_company').hide();
    $('.monthly-by-company').hide();
    $('.premium, .sum_insured, .roadtax').show();
    
    if(report_type == 'month'){    	
    	$('.company-monthly').show();
    	$('.premium, .sum_insured, .roadtax').hide();
    }    
    if(report_type == 'company'){
    	$('.by_company').show();
    	$('.monthly-by-company').show();
    	
    	$('.company-monthly').hide();
    	$('.premium, .sum_insured, .roadtax').hide();
    }

    $('.js-example-basic-multiple').select2();
    
    //company expenses yearly - sum-insured
    var ctx = document.getElementById( "sum-insured-yearly" );
    ctx.height = 150;
    var myChart = new Chart( ctx, {
        type: 'bar',
        data: {
            labels: [ '<?=$comp_str ?>'],
            datasets: <?=$comparison_datasets?>
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'label',
                titleFontSize: 12,
                titleFontColor: '#ffffff',
                bodyFontColor: '#ffffff',
                backgroundColor: '#000',
                cornerRadius: 3,
                intersect: false,
                callbacks: {
                    afterTitle: function() {
                        window.total = 0;
                    },
                    label: function(tooltipItem, data) {
                        var corporation = data.datasets[tooltipItem.datasetIndex].label;
                        var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        window.total += valor;
                        return corporation + ": RM" + valor.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");             
                    },
                    footer: function() {
                        return "TOTAL: RM" + window.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                    }
                }
            },
            legend: {
                display: 'bottom',
                display: true,
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
                        display: true,
                        labelString: 'Company'
                    }
                        } ],
                yAxes: [ {
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount (RM)'
                    }
                        } ]
            },
            title: {
                display: true,
                text: 'YEARLY COMPARISON OF SUM INSURED BY COMPANY'
            }
        }
    } );

   
  //company by month sum insured
    var ctx = document.getElementById( "chart-sum-insured-monthly" );
    ctx.height = 150;
    var myChart = new Chart( ctx, {           
        type: 'bar',        	            	
        data: {   
        	labels: [ '<?php echo $month_str;?>' ],
        	defaultFontFamily: 'Montserrat',         	
            datasets: <?=$datasets_sum_insured_monthly?>
                
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'label',
                titleFontSize: 12,
                titleFontColor: '#ffffff',
                bodyFontColor: '#ffffff',
                backgroundColor: '#000',
                cornerRadius: 3,
                intersect: false,
                callbacks: {
                    afterTitle: function() {
                        window.total = 0;
                    },
                    label: function(tooltipItem, data) {
                        var corporation = data.datasets[tooltipItem.datasetIndex].label;
                        var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        window.total += valor;
                        return corporation + ": RM" + valor.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");             
                    },
                    footer: function() {
                        return "TOTAL: RM" + window.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                    }
                }
            },
            legend: {
                position: 'bottom',
                display: true,
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [ {
                    stacked: true,
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
                    stacked: true,
                	ticks: {
                        beginAtZero: true,
                    },
                    display: true,
                    gridLines: {
                        display: true,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount (RM)'
                    }
                } ]
            },
            title: {
                display: true,
                text: 'MONTHLY SUM-INSURED FOR YEAR '+year
            }
        }
    } );

  //monthly sum insured by company
    var ctx = document.getElementById( "chart-company-monthly-si" );
    ctx.height = 150;
    var myChart = new Chart( ctx, {           
        type: 'bar',        	            	
        data: {   
        	labels: [ '<?php echo $month_str;?>' ],
        	defaultFontFamily: 'Montserrat',         	
            datasets: JSON.parse('<?=$sum_insured_byCompany?>')
                
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#ffffff',
                bodyFontColor: '#ffffff',
                backgroundColor: '#000',
                cornerRadius: 3,
                intersect: false,
                callbacks: {
                    afterTitle: function() {
                        window.total = 0;
                    },
                    label: function(tooltipItem, data) {
                        var corporation = data.datasets[tooltipItem.datasetIndex].label;
                        var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        window.total += valor;
                        return corporation + ": RM" + valor.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");             
                    },
                    footer: function() {
                        return "TOTAL: RM" + window.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                    }
                }
            },
            legend: {
                position:'bottom',
                display: true,
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [ {
                    stacked: true,
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
                    stacked: true,
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount (RM)'
                    }
                } ]
            },
            title: {
                display: true,
                text: company_name+' MONTHLY SUM-INSURED FOR YEAR '+year
            }
        }
    } );
  
    
});            
</script>
</body>
</html>