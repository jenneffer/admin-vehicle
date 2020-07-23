<?php 
require_once('../assets/config/database.php');
require_once('../function.php');
global $conn_admin_db;
session_start();

$action = isset($_POST['action']) && $_POST['action'] !="" ? $_POST['action'] : ""; 
$data = isset($_POST['data']) ? $_POST['data'] : ""; 
$telefon_list = isset($_POST['telefon_list']) ? $_POST['telefon_list'] : "";

if( $action != "" ){
    switch ($action){
        case 'add_management_bill':            
                add_new_management($data);
            break;
        case 'update_management_bill':
            update_management_bill($data);
            break;
            
        case 'add_water_bill':
                insert_billing_water($data);
            break;
            
        case 'update_water_bill':
            update_water_bill($data);
            break;
            
        case 'add_late_interest_charge':
                add_late_interest_charge($data);
            break;
        case 'update_late_interest_charge':
            update_late_interest_charge($data);
            break;
            
        case 'add_quit_rent_billing':
                add_quit_rent_billing($data);
            break;
        case 'update_quit_rent_billing':
            update_quit_rent_billing($data);
            break;
            
        case 'add_premium_insurance':
                add_premium_insurance($data);
            break;            
        case 'update_premium_insurance':
            update_premium_insurance($data);
            break;
        default:
            break;
    }
}

function update_quit_rent_billing($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data    
    $id = $param['item_id'];
    $invoice_no = $param['invoice_no'];
    $invoice_date = $param['invoice_date'];
    $paid_date = $param['paid_date'];
    $charged_amt = $param['charged_amt'];
    $payment_mode = $param['payment_mode'];
    $or_no = $param['or_no'];
    $due_date = $param['due_date'];
    $received_date = $param['received_date'];
    $remark = $param['remark'];
    
    $query = "UPDATE bill_management_quit_rent SET
            inv_no = '$invoice_no',
            invoice_date = '".dateFormat($invoice_date)."',
            payment = '$charged_amt',
            date_paid = '".dateFormat($paid_date)."',
            payment_mode = '$payment_mode',
            or_no = '$or_no',
            due_date = '".dateFormat($due_date)."',
            date_received = '".dateFormat($received_date)."',
            remarks = '$remark' WHERE id='$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function update_management_bill($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data
        $id = $param['item_id'];
        $description = $param['description'];
        $payment = $param['payment'];
        $payment_mode = $param['payment_mode'];
        $cheque_no = $param['cheque_no'];
        $or_no = $param['or_no'];
        $invoice_no = $param['invoice_no'];
        $remark = $param['remark'];
        $payment_date = $param['payment_date'];
        $receive_date = $param['receive_date'];
        
        $query = "UPDATE bill_management_fee SET
            description = '$description',
            payment_amount = '$payment',
            payment_mode = '$payment_mode',
            official_receipt_no = '$or_no',
            ref_no = '$invoice_no',
            cheque_no = '$cheque_no',
            remark = '$remark',
            payment_date = '".dateFormat($payment_date)."',
            received_date = '".dateFormat($receive_date)."' WHERE id='$id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
}

