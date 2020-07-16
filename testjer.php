<?php
require_once("header.php"); 
require_once("reservation.booking.common.php");

$arrangement_no = arrangementGenerator();
$mkendtimep=mktime(date("H")+8, date("i"), date("s"), date("m"), date("d"), date("Y"));
$todaydate=date("d M Y H:i a", $mkendtimep);
$user_type = $_SESSION['valid_usertype'];

$select_room_type = '';
ob_start();
$sql_roomt = db_query("SELECT code,code FROM room_type GROUP BY code");
db_select($sql_roomt,"room_type[{index}]",'',"","","room_type","");	
$select_room_type = ob_get_clean();

$select_bed_type = '';
ob_start();
$sql_bed = db_query("SELECT code,code FROM bed_master WHERE code <> 'TRP' ORDER BY code ");
db_select($sql_bed,"bed_type[{index}]","TWN",""," ","bed_type","");
$select_bed_type = ob_get_clean();


$select_room_number='';
ob_start();
$empty = array("---");
array_select($empty,$empty,"room_no[{index}]",$room_no,"","","room_no","");
$select_room_number= ob_get_clean();

$select_promo_code='';
ob_start();
$empty = array("---");
array_select($empty,$empty,"promo_code[{index}]",$promo_code,"","","promo_code","");
$select_promo_code= ob_get_clean();

$select_agent = '';
ob_start();
$sql_agent = db_query("SELECT code,description FROM agent_info ORDER BY description");
db_select($sql_agent,"agent_code","",""," ","","");
$select_agent = ob_get_clean();

// $select_room_wing = '';
// ob_start();
// $sql_wing = mysql_query("SELECT room_wing,room_wing FROM room_master GROUP BY room_wing");
// db_select($sql_bed,"room_wing[{index}]","",""," ","room_wing","");
// $select_room_wing = ob_get_clean();

//get room_type to populate select element
// $arr_std_room_type = array();
// $rst_std = mysql_query("SELECT id,type FROM room_type WHERE (date_start >= '2016-04-01' OR date_end IS NULL) AND code='STD' ORDER BY id");
// while( $row = mysql_fetch_assoc( $rst_std ) ){
// 	$arr_std_room_type[] = array(
// 			'id' => $row['id'],
// 			'type' => $row['type']
// 	);
// }

// $arr_cha_room_type = array();
// $rst_cha = mysql_query("SELECT id,type FROM room_type WHERE (date_start >= '2016-04-01' OR date_end IS NULL) AND code='CHA' ORDER BY id");
// while( $row = mysql_fetch_assoc( $rst_cha ) ){
// 	$arr_cha_room_type[] = array(
// 			'id' => $row['id'],
// 			'type' => $row['type']
// 	);
// }

function html_get_selectGender( $name ){
	$select_gender = '';
	ob_start();
	selectGender($name,"",""," ","forme","");
	$select_gender = ob_get_clean();
	return $select_gender;
}

