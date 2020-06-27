<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

    $date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date('01-m-Y');
    $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date('t-m-Y');

    $query = "SELECT sst.department_id, sst.item_id, date_added, date_taken, si.item_name,sd.department_code, 
            SUM(quantity) as quantity FROM stationary_stock_take sst
            INNER JOIN stationary_item si ON si.id = sst.item_id
            INNER JOIN stationary_department sd ON sd.department_id = sst.department_id
            WHERE date_taken BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."'
            GROUP BY sst.department_id, sst.item_id ORDER BY quantity DESC";
    
    $result = mysqli_query ( $conn_admin_db,$query);
    $arr_data = array();
    while($row = mysqli_fetch_assoc($result)){
        $arr_data[$row['department_id']][] = $row;
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
        .button_search{
            position: absolute;
            left:    0;
            bottom:   0;
        }

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
                                              <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>                            
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                            <div class="input-group">
                                              <input type="text" id="date_end" name="date_end" class="form-control" value="<?=$date_end?>" autocomplete="off">
                                              <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                            </div>                             
                                        </div>
                                        <div class="col-sm-1">                                    	
                                        	<button type="submit" class="btn btn-primary button_search ">View</button>                                        	
                                        </div>
                                        <div class="col-sm-1">                                    	
                                        	<button type="button" class="btn btn-primary button_search" onclick="printDiv('printableArea')">Print</button>
                                        </div>
                                        <div class="col-sm-1">                                    	
                                        	<button type="button" class="btn btn-primary button_search" onclick="fnExcelReport();">Export to Excel</button>
                                        </div>
                                     </div>    
                                </form>
                            </div>
                            <hr>
                            <div class="card-body" >
                                <table id="department_summary" class="table table-striped table-bordered">
                                    <?php 
                                    
                                    $tbody = ""; 
                                    foreach ($arr_data as $dept_id => $data){                                       
                                        $dept_name = itemName("SELECT department_code FROM stationary_department WHERE department_id='$dept_id'");
             
                                        $tbody .= "<tr><th colspan='3' style='text-align:center;'>".$dept_name."</th></tr>";                                        
                                        $tbody .= "<tr><th>No.</th><th>Item</th><th style='text-align:center;'>Quantity</th></tr>";                                         
                                        $count = 0;
                                        foreach ($data as $value){
                                            $count++;                                                                                           
                                            $tbody .= "<tr>";
                                            $tbody .= "<td>".$count.".</td>";
                                            $tbody .= "<td>".$value['item_name']."</td>";
                                            $tbody .= "<td style='text-align:center;'>".$value['quantity']."</td>";
                                            $tbody .= "</tr>";
                                        }
                                    }
                                    ?>
                                    <tbody>
                                    <?=$tbody;?>
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
//           $('#department_summary').DataTable({
//               "searching": false,
//               "paging": false,
//         	  "dom": 'Bfrtip',
//               "buttons": [ 
//                { 
//               	extend: 'excelHtml5', 
//               	messageTop: 'Vehicle Summon ',
//               	footer: true 
//                },
//                {
//               	extend: 'print',
//               	messageTop: 'Stock Summary ',
//               	footer: true,
//               	customize: function ( win ) {
//                       $(win.document.body)
//                           .css( 'font-size', '10pt' );
              
//                       $(win.document.body).find( 'table' )
//                           .addClass( 'compact' )
//                           .css( 'font-size', 'inherit' );
//                   }
//                }
//               ],
//            });
    	  $('#date_start, #date_end').datepicker({
              format: "dd-mm-yyyy",
              autoclose: true,
              orientation: "top left",
              todayHighlight: true
          });
      });
      
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
</html>