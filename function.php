<?php
// select input - retrieve data from database
    function db_select($query,$txt_name,$txt_value,$function,$default,$class,$tabindex, $readonly = NULL){
    	echo "<select id='$txt_name' name='$txt_name' onchange='$function' class='$class'  tabindex='$tabindex' $readonly>\n";
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
    
    // select input - year list
    function selectYear($txt_name,$txt_value,$function,$default,$class,$tabindex){
        $start_y = 2011;
        $end_y = date('Y')+10;
        echo "<select name='$txt_name' onchange='$function' class='$class'>\n";
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
        $sql_query = mysqli_query($conn_admin_db,$query) or die ('Error: '.mysqli_error ());
        $item = mysqli_fetch_array($sql_query);
        return $item[0];
    }
?>