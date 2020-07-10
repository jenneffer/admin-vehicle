<?php

require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$month_name = isset($_GET['month']) ? $_GET['month'] : "";
$acc_id = isset($_GET['acc_id']) ? $_GET['acc_id'] : "";
$year = isset($_GET['year']) ? $_GET['year'] : "";
$date_added = isset($_GET['date_added']) ? $_GET['date_added'] : "";

$company_name = itemName("SELECT name FROM company WHERE id IN(SELECT company FROM bill_fuji_xerox_account WHERE id='$acc_id')");
$query = "SELECT  * FROM bill_fuji_xerox_invoice
            WHERE acc_id='$acc_id' AND YEAR(invoice_date)='$year' AND MONTHNAME(invoice_date)='$month_name'";

$result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
$arr_data = [];
while($row = mysqli_fetch_assoc($result)){
    $arr_data[] = $row;
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
    .overline {       
        border-top: 1px solid black;
    }
    .finance_div{
        padding: 5px;
    }
    @media print {
    .btn-print,.btn-goback{
        display:none;
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
                        <strong class="card-title">Payment Request</strong>
                    </div>                              
                    <div class="card-body" id="printStatement">
                    	<div class="form-group row col-sm-12">
                    		<div class="row col-sm-12">
                            	<div class="col-sm-6 text-left">
                            		<h5><u>Subject : Payment Request</u></h5>
                            	</div>
                            </div>
                    	</div>
                        <div class="form-group row col-sm-12">
                        	<div class="row col-sm-12">
                            	<div class="col-sm-6">
                            		<h5><b>Company : </b><b> <?=$company_name?></b></h5>
                            	</div>
                            	<div class="col-sm-6 text-right">
                            		<h5><b> <?=dateFormatRev($date_added)?></b></h5>
                            	</div>
                            </div>
                        </div>                                                                     				
                        <div class="col-sm-12">
                            <table id="mytable">
                                <thead>
                                	<tr style="background-color: lightgrey;">
                                        <th>No</th>
                                        <th class="text-center">Serial No.</th>
                                        <th class="text-center">Invoice date</th>
                                        <th class="text-center">Invoice No.</th>
                                        <th class="text-center">Particulars</th>
                                        <th class="text-right">Amount (RM)</th>
                                        <th class="text-center">Remarks</th>                                        
                                    </tr>
                                </thead>
                                <tbody>  
                                <?php 
                                    $count = 0;
                                    $total_amount = 0;
                                    foreach ($arr_data as $data){ 
                                        $count++;
                                        $total_amount += $data['amount'];  
                                        $serial_no = itemName("SELECT serial_no FROM bill_fuji_xerox_account WHERE id='".$data['acc_id']."'");
                                        
                                    ?>
                                <tr>
                                    <td class="text-center"><?=$count?>.</td>
                                    <td class="text-center"><?=$serial_no?></td>
                                    <td class="text-center"><?=$data['invoice_date']?></td>
                                    <td class="text-center"><?=$data['invoice_no']?></td>
                                    <td class="text-center"><?=$data['particular']?></td>
                                    <td class="text-right"><?=number_format($data['amount'],2)?></td>
                                    <td class="text-center"><?=$data['remark']?></td>
                                    
                                </tr>
                                <?php }?>                          
                                </tbody>                                                                
<!--                                 <tfoot> -->
<!--                                 <tr> -->
<!--                                 	<td colspan="5">&nbsp;</td> -->
<!--                                 	<td class="text-right"><b><?=number_format($total_amount,2)?></b></td>
<!--                                 	<td>&nbsp;</td> -->
<!--                                 </tr> -->
<!--                                 </tfoot> -->
                            </table>                                                
                        </div>
                        <div class="row col-sm-12 text-right">                    	
                        	<div class="col-sm-6">&nbsp;</div>
                        	<div class=" row col-sm-6">
                        		<div class="col-sm-5">
                                	<label class=" form-control-label"><b>Grand Total</b></label>                            
                                </div> 
                                <div class="col-sm-2">&nbsp;</div>                               
                                <div class="col-sm-3 myLine">
                                    <label class=" form-control-label"><b><?=number_format($total_amount,2)?></b></label>                            
                                </div>
                        	</div>
                        </div>          
                        <br><br><br><br><br>
                        <div class="row col-sm-12 text-center">   
                        	<div class="col-sm-3 offset-sm-1 text-center font-italic">Prepared by,</div>
                        	<div class="col-sm-3 offset-sm-1 text-center font-italic">Verified by,</div>
                        	<div class="col-sm-3 offset-sm-1 text-center font-italic">Authorized by,</div>
                        </div>  
                        <br><br>  
                        <div class="row col-sm-12 text-center"> 
                        	<div class="col-sm-3 offset-sm-1 text-center overline" ><span><?=ucfirst($_SESSION['cr_name'])?></span></div>
                        	<div class="col-sm-3 offset-sm-1 text-center overline"><span>Cathrine E.</span></div>
                        	<div class="col-sm-3 offset-sm-1 text-center overline"><span>Kong Lih Shan</span></div>
                        </div> 
                        <br><br><br><br><br>
                        <div class="row col-sm-12 finance_div">
                        	<div class="col-sm-9"></div> 
                        	<div class="col-sm-3"><u>FOR FINANCE DEPARTMENT USE:</u></div>                          	                     	
                        </div> 
                        <div class="row col-sm-12 finance_div">
                        	<div class="col-sm-9"></div> 
                        	<div class="col-sm-3">Date Paid:</div>                          	                     	
                        </div>
                        <div class="row col-sm-12 finance_div">
                        	<div class="col-sm-9"></div> 
                        	<div class="col-sm-3">Chq No:</div>                          	                     	
                        </div>
                        <div class="row col-sm-12 finance_div">
                        	<div class="col-sm-9"></div> 
                        	<div class="col-sm-3">By:</div>                          	                     	
                        </div>
                        <div class="row col-sm-12 finance_div">
                        	<div class="col-sm-9"></div> 
                        	<div class="col-sm-3">Original Bill & Receipt Received.</div>                          	                     	
                        </div>  
                        <br><br><br>      
                        <div class="card-text text-sm-center">
                        	<button class="btn-info btn btn-goback" onclick="goBack()">Back</button>
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
