<?php
    require_once('../assets/config/database.php');
    require_once('./function.php');
    session_start();
    global $conn_admin_db;

    if(isset($_POST['save'])){
        $vehicle_reg_no = $_POST['vehicle_reg_no'];               
        $fitness_date = dateFormat($_POST['fitness_date']);
        $roadtax_due_date = dateFormat($_POST['roadtax_due_date']);
        $runner = $_POST['runner'];
        
        $sql_insert = mysqli_query($conn_admin_db, "INSERT INTO vehicle_puspakom SET
                            vv_id = '".$vehicle_reg_no."',
                            vp_fitnessDate = '".$fitness_date."',
                            vp_roadtaxDueDate = '".$roadtax_due_date."',                            
                            vp_runner = '".$runner."',                            
                            vp_lastUpdated = now()");
                                   
        alert ("Added successfully","puspakom.php");
    }
?>