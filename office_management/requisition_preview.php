<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;
	
	$rq_id = isset($_GET['rq_id']) ? $_GET['rq_id'] : "";
	$rq_status = isset($_GET['status']) ? $_GET['status'] :"";
	$readonly = $rq_status == 0 ? "" : "readonly";
	$disabled = $rq_status == 0 ? "" : "disabled";
	$query = "SELECT *, (SELECT NAME FROM company WHERE company.id = om_requisition.company_id ) AS company_name, 
            (SELECT cr_name FROM credential WHERE cr_id=om_requisition.user_id) AS prepared_by FROM om_requisition WHERE id='$rq_id'";
	
	$result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
	$row = mysqli_fetch_array($result);
	$company_id = $row['company_id'];
	$recipient = $row['recipient'];
	$username = itemName("SELECT cr_name FROM credential WHERE cr_id='".$row['user_id']."'");
	$serial_no = $row['serial_no'];
	$date = dateFormatRev($row['date']);
	$payment_date = dateFormatRev($row['payment_date']);
	$status = $row['status'];// 0-pending, 1-confirm, 2-rejected/cancelled
	
	//get the particular details
	$particular_query = "SELECT * FROM om_requisition_item WHERE rq_id='$rq_id'";
	$sql_result = mysqli_query($conn_admin_db, $particular_query) or die(mysqli_error($conn_admin_db));
	$particular_data = [];
	while ($row = mysqli_fetch_array($sql_result)){
	    $particular_data[] = $row;
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
                <form id="rq_form">
                    <div class="col-md-12">
                        <div class="card" id="printableArea">
                            <div class="card-header">                            
                                <strong class="card-title">Requisition Preview</strong>
                            </div>     
                            <div class="card-body">
                            <br>                                          
                                <div class="form-group row col-sm-12">
                                	<div class="col-sm-4">
                                        <label for="item" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                                        <div>
                                            <?php
                                            $company = mysqli_query ( $conn_admin_db, "SELECT id, name FROM company");
                                            db_select ($company, 'company_id', $company_id,'','-select-','form-control form-control-sm', '', $disabled);
                                        ?>
                                    </div>
                                    </div>
                                    <div class="col-sm-4">
                                    	<label for="to" class=" form-control-label"><small class="form-text text-muted">To</small></label>
                                        <input type="text" id="to" name="to" value="<?=$recipient;?>" class="form-control form-control-sm" <?=$readonly?>>
                                    </div>
                                    <div class="col-sm-4">
                                    	<label for="prepared_by" class=" form-control-label"><small class="form-text text-muted">Prepared by</small></label>
                                    	<input type="text" id="prepared_by" name="prepared_by" value="<?=strtoupper($username);?>" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">                                	
                                    <div class="col-sm-4">
                                    	<label for="serial_no" class=" form-control-label"><small class="form-text text-muted">Serial No.</small></label>
                                        <input type="text" id="serial_no" name="serial_no" value="<?=$serial_no;?>" class="form-control form-control-sm" <?=$readonly?>>
                                    </div>
                                	<div class="col-sm-4">
                                        <label for="date" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                                        <div class="input-group">
                                            <input id="date" name="date" class="form-control form-control-sm" value="<?=$date?>" autocomplete="off" <?=$disabled?>>                                           
                                        </div>   
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="paid_date" class=" form-control-label"><small class="form-text text-muted">Required to be paid on</small></label>
                                        <div class="input-group">
                                            <input id="paid_date" name="paid_date" class="form-control form-control-sm" value="<?=$payment_date?>" autocomplete="off" <?=$disabled?>>                                            
                                        </div>   
                                    </div>
                                </div>      
                            	<hr>
                            	<h5><b>Expenses Particular</b></h5>
                            	<br> 
                            	<div>     
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th scope="col" width='10%' class="text-center">No.</th>
                                            <th scope="col" width='50%' class="text-center">Particular</th>
                                            <th scope="col" width='20%' class="text-right">Total (RM)</th>
                                            <th scope="col" width='20%' class="text-center">Remark</th>
                                        </tr>
                                        <?php 
                                        $counter = 0;
                                        foreach ($particular_data as $data){
                                        $counter++;?>                               
                                        <tr>
                                            <td class="text-center"><?=$counter?></td>
                                            <td><input name='particular[]' size="80" class="form-control-sm hideBorder" value="<?=$data['particular']?>" <?=$readonly?>></td>
                                            <td><input name='total[]' size="20" class="form-control-sm hideBorder text-right" value="<?=number_format($data['total'],2)?>" <?=$readonly?>></td>
                                            <td><input name='remark[]' size="20" class="form-control-sm hideBorder" value="<?=$data['remark']?>" <?=$readonly?>></td>
                                        </tr> 
                                        <?php }?>                                                                     
                                    </table>
                                </div>                                                                                                            
                          	 
                           	</div> 
                            <!-- button save -->
                           	<div class="col-sm-12" style="text-align: center">
                           	<?php if($status == 0){?>
                           		<button type="button" class="btn btn btn-success button_confirm">Confirm</button>
                           		<button type="button" class="btn btn-primary button_cancel">Cancel</button>                           		
                           		<button type="button" class="btn btn-secondary button_close">Close</button>
                           	<?php }elseif ($status == 1){?>
                           		<button type="button" class="btn btn-primary button_print">Print Preview</button>
                           		<button type="button" class="btn btn-secondary button_close">Close</button>
                           	<?php }else{?>
                           		<button type="button" class="btn btn-secondary button_close">Close</button>
                           	<?php }?>
                           	</div>
                           	<br>                      
                        </div>
                    </div>
                    </form>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
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

        $('#rq_form').on("submit", function(e){ 
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

        $('.button_confirm').on("click", function(event){
            event.preventDefault();
            $.ajax({  
                url:"requisition.ajax.php",  
                method:"POST",                        
                data:{action:'confirm_request',id: '<?=$rq_id?>'},  
                success:function(data){   
                    console.log(data);
                    location.reload();                     
                }  
           });
        });
        
        $('.button_close').on("click", function(event){
        	event.preventDefault();  
        	window.close();
        });
        
        $('.button_print').on("click", function(event){
            var rq_id = '<?=$rq_id?>';
            event.preventDefault();
            window.open("requisition_form_print.php?rq_id="+rq_id,"mywindow","width=1000,height=650");
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
            else{  
                 $.ajax({  
                      url:"requisition.ajax.php",  
                      method:"POST",                        
                      data:{action:'add_new_request', data: $('#rq_form').serialize(), rq_item: RQ_ITEM_LIST},  
                      success:function(data){   
                          console.log(data);
                          var rq_id = data.rq_id;
                          console.log(rq_id);
                           $('#editItem').modal('hide');                             
                           location.reload();                             
                      }  
                 });  
            }
        });
        
        $('#paid_date, #date').datepicker({
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
