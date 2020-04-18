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
   </style>
</head>
<body>
<div class="content">
	<div class="animated fadeIn">
		<div class="row">
		<table id="company_expenses_summary" class="table table-striped responsive table-bordered">
		<thead>
            <tr>
            	<th>No.</th>
            	<th>Vehicle No.</th>
            	<th>Premium (RM)</th>
            	<th>Sum Insured (RM)</th>
            	<th>NCD (%)</th>
            	<th>Remark</th>
            </tr>
    	</thead>
		</table>
		</div>
	</div>
</div>
<div class="clearfix"></div>
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

<script type="text/javascript">
$(document).ready(function() {
    $('#company_expenses_summary').DataTable({
    	"paging": false,
    	"pageLength": 1,
    	"responsive": true
     });
});
</script>
</body>