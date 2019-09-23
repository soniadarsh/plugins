<?php

class InkPaypal {

    public $item_name = '';
    public $item_number = 0;
    public $payment_status = '';
    public $payment_amount = 0;
    public $payment_currency = '';
    public $txn_id = '';
    public $receiver_email = '';
    public $payer_email = '';
    public $status = 0;

    //Recurring variable
    function __construct() {
        // parent::__construct();
        $this->appointments_paypal_trans();
    }

    public function appointments_paypal_trans() {
        global $current_user;
        // assign posted variables to local variables      
        if (!isset($_GET['return'])) {
        $this->first_name = $_POST['first_name'];
        $this->item_name = $_POST['item_name'];
        if(isset($_POST['item_number'])){
            $this->item_number = $_POST['item_number'];    
        }else{
            $this->item_number= '';
        }
        
        $this->payment_status = $_POST['payment_status'];
        $this->payment_amount = $_POST['mc_gross'];
        $this->payment_currency = $_POST['mc_currency'];
        $this->txn_id = $_POST['txn_id'];
        if(isset($_POST['receiver_email'])){
            $this->receiver_email = $_POST['receiver_email'];    
        }else{
            $this->receiver_email = '';
        }
        
        $this->payer_email = $_POST['payer_email'];
        if ($this->payment_status == 'Completed' || $this->payment_status == 'Pending') {
            $this->status = 1;
            $this->payment_status = 'Completed';
            $post_status_to_admin = "Payment Received";
            $post_status_to_client = "Your order is successfully completed.";
        }
        }
    }

    public function mail_send_func() {
        /**
         * Send transaction notification to admin or client
         */
        $transaction_details = '';
        $personname = $_GET['aptname'];
        $aptime = $_GET['apttime'];
        $aptphone = $_GET['aptphone'];
         $as = new AptService();
        $showdate = $as->date_change_format($_GET['aptdate']);
    if (get_option('apt_dformat') == '1') {
        $datechange = date('d/m/Y', strtotime($showdate));
    } elseif (get_option('apt_dformat') == '2') {
        $datechange = date('m/d/Y', strtotime($showdate));
    } elseif (get_option('apt_dformat') == '3') {
        $datechange = date('d-M-Y', strtotime($showdate));
    }
        $aptemail = $_GET['aptemail'];
        $apt_txn_booking_date = date("F j, Y, g:i a");
        $url = site_url();
        $adminurl = str_replace('https://', '', $url);
        $transaction_details .= sprintf(__("Hello %s", 'appointment'), $personname) . ",\r";
        $transaction_details .= "\r";
        $transaction_details .= __("Your Appointment had been fixed, below are the details of your appointment.", 'appointment') . "\r \r";
        $transaction_details .= sprintf(__("Service Name: %s", 'appointment'), $this->item_name) . "\r";
        $transaction_details .= sprintf(__("Appointment Date: %s", 'appointment'), $datechange) . "\r";
        $transaction_details .= sprintf(__("Appointment Time: %s", 'appointment'), $aptime) . "\r";
        $transaction_details .= sprintf(__("Amount Paid: %s", 'appointment'), $this->payment_amount) . "\r";
        $transaction_details .= sprintf(__("Date: %s", 'appointment'), $apt_txn_booking_date) . "\r \r";
        $transaction_details .= __("Thanks for booking with us.", 'appointment') . "\r";
        $transaction_details .= "Warm Regards,\r \r";
        $transaction_details .= "$adminurl\r";
        $subject = __("Your Appointment Confirmation Email", 'appointment');
        $filecontent = $transaction_details;
        $admin_email = get_option('admin_email');
        $headers = 'From: <' . $admin_email . '>' . "\r\n" . 'Reply-To: ' . $admin_email;
        $header = 'From: ' . $personname . ' <' . $aptemail . '>' . "\r\n" . 'Reply-To: ' . $aptemail;
        //mail($to_admin, $subject, $filecontent, $headers);
        wp_mail($aptemail, $subject, $filecontent, $headers); //email to user
        wp_mail($admin_email, $subject, $filecontent, $header); //email to admin
        $is_sms_on = get_option('sms_enable');
        if ($is_sms_on == 'on') {
            $user_phone = $aptphone;
            $message_user = 'Hello ' . $personname . ' Your Appointment has been booked on ' . $aptdate . ', for the timeslot of ' . $aptime;
            twilio_booking_send_sms($user_phone, $message_user);
            $appointment_admin = get_option('apt_sms_own_number');
            $message_admin = 'Hello ' . $personname . ' has been booked the Appointment on ' . $aptdate . ', for the timeslot of ' . $aptime;
            twilio_booking_send_sms($appointment_admin, $message_admin);
        }
    }

