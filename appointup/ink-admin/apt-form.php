<?php
//if (file_exists($db_obj1->dir . "ink-admin/appointments-form/Twilio/autoload.php")) {
//    require_once $db_obj1->dir . 'ink-admin/appointments-form/Twilio/autoload.php';
//}


add_shortcode('ink-appointments-form', 'ink_appoitment');

function get_disable_days() {
    $apt_bulk_days = get_option('apt_disable_days');
    $bulk_day_return = '';
    if (is_array($apt_bulk_days)) {
        $count = 0;
        end($apt_bulk_days);
        $last_key = array_search(key($apt_bulk_days), array_keys($apt_bulk_days));
        foreach ($apt_bulk_days as $days) {
            if ($last_key > $count) {
                $bulk_day_return .= $days . ',';
            } else {
                $bulk_day_return .= $days;
            }
            $count++;
        }
    }
    return $bulk_day_return;
}

function get_specific_days_to_work() {
    $apt_excp_open = get_option('apt_excp_open');
    $dates_return = '';
    $dates = explode(",", $apt_excp_open);
    if (is_array($dates)) {
        $count = 0;
        end($dates);
        $last_key = key($dates);
        foreach ($dates as $date) {
            if ($last_key > $count) {
                $dates_return .= '"' . $date . '",';
            } else {
                $dates_return .= '"' . $date . '"';
            }
            $count++;
        }
    }
    return $dates_return;
}

function get_specific_days_nottowork() {
    $apt_excp_close = get_option('apt_excp_close');
    $dates_return = '';
    $dates = explode(",", $apt_excp_close);
    if (is_array($dates)) {
        $count = 0;
        end($dates);
        $last_key = key($dates);
        foreach ($dates as $date) {
            if ($last_key > $count) {
                $dates_return .= '"' . $date . '",';
            } else {
                $dates_return .= '"' . $date . '"';
            }
            $count++;
        }
    }
    return $dates_return;
}

