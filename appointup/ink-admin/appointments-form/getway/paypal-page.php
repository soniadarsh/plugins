<?php

/**
 * Paypal Transaction	
 * @ gateway_sandbox
 * */
function gateway_sandbox() {
    if (isset($_POST['submit'])) {
        $db_obj = new Apt_DB();
        if (file_exists($db_obj->dir . "ink-admin/appointments-form/getway/paypal/paypal_sandbox.php")) {
            include_once($db_obj->dir . "ink-admin/appointments-form/getway/paypal/paypal_sandbox.php");
        }
    }
}

/**
 * 	 Paypal Transaction	
 * @ gateway_paypal
 * */
function gateway_paypal() {
    if (isset($_POST['submit'])) {
        $db_obj = new Apt_DB();
        if (file_exists($db_obj->dir . "ink-admin/appointments-form/getway/paypal/paypal_response.php")) {
            include_once($db_obj->dir . "ink-admin/appointments-form/getway/paypal/paypal_response.php");
        }
    }
}

function cash_payment($sr_apt_id, $sr_apt_time, $sr_apt_date, $sr_apt_persion_name, $sr_apt_email, $sr_apt_phone, $sr_msg, $sr_lead_form1, $sr_lead_form2, $sr_lead_form3, $sr_lead_form4, $sr_lead_form5, $sr_data_rand) {
    global $wpdb;
    $db_obj = new Apt_DB();
    $apt_service = $db_obj->tbl_service;
    $appointment_data = $db_obj->tbl_appointment_data;
    $sql_srdata = $wpdb->get_row("SELECT * FROM $apt_service Where service_id='$sr_apt_id'", ARRAY_N);
    $cr_code = get_option('apt_currency_code');
    $price = $sql_srdata[2] . '&nbsp' . $cr_code . '&nbsp- Pay Cash Later';
    $priceshow = $sql_srdata[2] . '' . $cr_code;   
    $apt_txn_booking_date = date("F j, Y, g:i A");
    $apt = new AptService();
    if (isset($_POST['submit'])) {
        $sql_val = $wpdb->get_row("SELECT * FROM $appointment_data Where apt_data_rand='$sr_data_rand'");        
        if (!$sql_val) {
            $apt->insert_data_frontend($sr_apt_id, $sr_apt_date, $sr_apt_persion_name, $sql_srdata[1], $sr_apt_time, $price, $sr_apt_email, $sr_apt_phone, $sr_msg, $sr_lead_form1, $sr_lead_form2, $sr_lead_form3, $sr_lead_form4, $sr_lead_form5, $sr_data_rand, $apt_txn_booking_date, 'cash');
           
            printf(__('<p>Your appointment has been booked successfully. You have to pay the amount of %s at the time of appointment.<br/>Thanks</p>', 'appointment'), $priceshow);
            /**
             * Send transaction notification to admin or client
             */
            $transaction_details = '';
            $personname = $sr_apt_persion_name;
            $servicename = $sql_srdata[1];
            $aptime = $sr_apt_time;
            $aptdate = $sr_apt_date;
            $aptemail = $sr_apt_email;
            $url = site_url();
            $adminurl = str_replace('https://', '', $url);
            $transaction_details .= sprintf(__("Hello %s", 'appointment'), $personname) . ",\r";
            $transaction_details .= "\r";
            $transaction_details .= __("Your Appointment had been fixed, below are the details of your appointment.", 'appointment') . "\r \r";
            $transaction_details .= sprintf(__("Service Name: %s", 'appointment'), $servicename) . "\r";
            $transaction_details .= sprintf(__("Appointment Date: %s", 'appointment'), $aptdate) . "\r";
            $transaction_details .= sprintf(__("Appointment Time: %s", 'appointment'), $aptime) . "\r";
            $transaction_details .= sprintf(__("Amount Paid: %s", 'appointment'), $priceshow) . "\r";
            $transaction_details .= sprintf(__("Date: %s", 'appointment'), $apt_txn_booking_date) . "\r \r";
            $transaction_details .= __("Thanks for booking with us.", 'appointment') . "\r";
            $transaction_details .= "Warm Regards,\r \r";
            $transaction_details .= "$adminurl\r";
            $subject = __("Your Appointment Confirmation Email", 'appointment');
            $filecontent = $transaction_details;
            $admin_email = get_option('admin_email');
            $headers = 'From:  <' . $admin_email . '>' . "\r\n" . 'Reply-To: ' . $admin_email;
            $header = 'From: ' . $personname . ' <' . $aptemail . '>' . "\r\n" . 'Reply-To: ' . $aptemail;
            //mail($to_admin, $subject, $filecontent, $headers);
            wp_mail($aptemail, $subject, $filecontent, $headers); //email to user
            wp_mail($admin_email, $subject, $filecontent, $header); //email to admin
            $is_sms_on = get_option('sms_enable');
            if ($is_sms_on == 'on') {
                $user_phone = $sr_apt_phone;
                $message_user = 'Hello ' . $sr_apt_persion_name . ' Your Appointment has been booked on ' . $apt_txn_booking_date . ', for the timeslot of ' . $sr_apt_time;
                twilio_booking_send_sms($user_phone, $message_user);
                $appointment_admin = get_option('apt_sms_own_number');
                $message_admin = 'Hello ' . $sr_apt_persion_name . ' has been booked the Appointment on ' . $apt_txn_booking_date . ', for the timeslot of ' . $sr_apt_time;
                twilio_booking_send_sms($appointment_admin, $message_admin);
            }
        } //refresh value if end
    } //submit data if end
}

