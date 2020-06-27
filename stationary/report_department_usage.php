<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');

//     $query = "SELECT si.id, si.item_name, department_id, SUM(quantity) AS quantity, date_taken 
//             FROM stationary_item si
//             INNER JOIN stationary_stock_take sst ON sst.item_id = si.id
//             WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' GROUP BY si.id,department_id ORDER BY quantity DESC
            
//             UNION 
//             SELECT sd.id, si.item_name, '' AS department_id, '' AS quantity, '' AS date_taken
//             FROM stationary_item si WHERE si.id NOT IN (SELECT item_id FROM stationary_stock_take WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."')";
    
    $query = "SELECT * FROM (SELECT si.id, si.item_name, department_id, SUM(quantity) AS quantity, date_taken FROM stationary_item si INNER JOIN stationary_stock_take sst ON sst.item_id = si.id WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' GROUP BY si.id,department_id 
            UNION ALL 
            SELECT stationary_item.id, stationary_item.item_name, '' AS department_id, 0 AS quantity, '' AS date_taken FROM stationary_item  WHERE stationary_item.id NOT IN (SELECT item_id FROM stationary_stock_take WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'))t
            ORDER BY t.quantity DESC";
    
    $result = mysqli_query ( $conn_admin_db,$query);
    $arr_data = [];
    while($row = mysqli_fetch_assoc($result)){
        $arr_data[$row['id']] = $row;
    }
    
    //department
    $dept_rst = mysqli_query($conn_admin_db, "SELECT * FROM stationary_department WHERE status='1' ORDER BY department_id");
    $arr_dept = [];
    while($rows = mysqli_fetch_assoc($dept_rst)){
        $arr_dept[] = $rows;
    }
    

?>
<!doctype html>
<html class="no-js" lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Eng Peng Vehicle</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- link to css -->
<?php include('../allCSS1.php')?>
<link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">
<style>
    .button_search{
        position: absolute;
        left:    0;
        bottom:   0;
    }
    a#title{
        color:blue;
    }
    a:hover {
        cursor: pointer;
    }
/*      .accordion-toggle:after { */
/*         /* symbol for "opening" panels */ */
/*         font-family:'FontAwesome'; */
/*         content:"\f077"; */
/*         float: right; */
/*         color: inherit; */
/*     } */
/*     .panel-heading.collapsed .accordion-toggle:after { */
/*         /* symbol for "collapsed" panels */ */
/*         content:"\f078"; */
/*     } */

/*         @media print { */
/*           body * { */
/*             visibility: hidden; */
/*           } */
/*           #printableArea, #printableArea * { */
/*             visibility: visible; */
/*           } */
/*           #printableArea { */
/*             position: absolute; */
/*             left:0; */
/*             top: 0; */
/*           } */
/*           #left-panel { */
/*             visibility: hidden; */
/*           } */
/*         } */

</style>
</head>

<body>
<!--Left Panel -->
<?php  include('../assets/nav/leftNav.php')?>
<!-- Right Panel -->
<?php include('../assets/nav/rightNav.php')?>
<!-- /#header -->
<!-- /#header -->
<!-- Content -->
<div id="right-panel" class="right-panel">
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="printableArea">
                    <div class="card-header">
                        <strong class="card-title">Stock Take (By Department)</strong>
                    </div>                                                
                    <div class="card-body">
                        <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
            	            <div class="form-group row col-sm-12">
                                <div class="col-sm-3">
                                    <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                    <div class="input-group">
                                      <input type="text" id="date_start" name="date_start" class="form-control" value="<?=$date_start?>" autocomplete="off">
<!--                                               <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
                                    </div>                            
                                </div>
                                <div class="col-sm-3">
                                    <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                    <div class="input-group">
                                      <input type="text" id="date_end" name="date_end" class="form-control" value="<?=$date_end?>" autocomplete="off">
<!--                                               <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
                                    </div>                             
                                </div>
                                <div class="col-sm-1">                                    	
                                	<button type="submit" class="btn btn-primary button_search ">View</button>                                        	
                                </div>
<!--                                         <div class="col-sm-1">                                    	 -->
<!--                                        	<button type="button" class="btn btn-primary button_search" onclick="printDiv('printableArea')">Print</button>
<!--                                         </div> -->
<!--                                         <div class="col-sm-1">                                    	 -->
<!--                                        	<button type="button" class="btn btn-primary button_search" onclick="fnExcelReport();">Export to Excel</button>
<!--                                         </div> -->
                             </div>    
                        </form>
                    </div>
                    <hr>
                    <div class="card-body" id="printableArea">
                        <table id="department_summary" class="table table-striped table-bordered">
                            <?php 
                            $theader = "";
                            $tbody = "";  
                            foreach ($arr_data as $item_id => $item_data){
                                $item_name = itemName("SELECT item_name FROM stationary_item WHERE id='$item_id'");                                       
                                $tbody_ext = "";
                                $quantity = 0;
                                $total_quantity = 0;
                                $header_ext = "";
                                foreach ($arr_dept as $dept_data){
                                    $header_ext .="<th>".$dept_data['department_code']."</th>";    
                                    $quantity = itemName("SELECT SUM(quantity) FROM stationary_stock_take WHERE department_id='".$dept_data['department_id']."' AND item_id='$item_id' AND date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'");
                                    $total_quantity += $quantity;
                                    $tbody_ext .="<td>".$quantity."</td>";
                                }         
                                $tbody .="<tr><td><a id='$item_id' href='#' data-toggle='modal' data-target='#chartModal'>".$item_name."</a></td>".$tbody_ext."<td>".$total_quantity."</td></tr>";
                            }
                            
                            $theader .= "<thead><tr><th>ITEM</th>".$header_ext."<th class='rotate'>TOTAL</th></tr></thead>";     
                            ?>
                            <?=$theader?> 
                            <tbody>
                            <?=$tbody?>
                            </tbody>                                                                                                                     
                            <?php if(empty($arr_data)){?>
                            	<tfoot>
                            		<tr>
                            			<td colspan="13" style="text-align: center">No records found...</td>
                            		</tr>
                            	</tfoot>    
                            <?php }?>                                 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
