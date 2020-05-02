<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
    global $conn_admin_db;
    
    $cv_id = $_GET['cv_id'];
    $query = "SELECT *, (SELECT NAME FROM company WHERE company.id = om_pcash_voucher.company_id ) AS company_name,
            (SELECT cr_name FROM credential WHERE cr_id=om_pcash_voucher.user_id) AS prepared_by FROM om_pcash_voucher WHERE id='$cv_id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    $row = mysqli_fetch_array($result);
    $company_name = $row['company_name'];
    $recipient = $row['recipient'];
    $prepared_by = $row['prepared_by'];
    $cv_no = $row['cv_no'];
    $date = dateFormatRev($row['cv_date']);
    $status = $row['workflow_status'];// 0-pending, 1-confirm, 2-rejected/cancelled
    
    //get the particular details
    $particular_query = "SELECT * FROM om_pcash_voucher_item WHERE cv_id='$cv_id'";
    $sql_result = mysqli_query($conn_admin_db, $particular_query) or die(mysqli_error($conn_admin_db));
    $particular_data = [];
    while ($row = mysqli_fetch_array($sql_result)){
        $particular_data[] = $row;
    }
?>

<html>
<title>PETTY CASH VOUCHER</title>
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
	<th class="table-1" colspan="6" style="text-align:center; font-size:18px"><?=$company_name?><br>
	<span class="table-1" style="text-align:center; font-size:16px;">PETTY CASH VOUCHER</span></th>	
</tr>
<tr><td colspan="6">&nbsp;</td></tr>
<!-- <tr><td colspan="6">&nbsp;</td></tr> -->
<tr>
    <td class="table-1">Pay to</td>
    <td>: &nbsp;<?=$recipient?></td>
    <td class="table-1">Voucher No.</td>
    <td class="table-1">: &nbsp;<?=strtoupper($cv_no)?></td>
    <td class="table-1">Date</td>
    <td class="table-1">: &nbsp;<?=$date?></td>
</tr>
</table>
<br>
<table class="table-content" style="width: 100%">
<tr>
    <th class="table-content text-center" width="10%">No.</th>
    <th class="table-content text-center" width="20%">Date</th>
    <th class="table-content text-center" width="50%">Descriptions</th>
    <th class="table-content text-right" width="20%">Amt (RM)</th>
    
</tr>
<?php 
    $counter = 0;
    $total = 0;
    foreach ($particular_data as $data){
    $counter++;
    $total += $data['amount'];
    ?>  
    <tr>
        <td class="table-content" style="text-align: center"><?=$counter?>.</td>
        <td class="table-content text-center"><?=dateFormatRev($data['item_date'])?></td>
        <td class="table-content text-center">&nbsp;<?=$data['particular']?></td>
        <td style='text-align: right;' class="table-content"><?=number_format($data['amount'],2)?></td>
        
    </tr>
<?php }?>    
<tr>
    <td class="table-content">&nbsp;</td>
    <td class="table-content">&nbsp;</td>
    <td class="table-content">&nbsp;</td>
    <td class="table-content">&nbsp;</td>
</tr>
<tr>
    <th class="table-content">&nbsp;</th>
    <th class="table-content">&nbsp;</th>
    <th class="table-content" style='text-align: right;'>Total</th>
    <th class="table-content" style='text-align: right;'><?=number_format($total,2)?></th>
</tr>
</table>
<br><br>
<table class="table-1" style="width: 100%">
<tr>
    <td class="table-1 text-left" style="width: 25%">Prepared by</td>
    <td class="table-1 text-left" style="width: 25%">Authorised by</td>
    <td class="table-1 text-left" style="width: 25%">Cashier</td>
    <td class="table-1 text-left" style="width: 25%">Received By</td>
</tr>
<tr>
    <td class="table-1">&nbsp;</td>
    <td class="table-1">&nbsp;</td>
    <td class="table-1">&nbsp;</td>
    <td class="table-1">&nbsp;</td>
</tr>
<tr>
    <td class="table-1 text-left border-bottom border-dark"></td>
    <td class="table-1 text-left border-bottom border-dark"></td>
    <td class="table-1 text-left border-bottom border-dark"></td>
    <td class="table-1 text-left border-bottom border-dark"></td>
</tr>
<tr>
    <td class="table-1 text-left">Name :</td>
    <td class="table-1 text-left">Name :</td>
    <td class="table-1 text-left">Name :</td>
    <td class="table-1 text-left">Name :</td>
</tr>
<tr>
    <td class="table-1 text-left">Date :</td>
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