function free_payment($fr_apt_id, $fr_apt_time, $fr_apt_date, $fr_apt_persion_name, $fr_apt_email, $fr_apt_phone, $fr_msg, $fr_lead_form1, $fr_lead_form2, $fr_lead_form3, $fr_lead_form4, $fr_lead_form5, $fr_data_rand) {
    global $wpdb;
    //global $wpdb;
//echo $wpdb->dbname;
$schedule = wp_get_schedule( 'apt_send_reminder', array( 'some_arg' ) );
    $db_obj = new Apt_DB();
    $apt_service = $db_obj->tbl_service;
    $appointment_data = $db_obj->tbl_appointment_data;
    $sql_srdata = $wpdb->get_row("SELECT * FROM $apt_service Where service_id='$fr_apt_id'", ARRAY_N);
    $cr_code = get_option('apt_currency_code');
    $price = $sql_srdata[3] . '&nbsp Appointment';
    $apt_txn_booking_date = date("F j, Y, g:i A");
    $apt = new AptService();
    if (isset($_POST['submit'])) {
        $sql_val = $wpdb->get_row("SELECT * FROM $appointment_data Where apt_data_rand='$fr_data_rand'");
        if (!$sql_val) {
           $apt->insert_data_frontend($fr_apt_id, $fr_apt_date, $fr_apt_persion_name, $sql_srdata[1], $fr_apt_time, $price, $fr_apt_email, $fr_apt_phone, $fr_msg, $fr_lead_form1, $fr_lead_form2, $fr_lead_form3, $fr_lead_form4, $fr_lead_form5, $fr_data_rand, $apt_txn_booking_date, 'free');           
           printf(__('<p>Your appointment has been booked successfully. <br/>Thanks</p>', 'appointment'));
            /**
             * Send transaction notification to admin or client
             */
            $transaction_details = '';
            $personname = $fr_apt_persion_name;
            $servicename = $sql_srdata[1];
            $aptime = $fr_apt_time;
            $aptdate = $fr_apt_date;
            $aptemail = $fr_apt_email;
            $url = site_url();
            $adminurl = str_replace('https://', '', $url);
            $transaction_details .= sprintf(__("Hello %s", 'appointment'), $personname) . ",\r";
            $transaction_details .= "\r";
            $transaction_details .= __("Your Appointment had been fixed, below are the details of your appointment.", 'appointment') . "\r \r";
            $transaction_details .= sprintf(__("Service Name: %s", 'appointment'), $servicename) . "\r";
            $transaction_details .= sprintf(__("Appointment Date: %s", 'appointment'), $aptdate) . "\r";
            $transaction_details .= sprintf(__("Appointment Time: %s", 'appointment'), $aptime) . "\r";
            $transaction_details .= sprintf(__("Date: %s", 'appointment'), $apt_txn_booking_date) . "\r \r";
            $transaction_details .= __("Thanks for booking with us.", 'appointment') . "\r";
            $transaction_details .= "Warm Regards,\r \r";
            $subject = __("Your Appointment Confirmation Email", 'appointment');
            $filecontent = $transaction_details;
            $admin_email = get_option('admin_email');
            $headers = 'From:  <' . $admin_email . '>' . "\r\n" . 'Reply-To: ' . $admin_email;
            $header = 'From: ' . $personname . ' <' . $aptemail . '>' . "\r\n" . 'Reply-To: ' . $aptemail;
            //mail($to_admin, $subject, $filecontent, $headers);
            wp_mail($aptemail, $subject, $filecontent, $headers); //email to user
            wp_mail($admin_email, $subject, $filecontent, $header); //email to admin          
            
                
            $is_sms_on = get_option('sms_enable');
            if ($is_sms_on == 'on') {
                $user_phone = $fr_apt_phone;
                $message_user = 'Hello ' . $fr_apt_persion_name . ' Your Appointment has been booked on ' . $apt_txn_booking_date . ', for the timeslot of ' . $fr_apt_time;
                twilio_booking_send_sms($user_phone, $message_user);
                $appointment_admin = get_option('apt_sms_own_number');
                $message_admin = 'Hello ' . $fr_apt_persion_name . ' has been booked the Appointment on ' . $apt_txn_booking_date . ', for the timeslot of ' . $fr_apt_time;
                twilio_booking_send_sms($appointment_admin, $message_admin);
            }
        } //refresh value if end
    } //submit data if end
}

