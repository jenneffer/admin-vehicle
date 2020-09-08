<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;
	
	$username = itemName("SELECT cr_name FROM credential WHERE cr_id='".$_SESSION['cr_id']."'");
	$company_id = isset($_GET['company_id']) ? $_GET['company_id'] : "";
	$company_name = itemName("SELECT name FROM company WHERE id='".$company_id."'");
	$total = isset($_GET['amount']) ? $_GET['amount'] : 0;
	$staff_claim_id = isset($_GET['staff_claim_id']) ? $_GET['staff_claim_id'] : "";
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
                    	<form id="rq_form" method="POST" action="add_requisition.php">
                    	<input type="hidden" name="company_id" value="<?=$company_id?>"/>
                    	<input type="hidden" name="staff_claim_id" value="<?=$staff_claim_id?>"/>
                        <div class="card" id="printableArea">     
                           <div class="card-body"> 
                           		<div class="text-center">
                           			<span style="font-size: 18px;"><b><?=$company_name?></b></span><br>
                           			<span style="font-size: 16px;"><b>PAYMENT REQUISITION FORM</b></span>
                           		</div>  
                           		<br>               
<!--                            		<div class="form-group row col-sm-12"> -->
<!--                            			<div class="col-sm-6"> -->
<!--                            				<label for="company" class=" form-control-label"><small class="form-text text-muted">Company</small></label> -->
                           				<?php
//                                             $company = mysqli_query ( $conn_admin_db, "SELECT id, name FROM company");
//                                             db_select ($company, 'company_id', '','','-select-','form-control','');
//                                         ?>
<!--                            			</div>                                     -->
<!--                                 </div>  -->
                                <div class="form-group row col-sm-12">
                                    <div class="col-sm-3">
                                        <label for="recipient" class=" form-control-label"><small class="form-text text-muted">To <span class="color-red">*</span></small></label>
                                        <input type="text" id="recipient" name="recipient" placeholder="Recipient" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="ncd" class=" form-control-label"><small class="form-text text-muted">Serial No. <span class="color-red">*</span></small></label>
                                        <input type="text" id="serial_no" name="serial_no" placeholder="Serial number" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-sm-3">
                                		<label for="date" class=" form-control-label"><small class="form-text text-muted">Date <span class="color-red">*</span></small></label>
                                		<div class="input-group">
                                        	<input id="date" name="date" class="form-control form-control-sm" value="<?=date('d-m-Y')?>" autocomplete="off">                                        	
                                    	</div>
                                	</div>
                                	<div class="col-sm-3">
                                		<label for="payment_date" class=" form-control-label"><small class="form-text text-muted">Payment Date <span class="color-red">*</span></small></label>
                                		<div class="input-group">
                                        	<input id="payment_date" name="payment_date" class="form-control form-control-sm" autocomplete="off">
                                    	</div>
                                	</div>
                                </div>       
                                <br>                        	   
                                <div>     
                                    <table class="table table-striped table-bordered">
                                    <tr>
                                        <th scope="col" width='10%' class="text-center">No.</th>
                                        <th scope="col" width='50%' class="text-center">Particular</th>
                                        <th scope="col" width='20%' class="text-right">Total (RM)</th>
                                        <th scope="col" width='20%' class="text-center">Remark</th>
                                    </tr>                                    
                                    <tr>
                                        <td class="text-center">1.</td>
                                        <td>                                              
                                             <input name='particular[]' size="80" value="Expenses for Admin department" class="form-control-sm hideBorder">
                                        </td>
                                        <td> 
                                             <input name='total[]' size="30" value="<?=number_format($total,2)?>" class="form-control-sm hideBorder text-right">
                                        </td>
                                        <td> 
                                             <input name='remark[]' size="30" class="form-control-sm hideBorder">
                                        </td>
                                    </tr>
