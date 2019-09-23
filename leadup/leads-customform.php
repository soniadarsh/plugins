<?php

// Create the page
function dynamic_create_form() {
    $admin_url = admin_url('admin.php?page=leadcapture');
    global $lead_field_count, $wpdb;
//delete column
    $countdelete = 1;
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $wpdb->query($wpdb->prepare("DELETE FROM $lead_field_count WHERE ID = %d", $id));
    }
    if (isset($_GET['add-lead'])) {
        global $wpdb, $lead_field_count, $lead_field_table;
        $addlead = $_GET['add-lead'];
        $spid = $wpdb->get_row("SELECT * FROM $lead_field_table WHERE PID=$addlead", ARRAY_N);
        $field_id = $spid[2] . '_' . $spid[1];
        $query = $wpdb->insert($lead_field_table, array(
            'ID' => $spid[1],
            'field_name' => $spid[2],
            'text_name' => 'new Field',
            'field_id' => $field_id,
        ));
    }
    if (isset($_GET['delete-lead'])) {
        $pid = $_GET['delete-lead'];
        global $wpdb, $lead_field_count, $lead_field_table;
        $spid = $wpdb->get_row("SELECT * FROM $lead_field_table WHERE PID=$pid", ARRAY_N);
        $dpid = $wpdb->get_row("SELECT * FROM $lead_field_table WHERE ID=$spid[1]", ARRAY_N);
        $id_count = $wpdb->get_var("SELECT COUNT(*) FROM $lead_field_table WHERE ID=$spid[1]");
        $wpdb->query($wpdb->prepare("DELETE FROM $lead_field_table WHERE PID = %d", $pid));
        if ($id_count == 1) {
            $wpdb->query($wpdb->prepare("DELETE FROM $lead_field_count WHERE ID = %d", $spid[1]));
        }
    }