$reservation_details_form_inputs = "<table border='0' align='center' width='100%' cellpadding='3' cellspacing='0' class='tblForm' >
	<tr>
	<td class='header' width='3%' align='center'><img src='images/button.gif' border='0'> </td>
	<td class='header' colspan='10' style='border-top:1px solid #296DC1;'><strong>RESERVATION DETAILS {index}</strong></td>
	</tr>
	<tr><td colspan='6'><img src='images/blank.gif' border='0'></td></tr>
	<tr>
	<td>&nbsp;</td>
	<td width='10%' align='left'></td>
	<td align='left' width='38%'></td>
	<td width='1%'></td>
	<td width='2%'></td>
	<td></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td align='left'>*No of Pax</td>
	<td align='left'><input class='short_label pax_r_adult' name='adult[{index}]' type='text' value='' > 
	<label class='short_label'>Adult</label> <input class='short_label  pax_r_child' name='child[{index}]' type='text' value='' ><label class='short_label'>Child</label></td>
	<td colspan='2'>*Room Type </td>
	<td align='left'>".$select_room_type."</td>	
	<td colspan='2'>Promo Code </td>
	<td align='left'>".$select_promo_code."</td>	
	</td>
	</tr>

	<tr>
	<td>&nbsp;</td>
	<td align='left'>*Check-in Date</td>
	<td align='left'><input type='text' id='checkin_{index}' name='checkin[{index}]' value='' readonly > <a style='float:left;' href='#' onClick=\"cal1xx.select(document.form_new_arrangement.checkin_{index},'anchor1x{index}','dd-MM-yyyy'); clearReservationDates({index}); return false;\" name='anchor1x{index}' id='anchor1x{index}'><img src='images/icon_cal.gif' border='0'></a>
	<input type='checkbox' name='lunch_arrive[{index}]' value='1' /><label >Include Lunch On Arrival</label>
	<td colspan='2'>*Bed Type</td>
	<td>".$select_bed_type."</td>
	</td>
	</tr>		
	
	<tr>
	<td>&nbsp;</td>
	<td align='left'>*Staying Night</td>
	<td align='left'><input class='short_label night' type='text' name='night[{index}]' value='' ></td>
	<td colspan='2'> Room Number</td>
	<td>".$select_room_number."</td>
	</tr>
	
	<tr>
	<td>&nbsp;</td>
	<td align='left'>*Check-out Date</td>
	<td align='left'><input type='text' id='checkout_{index}' name='checkout[{index}]' value='' readonly > <a style='float:left;' href='#' onClick=\"cal1xx.select(document.form_new_arrangement.checkout_{index},'anchor2x{index}','dd-MM-yyyy'); clearReservationDates({index}); return false;\" name='anchor2x{index}' id='anchor2x{index}'><img src='images/icon_cal.gif' border='0'></a>
	<input  type='checkbox' name='lunch_depart[{index}]' value='1' /><label >Include Lunch On Departure</label>
	<td colspan='4'><input type='checkbox' class='extra_mattress' name='extra_mattress[{index}]' class='radio' value='1' > <label>+ Extra Mattress</label>
	<input type='checkbox' class='baby_cot' name='baby_cot[{index}]' class='radio' value='1' > <label>+ Baby Cot</label></td>
	</td>
	
	<tr>
	<td colspan='6'><hr align='left' noshade width='90%' size='1' style='border:1px dashed #D4DDED;'></td>
	</tr>
	
	<td>&nbsp;</td>
	<td align='left' colspan='6'>
	<div style='display:inline-block;float:left;'>
	<p>
	<label class='medium_label'>OVL None</label> 
	<input type='radio' class='radio' name='overland[{index}]' id='no' value='' >
	</p>
	<p>
	<label class='medium_label' style=''>OVL LDU</label> 
	<input type='radio' class='radio' name='overland[{index}]' id='ldu' value='LDU' >
	</p>
	<p>
	<label class='medium_label' style=''>OVL SMM</label>
	<input type='radio' class='radio' name='overland[{index}]' id='smm' value='SMM' >
	</p>
	<p>
	<label class='medium_label' style=''>OVL SDK</label>
	<input type='radio' class='radio' name='overland[{index}]' id='sdk' value='SDK' >
	</p>
	</div>
	
	<div style='display:inline-block;float:left;margin-left:30px;'>
	<p><label for='chk_non_bet'>NON-BET Guide</label><input type='checkbox' name='chk_non_bet[{index}]' class='radio' value='1' id='chk_non_bet'  ></p>
	<p><label for='label02'>Domestic Rate</label><input type='checkbox' name='dom_int[{index}]' class='radio' value='1' id='label02'  ></p>
	<p><label for='vcl'>Conservation Contribution (CC)</label> &nbsp; <input type='checkbox' name='vcl[{index}]' class='radio' value='1' id='label05' checked></p>
	</div>
	
	<div style='display:inline-block;float:left;margin-left:30px;'>
	<p><label for='label04'>Free Meal</label><input type='checkbox' name='foc_meal[{index}]' class='radio' value='1' id='label04' ></p>
	</div>
	
	</td>
	</tr>
	
	<tr><td colspan='6'><img src='images/blank.gif' border='0'></td></tr>
	
	<tr>
	<td class='header' align='center' style='border-top:1px solid #296DC1;'> </td>
	<td class='header' colspan='5' style='border-top:1px solid #296DC1;'><strong>GUEST DETAILS</strong></td>
	</tr>
	
	<tr><td colspan='6'><img src='images/blank.gif' border='0'></td></tr>
	
	<tr>
	<td>&nbsp;</td>
	<td colspan='5' align='left'>
	
	<table border='0' align='left' width='95%' cellpadding='3' cellspacing='0' id='tableResult'>
	<tr>
	<td class='header' width='5%' align='center'>#</td>
	<td class='header' width='20%'>Guest Name</td>
	<td class='header' width='10%'>Passport</td>
	<td class='header' width='10%'>Date of Birth</td>
	<td class='header' width='10%'>Gender</td>
	</tr>
	
	<tr>
	<td align='center'>*1</td>
	<td>
	<input type='text' name='guest_name_01[{index}]' value='' size='25' class='forme'  > 
	</td>
	<td><input type='text' name='passport_01[{index}]' value='' size='15' class='forme'  ></td>
	<td><input type='text' id='dob_01_{index}' name='dob_01[{index}]' value='' size='15' class='forme' >  
	<a href='#' onClick=\"cal1xx.select(document.form_new_arrangement.dob_01_{index},'anchor31{index}','dd-MM-yyyy'); return false;\" name='anchor31{index}' id='anchor31{index}'><img src='images/icon_cal.gif' border='0'></a></td>
	<td>".html_get_selectGender( 'gender_01[{index}]' )."</td>
	</tr>
	
	<tr>
	<td align='center'>2</td>
	<td>
	<input type='text' name='guest_name_02[{index}]' value='' size='25' class='forme'  > </td>
	<td><input type='text' name='passport_02[{index}]' value='' size='15' class='forme'  ></td>
	<td><input type='text' id='dob_02_{index}' name='dob_02[{index}]' value='' size='15' class='forme' >  
	<a href='#' onClick=\"cal1xx.select(document.form_new_arrangement.dob_02_{index},'anchor32{index}','dd-MM-yyyy'); return false;\" name='anchor32{index}' id='anchor32{index}'><img src='images/icon_cal.gif' border='0'></a></td>
	<td>".html_get_selectGender( 'gender_02[{index}]' )."</td>
	</tr>
	
	<tr>
	<td align='center'>3</td>
	<td>
	<input type='text' name='guest_name_03[{index}]' value='' size='25' class='forme'  > </td>
	<td><input type='text' name='passport_03[{index}]' value='' size='15' class='forme'  ></td>
	<td><input type='text' id='dob_03_{index}' name='dob_03[{index}]' value='' size='15' class='forme' >  
	<a href='#' onClick=\"cal1xx.select(document.form_new_arrangement.dob_03_{index},'anchor33{index}','dd-MM-yyyy'); return false;\" name='anchor33{index}' id='anchor33{index}'><img src='images/icon_cal.gif' border='0'></a></td>
	<td>".html_get_selectGender( 'gender_03[{index}]' )."</td>
	</tr>
	
	<tr>
	<td align='center'>4</td>
	<td>
	<input type='text' name='guest_name_04[{index}]' value='' size='25' class='forme' > </td>
	<td><input type='text' name='passport_04[{index}]' value='' size='15' class='forme'  ></td>
	<td><input type='text' id='dob_04_{index}' name='dob_04[{index}]' value='' size='15' class='forme' >  
	<a href='#' onClick=\"cal1xx.select(document.form_new_arrangement.dob_04_{index},'anchor34{index}','dd-MM-yyyy'); return false;\" name='anchor34{index}' id='anchor34{index}'><img src='images/icon_cal.gif' border='0'></a></td>
	<td>".html_get_selectGender( 'gender_04[{index}]' )."</td>
	</tr>
	
	</table>
	
	</td>
	</tr>
	
	<tr><td colspan='6'><img src='images/blank.gif' border='0'></td></tr>
	</table>
	</form>
	";

?>
<link href="lib/style.css" rel="stylesheet">
<body>
<style>
label{
	display: inline-block;
	float: left;
	width: 120px;
	text-align: left;
	padding-bottom: 5px;
	padding-right:10px;
}
.short_label {
	width: 20px;
}
.medium_label {
	width: 60px;
}
input, textarea, select {
	display: block;
	float: left;
	margin-bottom: 3px;

}
p {
	clear:both;
}
.ui-tabs-vertical { width: 100%; }
.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em;  border-right-width: 1px; }
.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: left; width: 80%;}
</style>
<link rel="stylesheet" href="lib/js/jquery-ui/jquery-ui.css">
<script type="text/javascript" src="lib/js/jquery-ui/external/jquery/jquery.js"></script>
<script type="text/javascript" src="lib/js/jquery-ui/jquery-ui.js"></script>

<script language="JavaScript" src="lib/js/forcenumeric.js"></script>

<script language="JavaScript" src="lib/CalendarPopup.js"></script>
<script language="JavaScript" id="jscal1xx">
var cal1xx = new CalendarPopup("div_travel_calendar");
var cal1xy = new CalendarPopup("div_travel_calendar_enddate");

cal1xx.setYearSelectStartOffset(100);

cal1xx.showNavigationDropdowns();
cal1xy.showNavigationDropdowns();


