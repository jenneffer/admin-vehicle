<?php
require_once('../assets/config/database.php');
require_once('../function.php');
require_once('../check_login.php');
global $conn_admin_db;

$year_select = isset($_POST['year_select']) ? $_POST['year_select'] : date("Y");
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : date("01-m-Y");
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : date("t-m-Y");
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
    .button_search{
        position: absolute;
        left:    0;
        bottom:   0;
    }
    .button_add_invoice{
        position: absolute;
        left:    0;
        bottom:   0;
    }
    
   </style>
</head>

<body>
<!--Left Panel -->
<?php include('../assets/nav/leftNav.php')?>
<!-- Right Panel -->
<?php include('../assets/nav/rightNav.php')?>
<!-- /#header -->
<!-- Content -->
<div id="right-panel" class="right-panel">
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="printableArea">
                    <div class="card-header">
                        <strong class="card-title">Photocopy Machine (Fuji Xerox)</strong>
                    </div>     
                    <div class="card-body">                                               
						<div class="tabs">
							<ul>
								<li id="t1"><a href="#tab1" class="tab1a">Fuji Xerox Account</a></li>
                                <li id="t2"><a href="#tab2" class="tab2a">Invoice</a></li>
							</ul>
							<div class="tab-content">
    							<div class="tab active" id="tab1">
        							<div class=" form-group col-sm-12">                        		
                                		<button type="button" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#addItem">Add New Account</button>                        		
                                		<div>
        									<span class="color-red"> ** To add new record of usage, please click the hyperlink in Reference No. column</span>
        								</div>
                                	</div>
                                	<table id="item-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                            	<th>Serial No.</th>                                        
        										<th>Company</th>										
        										<th>Account No.</th>
        										<th>Location</th>
        										<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $sql_query = "SELECT * FROM bill_fuji_xerox_account WHERE status ='1'"; 
                                            if(mysqli_num_rows(mysqli_query($conn_admin_db,$sql_query)) > 0){
                                                $count = 0;
                                                $sql_result = mysqli_query($conn_admin_db, $sql_query)or die(mysqli_error($conn_admin_db));
                                                    while($row = mysqli_fetch_array($sql_result)){ 
                                                        $count++;  
                                                        $comp_name = itemName("SELECT name FROM company WHERE id='".$row['company']."'");
                                                        ?>
                                                        <tr>
                                                        	<td><a href="fx_account_details.php?id=<?=$row['id']?>" target="_blank" style="color:blue;"><?=$row['serial_no']?></a></td>                                                    
                                                            <td><?=strtoupper($comp_name)?></td>
                                                            <td><?=$row['acc_no']?></td>
                                                            <td><?=$row['location']?></td>
                                                            <td>
                                                            	<span id="<?=$row['id']?>" data-toggle="modal" class="edit_data" data-target="#editItem"><i class="fa fa-edit"></i></span>
                                                            	<span id="<?=$row['id']?>" data-toggle="modal" class="delete_data" data-target="#deleteItem"><i class="fas fa-trash-alt"></i></span>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                                }
                                        ?>
                                        </tbody>
                                    </table>    
    							</div>
    							<div class="tab" id="tab2">  
        							<form action="" enctype="multipart/form-data" method="post">
                                        <div class="form-group row col-sm-12">
                                            <div class="col-sm-3">
                                                <label for="date_start" class="form-control-label"><small class="form-text text-muted">Date Start</small></label>
                                                <div class="input-group">
                                                  <input type="text" id="date_start" name="date_start" class="form-control form-control-sm" value="<?=$date_start?>" autocomplete="off">
                                                </div>                            
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="date_end" class="form-control-label"><small class="form-text text-muted">Date End</small></label>
                                                <div class="input-group">
                                                  <input type="text" id="date_end" name="date_end" class="form-control form-control-sm" value="<?=$date_end?>" autocomplete="off">
                                                </div>                             
                                            </div>
                                            <div class="col-sm-1">                                    	
                                            	<button type="button" class="btn-sm btn btn-primary button_search ">View</button>                                        	
                                            </div>
                                            <div class="col-sm-2 text-right">
                                        		<button type="button" class="btn-sm btn btn-primary button_add_invoice" data-toggle="modal" data-target="#addInvoice">Add New Invoice</button>
                                        	</div>
                                        </div>
                            		</form>
                            		<table id="fj_invoice_table" class="table table-striped table-bordered">        
                                		<thead>
                                            <tr>
                                            	<th class="text-center">Serial No.</th>	
                                            	<th>Company</th>																		
            									<th class="text-right">Amount (RM)</th>        							    																			
                                            </tr>										
                                    	</thead>
                                    	<tbody>
                                    	</tbody>
                                    	<tfoot>
                                    		<tr>
                                    			<th colspan="2" class="text-right"> Grand Total</th>
                                    			<th></th>
                                    		</tr>
                                    	</tfoot>                                    
                                	</table>      
    							</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
</div>
        
<!-- Modal Add new fuji xerox account -->
<div id="addItem" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Fuji Xerox Account</h4>
        	</div>
            <div class="modal-body">
            <form role="form" method="POST" action="" id="add_form">                    
                <div class="form-group row col-sm-12">
                	<div class="col-sm-6">
                        <label for="company" class=" form-control-label"><small class="form-text text-muted">Company <span class="color-red">*</span></small></label>
                        <div>
                            <?php
                                $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE status='1' ORDER BY name");
                                db_select ($company, 'company', '','','-select-','form-control','','required');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="serial_no" class=" form-control-label"><small class="form-text text-muted">Serial No. <span class="color-red">*</span></small></label>
                        <input type="text" id="serial_no" name="serial_no" placeholder="Enter Serial number" class="form-control" required>
                    </div>
                </div>  
                <div class="form-group row col-sm-12">
                	<div class="col-sm-12">
                        <label for="acc_no" class=" form-control-label"><small class="form-text text-muted">Account_no <span class="color-red">*</span></small></label>
                        <input type="text" id="acc_no" name="acc_no" class="form-control" required>
                    </div>
                </div>                  
                <div class="form-group row col-sm-12">
                	<div class="col-sm-12">
                        <label for="location" class=" form-control-label"><small class="form-text text-muted">Location <span class="color-red">*</span></small></label>
                        <textarea id="location" name="location" class="form-control" required></textarea>
                    </div>
                </div>                        
                <div class="form-group row col-sm-12">
                	<div class="col-sm-12">
                        <label for="remark" class=" form-control-label"><small class="form-text text-muted">Remark</small></label>
                        <textarea id="remark" name="remark" class="form-control"></textarea>
                    </div>
                </div>              
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary save_data ">Save</button>
                </div>
            </form>
			</div>
        </div>
    </div>
</div>		
<!-- Modal add new invoice -->
<div class="modal fade" id="addInvoice">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Invoice</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="" id="add_invoice">                                                                  
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label class=" form-control-label"><small class="form-text text-muted">Company <span class="color-red">*</span></small></label>
                            <div>
                                <?php
                                    $company = mysqli_query ( $conn_admin_db, "SELECT id, UPPER(name) FROM company WHERE id IN(SELECT company FROM bill_fuji_xerox_account WHERE status='1') ORDER BY name");
                                    db_select ($company, 'company_add', '','','-select-','form-control','','required');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label "><small class="form-text text-muted">Serial No. <span class="color-red">*</span></small></label>                                  
                            <select id="serial_no_add" name="serial_no_add" class="form-control" required>
                               <option value="0">- select -</option>
                            </select>
                        </div> 
                    </div>   
                    <div class="row form-group col-sm-12">       
                    	<div class="col-sm-6">
                            <label for="inv_date" class=" form-control-label"><small class="form-text text-muted">Invoice Date <span class="color-red">*</span></small></label>
                            <div class="input-group">
                                <input type="text" id="inv_date" name="inv_date" class="form-control" autocomplete="off" required>                               
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="inv_no" class=" form-control-label"><small class="form-text text-muted">Invoice No. <span class="color-red">*</span></small></label>
                            <input type="text" id="inv_no" name="inv_no" class="form-control" autocomplete="off" required>
                        </div>
                    </div>                                                                 	 
                    <div class="row form-group col-sm-12">
                        <div class="col-sm-6">
                            <label for="particular" class=" form-control-label"><small class="form-text text-muted">Particulars <span class="color-red">*</span></small></label>
                            <textarea id="particular" name="particular" class="form-control" autocomplete="off" required></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label for="amount" class=" form-control-label"><small class="form-text text-muted">Amount (RM) <span class="color-red">*</span></small></label>
                            <input type="text" id="amount" name="amount" class="form-control" autocomplete="off" required>
                        </div>                                
                    </div>
                    <div class="row form-group col-sm-12">                            	
                    	<div class="col-sm-6">
                            <label for="remark_add" class=" form-control-label"><small class="form-text text-muted">Remark <span class="color-red">*</span></small></label>
                            <textarea id="remark_add" name="remark_add" class="form-control" autocomplete="off"></textarea>
                        </div>                                                            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary save_invoice ">Save</button>
                    </div>
                </form>
            </div>
    	</div>
	</div>
</div>
<!-- Modal edit fj account  -->
<div id="editItem" class="modal fade">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Account</h4>
        </div>
        <div class="modal-body">
            <form role="form" method="POST" action="" id="update_form">
                <input type="hidden" name="_token" value="">
                <input type="hidden" id="id" name="id" value="">
                <div class="form-group row col-sm-12">
            	<div class="col-sm-6">
                    <label for="company_edit" class=" form-control-label"><small class="form-text text-muted">Company <span class="color-red">*</span></small></label>
                    <div>
                        <?php
                            $company = mysqli_query ( $conn_admin_db, "SELECT id, code FROM company");
                            db_select ($company, 'company_edit', '','','-select-','form-control','','required');
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="serial_no_edit" class=" form-control-label"><small class="form-text text-muted">Serial No. <span class="color-red">*</span></small></label>
                    <input type="text" id="serial_no_edit" name="serial_no_edit" placeholder="Enter Serial number" class="form-control" required>
                </div>
                </div>         
                <div class="form-group row col-sm-12">
                	<div class="col-sm-12">
                        <label for="acc_no_edit" class=" form-control-label"><small class="form-text text-muted">Account_no <span class="color-red">*</span></small></label>
                        <input type="text" id="acc_no_edit" name="acc_no_edit" class="form-control" required>
                    </div>
            	</div>           
                <div class="form-group row col-sm-12">
                	<div class="col-sm-12">
                        <label for="location_edit" class=" form-control-label"><small class="form-text text-muted">Location <span class="color-red">*</span></small></label>
                        <textarea id="location_edit" name="location_edit" class="form-control" required></textarea>
                    </div>
                </div>                        
                <div class="form-group row col-sm-12">
                	<div class="col-sm-12">
                        <label for="remark_edit" class=" form-control-label"><small class="form-text text-muted">Remark <span class="color-red">*</span></small></label>
                        <textarea id="remark_edit" name="remark_edit" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary update_data ">Update</button>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<div class="modal fade" id="deleteItem">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                   Are you sure you want to delete?
               </p>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" id="delete_record" class="btn btn-primary">Confirm</button>
        	</div>
    	</div>
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
<script src="../assets/js/jquery-ui.js"></script>
<script src="../assets/js/script/bootstrap-datepicker.min.js"></script>
<script src="../assets/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    // Initialize select2
    var select2 = $("#company").select2({
        selectOnClose: true
    });
    select2.data('select2').$selection.css('height', '38px');
    select2.data('select2').$selection.css('border', '1px solid #ced4da');
    
    var select3 = $("#company_add").select2({
        selectOnClose: true
    });
    select3.data('select2').$selection.css('height', '38px');
    select3.data('select2').$selection.css('border', '1px solid #ced4da');

    $(".tabs").tabs();
    var currentTab = $('.ui-state-active a').index();
    if(localStorage.getItem('activeTab') != null){
    	 $('.tabs > ul > li:nth-child('+ (parseInt(localStorage.getItem('activeTab')) + 1)  +')').find('a').click();
    }

    $('.tabs > ul > li > a').click(function(e) {
        var curTab = $('.ui-tabs-active');         
        curTabIndex = curTab.index();          
        localStorage.setItem('activeTab', curTabIndex);
    });
     
    $('#item-data-table').DataTable({
    	"paging": false,  
    	"searching" : false, 
    	"bInfo" : false,
    	"ordering": false,
    	"fixedHeader" : true
    });
    
    $(document).on('click', '.edit_data', function(){
    	var id = $(this).attr("id");        	
    	$.ajax({
    			url:"fx_bill.ajax.php",
    			method:"POST",
    			data:{action:'retrieve_account', id:id},
    			dataType:"json",
    			success:function(data){
        			console.log(data);            			        			
    				$('#id').val(id);					
                    $('#company_edit').val(data.company);      
                    $('#serial_no_edit').val(data.serial_no);  
                    $('#location_edit').val(data.location);   
                    $('#acc_no_edit').val(data.acc_no);            
                    $('#remark_edit').val(data.remark);                        
                    $('#editItem').modal('show');
    			}
    		});
    });

    $(document).on('click', '.delete_data', function(){
        var id = $(this).attr("id");
        $('#delete_record').data('id', id); //set the data attribute on the modal button
    
    });
  	
	$( "#delete_record" ).click( function() {
        var ID = $(this).data('id');
        $.ajax({
        	url:"fx_bill.ajax.php",
        	method:"POST",    
        	data:{action:'delete_account', id:ID},
        	success:function(data){	  						
        		$('#deleteItem').modal('hide');		
        		location.reload();		
        	}
        });
	});

    $('#update_form').on("submit", function(event){  
        event.preventDefault();  
        $.ajax({  
            url:"fx_bill.ajax.php",  
            method:"POST",  
            data:{action:'update_account', data: $('#update_form').serialize()},  
            success:function(data){   
                 if(data){
                     alert("Successfully updated!");
                	 $('#editItem').modal('hide');  
                     location.reload();
                 }  
            }  
        });  
    }); 
    
    $('#add_form').on("submit", function(event){  
        event.preventDefault();  
        $.ajax({  
            url:"fx_bill.ajax.php",  
            method:"POST",  
            data:{action:'add_new_account', data: $('#add_form').serialize()},  
            success:function(data){   
               if(data){
                   alert("Successfully added!");
            	   $('#editItem').modal('hide');  
                   $('#bootstrap-data-table').html(data);
                   location.reload(); 
               } 
            }  
        });  
      });

    $('#add_invoice').on("submit", function(event){  
        event.preventDefault();               
        $.ajax({  
            url:"fx_bill.ajax.php",  
            method:"POST",  
            data:{action:'add_new_invoice', data: $('#add_invoice').serialize()},  
            success:function(data){   
                console.log(data)
//                  $('#editItem').modal('hide');                             
//                  location.reload();  
            }  
       });  
    });

    //update the date value on datepicker change
    $("#date_start").change(function(){
    	var date_start = $(this).val();
    	$("#date_start").val(date_start);
	});
    $("#date_end").change(function(){
    	var date_end = $(this).val();
    	$("#date_end").val(date_end);
	});
	    
    $('#inv_date, #date_start, #date_end').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        orientation: "top left",
        todayHighlight: true
    });

    //onchange company
    $("#company_add").change(function(){
        var company = $(this).val();
        $.ajax({
            url: 'fx_bill.ajax.php',
            type: 'POST',
            data: {action:'get_serial_no', id: company},
            dataType: 'json',
            success:function(response){
                console.log(response);
                var len = response.length;
                $("#serial_no_add").empty();
                for( var i = 0; i<len; i++){
                    var acc_id = response[i]['id'];
                    var description = response[i]['serial_no'];
                    
                    $("#serial_no_add").append("<option value='"+acc_id+"'>"+description+"</option>");
    
                }
            }
        });
    }); 
    var table = $('#fj_invoice_table').DataTable({
    	"ordering": false,
        "paging": false,  
        "searching" : false, 
        "bInfo" : false,
        "processing": true,
     	"serverSide": true,
        "columnDefs": [
        	{
                "targets": [2], // your case first column
                "className": "text-right", 
                "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
         	},
         	{
                "targets": [0], // your case first column
                "className": "text-left"                          	                      	        	     
         	}
        ],	
        "footerCallback": function( tfoot, data, start, end, display ) {
    		var api = this.api(), data;
    		var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;
    
    		api.columns([2], { page: 'current'}).every(function() {
    			var sum = this
    		    .data()
    		    .reduce(function(a, b) {
    		    var x = parseFloat(a) || 0;
    		    var y = parseFloat(b) || 0;
    		    	return x + y;
    		    }, 0);			
    		       
    		    $(this.footer()).html(numFormat(sum));
    		}); 
    	},
        "ajax":{
            "url": "fx_bill.ajax.php",    
            "type":"POST",       	
            "data" : function ( data ) {                
                data.date_start = $("#date_start").val();
                data.date_end = $("#date_end").val();  
                data.action = 'display_invoice_list';				
            }
        },
    });

    $( ".button_search" ).click(function( event ) {
        table.clear();
        table.ajax.reload();
        table.draw();  		
    });	 

//     var $previousTab = 0;
//     var $backButtonUsed = false;
//     $("#nav-tabContent").tabs(); 
//     $("#nav-tabContent").bind("tabselect", function(event, ui){
// 		if($backButtonUsed){

// 		}
// 	});
    
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
