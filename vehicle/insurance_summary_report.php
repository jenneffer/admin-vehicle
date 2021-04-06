<?php
	require_once('../assets/config/database.php');
	require_once('../check_login.php');
	global $conn_admin_db;
	$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
	$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');
	$select_c = isset($_POST['select_company']) ? $_POST['select_company'] : "";
	
	
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
	<?php  include('../assets/nav/leftNav.php')?>
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
                                <strong class="card-title">Insurance Summary</strong>
                            </div>
                            <div class="card-body">
                            <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
                	            <div class="form-group row col-sm-12">
                	            	<div class="col-sm-3">
                            			<label for="company_dd" class="form-control-label"><small class="form-text text-muted">Company</small></label>
                                		<?php
                                            $select_company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE vehicle_used='1' AND status='1' ORDER BY name ASC");
                                            db_select ($select_company, 'select_company', $select_c,'submit()','All','form-control form-control-sm','');                        
                                        ?>
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
                                <table id="general_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th colspan="2" style="text-align: center">Date</th>											
                                            <th rowspan="2">Reg No.</th>										
											<th rowspan="2">Company</th>
<!-- 											<th rowspan="2">Insurer</th> -->
<!-- 											<th rowspan="2">CN/Policy No.</th> -->
											<th rowspan="2">Amount (RM)</th>											
											<th rowspan="2">Sum Insured (RM)</th>
											<th rowspan="2">NCD (%)</th>
											<th rowspan="2">Excess (RM)</th>
											<th rowspan="2">Type of Cover</th>											
											<th rowspan="2">Payment Details</th>                                            
                                        </tr>
                                        <tr>
                                            <th>From</th>
											<th>To</th>											
                                        </tr>
                                    </thead>
                                    <tbody>                                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-right font-weight-bold">Total</th>                                            
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
    </div> <!-- from right panel page -->
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
            var table = $('#general_table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax":{
                 "url": "insurance.ajax.php",    
                 "type": "POST",            	
                 "data" : function ( data ){	
                	 	data.date_start = '<?=$date_start?>';
						data.date_end = '<?=$date_end?>';	
						data.select_company = '<?=$select_c?>';	
						data.action = 'get_insurance_summary_report';							
                     }
                },
                "footerCallback": function( tfoot, data, start, end, display ) {
    				var api = this.api(), data;
    				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;

					api.columns([4,7], { page: 'current'}).every(function() {
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
                	      "targets": [4,5,7], // your case first column
                	      "className": "text-right", 
                	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
                	 },
                	 {
               	      "targets": [4,5,7,8], // your case first column
               	      "className": "text-center",                	                  	                      	        	     
               	 	}
				],
				"dom": 'Bfrtip',
	            "buttons": [ 
	             { 
	            	extend: 'excelHtml5', 
	            	messageTop: 'General Table',
	            	footer: true 
	             },
	             {
	            	extend: 'print',
	            	messageTop: 'Insurance Summary',
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

    		//get filtered report
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