</script>
<script type="text/javascript">
document.write(getCalendarStyles());
</script>

<script type="text/javascript">

OBJ_ROOMS_ITEMS_AVAILABLE = [];
OBJ_CURRENT_ROOMS_LIST = [];

function cal_trigger_onTravelEnd(y, m, d) {
	var date = d + '-' + m + '-' +y;
	$("input[name=travel_date_end]").val( date );
	$("input[name=travel_night]").val( '' );
	updateTravelDates( "input[name=travel_date_start]", "input[name=travel_date_end]", "input[name=travel_night]");
	is_reservation_container_ready(false);
}
//called before commiting form
function is_reservation_resource_available( checkin, night ) {
	var blnresult = false;
	$.ajax({
		method: "GET",
		url: "reservation.booking.ajax.php", 
		data: {action: 'get_rooms_items', checkin: checkin, night: night},
		async: false,
		
	}).done( function( indata ){
		var obj = $.parseJSON( indata );
		if( obj.result ) {
			if ( parseInt( OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms ) > parseInt( obj.result.num_rooms ) ) {
				alert("Room Availability Has Changed. Please Remove Some Reservation(s)." );
			}
			else if ( parseInt( OBJ_ROOMS_ITEMS_AVAILABLE.num_mattress ) > parseInt( obj.result.num_mattress ) ) {
				alert("Extra Mattress(es) Availability Has Changed. Please Remove Some Extra Mattress(es)." );
			}
			else if ( parseInt( OBJ_ROOMS_ITEMS_AVAILABLE.bedtypes['DBL'] ) > parseInt( obj.result.bedtypes['DBL'] ) ) {
				alert("DBL Room(s) Availability Has Changed. Please Remove Some DBL Room(s)." );
			}
			//testing
			else if ( parseInt( OBJ_ROOMS_ITEMS_AVAILABLE.room_types['STD'] ) > parseInt( obj.result.room_types['STD'] ) ) {
				alert("STD Room(s) Availability Has Changed. Please Remove Some STD Room(s)." );
			}
			else if ( parseInt( OBJ_ROOMS_ITEMS_AVAILABLE.room_types['DLX'] ) > parseInt( obj.result.room_types['DLX'] ) ) {
				alert("CHA Room(s) Availability Has Changed. Please Remove Some DLX Room(s)." );
			}
			else {
				
				blnresult = true;
			}
		}
		else {
			alert("Unable To Confirm Reservation Resource. Please Try Submitting Again." );
		}
		
	});	

	return blnresult;
}

function copy_travel_info ( index ) {
	$("input[name=checkin\\["+index+"\\]]").val( $("input[name=travel_date_start]").val() );
	$("input[name=night\\["+index+"\\]]").val( $("input[name=travel_night]").val() );
	$("input[name=checkout\\["+index+"\\]]").val( $("input[name=travel_date_end]").val() );
	
	$("input[name=guest_name_01\\["+index+"\\]]").val( $("input[name=contact_name]").val() + " ("+index+")" );
		
}

// function checkDate() {

//     var EnteredDate =  $('input[name=travel_date_start]').val();
//     var date = EnteredDate.substring(0, 2);
//     var month = EnteredDate.substring(3, 5);
//     var year = EnteredDate.substring(6, 10);

//     var myDate = new Date(year, month - 1, date);

//     var today = new Date();

//     if (myDate < today) {
//     	is_reservation_container_ready(false);
//     	alert("Entered date is less than today's date ");
//     }
//     else
//     	is_reservation_container_ready(true);
// }

function get_room_items_availability( blnForcePass ) {
	var blnresult =false;
	var travel_start = $('input[name=travel_date_start]').val();
	var travel_end = $('input[name=travel_date_end]').val();
	var night = $('input[name=travel_night]').val();
//	var today_date = "<?= date('d-m-Y') ?>"; 

	if( travel_start != '' && travel_end != '' || night != '' ){
		$.ajax({
			method: "GET",
			url: "reservation.booking.ajax.php", 
			data: {action: 'get_rooms_items', checkin: travel_start, night: night },
			async: false,
				
		}).done( function( indata ){	

			var obj = $.parseJSON( indata );
			if( obj.result ) {
				OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms = obj.result.num_rooms;
				OBJ_ROOMS_ITEMS_AVAILABLE.num_mattress = obj.result.num_mattress;
				OBJ_ROOMS_ITEMS_AVAILABLE.num_baby_cot = obj.result.num_baby_cot;
				OBJ_ROOMS_ITEMS_AVAILABLE.bedtypes = obj.result.bedtypes;
				//OBJ_ROOMS_ITEMS_AVAILABLE.room_types = obj.result.room_types;
				OBJ_ROOMS_ITEMS_AVAILABLE.bedtype_room_list = obj.result.bedtype_room_list;
				OBJ_CURRENT_ROOMS_LIST = obj.result.bedtype_room_list;	
				OBJ_ROOMS_ITEMS_AVAILABLE.promo_code = obj.result.promo_code;

				$('input[name=num_rooms_avail]').val( OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['STD'] + OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['DLX'] );
				$('input[name=num_mattress_avail]').val( OBJ_ROOMS_ITEMS_AVAILABLE.num_mattress );
				$('input[name=num_baby_cot_avail]').val( OBJ_ROOMS_ITEMS_AVAILABLE.num_baby_cot );
				$('input[name=num_room_dbl_avail_std]').val( OBJ_ROOMS_ITEMS_AVAILABLE.bedtype_room_list['STD']['DBL'].length );
				$('input[name=num_room_dbl_avail_dlx]').val( OBJ_ROOMS_ITEMS_AVAILABLE.bedtype_room_list['DLX']['DBL'].length );
				$('input[name=num_room_std_avail]').val( OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['STD'] );
				$('input[name=num_room_dlx_avail]').val( OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['DLX'] );
				  
				  
				if( (OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['STD'] + OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['DLX']) <= 0 ) {
					is_reservation_container_ready( false );
					alert("No Rooms Available Between " + travel_start + " And " + travel_end + ". Please Choose Another Period." );
				}
// 				else if( travel_start < today_date  ){
// 					checkDate();
// 				}
				else {
					is_reservation_container_ready(true);
					blnresult = true;
				}
			}
				//console.dir(OBJ_ROOMS_ITEMS_AVAILABLE);
		});	
		
	}
	else {
		alert('Please Fill In Travel Start, Staying Night(s) & Travel End Dates');
	}

	return blnresult;
}

function disable_room_no(index){
	
	var user_type = <?= json_encode($user_type);?>;
    if( user_type == 'Consultant' ){
    	$("select[name=room_no\\["+index+"\\]]").attr('disabled',true);
 	} 
}

