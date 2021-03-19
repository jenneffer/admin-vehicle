<?php
require_once('../assets/config/database.php');
require_once('../check_login.php');
require_once('../function.php');
global $conn_admin_db;
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
// $select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";

$sql_query = "SELECT * FROM vehicle_vehicle vv
INNER JOIN vehicle_roadtax vr ON vv.vv_id = vr.vv_id AND vr.status='1'
INNER JOIN company ON company.id = vv.company_id 
LEFT JOIN vehicle_puspakom vp ON vp.vv_id = vv.vv_id AND vp.status='1' 
LEFT JOIN vehicle_insurance vi ON vi.vv_id = vv.vv_id AND vi.vi_status='1'
WHERE vrt_roadTax_fromDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'";
// echo $sql_query;

$result  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));

$arr_data = array();
while($row = mysqli_fetch_assoc($result)){

    $arr_data[$row['company_id']][] = $row;
}

// var_dump($arr_data);

?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Vehicle</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- link to css -->
	<?php include('../allCSS1.php')?>
   <style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
        .button_search{
            position: absolute;
            left:    0;
            bottom:   0;
        }

    </style>
</head>

<body>
    <!--Left Panel -->
	<?php include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <!-- /#header -->
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">
                                <strong class="card-title">Road Tax Summary (By Company)</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">                    	            	
                                        <div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">
                                            </div>                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_end" name="date_end" class="form-control form-control-sm" value="<?=$date_end?>" autocomplete="off">
                                            </div>                             
                                        </div>
                                        <div class="col-sm-3">                                    	
                                        	<button type="submit" class="btn btn-sm btn-primary button_search ">View</button>
                                        </div>
                                     </div>    
                                </form>
                            </div>
                            <hr>
                            <div class="card-body" >
                                <table id="roadtax_summary">
                                    <?php 
                                        $tbody = "";
                                        $grandtotal = 0;
                                        foreach ($arr_data as $company_id => $data){
                                            $comp_name = itemName("SELECT name FROM company WHERE id='$company_id'");  
                                            
                                            $tbody .="<table class='table table-bordered'>";
                                            $tbody .= "<tr><th colspan='11' style='text-align:center; background-color:#93bcc9;'>".$comp_name."</th></tr>";
                                            $tbody .= "<tr>
                                                        	<th rowspan='2'>No.</th>
                											<th rowspan='2'>Vehicle No.</th>
                                                            <th>Use Under</th>
                											<th>LPKP Permit</th>
                											<th>Fitness Test</th>
                											<th colspan='2' style='text-align: center'>Insurance</th>
                											<th colspan='4' style='text-align: center'>Road Tax</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Company</th>
                											<th>Due Date</th>
                											<th>Due Date</th>
                											<th>Due</th>
                											<th>Status</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Period</th>
                                                            <th class='sum'>Amount(RM)</th>
                                                        </tr>";
                                            $count = 0;
                                            $total_sum = 0;
                                            foreach ($data as $value){
                                                $count++;
                                                $total_sum += $value['vrt_amount'];
                                                $grandtotal += $value['vrt_amount'];
                                                $insurance_status = $value['vi_insuranceStatus'] == 1 ? "Active" : "Inactive";
                                                $fitness_date = !empty($value['vp_fitnessDate']) ? dateFormatRev($value['vp_fitnessDate']) : '-';
                                                $lpkp_dueDate = $row['vrt_lpkpPermit_dueDate'] != NULL ? dateFormatRev($row['vrt_lpkpPermit_dueDate']) : "-";
                                                $ins_due_date = $value['vi_insurance_dueDate'] != NULL ? dateFormatRev($value['vi_insurance_dueDate']) : "-";
                                                $rt_fromDate = $value['vrt_roadTax_fromDate'] != NULL ? dateFormatRev($value['vrt_roadTax_fromDate']) : "-";
                                                $rt_dueDate = $value['vrt_roadTax_dueDate'] != NULL ? dateFormatRev($value['vrt_roadTax_dueDate']) : "-";
                                                $tbody .="<tr>";
                                                $tbody .="<td>".$count.".</td>";
                                                $tbody .="<td>".$value['vv_vehicleNo']."</td>";
                                                $tbody .="<td>".$value['code']."</td>";
                                                $tbody .="<td>".$lpkp_dueDate."</td>";
                                                $tbody .="<td>".$fitness_date."</td>";
                                                $tbody .="<td>".$ins_due_date."</td>";
                                                $tbody .="<td>".$insurance_status."</td>";
                                                $tbody .="<td>".$rt_fromDate."</td>";
                                                $tbody .="<td>".$rt_dueDate."</td>";
                                                $tbody .="<td>".$value['vrt_roadTax_period']."</td>";
                                                $tbody .="<td class='text-right'>".number_format($value['vrt_amount'],2)."</td>";
                                                $tbody .="</tr>";
                                                
                                            }
                                            $tbody .="<tr>";
                                            $tbody .="<td colspan='10' class='text-right font-weight-bold'>TOTAL (RM)</td>";
                                            $tbody .="<td class='text-right font-weight-bold'>".number_format($total_sum,2)."</td>";
                                            $tbody .="</tr>";
                                            $tbody .="</table>";
                                            $tbody .="<div class='text-right'><input type='button' class='btn btn-sm btn-info' onclick=window.open('roadtax.summary.print.php?company=$company_id&date_start=$date_start&date_end=$date_end','_blank') value='Print'/></div><br><br>";

                                        }
                                    ?>
                                    
                                    <tbody> 
                                     <?=$tbody;?>
                                     
                                    <table class='table table-bordered'>
                                    	<?php if($grandtotal !=0){?>
                                        <tr style='background-color:#93bcc9;'>
                                            <th colspan="10" class="text-right font-weight-bold">GRANDTOTAL</th>
                                            <th class="text-right font-weight-bold"><?=number_format($grandtotal,2)?></th>
                                        </tr>
                                        <?php } else{?>
                                        <tr><td class="text-center">No records found.</td></tr>
                                    	<?php }?>
                                    </table>   
                                    
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </div>
        <div class="clearfix"></div>
        <!-- Footer -->
        <?PHP include('../footer.php')?>
        <!-- /.site-footer -->
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

    	function myFunction(company_id, date_start, date_end){
        	alert(date_start);
        	
			window.open('roadtax.summary.print.php?company='+company_id+'&date_start='+date_start+'&date_end='+date_end,'_blank');    
    	}
        $(document).ready(function() {
//             var table = $('#roadtax_summary').DataTable({
//                 "processing": true,
//                 "serverSide": true,
//                 "searching": false,
//                 "ajax":{
//                  "url": "roadtax.all.ajax.php",  
//                  "type": "POST",         	
//                  "data" : function ( data ){
//                	 	data.date_start = '<?=$date_start?>';
//						data.date_end = '<?=$date_end?>';
// 						data.action = 'roadtax_summary';
//						data.select_company = '<?=$select_c?>';
// 					}
//                 },
//                 "footerCallback": function( tfoot, data, start, end, display ) {
//     				var api = this.api(), data;
//     				// Remove the formatting to get integer data for summation
//     	            var intVal = function ( i ) {
//     	                return typeof i === 'string' ?
//     	                    i.replace(/[\$,]/g, '')*1 :
//     	                    typeof i === 'number' ?
//     	                        i : 0;
//     	            };
//     				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;

// 					api.columns([10], { page: 'current'}).every(function() {
// 							var sum = this
// 						    .data()
// 						    .reduce( function (a, b) {
//                                 return intVal(a) + intVal(b);
//                             }, 0 );			
						       
// 						    $(this.footer()).html(numFormat(sum));
// 					}); 
    				
//     			},
//                 "columnDefs": [
//                 	  {
//                 	      "targets": 10, // your case first column
//                 	      "className": "text-right",                	     
//                 	 }],
//             	 "dom": 'Bfrtip',
//                  "buttons": [ 
//                 	 { 
//         				extend: 'excelHtml5', 
//         				messageTop: 'Road Tax Summary',
//         				footer: true 
//         			 },
//                      {
//         				extend: 'print',
//         				messageTop: 'Road Tax Summary',
//         				footer: true,
//         				customize: function ( win ) {
//                             $(win.document.body)
//                                 .css( 'font-size', '10pt' );

//                             $(win.document.body).find( 'table' )
//                                 .addClass( 'compact' )
//                                 .css( 'font-size', 'inherit' );
//                         }
//                      }
//                   ],         	 
//             });
            
            $('#myform').on("submit", function(event){  
        	   	table.clear();
      			table.ajax.reload();
      			table.draw();      
           	});
           	
            $('#date_start, #date_end').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                orientation: "top left",
                todayHighlight: true
            });
        });
  </script>
</body>
</html>
