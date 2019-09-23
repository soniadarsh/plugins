<?php

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once( $parse_uri[0] . 'wp-load.php' );
$error = 'error';

// validate the paypal request by sending it back to paypal
function gc_ipn_request_check() {
    define('SSL_P_URL', 'https://www.paypal.com/cgi-bin/webscr');
    define('SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');

    $hostname = gethostbyaddr($_SERVER ['REMOTE_ADDR']);
    if (!preg_match('/paypal\.com$/', $hostname)) {
        $ipn_status = ___('Validation post isn\'t from PayPal', 'appointment');
        if (get_option('paypal_ipn') == true) {
            wp_mail(get_option('admin_email'), $ipn_status, 'fail');
        }
        return false;
    }

    // parse the paypal URL
    $paypal_url = ($_REQUEST['test_ipn'] == 1) ? SSL_SAND_URL : SSL_P_URL;
    $url_parsed = parse_url($paypal_url);


    $post_string = '';
    foreach ($_REQUEST as $field => $value) {
        $post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
    }
    $post_string.="cmd=_notify-validate"; // append ipn command
    // get the correct paypal url to post request to
    if (get_option('apt_paypal') == "sandbox") {
        $paypal_mode_status = true;
    }

    if ($paypal_mode_status == true)
        $fp = fsockopen('ssl://www.sandbox.paypal.com', "443", $err_num, $err_str, 60);
    else
        $fp = fsockopen('ssl://www.paypal.com', "443", $err_num, $err_str, 60);

    $ipn_response = '';

    if (!$fp) {
        // could not open the connection.  If loggin is on, the error message
        // will be in the log.
        $ipn_status = "fsockopen error no. $err_num: $err_str";
        if (get_option('paypal_ipn') == true) {
            wp_mail(get_option('admin_email'), $ipn_status, 'fail');
        }
        return false;
    } else {
        // Post the data back to paypal
        fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");
        fputs($fp, "Host: $url_parsed[host]\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $post_string . "\r\n\r\n");

        // loop through the response from the server and append to variable
        while (!feof($fp)) {
            $ipn_response .= fgets($fp, 1024);
        }
        fclose($fp); // close connection
    }

    // Invalid IPN transaction.  Check the $ipn_status and log for details.
    if (!preg_match("/VERIFIED/s", $ipn_response)) {
        $ipn_status = __('IPN Validation Failed', 'appointment');
        if (get_option('paypal_ipn') == true) {
            wp_mail(get_option('admin_email'), $ipn_status, 'fail');
        }
        return false;
    } else {
        $ipn_status = __("IPN VERIFIED", 'appointment');
        if (get_option('paypal_ipn') == true) {
            wp_mail(get_option('admin_email'), $ipn_status, 'SUCCESS');
        }
        return true;
    }
}

// this is the paypal ipn listener which waits for the request
function gc_ipn_listener() {
    error_log('ipn_listener function', 1, get_option('admin_email'));
    // if the test variable is set (sandbox mode), send a debug email with all values
    if (isset($_REQUEST['test_ipn'])) {
        $_REQUEST = stripslashes_deep($_REQUEST);
        $str = implode(", ", $_REQUEST);
        if (get_option('paypal_ipn') == true) {
            wp_mail(get_option('admin_email'), __('PayPal IPN Debug Email Test IPN', 'appointment'), "" . print_r($_REQUEST, true));
        }
    }

    // make sure the request came from geocraft (pid) or paypal (txn_id refund, update)
    if (isset($_REQUEST['txn_id']) || isset($_REQUEST['invoice'])) {
        $_REQUEST = stripslashes_deep($_REQUEST);

        // if paypal sends a response code back let's handle it
        if (gc_ipn_request_check()) {

            $ipn_data = gc_ipn_data($_REQUEST['custom']);

            $request = wp_parse_args($ipn_data, $_REQUEST);

            // send debug email to see paypal ipn post vars
            if (get_option('paypal_ipn') == true) {
                wp_mail(get_option('admin_email'), __('PayPal IPN Debug Email Main', 'appointment'), "" . print_r($request, true));
            }
            // process the ad since paypal gave us a valid response

            gc_handle_ipn_response($request);
        }
    }
}

gc_ipn_listener();

function gc_wp_mail($subject, $message) {
    $headers = 'From: Krishna <' . get_option('admin_email') . '>' . "\r\n";
    wp_mail(get_option('admin_email'), $subject, $message, $headers);
}

function gc_handle_ipn_response($request) {
    global $wpdb;

    //step functions required to process orders
    //include_once("wp-load.php");
    // make sure the ad unique trans id (stored in invoice var) is included
    if (!empty($request['txn_id'])) {


        // process the ad based on the paypal response
        switch (strtolower($request['payment_status'])) :

            // payment was made so we can approve the ad
            case 'completed' :
                if (get_option('paypal_ipn') == true) {
                    error_log('payment completed', 1, get_option('admin_email'));
                }
                delete_option('gc_paypal_ipn_' . $request['custom']);

                $apt_txn_booking_date = date("F j, Y, g:i A");

                //Mail details to admin email
                $mailto = get_option('admin_email');
                $subject = __('PayPal IPN - payment receiver', 'appointment');
                $headers = 'From: ' . __('AppointUp Admin', 'appointment') . ' <' . get_option('admin_email') . '>' . "\r\n";

                $message = __('Dear Admin,', 'appointment') . "\r\n\r\n";
                $message .= __('The following payment is receive on your website.', 'appointment') . "\r\n\r\n";
                $message .= __('Payment Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= sprintf(__('Payer PayPal address: %s', 'appointment'), $request['payer_email']) . "\r\n";
                $message .= sprintf(__('Transaction ID: %s', 'appointment'), $request['txn_id']) . "\r\n";
                $message .= sprintf(__('Payer name: %s', 'appointment'), $request['aptname']) . "\r\n";
                $message .= sprintf(__('Payer email Address: %s', 'appointment'), $request['aptemail']) . "\r\n";
                $message .= sprintf(__('Payment type: %s', 'appointment'), $request['payment_type']) . "\r\n";
                $message .= sprintf(__('Amount: %s', 'appointment'), $request['mc_gross'], "(" . $request['mc_currency'] . ")") . "\r\n\r\n";
                $message .= "Appointment Details \r";
                $message .= "------------------ \r";
                $message .= sprintf(__("Service Name: %s", 'appointment'), $request['item_name']) . "\r";
                $message .= sprintf(__("Appointment Date: %s", 'appointment'), $request['aptdate']) . "\r";
                $message .= sprintf(__("Appointment Time: %s", 'appointment'), $request['apttime']) . "\r";
                $message .= sprintf(__("Amount Paid: %s", 'appointment'), $request['payment_gross']) . "\r";
                $message .= sprintf(__("Date: %s", 'appointment'), $apt_txn_booking_date) . "\r \r";
                $message .= __('Full Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= print_r($request, true) . "\r\n";
                //admin email
                wp_mail($mailto, $subject, $message, $headers);

                $blogtime = current_time('mysql');
                $transaction_details .= "--------------------------------------------------------------------------------\r\n";
                //            $transaction_details .= sprintf(__("Payment Details for Listing ID &#35;%s", 'appointment'), $request['post_id']) . "\r\n";
                $transaction_details .= "--------------------------------------------------------------------------------\r\n";
                $transaction_details .= sprintf(__("Your name: %s", 'appointment'), $request['aptname']) . " \r\n";
                $transaction_details .= "--------------------------------------------------------------------------------\r\n";
                $transaction_details .= sprintf(__("Trans ID: %s", 'appointment'), $request['txn_id']) . "\r\n";
                $transaction_details .= sprintf(__("Status: %s", 'appointment'), $request['payment_status']) . "\r\n";
                $transaction_details .= sprintf(__("Date: %s", 'appointment'), $blogtime) . "\r";
                $transaction_details .= "--------------------------------------------------------------------------------\r\n";
                $transaction_details .= "Appointment Details \r\n";
                $transaction_details .= sprintf(__("Service Name: %s", 'appointment'), $request['item_name']) . "\r\n";
                $transaction_details .= sprintf(__("Appointment Date: %s", 'appointment'), $request['aptdate']) . "\r\n";
                $transaction_details .= sprintf(__("Appointment Time: %s", 'appointment'), $request['apttime']) . "\r\n";
                $transaction_details .= sprintf(__('Amount Paid: %1$s %2$s', 'appointment'), $request['mc_gross'], "(" . $request['mc_currency'] . ")") . "\r\n";
                $transaction_details .= sprintf(__("Date: %s", 'appointment'), $apt_txn_booking_date) . "\r \r\n";
                $transaction_details = $transaction_details;
                $subject = __("Appointment Submitted and Payment Success Confirmation Email", 'appointment');
                //  $site_name = get_option('blogname');
                $fromEmail = 'Admin';
                $filecontent = $transaction_details;
                $user_email = $request['aptemail'];
                global $wpdb;
                $headers = 'From: ' . get_option('admin_email') . ' <' . $user_email . '>' . "\r\n" . 'Reply-To: ' . get_option('admin_email');
                wp_mail($user_email, $subject, $filecontent, $headers); //email to client

                $front_apt_price = $request['payment_gross'] . '' . $request['mc_currency'];
                $save = new AptService();
                $showdate = $save->date_change_format($request['aptdate']);

                insert_data_frontend_ipn($request['aptserviceid'], $showdate, $request['aptname'], $request['item_name'], $request['apttime'], $front_apt_price, $request['aptemail'], $request['aptphone'], $request['aptmessage'], $request['label1'], $request['label2'], $request['label3'], $request['label4'], $request['label5'], $request['aptrandom'], $apt_txn_booking_date, 'paypal');

                insert_transaction_ipn($request['aptserviceid'], $apt_txn_booking_date, $request['item_name'], $front_apt_price, $request['payer_email'], $request['payment_status'], $request['txn_id'], $request['aptrandom']);

                $is_sms_on = get_option('sms_enable');
                if ($is_sms_on == 'on') {
                    $user_phone = $request['aptphone'];
                    $message_user = 'Hello ' . $request['aptname'] . ' Your Appointment has been booked on ' . $apt_txn_booking_date . ', for the timeslot of ' . $showdate;
                    twilio_booking_send_sms_ipn($user_phone, $message_user);
                    $appointment_admin = get_option('apt_sms_own_number');
                    $message_admin = 'Hello ' . $request['aptname'] . ' has been booked the Appointment on ' . $apt_txn_booking_date . ', for the timeslot of ' . $showdate;
                    twilio_booking_send_sms_ipn($appointment_admin, $message_admin);
                }

                break;

            case 'pending' :
              
                delete_option('gc_paypal_ipn_' . $request['custom']);

                // send an email if payment is pending
                $mailto = get_option('admin_email');
                $subject = __('PayPal IPN - payment pending', 'appointment');
                $headers = 'From: ' . __('AppointUp Admin', 'appointment') . ' <' . get_option('admin_email') . '>' . "\r\n";

                $message = __('Dear Admin,', 'appointment') . "\r\n\r\n";
                $message .= sprintf(__('The following payment is pending on your %s website.', 'appointment'), $blogname) . "\r\n\r\n";
                $message .= __('Payment Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= sprintf(__('Payer PayPal address: %s', 'appointment'), $request['payer_email']) . "\r\n";
                $message .= sprintf(__('Transaction ID: %s', 'appointment'), $request['txn_id']) . "\r\n";
                $message .= sprintf(__('Payer first name: %s', 'appointment'), $request['first_name']) . "\r\n";
                $message .= sprintf(__('Payer last name: %s', 'appointment'), $request['last_name']) . "\r\n";
                $message .= sprintf(__('Payment type: %s', 'appointment'), $request['payment_type']) . "\r\n";
                $message .= sprintf(__('Amount: %1$s %2$s', 'appointment'), $request['mc_gross'], "(" . $request['mc_currency'] . ")") . "\r\n\r\n";
                $message .= __('Full Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= print_r($request, true) . "\r\n";

                wp_mail($mailto, $subject, $message, $headers);

                break;

            // payment failed so don't approve the ad
            case 'denied' :
            case 'expired' :
            case 'failed' :
            case 'voided' :

                //Expire listing 

                delete_option('gc_paypal_ipn_' . $request['custom']);

                // send an email if payment didn't work
                $mailto = get_option('admin_email');
                $subject = __('PayPal IPN - payment failed', 'appointment');
                $headers = 'From: ' . __('AppointUp Admin', 'appointment') . ' <' . get_option('admin_email') . '>' . "\r\n";

                $message = __('Dear Admin,', 'appointment') . "\r\n\r\n";
                $message .= sprintf(__('The following payment has failed on your %s website.', 'appointment'), $blogname) . "\r\n\r\n";
                $message .= __('Payment Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= sprintf(__('Payer PayPal address: %s', 'appointment'), $request['payer_email']) . "\r\n";
                $message .= sprintf(__('Transaction ID: %s', 'appointment'), $request['txn_id']) . "\r\n";
                $message .= sprintf(__('Payer first name: %s', 'appointment'), $request['first_name']) . "\r\n";
                $message .= sprintf(__('Payer last name: %s', 'appointment'), $request['last_name']) . "\r\n";
                $message .= sprintf(__('Payment type: %s', 'appointment'), $request['payment_type']) . "\r\n";
                $message .= sprintf(__('Amount: %1$s %2$s', 'appointment'), $request['mc_gross'], "(" . $request['mc_currency'] . ")") . "\r\n\r\n";
                $message .= __('Full Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= print_r($request, true) . "\r\n";
                wp_mail($mailto, $subject, $message, $headers);
                break;

            case 'refunded' :
            case 'reversed' :
            case 'chargeback' :

                //Expire listing 
                // send an email if payment was refunded
                $mailto = get_option('admin_email');
                $subject = __('PayPal IPN - payment refunded/reversed', 'appointment');
                $headers = 'From: ' . __('Admin', 'appointment') . ' <' . get_option('admin_email') . '>' . "\r\n";

                $message = __('Dear Admin,', 'appointment') . "\r\n\r\n";
                $message .= sprintf(__('The following payment has been marked as refunded on your %s website.', 'appointment'), $blogname) . "\r\n\r\n";
                $message .= __('Payment Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= sprintf(__('Payer PayPal address: %s', 'appointment'), $request['payer_email']) . "\r\n";
                $message .= sprintf(__('Transaction ID: %s', 'appointment'), $request['txn_id']) . "\r\n";
                $message .= sprintf(__('Payer first name: %s', 'appointment'), $request['first_name']) . "\r\n";
                $message .= sprintf(__('Payer last name: %s', 'appointment'), $request['last_name']) . "\r\n";
                $message .= sprintf(__('Payment type: %s', 'appointment'), $request['payment_type']) . "\r\n";
                $message .= sprintf(__('Reason code: %s', 'appointment'), $request['reason_code']) . "\r\n";
                $message .= sprintf(__('Amount: %1$s %2$s', 'appointment'), $request['mc_gross'], "(" . $request['mc_currency'] . ")") . "\r\n\r\n";
                $message .= __('Full Details', 'appointment') . "\r\n";
                $message .= '-----------------' . "\r\n";
                $message .= print_r($request, true) . "\r\n";

                wp_mail($mailto, $subject, $message, $headers);

                break;
        endswitch;
    }
}

function gc_ipn_data($key) {
    $data = get_option('gc_paypal_ipn_' . $key);
    if ($data) {
        $data = unserialize(base64_decode($data));
        return $data;
    }
}

function insert_data_frontend_ipn($front_apt_id, $front_apt_date, $front_apt_persion_name, $front_apt_name, $front_apt_time, $front_apt_price, $apt_data_email, $apt_data_mobile, $apt_data_message, $apt_lead_form1, $apt_lead_form2, $apt_lead_form3, $apt_lead_form4, $apt_lead_form5, $apt_data_rand, $apt_data_current_date, $apt_payment_method) {
    $parts = explode('/', $front_apt_date);
    $todaydate = $parts[2] . "-" . $parts[1] . "-" . $parts[0];
    global $wpdb;
    $appointment_data = $wpdb->prefix . 'appointment_data';



    $wpdb->insert($appointment_data, array(
        'service_id' => $front_apt_id,
        'apt_data_date' => $front_apt_date,
        'apt_data_persion_name' => $front_apt_persion_name,
        'apt_data_service_name' => $front_apt_name,
        'apt_data_time' => $front_apt_time,
        'apt_data_price' => $front_apt_price,
        'apt_data_email' => $apt_data_email,
        'apt_data_mobile' => $apt_data_mobile,
        'apt_data_message' => $apt_data_message,
        'fieldlabel1' => $apt_lead_form1,
        'fieldlabel2' => $apt_lead_form2,
        'fieldlabel3' => $apt_lead_form3,
        'fieldlabel4' => $apt_lead_form4,
        'fieldlabel5' => $apt_lead_form5,
        'apt_data_rand' => $apt_data_rand,
        'apt_data_current_Date' => $apt_data_current_date,
        'apt_payment_method' => $apt_payment_method,
        'ddmmyyy' => $todaydate
    ));
}

function insert_transaction_ipn($front_apt_id, $apt_txn_booking_date, $apt_txn_service_name, $apt_txn_price, $apt_txn_payer_email, $apt_txn_status, $apt_txn_txnid, $apt_data_rand) {
    global $wpdb;
    $appointment_data = $wpdb->prefix . 'appointment_data';
    $max_id = $wpdb->get_var("SELECT MAX(APTID) FROM $appointment_data");
    $apt_transaction = $wpdb->prefix . 'apt_transaction';
    $query = $wpdb->insert($apt_transaction, array(
        'TXN_ID' => $max_id,
        'service_id' => $front_apt_id,
        'apt_txn_booking_date' => $apt_txn_booking_date,
        'apt_txn_service_name' => $apt_txn_service_name,
        'apt_txn_price' => $apt_txn_price,
        'apt_txn_payer_email' => $apt_txn_payer_email,
        'apt_txn_status' => $apt_txn_status,
        'apt_txn_txnid' => $apt_txn_txnid,
        'apt_data_rand' => $apt_data_rand
    ));
}


/**
 * this function fetches the parameter require to send sms
 */
function twilio_booking_send_sms_ipn($msgtonumber = '', $message = '') {
    $ink_twiliosid = get_option('apt_sms_sid');
    $ink_twiliotoken = get_option('apt_sms_token');
    $msgfromnumber = get_option('apt_sms_number');

    if (!strpos('+', $msgtonumber)) {
        $msgtonumber = "+" . $msgtonumber;
    }
    if ($ink_twiliosid == '' && $ink_twiliotoken = '' && $msgtonumber == '' && $msgfromnumber == '') {
        _e('Some Twilio Credentials are missing. Please enter all the credentials for Twilio', 'appointment');
    } else {
        twilio_sendSms_ipn($ink_twiliosid, $ink_twiliotoken, $msgfromnumber, $msgtonumber, $message);
    }
}

function twilio_sendSms_ipn($sid, $token, $twilioNumber, $to, $message) {
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