<!--                                     <tr> -->
<!--                                         <td class="text-center">2.</td> -->
<!--                                         <td>  -->
<!--                                              <input name='particular[]' size="80" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                         <td>  -->
<!--                                              <input name='total[]' size="20" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                         <td>  -->
<!--                                              <input name='remark[]' size="20" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                     </tr>  -->
<!--                                     <tr> -->
<!--                                         <td class="text-center">3.</td> -->
<!--                                         <td>  -->
<!--                                              <input name='particular[]' size="80" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                         <td>  -->
<!--                                              <input name='total[]' size="20" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                         <td>  -->
<!--                                              <input name='remark[]' size="20" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                     </tr> -->
<!--                                     <tr> -->
<!--                                         <td class="text-center">4.</td> -->
<!--                                         <td>  -->
<!--                                              <input name='particular[]' size="80" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                         <td>  -->
<!--                                              <input name='total[]' size="20" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                         <td>  -->
<!--                                              <input name='remark[]' size="20" class="form-control-sm hideBorder"> -->
<!--                                         </td> -->
<!--                                     </tr> -->
                                    <tr>                                    
                                    </table>
                                </div>                                              
                                <div style="text-align: center;">
                        			<button type="submit" name="btn_save" class="btn btn-primary">Save</button>
                        			<button type="button" name="btn_reset" class="btn btn-secondary">Reset</button>
                        		</div>
                        	</div>                        	
                    	</div>
                    	</form>
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
    $(document).ready(function() {
    	var RQ_ITEM_LIST = [];
    	// Initialize select2
//     	var select2 = $("#item").select2({
//     		placeholder: "select option",
//     	    selectOnClose: true
//         });
//     	select2.data('select2').$selection.css('height', '38px');
//     	select2.data('select2').$selection.css('border', '1px solid #ced4da');
        
        $('#item-data-table').DataTable({
        	"columnDefs": [
//         	    { "width": "10%", "targets": 0 },
//         	    { "width": "80%", "targets": 1 },
//         	    { "width": "10%", "targets": 2 }
        	  ]
  	  	});

        $('.save_particular').on("click", function(e){ 
            e.preventDefault();
            var particular = $("input[name='particular']").val();
            var total = $("input[name='total']").val();
         	var remark = $("input[name='remark']").val();
         	
            $(".data-table tbody").append("<tr data-particular='"+particular+"' data-total='"+total+"' data-remark='"+remark+"'><td>"+particular+"</td><td>"+total+"</td><td>"+remark+"</td><td style='text-align:center'><i class='fa fa-edit' style='color:#33b5e5'></i>&nbsp;&nbsp;<i class='fas fa-trash-alt' style='color:red'></i></td></tr>");

            //push data into array
            RQ_ITEM_LIST.push({
				particular: particular,
				total: total,
				remark: remark
            });
            console.log(RQ_ITEM_LIST);
            $("input[name='particular']").val('');
            $("input[name='total']").val('');
            $("input[name='remark']").val('');
        });

        $('.button_reset').on("click", function(event){
        	event.preventDefault();  
        	$("input[name='particular']").val('');
            $("input[name='total']").val('');
            $("input[name='remark']").val('');
        });

        $('.button_save').on("click", function(event){ 
        	event.preventDefault(); 
            if($('#company_id').val() == ""){  
                alert("Company is required");  
            }  
            else if($('#to').val() == ""){  
                alert("Recipient is required");  
            } 
            else if($('#date').val() == ""){  
                alert("Date is required");  
            } 
            else if($('#paid_date').val() == ""){  
                alert("Payment date is required");  
            }      
//             else{  
//                  $.ajax({  
//                       url:"requisition.ajax.php",  
//                       method:"POST",                        
//                       data:{action:'add_new_request', data: $('#rq_form').serialize(), rq_item: RQ_ITEM_LIST},  
//                       success:function(data){   
//                           console.log(data);
//                           var rq_id = data.rq_id;
//                           console.log(rq_id);
//                            $('#editItem').modal('hide');                             
//                            location.reload();                             
//                       }  
//                  });  
//             }
        });
        
        $('#payment_date, #date').datepicker({
              format: "dd-mm-yyyy",
              autoclose: true,
              orientation: "top left",
              todayHighlight: true
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
    });
  </script>
</body>
</html>
