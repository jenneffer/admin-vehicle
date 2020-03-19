<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$select_account = isset($_POST['acc_no']) ? $_POST['acc_no'] : "";

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
ob_start();
selectYear('year_select',$year_select,'','','form-control','','');
$html_year_select = ob_get_clean();
$company_name = "";
$acc_no = "";
if(!empty($select_account)){
    $company_name = itemName("SELECT name FROM company WHERE id IN (SELECT company_id FROM bill_account_setup WHERE acc_id = '$select_account')");
    $acc_no = itemName("SELECT account_no FROM bill_account_setup WHERE acc_id='$select_account'");
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
                                <strong class="card-title">SESB</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                    	            <div class="form-group row col-sm-12">
                                        <div class="col-sm-3">
                                            <label for="acc_no" class="form-control-label"><small class="form-text text-muted">Account No.</small></label>
                                            <?php
                                                $sesb_acc = mysqli_query ( $conn_admin_db, "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id),' - ',bill_account_setup.account_no ) AS comp_acc FROM bill_account_setup WHERE bill_type='1'");
                                                db_select ($sesb_acc, 'acc_no', $select_account,'','-select-','form-control','');
                                            ?>                           
                                        </div>
                                        <div class="col-sm-1">
                                        	<label for="acc_no" class="form-control-label"><small class="form-text text-muted">Year</small></label>
                                        	<?=$html_year_select;?>
                                        </div>
                                        <div class="col-sm-4">                                    	
                                        	<button type="submit" class="btn btn-primary button_search ">Submit</button>
                                        </div>
                                     </div>    
                                </form>
                            </div>
                            <hr>
                            <div class="card-body">
                                <table id="sesb_table" class="table table-striped table-bordered">                                
                                    <thead>
                                        <tr>
                                        	<th>Description</th>
											<th colspan="3" class="text-center" >Meter Reading</th>
                                            <th rowspan="2">Current Usage (RM)</th>
											<th rowspan="2">KWTBB (RM)</th>
											<th rowspan="2">Penalty (RM)</th>											
<!-- 											<th rowspan="2">Power Factor Below 0.85</th> -->
											<th rowspan="2">Additional Deposit (RM)</th>
											<th rowspan="2">Other Charges (RM)</th>											
                                            <th rowspan="2">Adjustment</th>
                                            <th colspan="2" class="text-center">Period Date</th>
                                            <th rowspan="2">Amount (RM)</th>
                                            <th rowspan="2">Due Date</th>
                                            <th rowspan="2">Cheque No.</th>
                                            <th rowspan="2">Payment Date</th>
                                        </tr>
                                        <tr>
                                        	<th>Month</th>
                                        	<th>From</th>
                                        	<th>To</th>
                                        	<th>Total Usage (KWH)</th>
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
    	  var company_name = '<?=$company_name;?>';
          var year = '<?=$year_select;?>';
          var res = company_name.concat('_'+year);
          var acc_no = '<?=$acc_no;?>';
          
          $('#sesb_table').DataTable({
              "searching": true,
              "order" : [[ 10, "asc" ]],              
        	  "dom": 'Bfrtip',
              "buttons": [ 
               { 
              	extend: 'excelHtml5', 
              	title: 'SESB_'+res,
              	footer: true 
               },
               {
              	extend: 'print',
              	title: 'Company : '+company_name+'<br>'+'Account No. : '+acc_no,              	
              	footer: true,
              	customize: function ( win ) {
                            $(win.document.body).find('h1').css('font-size', '12pt'); 
                            $(win.document.body)
                              .css( 'font-size', '10pt' );
                            
                            $(win.document.body).find( 'table' )
                              .addClass( 'compact' ).css( 'font-size', 'inherit' );

                            var last = null;
                            var current = null;
                            var bod = [];
             
                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName('head')[0],
                                style = win.document.createElement('style');
             
                            style.type = 'text/css';
                            style.media = 'print';
             
                            if (style.styleSheet)
                            {
                              style.styleSheet.cssText = css;
                            }
                            else
                            {
                              style.appendChild(win.document.createTextNode(css));
                            }
             
                            head.appendChild(style);
                  }
               }
              ],
              "ajax":{
                  "url": "report_all.ajax.php",  
                  "type":"POST",       	        	
             	 	"data" : function ( data ) {
      					data.action = 'report_sesb';	
      					data.filter = '<?=$select_account?>';
      					data.year = '<?=$year_select?>';			
         	        }         	                 
                 },
             "footerCallback": function( tfoot, data, start, end, display ) {
 				var api = this.api(), data;
 				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;

				api.columns([3,4,5,6,7,8,9,12], { page: 'current'}).every(function() {
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
          	      "targets": [3,4,5,6,7,8,9,12], // your case first column
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
