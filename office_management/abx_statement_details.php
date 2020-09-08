<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$abx_id = isset($_GET['abx_id']) ? $_GET['abx_id'] : "";

$query = "SELECT * FROM om_abx_statement
            INNER JOIN om_abx_statement_list ON om_abx_statement.id = om_abx_statement_list.abx_id
            WHERE om_abx_statement.id='$abx_id'";

$invoice_no = itemName("SELECT invoice_no FROM om_abx_statement WHERE id='$abx_id'");

$result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
$arr_data = [];
$total_by_company = [];
while ($row = mysqli_fetch_assoc($result)) {
    $code = itemName("SELECT code FROM company WHERE id='".$row['company_id']."'");
    $arr_data[] = $row;
    $total_by_company[$code] += $row['amount'];
}


?>

<!doctype html><html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Vehicle</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- link to css -->
	<?php include('../allCSS1.php')?>
   <style>
    .select2-selection__rendered {
      margin: 5px;
    }
    .select2-selection__arrow {
      margin: 5px;
    }
    .select2-container{ 
        width: 100% !important; 
    }
    .button_add{
        position: absolute;
        left:    0;
        bottom:   0;
    }
    .hideBorder {
        border: 0px;
        background-color: transparent;        
    }
    .hideBorder:hover {
        background: transparent;
        border: 1px solid #dee2e6;
    }
    form{
        margin: 20px 0;
    }
    form input, button{
        padding: 5px;
    }
    table{
        width: 100%;
        margin-bottom: 20px;
		border-collapse: collapse;
    }
    table, th, td{
        border: 1px solid #cdcdcd;
    }
    table th, table td{
        padding: 10px;
        text-align: left;
    }
    .myLine {
      border-top: 1px outset black;
      border-bottom: 2px outset black;      
    }
    @media print {
        .btn-print{
            display:none !important;
        }               
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
                <div class="card"  id="printableArea">
                    <div class="card-header">
                        <strong class="card-title">ABX Statement Details</strong>
                    </div>                              
                    <div class="card-body" id="printStatement">
                        <div class="form-group row col-sm-12">
                        	<div class="col-sm-12 text-center">
                                <h4><b>INVOICE : </b><b> <?=$invoice_no?></b></h4>
                                
                            </div>
                        </div>                                                                     				
                        <div class="col-sm-12">
                            <table id="mytable">
                                <thead>
                                	<tr style="background-color: lightgrey;">
                                        <th>DATE</th>
                                        <th>AIRBILL NO.</th>
                                        <th>PARTICULAR</th>
                                        <th class="text-center">COMPANY</th>
                                        <th class="text-center">REQUESTED BY</th>
                                        <th class="text-right">CHARGE</th>
                                        <th class="text-right">TAX</th>
                                        <th class="text-right">AMOUNT (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                <?php 
                                    $total_charge = 0;
                                    $total_tax = 0;
                                    $total_amount = 0;
                                    foreach ($arr_data as $data){
                                    $company_name = itemName("SELECT code FROM company WHERE id='".$data['company_id']."'");                                
                                    $total_charge += $data['charge'];
                                    $total_tax += $data['tax'];
                                    $total_amount += $data['amount'];                                
                                    ?>
                                <tr>
                                	<td><?=dateFormatRev($data['date'])?></td>
                                	<td><?=$data['airbill_no']?></td>
                                	<td><?=$data['particular']?></td>
                                	<td class="text-center"><?=$company_name?></td>
                                	<td class="text-center"><?=$data['requested_by']?></td>
                                	<td class="text-right"><?=number_format($data['charge'],2)?></td>
                                	<td class="text-right"><?=number_format($data['tax'],2)?></td>
                                	<td class="text-right"><?=number_format($data['amount'],2)?></td>
                                </tr>
                                <?php }?>                          
                                </tbody>
                                
                                <tfoot>
                                <tr>
                                	<td colspan="5">&nbsp;</td>
                                	<td class="text-right"><b><?=number_format($total_charge,2)?></b></td>
                                	<td class="text-right"><b><?=number_format($total_tax,2)?></b></td>
                                	<td class="text-right"><b><?=number_format($total_amount,2)?></b></td>
                                </tr>
                                </tfoot>
                            </table>                                                
                        </div>
                        <br>
                        <div class="row col-sm-12 text-right">                    	
                        	<div class="col-sm-6">&nbsp;</div>
                        	<div class="form-group row col-sm-6">
                        		<div class="col-sm-6">
                                	<label class=" form-control-label"><b>GRAND TOTAL</b></label>                            
                                </div>
                                <div class="col-sm-3">&nbsp;</div>
                                <div class="col-sm-3 myLine">
                                    <label class=" form-control-label"><b><?=number_format($total_amount,2)?></b></label>                            
                                </div>
                        	</div>
                        </div>
                        <div class="col-sm-12 text-right"> 
                        
                        <?php foreach ($total_by_company as $code => $data_value){?>                    
                        	<div class=" row col-sm-6">
                        		<div class="col-sm-6">&nbsp;</div>
                        		<div class="col-sm-3">
                                	<label class=" form-control-label"><?=$code?></label>                            
                                </div>
                                <div class="col-sm-3">
                                    <label class=" form-control-label"><?=number_format($data_value,2)?></label>                            
                                </div>
                        	</div>                          
                        <?php }?>
                        
                        </div>
                        <div class="row col-sm-6 text-right">                    	
                        	<div class="col-sm-3">&nbsp;</div>
                        	<div class="col-sm-6">
                            	<label class=" form-control-label"><b>GRAND TOTAL</b></label>                            
                            </div>
                            <div class="col-sm-3 myLine">
                                <label class=" form-control-label"><b><?=number_format($total_amount,2)?></b></label>                            
                            </div>
                        </div>
                        <br><br><br>
                        <div class="card-text text-sm-center">
                        	<button class="btn-info btn btn-print" onclick="goBack()">Back</button>
                        	&nbsp;&nbsp;
                        	<button class="btn-primary btn btn-print" onclick="printDiv('printStatement')">Print</button>  
                        </div>                                       
            		</div>
    			</div>
    		</div>
        	</div><!-- .animated -->
    	</div><!-- .content -->
    </div>
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
<script src="../assets/js/select2.min.js"></script>

<script type="text/javascript">
function printDiv(divName){
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
}
function goBack() {
	window.history.back();
}
</script>
</body>
</html>