function is_reservation_container_ready( blnForce ) {
	blnForce = typeof blnForce !== 'undefined' ? blnForce : true;
	var blnresult = false;
	var travel_start = $('input[name=travel_date_start]').val();
	var travel_end = $('input[name=travel_date_end]').val();
	var night = $('input[name=travel_night]').val();

	
	if( blnForce && ( travel_start != '' && travel_end != '' && night != ''  ) ) {
		blnresult = true;
		$('#div_reservation_container *').removeAttr('disabled');
		$('input[name=save_all]').removeAttr('disabled').show();
		$('input[name=checkin_all]').removeAttr('disabled').show();
	}
	else {

		$('#div_reservation_container *').attr('disabled', 'disabled');
		$('input[name=save_all]').attr('disabled', 'disabled').hide();
		$('input[name=checkin_all]').attr('disabled', 'disabled').hide();
		
	}
	
	return blnresult;
}


function clearTravelDates() {
	$('input[name=travel_night]').val('');
	$('input[name=travel_date_start]').val('');
	$('input[name=travel_date_end]').val('');
	
	is_reservation_container_ready();
}

function clearReservationDates( index ){

	$("input[name=night\\["+index+"\\]]").val('');
	$("input[name=checkin\\["+index+"\\]]").val('');
	$("input[name=checkout\\["+index+"\\]]").val('');
	

}

//datestring d-m-Y reformat to date acceptable in Date object
function reFormatDate ( datestring ) {
	var datesplit = datestring.split("-");
	var date = [datesplit[1], datesplit[0],datesplit[2]]; 
	date = date.join("/"); //format m-d-Y	
	var formatdate = new Date( date );
	return formatdate;
		
}


function updateTravelDates( start_field, end_field, night_field ){
	
	var nights = $( night_field ).val();
	var travel_start = $( start_field ).val();
	var travel_end = $( end_field ).val();

	//update checkout date
	if ( travel_start != '' &&  nights != '' ){
		nights = parseInt( nights );
		var datesplit = travel_start.split("-");
		var date = [datesplit[1], datesplit[0],datesplit[2]]; 
		date = date.join("/"); //format m-d-Y	
		var checkoutdate = new Date( date );
		checkoutdate.setDate(checkoutdate.getDate() + nights);
		$( end_field ).val( [checkoutdate.getDate(),checkoutdate.getMonth()+1,checkoutdate.getFullYear()].join('-') );
	}
	//update nights
	else if ( travel_start != '' &&  travel_end != '' ) {
		var arr_date_in = travel_start.split("-");
		var date_in = new Date([arr_date_in[1], arr_date_in[0], arr_date_in[2]].join("/"));
		var arr_date_end = travel_end.split("-");
		var date_end = new Date([arr_date_end[1], arr_date_end[0], arr_date_end[2]].join("/"));
		var diff_nights = ( date_end - date_in ) / ( 1000 * 60 * 60 * 24 ) ;

		$( night_field ).val( diff_nights );
	}
	//update checkin date
	else if ( travel_end != '' &&  nights != '' ){ 
		nights = parseInt( nights );
		var datesplit = travel_end.split("-");
		var date = [datesplit[1], datesplit[0],datesplit[2]]; 
		date = date.join("/"); //format m-d-Y	
		var checkindate = new Date( date );
		checkindate.setDate(checkindate.getDate() - nights);

		$( start_field ).val( [checkindate.getDate(),checkindate.getMonth()+1,checkindate.getFullYear()].join('-') );
		
	}
	
	
}

$(document).ajaxStart(function() {
	$("#loading").show();
}).ajaxStop(function () {
	$("#loading").hide();
});


