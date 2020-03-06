<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;

	$company = isset($_GET['company']) ? $_GET['company'] : "";
	
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
   @media print{
   @page {size: landscape}
       .button_search{
            display:none
       }
   }
   </style>
</head>

<body>
<div class="card-body">
	<div class="col-sm-12" style="text-align: center;">                                    	
    	<button type="button" class="btn btn-primary button_search" onClick="window.print();window.close();">Print</button>
    </div>
    <br>
    <table id="vehicle_table" border="1" style="border-collapse:collapse;text-align:center;width:100%;">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
				<th rowspan="2">Reg No.</th>
                <th rowspan="2">Company</th>
                <th rowspan="2">Category</th>
				<th rowspan="2">Make</th>
				<th rowspan="2">Model</th>
				<th rowspan="2">Engine No.</th>
				<th rowspan="2">Chasis No.</th>
				<th rowspan="2">B.D.M/B.G.K</th>
				<th rowspan="2">B.T.M</th>
				<th rowspan="2">Goods Capacity</th>
				<th rowspan="2">Year Made</th>
				<th rowspan="2">Finance</th>		
				<th colspan="4" style="text-align: center;">LPKP Permit</th>
				<th rowspan="2">Remarks</th>
            </tr>
            <tr>
            	<th>Type</th>
            	<th>No.</th>
            	<th>License Ref No.</th>
            	<th>Due Date</th>
            </tr>
        </thead>
        <tbody>

        <?php 
            $sql_query = "SELECT vv.vv_id,vv_vehicleNo,code,vv_category,vv_brand,vv_model,vv_engine_no,vv_chasis_no,vv_bdm,
                        vv_btm,vv_capacity,vv_yearMade,vv_finance,vpr_type, vpr_no,vpr_license_ref_no,vpr_due_date, 
                        vv_remark FROM vehicle_vehicle vv
                        INNER JOIN company ON company.id = vv.company_id 
                        LEFT JOIN vehicle_permit vp ON vp.vv_id = vv.vv_id
                        WHERE vv.status='1'"; //only show active vehicle 
            
            if (!empty($company)) {
                $sql_query .= " AND company.id='$company'";
            }
            
            if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                $count = 0;
                $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                    while($row = mysqli_fetch_array($sql_result)){ 
                        $count++;
                        $category = itemName("SELECT vc_type FROM vehicle_category WHERE vc_id='".$row['vv_category']."'");
                        ?>
                        <tr>
                            <td><?=$count?>.</td>
                            <td><?=$row['vv_vehicleNo']?></td>
                            <td><?=$row['code']?></td>
                            <td><?=$category?></td>
                            <td><?=$row['vv_brand']?></td>
                            <td><?=$row['vv_model']?></td>
                            <td><?=$row['vv_engine_no']?></td>
                            <td><?=$row['vv_chasis_no']?></td>
                            <td><?=$row['vv_bdm']?></td>
                            <td><?=$row['vv_btm']?></td>
                            <td><?=$row['vv_capacity']?></td>
                            <td><?=$row['vv_yearMade']?></td>
                            <td><?=$row['vv_finance']?></td>
                            <td><?=$row['vpr_type']?></td>
                            <td><?=$row['vpr_no']?></td>
                            <td><?=$row['vpr_license_ref_no']?></td>
                            <td><?=$row['vpr_due_date']?></td>
                            <td><?=$row['vv_remark']?></td>                            
                        </tr>
        <?php
                    }
                }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
