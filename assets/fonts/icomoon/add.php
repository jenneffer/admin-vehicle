<?php
	include('../assets/config/database.php');
	
	$selcomsql = "SELECT * FROM company ORDER BY compDesc ASC";
	$rselcomsql = mysqli_query($conn_ins_db, $selcomsql);
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Insurance</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include('../lvlCSS.php')?>
    

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    
    <!-- Left Panel -->
	<?php include('../assets/nav/lvlLeftNav.php')?>	
    <!-- Header-->
	<?php include('../assets/nav/lvlRightNav.php')?>
		<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Insurance Section</a></li>
                                    <li class="active">Add New Insurance</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumbs ends here -->

        <div class="content">
            <div class="animated fadeIn">

                <div class="row">
				<!-- form -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>New Insurance</strong> 
                            </div>
                            <div class="card-body card-block">
								<!-- ====================== FORM ACTION ====================== -->
                                <form action="add.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
									<div class="row form-group">
										<div class="col col-md-6"><h3>Insurance Policy</h3></div>
									</div>
									
                                    <div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="selectSm" class=" form-control-label">Select Company <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-4">
                                            <select name="selCom" id="selectSm" class="form-control-sm form-control" required>
												<?php
													while ($row = mysqli_fetch_array($rselcomsql)) {
														$comcode = $row['compCode'];
														$comdesc = $row['compDesc'];
														
														echo"<option value='$comcode'>$comdesc</option>";
													}
												?>
                                            </select>
                                        </div>
                                    </div> <!-- end of select company -->
									<!-- start Correspond Address -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="textarea-input" class=" form-control-label">Correspond Address</label></div>
                                        <div class="col-12 col-md-9"><textarea name="correspondAddress" id="textarea-input" rows="5" placeholder="Address..." class="form-control"></textarea></div>
                                    </div>
									<!-- end Correspond Address -->
<!-- ======================== -->
									<!-- start Classification -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Classification <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-4"><input type="text" id="text-input" name="classification" class="form-control" required><small class="form-text text-muted">eg: FIRE, WATER, BUILDING</small></div>
                                    </div>
									<!-- end Classification -->
<!-- ======================== -->									
									<!-- start Policy No. -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Policy No. <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-4"><input type="text" id="text-input" name="policyNo" class="form-control" required></div>
                                    </div>
									<!-- end Policy No. -->
<!-- ======================== -->
									<!-- start Policy No. -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Period of Insurance <span style="color:red">*</span></label></div>
                                        <div class="col col-md-1" ><label for="text-input" class=" form-control-label" required>From:</label></div>
                                        <div class="col-5 col-md-2" ><input type="date" id="text-input" name="polFrom" class="form-control"></div>
                                        <div class="col col-md-1"><label for="text-input" class=" form-control-label" required>To:</label></div>
                                        <div class="col-5 col-md-2"><input type="date" id="text-input" name="polTo" class="form-control"></div>
                                    </div>
									<!-- end Policy No. -->
<!-- ======================== -->
									<!-- start issuing branch -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Issuing Branch <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-4"><input type="text" id="text-input" name="issueCompany" class="form-control" required><small class="form-text text-muted">eg: KOTA KINABALU, INANAM, TAMPARULI</small></div>
                                    </div>
									<!-- end issuing branch -->
<!-- ======================== -->
									<!-- start Issue Date -->
									<div class="row form-group">
										<!--<div class="col col-md-1"></div> -->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Issuing Date</label></div>
                                        <div class="col-12 col-md-2"><input type="date" id="text-input" name="issueDate" class="form-control"></div>
                                    </div>
									<!-- end Issue Date -->
<!-- ======================== -->
									<!-- start insurance company -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Gross Premium <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-2"><input type="text" id="text-input" name="grossPremium" class="form-control" placeholder="RM " required></div>
                                    </div>
									<!-- end insurance company -->
<!-- ======================== -->
									<!-- start insurance company -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Service Tax <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-2"><input type="text" id="text-input" name="serviceTax" class="form-control" placeholder="RM " required></div>
                                    </div>
									<!-- end insurance company -->
<!-- ======================== -->
									<!-- start insurance company -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Stamp Duty <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-2"><input type="text" id="text-input" name="stampDuty" class="form-control" placeholder="RM "required></div>
                                    </div>
									<!-- end insurance company -->
<!-- ======================== -->
									<div class="row form-group">
										<!--<div class="col col-md-1"></div> -->
                                        <div class="col col-md-2"><label for="file-input" class=" form-control-label">Scanned Hardcopy</label></div>
                                        <div class="col col-md-3"><input type="file" id="file-input" name="softcopy" class="form-control-file"></div>
                                    </div>
									<!-- submit button -->
<!-- ======================== -->
									<!-- start insurance company -->
									<div class="row form-group">
										<!-- <div class="col col-md-1"></div>-->
                                        <div class="col col-md-2"><label for="text-input" class=" form-control-label">Insurance Company <span style="color:red">*</span></label></div>
                                        <div class="col-12 col-md-4"><input type="text" id="text-input" name="insuCompany" class="form-control" required><small class="form-text text-muted">eg: ALLIANZ, AIA, GREAT EASTERN</small></div>
                                    </div>
									<!-- end insurance company -->
<!-- ======================== -->
									
									<div class="row form-group"></div>
									<div class="row form-group">
										<div class="col col-md-4">&nbsp;</div>
										<div class="col col-md-4">
											<button type="submit" class="btn btn-primary col-12" name="submit">Submit</button>
										</div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                &nbsp;
                            </div>
                        </div>
                    </div>
					<!-- End of basic form elements -->

            </div>


        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

<?php include('../footer.php')?>

</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<?php include('../lvlScript.php')?>


</body>
</html>

<?php
	if(isset($_POST['submit'])) {
		echo $poliHoldCompany = $_POST['selCom'];
		echo $corAddress = $_POST['correspondAddress'];
		echo $class = $_POST['classification'];
		echo $policyNumber = $_POST['policyNo'];
		echo $policyFrom = $_POST['polFrom'];
		echo $policyTo = $_POST['polTo'];
		echo $dateIssue = $_POST['issueDate'];
		echo $compIssue = $_POST['issueCompany'];
		echo $insuranceCompany = $_POST['insuCompany'];
		echo $grossPrem = $_POST['grossPremium'];
		echo $serviceTax = $_POST['serviceTax'];
		echo $stampDuty = $_POST['stampDuty'];
		echo "<br>";
		//$scannedHardware = $_POST['softcopy'];
		/*$ = $_POST[''];
		$ = $_POST[''];
		$ = $_POST[''];*/
		
		echo $dateSql = "INSERT INTO `insurance`
								(`ins_insurance_company`, `ins_company`, `ins_correspond_address`, `ins_policy_no`, 
								`ins_class`, `ins_date_start`, `ins_date_end`, `ins_issuing_branch`, `ins_issuing_date`, 
								`ins_gross_premium`, `ins_service_tax`, `ins_stamp_duty`, ) 
								VALUES 
								('$insuranceCompany','$poliHoldCompany','$corAddress','$policyNumber',
								'$class','$policyFrom','$policyTo','$compIssue','$dateIssue', 
								'$grossPrem', '$serviceTax', '$stampDuty')";
		if($rdateSql = mysqli_query($conn_ins_db, $dateSql)) {
			echo"alert('Successfully added')'";
		} else {
			
			echo"alert('NOT Successfully added')'";
		}
	} else {
		
	}


?>
