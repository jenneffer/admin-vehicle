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
        body {
        color: #404E67;
        background: #F5F7FA;
		font-family: 'Open Sans', sans-serif;
	}
	.table-wrapper {
		width: 700px;
		margin: 30px auto;
        background: #fff;
        padding: 20px;	
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
		height: 30px;
		font-weight: bold;
		font-size: 12px;
		text-shadow: none;
		min-width: 100px;
		border-radius: 50px;
		line-height: 13px;
    }
	.table-title .add-new i {
		margin-right: 4px;
	}
    table.table {
        table-layout: fixed;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
		cursor: pointer;
        display: inline-block;
        margin: 0 5px;
		min-width: 24px;
    }    
	table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table td a.add i {
        font-size: 24px;
    	margin-right: -1px;
        position: relative;
        top: 3px;
    }    
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
	table.table .form-control.error {
		border-color: #f50000;
	}
	table.table td .add {
		display: none;
	}
</style>
        
</head>

<body>
    <!--Left Panel -->
	<?php  //include('../assets/nav/leftNav.php')?>
    <!-- Right Panel -->
    <?php include('../assets/nav/rightNav.php')?>
    <!-- /#header -->
    <!-- Content -->
        <div id="right-panel" class="right-panel">
        <div class="content">

        <!-- Editable table -->
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2><b>SESB</b> Billing</h2></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                        </div>
                    </div>
                </div>
                <div  id="add_member">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Administration</td>
                            <td>(171) 555-2222</td>
                            <td>
    							<a class="add" title="Add" data-toggle="tooltip"><i class="fas fa-plus-circle"></i></a>
                                <a class="edit" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                <a class="delete" title="Delete" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Peter Parker</td>
                            <td>Customer Service</td>
                            <td>(313) 555-5735</td>
                            <td>
    							<a class="add" title="Add" data-toggle="tooltip"><i class="fas fa-plus-circle"></i></a>
                                <a class="edit" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                <a class="delete" title="Delete" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Fran Wilson</td>
                            <td>Human Resources</td>
                            <td>(503) 555-9931</td>
                            <td>
    							<a class="add" title="Add" data-toggle="tooltip"><i class="fas fa-plus-circle"></i></a>
                                <a class="edit" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                <a class="delete" title="Delete" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>      
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <!-- Editable table -->
        </div><!-- .content -->
        </div>

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

	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		var actions = $("table td:last-child").html();
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
			$(this).attr("disabled", "disabled");
			var index = $("table tbody tr:last-child").index();
	        var row = '<tr>' +
	            '<td><input type="text" class="form-control" name="name" id="name"></td>' +
	            '<td><input type="text" class="form-control" name="department" id="department"></td>' +
	            '<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
				'<td>' + actions + '</td>' +
	        '</tr>';
	    	$("table").append(row);		
			$("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
	        $('[data-toggle="tooltip"]').tooltip();
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			var empty = false;
			var input = $(this).parents("tr").find('input[type="text"]');			
	        input.each(function(){	        	
				if(!$(this).val()){
					$(this).addClass("error");
					empty = true;
				} else{
	                $(this).removeClass("error");
	            }
			});
			$(this).parents("tr").find(".error").first().focus();
			//Testing
// 			var name = $( 'input[name=name]' ).val();
// 			var department = $( 'input[name=department]' ).val();
// 			var phone = $( 'input[name=phone]' ).val();
// 			var members = [];
// 			members.push({
// 				name: name,
// 				department: department,
// 				phone: phone
// 			});

// 			var data = table.$('input, select').serialize();
			var input_data = $("#add_member").find("input").serialize();
			if(!empty){
				input.each(function(){
					$(this).parent("td").html($(this).val());
					
				});					
				//save data to database - testing	
				
				save_data_to_db(input_data);
					
				$(this).parents("tr").find(".add, .edit").toggle();
				$(".add-new").removeAttr("disabled");
			}		
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){					
	        $(this).parents("tr").find("td:not(:last-child)").each(function(){
				$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
			});		
			$(this).parents("tr").find(".add, .edit").toggle();
			$(".add-new").attr("disabled", "disabled");
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
	        $(this).parents("tr").remove();
			$(".add-new").removeAttr("disabled");
	    });
	});

	function save_data_to_db(input){
		console.log(input);
		event.preventDefault();
		$.ajax({
			url: "add_bill.ajax.php",
			data: {action:'add_members',data:input},
			method: 'POST',
			success: function( response ) {		

			}
		});

	}

  </script>
</body>
</html>