function update_water_bill($data){
    global $conn_admin_db;
    $param = array();
    if(!empty($data)){
        parse_str($data, $param); //unserialize jquery string data
        $item_id = $param['item_id'];
        $invoice_no = $param['invoice_no'];
        $invoice_date = $param['invoice_date'];
        $receive_date = $param['receive_date'];
        $from_date = $param['from_date'];
        $to_date = $param['to_date'];
        $paid_date = $param['paid_date'];
        $due_date = $param['due_date'];
        $description = $param['description'];
        $previous_mr = $param['previous_mr'];
        $current_mr = $param['current_mr'];
        $charged_amt = $param['charged_amt'];
        $surcharge = $param['surcharge'];
        $payment_mode = $param['payment_mode'];
        $or_no = $param['or_no'];
        $total_consume = $current_mr - $previous_mr;
        $total = $charged_amt + $surcharge;
        
        $rounded = round_up($total);
        $adjustment = number_format(($rounded-$total), 2);
        
        $query = "UPDATE bill_management_water SET
                date_from = '".dateFormat($from_date)."',
                date_to = '".dateFormat($to_date)."',
                invoice_no = '$invoice_no',
                invoice_date = '".dateFormat($invoice_date)."',
                due_date = '".dateFormat($due_date)."',
                description = '$description',
                previous_mr = '$previous_mr',
                current_mr = '$current_mr',
                total_consume = '$total_consume',
                charged_amount = '$charged_amt',
                surcharge = '$surcharge',
                adjustment = '$adjustment',
                total = '$total',
                payment_date = '".dateFormat($paid_date)."',
                payment_mode = '$payment_mode',
                or_no = '$or_no',
                received_date = '".dateFormat($receive_date)."' WHERE id='$item_id'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
}

function update_premium_insurance($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    
    $id = $param['item_id'];
    $date_from = $param['date_from'];
    $date_to = $param['date_to'];
    $invoice_no = $param['invoice_no'];
    $charged_amt = $param['charged_amt'];
    $payment_mode = $param['payment_mode'];
    $or_no = $param['or_no'];
    $paid_date = $param['paid_date'];
    $description = $param['description'];
    
    $query = "UPDATE bill_management_insurance SET            
            invoice_no = '$invoice_no',
            description = '$description',
            payment = '$charged_amt',
            payment_mode = '$payment_mode',
            or_no = '$or_no',
            date_paid = '".dateFormat($paid_date)."',
            date_from = '".dateFormat($date_from)."',
            date_to = '".dateFormat($date_to)."' WHERE id='$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo  json_encode($result);
}

function add_premium_insurance($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    
    $acc_id = $param['acc_id'];
    $date_from = $param['date_from'];
    $date_to = $param['date_to'];
    $invoice_no = $param['invoice_no'];
    $charged_amt = $param['charged_amt'];
    $payment_mode = $param['payment_mode'];
    $or_no = $param['or_no'];
    $paid_date = $param['paid_date'];
    $description = $param['description'];
    
    $query = "INSERT INTO bill_management_insurance SET 
            acc_id = '$acc_id',
            invoice_no = '$invoice_no',
            description = '$description',
            payment = '$charged_amt',
            payment_mode = '$payment_mode',
            or_no = '$or_no',
            date_paid = '".dateFormat($paid_date)."',
            date_from = '".dateFormat($date_from)."',
            date_to = '".dateFormat($date_to)."' ";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo  json_encode($result);
}

function add_quit_rent_billing($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    
    $acc_id = $param['acc_id'];
    $invoice_no = $param['invoice_no'];
    $invoice_date = $param['invoice_date'];
    $paid_date = $param['paid_date'];
    $charged_amt = $param['charged_amt'];
    $payment_mode = $param['payment_mode'];
    $or_no = $param['or_no'];
    $due_date = $param['due_date'];
    $received_date = $param['received_date'];
    $remark = $param['remark'];
    
    $query = "INSERT INTO bill_management_quit_rent SET
            acc_id = '$acc_id',
            inv_no = '$invoice_no',
            invoice_date = '".dateFormat($invoice_date)."',
            payment = '$charged_amt',
            date_paid = '".dateFormat($paid_date)."',
            payment_mode = '$payment_mode',
            or_no = '$or_no',
            due_date = '".dateFormat($due_date)."',
            date_received = '".dateFormat($received_date)."',
            remarks = '$remark' ";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function add_late_interest_charge($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    $acc_id = $param['acc_id'];
    $bill_date = $param['bill_date'];
    $invoice_no = $param['invoice_no'];
    $payment_due_date = $param['payment_due_date'];
    $charged_amt = $param['charged_amt'];
    $payment_mode = $param['payment_mode'];
    $or_no = $param['or_no'];
    $description = $param['description'];
    
    $query = "INSERT INTO bill_management_late_interest_charge SET
            acc_id = '".$acc_id."',
            bill_date = '".dateFormat($bill_date)."',
            inv_no = '$invoice_no',
            payment_due_date = '".dateFormat($payment_due_date)."',
            description = '$description',
            amount = '$charged_amt',
            payment_mode = '$payment_mode',
            or_no = '$or_no'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function update_late_interest_charge($data){
    global $conn_admin_db;
    $param = array();
    parse_str($data, $param); //unserialize jquery string data
    $id = $param['item_id'];
    $bill_date = $param['bill_date'];
    $invoice_no = $param['invoice_no'];
    $payment_due_date = $param['payment_due_date'];
    $charged_amt = $param['charged_amt'];
    $payment_mode = $param['payment_mode'];
    $or_no = $param['or_no'];
    $description = $param['description'];
    
    $query = "UPDATE bill_management_late_interest_charge SET
            bill_date = '".dateFormat($bill_date)."',
            inv_no = '$invoice_no',
            payment_due_date = '".dateFormat($payment_due_date)."',
            description = '$description',
            amount = '$charged_amt',
            payment_mode = '$payment_mode',
            or_no = '$or_no' WHERE id='$id'";
    
    $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    echo json_encode($result);
}

function insert_billing_water($data){
    global $conn_admin_db;
    $param = array();
    if(!empty($data)){
        parse_str($data, $param); //unserialize jquery string data  
        $acc_id = $param['acc_id'];
        $invoice_no = $param['invoice_no'];
        $invoice_date = $param['invoice_date'];
        $receive_date = $param['receive_date'];
        $from_date = $param['from_date'];
        $to_date = $param['to_date'];
        $paid_date = $param['paid_date'];
        $due_date = $param['due_date'];
        $description = $param['description'];
        $previous_mr = $param['previous_mr'];
        $current_mr = $param['current_mr'];
        $charged_amt = $param['charged_amt'];
        $surcharge = $param['surcharge'];    
        $payment_mode = $param['payment_mode'];
        $or_no = $param['or_no'];
        $total_consume = $current_mr - $previous_mr;
        $total = $charged_amt + $surcharge;
        
        $rounded = round_up($total);
        $adjustment = number_format(($rounded-$total), 2);
        
        $query = "INSERT INTO bill_management_water SET 
                acc_id = '".$acc_id."',
                date_from = '".dateFormat($from_date)."',
                date_to = '".dateFormat($to_date)."',
                invoice_no = '$invoice_no',
                invoice_date = '".dateFormat($invoice_date)."',
                due_date = '".dateFormat($due_date)."',
                description = '$description',
                previous_mr = '$previous_mr',
                current_mr = '$current_mr',
                total_consume = '$total_consume',
                charged_amount = '$charged_amt',
                surcharge = '$surcharge',
                adjustment = '$adjustment',
                total = '$total',
                payment_date = '".dateFormat($paid_date)."',
                payment_mode = '$payment_mode',
                or_no = '$or_no',
                received_date = '".dateFormat($receive_date)."'";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }
}

function add_new_management($data){
    global $conn_admin_db;
    if (!empty($data)) {
        $param = array();
        parse_str($data, $param); //unserialize jquery string data        
        $acc_id = $param['acc_id'];
        $description = $param['description'];
        $payment = $param['payment'];
        $remark = $param['remark'];
        $payment_mode = $param['payment_mode'];
        $cheque_no = $param['cheque_no'];
        $or_no = $param['or_no'];
        $invoice_no = $param['invoice_no'];
        $payment_date = $param['payment_date'];
        $receive_date = $param['receive_date'];
        
        $query = "INSERT INTO bill_management_fee SET acc_id = '$acc_id',
            description = '$description',
            payment_amount = '$payment',
            remark = '$remark',
            payment_mode = '$payment_mode',
            official_receipt_no = '$or_no',
            ref_no = '$invoice_no',
            cheque_no = '$cheque_no',
            payment_date = '".dateFormat($payment_date)."',
            received_date = '".dateFormat($receive_date)."' ";
        
        $result = mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
        echo json_encode($result);
    }       
}

function insert_billing_photocopy_machine($param){
    global $conn_admin_db;
    $sel_account = $param['sel_account'];
    $date_entered = $param['date_entered_fx'];
    $full_color = $param['full_color'];
    $black_white = $param['black_white'];
    $color_a3 = $param['color_a3'];
    $copy = $param['copy'];
    $print = $param['print'];
    $fax = $param['fax'];
    $total = 0;
    if(!empty($full_color) && !empty($black_white)){
        $total = $full_color + $black_white;
    }
    elseif (!empty($copy) || !empty($print) || !empty($fax)){
        $total = $copy + $print + $fax;
    }
    
    $query = "INSERT INTO bill_photocopy_machine SET acc_id = '$sel_account',
            date = '".dateFormat($date_entered)."',
            full_color = '$full_color',
            black_white = '$black_white',
            color_a3 = '$color_a3',
            copy = '$copy',
            print = '$print',
            fax = '$fax',
            total = '$total'";
    
    mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
}
function insert_billing_celcom($param){
    global $conn_admin_db;
    $sel_account = $param['sel_account'];
    $date_entered = $param['date_entered'];
    $bill_amount = $param['bill_amount'];
    
    $query = "INSERT INTO bill_celcom SET acc_id = '$sel_account',
            date = '".dateFormat($date_entered)."',
            bill_amount = '$bill_amount'";
    
    mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
}

function insert_billing_sesb($param){
    global $conn_admin_db;
    $cheque_no = $param['cheque_no'];
    $from_date = $param['from_date'];
    $to_date = $param['to_date'];
    $paid_date = $param['paid_date'];
    $due_date = $param['due_date'];
    $sel_account = $param['sel_account'];
    $reading_from = $param['reading_from'];
    $reading_to = $param['reading_to'];
    $current_usage = $param['current_usage'];
    $kwtbb = $param['kwtbb'];
    $penalty = $param['penalty'];
    $additional_depo = $param['additional_depo'];
    $other_charges = $param['other_charges'];
    $total_usage = $reading_to - $reading_from;
    $power_factor = $param['power_factor'];
    $amount = $current_usage + $kwtbb + $penalty + $additional_depo + $other_charges;
    $rounded = round_up($amount);
    $adjustment = number_format(($rounded-$amount), 2);
    $total_amt = $amount + $adjustment;
    
    $query_insert_sesb = "INSERT INTO bill_sesb
                    SET acc_id = '$sel_account',
                    meter_reading_from = '$reading_from',
                    meter_reading_to = '$reading_to',
                    total_usage = '$total_usage',
                    current_usage = '$current_usage',
                    kwtbb = '$kwtbb',
                    penalty = '$penalty',
                    power_factor = '$power_factor',
                    additional_deposit = '$additional_depo',
                    other_charges = '$other_charges',
                    amount = '$total_amt',
                    adjustment = '$adjustment',
                    cheque_no = '$cheque_no',
                    date_start = '".dateFormat($from_date)."',
                    date_end = '".dateFormat($to_date)."',
                    paid_date = '".dateFormat($paid_date)."',
                    due_date = '".dateFormat($due_date)."'";
   
    mysqli_query($conn_admin_db, $query_insert_sesb) or die(mysqli_error($conn_admin_db));
    
}

function insert_billing_jabatan_air($param){
    global $conn_admin_db;
    $cheque_no = $param['cheque_no'];
    $from_date = $param['from_date'];
    $to_date = $param['to_date'];
    $paid_date = $param['paid_date'];
    $due_date = $param['due_date'];
    $sel_account = $param['sel_account'];
    $read_from = $param['read_from'];
    $read_to = $param['read_to'];
    $usage_1 = $param['usage_1'];
    $usage_2 = $param['usage_2'];
    $credit = $param['credit'];
    $rate_70 = $usage_1 * 1.60;
    $rate_71 = $usage_2 * 2.00;
    $amount = $rate_70 + $rate_71;
    $rounded = round_up($amount);
    $adjustment = number_format(($rounded-$amount), 2);
    $total_amt = $amount + $adjustment;
    
    $query_insert_ja = "INSERT INTO bill_jabatan_air
                    SET acc_id = '$sel_account',
                    meter_reading_from = '$read_from',
                    meter_reading_to = '$read_to',
                    usage_70 = '$usage_1',
                    usage_71 = '$usage_2',
                    rate_70 = '$rate_70',
                    rate_71 = '$rate_71',
                    credit_adjustment = '$credit',
                    amount = '$total_amt',
                    adjustment = '$adjustment',
                    cheque_no = '$cheque_no',
                    date_start = '".dateFormat($from_date)."',
                    date_end = '".dateFormat($to_date)."',
                    paid_date = '".dateFormat($paid_date)."',
                    due_date = '".dateFormat($due_date)."'";
    
    mysqli_query($conn_admin_db, $query_insert_ja) or die(mysqli_error($conn_admin_db));
    
}

function insert_billing_telekom($param, $telefon_list){
    global $conn_admin_db;
    $cheque_no = $param['cheque_no'];
    $from_date = $param['from_date'];
    $to_date = $param['to_date'];
    $paid_date = $param['paid_date'];
    $due_date = $param['due_date'];
    $sel_account = $param['sel_account'];
    $bill_no = $param['bill_no'];
    $monthly_fee = $param['monthly_fee'];
    $rebate = $param['rebate'];
    $cr_adjustment = $param['cr_adjustment'];
    
    $query_insert_telekom = "INSERT INTO bill_telekom 
                        SET acc_id = '$sel_account',
                        bill_no = '$bill_no',
                        monthly_bill = '$monthly_fee',
                        rebate = '$rebate',
                        credit_adjustment = '$cr_adjustment',
                        cheque_no = '$cheque_no',
                        date_start = '".dateFormat($from_date)."',
                        date_end = '".dateFormat($to_date)."',
                        paid_date = '".dateFormat($paid_date)."',
                        due_date = '".dateFormat($due_date)."'";
    
    mysqli_query($conn_admin_db, $query_insert_telekom) or die(mysqli_error($conn_admin_db));
    
    $last_insert_id = mysqli_insert_id($conn_admin_db);
    
    $values = [];
    if(!empty($telefon_list)){
        foreach ($telefon_list as $tel){
            $telefon = $tel['telefon'];
            $type = $tel['type'];
            $usage = $tel['usage'];
            
            $values[] = "('$last_insert_id', '$telefon', '$usage', '$type')";
        
        }
        
        $values = implode(",", $values); 
        $query = "INSERT INTO bill_telefon_list (bt_id, tel_no, usage_amt, phone_type) VALUES" .$values;
        mysqli_query($conn_admin_db, $query) or die(mysqli_error($conn_admin_db));
    }
    
    //update gst, adjustment and amount
    
    $sum_usage = itemName("SELECT SUM(usage_amt) FROM bill_telekom bt
                        INNER JOIN bill_telefon_list btl ON btl.bt_id = bt.id WHERE bt.id='$last_insert_id'");
    
    $total = $monthly_fee + $sum_usage;
    $gst = $total * 0.06;
    $amount = $total + $gst + $cr_adjustment;
    $rounded = round_up($amount);
    $adjustment = number_format(($rounded-$amount), 2);
    $total_amt = $amount + $rebate + $adjustment;
    
    $query_update = "UPDATE bill_telekom SET gst_sst='$gst', adjustment='$adjustment', amount='$total_amt' WHERE id='$last_insert_id'";
    mysqli_query($conn_admin_db, $query_update) or die(mysqli_error($conn_admin_db));
    
}

//to round up0.05
function round_up($x){
    return round($x * 2, 1) / 2;
}
?>