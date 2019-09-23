<?php
$ipn = get_option('paypal_ipn');
global $wpdb;
if (isset($_POST['curradd'])) {
    if (isset($_POST['currname']) && $_POST['currcode'] && $_POST['currsymbol']) {
        $currname = $_POST['currname'];
        $currcode = $_POST['currcode'];
        $currsymbol = $_POST['currsymbol'];
        $query = $wpdb->insert($wpdb->prefix . 'apt_currency', array(
            'apt_c_name' => $currname,
            'apt_c_code' => $currcode,
            'apt_c_symbol' => $currsymbol,
            'apt_c_des' => ''
        ));
        if ($query):
            echo "<h4>Currency Inserted Successfully</h4>";
            header('Location:' . admin_url() . 'admin.php?page=paymentsettings');
        endif;
    } else {
        echo "<h4>Please Fill Up The Complete Data</h4>";
    }
}
?>

<div class="wrap" id="of_container">
    <div id="of-popup-save" class="of-save-popup">
        <div class="of-save-save"></div>
    </div>
    <div id="of-popup-reset" class="of-save-popup">
        <div class="of-save-reset"></div>
    </div>
    <div id="header">
        <div class="logo">
            <h2><?php echo APT_ADV_SETTING; ?></h2>
        </div>
        <a href="https://www.inkthemes.com" target="new">
            <div class="icon-option"></div>
        </a>

        <div class="clear"></div>
    </div>
    <form enctype="multipart/form-data" id="ofform" name="price_form" method="post">
        <div id="main">
            <div id="of-nav">
                <ul>
                    <li><a class="pn-view-a" href="#of-option-paypalsetting" title="paypalsetting"><?php echo PAYPAL_SETTING; ?></a></li>
                    <li><a class="pn-view-a" href="#of-option-manage-currency" title="manage-currency"><?php echo PAYPAL_CURR; ?></a></li>
                    <li><a class="pn-view-a" href="#of-option-excp-date-setting" title="excp-date-settings"><?php _e("Date Exceptions", "appointment"); ?></a></li>
                    <li><a class="pn-view-a" href="#of-option-rmail-setting" title="rmail-settings"><?php _e("Reminder Email Settings", "appointment"); ?></a></li>
                    <li><a class="pn-view-a" href="#of-option-sms-setting" title="sms-settings"><?php _e("SMS Settings", "appointment"); ?></a></li>
                    <li><a class="pn-view-a" href="#of-option-style-setting" title="style-settings"><?php _e("Form Styles", "appointment"); ?></a></li>
                    <li><a class="pn-view-a" href="#of-option-other-setting" title="Other-settings"><?php _e("Other Settings", "appointment"); ?></a></li>
                </ul>
            </div>
            <div id="content">
                <div class="group" id="of-option-paypalsetting">
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo APT_HEAD; ?></h3>
                        <div class="option">
                            <div class="controls">
                                <input name="apt_form_head" type="text" id="apt_form_head" value="<?php echo get_option('apt_form_head'); ?>" class="of-input"/>
                                <br/>
                                <span id="pkg_error"></span>
                            </div>
                            <div class="explain"><?php echo APT_HEAD_DES; ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo APT_FIX_HEAD; ?></h3>

                        <div class="option">
                            <div class="controls">
                                <input name="apt_fix_date" type="text" id="apt_fix_date"
                                       value="<?php echo get_option('apt_fix_date'); ?>" class="of-input"/>
                                <br/>
                                <span id="pkg_error"></span>
                            </div>
                            <div class="explain"><?php echo APT_FIX_DES; ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo __('Appointment Button Text', 'appointment'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <input name="apt_btn_txt" type="text" id="apt_btn_txt"
                                       value="<?php echo get_option('apt_btn_txt'); ?>" class="of-input"/>
                                <br/>
                                <span id="pkg_error"></span>
                            </div>
                            <div class="explain"><?php echo __('Enter the text which you want to show over the submit button', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo APT_MSG_HEAD; ?></h3>

                        <div class="option">
                            <div class="controls">
                                <input name="apt_custom_msg" type="text" id="apt_custom_msg"
                                       value="<?php echo get_option('apt_custom_msg'); ?>" class="of-input"/>
                                <br/>
                                <span id="pkg_error"></span>
                            </div>
                            <div class="explain"><?php echo APT_MSG_DES; ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo MERCHANT_ID; ?></h3>

                        <div class="option">
                            <div class="controls">
                                <input name="merchaint_email" type="text" id="merchaint_email"
                                       value="<?php echo get_option('apt_merchaint_email'); ?>" class="of-input"/>
                                <br/>
                                <span id="pkg_error"></span>
                            </div>
                            <div class="explain"><?php echo MRC_TITLE_DES; ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="section section-text">
                        <h3 class="heading"><?php echo PYMT_MODE; ?></h3>
                        <div class="option">
                            <div class="controls">
                                <select name="payment_mode" id="payment_mode" class="of-input">
                                    <option <?php if (get_option('apt_paypal') == 'paypal') echo 'selected="selected"' ?>
                                        value="paypal"> <?php echo PYPL_OPT; ?></option>
                                    <option <?php if (get_option('apt_paypal') == 'sandbox') echo 'selected="selected"' ?>
                                        value="sandbox"> <?php echo SAND_OPT; ?></option>
                                    <option <?php if (get_option('apt_paypal') == 'cash') echo 'selected="selected"' ?>
                                        value="cash"> <?php echo CASH_OPT; ?></option>
                                </select>
                                <br/>
                                <span id="pkg_error"></span>
                            </div>
                            <div class="explain"><?php echo PYPL_PYMT_DES; ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="section section-text ">
                        <h3 class="heading"><?php _e('Enable IPN Debug:', 'geocraft'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <select name="paypal_ipn" class="of-input">
                                    <option value="0" <?php if ($ipn == '0' || $ipn == '') { ?> selected="selected" <?php } ?>><?php _e('No', 'geocraft'); ?></option>
                                    <option value="1" <?php if ($ipn == 1) { ?> selected="selected" <?php } ?>><?php _e('Yes', 'geocraft'); ?></option>
                                </select>
                            </div>
                            <div class="explain"><p><?php _e('Debug email will send to admin email.', 'geocraft'); ?></p></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="group" id="of-option-manage-currency">
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo SET_CURR; ?></h3>
                        <div class="option">
                            <div class="controls">
                                <select name="apt_currency" id="apt_currency" class="of-input">
                                    <?php
                                    $symbol = get_option('apt_currency_code');
                                    foreach ($c_queries as $query) {

                                        if (($query->apt_c_code != '')) {
                                            ?>
                                            <option <?php if ($symbol == $query->apt_c_code) echo 'selected="selected"' ?>
                                                value="<?php echo $query->apt_c_code; ?>"><?php echo $query->apt_c_name; ?>
                                                &nbsp
                                                &nbsp(<?php echo $query->apt_c_code; ?>)
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="explain"><?php echo SET_CURR_DES; ?></div>
                            <div class="clear"></div>          
                            <h3 class="heading">Add Your Own Currency</h3>
                            <div class="Currency-addition">                                
                                <label><?php _e('Enter Currency Name:', 'appointment'); ?></label> 
                                <input type="text" name="currname" id="currname" placeholder="US Dollar"/>
                                <label><?php _e('Enter Currency Code:', 'appointment'); ?></label> 
                                <input type="text" name="currcode" id="currcode" placeholder="USD"/>
                                <label><?php _e('Enter Currency Symbol:', 'appointment'); ?></label> 
                                <input type="text" name="currsymbol" id="currsymbol" placeholder="&#36;"/>
                                <input type="submit" name="curradd" id="curradd" value="<?php _e('Add Currency', 'appointment'); ?>" />

                            </div>
                            <div class="clear"></div>
                            <h3 class="heading"><?php echo SUP_CURR; ?></h3>

                            <div class="currencysata">
                                <table id="currencysata" class="wp-list-table widefat fixed pages">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:40px;"><?php _e('ID', 'appointment'); ?></th>
                                            <th scope="col" style="width:200px;"><?php _e('Currency', 'appointment'); ?></th>
                                            <th scope="col"><?php _e('Code', 'appointment'); ?></th>
                                            <th scope="col"><?php _e('Symbol', 'appointment'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($c_queries as $query) {
//                                            if ($i < 25) {
                                            ?>
                                            <tr>
                                                <th scope="col"><?php echo $i++; ?></th>
                                                <th scope="col"><?php echo $query->apt_c_name; ?></th>
                                                <th scope="col"><?php echo $query->apt_c_code; ?></th>
                                                <th scope="col"><?php echo $query->apt_c_symbol; ?></th>
                                            </tr>
                                            <?php
//                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group" id="of-option-excp-date-setting">
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo _e('Exceptional working days(e.g. a specific Sunday you decided to work)', 'appointment'); ?></h3>

                        <div class="option">
                            <div class="controls">
                                <div class="wrap-cpt">
                                    <textarea name="apt_excp_open" id="open_datepick" style="max-width: 345px;min-height: 68px;"><?php if (get_option('apt_excp_open')) echo get_option('apt_excp_open') ?></textarea>
                                </div>
                            </div>
                            <div class="explain"><?php echo _e('Please enter each date using M-D-YYYY format (e.g. 3-17-2015) and separate each day with a comma. Datepick will allow entering multiple dates. ', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <h3 class="heading"><?php echo _e('Exceptional NON working days(e.g. holidays)', 'appointment'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <div class="wrap-cpt">
                                    <textarea name="apt_excp_close" id="closed_datepick" style="max-width: 345px;min-height: 68px;"><?php if (get_option('apt_excp_close')) echo get_option('apt_excp_close') ?></textarea>
                                </div>
                            </div>
                            <div class="explain"><?php echo _e('Please enter each date using M-D-YYYY format (e.g. 3-17-2015) and separate each day with a comma. Datepick will allow entering multiple dates. ', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <h3 class="heading"><?php echo _e('Bulk Disable Days', 'appointment'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <div class="wrap-cpt">
                                    <?php
                                    $apt_disable_days = get_option('apt_disable_days');
                                    ?>
                                    <label for="sun" class="apt_checkbox_lable"><input type="checkbox" id="sun" class="checkbox apt_checkbox" name="apt_disable_days[sun]" <?php
                                    if (isset($apt_disable_days['sun'])) {
                                        echo "checked";
                                    }
                                    ?> value="0">Sunday</label>
                                    <br/>
                                    <label for="mon" class="apt_checkbox_lable"><input type="checkbox" id="mon" class="checkbox apt_checkbox" name="apt_disable_days[mon]" <?php
                                        if (isset($apt_disable_days['mon'])) {
                                            echo "checked";
                                        }
                                    ?> value="1">Monday</label>
                                    <br/>
                                    <label for="tue" class="apt_checkbox_lable"><input type="checkbox" id="tue" class="checkbox apt_checkbox" name="apt_disable_days[tue]" <?php
                                        if (isset($apt_disable_days['tue'])) {
                                            echo "checked";
                                        }
                                    ?> value="2">Tuesday</label>
                                    <br/>
                                    <label for="wed" class="apt_checkbox_lable"><input type="checkbox" id="wed" class="checkbox apt_checkbox" name="apt_disable_days[wed]" <?php
                                        if (isset($apt_disable_days['wed'])) {
                                            echo "checked";
                                        }
                                    ?> value="3">Wednesday</label>
                                    <br/>
                                    <label for="thu" class="apt_checkbox_lable"><input type="checkbox" id="thu" class="checkbox apt_checkbox" name="apt_disable_days[thu]" <?php
                                        if (isset($apt_disable_days['thu'])) {
                                            echo "checked";
                                        }
                                    ?> value="4">Thursday</label>
                                    <br/>
                                    <label for="fri" class="apt_checkbox_lable"><input type="checkbox" id="fri" class="checkbox apt_checkbox" name="apt_disable_days[fri]" <?php
                                        if (isset($apt_disable_days['fri'])) {
                                            echo "checked";
                                        }
                                    ?> value="5">Friday</label>
                                    <br/>
                                    <label for="sat" class="apt_checkbox_lable"><input type="checkbox" id="sat" class="checkbox apt_checkbox" name="apt_disable_days[sat]" 
                                        <?php
                                        if (isset($apt_disable_days['sat'])) {
                                            echo "checked";
                                        }
                                        ?> value="6">Saturday</label>
                                </div>
                            </div>
                            <div class="explain"><?php echo _e('You can select days to bulk disable appointment', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="group" id="of-option-rmail-setting">
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo _e('Send Reminder Notification', 'appointment'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <div class="wrap-cpt">
                                    <select name="apt_reminder_mail">
                                        <option value="yes" <?php echo (get_option('apt_reminder_mail') == 'yes') ? 'selected' : ''; ?> >Yes</option>
                                        <option value="no" <?php echo (get_option('apt_reminder_mail') == 'no') ? 'selected' : ''; ?> >No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="explain"><?php echo _e('Whether to send reminder notification email(s) to the client before the appointment.', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <h3 class="heading"><?php echo _e('Send Reminder Notification to Administrator', 'appointment'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <select name="apt_reminder_to_admin">
                                    <option value="yes" <?php echo (get_option('apt_reminder_to_admin') == 'yes') ? 'selected' : ''; ?> >Yes</option>
                                    <option value="no" <?php echo (get_option('apt_reminder_to_admin') == 'no') ? 'selected' : ''; ?> >No</option>
                                </select>
                            </div>
                            <div class="explain"><?php echo _e('Select the option to get notification', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Administrator Notification Email', 'appointment'); ?></h3>
                            <div class="controls">
                                <input name="apt_reminder_mail_from" type="text" id="apt_reminder_mail_from" value="<?php echo (get_option('apt_reminder_mail_from') != '') ? get_option('apt_reminder_mail_from') : get_option('admin_email'); ?>" class="of-input" />
                            </div>
                            <div class="explain"><?php echo _e('Enter your email to get reminder notifications, this email is also used as "From" email to send reminder notification.', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Number of day before reminder email Send', 'appointment'); ?></h3>
                            <div class="controls">                                 
                                <select name="apt_reminder_day" id="apt_reminder_day">
                                    <option value="1" <?php echo (get_option('apt_reminder_day') == '1') ? 'selected' : ''; ?> >1</option>
                                    <option value="2" <?php echo (get_option('apt_reminder_day') == '2') ? 'selected' : ''; ?> >2</option>
                                    <option value="3" <?php echo (get_option('apt_reminder_day') == '3') ? 'selected' : ''; ?> >3</option>
                                    <option value="4" <?php echo (get_option('apt_reminder_day') == '4') ? 'selected' : ''; ?> >4</option>
                                    <option value="5" <?php echo (get_option('apt_reminder_day') == '5') ? 'selected' : ''; ?> >5</option>
                                    <option value="6" <?php echo (get_option('apt_reminder_day') == '6') ? 'selected' : ''; ?> >6</option>
                                    <option value="7" <?php echo (get_option('apt_reminder_day') == '7') ? 'selected' : ''; ?> >7</option>
                                </select>
                                <br/><br/>
                            </div>    
                            <div class="explain"><?php echo _e('Select number of days before the reminder email send', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Reminder Email Subject', 'appointment'); ?></h3>
                            <div class="controls">
                                <input name="apt_reminder_subject" type="text" id="apt_reminder_subject" value="<?php echo (get_option('apt_reminder_subject') != '') ? get_option('apt_reminder_subject') : 'Appointment Reminder.....'; ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Enter Your Account SID from www.twilio.com/console', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="group" id="of-option-sms-setting">
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo _e('SMS On/Off', 'appointment'); ?></h3>
                        <div class="option">
                            <div class="controls">
                                <div class="wrap-cpt">
                                    <input type="radio" class="of-radio" name="sms_on" id="apt-radio" value="on" <?php if (get_option('sms_enable') == 'on') echo 'checked'; ?> ><span><?php _e('On', 'appointment'); ?></span>
                                    <br/>
                                    <input type="radio" class="of-radio" name="sms_on" id="apt-radio" value="off" <?php if (get_option('sms_enable') == 'off') echo 'checked'; ?> >
                                    <span><?php _e('Off', 'appointment'); ?></span>
                                </div>
                            </div>
                            <div class="explain"><?php echo _e('By default sms is activated. Turn it off to deactivate this', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Enter SID Of Your Twilio Account', 'appointment'); ?></h3>
                            <div class="controls">
                                <input name="apt_sms_sid" type="text" id="apt_sms_sid" value="<?php echo get_option('apt_sms_sid'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Enter your sid of twilio account from www.twilio.com/console', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Enter Token Of Your Twilio Account', 'appointment'); ?></h3>
                            <div class="controls">
                                <input name="apt_sms_token" type="text" id="apt_sms_token" value="<?php echo get_option('apt_sms_token'); ?>" class="of-input" />
                            </div>
                            <div class="explain"><?php echo _e('Enter your token of twilio account from www.twilio.com/console', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Enter Phone Number Of Your Twilio Account', 'appointment'); ?></h3>
                            <div class="controls">
                                <input name="apt_sms_number" type="text" id="apt_sms_number" value="<?php echo get_option('apt_sms_number'); ?>" class="of-input" />
                            </div>
                            <div class="explain"><?php echo _e('Enter your number of twilio account from www.twilio.com/console', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Enter Your Number', 'appointment'); ?></h3>
                            <div class="controls">
                                <input name="apt_sms_own_number" type="text" id="apt_sms_own_number" value="<?php echo get_option('apt_sms_own_number'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Enter your number in which you want to get notified threw sms at the time of booking', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="group" id="of-option-style-setting">
                    <div class="section section-text ">

                        <h3 class="heading"><?php echo _e('Form Styles', 'appointment'); ?></h3>
                        <?php
                        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                        if (is_plugin_active('elementor/elementor.php')) {
                            echo '<span style="color:red;position: relative; bottom: 5px; font-size: 14px;">Note: The Following styles will work only if Elementor Plugin is deactivated.</span>';
                        }
                        ?>
                        <div class="option">
                            <div class="controls">
                                <select name="apt_form_style" id="apt_form_style">
                                    <option value="0" <?php echo (get_option('apt_form_style') == '0') ? 'selected' : ''; ?> ><?php _e('Black', 'appointment'); ?></option>
                                    <option value="1" <?php echo (get_option('apt_form_style') == '1') ? 'selected' : ''; ?> ><?php _e('Blue', 'appointment'); ?></option>
                                    <option value="2" <?php echo (get_option('apt_form_style') == '2') ? 'selected' : ''; ?> ><?php _e('Green', 'appointment'); ?></option>
                                    <option value="3" <?php echo (get_option('apt_form_style') == '3') ? 'selected' : ''; ?> ><?php _e('Red', 'appointment'); ?></option>
                                    <option value="4" <?php echo (get_option('apt_form_style') == '4') ? 'selected' : ''; ?> ><?php _e('Yellow', 'appointment'); ?></option>
                                </select>
                            </div>
                            <div class="explain"><?php echo _e('Select the form color, you can set it to blue, green, red and yellow. by default "Black" option is selected.', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Appointment Form Background Color', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="apt_form_background_color" type="text" id="apt_form_background_color" value="<?php echo get_option('apt_form_background_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select color for background of appointment form', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Text Color of Form', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="apt_form_text_color" type="text" id="apt_form_text_color" value="<?php echo get_option('apt_form_text_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select color of text showing on appointment form', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Background Color of Input Boxes', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="apt_form_background_input_color" type="text" id="apt_form_background_input_color" value="<?php echo get_option('apt_form_background_input_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select color for background of input boxes', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Border Color of Input Boxes', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="apt_form_border_input_color" type="text" id="apt_form_border_input_color" value="<?php echo get_option('apt_form_border_input_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select border color for input boxes', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <h3 class="heading"><?php echo _e('Form Button Setting', 'appointment'); ?></h3>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Submit Button Background Color', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="submit_btn_background_color" type="text" id="submit_btn_background_color" value="<?php echo get_option('submit_btn_background_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select background color of submit button', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Submit Button Hover Background Color', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="submit_btn_hover_background_color" type="text" id="submit_btn_hover_background_color" value="<?php echo get_option('submit_btn_hover_background_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select background color of submit button', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Submit Button Text Color', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="submit_btn_txt_color" type="text" id="submit_btn_txt_color" value="<?php echo get_option('submit_btn_txt_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select color of text for submit button', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <h3 class="heading"><?php echo _e('Submit Button Shadow Color', 'appointment'); ?></h3>
                            <div class="controls">
                                <input class="of-color" name="submit_btn_shadow_color" type="text" id="submit_btn_shadow_color" value="<?php echo get_option('submit_btn_shadow_color'); ?>" class="of-input"/>
                            </div>
                            <div class="explain"><?php echo _e('Select color of shadow of submit button', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="group" id="of-option-other-setting">
                    <div class="section section-text ">
                        <h3 class="heading"><?php echo _e('Captcha On/Off', 'appointment'); ?></h3>

                        <div class="option">
                            <div class="controls">
                                <div class="wrap-cpt">
                                    <input type="radio" class="of-radio" name="cpt_on" id="apt-radio" value="on" <?php if (get_option('cpt_enable') == 'on') echo 'checked'; ?> ><span><?php _e('On', 'appointment'); ?></span>
                                    <br/>
                                    <input type="radio" class="of-radio" name="cpt_on" id="apt-radio" value="off" <?php if (get_option('cpt_enable') == 'off') echo 'checked'; ?> >
                                    <span><?php _e('Off', 'appointment'); ?></span>
                                </div>
                            </div>
                            <div class="explain"><?php echo _e('By default captcha is activated. Turn it off to deactivate this', 'appointment'); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div class="option">
                            <div class="controls">                                 
                                <h3 class="heading"><?php echo _e('Recaptcha Public Key', 'appointment'); ?></h3>
                                <input type="text" name="apt_recaptcha_public" id="apt_recaptcha_public" value="<?php echo get_option('apt_recaptcha_public'); ?>" > <br/><br/>	                                  
                            </div>    
                            <div class="explain"><br/><br/><?php echo _e('Go to <a href="https://www.google.com/recaptcha/" target="_blank">Google Recaptcha</a> to Create your Public key', 'appointment'); ?></div>
                            <div class="clear"></div>
                            <div class="controls">
                                <h3 class="heading"><?php echo _e('Recaptcha Private Key', 'appointment'); ?></h3>	
                                <input type="text" name="apt_recaptcha_private" id="apt_recaptcha_private" value="<?php echo get_option('apt_recaptcha_private'); ?>" >                                
                            </div>
                            <div class="explain"><br/><br/><?php echo _e('Go to <a href="https://www.google.com/recaptcha/" target="_blank">Google Recaptcha</a> to Create your Private key', 'appointment'); ?> </div>
                            <div class="clear"></div>
                            <div class="controls">
                                <h3 class="heading"><?php echo _e('Date Format', 'appointment'); ?></h3>
                                <?php
                                $date_format_checked = get_option('apt_dformat');
                                ?>
                                <input type="radio" class="of-radio" name="apt_date_format" <?php echo ($date_format_checked == '1') ? 'checked' : ''; ?> value="1" />31/01/2017
                                <br/>
                                <input type="radio" class="of-radio" name="apt_date_format" <?php echo ($date_format_checked == '2') ? 'checked' : ''; ?> value="2" />01/31/2017
                                <br/>
                            </div>
                            <div class="explain"><br/><br/><?php echo _e('Choose the date format', 'appointment'); ?> </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="save_bar_right save_bar_top">
            <img style="display:none" src="<?php echo $apt_db->dir_url; ?>ink-admin/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..."/>
            <input type="submit" id="submit" name="submit" value="<?php echo SAVE_ALL_CHNG; ?>" class="button-primary"/>
        </div>
    </form>
    <div class="save_bar_left save_bar_top">
        <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']) ?>" method="post" style="display:inline"
              id="ofform-reset">
            <span class="submit-footer-reset">
                <input name="reset" type="submit" value="<?php _e('Reset Options', 'appointment'); ?>" class="button submit-button reset-button"
                       onclick="return confirm('Click OK to reset. Any settings will be lost!');"/>
                <input type="hidden" name="of_save" value="reset"/>
            </span>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo plugins_url('../js/jquery.datepick.min.js', __DIR__); ?>"></script> 
<script type="text/javascript" src="<?php echo plugins_url('../js/jquery.multiselect.min.js', __DIR__); ?>"></script> 
<link rel='stylesheet' id='jquery-datepick-css'  href='<?php echo plugins_url('../css/jquery.datepick.css', __DIR__); ?>' type='text/css' media='all' />
<link rel='stylesheet' id='jquery-multiselect-css'  href='<?php echo plugins_url('../css/jquery.multiselect.css', __DIR__); ?>' type='text/css' media='all' />
<script type="text/javascript">
                           jQuery(document).ready(function () {

                               var flip = 0;

                               jQuery('#expand_options').click(function () {
                                   if (flip == 0) {
                                       flip = 1;
                                       jQuery('#of_container #of-nav').hide();
                                       jQuery('#of_container #content').width(755);
                                       jQuery('#of_container .group').add('#of_container .group h2').show();

                                       jQuery(this).text('[-]');

                                   } else {
                                       flip = 0;
                                       jQuery('#of_container #of-nav').show();
                                       jQuery('#of_container #content').width(595);
                                       jQuery('#of_container .group').add('#of_container .group h2').hide();
                                       jQuery('#of_container .group:first').show();
                                       jQuery('#of_container #of-nav li').removeClass('current');
                                       jQuery('#of_container #of-nav li:first').addClass('current');

                                       jQuery(this).text('[+]');

                                   }

                               });

                               jQuery('.group').hide();
                               jQuery('.group:first').fadeIn();

                               jQuery('.group .collapsed').each(function () {
                                   jQuery(this).find('input:checked').parent().parent().parent().nextAll().each(
                                           function () {
                                               if (jQuery(this).hasClass('last')) {
                                                   jQuery(this).removeClass('hidden');
                                                   return false;
                                               }
                                               jQuery(this).filter('.hidden').removeClass('hidden');
                                           });
                               });

                               jQuery('.group .collapsed input:checkbox').click(unhideHidden);

                               function unhideHidden() {
                                   if (jQuery(this).attr('checked')) {
                                       jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
                                   } else {
                                       jQuery(this).parent().parent().parent().nextAll().each(
                                               function () {
                                                   if (jQuery(this).filter('.last').length) {
                                                       jQuery(this).addClass('hidden');
                                                       return false;
                                                   }
                                                   jQuery(this).addClass('hidden');
                                               });

                                   }
                               }

                               jQuery('.of-radio-img-img').click(function () {
                                   jQuery(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
                                   jQuery(this).addClass('of-radio-img-selected');

                               });
                               jQuery('.of-radio-img-label').hide();
                               jQuery('.of-radio-img-img').show();
                               jQuery('.of-radio-img-radio').hide();
                               jQuery('#of-nav li:first').addClass('current');
                               jQuery('#of-nav li a').click(function (evt) {

                                   jQuery('#of-nav li').removeClass('current');
                                   jQuery(this).parent().addClass('current');

                                   var clicked_group = jQuery(this).attr('href');

                                   jQuery('.group').hide();

                                   jQuery(clicked_group).fadeIn();

                                   evt.preventDefault();

                               });
                               jQuery("#open_datepick").datepick({minDate: new Date(), dateFormat: 'm-d-yyyy', multiSelect: 999, monthsToShow: 1});
                               jQuery("#closed_datepick").datepick({minDate: new Date(), dateFormat: 'm-d-yyyy', multiSelect: 999, monthsToShow: 1});
                           });
</script>