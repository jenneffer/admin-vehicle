<?php
require_once('../assets/config/database.php');
require_once('../check_login.php');
require_once('../function.php');
global $conn_admin_db;
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
$select_runner = isset($_POST['select_runner']) ? $_POST['select_runner'] : "";

$sql_query = "SELECT * FROM vehicle_runner_claim vrc
        INNER JOIN vehicle_vehicle vv ON vv.vv_id = vrc.vehicle_id
        INNER JOIN vehicle_runner vr ON vr.r_id = vrc.runner_id
        INNER JOIN company ON company.id = vv.company_id
        WHERE vrc.invoice_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'";

if(!empty($select_runner)){
    $sql_query .=" AND vrc.runner_id = '$select_runner'";
}
// echo $sql_query;

$result  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));

$arr_data = array();
while($row = mysqli_fetch_assoc($result)){

    $arr_data[$row['company_id']][] = $row;
}

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
                                <strong class="card-title">Runner Claim Summary (By Company)</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">  
                    	            	<div class="col-sm-3">                
                    	            		<label for="date_start" class="form-control-label"><small class="form-text text-muted">Runner Name</small></label>
                                            <div class="input-group">
                                              	<?php
                                                    $runner = mysqli_query ( $conn_admin_db, "SELECT r_id, UPPER(r_name) FROM vehicle_runner WHERE r_status='1'");
                                                    db_select ($runner, 'select_runner', $select_runner,'submit()','All','form-control form-control-sm','','');
                                                ?>
                                            </div>                              	            	
                    	            	</div>
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
                                            $tbody .= "<tr><th colspan='13' style='text-align:center; background-color:#93bcc9;'>".$comp_name."</th></tr>";
                                            $tbody .= "<tr>
                                                            <th rowspan='2'>No.</th>
                                                            <th rowspan='2'>Runner</th>
                											<th rowspan='2'>Bill No.</th>
                											<th rowspan='2'>Vehicle No.</th>
                											<th rowspan='2'>Invoice No.</th>
                											<th rowspan='2'>Invoice Amount(RM)</th>
                											<th rowspan='2'>Inspection Charge(RM)</th>
                											<th rowspan='2'>Service Charge(RM)</th>
                											<th rowspan='2'>Other Misc</th>
                											<th rowspan='2'>Total (RM)</th>
                											<th colspan='2'>Puspakom Period</th>
                											<th rowspan='2'>Remark</th>                											
                                                        </tr>
                                                        <tr>                                         
                                                        	<th>From</th>
                                                        	<th>To</th>
                                                        </tr>";
                                            $count = 0;
                                            $total_sum = 0;
                                            foreach ($data as $row){
                                                $count++;
                                                $runner_name = $row['r_name'];
                                                $bill_no = $row['bill_no'];
                                                $vehicle_no = $row['vv_vehicleNo'];
                                                $invoice_no = $row['invoice_no'];
                                                $invoice_amt = $row['invoice_amount'];
                                                $inspection_charge = $row['inspection_charge'];
                                                $service_charge = $row['service_charge'];
                                                $other_misc = $row['other_misc'];
                                                $total = $invoice_amt + $inspection_charge + $service_charge;
                                                $puspakom_from = $row['puspakom_from'];
                                                $puspakom_to = $row['puspakom_to'];
                                                $remark = $row['remark'];
                                                
                                                $total_sum += $total;
                                                
                                                $tbody .="<tr>";
                                                $tbody .="<td>".$count.".</td>";
                                                $tbody .="<td>".strtoupper($runner_name)."</td>";
                                                $tbody .="<td>".$bill_no."</td>";
                                                $tbody .="<td>".$vehicle_no."</td>";
                                                $tbody .="<td>".$invoice_no."</td>";
                                                $tbody .="<td class='text-center'>".number_format($invoice_amt,2)."</td>";
                                                $tbody .="<td class='text-center'>".number_format($inspection_charge,2)."</td>";
                                                $tbody .="<td class='text-center'>".number_format($service_charge,2)."</td>";
                                                $tbody .="<td>".$other_misc."</td>";
                                                $tbody .="<td class='text-right'>".number_format($total,2)."</td>";
                                                $tbody .="<td>".dateFormatRev($puspakom_from)."</td>";
                                                $tbody .="<td>".dateFormatRev($puspakom_to)."</td>";
                                                $tbody .="<td>".$remark."</td>";
                                                $tbody .="</tr>";
                                                
                                            }
                                            $tbody .="<tr>";
                                            $tbody .="<td colspan='9' class='text-right font-weight-bold'>TOTAL (RM)</td>";
                                            $tbody .="<td class='text-right font-weight-bold'>".number_format($total_sum,2)."</td>";
                                            $tbody .="<td>&nbsp;</td>";
                                            $tbody .="<td>&nbsp;</td>";
                                            $tbody .="<td>&nbsp;</td>";
                                            $tbody .="</tr>";
                                            $tbody .="</table>";
                                            
                                        }
                                    ?>
                                    
                                    <tbody> 
                                     <?=$tbody;?>                                    
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
