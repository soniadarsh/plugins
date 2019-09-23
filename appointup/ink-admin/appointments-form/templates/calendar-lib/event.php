<?php

/*
 * Hook our function , apt_send_reminder_email(), into the action apt_send_reminder 
 */
add_action('apt_send_reminder', 'apt_send_reminder_email');

/*
 * Hook our function , apt_get_appointment_date(), into the action apt_schedule 
 */
add_action('apt_schedule', 'apt_get_appointment_date');

/*
 * Add custom cron intervals
 */
add_filter('cron_schedules', 'apt_cron_add_twicehourly');

/**
 * add cron event on activation
 */
function apt_on_activate() {
    if (!wp_next_scheduled('apt_schedule')) {
        wp_schedule_event(time(), 'apt_twicehourly', 'apt_schedule');
    }
}

/**
 * remove cron events on deactivation
 */
function apt_on_deactivate() {
    while (wp_next_scheduled('apt_schedule')) {
        $timestamp = wp_next_scheduled('apt_schedule');
        wp_unschedule_event($timestamp, 'apt_schedule');
    }
}

/**
 * 
 * function name: apt_cron_add_twicehourly
 * function description: add cron interval for 30 Min
 * @param type $schedules
 * @return string
 */
function apt_cron_add_twicehourly($schedules) {
    $schedules['apt_twicehourly'] = array(
        'interval' => 1800,
        'display' => 'Twice Hourly (30 Min)'
    );
    return $schedules;
}

/**
 * 
 * function name: apt_get_appointment_date
 * function description: this function get appointments for particular day and call apt_schedule_cron_reminder to send reminder email.
 * @global type $wpdb
 * @global type $table_prefix
 * @global string $table_appointment_data
 */
function apt_get_appointment_date() {
    
    global $wpdb, $table_prefix, $table_appointment_data;
    $table_appointment_data = $table_prefix . "appointment_data";
    $apt_date = apt_get_reminder_days();
    $appointment_data = $wpdb->get_results("SELECT * FROM $table_appointment_data where ddmmyyy = '$apt_date'", ARRAY_A);
    if (!empty($appointment_data)) {
        foreach ($appointment_data as $value) {
            $apt_id = $value['APTID'];
            $booking_date = strtotime($value['apt_data_current_date']);
            $time_to_add_cron_event = date("g:i a", $booking_date);
            $date_to_add_cron_event = date("F j, Y");
            $cron_event_time = $date_to_add_cron_event . ", " . $time_to_add_cron_event;
//            $apt_time = strtotime(date("F j, Y, g:i a"));
            $reminder_status = apt_check_reminder($apt_id);
            if (!$reminder_status) {
                apt_schedule_cron_reminder(strtotime($cron_event_time), 'APTID_' . $apt_id);
            } else {
                apt_clear_scheduled_hook('apt_send_reminder', 'APTID_' . $apt_id);
            }
        }
    }
}

/**
 * 
 * function name: apt_get_reminder_days
 * function description: Give the number of days before the reminder mail is to be send
 * @return string
 */
function apt_get_reminder_days() {
    $days = get_option('apt_reminder_day');
    switch ($days) {
        case 1:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 1);
            break;
        case 2:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 2);
            break;
        case 3:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 3);
            break;
        case 4:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 4);
            break;
        case 5:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 5);
            break;
        case 6:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 6);
            break;
        case 7:
            $apt_date = date('Y') . '-' . date('m') . '-' . (date('d') + 7);
            break;
        default:
            $apt_date = date('Y') . '-' . date('m') . '-' . date('d');
            break;
    }
    return $apt_date;
}

/**
 * 
 * function name: apt_check_reminder
 * function description: check the reminder mail send or not, if send return send else return false.
 * @global type $wpdb
 * @global type $table_prefix
 * @global string $table_reminder
 * @param type $APTID
 * @return boolean
 */
function apt_check_reminder($APTID) {
    global $wpdb, $table_prefix, $table_reminder;
    $table_reminder = $table_prefix . 'apt_reminder';
    $reminder_status = $wpdb->get_results("SELECT apt_reminder_id FROM $table_reminder where apt_id = $APTID", ARRAY_A);
    if ($reminder_status) {
        return $reminder_status;
    } else {
        return false;
    }
}

/**
 * 
 * function name: apt_send_reminder_email
 * function description : send reminder mail to the user as well as admin.
 * @global type $wpdb
 * @global type $table_prefix
 * @param type $apt_id
 */
