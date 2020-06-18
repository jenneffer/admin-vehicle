<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Example of Bootstrap 3 Accordion with Arrow Icon</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    .bs-example{
    	margin: 20px;
    }
    .rotate{
		-webkit-transform: rotate(90deg);  /* Chrome, Safari, Opera */
			-moz-transform: rotate(90deg);  /* Firefox */
			-ms-transform: rotate(90deg);  /* IE 9 */
				transform: rotate(90deg);  /* Standard syntax */    
    }
</style>
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.in").each(function(){
        	$(this).siblings(".panel-heading").find(".glyphicon").addClass("rotate");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").addClass("rotate");
        }).on('hide.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("rotate");
        });
    });
</script>
</head>
<body>
<div class="bs-example">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <span class="glyphicon glyphicon-menu-right"></span> Service/Maintenance Charges</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div>
                    	<div class="row form-group col-sm-12">
                        	<div class="col-sm-4">
                                <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                                <input type="text" id="description" name="description" class="form-control" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                                <label for="payment" class=" form-control-label"><small class="form-text text-muted">Payment (RM)</small></label>
                                <input type="text" id="payment" name="payment" class="form-control" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                            	<label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>
                            	<select id="payment_mode" name="payment_mode" class="form-control">
                            		<option value="">- Select -</option>
                            		<option value="cash">Cash</option>
                            		<option value="ibg">IBG</option>
                            	</select>
                            </div>                                 
                        </div>
                        <div class="row form-group col-sm-12">
                            <div class="col-sm-4">
                                <label for="or_no" class=" form-control-label"><small class="form-text text-muted">Official Receipt No.</small></label>
                                <input type="text" id="or_no" name="or_no" class="form-control" autocomplete="off">
                            </div>  
                            <div class="col-sm-4">
                                <label for="cheque_no" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                                <input type="text" id="cheque_no" name="cheque_no" class="form-control" autocomplete="off">
                            </div>                                                                              
                        </div>    
                        <div class="row form-group col-sm-12">
                        	<div class="col-sm-4">
                                <label for="bill_invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice / Reference No.</small></label>
                                <input type="text" id="bill_invoice_no" name="bill_invoice_no" class="form-control" autocomplete="off">
                            </div>
                        	<div class="col-sm-4">
                                <label for="payment_date" class=" form-control-label"><small class="form-text text-muted">Payment Date</small></label>
                                <div class="input-group">
                                    <input type="text" id="payment_date" name="payment_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="receive_date" class=" form-control-label"><small class="form-text text-muted">Received Date</small></label>
                                <div class="input-group">
                                    <input type="text" id="receive_date" name="receive_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>                                            
                        </div>                                    	
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <span class="glyphicon glyphicon-menu-right"></span> Sinking Fun</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div>
                    	<div class="row form-group col-sm-12">
                        	<div class="col-sm-4">
                                <label for="description" class=" form-control-label"><small class="form-text text-muted">Description</small></label>
                                <input type="text" id="description" name="description" class="form-control" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                                <label for="payment" class=" form-control-label"><small class="form-text text-muted">Payment (RM)</small></label>
                                <input type="text" id="payment" name="payment" class="form-control" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                            	<label for="payment_mode" class=" form-control-label"><small class="form-text text-muted">Payment Mode</small></label>
                            	<select id="payment_mode" name="payment_mode" class="form-control">
                            		<option value="">- Select -</option>
                            		<option value="cash">Cash</option>
                            		<option value="ibg">IBG</option>
                            	</select>
                            </div>                                 
                        </div>
                        <div class="row form-group col-sm-12">
                            <div class="col-sm-4">
                                <label for="or_no" class=" form-control-label"><small class="form-text text-muted">Official Receipt No.</small></label>
                                <input type="text" id="or_no" name="or_no" class="form-control" autocomplete="off">
                            </div>  
                            <div class="col-sm-4">
                                <label for="cheque_no" class=" form-control-label"><small class="form-text text-muted">Cheque No.</small></label>
                                <input type="text" id="cheque_no" name="cheque_no" class="form-control" autocomplete="off">
                            </div>                                                                              
                        </div>    
                        <div class="row form-group col-sm-12">
                        	<div class="col-sm-4">
                                <label for="bill_invoice_no" class=" form-control-label"><small class="form-text text-muted">Invoice / Reference No.</small></label>
                                <input type="text" id="bill_invoice_no" name="bill_invoice_no" class="form-control" autocomplete="off">
                            </div>
                        	<div class="col-sm-4">
                                <label for="payment_date" class=" form-control-label"><small class="form-text text-muted">Payment Date</small></label>
                                <div class="input-group">
                                    <input type="text" id="payment_date" name="payment_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="receive_date" class=" form-control-label"><small class="form-text text-muted">Received Date</small></label>
                                <div class="input-group">
                                    <input type="text" id="receive_date" name="receive_date" class="form-control" autocomplete="off">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>                                            
                        </div>                                    	
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    <span class="glyphicon glyphicon-menu-right"></span> Water Bill</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                    <span class="glyphicon glyphicon-menu-right"></span> Late Interest Charge</a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    <span class="glyphicon glyphicon-menu-right"></span> Quit Rent</a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    <span class="glyphicon glyphicon-menu-right"></span> Insurance</a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                </div>
            </div>
        </div>
    </div>
	<p><strong>Note:</strong> Click on the linked heading text to expand or collapse accordion panels.</p>
</div>
</body>
</html>                                		                                		                            