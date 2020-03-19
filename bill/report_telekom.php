<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;




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
                                <strong class="card-title">Telekom</strong>
                            </div>
<!--                             <div class="card-body"> -->
<!--                                 <form id="myform" enctype="multipart/form-data" method="post" action="">                	                    -->
<!--                     	            <div class="form-group row col-sm-12"> -->
<!--                                         <div class="col-sm-3"> -->
<!--                                             <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label> -->
<!--                                             <div class="input-group"> -->
<!--                                              <input type="text" id="date_start" name="date_start" class="form-control" value="<?=$date_start?>" autocomplete="off">
<!--                                               <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
<!--                                             </div>                             -->
<!--                                         </div> -->
<!--                                         <div class="col-sm-3"> -->
<!--                                             <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label> -->
<!--                                             <div class="input-group"> -->
<!--                                             <input type="text" id="date_end" name="date_end" class="form-control" value="<?=$date_end?>" autocomplete="off">
<!--                                               <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
<!--                                             </div>                              -->
<!--                                         </div> -->
<!--                                         <div class="col-sm-4">                                    	 -->
<!--                                         	<button type="submit" class="btn btn-primary button_search ">Submit</button> -->
<!--                                         </div> -->
<!--                                      </div>     -->
<!--                                 </form> -->
<!--                             </div> -->
<!--                             <hr> -->
                            <div class="card-body">
                                <table id="telekom_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                       		<th>Description</th>
                        					<th scope='col'>Jan</th>
                                            <th scope='col'>Feb</th>
                                            <th scope='col'>Mar</th>
                                            <th scope='col'>Apr</th>
                                            <th scope='col'>May</th>
                                            <th scope='col'>Jun</th>
                                            <th scope='col'>Jul</th>
                                            <th scope='col'>Aug</th>
                                            <th scope='col'>Sep</th>
                                            <th scope='col'>Oct</th>
                                            <th scope='col'>Nov</th>
                                            <th scope='col'>Dec</th>
											<th scope='col'>TOTAL</th>                                            
                                        </tr>                                        									
                                    </thead>
                                    <tbody>                                      
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
          $('#telekom_table').DataTable({
              "searching": true,
        	  "dom": 'Bfrtip',
			  "paging": false,
              "buttons": [ 
               { 
              	extend: 'excelHtml5', 
              	messageTop: 'Vehicle Summon',
              	footer: true 
               },
               {
              	extend: 'print',
              	messageTop: 'Vehicle Summon',
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
      					data.action = 'report_telekom';				
         	        }         	                 
                 },
             'columnDefs': [
           	  {
           	      "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13], // your case first column
           	      "className": "text-right", 
           	      //"render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
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