function update_dropdown_options( elem_id, arr_values, selected_index ){

	var $el = $( elem_id );
	$el.empty(); // remove old options
	
	$.each( arr_values, function( key, value ) {
		if( key != '' && key == selected_index ){
			$el.append( $("<option></option>").attr('selected', true).attr("value", value).text(value) );
		}
		else if ( value != '' ){
			$el.append($("<option></option>").attr("value", value).text(value));
		}
	});

}
function update_roomtype_option( index ){

	var room_selected = $("select[name=room_type\\["+index+"\\]] option:selected").val();	
	var avail_room_type = [];	

	if( OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['DLX'] > 0 ){
		avail_room_type.push( 'DLX' );
	}
	if( OBJ_ROOMS_ITEMS_AVAILABLE.num_rooms['STD'] > 0 ){
		avail_room_type.push( 'STD' );
	}

	update_dropdown_options("select[name=room_type\\["+index+"\\]]" ,avail_room_type, room_selected );

}
$(document).ready(function(){
	$("#loading").hide();
	//force numeric on some inputs
	$("input[name=travel_night], input[name=travel_date_start], input[name=travel_date_end]").forceNumeric();
	
	
	//get true/false when validating all reservations
	function bln_validate_form( blnCheckin ) {
		blnCheckin = typeof blnCheckin !== 'undefined' ? blnCheckin : false;
		var blnresult = true;
		
		//check if arrangement has contact name, nationality, email address, agent filled
		var contact_name = $("input[name=contact_name]").val();
		var contact_email = $("input[name=email]").val();
		var contact_nationality = $("select[name=nation_id]").val();
		var agent = $("select[name=agent_code]").val();
		if( contact_name == '' || contact_nationality == '' || agent == '' ) {
			alert("One Or More Of The Following Fields Is Empty \n\nName\nNationality\nAgent");
			blnresult = false;
		}
		
		//validate email input
		if( blnresult && contact_email != '' ) {
			//var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			var re = /^.{1,}@.{2,}\..{2,}/;
		    blnresult = re.test( contact_email );
			if ( !(blnresult) ) {
				alert( "Email Address Is Invalid! " );
				blnresult = false;
			}
		}
		
		var num_current_reservation =  $('#tabs >ul >li').size();
		if ( blnresult && num_current_reservation > num_rooms) {
			alert("Not Enough Rooms Available For All Reservations");
			blnresult = false;
		}
		//check if num reservation > num available rooms
		var num_rooms = parseInt( $("input[name=num_rooms_avail]").val() );
		var num_current_reservation =  $('#tabs >ul >li').size();
		if ( blnresult && num_current_reservation > num_rooms) {
			alert("Not Enough Rooms Available For All Reservations");
			blnresult = false;
		}
		
		var current_mattress = 0;
		var current_baby_cot = 0;
		for( var i = 0; i < tabCounter; i++ ) {
			if( blnresult && $( "#tabs-" + i ).length ) {
				//check if adult + child field is empty
				var adult = $( "input[name=adult\\[" + i + "\\]]" ).val() == '' ? 0 : parseInt( $( "input[name=adult\\[" + i + "\\]]" ).val() );
				var child = $( "input[name=child\\[" + i + "\\]]" ).val() == '' ? 0 : parseInt( $( "input[name=child\\[" + i + "\\]]" ).val() );			
				if( blnresult && adult <= 0 && child <= 0) {
					alert("Reservation " + i + ": No of Pax Field Is Empty");
					blnresult = false;
					break;
				}
				
				//check reservation travel period is not empty and is between travel start and travel end dates
				var checkin = $("input[name=checkin\\["+i+"\\]]").val();
				var checkout = $("input[name=checkout\\["+i+"\\]]").val();
				if( blnresult && ( checkin == '' || checkout == '' ) ) {
					alert("Reservation " + i + ": Checkin / Checkout Field Is Empty");
					blnresult = false;
					break;
				}

				var date_travel_start = reFormatDate( $("input[name=travel_date_start]").val() );
				var date_travel_end = reFormatDate( $("input[name=travel_date_end]").val() );
				var date_checkin = reFormatDate( checkin );
				var date_checkout = reFormatDate( checkout );
				if( blnresult && ( date_checkin < date_travel_start || date_checkin > date_travel_end 
					|| date_checkout < date_travel_start || date_checkout > date_travel_end ) ) {
					alert("Reservation " + i + ": Checkin / Checkout Dates Not Within Travel Dates");
					blnresult = false;
					break;
				}

				//check if bed type is set
				if ( blnresult && $("select[name=bed_type\\["+i+"\\]] option:selected").val() == '' ) {
					alert("Reservation " + i + ": Bed Type Not Set");
					blnresult = false;
					break;
				}

				//check that reservation has guest name_01 filled
				if( blnresult &&( $("input[name=guest_name_01\\["+i+"\\]]").val() == '' ) ){
					alert("Reservation " + i + ": No Guest Name For This Reservation");
					blnresult = false;
					break;
				}
				
				//add to total mattress if checked
				if( blnresult && $("input[name=extra_mattress\\["+i+"\\]]").prop("checked") == true){
					current_mattress += 1;	
				}
				
				//add to total total baby cot if checked
				if( blnresult && $("input[name=baby_cot\\["+i+"\\]]").prop("checked") == true){
					current_baby_cot += 1;	
				}
				
				if ( blnCheckin ) {
					
					//check if checkin date is today's date
					var today_date = "<?= date('d-m-Y') ?>";
					if( blnresult && checkin != today_date ) {
						alert("Reservation " + i + ": This guest should check-in on " + today_date ); 
						blnresult = false;
						break;
					}
					//check if room number is filled before check-in
					var cur_room = $("select[name=room_no\\["+i+"\\]]").val();
					if( blnresult && cur_room == '' ) {
						alert("Reservation " + i + ": Room Number Is Empty!"); 
						blnresult = false;
						break;
					}
					
					
				}
				
			}
		}
		
		//check if reservations extra mattress > num mattress available
		var num_mattress = parseInt( $("input[name=num_mattress_avail]").val() );
		if ( blnresult && current_mattress > num_mattress ) {
			alert("Not Enough Mattresses Available For All Reservations");
			blnresult = false;
		}
		
		//check if reservation baby cot > num baby_cot available
		var num_baby_cot = parseInt( $("input[name=num_baby_cot_avail]").val() );
		if ( blnresult && current_baby_cot > num_baby_cot ) {
			alert("Not Enough Baby Cot Available For All Reservations");
			blnresult = false;
		}
	
		return blnresult;
	}
	
	
		
	
	function updateTotalPax() {
		var adults = 0, childs = 0;
		for( var i = 1; i <= tabCounter; i++ ) {
			if( $( "#tabs-" + i ).length ) {
				adults += ( $("input[name=adult\\["+i+"\\]]").val() == '' ) ? 0 : parseInt( $("input[name=adult\\["+i+"\\]]").val() );
				childs += ( $("input[name=child\\["+i+"\\]]").val() == '' ) ? 0 : parseInt( $("input[name=child\\["+i+"\\]]").val() );
			}
		}
		//if the tab is closed, update the total pax 
		$( "input[name=travel_adult]" ).val( adults );
		$( "input[name=travel_child]" ).val( childs );
		
	}

	//Promo code available within the period
	function populate_promo_code ( index ){
		
		var promo_code =  OBJ_ROOMS_ITEMS_AVAILABLE.promo_code;
		var option = '';
		for( var i = 0; i < promo_code.length; i++ ) {
			option += '<option value="'+ promo_code[i] + '">' + promo_code[i] + '</option>';
		}
		$("select[name=promo_code\\["+index+"\\]]").append(option);	
	}
	
	//refresh active tab room list
	function refreshRoomSelectList( index ){
		var room_elem = $("select[name=room_no\\["+index+"\\]]");
		var bedtype_elem = $("select[name=bed_type\\["+index+"\\]]");
		//var roomtype_elem = $("select[name=room_type\\["+index+"\\]]");
	
		var current_reservation_room = room_elem.val();
		var current_reservation_bedtype = bedtype_elem.val();
		//var current_reservation_roomtype = roomtype_elem.val(); 

		var toRemove = [];
		//if ( current_reservation_room != '' ){
			for( var i = 1; i <= tabCounter; i++ ) {
				if( $( "#tabs-" + i ).length ) {
					cur_room = $("select[name=room_no\\["+i+"\\]]").val();
					if( cur_room != '' && cur_room != current_reservation_room ) toRemove.push( cur_room );
						
				}
			}
			
			cur_room_list = OBJ_CURRENT_ROOMS_LIST[current_reservation_bedtype].filter( function( el ) {
				return toRemove.indexOf( el ) < 0;
			});
						
			if( cur_room_list.length > 0 ){

				room_elem.empty(); // remove old options
				room_elem.append($("<option></option>").attr("value", "").text( "---" ) ); 
				$.each( cur_room_list, function(value, key) {
					room_elem.append($("<option></option>").attr("value", key).text( key ) );
				});
				//select current value
				room_elem.val( current_reservation_room );
			}
			else {
				room_elem.empty(); // remove old options
				room_elem.append($("<option></option>").attr("value", "").text( "---" ) ); 

			}
		//}
	}
	
	function is_mattress_available( bln_test_after_threshold ){
		bln_test_after_threshold = typeof bln_test_after_threshold !== 'undefined' ? bln_test_after_threshold : true;
		var blnresult = true;
		var current_mattress = 0;
		var num_mattress = parseInt( $("input[name=num_mattress_avail]").val() );
		for( var i = 1; i <= tabCounter; i++ ) {
			if( $( "#tabs-" + i ).length) {
				if( $("input[name=extra_mattress\\["+i+"\\]]").prop("checked") == true){
					current_mattress += 1;	
				}
			}
		}
		if ( bln_test_after_threshold ) {
			if ( current_mattress > num_mattress ) blnresult = false;
		}
		else {
			if ( current_mattress >= num_mattress ) blnresult = false;
		}

		return blnresult;
	}
	function is_baby_cot_available( bln_test_after_threshold ){
		bln_test_after_threshold = typeof bln_test_after_threshold !== 'undefined' ? bln_test_after_threshold : true;
		var blnresult = true;
		var current_num = 0;
		var num_available = parseInt( $("input[name=num_baby_cot_avail]").val() );
		for( var i = 1; i <= tabCounter; i++ ) {
			if( $( "#tabs-" + i ).length) {
				if( $("input[name=baby_cot\\["+i+"\\]]").prop("checked") == true){
					current_num += 1;	
				}
			}
		}
		if ( bln_test_after_threshold ) {
			if ( current_num > num_available ) blnresult = false;
		}
		else {
			if ( current_num >= num_available ) blnresult = false;
		}

		return blnresult;
	}
	
	function toggle_addons( index ) {
		var bedtype = $("select[name=bed_type\\["+index+"\\]]").val();

		//only DBL and TWN can have extra mattress
		if( is_mattress_available( false ) && bedtype != '' && ( bedtype == 'DBL' || bedtype == 'TWN'  ) ) {
			$( "input[name=extra_mattress\\["+index+"\\]]" ).removeAttr('disabled');			
		}
		else {
			//$( "input[name=extra_mattress\\["+index+"\\]]" ).prop('checked', false); // Unchecks it
			if( !$( "input[name=extra_mattress\\["+index+"\\]]" ).prop('checked') ){
				$( "input[name=extra_mattress\\["+index+"\\]]" ).attr('disabled', 'disabled');
				tabs.tabs( "refresh" );
			}
			
		}
		if( is_baby_cot_available( false ) ) {
			$( "input[name=baby_cot\\["+index+"\\]]" ).removeAttr('disabled');			
		}
		else {
			//$( "input[name=baby_cot\\["+index+"\\]]" ).prop('checked', false); // Unchecks it
			if( !$( "input[name=baby_cot\\["+index+"\\]]" ).prop('checked') ){
				$( "input[name=baby_cot\\["+index+"\\]]" ).attr('disabled', 'disabled');
				tabs.tabs( "refresh" );
			}
		}
		
	}
	function is_room_bedtype_available( bedtype ) {
		var cur_room, cur_bedtype, cur_roomtype;
		var blnresult = true;
		var room_count = 0;
		var comp_count = 0;
		
		if ( OBJ_CURRENT_ROOMS_LIST.hasOwnProperty( bedtype ) ) {
			for( var i = 1; i <= tabCounter; i++ ) {
				if( $( "#tabs-" + i ).length) {
					cur_bedtype = $("select[name=bed_type\\["+i+"\\]]").val();
					
					if( cur_bedtype == 'COMP' ){
						comp_count++;
					}
					
					if( cur_bedtype == bedtype ){
						room_count++;
					}
				}
			}

			//COMP rooms reserve rooms in this order TWN-> DBL 
			//if we have COMP rooms, make sure they do not exceed room availability for its bedtype respectively
			if( comp_count > 0 ){
				var twn_limit = parseInt(OBJ_ROOMS_ITEMS_AVAILABLE.bedtypes['TWN']);
				var dbl_limit = parseInt(OBJ_ROOMS_ITEMS_AVAILABLE.bedtypes['DBL']);
				
				if( comp_count > (twn_limit + dbl_limit) ) blnresult = false;
			}
			
			
			//room_limit = parseInt(OBJ_CURRENT_ROOMS_LIST[bedtype].length);
			room_limit = parseInt(OBJ_ROOMS_ITEMS_AVAILABLE.bedtypes[bedtype]);

			if ( room_count > room_limit ) blnresult = false;

		}

		return blnresult;	
	}

	//function to update room list on new tabs
	function updateRoomSelectList( index, bedtype ) {
		var elem = $("select[name=room_no\\["+index+"\\]]");
		var room_type = $("select[name=room_type\\["+index+"\\]]");
		
		var current_reservation_room = elem.val();		
		if( bedtype != '' ){
			//check all reservation if any room number has been taken
			var toRemove = [];
			var cur_room;
			for( var i = 1; i <= tabCounter; i++ ) {
				if( $( "#tabs-" + i ).length ) {
					cur_room = $("select[name=room_no\\["+i+"\\]]").val();
					if( cur_room != '' && cur_room != current_reservation_room) toRemove.push( cur_room );
					
				}
			}
			
			cur_room_list = OBJ_CURRENT_ROOMS_LIST[bedtype].filter( function( el ) {
				return toRemove.indexOf( el ) < 0;
			});
		
			if( cur_room_list.length > 0 ){
				elem.empty(); // remove old options
				elem.append($("<option></option>").attr("value", "").text( "---" ) ); 
				$.each( cur_room_list, function(value, key) {
					elem.append($("<option></option>").attr("value", key).text( key ) );
				});
			}
			else {
				elem.empty();
				elem.append($("<option></option>").attr("value", "").text( "---" ) ); 
				alert("Room " + bedtype + " Is Fully Booked!");
				$("select[name=bed_type\\["+index+"\\]] option[value='']").prop('selected', true);
				updateRoomSelectList( index, '' );
			}		
		}		
	}

// 	function populate_select_room_type ( select_type, select_element ){
// 		select_element.empty();
// 		var data;
// 		if( select_type == 'STD' ){
			data = <?= json_encode( $arr_std_room_type );?>;
// 		}
// 		else if( select_type == 'CHA' ){
			data = <?= json_encode( $arr_cha_room_type );?>;
// 		}
// 			$.each(data, function() {
// 			select_element.append(new Option(this.type, this.type));
// 		});
// 		tabs.tabs( "refresh" );		
// 	}

	// actual addTab function: adds new tab using the input from the form above
	function addTab() {
		
		var reservation_form = <?= json_encode(utf8_encode($reservation_details_form_inputs)); ?>;
		var label = tabTitle.val() || "Reservation " + tabCounter,
		id = "tabs-" + tabCounter,
		li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
		tabContentHtml = tabContent.val() ||reservation_form.replace( /{index}/g, tabCounter );
		
		
		$('#tabs').show();
		
		tabs.find( ".ui-tabs-nav" ).append( li );
		tabs.append( "<div id='" + id + "'><p>" + tabContentHtml + "</p></div>" );
		
		tabs.tabs( "refresh" );
		tabs.tabs( "option", "active", tabCounter);
		tabs.tabs( "option", "collapsible", false );
		
		//force numeric on some inputs
		$("input[name=adult\\["+tabCounter+"\\]], input[name=child\\["+tabCounter+"\\]], input[name=checkin\\["+tabCounter+"\\]], input[name=checkout\\["+tabCounter+"\\]], input[name=night\\["+tabCounter+"\\]], input[name=dob_01\\["+tabCounter+"\\]], input[name=dob_02\\["+tabCounter+"\\]], input[name=dob_03\\["+tabCounter+"\\]], input[name=dob_04\\["+tabCounter+"\\]]").forceNumeric();
		
		//force to set adult = 1 on new reservation
		$("input[name=adult\\["+tabCounter+"\\]]").val('1');
		updateTotalPax();
		
		tabCounter++;
		
	}

	var tabTitle = $( "#tab_title" ),
		tabContent = $( "#tab_content" ),
		tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
		tabCounter = 1;
	var tabs = $( "#tabs" ).tabs();
	//add the first reservation form
	addTab();
	var ready= is_reservation_container_ready();	
	//for vertical tabs
	$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix " );
	$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	
	
	 // close icon: removing the tab on click
	tabs.delegate( "span.ui-icon-close", "click", function(event) {
		if ( $('#tabs >ul >li').size() <= 1 ){
			event.stopImmediatePropagation();
			return false;
			
		}
		var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
		$( "#" + panelId ).remove();
		
		tabs.tabs( "refresh" );
	});
	
	tabs.bind( "keyup", function( event ) {
		if ( $('#tabs >ul >li').size() <= 1){
			event.stopImmediatePropagation();
			return false;
		}
		if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
			var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
			$( "#" + panelId ).remove();
			tabs.tabs( "refresh" );
		}
	});
	
	tabs.on('tabsactivate', function(event, ui) { 
		var selector = ui.newPanel.selector;
		var number_matches = selector.match(/[0-9]+/g);
		var index = number_matches[0];

		toggle_addons( index );
		//refresh room list if other 'new' reservation has already selected the on in its current list
		refreshRoomSelectList(index);



	});

	$("input[name=bttn_add_reservation]").click( function(event) {
		var num_room_avaialble = $("input[name=num_rooms_avail]").val();
		var num_rooms = parseInt( num_room_avaialble );
		var num_current_reservation =  $('#tabs >ul >li').size();
		
		if ( num_current_reservation < num_rooms) {
			addTab();
			copy_travel_info( tabCounter - 1 );//offset tabCounter by 1 as tabCounter always increases on each new tab
			disable_room_no( tabCounter - 1 );//Disable room_no selection for TC
			populate_promo_code( tabCounter - 1 ); 
			update_roomtype_option( tabCounter - 1 ); 
			tabs.tabs({ active: -1 }); //activate the newly created tab
			refreshRoomSelectList( tabCounter );
			
		}
		else {			
			alert( 'Cannot Enter New Reservation As Max Available Rooms Reached.' );
		}
	});
	

	
	$("input[name=bttn_check_availability]").click( function( event ) {
//		$("#loading").show();
		if ( get_room_items_availability() && tabCounter == 2 ) {
			var index = tabCounter - 1; //refer to first reservation form
			toggle_addons( index );
			copy_travel_info( index ); 
			disable_room_no( index );
			populate_promo_code( index );
			update_roomtype_option( index );
		}
		
	});
	
	$("form[name=form_new_arrangement]").on( 'change', "input.night", function(event) {
		var name = $(this).attr('name');
		//travel dates
		if( name == 'travel_night'){
			updateTravelDates( "input[name=travel_date_start]", "input[name=travel_date_end]", "input[name=travel_night]");
			is_reservation_container_ready(false);
		}
		//reservation dates
		else{
			var number_matches = name.match(/[0-9]+/g);
			var index = number_matches[0];
			updateTravelDates( "input[name=checkin\\["+index+"\\]]", "input[name=checkout\\["+index+"\\]]", "input[name=night\\["+index+"\\]]");
		}

	});
	
	$("form[name=form_new_arrangement]").on( 'change', "input.pax_r_adult, input.pax_r_child", function(event) {
		updateTotalPax();
	});
	
	$("form[name=form_new_arrangement]").on( 'change', "select.bed_type", function(event) {
		var bedtype = $(this).val();
		var name = $(this).attr('name');
		var number_matches = name.match(/[0-9]+/g);
		var index = number_matches[0];
		var roomtype = $("select[name=room_type\\["+index+"\\]]").val();
		var num_rooms = $('input[name=num_rooms_avail]').val();
		if( bedtype != '' ) {
	
			if( bedtype == 'COMP' ){
				if( OBJ_ROOMS_ITEMS_AVAILABLE.bedtypes['TWN'].length > 0 && num_rooms > 0 ){
					bedtype = 'TWN';
				}
			}
			
			if ( is_room_bedtype_available( bedtype ) && num_rooms > 0 ){
				updateRoomSelectList( index, bedtype );
				toggle_addons( index );
			}
			else {
				$(this).val('');
				alert("Room " + bedtype + " Max Limit Reached");
				updateRoomSelectList( index, '' );
				toggle_addons( index );
				
			}
		}
		else {
			toggle_addons( index );
		}
		
	});
	
	$("form[name=form_new_arrangement]").on( 'change', "input.extra_mattress", function(event) {
		if( $(this).is(":checked") && !( is_mattress_available() ) ) {
			alert("Mattress Max Limit Reached");
			$(this).prop('checked', false);
	    }
	});

	
	$(" input[name=save_all], input[name=checkin_all] ").click( function(event) {
		var name = $(this).attr('name');
		$("input[name=counter_reservations]").val( tabCounter - 1 );
		var travel_start = $('input[name=travel_date_start]').val();
		var night = $('input[name=travel_night]').val();
		var blnCheckin = false;
		
//		$("#loading").show();
		
		if( name == 'checkin_all' ){
			var ans = confirm("Proceed To Check-In All Guest(s)?");
			if( ans ) blnCheckin = true;
			
			if( blnCheckin && ans ) {
				$("input[name=submit_checkin_all]").val( '1' );
				if( !( bln_validate_form( blnCheckin ) &&  is_reservation_resource_available( travel_start, night ) ) ) {
					event.preventDefault();
//					$("#loading").hide();
					$("input[name=submit_checkin_all]").val( '0' );
				}
			}
			else if ( ans != true){
				event.preventDefault();
//				$("#loading").hide();
				$("input[name=submit_checkin_all]").val( '0' );
			}
			
			
		}
		else {
			$("input[name=submit_checkin_all]").val( '0' );
			if( !( bln_validate_form() &&  is_reservation_resource_available( travel_start, night ) ) ) {
				event.preventDefault();
//				$("#loading").hide();
				$("input[name=submit_checkin_all]").val( '0' );
			}
		}
		
		
	});
	
	//$( "select[name*=room_type\\[]" ).change(function(event){
// 	$( "form[name=form_new_arrangement]" ).on( "change", "select[name*=room_type\\[]",function( event ) {
// 		var index = $(this).index("select[name*=room_type\\[]");
// 		var select_element = $( "select[name*=bed_type\\[]:eq("+index+")" );
		
// 		populate_select_room_type( $(this).val(), select_element );
// 		updateRoomSelectList( index + 1, select_element.val() ); //tab index starts from 1, not zero based
// 		tabs.tabs( "refresh" );		
// 	});	
 
});
</script>


