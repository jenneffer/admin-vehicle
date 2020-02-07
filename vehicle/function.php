<?php
// select input - retrieve data from database
function db_select($query,$txt_name,$txt_value,$function,$default,$class,$tabindex){
	echo "<select id='$txt_name' name='$txt_name' onchange='$function' class='$class' tabindex='$tabindex'>\n";
	if($default <> '') echo "<option value=''>$default</option>\n";
	while($row = mysqli_fetch_array($query)){
		if($txt_value == $row[0])
		echo "<option value='$row[0]' selected>".stripslashes($row[1])."</option>\n";
		else
		echo "<option value='$row[0]'>".stripslashes($row[1])."</option>\n";
	}
	echo "</select>\n";	
}

// javascript alert & window location
function alert($alert,$location){
	echo "<script type='text/javascript' language='javascript'>\n";
	if($alert <> "")
	echo "alert('$alert');\n";
	if($location <> "")
	echo "window.location=\"$location\";\n";
	echo "</script>\n";
}

//format date from dd-mm-yy to yy-mm-dd
function dateFormat($date){
    $new_date = date('Y-m-d', strtotime($date));    
    return $new_date;
}

//format date from yy-mm-dd to dd-mm-yy
function dateFormatRev($date){
    $new_date = date('d-m-Y', strtotime($date));
    return $new_date;
}
?>