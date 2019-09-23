<?php
/**
  @ InfoWay front page function
  @ infoway_front()
 * */
add_shortcode('ink-leadcapture', 'leadcapture_frontend');

function leadcapture_frontend($atts = array()) {
    global $wpdb;
    ob_start();
    extract(shortcode_atts(array(
        'mail' => ''
                    ), $atts));
    if (isset($mail) && $mail != '') {
        if (strpos($mail, ',')) {
            $mail_list = explode(',', $mail);
        } else {
            $mail_list = $mail;
        }
    } else {
        $mail_list = array();
    }
    $capfail = false;
    $a = new LeadsSetData();
//require_once(plugin_dir_path(__FILE__) . '/inc/recaptchalib.php');
    $recaptcha = get_option('inklead_recaptcha');
    $publickey = isset($recaptcha['public_key']) ? $recaptcha['public_key'] : "";
    $privatekey = isset($recaptcha['private_key']) ? $recaptcha['private_key'] : "";
# the response from reCAPTCHA
    $resp = null;
# the error code from reCAPTCHA, if any
    $error = null;

    $is_valid = null;
    $captcha_option = get_option('leads-captcha');
    $captcha_option_on = "on";
    if (isset($_POST['leadsubmit']) && $captcha_option === 'on') {
// Get a key from https://www.google.com/recaptcha/admin/create
# was there a reCAPTCHA response?
        if ($_POST["g-recaptcha-response"]) {

//$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            //$resp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);

            $responseKeys = json_decode($resp, true);
            if (intval($responseKeys["success"]) === 0) {
                $is_valid = true;
            } else {
# set the error code so that we can display it
                $is_valid = false;
                $error = $resp->error;
            }
        }
    }
//echo recaptcha_get_html($publickey, $error);
    if (isset($_POST['leadsubmit']) && $captcha_option === 'off') {
        $is_valid = true;
    }

    if ((isset($_POST['leadsubmit'])) && $is_valid == true) {
        global $lead_field_count, $wpdb;
//label1
        if (is_array($_POST['Name'])) {
            $lab2 = $_POST['Name'];
            $chk1 = implode(",", $lab2);
            $lead_form5 = $a->set_lead_name($chk1);
        } else {
            $name = $a->set_lead_name($_POST['Name']);
        }
//label2
        if (is_array($_POST['Email'])) {
            $lab2 = $_POST['Email'];
            $chk1 = implode(",", $lab2);
            $lead_form5 = $a->set_form1($chk1);
        } else {
            $lead_form1 = $a->set_form1($_POST['Email']);
        }
//label3 
        if (is_array($_POST['Number'])) {
            $lab2 = $_POST['Number'];
            $chk1 = implode(",", $lab2);
            $lead_form5 = $a->set_form2($chk1);
        } else {
            $lead_form2 = $a->set_form2($_POST['Number']);
        }
//label4
        if (is_array($_POST['Message'])) {
            $lab2 = $_POST['Message'];
            $chk1 = implode(",", $lab2);
            $lead_form5 = $a->set_form3($chk1);
        } else {
            $lead_form3 = $a->set_form3($_POST['Message']);
        }
//label5
        if (isset($_POST['label1'])) {
            if (is_array($_POST['label1'])) {
                $lab2 = $_POST['label1'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form4($chk1);
            } else {
                $lead_form4 = $a->set_form4($_POST['label1']);
            }
        } else {
            $lead_form4 = $a->set_form4('');
        }
//label6
        if (isset($_POST['label2'])) {
            if (is_array($_POST['label2'])) {
                $lab2 = $_POST['label2'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form5($chk1);
            } else {
                $lead_form5 = $a->set_form5($_POST['label2']);
            }
        } else {
            $lead_form5 = $a->set_form5('');
        }
//label7
        if (isset($_POST['label3'])) {
            if (is_array($_POST['label3'])) {
                $lab2 = $_POST['label3'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form6($chk1);
            } else {
                $lead_form6 = $a->set_form6($_POST['label3']);
            }
        } else {
            $lead_form6 = $a->set_form6('');
        }
//label8
        if (isset($_POST['label4'])) {
            if (is_array($_POST['label4'])) {
                $lab2 = $_POST['label4'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form7($chk1);
            } else {
                $lead_form7 = $a->set_form7($_POST['label4']);
            }
        } else {
            $lead_form7 = $a->set_form7('');
        }
//label9
        if (isset($_POST['label5'])) {
            if (is_array($_POST['label5'])) {
                $lab2 = $_POST['label5'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form8($chk1);
            } else {
                $lead_form8 = $a->set_form8($_POST['label5']);
            }
        } else {
            $lead_form8 = $a->set_form8('');
        }
//label10
        if (isset($_POST['label6'])) {
            if (is_array($_POST['label6'])) {
                $lab2 = $_POST['label6'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form9($chk1);
            } else {
                $lead_form9 = $a->set_form9($_POST['label6']);
            }
        } else {
            $lead_form9 = $a->set_form9('');
        }
//label11
        if (isset($_POST['label7'])) {
            if (is_array($_POST['label7'])) {
                $lab2 = $_POST['label7'];
                $chk1 = implode(",", $lab2);
                $lead_form5 = $a->set_form10($chk1);
            } else {
                $lead_form9 = $a->set_form10($_POST['label7']);
            }
        } else {
            $lead_form9 = $a->set_form10('');
        }
//randvalue
        $rand = $a->set_randvalue($_POST['randvalue']);
        if (isset($_POST['leadsubmit'])) {
            global $wpdb;
            $a->email_send($mail_list);
            $a->savetodb();
        }
    }
    ?> 
    <script>
        function dynamic_validate() {
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
                            jQuery(this).closest('.inkleadradiobox').append('<label for="' + for_val + '" class="error dynamic_radio">Please enter valid value&nbsp;</label>');
                        }
                    }
                });
            }, 100);
        }
    </script>
    <div class="inkleadsform-conatainer">
        <?php if ((!isset($_POST['leadsubmit'])) || (!$is_valid)) { ?>
            <div class="inkleadheading"> <h2 class="heading"><?php echo get_option('leadcapture-heading') != '' ? get_option('leadcapture-heading') : 'Capture Your Lead'; ?></h2></div>
            <div class="inlleadsform-wrapper">

                <div class="inkleadsform-top"></div>
                <div class="inkleadsform">
                    <div class="inklead_form_wrap">
                        <form action="#" name="inkleadsform" onSubmit="dynamic_validate()" id="sign_in_form" class="sign_in_form" method="post" autocomplete="on">
                            <ul class="inkleadsul">
                                <?php
                                global $lead_field_count, $wpdb;
                                $sqlfeatch = $wpdb->get_results("SELECT * FROM $lead_field_count", ARRAY_A);
                                foreach ($sqlfeatch as $row) {
                                    $id = $row["ID"];
                                    $texttype = $row["text_name"];
                                    $textname = $row["text_value"];
                                    $textid = $row["text_label"];
                                    $required = $row["required"];
                                    if ($texttype == 'text') {
                                        $leads_text = leads_text($textname, $textid, $texttype, $required, $id);
                                    }
                                    if ($texttype == 'number') {
                                        $leads_number = leads_text($textname, $textid, $texttype, $required, $id);
                                    }
                                }
                                ?>
                            </ul>

                            <ul class="inklead_btn_box">
                                <?php
                                foreach ($sqlfeatch as $row) {
                                    $id = $row["ID"];
                                    $texttype = $row["text_name"];
                                    $textname = $row["text_value"];
                                    $textid = $row["text_label"];
                                    $required = $row["required"];
                                    if ($texttype == 'checkbox') {
                                        ?>
                                        <div class="checkpanel">
                                            <span class="lead_cname">
                                                <?php
                                                echo "<span class='lead_checkheading'>" . $textname . "</span>";
                                                ?>
                                            </span>
                                        </div>
                                        <li class="inkleadcheckbox">
                                            <?php
                                            $leads_chkbox = leads_chkbox($textid, $id);
                                            ?>
                                        </li>
                                    <?php } ?>

                                    <?php if ($texttype == 'radio') { ?>

                                        <div class="radiopanel">
                                            <span class="lead_rname">
                                                <?php
                                                echo "<span class='lead_radioheading'>" . $textname . "</span>";
                                                ?>
                                            </span>
                                        </div>

                                        <li class="inkleadradiobox" id="<?php echo $id . '_inkleadradiobox'; ?>">
                                            <?php
                                            $leads_radio = leads_radio($textid, $id, $required);
                                            ?>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>

                            <ul class="inkleadsul">
                                <?php
                                foreach ($sqlfeatch as $row) {
                                    $id = $row["ID"];
                                    $texttype = $row["text_name"];
                                    $textname = $row["text_value"];
                                    $textid = $row["text_label"];
                                    $required = $row["required"];

                                    if ($texttype == 'textarea') {

                                        $leads_textarea = leads_textarea($textname, $textid, $required, $id);
                                    }
                                }
                                $captcha_option_on = "on";
                                if ($captcha_option === $captcha_option_on) {
                                    ?>
                                    <li class="inkleadcaptcha">
                                        <div id="recaptcha_widget">
                                            <div class="g-recaptcha" data-sitekey="<?php echo $publickey ?>"></div>
                                        </div>
                                    </li>

                                    <?php
                                } //captcha on/off
                                if (!$is_valid && isset($_POST['leadsubmit'])) {
                                    echo "<br/><div class='captcha_color'> <p id='error_msg'>" . __('The captcha was incorrect.', 'leadcapture') . "</p></div>";
                                }
                                ?>

                            </ul>
                           
                                <div class="btn_btn_submit">
                                    <div class = "inkleadsbutton">
                                        <input class = "btnsubmit" type = "submit" name = "leadsubmit" value = "<?php echo (get_option('lead_btn_txt') != '') ? get_option('lead_btn_txt') : _e('Send Your Message', 'leadcapture'); ?>"/>
                                        <input type = "hidden" name = "randvalue" id = "randvalue" value = "<?php echo rand(); ?>" />
                                    </div>
                                </div>
                        </form>
                    </div>

                </div>
                <div class = "inkleadsform-bottom"></div>
            </div>
        <?php }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
?>