//function end

/**
 * manual_payment function 
 */
function manual_payment($mn_apt_id, $mn_apt_time, $mn_apt_date, $mn_apt_persion_name, $mn_apt_email, $mn_apt_phone, $mn_msg, $mn_lead_form1, $mn_lead_form2, $mn_lead_form3, $mn_lead_form4, $mn_lead_form5, $mn_data_rand) {
    global $wpdb;
    $db_obj = new Apt_DB();
    $apt_service = $db_obj->tbl_service;
    $appointment_data = $db_obj->tbl_appointment_data;
    $sql_srdata = $wpdb->get_row("SELECT * FROM $apt_service Where service_id='$mn_apt_id'", ARRAY_N);
    $cr_code = get_option('apt_currency_code');
    if ($sql_srdata[3] == 'free') {
        $price = 'Manual Appointment</br>(free)';
    } else {
        $price = 'Manual Appointment</br>(' . $sql_srdata[2] . '&nbsp' . $cr_code . '&nbspPending)';
    }
//    $price = 'Manual Appointment';
    $apt_txn_booking_date = date("F j, Y, g:i A");
    $apt = new AptService();
    if (isset($_POST['submit'])) {
        $sql_val = $wpdb->get_row("SELECT * FROM $appointment_data Where apt_data_rand='$mn_data_rand'");
        if (!$sql_val) {
            $apt->insert_data_frontend($mn_apt_id, $mn_apt_date, $mn_apt_persion_name, $sql_srdata[1], $mn_apt_time, $price, $mn_apt_email, $mn_apt_phone, $mn_msg, $mn_lead_form1, $mn_lead_form2, $mn_lead_form3, $mn_lead_form4, $mn_lead_form5, $mn_data_rand, $apt_txn_booking_date, 'Manual Appointment');
            printf(__('<p>Your appointment has been booked successfully. <br/>Thanks</p>', 'appointment'));
            /**
             * Send transaction notification to admin or client
             */
            $transaction_details = '';
            $personname = $mn_apt_persion_name;
            $servicename = $sql_srdata[1];
            $aptime = $mn_apt_time;
            $aptdate = $mn_apt_date;
            $aptemail = $mn_apt_email;
            $url = site_url();
            $adminurl = str_replace('https://', '', $url);
            $transaction_details .= sprintf(__("Hello %s", 'appointment'), $personname) . ",\r";
            $transaction_details .= "\r";
            $transaction_details .= __("Your Appointment had been fixed, below are the details of your appointment.", 'appointment') . "\r \r";
            $transaction_details .= sprintf(__("Service Name: %s", 'appointment'), $servicename) . "\r";
            $transaction_details .= sprintf(__("Appointment Date: %s", 'appointment'), $aptdate) . "\r";
            $transaction_details .= sprintf(__("Appointment Time: %s", 'appointment'), $aptime) . "\r";
            $transaction_details .= sprintf(__("Date: %s", 'appointment'), $apt_txn_booking_date) . "\r \r";
            $transaction_details .= __("Thanks for booking with us.", 'appointment') . "\r";
            $transaction_details .= "Warm Regards,\r \r";
            $transaction_details .= "$adminurl\r";
            $subject = __("Your Appointment Confirmation Email", 'appointment');
            $filecontent = $transaction_details;
            $admin_email = get_option('admin_email');
            $headers = 'From:  <' . $admin_email . '>' . "\r\n" . 'Reply-To: ' . $admin_email;
            $header = 'From: ' . $personname . ' <' . $aptemail . '>' . "\r\n" . 'Reply-To: ' . $aptemail;
            //mail($to_admin, $subject, $filecontent, $headers);
            wp_mail($aptemail, $subject, $filecontent, $headers); //email to user
            wp_mail($admin_email, $subject, $filecontent, $header); //email to admin
            $is_sms_on = get_option('sms_enable');
            if ($is_sms_on == 'on') {
                $user_phone = $mn_apt_phone;
                $message_user = 'Hello ' . $mn_apt_persion_name . ' Your Appointment has been booked on ' . $apt_txn_booking_date . ', for the timeslot of ' . $mn_apt_time;
                twilio_booking_send_sms($user_phone, $message_user);
                $appointment_admin = get_option('apt_sms_own_number');
                $message_admin = 'Hello ' . $mn_apt_persion_name . ' has been booked the Appointment on ' . $apt_txn_booking_date . ', for the timeslot of ' . $mn_apt_time;
                twilio_booking_send_sms($appointment_admin, $message_admin);
            }
        }
    }
}

/**
 * this function fetches the parameter require to send sms
 */
function twilio_booking_send_sms($msgtonumber = '', $message = '') {
    $ink_twiliosid = get_option('apt_sms_sid');
    $ink_twiliotoken = get_option('apt_sms_token');
    $msgfromnumber = get_option('apt_sms_number');

    if (!strpos('+', $msgtonumber)) {
        $msgtonumber = "+" . $msgtonumber;
    }
    if ($ink_twiliosid == '' && $ink_twiliotoken = '' && $msgtonumber == '' && $msgfromnumber == '') {
        _e('Some Twilio Credentials are missing. Please enter all the credentials for Twilio', 'appointment');
    } else {
        twilio_sendSms($ink_twiliosid, $ink_twiliotoken, $msgfromnumber, $msgtonumber, $message);
    }
}

function twilio_sendSms($sid, $token, $twilioNumber, $to, $message) {
    $client = new Twilio\Rest\Client($sid, $token);

    try {
        $client->messages->create(
                $to, array(
            "body" => $message,
            "from" => $twilioNumber
                )
        );
    } catch (Twilio\Exceptions\TwilioException $e) {
        echo 'Could not send SMS notification. Checkout Your Credetials or Enterd Number.';
    }
}