<?php
	require_once('../assets/config/database.php');
	
	session_start();
	if(isset($_SESSION['cr_id'])) {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $params);
		
		// get id
		$userId = $_SESSION['cr_id'];
		$name = $_SESSION['cr_name'];
		
	} else {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$PrevURL= $url;
		header("Location: ../login.php?RecLock=".$PrevURL);
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
    <title>Eng Peng Insurance</title>
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
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Road Tax</strong>
                            </div>
                            <div class="card-body">
                                <table id="general_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th rowspan="2">No.</th>
											<th rowspan="2">Company</th>
                                            <th rowspan="2">Plat No.</th>
											<th rowspan="2">LPKP (date)</th>											
											<th colspan="2">Period of Insuranse</th>
											<th rowspan="2">Premium (RM)</th>
											<th rowspan="2">NCD (%)</th>
											<th rowspan="2">Sum Insured (RM)</th>
											<th rowspan="2">Excess</th>
											<th rowspan="2">Capacity</th>
											<th rowspan="2">Puspakom</th>
                                            <th colspan="2">Road Tax</th>
                                            <th rowspan="2">Amount(RM)</th>
                                            <th rowspan="2">Period</th>
                                        </tr>
                                        <tr>
                                            <th>From</th>
											<th>To</th>
											<th>From</th>
											<th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-right font-weight-bold">Total</td>
                                            <td class="text-right font-weight-bold">Premium Total</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>                                            
                                            <td class="text-right font-weight-bold">Excess Total</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td class="text-right font-weight-bold">Amount Total</td>
                                            <td>&nbsp;</td>
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
	
	<script type="text/javascript">
        $(document).ready(function() {
            $('#general_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                 "url": "general.table.ajax.php",           	
                 "data" : function ( data ){}
                },
                "footerCallback": function( tfoot, data, start, end, display ) {
    				var api = this.api(), data;
    				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;

					api.columns([6,9,14], { page: 'current'}).every(function() {
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
                	      "targets": [6,8,9,14], // your case first column
                	      "className": "text-right", 
                	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
                	 }],

            	
            });
      });
  </script>
</body>
</html>