<div>
<div id="div_travel_calendar" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;z-index:99;"></div>
<div id="div_travel_calendar_enddate" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;z-index:99;"></div>
<div id="loading"></div>
<form name="form_new_arrangement" action="reservation.booking.new.php" method="post">

<input readonly type='hidden' name='counter_reservations' value='0' />
<input readonly type='hidden' name='submit_checkin_all' value='0' />
<table border="0" align="center" width="90%" cellpadding="3" cellspacing="0" class="tblForm" id="arrangement_tableForm">
<tr>
<td class="header" width="3%" align="center"><img src="images/button.gif" border="0"> </td>
<td class="header" colspan="5" style="border-top:1px solid #296DC1;"><strong>ARRANGEMENT DETAILS</strong></td>
</tr>

<tr><td colspan="6"><img src="images/blank.gif" border="0"></td></tr>

<tr>
<td colspan='3' style="padding-left:50px;">
<p><label for="contact_name">*Name</label><input name="contact_name" type="text" value="" ></p>
<p><label for="address">Address</label><textarea name="address" cols="50" rows="3" ><?=$address?></textarea> </p>
<p><label for="email">Email</label><input name="email" type="text" value="<?=$email?>" size="30"></p>
<p><label for="nation_id">*Nationality</label>
<?php
$sql_nation = db_query("SELECT nation_id,description FROM nationality ORDER BY description");
db_select($sql_nation,"nation_id",$nation_id,""," ","","");
?></p>
<p><label for="remark">Remarks</label><textarea name="remark" cols="50" rows="3" ><?=$remark?></textarea></p>


