<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');

global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
// $tariff = isset($_POST['tariff']) ? $_POST['tariff'] : "CM1";
$select_company = isset($_POST['company']) ? $_POST['company'] : "1";
$select_location = isset($_POST['location']) ? $_POST['location'] : "All";
// $report_type = isset($_POST['report_type']) ? $_POST['report_type'] : "month";
ob_start();
selectYear('year_select[{index}]',$year_select,'','','form-control form-control-sm year','');
$html_year_select = ob_get_clean();


//html company select
ob_start();
$company = mysqli_query ( $conn_admin_db, "SELECT company, (SELECT UPPER(NAME) FROM company WHERE id=bill_fuji_xerox_account.company) AS company_name FROM bill_fuji_xerox_account WHERE status='1' GROUP BY company ORDER BY company_name ASC");
db_select ($company, 'company[{index}]',$select_company,'','','form-control form-control-sm company','');
$html_company_select = ob_get_clean();

// html location select
ob_start();
$location = mysqli_query ( $conn_admin_db, "SELECT id, location FROM bill_fuji_xerox_account WHERE company='$select_company' AND id IN (SELECT acc_id FROM bill_fuji_xerox_invoice)");
db_select ($location, 'location[{index}]',$select_location,'','All','form-control form-control-sm location','');
$html_location_select = ob_get_clean();

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

$compare_form_input = "<div class='form-group row col-sm-12'>  
                      	<div class='col-sm-2'>                      		
                      		".$html_year_select."
                      	</div>
                      	<div class='col-sm-4 monthly-div'>                		
                			".$html_company_select."
                		</div>
                		<div class='col-sm-4 monthly-div'>                		
                			".$html_location_select."
                		</div>
                	</div>";

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
                <form name="form_comparison" id="form_comparison" action="" method="post">
                <div class="card-body">
                <div class='row col-sm-12'>
                    <div class='col-sm-2'><label for='year_select' class='form-control-label'><small class='form-text text-muted'>Year</small></label></div>                
                    <div class='col-sm-4'><label for='company' class='form-control-label'><small class='form-text text-muted'>Company</small></label></div>                   
                    <div class='col-sm-2'><label for='location' class='form-control-label'><small class='form-text text-muted'>Account No./Location</small></label></div>                   
                </div>
				<div id="div-comparison">
				</div>
				<div class="form-group row col-sm-12">  
            		<div class="col-sm-6">
            			<input type="button" class=" btn btn-sm btn-info" name="button_add_row" value="Click to append field to compare">&nbsp;&nbsp;
            			<input type="button" class=" btn btn-sm btn-primary btn_compare" value="Compare">
            			<input type="button" class=" btn btn-sm btn-secondary btn_clear" value="Clear Comparison">
            		</div>
            	</div>
                <br>
                <div class="row">          
                    <div class="col-sm-12 ja-monthly">            	
						<canvas id="ja-monthly"></canvas>                        
                    </div>     
                </div> 
				</div>
				</form>     
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
<!-- <script src="http://code.jquery.com/jquery-1.8.3.js"></script> -->
<!-- <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script> -->
<script type="text/javascript">
	OBJ_CURRENT_LOCATION_LIST = [];
    $(document).ready(function() {        
        var company = '<?=$select_company?>';    
        console.log(company);  
        var newDataObject = [];  
        divCounter = 1;
       	//get the default first row 
        addRow();
        get_location(company); 
        
        $("input[name=button_add_row]").click( function(event) {
        	addRow();
        });
        
        $("form[name=form_comparison]").on( 'change', "select.company", function(event) {				
        	var company = $(this).val();         	      		
        	var name = $(this).attr('name');
        	//call ajax to get location list
        	get_location(company);        	      		
        	var number_matches = name.match(/[0-9]+/g);
        	var index = number_matches[0];
        	var location = $("select[name=location\\["+index+"\\]]").val();
        	
        	updateLocationSelectList( index, company);
        	
        });
        
        
        $('.btn_compare').on("click", function(event){ 
        	var iData = $('#form_comparison').serialize();
        	$.ajax({  
                url:"fx_bill.ajax.php",  
                type:"POST",                        
                data:{action:'compare_data', data: iData},  
                async:false,
                
            }).done(function( indata ){ 
                var data = JSON.parse(indata);    
                if( data.length > 0 ){
                	newDataObject = indata;
                	myChart.data.datasets = JSON.parse(newDataObject);                    	
                	myChart.update();
                }
                else{
                    alert("No data to compare!");
                }                     	                                        	
            });
        });
        //to reset the input value
        $('.btn_clear').on("click", function(event){
        	location.reload();
        });

        //to add new row to compare
        function addRow(){
            var compare_form = <?= json_encode(utf8_encode($compare_form_input))?>;  
            var divContentHtml = compare_form.replace( /{index}/g, divCounter );       
            var id = "div-" + divCounter;
            $('#div-comparison').show();
            $('#div-comparison').append( "<div id='" + id + "'>" + divContentHtml + "</div>" );
            divCounter++;            
        }
        //to update the location list when company change
        function updateLocationSelectList( index, company){
        	var elem = $("select[name=location\\["+index+"\\]]");
        	var toRemove = [];
        	cur_location_list = OBJ_CURRENT_LOCATION_LIST[company];
//         	cur_location_list = OBJ_CURRENT_LOCATION_LIST[company].filter( function( el ) {        			
//         		return toRemove.indexOf( el ) < 0;
//         	});  
			// Get the size of an object
            Object.size = function(obj) {
                var size = 0, key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key)) size++;
                }
                return size;
            };
            
        	if( Object.size(cur_location_list) > 0 ){
        		elem.empty(); // remove old options
        		elem.append($("<option></option>").attr("value", "").text( "All" ) ); 
        		$.each( cur_location_list, function(key, value) {
        			elem.append($("<option></option>").attr("value", key).text( value ) );
        		});
        	}
        }
        //to get the location based on the selected company
        function get_location(company_id){
            $.ajax({
                url: 'fx_bill.ajax.php',
                type: 'POST',
                data: {action:'get_location', company: company_id},
                async:false,
            }).done(function( indata ){                                        	
            	var obj = $.parseJSON( indata );
            	if( obj.result ) {
            		OBJ_CURRENT_LOCATION_LIST = obj.result;
            	}
            });
        }
        
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
    });         
</script>
</body>
</html>