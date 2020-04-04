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
$ref_no = "";
if(!empty($select_account)){
    $company_name = itemName("SELECT name FROM company WHERE id IN (SELECT company_id FROM bill_account_setup WHERE acc_id = '$select_account')");
    $acc_no = itemName("SELECT account_no FROM bill_account_setup WHERE acc_id='$select_account'");
    $ref_no = itemName("SELECT reference FROM bill_account_setup WHERE acc_id='$select_account'");
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
                                <strong class="card-title">Telekom</strong>
                            </div>
                            <div class="card-body">
                                <form id="myform" enctype="multipart/form-data" method="post" action="">                	                   
									<div class="form-group row col-sm-12">
										<div class="col-sm-3">
                                            <label for="date_start" class="form-control-label"><small class="form-text text-muted">Account No.</small></label>
                                            <?php
                                                $jabatan_air_acc = mysqli_query ( $conn_admin_db, "SELECT acc_id , CONCAT((SELECT c.code FROM company c WHERE c.id = bill_account_setup.company_id),' - ',bill_account_setup.account_no ) AS comp_acc FROM bill_account_setup WHERE bill_type='3'");
                                                db_select ($jabatan_air_acc, 'acc_no', $select_account,'','-select-','form-control','');
                                            ?>                           
                                        </div>
                                        <div class="col-sm-2">
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
    	  var company_name = '<?=$company_name;?>';
          var year = '<?=$year_select;?>';
          var res = company_name.concat('_'+year);
          var acc_no = '<?=$acc_no;?>';
          var ref_no = '<?=$ref_no?>';

//           if ( config.header) {
//               var tablecaption = [config.message];
//        			addRow( tablecaption, rowPos );
//               //addRow( "testing", "0" );
//                addRow( "", rowPos );
//              addRow( data.header, rowPos );
//              //$('row c', rels).attr( 's', '2' ); // bold
//          }
          
          $('#telekom_table').DataTable({
              "searching": true,
        	  "dom": 'Bfrtip',
			  "paging": false,
              "buttons": [ 
               { 
              	extend: 'excelHtml5', 
              	title: 'Telekom_'+res,
              	footer: true,
              	customize: function ( xlsx ) {
              		console.log(xlsx);
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var downrows = 3;
                    var clRow = $('row', sheet);
                    //update Row
                    clRow.each(function () {
                        var attr = $(this).attr('r');
                        var ind = parseInt(attr);
                        ind = ind + downrows;
                        $(this).attr("r",ind);
                    });
             
                    // Update  row > c
                    $('row c ', sheet).each(function () {
                        var attr = $(this).attr('r');
                        var pre = attr.substring(0, 1);
                        var ind = parseInt(attr.substring(1, attr.length));
                        ind = ind + downrows;
                        $(this).attr("r", pre + ind);
                    });
             
                    function Addrow(index,data) {
                        msg='<row r="'+index+'">'
                        for(i=0;i<data.length;i++){
                            var key=data[i].k;
                            var value=data[i].v;
                            msg += '<c t="inlineStr" r="' + key + index + '" s="42">';
                            msg += '<is>';
                            msg +=  '<t>'+value+'</t>';
                            msg+=  '</is>';
                            msg+='</c>';
                        }
                        msg += '</row>';
                        return msg;
                    }
             
                    //insert
                    var r1 = Addrow(1, [{ k: 'A', v: 'Company' }, { k: 'B', v: company_name }]);
                    var r2 = Addrow(2, [{ k: 'A', v: 'Account No.' }, { k: 'B', v: acc_no }]);
                    var r3 = Addrow(3, [{ k: 'A', v: 'Reference' }, { k: 'B', v: ref_no }]);
                    
                    sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + sheet.childNodes[0].childNodes[1].innerHTML;
                
               }
               },
               {
              	extend: 'print',
              	title: 'Telekom <br>Company : '+company_name+'<br>'+'Account No. : '+acc_no+'<br>Year : '+year,
              	footer: true,
              	customize: function ( win ) {
              		$(win.document.body).find('h1').css('font-size', '12pt'); 
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
      					data.filter = '<?=$select_account?>';
      					data.year = '<?=$year_select?>';		
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