</td>
<td colspan='3'>
<p><label for='arrangement_date'>Booking Date</label><input style='border:0;' type='text' name='arrangement_date' value='<?= $todaydate; ?>' /></p>
<p><label for='arrangement_no'>Arrangement No.</label><input style='border:0;' type='text' name='arrangement_no' value='<?= $arrangement_no; ?>' /></p>
<p><label>Tour Consultant</label><strong><?=stripslashes(itemName("SELECT username FROM user WHERE id='".$_SESSION['valid_userid']."'"))?></strong><input type="hidden" name="tour_cons" value="<?=$_SESSION['valid_userid']?>"></p>
<p><label for='agent_code'>*Agent</label>
<?php
	$sql_agent = db_query("SELECT code,description FROM agent_info ORDER BY description");
	db_select($sql_agent,"agent_code",$agent_code,""," ","","");
?>
</p>
<p><label for='travel_date_start'>*Check-in</label><input type="text" name="travel_date_start" value="" size="15" readonly  /> <a href="#" onClick="cal1xx.select(document.form_new_arrangement.travel_date_start,'anchor1xx','dd-MM-yyyy'); clearTravelDates(); return false;" name="anchor1xx" id="anchor1xx"><img src="images/icon_cal.gif" border="0"></a></p>
<p><label for='night'>*Staying Night(s)</label><input class="night" type="text" name="travel_night" size="3" value="" ></p>
<p><label for='travel_date_end'>*Check-out</label><input  type="text" name="travel_date_end" value="" size="15" readonly ><a href="#" onClick="cal1xy.setReturnFunction('cal_trigger_onTravelEnd');cal1xy.select(document.form_new_arrangement.travel_date_end,'anchor1xy','dd-MM-yyyy'); return false;" name="anchor1xy" id="anchor1xy"><img src="images/icon_cal.gif" border="0"></a><input type='button' style='float:none;display:inline-block; margin: -15px 0 0 15px;' class='button' name='bttn_check_availability' value='Check Availability'/></p>
<p><label>Total Pax</label><input readonly name="travel_adult" type="text" style="border:none;" value="0" size="3"><label class='short_label'>A</label> <input readonly name="travel_child" type="text" style="border:none;" value="0" size="3"><label  class='short_label'> C</label></p>





