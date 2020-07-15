<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');

global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : "2019";
// $tariff = isset($_POST['tariff']) ? $_POST['tariff'] : "CM1";
$select_company = isset($_POST['company']) ? $_POST['company'] : "13";
// $select_location = isset($_POST['location']) ? $_POST['location'] : "All";
// $report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "month";
ob_start();
selectYear('year_select',$year_select,'','','form-control form-control-sm year','');
$html_year_select = ob_get_clean();


//html company select
ob_start();
$company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE id IN (SELECT company_id FROM bill_sesb_account WHERE status='1') AND status='1' ORDER BY name ASC");
db_select ($company, 'company',$select_company,'','','form-control form-control-sm company','');
$html_company_select = ob_get_clean();

//html location select
// ob_start();
// $location = mysqli_query ( $conn_admin_db, "SELECT location,UPPER(location) FROM bill_jabatan_air_account WHERE company_id='$select_company' AND status='1' GROUP BY location");
// db_select ($location, 'location',$select_location,'','All','form-control form-control-sm location','');
// $html_location_select = ob_get_clean();


//option year
ob_start();
optionYear($year_select);
$html_year_option = ob_get_clean();
//option company
ob_start();
$comp_op = mysqli_query($conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE id IN (SELECT company_id FROM bill_sesb_account WHERE status='1') AND status='1' ORDER BY name ASC");
db_option($comp_op);
$html_company_option = ob_get_clean();
//option location
ob_start();
$location_op = mysqli_query($conn_admin_db, "SELECT location,UPPER(location) FROM bill_sesb_account WHERE company_id='$select_company' AND status='1' GROUP BY location");
db_option($location_op,"All");
$html_location_option = ob_get_clean();

$comp_name = itemName("SELECT UPPER(name) FROM company WHERE id='".$select_company."'");
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
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
                    <strong class="card-title">COMPARISON OF ELECTRICITY USAGE</strong>
                </div>     
                <div class="card-body">
                <form method="POST" id="compare_form">
                	<div class="form-group row col-sm-12">  
                      	<div class="col-sm-2">
                      		<label for="year_select" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                      		<?=$html_year_select?>
                      	</div>
                      	<div class="col-sm-4 monthly-div">
                		<label for="company" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                			<?=$html_company_select?>
                		</div>
                		<div class="col-sm-4 monthly-div">
                		<label for="location" class="form-control-label"><small class="form-text text-muted">Account No./Location</small></label>
                			<select id="location" name="location" class="form-control form-control-sm">
                				<option>All</option>
                			</select>
                		</div>
                	</div>
               	<div class="dynamic-div-compare"><!-- Show when -->
                	</div>
                	<div class="form-group row col-sm-12">  
                		<div class="col-sm-6">
                			<input type="button" class=" btn btn-sm add-row btn-info" value="Click to append field to compare">&nbsp;&nbsp;
                			<input type="button" class=" btn btn-sm btn-primary btn_compare" value="Compare">
                			<input type="button" class=" btn btn-sm btn-secondary btn_clear" value="Clear Comparison">
                		</div>
                	</div>
                </form>
                <br>
                <div class="row">          
                    <div class="col-sm-12 ja-monthly">            	
						<canvas id="ja-monthly"></canvas>                        
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
<?php  require_once ('../allScript2.php')?>
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
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
	<script type="text/javascript">
        $(document).ready(function() {

//         	$(".year").chosen();
//         	$(".company").chosen();
//         	$(".location").chosen();
			var company = '<?=$select_company?>';
        	var newDataObject = [];
			var COUNT = [];
        	var year_option = <?=json_encode($html_year_option)?>;
        	var company_option = <?=json_encode($html_company_option)?>;
        	var location_option = <?=json_encode($html_location_option)?>;
        	var count = 0;
        	$(".add-row").click(function(){
            	count++;
            	COUNT.push(count);              	          	
        		var markup = "<div class='form-group row col-sm-12'><div class='col-sm-2'><select name='year_"+count+"' id='year_"+count+"' class='form-control form-control-sm'>"+year_option+"</select></div><div class='col-sm-4'><select name='company_"+count+"' id='company_"+count+"'  class='form-control form-control-sm'>"+company_option+"</select></div><div class='col-sm-4'><select name='location_"+count+"' id='location_"+count+"'  class='form-control form-control-sm'>"+location_option+"</select></div></div>";          	

                $("div .dynamic-div-compare").append(markup);
            });
        	//get default value of location option
            onChangeCompany(company);
           	//the first dropdowns          
            $("#company").change(function(){
                var company_id = $(this).val();   
                onChangeCompany(company_id);          
            }); 
            
            var select_company = '<?=$comp_name?>'; 
            var year = '<?=$year_select?>';

            //JA monthly       
        	var ctx = document.getElementById("ja-monthly").getContext("2d");
              ctx.height = 100;
              var myChart = new Chart( ctx, {           
                  type: 'line',        	            	
                  data: {   
                  	labels: [ '<?php echo $month_str;?>' ],
                  	defaultFontFamily: 'Montserrat',         	
                      datasets: []
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
                      layout: {
                          padding: {
                             bottom: 100  //set that fits the best
                          }
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
                                  labelString: 'Amount (RM)'
                              }
                                  } ]
                      },
                      title: {
                          display: true,
                          text: 'MONTHLY USAGE FOR YEAR '+year
                      }
                  }
              });
			
        	$('.btn_compare').on("click", function(event){ 
            	var data = $('#compare_form').serialize();
            	$.ajax({  
                    url:"sesb_bill.ajax.php",  
                    type:"POST",                        
                    data:{action:'compare_data', data: data, count:COUNT},  
                    success:function(data){                           
                    	newDataObject = data;
                    	myChart.data.datasets = JSON.parse(newDataObject);                    	
                    	myChart.update();
                    }  
                });
        	});

        	$('.btn_clear').on("click", function(event){
				location.reload();
			});
        });    

        function onChangeCompany(company_id){
            $.ajax({
                url: 'sesb_bill.ajax.php',
                type: 'POST',
                data: {action:'get_location', company: company_id},
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    var len = response.length;
                    $('#location').empty();  
                    $("#location").prepend("<option value=''>All</option>");                                   
                    for( var i = 0; i<len; i++){
                        var acc_id = response[i]['loc'];
                        var description = response[i]['loc_name'];                        
                        $("#location").append("<option value='"+acc_id+"'>"+description+"</option>");
        
                    }
                }
            });
        }   

            
</script>
</body>
</html>