</div>
<!-- Modal -->
<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">            
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>                
            </div>
            <div class="modal-body">
				<canvas id="chart-item-usage"></canvas> 
				<br>
				<div id="item-summary-div">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
							<div class="panel-heading collapsed text-center" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne">
                 				<a id="title" class="panel-title accordion-toggle">Item Summary &nbsp;<i class="fas fa-chevron-down"></i></a>   				
							</div>       
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                	<table id="item-summary" class="display compact" style="width: 100%;">
                    					<thead>
                    						<tr>
                        						<th>Staff name/Dept</th>
                        						<th>Date</th>
                        						<th>Qty</th>
                    						</tr>
                    					</thead>
                    					<tbody>
                    					</tbody>					
                    				</table>  
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>   
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>         
        </div>              
    </div>
</div>
<!-- export to excell -->
<iframe id="txtArea1" style="display:none"></iframe>
<div class="clearfix"></div>
<!-- Footer -->
<?PHP include('../footer.php')?>
    <!-- /.site-footer -->
<!-- from right panel page -->
<!-- /#right-panel -->

<!-- link to the script-->
<?php include ('../allScript2.php')?>
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
    $('#department_summary').DataTable({
      "searching": true,
      "paging": false,
      "dom": 'Bfrtip',
      "buttons": [ 
       { 
      	extend: 'excelHtml5', 
      	messageTop: 'Vehicle Summon ',
      	footer: true 
       },
       {
      	extend: 'print',
      	messageTop: 'Stock Summary ',
      	footer: true,
      	customize: function ( win ) {
              $(win.document.body)
                  .css( 'font-size', '10pt' );
      
              $(win.document.body).find( 'table' )
                  .addClass( 'compact' )
                  .css( 'font-size', 'inherit' );
          }
       }
      ],        	  
    });

    $('#chartModal').on('shown.bs.modal',function(event){    	    
    	var data = event.relatedTarget;
    	var id = data.id;
 		var date_start = '<?=$date_start?>';
 		var date_end = '<?=$date_end?>'; 		
    	$.ajax({
			url:"chart.ajax.php",
			method:"POST",
			data:{action:'get_chart_data', id:id, date_start:date_start, date_end:date_end},
			dataType:"json",
			cache: false,			
			success:function(response){  
				console.log(response);
				var chart_data = response.chart_data;
				var item_summary = response.item_summary;
				var label = [];   
				var datas = []; 
				var backgroundColor = [];
				var item_name = "";
				chart_data.forEach(function (item) {
				label.push(item.label);
                  datas.push(item.data);
                  backgroundColor.push(item.backgroundColor);
                  item_name = item.item_name +" From "+date_start+" - "+date_end;
                });  

				var i_name = '';
				if(item_name !=''){
					i_name = item_name;
				}
                
                //Check whether the chart variable is already initialized as Chart, if so, destroy it and create a new one, even you can create another one on the same name
				if(window.myChart instanceof Chart){
				    window.myChart.destroy();				    
				}
				var ctx = document.getElementById( "chart-item-usage" ).getContext('2d');
			    ctx.height = 150;
			    myChart= new Chart( ctx, {
			        type: 'doughnut',
			        data: {
			            datasets: [ {
			                data: datas,
			                backgroundColor: backgroundColor,

			                } ],
			            labels: label,
			        },
			        options: {
			            responsive: true,
			            title: {
			                display: true,
			                text: i_name,
			                fontSize : 16
			            },
			            legend: {
			                position: 'right'
			            }            
			        }
			    });   

			    //generate item summary table	
			        
			    if ($.fn.DataTable.isDataTable("#item-summary")) {//First check if dataTable exist or not, if it does then destroy dataTable and recreate it		 
		    	  $('#item-summary').DataTable().clear().destroy();
		    	}
			    $('#item-summary').DataTable( {
			        data: item_summary,
			        lengthChange:false		        
			    });  
			            
			}				 
		});
    	
    });
    
    $('#date_start, #date_end').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      orientation: "top left",
      todayHighlight: true
    });
});
function resetChart(){
	$('input').val('');
	$('#payment_method').val(0);
}
function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}
  
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function fnExcelReport(){
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('department_summary'); // id of table
    
    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
      tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
      //tab_text=tab_text+"</tr>";
    }
    
    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
    
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 
    
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
      txtArea1.document.open("txt/html","replace");
      txtArea1.document.write(tab_text);
      txtArea1.document.close();
      txtArea1.focus(); 
      sa=txtArea1.document.execCommand("SaveAs",true,"Department Summary.xls");
    }  
    else                 //other browser not tested on IE 11
      sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
    
    return (sa);
}
  </script> 
</body>
<style>
#printableArea{ 
     font-size:12px; 
     margin:0px; 
     padding:.5rem; 
} 

#item-summary-div{
    font-size:11px; 
}
</style>
</html>