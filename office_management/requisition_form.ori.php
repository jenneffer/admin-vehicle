<?php
	require_once('../assets/config/database.php');
	require_once('../function.php');	
	require_once('../check_login.php');
	global $conn_admin_db;
	
	$username = itemName("SELECT cr_name FROM credential WHERE cr_id='".$_SESSION['cr_id']."'");

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
                                <strong class="card-title">Payment Requisition Form</strong>
                            </div>     
                           <div class="card-body">
                           <br>       
                           <form id="rq_form" action="add_requisition.php" method="post">        
                                <div class="form-group row col-sm-12">
                                	<div class="col-sm-4">
                                        <label for="item" class=" form-control-label"><small class="form-text text-muted">Company</small></label>
                                        <div>
                                            <?php
                                                $company = mysqli_query ( $conn_admin_db, "SELECT id, name FROM company");
                                                db_select ($company, 'company_id', '','','-select-','form-control','');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    	<label for="to" class=" form-control-label"><small class="form-text text-muted">To</small></label>
                                        <input type="text" id="to" name="to" class="form-control">
                                    </div>
                                    <div class="col-sm-4">
                                    	<label for="prepared_by" class=" form-control-label"><small class="form-text text-muted">Prepared by</small></label>
                                    	<input type="text" id="prepared_by" name="prepared_by" value="<?=strtoupper($username);?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">                                	
                                    <div class="col-sm-4">
                                    	<label for="serial_no" class=" form-control-label"><small class="form-text text-muted">Serial No.</small></label>
                                        <input type="text" id="serial_no" name="serial_no" class="form-control">
                                    </div>
                                	<div class="col-sm-4">
                                        <label for="date" class=" form-control-label"><small class="form-text text-muted">Date</small></label>
                                        <div class="input-group">
                                            <input id="date" name="date" class="form-control" autocomplete="off">
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        </div>   
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="paid_date" class=" form-control-label"><small class="form-text text-muted">Required to be paid on</small></label>
                                        <div class="input-group">
                                            <input id="paid_date" name="paid_date" class="form-control" autocomplete="off">
                                            <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        </div>   
                                    </div>
                                </div>      
                                <hr>
                                <h5><b>Add Expenses Particular</b></h5>
                                <br>
                                <div class="row form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label><small class="form-text text-muted">Particular</small></label>
                                        <input type="text" name="particular" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label><small class="form-text text-muted">Total (RM)</small></label>
                                        <input type="text" name="total" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label><small class="form-text text-muted">Remark</small></label>
                                        <input type="text" name="remark" class="form-control">
                                    </div>  
                                    <div class="col-sm-1"><button type="button" class="btn btn-success button_add save_particular">Add</button></div>
                                    <div class="col-sm-2"><button type="button" class="btn btn-secondary button_add button_reset">Reset</button> </div>                              
                                </div>                                                                                                       	                    
                           <table id="particular_list" class="table table-bordered data-table">
                            <thead>
                              <th>Particular</th>
                              <th>Total (RM)</th>
                              <th>Remark</th>
                              <th width="200px" style="text-align: center">Action</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                           </table>                            
                           </div> 
                           <!-- button save -->
                           <div class="col-sm-12" style="text-align: center">
                           		<button type="submit" class="btn btn-primary button_save">Save</button>
                           </div>
                           <br> 
                           </form>                     
                        </div>
                    </div>
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
