<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;
// 	if(isset($_SESSION['cr_id'])) {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$query = parse_url($url, PHP_URL_QUERY);
// 		parse_str($query, $params);
		
// 		// get id
// 		$userId = $_SESSION['cr_id'];
// 		$name = $_SESSION['cr_name'];
		
// 	} else {
// 		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// 		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		$PrevURL= $url;
// 		header("Location: ../login.php?RecLock=".$PrevURL);
//     }
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
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
        
        .select2-selection__rendered {
          margin: 5px;
        }
        .select2-selection__arrow {
          margin: 5px;
        }
        .button_add{
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
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Setup Account</strong>
                            </div>
                            <form id="add_new_account" role="form" action="" method="post">
                                <div class="card-body card-block ">
                                    <div class="form-group row col-sm-12">
                                        <div class="col-sm-4">
                                            <label class="control-label "><small class="form-text text-muted">Bill Type</small></label>                                  
                                            <?php
                                                $bill_type = mysqli_query ( $conn_admin_db, "SELECT id, name FROM bill_billtype");
                                                db_select ($bill_type, 'bill_type', '','','-select-','form-control','');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label "><small class="form-text text-muted">Company</small></label>                                  
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                                                db_select ($company, 'company', '','','-select-','form-control','');
                                            ?>
                                        </div>   
                                        <div class="col-sm-4" id="acc_no">
                                            <label for="acc_no" class=" form-control-label"><small class="form-text text-muted">Account No.</small></label>
                                            <input type="text" id="acc_no" name="acc_no" placeholder="Enter Account number" class="form-control">
                                        </div>                                
                                    </div>
                                    <div class="form-group row col-sm-12">
                                       <div class="col-sm-4" id="location">
                                            <label class="control-label"><small class="form-text text-muted">Location</small></label>
                                            <textarea id="location" name="location" placeholder="Enter location" class="form-control"></textarea>
                                        </div> 
                                        <div class="col-sm-4" id="deposit">
                                            <label for="deposit" class=" form-control-label"><small class="form-text text-muted">Deposit (RM)</small></label>
                                            <input type="text" id="deposit" name="deposit" placeholder="Enter deposit amount" class="form-control">
                                        </div>
                                        <div class="col-sm-4" id="tariff">
                                            <label for="tariff" class=" form-control-label"><small class="form-text text-muted">Tariff</small></label>
                                            <input type="text" id="tariff" name="tariff" placeholder="Enter tariff" class="form-control">
                                        </div>                                                                            
                                    </div>
                                    <div class="form-group row col-sm-12">
                                    	<div class="col-sm-4" id="owner">
                                            <label for="owner" class=" form-control-label"><small class="form-text text-muted">Owner</small></label>
                                            <input type="text" id="owner" name="owner" class="form-control">
                                        </div>
                                        <div class="col-sm-4" id="reference">
                                            <label for="reference" class=" form-control-label"><small class="form-text text-muted">Reference</small></label>
                                            <input type="text" id="reference" name="reference" class="form-control">
                                        </div>
                                    </div>    
                                    
                                    <div id="4" class="billing">
                                    	<div class="form-group row col-sm-12">
                                    		<div class="col-sm-4">
                                                <label for="position" class=" form-control-label"><small class="form-text text-muted">Position/Department</small></label>
                                                <input type="text" id="position" name="position" class="form-control">
                                        	</div>
                                        	<div class="col-sm-4">
                                                <label for="user" class=" form-control-label"><small class="form-text text-muted">User</small></label>
                                                <input type="text" id="user" name="user" class="form-control">
                                        	</div>
                                        	<div class="col-sm-4">
                                                <label for="hp_no" class=" form-control-label"><small class="form-text text-muted">Telephone No.</small></label>
                                                <input type="text" id="hp_no" name="hp_no" class="form-control">
                                        	</div>
                                    	</div>      
                                    	<div class="form-group row col-sm-12">
                                    		<div class="col-sm-4">
                                                <label for="celcom_limit" class=" form-control-label"><small class="form-text text-muted">Celcom Limit</small></label>
                                                <input type="text" id="celcom_limit" name="celcom_limit" class="form-control">
                                        	</div>
                                        	<div class="col-sm-4">
                                                <label for="package" class=" form-control-label"><small class="form-text text-muted">Package</small></label>
                                                <input type="text" id="package" name="package" class="form-control">
                                        	</div>
                                        	<div class="col-sm-4">
                                                <label for="latest_package" class=" form-control-label"><small class="form-text text-muted">Latest Package</small></label>
                                                <input type="text" id="latest_package" name="latest_package" class="form-control">
                                        	</div>
                                    	</div>    
                                    	<div class="form-group row col-sm-12">
                                    		<div class="col-sm-4">
                                                <label for="limit_rm" class=" form-control-label"><small class="form-text text-muted">Limit (RM)</small></label>
                                                <input type="text" id="limit_rm" name="limit_rm" class="form-control">
                                        	</div>
                                        	<div class="col-sm-4">
                                                <label for="data" class=" form-control-label"><small class="form-text text-muted">Data</small></label>
                                                <input type="text" id="data" name="data" class="form-control">
                                        	</div>
                                        	<div class="col-sm-4">
                                                <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                                                <input type="text" id="remark" name="remark" class="form-control">
                                        	</div>
                                    	</div>                                      	                             
                                    </div>                                
									<div class="form-group row col-sm-12">
                                		<div class="col-sm-4" id="serial_no">
                                            <label for="serial_no" class=" form-control-label"><small class="form-text text-muted">Serial No.</small></label>
                                            <input type="text" id="serial_no" name="serial_no" class="form-control">
                                    	</div>
                                    	<div class="col-sm-4" id="owner_ref">
                                            <label for="owner_ref" class=" form-control-label"><small class="form-text text-muted">Owner Ref</small></label>
                                            <input type="text" id="owner_ref" name="owner_ref" class="form-control">
                                    	</div>
                                    	<div class="col-sm-4" id="owner_ref">
                                            <label for="unit_no" class=" form-control-label"><small class="form-text text-muted">Unit No.</small></label>
                                            <input type="text" id="unit_no" name="unit_no" class="form-control">
                                    	</div>
                                	</div>   
                                	<div class="form-group row col-sm-12">
                                		<div class="col-sm-4" id="property_type">
                                            <label for="property_type" class=" form-control-label"><small class="form-text text-muted">Property Type</small></label>
                                            <select name="property_type" id="property_type" class="form-control">
                                            	<option value="">- Select -</option>
                                            	<option value="1">Shop Lot</option>
                                            	<option value="2">House</option>
                                            </select>
                                    	</div>
                                	</div>                                                                                                 
                                    <div class="card-body">
                                        <button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                                        <button type="button" id="cancel" name="cancel" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>
        </div>
        <div>
        </div>
        <!-- Modal   -->
        <div id="add_phone" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Telephone List</h4>
                </div>
                <div class="modal-body">
                    <form id="telefon_bill">        
                        <div class="row form-group col-sm-12">
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Telephone No.</small></label>
                                <input type="text" name="telefon" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Type</small></label>
                                <input type="text" name="type" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label><small class="form-text text-muted">Usage (RM)</small></label>
                                <input type="text" name="usage" class="form-control">
                            </div>  
                            <div class="col-sm-1">
                            	<button type="submit" class="btn btn-success button_add">Add</button>                            	
                            </div> 
                            <div class="col-sm-1">
                            	<button type="button" data-dismiss="modal" class="btn btn-secondary button_add">Cancel</button>
                            </div>                         
                        </div>                                                                             
                  	</form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    <script src="../assets/js/select2.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function() {
        //declare empty array to temporary save the data in table
        var TELEPHONE_LIST = [];
        
    	$('.billing').hide();  
    	$('#owner_ref, #serial_no, #owner, #reference, #property_type').hide();  	
    	$('#bill_type').change(function(){
    		$('.billing').hide();
			$('#'+$(this).val()).show();
			if($(this).val() == 1){
				$('#location, #deposit, #tariff, #acc_no').show();
				$('#owner,#serial_no,#owner_ref,#reference,#property_type').hide();
			}
			else if($(this).val() == 2){
				$('#location, #deposit, #owner').show();
				$('#tariff, #reference,#property_type').hide();
			}
			else if($(this).val() == 3){
				$('#location, #reference').show();
				$('#owner, #deposit, #tariff,#property_type').hide();
			}
			else if($(this).val() == 4){
				$('#location, #deposit, #tariff, #reference, #serial_no,#property_type').hide();
				$('#acc_no').show();
			}
			else if($(this).val() == 5){
				$('#serial_no, #location').show();
				$('#deposit, #tariff, #acc_no,#owner_ref, #reference,#property_type').hide();
			}
			else if($(this).val() == 6){
				$('#owner_ref, #location, #property_type').show();		
				$('#deposit, #tariff, #acc_no, #serial_no').hide();		
			}

        });

        $('#telefon_bill').on("submit", function(e){ 
            e.preventDefault();
            var telefon = $("input[name='telefon']").val();
            var type = $("input[name='type']").val();
         	var usage = $("input[name='usage']").val();
         	
            $(".data-table tbody").append("<tr data-telefon='"+telefon+"' data-type='"+type+"' data-usage='"+usage+"'><td>"+telefon+"</td><td>"+type+"</td><td>"+usage+"</td><td><button class='btn btn-info btn-xs btn-edit'>Edit</button><button class='btn btn-danger btn-xs btn-delete'>Delete</button></td></tr>");

            //push data into array
            TELEPHONE_LIST.push({
				telefon: telefon,
				type: type,
				usage: usage
            });
            console.log(TELEPHONE_LIST);
            $("input[name='telefon']").val('');
            $("input[name='type']").val('');
            $("input[name='usage']").val('');
        });
    	
        $('#add_new_account').on("submit", function(event){  
            event.preventDefault();     
            console.log(TELEPHONE_LIST);         
            $.ajax({  
                url:"account_setup.ajax.php",  
                method:"POST",  
                data:{action:'add_new_account', data : $('#add_new_account').serialize()},  
                success:function(data){ 
                    location.reload();                                                        	 
                }  
           });    
        });

        $('#from_date, #to_date, #paid_date, #due_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "top left",
            todayHighlight: true
        });
        
    });

    function isNumberKey(evt){
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	if (charCode != 46 && charCode > 31 
    	&& (charCode < 48 || charCode > 57))
    	return false;
    	return true;
    }  
    
    function isNumericKey(evt){
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	if (charCode != 46 && charCode > 31 
    	&& (charCode < 48 || charCode > 57))
    	return true;
    	return false;
    } 

  </script>
</body>
<style>
.table{
    font-size:14px;
}
</style>
</html>
