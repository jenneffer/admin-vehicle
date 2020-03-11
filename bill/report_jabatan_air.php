<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$select_account = isset($_POST['acc_no']) ? $_POST['acc_no'] : "";

function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
        switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
        }
    }
    return $num.'th';
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
        .hide{
            display:none
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
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Jabatan Air</strong>
                            </div>
							<div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">
                                        <div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Account No.</small></label>
                                            <?php
                                                $jabatan_air_acc = mysqli_query ( $conn_admin_db, "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id),' - ',bill_account_setup.account_no ) AS comp_acc FROM bill_account_setup WHERE bill_type='2'");
                                                db_select ($jabatan_air_acc, 'acc_no', $select_account,'','-select-','form-control','');
                                            ?>                           
                                        </div>
                                        <div class="col-sm-4">                                    	
                                        	<button type="submit" class="btn btn-primary button_search ">Submit</button>
                                        </div>
                                     </div>    
                                </form>
                            </div>
                            <hr>
                            <div class="card-body">
                                <table id="jabatan_air_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>Description</th>
											<th colspan="3" class="text-center">Meter Reading</th>
                                            <th colspan="2" class="text-center">0-70</th>
											<th colspan="2" class="text-center">>70</th>
											<th rowspan="2">Credit</th>											
											<th rowspan="2">Adjustment</th>
											<th colspan="2" class="text-center">Period Date</th>											
                                            <th rowspan="2">Cheque No.</th>
                                            <th rowspan="2">Payment Date</th>
                                            <th rowspan="2">Amount (RM)</th>
                                        </tr>
                                        <tr>
                                        	<th>Month</th>
                                        	<th>From</th>
                                        	<th>To</th>
                                        	<th>Total Usage</th>
                                        	<th>M3</th>
                                        	<th>1.60</th> 
                                        	<th>M3</th>
                                        	<th>2.00</th>    
                                        	<th>From</th>
                                        	<th>To</th>                                     	
                                        </tr>										
                                    </thead>
                                    <tbody>                                      
                                    </tbody> 
                                    <tfoot>
                                    	<tr>
                                            <td colspan="3" class="text-right font-weight-bold">Grand Total</td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                            <td class="text-right font-weight-bold"></td>
                                        </tr>
                                    </tfoot>                                                                   
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
          $('#jabatan_air_table').DataTable({
              "searching": true,
        	  "dom": 'Bfrtip',
        	  "order" : [[ 10, "asc" ]],            
              "buttons": [ 
               { 
              	extend: 'excelHtml5', 
              	messageTop: 'Vehicle Summon ',
              	footer: true 
               },
               {
              	extend: 'print',
              	messageTop: 'Vehicle Summon ',
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
              "ajax":{
                  "url": "report_all.ajax.php",  
                  "type":"POST",       	        	
             	 	"data" : function ( data ) {
      					data.action = 'report_jabatan_air';	
      					data.filter = '<?=$select_account?>';			
         	        }         	                 
                 },
             "footerCallback": function( tfoot, data, start, end, display ) {
  				var api = this.api(), data;
  				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;

 				api.columns([3,5,7,8,9,14], { page: 'current'}).every(function() {
 					var sum = this
 				    .data()
 				    .reduce(function(a, b) {
 				    var x = parseFloat(a) || 0;
 				    var y = parseFloat(b) || 0;
 				    	return x + y;
 				    }, 0);			
 				       
 				    $(this.footer()).html(numFormat(sum));
 				}); 
  			},
  			'columnDefs': [
           	  {
           	      "targets": [1,2,3,5,6,7,8,9,14], // your case first column
           	      "className": "text-right", 
           	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
           	 }
 			],
           });
//           $('#date_start, #date_end').datepicker({
//               format: "dd-mm-yyyy",
//               autoclose: true,
//               orientation: "top left",
//               todayHighlight: true
//           });
      });
  </script>
</body>
</html>
