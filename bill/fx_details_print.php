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

<html>
<title>PAYMENT REQUEST</title>
<?php include('../allCSS1.php')?>
<style>
.table-1 {
    padding:5px;
    border-collapse:separate;
    border-spacing: 15px;
    /*font-size:14px;*/
}
.table-content {
    border: 1px solid black;
    border-collapse:collapse;
    padding: 8px;    
 }
 .button{
    width:10%;
    font-size:10pt;
 }
@page {
/*     font-size:11px; */
    font-family: "Open Sans", sans-serif;
    size: auto;  
    margin: 5mm; 
}
@media print {
    #print{
        display:none;
    }
}   
</style>
<body>
<table class="table-1" style="width: 100%">
<tr>
	<th class="table-1" colspan="6" style="text-align:center; font-size:18px">PAYMENT REQUEST</th>	
</tr>
<tr>    
	<td><b>Company : <?=$company_name?></b></td>
    <td class="table-1 text-right"><?=$date_added?></td>
</tr>
</table>
<table class="table-content" style="width: 100%; text-align:center;">
<tr>
    <th class="table-content text-center" width="5%">No.</th>
    <th class="table-content text-center" width="10%">Machine Serial No.</th>
    <th class="table-content text-center" width="15%">Invoice Date</th>
    <th class="table-content text-center" width="15%">Invoice No.</th>
    <th class="table-content text-center" width="20%">Particulars</th>
    <th class="table-content text-center" width="10%">Amount (RM)</th>
    <th class="table-content text-center" width="10%">Remarks</th>
    
</tr>
<?php 
    $counter = 0;
    $total = 0;
    foreach ($arr_data as $data){
        $serial_no = itemName("SELECT serial_no FROM bill_fuji_xerox_account WHERE id='".$data['acc_id']."'");
    $counter++;
    $total += $data['amount'];
    ?>  
    <tr>
        <td class="table-content" style="text-align: center"><?=$counter?>.</td>
        <td class="table-content text-center"><?=$serial_no?></td>
        <td class="table-content text-center">&nbsp;<?=$data['invoice_date']?></td>
        <td class="table-content text-center">&nbsp;<?=$data['invoice_no']?></td>
        <td class="table-content text-center">&nbsp;<?=$data['particular']?></td>
        <td style='text-align: right;' class="table-content"><?=number_format($data['amount'],2)?></td>
        <td class="table-content text-center">&nbsp;<?=$data['remark']?></td>
        
    </tr>
<?php }?>    
<tr>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>    
    <th style='text-align: right;'>Grand Total</th>
    <th style='text-align: right;'><?=number_format($total,2)?></th>
    <th>&nbsp;</th>
</tr>
</table>
<br><br>
<table class="table-1" style="width: 100%">
<tr>
    <td class="table-1 text-left font-italic" style="width: 25%">Prepared by,</td>
    <td class="table-1 text-left font-italic" style="width: 25%">Verified by,</td>
    <td class="table-1 text-left font-italic" style="width: 25%">Authorised by,</td>
</tr>
<tr>
    <td class="table-1">&nbsp;</td>
    <td class="table-1">&nbsp;</td>
    <td class="table-1">&nbsp;</td>    
</tr>
<tr>
    <td class="table-1 text-left border-bottom border-dark"></td>
    <td class="table-1 text-left border-bottom border-dark"></td>
    <td class="table-1 text-left border-bottom border-dark"></td>
</tr>
<tr>
    <td class="table-1 text-left">Name :</td>
    <td class="table-1 text-left">Name :</td>
    <td class="table-1 text-left">Name :</td>
</tr>
<tr>
    <td class="table-1 text-left">Date :</td>
    <td class="table-1 text-left">Date :</td>
    <td class="table-1 text-left">Date :</td>
</tr>
</table>
</body>
<br><br>
<div style="text-align: center;">
	<button type="button" name='print' id="print" class="btn btn-success"  onClick='window.print();window.close();' >Print</button>
</div>

</html>