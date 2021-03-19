<?php
require_once('../assets/config/database.php');
require_once('../check_login.php');
require_once('../function.php');
global $conn_admin_db;
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('01-m-2020');
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date('t-m-2020');
$company_id = isset($_GET['company']) ? $_GET['company'] : "1";

//get the month name and year
$date_explode = explode("-",$date_start);

$selected_month = date('F', mktime(0, 0, 0, $date_explode[1], 10));
$selected_year = $date_explode[2];

$sql_query = "SELECT * FROM vehicle_vehicle vv
INNER JOIN vehicle_roadtax vr ON vv.vv_id = vr.vv_id AND vr.status='1'
INNER JOIN company ON company.id = vv.company_id 
LEFT JOIN vehicle_puspakom vp ON vp.vv_id = vv.vv_id AND vp.status='1' 
LEFT JOIN vehicle_insurance vi ON vi.vv_id = vv.vv_id AND vi.vi_status='1'
WHERE vrt_roadTax_fromDate BETWEEN '".dateFormat($date_start)."' AND '".dateFormat($date_end)."' AND vv.company_id='$company_id'";


$result  = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));

$arr_data = array();
while($row = mysqli_fetch_assoc($result)){

    $arr_data[] = $row;
}

// var_dump($arr_data);

?>

<html>
<title>Roadtax Summary</title>
<?php include('../allCSS1.php')?>
<style>
#footer{
    text-align: right;
    height: 20px;
    position:fixed;
    margin:0px;
    bottom:0px;
    font-size:13px;
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
.table-1 {
    border-collapse:separate;
    border-spacing: 15px;
    /*font-size:14px;*/
}
th, td {
  padding: 10px;
  font-size:13px;
}
</style>
<body>
<div class="staff-claim">
<table class="table-1" style="width: 100%">

<tr>
   <td width="30%" class="text-left"><b>Road Tax Fee For The Month Of <?=$selected_month . " ". $selected_year?></b></td> 
   <td width="30%" class="text-center">&nbsp;</td> 
   <td width="30%" class="text-right"><b>Date &nbsp;:&nbsp;&nbsp; <?=dateFormatRev(date('Y-m-d'))?></b></td> 
</tr>
</table>

<table id="roadtax_summary" class="table-bordered" style="width: 100%">
    <?php 
        $tbody = "";
        $comp_name = itemName("SELECT name FROM company WHERE id='$company_id'");
        
        $tbody .= "<tr><th colspan='11' style='text-align:center;'>".$comp_name."</th></tr>";
        $tbody .= "<tr>
                        	<th rowspan='2'>No.</th>
							<th rowspan='2'>Vehicle No.</th>
                            <th>Use Under</th>
							<th>LPKP Permit</th>
							<th>Fitness Test</th>
							<th colspan='2' style='text-align: center'>Insurance</th>
							<th colspan='4' style='text-align: center'>Road Tax</th>
                        </tr>
                        <tr>
                            <th>Company</th>
							<th>Due Date</th>
							<th>Due Date</th>
							<th>Due</th>
							<th>Status</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Period</th>
                            <th class='sum'>Amount(RM)</th>
                        </tr>";
        $count = 0;
        $total_sum = 0;
        foreach ($arr_data as $value){
            $count++;
            $total_sum += $value['vrt_amount'];
            $grandtotal += $value['vrt_amount'];
            $insurance_status = $value['vi_insuranceStatus'] == 1 ? "Active" : "Inactive";
            $fitness_date = !empty($value['vp_fitnessDate']) ? dateFormatRev($value['vp_fitnessDate']) : '-';
            $lpkp_dueDate = $row['vrt_lpkpPermit_dueDate'] != NULL ? dateFormatRev($row['vrt_lpkpPermit_dueDate']) : "-";
            $ins_due_date = $value['vi_insurance_dueDate'] != NULL ? dateFormatRev($value['vi_insurance_dueDate']) : "-";
            $rt_fromDate = $value['vrt_roadTax_fromDate'] != NULL ? dateFormatRev($value['vrt_roadTax_fromDate']) : "-";
            $rt_dueDate = $value['vrt_roadTax_dueDate'] != NULL ? dateFormatRev($value['vrt_roadTax_dueDate']) : "-";
            $tbody .="<tr>";
            $tbody .="<td>".$count.".</td>";
            $tbody .="<td>".$value['vv_vehicleNo']."</td>";
            $tbody .="<td>".$value['code']."</td>";
            $tbody .="<td>".$lpkp_dueDate."</td>";
            $tbody .="<td>".$fitness_date."</td>";
            $tbody .="<td>".$ins_due_date."</td>";
            $tbody .="<td>".$insurance_status."</td>";
            $tbody .="<td>".$rt_fromDate."</td>";
            $tbody .="<td>".$rt_dueDate."</td>";
            $tbody .="<td>".$value['vrt_roadTax_period']."</td>";
            $tbody .="<td class='text-right'>".number_format($value['vrt_amount'],2)."</td>";
            $tbody .="</tr>";
            
        }
        $tbody .="<tr>";
        $tbody .="<td colspan='10' class='text-right font-weight-bold'>TOTAL (RM)</td>";
        $tbody .="<td class='text-right font-weight-bold'>".number_format($total_sum,2)."</td>";
        $tbody .="</tr>";
    ?>
    
    <tbody> 
     <?=$tbody;?>           
    </tbody>    
</table>
<br>
<table class="table-1" style="width: 100%">
<tr>
    <td class="table-1 text-left" style="width: 20%">Prepared by</td>
    <td class="table-1 text-left" style="width: 20%">Verified by</td>
    <td class="table-1 text-left" style="width: 20%">Authorised By</td>
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
    <td class="table-1 text-left"><?=ucwords($_SESSION['cr_name'])?></td>
    <td class="table-1 text-left">Freddy Jesse Mojinun</td>
    <td class="table-1 text-left">Kong Lih Shan</td>
</tr>

</table>
</div>
<div id="footer">
    Printed on: <?=date("d-m-Y h:i:sa")?> by <?=ucwords($_SESSION['cr_name'])?>
</div>
</body>
<br><br>

<div style="text-align: center;" class="exclude_print">	
	<button type="button" name='print' id="print" class="btn btn-success">Print</button>	
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
        var staff_claim_id = '<?=$staff_claim_id?>';
        if(staff_claim_id !=''){
            $('.checkbox').hide();
        }
    	$('#print').on("click", function(event){
    		window.print();window.close();      
//     		if($('input[type="checkbox"]').prop("checked") == true){       
//         		//save data into database 	
//         		event.preventDefault();
//         		$.ajax({
//         			url:"pcash_voucher.ajax.php",
//         			method:"POST",   
//         			dataType: "json", 
//         			data:{action:'save_staff_claim', str_cv_id:str_cv_id, total_cv:total_cv },
//         			success:function(data){	    
//             			if(data){
//             				window.print();window.close();       
//                 		}else{
// 							alert(data);
//                     	}    												
//         			}
//         		});	
        		
//     		}else if(staff_claim_id !=''){
//     			window.print();window.close();       
//     		}
//     		else{
// 				alert('Please Confirmed before printing!');
//     		}
    	});
    });
</script>     

