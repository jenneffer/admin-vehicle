<?php
    require_once('../assets/config/database.php');
    require_once('../function.php');
    require_once('../check_login.php');
	global $conn_admin_db;

?>

<!doctype html>
<html class="no-js" lang="">
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
        .submit-button{
            text-align: center;
        }
        .select2-selection__rendered {
          margin: 5px;
        }
        .select2-selection__arrow {
          margin: 5px;
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
            <form id="add_roadtax" action="" method="post">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Road Tax</strong>
                    </div>
                    <div class="card-body">
				      	<div class="form-group row col-sm-12">
					      	<div class="col-sm-12">
                                <label for="vehicle_reg_no" class=" form-control-label"><small class="form-text text-muted">Vehicle Reg No.<span class="color-red">*</span></small></label>
                                <?php
                                    $vehicle = mysqli_query ( $conn_admin_db, "SELECT vv_id, UPPER(vv_vehicleNo) FROM vehicle_vehicle WHERE status='1'");
                                    db_select ($vehicle, 'vehicle_reg_no', '','','-select-','form-control','','required');
                                ?>
                            </div> 
				      	</div>
				      	<div class="form-group row col-sm-12">
				      	<div class="col-sm-6">
                            <label for="roadtax_from_date" class="form-control-label"><small class="form-text text-muted">Roadtax from date<span class="color-red">*</span></small></label>
                            <div class="input-group">
                                <input id="roadtax_from_date" name="roadtax_from_date" class="form-control" autocomplete="off" required>
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="roadtax_due_date" class="form-control-label"><small class="form-text text-muted">Roadtax due date<span class="color-red">*</span></small></label>
                            <div class="input-group">
                                <input id="roadtax_due_date" name="roadtax_due_date" class="form-control" autocomplete="off" required>
                                <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                        </div>   
				      	</div>
                        <div class="form-group row col-sm-12"> 
                            <div class="col-sm-6">
                                <label for="roadtax_amount" class=" form-control-label"><small class="form-text text-muted">Roadtax Amount(RM)<span class="color-red">*</span></small></label>
                                <input type="text" id="roadtax_amount" name="roadtax_amount" onkeypress="return isNumberKey(event)" class="form-control" required>
                            </div> 
                            <div class="col-sm-6">
                                <label for="roadtax_period" class=" form-control-label"><small class="form-text text-muted">Roadtax Period</small></label>
                                <input type="text" id="roadtax_period" name="roadtax_period" placeholder="e.g: 6 Months, 12 Months" class="form-control">
                            </div> 
                        </div>
                        <br>
                        <div class="submit-button">
                        	<button type="submit" id="save" name="save" class="btn btn-primary">Save</button>
                            <button type="button" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
                        </div> 
                        <br>                 
                    </div>
                    
                </div>
               </form>
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
//             $('#bootstrap-data-table-export').DataTable();

			// Initialize select2
        	var select2 = $("#vehicle_reg_no").select2({
    //     		placeholder: "select option",
        	    selectOnClose: true
            });
        	select2.data('select2').$selection.css('height', '38px');
        	select2.data('select2').$selection.css('border', '1px solid #ced4da');
            
            $('#roadtax_from_date').datepicker({
            	format: 'dd-mm-yyyy',
            	autoclose: true,
            	todayHighlight: true,
             });
            $('#roadtax_due_date').datepicker({
            	format: 'dd-mm-yyyy',
            	autoclose: true,
            	todayHighlight: true,
             });     

            $('#add_roadtax').on("submit", function(event){  
                event.preventDefault();  
                $.ajax({  
                    url:"roadtax.all.ajax.php",  
                    method:"POST",  
                    data:{action:'create_roadtax', data: $('#add_roadtax').serialize()},  
                    success:function(data){ 
                          if(data){                              
                              alert("Added Successfully!");
                              window.location = "roadtax.php";  
                          }                               
                    }  
               	});   
             });                  
        });

        function isNumberKey(evt){
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) 
				return false;
			return true;
		}  
		
		function isNumericKey(evt){
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
				return true;
			return false;
		} 
  </script>
</body>
</html>