function apt_send_reminder_email($apt_id) {
    global $wpdb, $table_prefix, $table_appointment_data;
    $table_appointment_data = $table_prefix . "appointment_data";
    $table_reminder = $table_prefix . 'apt_reminder';
    $id_string = explode("_", $apt_id);
    $APTID = $id_string[1];
    $appointment_data = $wpdb->get_row("SELECT * FROM $table_appointment_data where APTID = '$APTID'", ARRAY_A);
    $mail_send = get_option('apt_reminder_mail');
    $mail_reminder_subject = (get_option('apt_reminder_subject') != '' ? get_option('apt_reminder_subject') : 'Appointment Reminder..........');

    if ($mail_send == "yes") {
        $clinte_email = $appointment_data['apt_data_email'];
        $admin_mail = (get_option('apt_reminder_mail_from') != '') ? get_option('apt_reminder_mail_from') : get_option('admin_email');
        $adminurl = str_replace('https://', '', site_url());
        $subject = $mail_reminder_subject;
        $message = sprintf(__("Hello %s", 'appointment'), $appointment_data['apt_data_persion_name']) . "<br/><br/>";
        $message .= 'This is the reminder notification for your appointment.';
        $message .='Here are the details:<br/><br/>';
        $message .= sprintf(__("Service Name: %s", 'appointment'), $appointment_data['apt_data_service_name']) . "<br/>";
        $message .= sprintf(__("Appointment Date: %s", 'appointment'), $appointment_data['apt_data_date']) . "<br/>";
        $message .= sprintf(__("Appointment Time: %s", 'appointment'), $appointment_data['apt_data_time']) . "<br/>";
        $message .= sprintf(__("Amount Paid: %s", 'appointment'), $appointment_data['apt_data_price']) . "<br/>";
        $message .= sprintf(__("Date: %s", 'appointment'), $appointment_data['apt_data_current_date']) . "<br/><br/>";
        $message .= __("Thanks for booking with us.", 'appointment') . "<br/>";
        $message .= "Warm Regards,<br/><br/>";
    //    $message .= "$adminurl<br/>";

        $mail_to_admin = get_option('apt_reminder_to_admin');

        if ($mail_to_admin == "yes") {
            $message1 = 'This is the reminder Email.<br/><br/>';
            $message1 .='Below are the appointment details of the client<br/><br/>';
            $message1 .= sprintf(__("Client Name: %s", 'appointment'), $appointment_data['apt_data_persion_name']) . "<br/>";
            $message1 .= sprintf(__("Service Name: %s", 'appointment'), $appointment_data['apt_data_service_name']) . "<br/>";
            $message1 .= sprintf(__("Appointment Date: %s", 'appointment'), $appointment_data['apt_data_date']) . "<br/>";
            $message1 .= sprintf(__("Appointment Time: %s", 'appointment'), $appointment_data['apt_data_time']) . "<br/>";
            $message1 .= sprintf(__("Amount Paid: %s", 'appointment'), $appointment_data['apt_data_price']) . "<br/>";
            $message1 .= sprintf(__("Date: %s", 'appointment'), $appointment_data['apt_data_current_date']) . "<br/><br/>";
            $message1 .= __("Thanks for using AppointUp plugin.", 'appointment') . "<br/>";
            $message1 .= __("Warm Regards,<br/><br/>", 'appointment');
          //  $message1 .= "https://www.inkthemes.com <br/>";
            //$headers = "From: " . strip_tags($admin_mail) . "\r\n";
            $headers = "Reply-To: " . strip_tags($clinte_email) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $email_result = wp_mail($admin_mail, $subject, $message1, $headers);
        }
        $header = "From: " . strip_tags($admin_mail) . "\r\n";
        $header .= "Reply-To: " . strip_tags($admin_mail) . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $email_result = wp_mail($clinte_email, $subject, $message, $header);
        if ($email_result) {
            $wpdb->insert($table_reminder, array(
                'apt_id' => $APTID,
                'apt_email' => $clinte_email,
                'apt_date' => date('Y-m-d H:i:s'),
                'apt_status' => 'send'
            ));
        }
        /* code to send ama to user */
        $is_sms_on = get_option('sms_enable');
        if ($is_sms_on == 'on') {
            $sr_apt_persion_name = $appointment_data['apt_data_persion_name'];
            $sr_apt_phone = $appointment_data['apt_data_mobile'];
            $apt_txn_booking_date = $appointment_data['apt_data_date'];
            $sr_apt_time = $appointment_data['apt_data_time'];
            $user_phone = $sr_apt_phone;
            $message_user = 'Hello ' . $sr_apt_persion_name . ' Your Appointment has been booked on ' . $apt_txn_booking_date . ', for the timeslot of ' . $sr_apt_time;
            twilio_booking_send_sms($user_phone, $message_user);
        }
    }
}

/**
 * 
 * function name: apt_schedule_cron_reminder
 * function description: scheduled 'apt_send_reminder' cron event with appointment id as an argument.
 * @param type $apt_time
 * @param type $apt_id
 */
function apt_schedule_cron_reminder($apt_time, $apt_id) {
    wp_clear_scheduled_hook('apt_send_reminder', array($apt_id));
    if (!wp_next_scheduled("apt_send_reminder")) {
        wp_schedule_single_event($apt_time, 'apt_send_reminder', array($apt_id));
    }
}

/**
 * Unscheduled all cron jobs attached to a specific hook.
 *
 *
 * @param string $hook Action hook, the execution of which will be unscheduled.
 * @param array $args Optional. Arguments that were to be pass to the hook's callback function.
 * @return type
 */
function apt_clear_scheduled_hook($hook, $args = array()) {
    if (!is_array($args)) {
        $args = array_slice(func_get_args(), 1);
    }
    $crons = _get_cron_array();
    if (empty($crons))
        return;

    $key = md5(serialize($args));
    foreach ($crons as $timestamp => $cron) {
        if (isset($cron[$hook][$key])) {
            wp_unschedule_event($timestamp, $hook, $args);
        }
    }
}
