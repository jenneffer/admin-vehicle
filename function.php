<?php
error_reporting(0);
// select input - retrieve data from database
    function db_select($query,$txt_name,$txt_value,$function,$default,$class,$tabindex, $readonly = NULL, $additional= NULL){
    	echo "<select id='$txt_name' name='$txt_name' onchange='$function' class='$class'  $readonly $additional>\n";
    	if($default <> '') echo "<option value=''>$default</option>\n";
    	while($row = mysqli_fetch_array($query)){
    		if($txt_value == $row[0])
    		echo "<option value='$row[0]' selected>".stripslashes($row[1])."</option>\n";
    		else
    		echo "<option value='$row[0]'>".stripslashes($row[1])."</option>\n";
    	}
    	echo "</select>\n";	
    }
    
    function db_option($query,$default=NULL){
        if($default <> '') echo "<option value=''>$default</option>\n";
        while($row = mysqli_fetch_array($query)){
            if($txt_value == $row[0])
                echo "<option value='$row[0]' selected>".stripslashes($row[1])."</option>\n";
            else
                echo "<option value='$row[0]'>".stripslashes($row[1])."</option>\n";
        }
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
    
    // select input - year list
    function selectYear($txt_name,$txt_value,$function,$default,$class,$tabindex, $additional=NULL){
        $start_y = 2015;
        $end_y = date('Y')+10;
        echo "<select name='$txt_name' onchange='$function' class='$class' $additional>\n";
        if($default <> '') echo "<option value=''>$default</option>\n";
        for($i=$start_y;$i<$end_y;$i++){
            if($txt_value == $i)
                echo "<option value='$i' selected>".$i."</option>\n";
                else
                    echo "<option value='$i'>".$i."</option>\n";
        }
        echo "</select>\n";
    }
    function optionYear($txt_value,$default=NULL){        
        $start_y = 2015;
        $end_y = date('Y')+10;
        if($default <> '') echo "<option value=''>$default</option>\n";
        for($i=$start_y;$i<$end_y;$i++){
            if($txt_value == $i)
                echo "<option value='$i' selected>".$i."</option>\n";
            else
                echo "<option value='$i'>".$i."</option>\n";
        }
    }
    
    // select input - year multiple list
    function selectYearMultiple($txt_name,$txt_value,$function,$default,$class,$tabindex){
        $start_y = 2015;
        $end_y = date('Y')+10;
        echo "<select multiple='multiple' id='$txt_name' name='$txt_name' onchange='$function' class='$class'>\n";
        if($default <> '') echo "<option value=''>$default</option>\n";
        for($i=$start_y;$i<$end_y;$i++){
            if($txt_value == $i)
                echo "<option value='$i' selected>".$i."</option>\n";
                else
                    echo "<option value='$i'>".$i."</option>\n";
        }
        echo "</select>\n";
    }
    
    function selectMonth($txt_name, $txt_value, $function, $default, $class, $tabindex){
        // set the month array
        $formattedMonthArray = array(
            "" => "-Select-",
            "1" => "January", 
            "2" => "February", 
            "3" => "March", 
            "4" => "April",
            "5" => "May", 
            "6" => "June", 
            "7" => "July", 
            "8" => "August",
            "9" => "September", 
            "10" => "October", 
            "11" => "November", 
            "12" => "December",
        );
    
    
        echo "<select name='$txt_name' id='$txt_name' onchange='$function' class='$class'>\n";
        if($default <> '') echo "<option value=''>$default</option>\n";
        foreach ($formattedMonthArray as $key => $month) {
            // if you want to select a particular month
            $selected = ($key == $txt_value) ? 'selected' : '';
            // if you want to add extra 0 before the month uncomment the line below
            //$month = str_pad($month, 2, "0", STR_PAD_LEFT);
            echo "<option $selected value='$key'>".$month."</option>";
        }
        echo "</select>\n";
    }
    
    function itemName($query){
        global $conn_admin_db;
        $sql_query = mysqli_query($conn_admin_db,$query) or die ('Error: '.mysqli_error ($conn_admin_db));
        $item = mysqli_fetch_array($sql_query);          
        return $item[0];
    }
    
    //check pcash status
    function checkStatus($id){
        global $conn_admin_db;
        $query = "SELECT workflow_status FROM om_pcash_request WHERE id='$id'";       
        $sql_query = mysqli_query($conn_admin_db,$query) or die ('Error: '.mysqli_error ($conn_admin_db));
        $item = mysqli_fetch_array($sql_query);
        return $item[0];
    }
    
    function addOrdinalNumberSuffix($num) {
        if (!in_array(($num % 100),array(11,12,13))){
            switch ($num % 10) {
                // Handle 1st, 2nd, 3rd
                case 1:  return $num.'st';
                case 2:  return $num.'nd';
                case 3:  return $num.'rd';
            }
        }
        return $num.'th';
    }
    
    function randomColor(){
        //Create a loop.
        $rgbColor = array();
        foreach(array('r', 'g', 'b') as $color){
            //Generate a random number between 0 and 255.
            $rgbColor[$color] = mt_rand(0, 255);
        }
        $rgbColor = "rgb(".implode(",", $rgbColor).")";
        return $rgbColor;
    }
    
    function get_month_name($month){
        $month_name = "";
        if($month == '1') {
            //                                         	echo "<span style='display:none'>1</span> January";
            $month_name = "January";
        } else if($month == '2') {
            //                                         	echo "<span style='display:none'>2</span> February";
            $month_name = "February";
        } else if($month == '3') {
            //                                         	echo "<span style='display:none'>3</span> March";
            $month_name = "March";
        } else if($month == '4') {
            //                                         	echo "<span style='display:none'>4</span> April";
            $month_name = "April";
        } else if($month == '5') {
            //                                         	echo "<span style='display:none'>5</span> May";
            $month_name = "May";
        } else if($month == '6') {
            //                                         	echo "<span style='display:none'>6</span> June";
            $month_name = "June";
        } else if($month == '7') {
            //                                         	echo "<span style='display:none'>7</span> Jully";
            $month_name = "July";
        } else if($month == '8') {
            //                                         	echo "<span style='display:none'>8</span> August";
            $month_name = "August";
        } else if($month == '9') {
            //                                         	echo "<span style='display:none'>9</span> September";
            $month_name = "September";
        } else if($month == '10') {
            //                                         	echo "<span style='display:none'>10</span> October";
            $month_name = "October";
        } else if($month == '11') {
            //                                         	echo "<span style='display:none'>11</span> November";
            $month_name = "November";
        } else {
            //                                         	echo "<span style='display:none'>12</span> December";
            $month_name = "December";
        }
        return $month_name;        
    }
?>