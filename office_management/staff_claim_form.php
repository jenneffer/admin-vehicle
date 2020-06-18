<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : "";
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] :"";
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] :"";
$company_name = itemName("SELECT name FROM company WHERE id='$company_id'");
$position = itemName("SELECT cr_position FROM credential WHERE cr_id='".$_SESSION['cr_id']."'");

//get cv_id
$str_cv_id = isset($_GET['cv_id']) ? $_GET['cv_id'] : "";
$arr_cv_id = [];
if(!empty($str_cv_id)){
    $arr_cv_id = explode(",", $str_cv_id);
}

$cv_id = implode("','", $arr_cv_id);

$query = "SELECT * FROM om_pcash_voucher 
            INNER JOIN om_pcash_voucher_item ON om_pcash_voucher_item.cv_id = om_pcash_voucher.id
            WHERE cv_date BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND company_id='$company_id' 
            AND om_pcash_voucher.id IN ('".$cv_id."')";

$result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
$cv_item_data = [];
while ($row = mysqli_fetch_assoc($result)){
    $cv_item_data[] = $row;
}

?>

<html>
<title>STAFF CLAIM FORM - CF 1</title>
<?php include('../allCSS1.php')?>
<style>
.table-1 {
    border-collapse:separate;
    border-spacing: 15px;
    /*font-size:14px;*/
}
.table-content {
    border: 1px solid black;
    border-collapse:collapse;
    padding:5px;
/*     margin-left:10px; */
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
    .exclude_print{
        display:none;
    }
}   
</style>
<body>
<div class="staff-claim">
<table class="table-1" style="width: 100%">
<tr>
	<th class="table-1" colspan="3" style="text-align:center; font-size:18px"><?=$company_name?><br>
	<span class="table-1" style="text-align:center; font-size:16px;">STAFF CLAIM FORM - CF 1</span></th>	
</tr>

<tr>
   <td width="30%" class="text-left"><b>Name &nbsp;:&nbsp;&nbsp; <?=ucwords($_SESSION['cr_name'])?></b></td> 
   <td width="30%" class="text-center"><b>Position &nbsp;:&nbsp;&nbsp; <?=ucwords($position)?></b></td> 
   <td width="30%" class="text-right"><b>Date &nbsp;:&nbsp;&nbsp; <?=date('d-m-Y')?></b></td> 
</tr>
</table>
<br>
<table class="table-content" style="width: 100%">
<tr>    
    <th class="table-content text-center" width="10%">Date</th>
    <th class="table-content text-center" width="10%">Ref#</th>
    <th class="table-content text-center" width="50%">Detail of Expenses</th>
    <th class="table-content text-right" width="20%">Amount (RM)</th>
    
</tr>
<?php 
    $counter = 0;
    $total = 0;
    foreach ($cv_item_data as $data){
        $counter++;
        $total += $data['amount'];
    ?>  
    <tr>        
        <td class="table-content text-center"><?=dateFormatRev($data['item_date'])?></td>
        <td class="table-content">&nbsp;</td>
        <td class="table-content text-center">&nbsp;<?=ucfirst($data['particular'])?></td>
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
    <th class="table-content" colspan="3" style='text-align: right;'>TOTAL</th>
    <th class="table-content" style='text-align: right;'><?=number_format($total,2)?></th>
</tr>
</table>
<br><br>
<table class="table-1" style="width: 100%">
<tr>
    <td class="table-1 text-left" style="width: 20%">Prepared by</td>
    <td class="table-1 text-left" style="width: 20%">Checked & Verified by</td>
    <td class="table-1 text-left" style="width: 20%">Authorised by</td>
    <td class="table-1 text-left" style="width: 20%">Verified by</td>
    <td class="table-1 text-left" style="width: 20%">Authorised By</td>
</tr>
<tr>
    <td class="table-1">&nbsp;</td>
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
    <td class="table-1 text-left border-bottom border-dark"></td>
</tr>
<tr>
    <td class="table-1 text-left"><?=ucwords($_SESSION['cr_name'])?></td>
    <td class="table-1 text-left">Opn Executive/Manager</td>
    <td class="table-1 text-left">Head of Department</td>
    <td class="table-1 text-left">A/c Spvr./Exec</td>
    <td class="table-1 text-left">Accountant/Directors</td>
</tr>
<tr>
    <td class="table-1 text-left">Date : <?=date('d-m-Y')?></td>
    <td class="table-1 text-left">Date :</td>
    <td class="table-1 text-left">Date :</td>
    <td class="table-1 text-left">Date :</td>
    <td class="table-1 text-left">Date :</td>
</tr>
</table>
</div>
</body>
<br><br>
<div style="text-align: center;" class="exclude_print">	
	<button type="button" name='print' id="print" class="btn btn-success">Print</button>	
	<input type="checkbox" name="confirm" value="">&nbsp;&nbsp;Confirm?
</div>
</html>
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
    $(document).ready(function() {
        var str_cv_id = '<?=$str_cv_id?>'; //string of cv_id
        var total_cv = '<?=$total?>'; //total of cv
    	$('#print').on("click", function(event){
    		if($('input[type="checkbox"]').prop("checked") == true){       
        		//save data into database 	
        		event.preventDefault();
        		$.ajax({
        			url:"pcash_voucher.ajax.php",
        			method:"POST",   
        			dataType: "json", 
        			data:{action:'save_staff_claim', str_cv_id:str_cv_id, total_cv:total_cv },
        			success:function(data){	    
            			if(data){
            				window.print();window.close();       
                		}else{
							alert(data);
                    	}    												
        			}
        		});	
        		
    		}
    		else{
				alert('Please Confirmed before printing!');
    		}
    	});
    });
</script>     