    public function admin_payment_mail() {
        /** Send transaction notification to admin * */
        $transaction_details = '';
        $personname = $_GET['aptname'];
        $aptime = $_GET['apttime'];  
         $as = new AptService();
         $showdate = $as->date_change_format($_GET['aptdate']);
    if (get_option('apt_dformat') == '1') {
        $datechange = date('d/m/Y', strtotime($showdate));
    } elseif (get_option('apt_dformat') == '2') {
        $datechange = date('m/d/Y', strtotime($showdate));
    } elseif (get_option('apt_dformat') == '3') {
        $datechange = date('d-M-Y', strtotime($showdate));
    }
        $aptemail = $_GET['aptemail'];
        $apt_txn_booking_date = date("F j, Y, g:i a");
        $admin_email = get_option('admin_email');         
        $url = site_url();
        $adminurl = str_replace('https://', '', $url);
        $subject = sprintf(__("New Appointment Booked through %s", 'appointment'), $adminurl);
        $transaction_details .= __("Hello,", 'appointment') . "\r \r";
        $transaction_details .= __("New Appointment booked. Below are the details of the Appointment which is booked.", 'appointment') . "\r";
        $transaction_details .= "\r";
        $transaction_details .= sprintf(__("Service Name Booked: %s ", 'appointment'), $this->item_name) . "\r";
        $transaction_details .= sprintf(__("Person Name: %s ", 'appointment'), $personname) . "\r";
        $transaction_details .= sprintf(__("Appointment Date Booked: %s", 'appointment'), $datechange) . "\r";
        $transaction_details .= sprintf(__("Appointment Time Booked: %s", 'appointment'), $aptime) . "\r";
        $transaction_details .= sprintf(__("Amount Received: %s", 'appointment'), $this->payment_amount) . " \r \r";
        $transaction_details .= __("You can login to your dashboard to see all the details.", 'appointment') . "\r";
        $transaction_details .= __("Thanks", 'appointment') . "\r";
        $content = $transaction_details;
        $headersa = 'From: ' . $personname . ' <' . $aptemail . '>' . "\r\n" . 'Reply-To: ' . $aptemail;
        wp_mail($admin_email, $subject, $content, $headersa); //email to client
    }

}


//add_shortcode('pay-status', 'ink_apt_trans_display');	
function ink_apt_trans_display() {
    if(isset($_GET['return'])){
   echo APT_USF;
    }
    global $wpdb;
    $db_obj = new Apt_DB();
    $apt_service = $db_obj->tbl_service;
    $appointment_data = $db_obj->tbl_appointment_data;
    $apt_transaction = $db_obj->tbl_transaction;
    $paypal_init = new InkPaypal();
    $as = new AptService();
    $showdate = $as->date_change_format($_GET['aptdate']);
    if (get_option('apt_dformat') == '1') {
        $datechange = date('d/m/Y', strtotime($showdate));
    } elseif (get_option('apt_dformat') == '2') {
        $datechange = date('m/d/Y', strtotime($showdate));
    } elseif (get_option('apt_dformat') == '3') {
        $datechange = date('d-M-Y', strtotime($showdate));
    }
    $merchant = get_option('apt_merchaint_email');
  //     error_log('payment TRANS BEFORE'.$paypal_init->item_name.'LIVE NAME'.$_POST['item_name'], 1, get_option('admin_email'));
    if (!empty($paypal_init->item_name)) {
//       error_log('payment TRANS AFTER'.$paypal_init->item_name.'LIVE NAME'.$_POST['item_name'], 1, get_option('admin_email'));
        $paypal_init->mail_send_func();
        echo PAYPAL_RET_TEXT . '</b><br/>';
        //echo "Payment Persoin Name:&nbsp;&nbsp;<b>" . $paypal_init->first_name . '</b><br/>';
        echo "<p>";
        echo $_GET['label1'];
        printf(__("Service Name:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->item_name);
        printf(__("Appointment Date:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $datechange);
        printf(__("Appointment Time:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $_GET['apttime']);
        printf(__("Amount Paid:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->payment_amount);
        printf(__("Payment Currency:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->payment_currency);
        printf(__("Transaction ID:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->txn_id);
        //printf(__("Payment Receiver Email:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->receiver_email);
        printf(__("Payment Receiver Email:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $merchant);
        printf(__("Payment Payer Email:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->payer_email);
        _e("Mode of Payment:&nbsp;&nbsp;<b>Paypal</b><br/>", 'appointment');
        printf(__("Your Payment Status:&nbsp;&nbsp;<b>%s</b><br/>", 'appointment'), $paypal_init->payment_status);
        echo "</p><br/>";
        $randnumber = $_GET['aptrandom'];
        $randvalue = $wpdb->get_row("SELECT * FROM $appointment_data WHERE  apt_data_rand ='$randnumber'");
        if ((!$randvalue) && (!empty($paypal_init->item_name)) && (!empty($paypal_init->txn_id)) && (!empty($paypal_init->payment_amount))) {
            $service_id = $_GET["aptserviceid"];
            $front_apt_price = $paypal_init->payment_amount . '' . $paypal_init->payment_currency;
            $apt_txn_booking_date = date("F j, Y, g:i A");
            $save = new AptService();
            $save->insert_data_frontend($service_id, $datechange, $_GET['aptname'], $paypal_init->item_name, $_GET['apttime'], $front_apt_price, $_GET['aptemail'], $_GET['aptphone'], $_GET['aptmessage'], $_GET['label1'], $_GET['label2'], $_GET['label3'], $_GET['label4'], $_GET['label5'], $randnumber, $apt_txn_booking_date, 'paypal');
            $max_id = $wpdb->get_var("SELECT MAX(APTID) FROM $appointment_data");
            $save->insert_transaction($max_id, $service_id, $apt_txn_booking_date, $paypal_init->item_name, $front_apt_price, $paypal_init->payer_email, $paypal_init->payment_status, $paypal_init->txn_id, $randnumber);
        }
        $paypal_init->admin_payment_mail();
    } else {
      //  echo APT_USF;
    }
}