<p style='float:right; margin-right:20px;'>
<input type="submit" style="margin-right:20px;" name="save_all" value="Save All" class="button"  >
<input type="submit" name="checkin_all" value="Checkin All" class="button"  >
</p>
</td>
</tr>


</table>


<table border="0" align="center" width="90%" cellpadding="3" cellspacing="0" class="tblForm" >
<tr>
<td class="header" width="3%" align="center"><img src="images/button.gif" border="0"> </td>
<td class="header" colspan="5" style="border-top:1px solid #296DC1;"><strong>ROOM RESERVATION DETAILS</strong></td>
</tr>

<tr>
<td colspan="6">
<div id="div_reservation_container" style='margin:0 auto; width:95%;'>
    <div >
    <div style='display: inline-block; padding-top:10px; '>
    <label >Available Rooms</label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_rooms_avail' value='0' />     
   	</div>
   	<div style='display: inline-block; padding-top:10px; border-left: medium solid #0000ff;'>
    <label style='padding-left:20px;'>Standard Room: </label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_room_std_avail' value='0' />
    <label class='short_label' style='padding-left:20px;'>DBL: </label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_room_dbl_avail_std' value='0' />
    </div>
    
    <div style='display: inline-block; padding-top:10px; border-left: medium solid #0000ff;'>
    <label style='padding-left:20px;'>Villa Room: </label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_room_dlx_avail' value='0' />
	<label class='short_label' style='padding-left:20px;'>DBL: </label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_room_dbl_avail_dlx' value='0' />	
	</div>
    
    <div style='display: inline-block; padding-top:10px; border-left: medium solid #0000ff;'>
    <label style='padding-left:20px;'>Extra Mattress: </label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_mattress_avail' value='0' />
    <label style='padding-left:20px;'>Baby Cot: </label><input readonly style='display: inline-block; border:none;' class='short_label' name='num_baby_cot_avail' value='0' />
    </div>
    
    <input style="float:none;display:inline-block;margin:-25px 0 0 20px;" class="button" type="button" name="bttn_add_reservation" value="Add New Reservation" /> 
    </div>
    
    <div id="tabs">
         <ul>

         </ul>
    </div>
</div>
</td>
</tr>

</table>
</form>
</div>

</body>
</html>