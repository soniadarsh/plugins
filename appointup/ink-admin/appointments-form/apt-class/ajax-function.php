<?php

function text_ajax_process_request() {
    $db_obj = new Apt_DB();
    global $wpdb;
    $apt_dateslot = $db_obj->tbl_dateslot;
    $apt_service = $db_obj->tbl_service;
    $appointment_data = $db_obj->tbl_appointment_data;
    $front_sr_id = isset($_POST["id"]) ? $_POST['id'] : '';
    // first check if data is being sent and that it is the data we want   
    if ($front_sr_id) {
        $datem = new AptService();
        $datechange = $_POST['ids'];
        if (get_option('apt_dformat') == '1') {
            $datechange = str_replace('/', '-', $datechange);
            $datechange = date('m/d/Y', strtotime($datechange));
            $dateformat = explode('/', $datechange);
        } else {
            $datechange = date('m/d/Y', strtotime($datechange));
            $dateformat = explode('/', $datechange);
        }
//        $dateformat = explode('/', $datechange);       
        $front_end_date = $dateformat[1] . '/' . $dateformat[0] . '/' . $dateformat[2];

        $sql_day_chk = $datem->apt_day_cheaking($front_sr_id, $front_end_date);
        $sql_week_chk = $wpdb->get_row("SELECT * FROM $apt_dateslot Where service_id='$front_sr_id'", ARRAY_N);
        $database_first_date = $sql_week_chk[2];
        $database_last_date = $sql_week_chk[3];
        $matchdate = $datem->date_compare($database_last_date, $database_first_date, $front_end_date);
        $i = '';
        if ($matchdate == 'Match') {
            if ($sql_day_chk != 'Not Available') {
                $queries = $wpdb->get_results($sql_day_chk);
                $result = $wpdb->get_results("SELECT apt_data_date, apt_data_time FROM $appointment_data WHERE apt_data_date = '$datechange' AND service_id = $front_sr_id", ARRAY_N);

                $booked_time = array();
                $booked_date = array();

                foreach ($result as $key => $value) {
                    array_push($booked_date, $value[0]);
                    array_push($booked_time, $value[1]);
                }
                $booked_time_count = array_count_values($booked_time);
                
                $all_limit_arr = array();
                if (in_array($datechange, $booked_date)) {
                    foreach ($queries as $query) {
                        $boook_n_t = $query->booking_number_time;
                        $timechk[] = $query->timeslot_start_time . '-' . $query->timeslot_end_time;
                        $avail = $datem->date_available_cheak($front_sr_id, $front_end_date, $timechk);
                        $seat_avail = $datem->seat_available_cheak($front_sr_id, $front_end_date, $timechk);
                        if (($avail != true) || ($boook_n_t > $seat_avail)) {
                            if ($boook_n_t != 0 && $boook_n_t > 0) {
                                $all_time_arr[] = $query->timeslot_start_time . '-' . $query->timeslot_end_time;
                            }
                            $all_limit_arr[$query->timeslot_start_time . '-' . $query->timeslot_end_time] = $query->booking_number_time;
                            $i = "finddata";
                        } //avil true closed if
                    }// end foreach
                    $final_result_booked = array();
                    foreach ($all_limit_arr as $key_limit => $value_limit) {
                        foreach ($booked_time_count as $key_count => $value_count) {
                            if ($key_limit == $key_count) {
                                if ($value_count < $value_limit) {
                                    
                                } else {
                                    $final_result_booked[] = $key_limit;
                                }
                            }
                        }
                    }
                    $avail_time_arr = array_merge(array_diff($all_time_arr, $final_result_booked), array_diff($final_result_booked, $all_time_arr));
                    foreach ($avail_time_arr as $avail_time) {
                        echo '<option>' . $avail_time . '</option>';
                    }

                    if ($i != 'finddata') {
                        echo '<option value="">' . NOT_AVI . '</option>';
                    }
                } else {
                    foreach ($queries as $query) {
                        if ($query->booking_number_time > 0) {
                            echo '<option>' . $query->timeslot_start_time . '-' . $query->timeslot_end_time . '</option>';
                        }
                    }
                }
            } // end daychk if
            else {
                echo '<option value="">' . NOT_AVI . '</option>';
            }
        }    // end match if
        else {
            echo '<option value="" >' . NOT_AVI . '</option>';
        }
        die();
    }
    $rnam = $_POST['price'];
    if (isset($_POST["price"])) {
        $price = get_option('apt_currency_symbol');
        $datechk = $wpdb->get_row("SELECT * FROM $apt_service WHERE service_id = '$rnam' ", ARRAY_N);

        if (!empty($datechk[2])) {
            $prices = '  ' . __('Price is', 'appointment') . '  ' . html_entity_decode($price) . '' . $datechk[2];
        } else {
            $prices = __("Select any service.", 'appointment');
        }
        if ($datechk[3] == 'free' && $datechk[3] != '') {
            $prices = __("This Service Appointment is free", 'appointment');
        }
        // echo " <input type='text' name='sr_price' id='sr_price'  class='inktext inklarge' value='" . $prices . "'/>";
        echo $prices;
        die();
    }
}

add_action('wp_ajax_master_response', 'text_ajax_process_request');
add_action('wp_ajax_nopriv_master_response', 'text_ajax_process_request');