function ink_appoitment() {
    global $wpdb;
    ob_start();
    $date_dformat = get_option('apt_dformat');
    switch ($date_dformat) {
        case '1':
            $date_format = 'dd/mm/yy';
            break;
        case '2':
            $date_format = 'mm/dd/yy';
            break;
        case '3':
            $date_format = 'dd-M-yy';
            break;
        default:
            $date_format = 'dd/mm/yy';
            break;
    }
    $obj_data = new Apt_DB();
    $lead_field_table = $obj_data->tbl_apt_lead_field_table;
    $lead_field_count = $obj_data->tbl_apt_lead_field_count;
    $lead_select_field = $obj_data->tbl_apt_lead_select_field;
    ?>
    <script>
        jQuery.noConflict();

        var SpecificDaysToWork = [<?php echo get_specific_days_to_work(); ?>];
        var SpecificDaysNotToWork = [<?php echo get_specific_days_nottowork(); ?>];
        var disabledDays = [<?php echo get_disable_days(); ?>];
        function disableSpecificDaysAndWeekends(date) {
            var m = date.getMonth();
            var d = date.getDate();
            var y = date.getFullYear();
            var day = date.getDay();
            if (jQuery.inArray(day, disabledDays) !== -1) {
                if (jQuery.inArray((m + 1) + '-' + d + '-' + y, SpecificDaysToWork) !== -1) {
                    return [true];
                } else {
                    return [false];
                }
            } else {
                if (jQuery.inArray((m + 1) + '-' + d + '-' + y, SpecificDaysNotToWork) !== -1) {
                    return [false];
                } else {
                    return [true];
                }
            }

        }

        function dynamic_validate() {
            console.log("hello");
            setTimeout(function () {

                jQuery('.dynamic_radio').remove();
                loop_id = '';
                jQuery('.inkleadradiobox input[type="radio"]').each(function () {
                    curr_id = jQuery(this).closest('.inkleadradiobox').attr('id');
                    curr_id = curr_id.replace('_inkleadradiobox', "");
                    if (loop_id != curr_id) {
                        if (jQuery(this).hasClass("error")) {
                            loop_id = curr_id;
                            var for_val = jQuery(this).attr('name');
                            jQuery(this).closest('.inkleadradiobox').append('<label for="' + for_val + '" class="error dynamic_radio">Please enter valid value</label>');
                        }
                    }
                });

            }, 100);
        }

        /** init datepicker */
        jQuery(document).ready(function () {
            jQuery.datepicker.setDefaults({
                dateFormat: '<?php echo $date_format ?>',
            });

            jQuery('#aptcal').datepicker({
                minDate: 0,
                beforeShowDay: disableSpecificDaysAndWeekends
            });

        });

    </script>
    <?php
    $db_obj = new Apt_DB();
    global $wpdb;
    $cpt_true = false;
    $apt_service = $db_obj->tbl_service;
    $check_apt = isset($_POST['chk_apt']) ? $_POST['chk_apt'] : null;
    $cpt_apt = isset($_POST['apt_cpt']) ? $_POST['apt_cpt'] : null;
    if ($check_apt != $cpt_apt) {
        $cpt_true = true;
    }
    $msg = '';
    $captcha_details = '';
    $is_captcha_on = get_option('cpt_enable');
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $is_captcha_on == 'on') {
        $recaptcha = $_POST['g-recaptcha-response'];
        if (!empty($recaptcha)) {
            $secret = get_option('apt_recaptcha_private');
            $secret = empty($secret) ? 'Google secret key' : $secret;
            $captcha_data = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $_POST['g-recaptcha-response']);
            $response = json_decode($captcha_data, TRUE);
            if ($response['success']) {
                $captcha_details = true;
            } else {
                $captcha_details = false;
                $error = array_search("invalid-input-secret", $response['error-codes']);
                if ($error == 0) {
                    $msg = __("Please enter correct reCAPTCHA key.", 'appointment');
                } else {
                    $msg = __("Please re-enter your reCAPTCHA.", 'appointment');
                }
            }
        } else {
            $captcha_details = false;
            $msg = __("Please re-enter your reCAPTCHA.", 'appointment');
        }
    }
    $blank_data = "";
    if ((isset($_POST['submit']) && $is_captcha_on != 'on' && $cpt_true == false ) || (isset($_POST['submit']) && $captcha_details == true)) {
        if (!isset($_POST['time']) || $_POST['time'] == '' || ($_POST['service_select'] == "")) {
            //_e("<p class='error_msg'>Please Insert All data.</p>", 'appointment');
            echo '<script type="text/javascript">  alert("Please insert all data.");</script>';
            $blank_data = true;
        } else {
            //label1
            if (isset($_POST['label1'])) {
                if (is_array($_POST['label1'])) {
                    $lab2 = $_POST['label1'];
                    $chk1 = implode(",", $lab2);
                    $lead_form1 = $chk1;
                } else {
                    $lead_form1 = $_POST['label1'];
                }
            } else {
                $lead_form1 = '';
            }
            //label2
            if (isset($_POST['label2'])) {
                if (is_array($_POST['label2'])) {
                    $lab2 = $_POST['label2'];
                    $chk1 = implode(",", $lab2);
                    $lead_form2 = $chk1;
                } else {
                    $lead_form2 = $_POST['label2'];
                }
            } else {
                $lead_form2 = '';
            }

            //label3
            if (isset($_POST['label3'])) {
                if (is_array($_POST['label3'])) {
                    $lab2 = $_POST['label3'];
                    $chk1 = implode(",", $lab2);
                    $lead_form3 = $chk1;
                } else {
                    $lead_form3 = $_POST['label3'];
                }
            } else {
                $lead_form3 = '';
            }
            //label4
            if (isset($_POST['label4'])) {
                if (is_array($_POST['label4'])) {
                    $lab2 = $_POST['label4'];
                    $chk1 = implode(",", $lab2);
                    $lead_form4 = $chk1;
                } else {
                    $lead_form4 = $_POST['label4'];
                }
            } else {
                $lead_form4 = '';
            }
            //label5
            if (isset($_POST['label5'])) {
                if (is_array($_POST['label5'])) {
                    $lab2 = $_POST['label5'];
                    $chk1 = implode(",", $lab2);
                    $lead_form5 = $chk1;
                } else {
                    $lead_form5 = $_POST['label5'];
                }
            } else {
                $lead_form5 = '';
            }

            $blank_data = false;
            echo $badUrl = (isset($_POST['sr_price'])) ? $_POST['sr_price'] : null;
            /* code to find out weather service is paid or free */
            $sr_aptfr_id = $_POST['service_select'];
            $sql_frdata = $wpdb->get_row("SELECT * FROM $apt_service Where service_id='$sr_aptfr_id'", ARRAY_N);
            if (isset($_GET['page']) && $_GET['page'] == 'manualappointment') {
                $datechange = $_POST['aptcal'];
                $dateformat = explode('/', $datechange);
                $newaptdate = $dateformat[1] . '/' . $dateformat[0] . '/' . $dateformat[2];
                manual_payment($_POST['service_select'], $_POST['time'], $datechange, $_POST['fname'], $_POST['aptemail'], $_POST['aptphone'], $_POST['aptmessage'], $lead_form1, $lead_form2, $lead_form3, $lead_form4, $lead_form5, $_POST['random']);
            } elseif ($sql_frdata[3] == 'free') {
                $datechange = $_POST['aptcal'];
                $dateformat = explode('/', $datechange);
                $newaptdate = $dateformat[1] . '/' . $dateformat[0] . '/' . $dateformat[2];
                free_payment($_POST['service_select'], $_POST['time'], $datechange, $_POST['fname'], $_POST['aptemail'], $_POST['aptphone'], $_POST['aptmessage'], $lead_form1, $lead_form2, $lead_form3, $lead_form4, $lead_form5, $_POST['random']);
            } elseif (get_option('apt_paypal') == "sandbox") {
                gateway_sandbox();
            } elseif (get_option('apt_paypal') == "paypal") {
                gateway_paypal();
            } elseif (get_option('apt_paypal') == "cash") {
                $datechange = $_POST['aptcal'];
                $dateformat = explode('/', $datechange);
                $newaptdate = $dateformat[1] . '/' . $dateformat[0] . '/' . $dateformat[2];
                cash_payment($_POST['service_select'], $_POST['time'], $datechange, $_POST['fname'], $_POST['aptemail'], $_POST['aptphone'], $_POST['aptmessage'], $lead_form1, $lead_form2, $lead_form3, $lead_form4, $lead_form5, $_POST['random']);
            }
        }
    }
    if (isset($_GET['paypal-trans'])) {
        ink_apt_trans_display();
    } else {
        $ruri = $_SERVER['REQUEST_URI'];
        $sname = $_SERVER['SERVER_NAME'];
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $fullpath = 'https://' . $sname . $ruri;
        } else {
            $fullpath = 'http://' . $sname . $ruri;
        }
        update_option('return_apt_url', $fullpath);
        $br = new AptService();
        $iechk = $br->ink_browser();
        if ((!isset($_POST['submit'])) || ($check_apt != $cpt_apt) || ($captcha_details == false) || ($blank_data == true)) {
            ?>
            <div class="ink-container">
                <div class="inkappointment_wrapper">
                    <div class="inkappointment_form_top">
                    </div>
                    <div class="inkappointment_form_wrapper">
                        <form method="post" action="" onSubmit="dynamic_validate()" id="ink-form" name="ink-form" class="ink-form" >
                            <header id="ink-header" class="ink-info"></header>

                            <div class="textheading main-head">
                                <h2>
                                    <span class="msg_text">
                                        <?php echo get_option('apt_form_head'); ?>
                                    </span>
                                </h2>
                            </div>

                            <div class="head_divider"></div>

                            <ul class="inkappform">
                                <li class="textfname">
                                    <input type="text" name="fname" id="fname" class="inktext inklarge inkrequired" placeholder="<?php _e('Name', 'appointment'); ?>"  maxlength="100" />
                                    <!--                                    <label id="apt_error"></label>-->
                                </li>
                                <li class="textaptemail">
                                    <input type="email" name="aptemail" id="aptemail" class="inktext inklarge inkrequired" placeholder="<?php _e('Email', 'appointment'); ?>"  maxlength="100" />
                                </li>
                                <li class="textaptphone">
                                    <input type="number" name="aptphone" id="aptphone" class="inktext inklarge" placeholder="<?php _e('Contact Number', 'appointment'); ?>" maxlength="100" />
                                </li>

                                <!--                            </ul>-->
                                <li class="textfixdate main-head">
                                    <h4>
                                        <span class="fix_date">
                                            <?php echo get_option('apt_fix_date'); ?>
                                        </span>
                                    </h4>
                                </li>

                                <!--                            <ul class="inkappform">-->
                                <li class="select_item">
                                    <select  id="service_select" name="service_select" class="inktext inklarge inkrequired">
                                        <option value=""><?php _e('Select Service', 'appointment'); ?></option>
                                        <?php
                                        $showts = $wpdb->get_results("SELECT * FROM $apt_service ", ARRAY_A);
                                        foreach ($showts as $timerow) {
                                            ?>
                                            <option value="<?php echo $timerow['service_id']; ?>"><?php echo $timerow['service_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </li>
                                <li class="textaptcal">
                                    <input type="text" name="aptcal" id="aptcal" class="dateField inktext inklarge" placeholder="<?php _e('Select Date', 'appointment'); ?>" />
                                </li>
                                <li class="select_item_time">
                                    <select id="time" name="time" class="inktext inklarge inkrequired">
                                        <option value=""><?php _e('Select Time', 'appointment'); ?></option>  
                                    </select>
                                </li>
                                <li class="textprice">
                                    <div id="price">
                                        <?php
                                        if (isset($_GET['page']) && $_GET['page'] == 'manualappointment') {
                                            ?>
                                            <input type="hidden" name="sr_price" id="sr_price"  class="inktext inklarge inkrequired" value="admin"/>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="text" name="sr_price" id="sr_price"  class="inktext inklarge inkrequired" value="<?php _e('Service Price', 'appointment'); ?>"/>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </li>
                                <!-- Custom fields start -->
                                <?php
                                global $wpdb;
//                                global $lead_field_count;
                                $sqlfeatch = $wpdb->get_results("SELECT * FROM $lead_field_count", ARRAY_A);
                                foreach ($sqlfeatch as $row) {
                                    $id = $row["ID"];
                                    $texttype = $row["text_name"];
                                    $textname = $row["text_value"];
                                    $textid = $row["text_label"];
                                    $required = $row["required"];
                                    if ($texttype == 'text') {
                                        $leads_textare = apt_leads_text($textname, $textid, $texttype, $required, $id);
                                    }
                                    if ($texttype == 'number') {
                                        $leads_num = apt_leads_number($textname, $textid, $texttype, $required, $id);
                                    }
                                    if ($texttype == 'textarea') {
                                        ?>
                                        <?php $leads_textare = apt_leads_textarea($textname, $textid, $required, $id); ?>
                                        <?php
                                    }
                                    if ($texttype == 'checkbox') {
                                        ?>
                                        <div class="inkleadcheckbox">
                                            <div class="checkpanel">
                                                <span class="cname">
                                                    <?php
                                                    echo "<span class='checkheading'><h4>" . $textname . "</h4></span>";
                                                    $leads_chkbox = apt_leads_chkbox($textid, $id);
                                                    ?>
                                                </span>
                                            </div> 
                                        </div>
                                    <?php } ?>

                                    <?php if ($texttype == 'radio') { ?>
                                        <div class="inkleadradiobox" id="<?php echo $id . '_inkleadradiobox'; ?>">
                                            <div class="radiopanel">
                                                <span class="rname">
                                                    <?php
                                                    echo "<span class='radioheading'><h4>" . $textname . "</h4></span>";
                                                    $leads_radio = apt_leads_radio($textid, $id, $required);
                                                    ?>
                                                </span>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <!--custom field end-->
                            <div class="textfixdate1 main-head" style="display:none">
                                <h4>
                                    <span class="fix_date"><?php //echo get_option('apt_custom_msg');  ?></span>
                                </h4>
                                <ul class="inkappform">
                                    <div class = "textaptmessage">
                                        <textarea name = "aptmessage" id = "aptmessage" class = "inktext inklarge" maxlength = "255" rows = "3" cols = "50" placeholder = "<?php _e('Your Message (Optional)', 'appointment'); ?>" ></textarea>
                                    </div>
                                </ul>
                            </div>

                            <?php if ($is_captcha_on === 'on') {
                                ?>

                                <div class="g-recaptcha-div"><div class="g-recaptcha" data-sitekey="<?php
                if (get_option('apt_recaptcha_public')) {
                    echo get_option('apt_recaptcha_public');
                } else {
                    echo 'Google Public Key';
                }
                                ?>">
                                    </div>
                                </div>
                                <span class='msg'><?php echo $msg; ?></span>

                            <?php } ?>
                            <div class="submit_bg">
                                <input type="hidden" name="random" id="random"  value="<?php echo rand(); ?>"/>
                                <input type="submit" name="submit" id="submit"  class='ink-submit inkrequired' value="<?php echo (get_option('apt_btn_txt') != '') ? get_option('apt_btn_txt') : _e('Book Appointment', 'appointment'); ?>"/>
                            </div>
                            <!--                            </ul>-->
                        </form>
                    </div>
                    <div class="inkappointment_form_bottom">
                    </div>
                </div>
            </div>
            <?php
        } //submit not set
    }
    return ob_get_clean();
}