// insert data in databse
    if (isset($_POST['add'])) {
//$user_count = $wpdb->get_var( "SELECT MAX(ID) FROM $lead_field_count");
//$label='text_'.$user_count;
        $myselect = $_POST['myselect'];
        $label = $_POST['textlabel'];
        $cname = $_POST['cname'];
        if (isset($_POST['required'])) {
            $required = $_POST['required'];
        } else {
            $required = '';
        }
        $customrand = $_POST['randvalue'];
        global $wpdb, $lead_field_count;
//        $radiochk = $wpdb->get_row("SELECT * FROM $lead_field_count WHERE  text_name='$myselect'");
//        var_dump($radiochk);
//        $chkradio = $radiochk->text_name;
        if (($myselect == 'select') || empty($cname)) {
//featch randam value
            echo "<div style='color:red; margin-top:10px; margin-left:150px;'>" . __('Enter Field Name / Select Field Type', 'leadcapture') . " </div>";
        } else {
            global $lead_field_table, $lead_field_count, $lead_select_field;
            $sql = "SELECT * FROM $lead_field_count WHERE  randvalue =$customrand";
            $sql2 = "SELECT * FROM $lead_field_table WHERE  randvalue =$customrand";
            $value = $wpdb->get_row($sql);
            $value2 = $wpdb->get_row($sql2);
            if (!$value) {
                $query = $wpdb->insert($lead_field_count, array(
                    'text_name' => $myselect,
                    'text_value' => $cname,
                    'text_label' => $label,
                    'required' => $required,
                    'randvalue' => $customrand
                ));
                if (($myselect == 'radio') || ($myselect == 'checkbox')) {
                    $last_id = $wpdb->get_var("SELECT MAX(ID) FROM $lead_field_count");
                    $field_id = $myselect . '_' . $last_id;
                    $query = $wpdb->insert($lead_field_table, array(
                        'ID' => $last_id,
                        'field_name' => $myselect,
                        'text_name' => 'First Choice',
                        'field_id' => $field_id,
                        'randvalue' => $customrand
                    ));
                    $query = $wpdb->insert($lead_field_table, array(
                        'ID' => $last_id,
                        'field_name' => $myselect,
                        'text_name' => 'Second Choice',
                        'field_id' => $field_id,
                        'randvalue' => $customrand
                    ));
                } //end radio and checkbox if
            } //end randm value if
        } // end select else
        $newclass = new LeadsSetData();
        $newclass->table_update($label, $cname);
    } // end add if
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $lead_field_count");
    ?>
    <div id="tabvanillas" class="inkwidget">
        <ul class="tabnav">
            <li><a href="#popular" class="leadbutton"><?php _e('Create Custom LeadUp Form', 'leadcapture'); ?></a></li>
            <li><a href="#recent" class="leadbutton"><?php _e('Lead Form Settings', 'leadcapture'); ?></a></li>
            <li><a href="#email" class="leadbutton"><?php _e('Email Service Integrations', 'leadcapture'); ?></a></li>
        </ul>
        <div id="popular" class="tabdiv">           
            <?php if ($count <= 9) { ?>
                <div class="custom-header">
                    <form action="<?php echo $admin_url; ?>" method="post" >
                        <select style="display:none;" id="textlabel" name="textlabel" >
                            <?php
                            $a = new LeadsSetData();
                            if (!$a->check('Name')) {
                                ?> <option value="Name"><?php _e('Name', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('Email')) {
                                ?> <option value="Email"><?php _e('Email', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('Number')) {
                                ?> <option value="Number"><?php _e('Number', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('Message')) {
                                ?> <option value="Message"><?php _e('Message', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('label1')) {
                                ?> <option value="label1"><?php _e('Label1', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('label2')) {
                                ?> <option value="label2"><?php _e('Label2', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('label3')) {
                                ?> <option value="label3"><?php _e('Label3', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('label4')) {
                                ?> <option value="label4"><?php _e('Label4', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('label5')) {
                                ?> <option value="label5"><?php _e('Label5', 'leadcapture'); ?></option> <?php
                            }
                            if (!$a->check('label6')) {
                                ?> <option value="label6"><?php _e('Label6', 'leadcapture'); ?></option> <?php } ?>
                        </select>
                        <table class="wp-list-table widefat fixed pages" style=" width:900px; ">
                            <thead>
                                <tr>
                                    <th  scope="col"> <label><?php _e('Enter Field Name:', 'leadcapture'); ?></label> </th>
                                    <th  scope="col"> <input type="text" name="cname" id="cname" /></th>
                                    <th  scope="col"><label><?php _e('Select Field Type:', 'leadcapture'); ?></label></th>
                                    <th  scope="col">
                                        <select id="myselect" name="myselect">
                                            <option value="select"><?php _e('Choose Fields', 'leadcapture'); ?></option>
                                            <option value="text">Single Line Text</option>
                                            <option value="textarea">Multi Line Text</option>
                                            <option value="checkbox">checkbox</option>
                                            <option value="number">number</option>
                                            <option value="radio">radio</option>
                                        </select>
                                    </th>
        <!--									<th  scope="col">
                                            <label>Required:<input type="checkbox" name="required" id="required" class="required"/></label>
                                    </th>-->
                                    <th  scope="col">
                                        <input type="submit" name="add" id="lead-add" value="<?php _e('Add Field', 'leadcapture'); ?>" />
                                        <input type="hidden" name="randvalue" id="randvalue" value="<?php echo rand(); ?>" />
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
                <?php
            }
            global $lead_field_count, $wpdb;
            ?>
            <table class="wp-list-table widefat fixed pages" style="width:900px;">
                <?php
                $query = "SELECT * FROM $lead_field_count ";
                $results = $wpdb->get_results($query);
                if ($results) {
                    ?>
                    <thead>
                        <tr>
                            <th class="field" scope="col"><?php _e('S.No.', 'leadcapture'); ?></th>
                            <th  class="rckbox" scope="col"><?php _e('Field Name', 'leadcapture'); ?></th>
                            <th  class="fieldname" scope="col"><?php _e('Field Options', 'leadcapture'); ?></th>
                            <th  class="field_type" scope="col"><?php _e('Field Type', 'leadcapture'); ?></th>
                            <!--<th  class="required" scope="col"><?php _e('Required', 'leadcapture'); ?></th>-->
                            <th  class="field_edit" scope="col"><?php _e('Field Edit', 'leadcapture'); ?></th>                            
                            <th  class="action" scope="col"><?php _e('Action', 'leadcapture'); ?></th>
                        </tr>
                    </thead>
                    <?php
// text/text area update
                    if (isset($_POST['update'])) {
                        global $wpdb, $lead_field_count, $lead_field_table;
                        $rname = $_POST['rname'];
                        if (isset($_POST['required'])) {
                            $required = $_POST['required'];
                        } else {
                            $required = '';
                        }
                        $uname = $_POST['uname'];
                        $ulabel = $_POST['ulabel'];
                        $wpdb->update($lead_field_count, array('text_value' => $rname, 'required' => $required), array('ID' => $uname), array('%s'), array('%d'));
                        $newclass = new LeadsSetData;
                        $newclass->table_update($ulabel, $rname);
                    }
// checkbox/radio update
                    if (isset($_POST['update-lead'])) {
                        global $wpdb, $lead_field_count, $lead_field_table;
                        $cbname = $_POST['cbname'];
                        $crname = $_POST['crname'];
                        $pidname = $_POST['pidname'];
                        $idname = $_POST['idname'];
                        $ulabel = $_POST['ulabel'];
                        $required = isset($_POST['required']) ? $_POST['required'] : '';
                        $wpdb->update($lead_field_table, array('text_name' => $crname), array('PID' => $pidname), array('%s'), array('%d'));
                        $wpdb->update($lead_field_count, array('text_value' => $cbname, 'required' => $required), array('ID' => $idname), array('%s'), array('%d'));
                        $newclass = new LeadsSetData;
                        $newclass->table_update($ulabel, $cbname);
                    }
                    global $lead_field_count;
                    $sqlfeatch = $wpdb->get_results("SELECT * FROM $lead_field_count", ARRAY_A);
                    $count = 1;
                    foreach ($sqlfeatch as $row) {
                        $number = 1;
                        $number1 = 1;
                        $id = $row["ID"];
                        $inputname = $row["text_name"];
                        $textname = $row["text_value"];
                        $required = $row["required"];
                        if (($inputname == 'radio') || ($inputname == 'checkbox')) { //Only radio and checkbox allow
                            global $lead_field_table;
                            $sqlfeatch2 = $wpdb->get_results("SELECT * FROM $lead_field_table", ARRAY_A);
                            foreach ($sqlfeatch2 as $row2) {
                                $rtext = $row2["text_name"];
                                $fname = $row2["field_name"];
                                $id2 = $row2["ID"];
                                if ($id == $id2) { //Compare to custom_table ID and field_radio ID
                                    $PID = $row2["PID"];
                                    ?>
                                    <tbody id="trans_list">
                                        <tr class="<?php echo $fname; ?>">
                                            <?php
                                            if ($number1 == 1) {
                                                $number1++;
                                                ?>
                                                <th  class="field" scope="col">
                                                    <?php echo $count++ . '.'; ?></th>
                                            <?php } else { ?> 
                                                <th  class="field" scope="col"></th>
                                                <?php
                                            }
                                            if (isset($_GET['edit2'])) {
                                                $update = $_GET['edit2'];
                                            } else {
                                                $update = '';
                                            }
                                            if (($update == $PID)) {
                                                $number2 = 1;
                                                $pidedit = $update;
                                                global $wpdb, $lead_field_count;
                                                $rcid = $wpdb->get_row("SELECT * FROM $lead_field_table WHERE PID = $pidedit", ARRAY_N);
                                                $rid = $wpdb->get_row("SELECT * FROM $lead_field_count WHERE ID = $rcid[1]", ARRAY_N);
                                                ?>
                                        <form action="<?php echo $admin_url . "&update-lead=" . $PID; ?>" method="post">
                                            <th  scope="col"> <input type="text" name="cbname" id="cbname" value="<?php echo $rid[2]; ?>" /></th> 
                                            <th  scope="col"> <input type="text" name="crname" id="crname" value="<?php echo $rcid[3]; ?>" />
                                            <th  scope="col" style="display:none;"> <input type="hidden" name="pidname" id="pidname" value="<?php echo $pidedit; ?>" /></th>
                                            <th  scope="col" style="display:none;"> <input type="hidden" name="idname" id="idname" value="<?php echo $rcid[1]; ?>" />
                                            <th  scope="col" style="display:none;"> <input type="text" name="uname" id="uname" value="<?php echo $rid[0]; ?>" />
                                            <th  scope="col" style="display:none;"> <input type="text" name="ulabel" id="ulabel" value="<?php echo $rid[3]; ?>" />
                                            </th>
                                            <th  scope="col"></th> 
                                            <!--<th  scope="col"></th>--> 
                                            <th  scope="col"><input type="submit" name="update-lead" id="update-lead" value="" /></th>
                                            <th  scope="col"><a href="<?php echo $admin_url . "&delete-lead=" . $PID; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'ico-close.png'; ?>" alt="Delete" height="16" width="16" /></a></th>
                                        </form>
                                        <?php
                                    } else {
                                        if (($inputname == 'radio') || ($inputname == 'checkbox')) {
                                            if ($number == 1) {
                                                $number++;
                                                ?>
                                                <th  scope="col"><?php echo $textname; ?></th> 
                                            <?php } else { ?>
                                                <th  scope="col"></th> 
                                            <?php } ?>
                                            <th  scope="col"><?php echo $rtext; ?></th> 
                                            <th  scope="col"><?php echo $fname; ?></th>
                                            <!--<th></th>-->
                                            <th  scope="col"><a id="edit" href="<?php echo $admin_url . "&edit2=" . $PID; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'icon-edit.png'; ?>" alt="edit" height="16" width="16" /></a>
                                                <a href="<?php echo $admin_url . "&add-lead=" . $PID; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'icon-add.png'; ?>" alt="Delete" height="16" width="16" /></a>
                                            </th>
                                            <th  scope="col">
                                                <a href="<?php echo $admin_url . "&delete-lead=" . $PID; ?>">
                                                    <img src="<?php echo IMG_PLUGIN_URL . 'ico-close.png'; ?>" alt="Delete" height="16" width="16" />
                                                </a>
                                            </th>
                                        <?php } ?>
                                    <?php } ?>
                                    </tr>
                                    <?php
                                } // end id if loop
                            } //end radio while loop
                        } //end radio if loop 
                        if (($inputname != 'radio') && ($inputname != 'checkbox')) {
                            ?>
                            <tbody id="trans_list">
                                <tr  class="<?php echo $inputname; ?>">
                                    <th  class="field" scope="col"><?php echo $count++ . '.'; ?></th>
                                    <?php
                                    if (isset($_GET['edit'])) {
                                        $update = $_GET['edit'];
                                    } else {
                                        $update = '';
                                    }
                                    if (($update == $id)) {
                                        $editid = $_GET['edit'];
                                        global $wpdb, $lead_field_count;
                                        $rid = $wpdb->get_row("SELECT * FROM $lead_field_count WHERE ID = $editid", ARRAY_N);
                                        ?>
                                <form action="<?php echo $admin_url . "&update=" . $id; ?>" method="post">
                                     <th  scope="col"> <input type="text" name="rname" id="rname" value="<?php echo $rid[2]; ?>" /></th>
                                    <th  scope="col"></th> 
                                    <th  scope="col"> <?php echo $rid[1]; ?></th>
                                    <th  scope="col" style="display:none;"> <input type="text" name="uname" id="uname" value="<?php echo $rid[0]; ?>" /></th>
                                    <th  scope="col" style="display:none;"> <input type="text" name="ulabel" id="ulabel" value="<?php echo $rid[3]; ?>" />
                                    </th>
                                    <!--<th  scope="col"><input type="checkbox" <?php echo ($rid[4]) ? 'checked="checked"' : ''; ?> name="required" id="required" /></th>-->
                                    <th  scope="col"><input type="submit" name="update" id="update-lead"  value="" /></th>
                                    <th  scope="col"><a href="<?php echo $admin_url . "&delete=" . $id; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'ico-close.png'; ?>" alt="Delete" height="16" width="16" /></a></th>
                                </form>
                    <?php
                } else {
                    if (($inputname != 'radio') && ($inputname != 'checkbox')) {
                        ?><th  scope="col"><?php echo $textname; ?></th> 
                                    <th  scope="col"></th> 
                                    <th  scope="col"><?php echo $inputname; ?></th>
                                    <!--<th  scope="col"><?php echo ($required) ? "Yes" : "No"; ?></th>-->
                                    <th  scope="col"><a id="edit" href="<?php echo $admin_url . "&edit=" . $id; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'icon-edit.png'; ?>" alt="edit" height="16" width="16" /></a></th>                                    
                                    <th  scope="col"><a href="<?php echo $admin_url . "&delete=" . $id; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'ico-close.png'; ?>" alt="Delete" height="16" width="16" /></a></th>
                        <?php
                    }
                }
                ?>
                            </tr>
                            <?php
                        }
                    } // end Main while loop
                } // end if code
                else {
                    ?>
                    <tbody id="trans_list">	
                        <tr>
                            <th colspan="7"><?php _e("No fields", 'leadcapture'); ?></th>
                        </tr>
    <?php } ?>
                </tbody>
            </table>

        </div><!--/popular-->

    <?php
    if (isset($_POST['saveleaddata'])) {
        update_option('leadcapture-heading', stripslashes(sanitize_text_field($_POST['top-head'])));
        update_option('lead_btn_txt', stripslashes(sanitize_text_field($_POST['submit-btn-txt'])));
        update_option('leadcapture-ack', ($_POST['lead-ack']));
        update_option('leadcapture-field_heading_col', stripslashes(sanitize_text_field($_POST['field-head-col'])));
        update_option('leadcapture-heading_col', stripslashes(sanitize_text_field($_POST['top-head-col'])));
        update_option('leadcapture-heading_sep_col', stripslashes(sanitize_text_field($_POST['top-head-sep-col'])));
        update_option('leadcapture-font_col', stripslashes(sanitize_text_field($_POST['form-font-col'])));
        update_option('leadcapture-email', sanitize_text_field($_POST['top-email']));
        update_option('leads-captcha', sanitize_text_field($_POST['cpton']));
        update_option('leadcapture_btn_bg_col', stripslashes(sanitize_text_field($_POST['form-btn-bg-col'])));
        //update_option('leadcapture-submit_btn', stripslashes(sanitize_text_field($_POST['lead_submit-btn'])));
        update_option('leadcapture_btn_txt_col', stripslashes(sanitize_text_field($_POST['form-btn-txt-col'])));
        update_option('leads_form_bg_col', sanitize_text_field($_POST['form-bg_col']));
        update_option('leads_form_fields_bg_col', sanitize_text_field($_POST['form-fields_bg_col']));
        $recaptcha_option = array(
            'public_key' => esc_attr($_POST['recaptcha_public_key']),
            'private_key' => esc_attr($_POST['recaptcha_private_key']),
        );
        update_option('inklead_recaptcha', $recaptcha_option);
    }
    $recaptcha = get_option('inklead_recaptcha');
    ?>
        <div id="recent" class="tabdiv">
            <form action="#" method="post">
                <table class="form-table">
                    <tr valign="top">
                        <?php
                       include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                       if (is_plugin_active('elementor/elementor.php')) {
                           echo '<span style="color:red;position: relative; bottom: 5px; font-size: 14px;">Note: The Following Color styles below will work only if Elementor Plugin is deactivated.</span>';
                       }
                       ?>
                        <th scope="row"><label for="top-head"><?php echo _e('Lead Up Form Heading', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="top-head" value="<?php echo esc_attr(get_option('leadcapture-heading')); ?>" />
                            <br/><span class="description"><?php echo _e('Mention the heading for the leadUp form that will display on the sidebar.', 'leadcapture'); ?></span>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Form Successful Submission Message', 'leadcapture'); ?></label></th>
                        <td>
                            <textarea rows="5" cols="49" id="lead-ack" name="lead-ack"><?php echo esc_attr(get_option('leadcapture-ack')); ?></textarea>
                            <br/><span class="description"><?php echo _e('Mention the messgae for the lead Up form that will display after successful submission of the form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Field Heading Color', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="color-picker" id="field-head-col" name="field-head-col" value="<?php echo esc_attr(get_option('leadcapture-field_heading_col')); ?>">
                            <br/><span class="description"><?php echo _e('Select the heading color for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Main Heading Color', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="color-picker" id="top-head-col" name="top-head-col" value="<?php echo esc_attr(get_option('leadcapture-heading_col')); ?>">
                            <br/><span class="description"><?php echo _e('Select the heading color for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Main Heading Separator Color', 'leadcapture'); ?></label></th>
                        <td>
                            <?php $my_default_sep_col = "#7D7D7D" ?>
                            <input class="color-picker" id="top-head-sep-col" name="top-head-sep-col" value="<?php echo esc_attr(get_option('leadcapture-heading_sep_col', $my_default_sep_col)); ?>">
                            <br/><span class="description"><?php echo _e('Select the heading separator color for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Field Text Color', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="color-picker" id="form-font-col" name="form-font-col" value="<?php echo esc_attr(get_option('leadcapture-font_col')); ?>">
                            <br/><span class="description"><?php echo _e('Select the font color for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="lead-email"><?php echo _e('Lead Up Emails', 'leadcapture'); ?></label></th>
                        <td>
                            <textarea rows="5" cols="49" id="lead-email" name="top-email" ><?php echo esc_attr(get_option('leadcapture-email')); ?></textarea>
                            <br/><span class="description"><?php echo _e('E-mail Address- Mention multiple e-mail ids here to receive mails from lead Up form. Add comma and space to separate two email ids. For eg:- example@gmail.com, example1@gmail.com', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="lead-radio"><?php echo _e('Google recaptcha On/Off', 'leadcapture'); ?></label></th>
                        <td>
                            <input type="radio" name="cpton" id="lead-radio" value="on" <?php if (get_option('leads-captcha') == 'on') echo 'checked'; ?> > <span><?php _e('on', 'leadcapture'); ?></span><br/>
                            <input type="radio" name="cpton" id="lead-radio1" value="off" <?php if (get_option('leads-captcha') == 'off') echo 'checked'; ?> > <span><?php _e('off', 'leadcapture'); ?></span>
                            <br/><span class="description"><?php echo _e('By default captcha is activated. Turn it off to deactivate this', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="recaptcha_public_key"><?php echo _e('Recaptcha Public key', 'leadcapture'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="recaptcha_public_key" id="recaptcha_public_key" value="<?php echo isset($recaptcha['public_key']) ? $recaptcha['public_key'] : ""; ?>"/>
                            <br/><span class="description"><?php echo _e('Enter recaptcha public key <a href="https://www.google.com/recaptcha/admin">Click here to get recaptcha key</a>', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="recaptcha_private_key"><?php echo _e('Recaptcha Private key', 'leadcapture'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="recaptcha_private_key" id="recaptcha_private_key" value="<?php echo isset($recaptcha['private_key']) ? $recaptcha['private_key'] : ""; ?>"/>
                            <br/><span class="description"><?php echo _e('Enter recaptcha private key <a href="https://www.google.com/recaptcha/admin">Click here to get recaptcha key</a>', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Submit Button Background Color', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="color-picker" id="form-btn-bg-col" name="form-btn-bg-col" value="<?php echo esc_attr(get_option('leadcapture_btn_bg_col')); ?>">
                            <br/><span class="description"><?php echo _e('Select the background color of submit button for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Lead Up Submit Button text', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="submit-btn-txt" name="submit-btn-txt" value="<?php echo esc_attr(get_option('lead_btn_txt')); ?>" />
                            <br/><span class="description"><?php echo _e('Mention the Submit button text for the leadUp form', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('Submit Button Text Color', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="color-picker" id="form-btn-txt-col" name="form-btn-txt-col" value="<?php echo esc_attr(get_option('leadcapture_btn_txt_col')); ?>">
                            <br/><span class="description"><?php echo _e('Select the Text color of submit button for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="leadformcolor"><?php echo _e('Select Form Background Color', 'leadcapture'); ?></label></th>
                        <td>
                            <?php $my_default_form_bg_col = "#565656" ?>
                            <input class="color-picker" id="form-bg_col" name="form-bg_col" value="<?php echo esc_attr(get_option('leads_form_bg_col',$my_default_form_bg_col)); ?>">
                            <br/><span class="description"><?php echo _e('Select form background color for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="leadformfieldscolor"><?php echo _e('Select Form Fields Background Color', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="color-picker" id="form-fields_bg_col" name="form-fields_bg_col" value="<?php echo esc_attr(get_option('leads_form_fields_bg_col')); ?>">
                            <br/><span class="description"><?php echo _e('Select form feilds background color for the lead Up form.', 'leadcapture'); ?></span>
                        </td>
                    </tr>

                </table>
                <input type="submit" id="saveleadsdata" name="saveleaddata" value="<?php _e('Save', 'leadcapture'); ?>"/>
            </form>
        </div><!--/recent-->

    <?php
    if (isset($_POST['saveleadsocialdata'])) {
        update_option('socialonoff', sanitize_text_field($_POST['socialautofillonoff']));
        update_option('google-api-key', sanitize_text_field($_POST['google-api-key']));
        update_option('facebook-app-id', sanitize_text_field($_POST['facebook-app-id']));
        update_option('facebook-app-secret', sanitize_text_field($_POST['facebook-app-secret']));
//            update_option('facebook-callback', sanitize_text_field($_POST['facebook-callback']));
    }
    ?>
        <!--Social Autofill-->

    <?php
    if (isset($_POST['saveleademaildata'])) {
        update_option('mailget-api-key', sanitize_text_field($_POST['mailget-api-key']));
        update_option('mailget-list-name', sanitize_text_field($_POST['mailget-list-name']));
        update_option('mailchimp-api-key', sanitize_text_field($_POST['mailchimp-api-key']));
        update_option('mailchimp-list-id', sanitize_text_field($_POST['mailchimp-list-id']));
        update_option('getresponse-api-key', sanitize_text_field($_POST['getresponse-api-key']));
        update_option('getresponse-list-name', sanitize_text_field($_POST['getresponse-list-name']));
    }
    ?>
        <!--Email Integration-->
        <div id="email" class="tabdiv">
            <form action="#" method="post">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('MailGet API Key', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="mailget-api-key" value="<?php echo esc_attr(get_option('mailget-api-key')); ?>" />
                            <br/><span class="description"><?php echo _e('You need to enter MailGet Api Key which can be generated from <a href="https://www.formget.com/mailget/"><b><u>MailGet</u></b></a>.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('MailGet List Name', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="mailget-list-name" value="<?php echo esc_attr(get_option('mailget-list-name')); ?>" />
                            <br/><span class="description"><?php echo _e('You need to enter MailGet List Name in which you want to add the lead from <a href="https://www.formget.com/mailget/"><b><u>MailGet</u></b></a>.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('MailChimp API Key', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="mailchimp-api-key" value="<?php echo esc_attr(get_option('mailchimp-api-key')); ?>" />
                            <br/><span class="description"><?php echo _e('You need to enter MailChimp API Key in which you want to add the lead from <a href="https://mailchimp.com/"><b><u>MailChimp</u></b></a>.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('MailChimp List ID', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="mailchimp-list-id" value="<?php echo esc_attr(get_option('mailchimp-list-id')); ?>" />
                            <br/><span class="description"><?php echo _e('You need to enter MailChimp List ID in which you want to add the lead from <a href="https://mailchimp.com/"><b><u>MailChimp</u></b></a>.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('GetResponse API Key', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="getresponse-api-key" value="<?php echo esc_attr(get_option('getresponse-api-key')); ?>" />
                            <br/><span class="description"><?php echo _e('You need to enter GetResponse API Key in which you want to add the lead from <a href="https://getresponse.com/"><b><u>GetResponse</u></b></a>.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="top-head"><?php echo _e('GetResponse List Name', 'leadcapture'); ?></label></th>
                        <td>
                            <input class="regular-text"  type="text" id="top-head" name="getresponse-list-name" value="<?php echo esc_attr(get_option('getresponse-list-name')); ?>" />
                            <br/><span class="description"><?php echo _e('You need to enter GetResponse List Name in which you want to add the lead from <a href="https://getresponse.com"><b><u>GetResponse</u></b></a>.', 'leadcapture'); ?></span>
                        </td>
                    </tr>
                </table>
                <input type="submit" id="saveleademaildata" name="saveleademaildata" value="<?php _e('Save', 'leadcapture'); ?>"/>
            </form>
        </div>
    </div><!--/widget-->
    <?php
}
