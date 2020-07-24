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
    .hideBorder {
        border: 0px;
        background-color: transparent;        
    }
    .hideBorder:hover {
        background: transparent;
        border: 1px solid #dee2e6;
    }
    form{
        margin: 20px 0;
    }
    form input, button{
        padding: 5px;
    }
    table{
        width: 100%;
        margin-bottom: 20px;
		border-collapse: collapse;
    }
    table, th, td{
        border: 1px solid #cdcdcd;
    }
    table th, table td{
        padding: 10px;
        text-align: left;
    }
    a:link {
      color: blue;
      background-color: transparent;
      text-decoration: none;
    }
    a:visited {
      color: #609;
      background-color: transparent;
      text-decoration: none;
    }
    a:hover {
      color: red;
      background-color: transparent;
      text-decoration: underline;
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
                    <div class="card" id="printableArea">
                        <div class="card-header">
                            <strong class="card-title">ABX Statement List</strong>
                        </div>
                        <div class="card-body">
                        	<table id="abx-statement" class="table table-striped table-bordered">
                                <thead>
                                    <tr>                                        
                                        <th>No.</th>
                                		<th>Invoice No.</th>
                                		<th>Amount (RM)</th>
                                		<th>Date added</th>
                                		<th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
							</table>
                        </div>
					</div>
				</div>            
        	</div><!-- .row -->
    	</div><!-- .animated -->
    </div><!-- .content -->
</div>
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
<script src="../assets/js/script/bootstrap-datepicker.min.js"></script>
<script src="../assets/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {	
	$('#abx-statement').DataTable({
    	"paging": true,
    	"searching": true,
    	"ajax":{
            "url": "abx.ajax.php",    
            "type": "POST",            	
            "data" : function ( data ) {
				data.action = 'display_abx_statement_list';				
   	        }
		},
		'columnDefs': [
        	  {
        	      "targets": [2], // your case first column
        	      "className": "text-right", 
        	      "render": $.fn.dataTable.render.number(',', '.', 2, '')               	                      	        	     
        	  },
        	  {
              	  "targets":[1,3,4],
              	  "className": "text-center",
              }],
    });
    $(document).on('click', '.delete_data', function(){
    	var id = $(this).attr("id");
    	$('#delete_record').data('id', id); //set the data attribute on the modal button
    
    });
  	
	$( "#delete_record" ).click( function() {
		var ID = $(this).data('id');
		$.ajax({
			url:"abx.ajax.php",
			method:"POST",    
			data:{action:'delete_data', id:ID},
			success:function(data){	  						
				$('#deleteItem').modal('hide');		
				location.reload();		
			}
		});
	});
    $('#date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        orientation: "top left",
        todayHighlight: true
  	});  	 
});
</script>
</body>
</html>
