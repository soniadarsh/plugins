<?php

function leads_fetach() {
    $leadsdata_url = admin_url('admin.php?page=leadsdata', 'http');
    global $wpdb, $leads_dynamicform;
    $sql = $wpdb->get_results("SELECT * FROM $leads_dynamicform", ARRAY_A);
    $nr = count($sql);
    $rteurn_array = array(
        'leads_count' => $nr,
        'sql' => $sql,
        'leadsdata_url' => $leadsdata_url
    );
    return $rteurn_array;
}

function paginationdisplay() {
    global $wpdb, $leads_dynamicform;
    $rteurn_array = leads_fetach();
    $nr = $rteurn_array['leads_count'];
    $sql = $rteurn_array['sql'];
    $leadsdata_url = $rteurn_array['leadsdata_url'];
    if ($nr >= 1) {
        if (isset($_GET['pn'])) {
            $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']);
        } else {
            $pn = 1;
        }
        $itemsPerPage = 10;
        $lastPage = ceil($nr / $itemsPerPage);
        if ($pn < 1) {
            $pn = 1;
        } else if ($pn > $lastPage) {
            $pn = $lastPage;
        }
        $centerPages = "";
        $sub1 = $pn - 1;
        $sub2 = $pn - 2;
        $add1 = $pn + 1;
        $add2 = $pn + 2;
        if ($pn == 1) {
            $centerPages .= '&nbsp; <span class="pagnumactive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pn == $lastPage) {
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagnumactive">' . $pn . '</span> &nbsp;';
        } else if ($pn > 2 && $pn < ($lastPage - 1)) {
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagnumactive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pn > 1 && $pn < $lastPage) {
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagnumactive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }
        $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
        $sql2 = $wpdb->get_results("SELECT * FROM $leads_dynamicform ORDER BY id DESC $limit", ARRAY_A);
        $paginationDisplay = "";
        if ($lastPage != "1") {
            if ($pn != 1) {
                $previous = $pn - 1;
                $paginationDisplay .= '&nbsp;  <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $previous . '">«</a> ';
            }
            $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
            if ($pn != $lastPage) {
                $nextPage = $pn + 1;
                $paginationDisplay .= '&nbsp;  <a class="lead_pagination" href="' . $leadsdata_url . '&pn=' . $nextPage . '"> »</a> ';
            }
        }
        $pagination = array(
            'column_number' => $nr,
            'show_data' => $sql,
            'perpage_limit' => $sql2,
            'pegination_display' => $paginationDisplay
        );
        return $pagination;
    }
}

function export_leads() {
    $rteurn_array = leads_fetach();
    global $leads_dynamic_index, $wpdb;
    $sqlfeatch = $wpdb->get_results("SELECT * FROM $leads_dynamic_index", ARRAY_A);
    foreach ($sqlfeatch as $row) {
        $csv1[] = $row["lead_name"];
    }
    $sql = $rteurn_array['sql'];
    $uploads = wp_upload_dir();
    $newfile = $uploads['basedir'];
    $importpath = $uploads['baseurl'];
    $importleads = $importpath . "/leads_capture_data.csv";
    $filename = $newfile . "/leads_capture_data.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('Leads', $csv1[0], $csv1[1], $csv1[2], $csv1[3], $csv1[4], $csv1[5], $csv1[6], $csv1[7], $csv1[8], $csv1[9], 'Date M/DD/YYYY'));
    $count = 1;
//data fetch for CSV file	
    if (!empty($sql)) {
        foreach ($sql as $row) {
            $id = $row["id"];
            $name = $row["name"];
            $leadform1 = $row["leadform1"];
            $leadform2 = $row["leadform2"];
            $leadform3 = $row["leadform3"];
            $leadform4 = $row["leadform4"];
            $leadform5 = $row["leadform5"];
            $leadform6 = $row["leadform6"];
            $leadform7 = $row["leadform7"];
            $leadform8 = $row["leadform8"];
            $leadform9 = $row["leadform9"];
            $date = $row["date"];
            $handle = fopen($filename, 'a');
            fputcsv($handle, array($count, $name, $leadform1, $leadform2, $leadform3, $leadform4, $leadform5, $leadform6, $leadform7, $leadform8, $leadform9, $date));
            fclose($handle);
            $count++;
        }
    }
    return $importleads;
}

function leads_radio($textid, $id, $required = '') {
    global $wpdb, $lead_field_table, $radio_table;
    $sqlfeatch2 = $wpdb->get_results("SELECT * FROM $lead_field_table", ARRAY_A);
    foreach ($sqlfeatch2 as $row2) {
        $rtext = $row2["text_name"];
        $fname = $row2["field_name"];
        $fnid = $row2["field_id"];
        $id2 = $row2["ID"];
        if ($id == $id2) {
//            echo '</br>';
            $field_required = ($required) ? '"required = "required"' : '""';
            $array_radio = '<label class="leads-radio-div"><input type="radio" ' . $field_required . ' id="radiobox" name="' . $textid . '" value="' . $rtext . '"><span class="radiomark"></span><div class="radioname">' . $rtext . '</div></label>';
            echo $array_radio;
        }
    }
}

function leads_chkbox($textid, $id) {
    global $wpdb, $lead_field_table, $radio_table;
    $sqlfeatch2 = $wpdb->get_results("SELECT * FROM $lead_field_table", ARRAY_A);
    foreach ($sqlfeatch2 as $row2) {
        $rtext = $row2["text_name"];
        $fname = $row2["field_name"];
        $fnid = $row2["field_id"];
        $id2 = $row2["ID"];
        if ($id == $id2) {
            ?>
            <!--</br>-->

            <label class="leads-check-div"><input type="checkbox" id="chkbox" name="<?php echo $textid; ?>[]" value="<?php echo $rtext; ?>"><span class="checkmark"></span><div class="checkname"><?php echo $rtext; ?></div></label>
            <?php
        }
    }
}

function leads_textarea($textname, $textid, $required = '', $id) {
    $br = new LeadsSetData();
    $browser = $br->user_browser();
    global $wpdb;
    $sqlfeatch2 = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "lead_field_count WHERE ID = $id", ARRAY_A);

    if (isset($sqlfeatch2)) {
        ?>

    <?php } ?>
    <li class="ml_textarea">
        <h4 class="multi_line_textarea_field"><?php
            foreach ($sqlfeatch2 as $item) {
                echo $item['text_value'];
            }
            ?></h4>
        <textarea name="<?php echo $textid; ?>" <?php if ($textid == "label1" || $textid == "label2" || $textid == "label3" || $textid == "label4" || $textid == "label5" || $textid == "label6" || $textid == "label7") { ?> id="add_comments" <?php } else { ?> id="lead_comments" <?php } ?>  <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                            this.value = '';
                        }" onblur="if (this.value == '') {
                                    this.value = '<?php echo $textname; ?>';
                                }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                  echo $textname;
                  echo ($required) ? "*" : "";
                  ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField" <?php echo ($required) ? "required" : ""; ?> ><?php
                  if ($browser == "ie") {
                      echo $textname;
                  }
                  ?></textarea></li>
    <?php
}

function leads_text($textname, $textid, $texttype, $required = '', $id) {
    $br = new LeadsSetData();
    $browser = $br->user_browser();
    global $wpdb;

    $sqlfeatch2 = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "lead_field_count WHERE ID = $id", ARRAY_A);

    if ($textid == 'Email') {
        ?>

        <li class="sl_mail_address">
            <h4 class="single_line_text_field"><?php
                foreach ($sqlfeatch2 as $item) {
                    echo $item['text_value'];
                }
                ?></h4>
            <input type="email" name="<?php echo $textid; ?>" id="leademail" <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                                    this.value = '';
                                }" onblur="if (this.value == '') {
                                            this.value = '<?php echo $textname; ?>';
                                        }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField email" <?php echo ($required) ? "required" : ""; ?>  />
        </li>
        <?php
    } else if ($textid == 'Name') {
        ?>
        <li class="sl_text_name">
            <h4 class="single_line_text_field"><?php
                foreach ($sqlfeatch2 as $item) {
                    echo $item['text_value'];
                }
                ?></h4>
            <input type="text" name="<?php echo $textid; ?>" id="leadname" <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                                    this.value = '';
                                }" onblur="if (this.value == '') {
                                            this.value = '<?php echo $textname; ?>';
                                        }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField" <?php echo ($required) ? "required" : ""; ?>  />
        </li>

    <?php } else if ($textid == 'Number') {
        ?>      
        <li class="num_field">
            <h4 class="label_num_field"><?php
                foreach ($sqlfeatch2 as $item) {
                    echo $item['text_value'];
                }
                ?></h4>

            <input type="number" name="<?php echo $textid; ?>" id="leadnumber" <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                                    this.value = '';
                                }" onblur="if (this.value == '') {
                                            this.value = '<?php echo $textname; ?>';
                                        }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField" <?php echo ($required) ? "required" : ""; ?>  />
        </li>
        <?php
    } else {
        switch ($texttype) {
            case 'text':
                $input_class = 'add_sl_text_name';
                $heading_class = 'single_line_text_field';
                break;
            case 'number':
                $input_class = 'add_num_field';
                $heading_class = 'label_num_field';
                break;
            default:
                $input_class = '';
                $heading_class = '';
        }

        switch ($textname) {
            case 'Name':
                $input_id = 'leaduser_name';
                break;
            case 'Email':
                $input_id = 'leaduser_email';
                break;
            case 'Number':
                $input_id = 'leaduser_num';
                break;
            default:
                $input_id = 'leaduser';
        }
        ?>

        <li class="<?php echo esc_attr($input_class); ?>">
            <h4 class="<?php echo esc_attr($heading_class); ?>"><?php
                foreach ($sqlfeatch2 as $item) {
                    echo $item['text_value'];
                }
                ?></h4>
            <input type="<?php echo $texttype; ?>" name="<?php echo $textid; ?>" id="<?php echo $input_id ?>" <?php
            $br = new LeadsSetData();
            $browser = $br->user_browser();
            if ($browser == "ie") {
                ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                                        this.value = '';
                                    }" onblur="if (this.value == '') {
                                                this.value = '<?php echo $textname; ?>';
                                            }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField" <?php echo ($required) ? "required" : ""; ?>  />
        </li>                            
        <?php
    }
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

function lead_option_css() {
    $add_css = '';
    if (get_option('leadcapture-field_heading_col') != '') {
        $add_css .= '.inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.single_line_text_field,'
                . '.inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.multi_line_textarea_field,'
                . '.inkleadsform-conatainer .inkleadsform .sign_in_form .inkleadsul h4.label_num_field,'
                . ' .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.checkheading,'
                . ' .inkleadsform-conatainer .inkleadsform .sign_in_form ul.inklead_btn_box span.lead_radioheading
{color:' . get_option('leadcapture-field_heading_col') . '!important;}';
    }

    if (get_option('leadcapture-heading_col') != '') {
        $add_css .= '.inkleadsform-conatainer h2.heading{color:' . get_option('leadcapture-heading_col') . '!important;}';
    }
    if (get_option('leadcapture-heading_sep_col') != '') {
        $add_css .= '.inkleadsform-conatainer h2.heading {
    border-bottom: 1px solid ' . get_option('leadcapture-heading_sep_col') . '!important;
}';
    }
    if (get_option('leadcapture-font_col') != '') {
        $add_css .= '.inkleadsform .sign_in_form ul.inkleadsul li textarea,'
                . ' .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"],'
                . ' .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"],'
                . ' .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]'
                . '{color:' . get_option('leadcapture-font_col') . '!important;}'
                . '.inkleadsform .sign_in_form ul.inkleadsul li textarea::-webkit-input-placeholder,
            .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::-webkit-input-placeholder,
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::-webkit-input-placeholder, 
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::-webkit-input-placeholder{ /* Chrome/Opera/Safari */
  color:' . get_option('leadcapture-font_col') . '!important;
}
.inkleadsform .sign_in_form ul.inkleadsul li textarea::-moz-placeholder, 
  .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]::-moz-placeholder, 
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]::-moz-placeholder,
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]::-moz-placeholder { /* Firefox 19+ */
  color:' . get_option('leadcapture-font_col') . '!important;
}
.inkleadsform .sign_in_form ul.inkleadsul li textarea:-ms-input-placeholder ,
.inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:-ms-input-placeholder ,
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:-ms-input-placeholder ,
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:-ms-input-placeholder{ /* IE 10+ */
  color:' . get_option('leadcapture-font_col') . '!important;
}
.inkleadsform .sign_in_form ul.inkleadsul li textarea:-moz-placeholder,
  .inkleadsform .sign_in_form ul.inkleadsul li input[type="text"]:-moz-placeholder,
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="number"]:-moz-placeholder, 
           .inkleadsform .sign_in_form ul.inkleadsul li input[type="email"]:-moz-placeholder{ /* Firefox 18- */
  color:' . get_option('leadcapture-font_col') . '!important;
}';
    }
    if (get_option('leadcapture_btn_bg_col') != '') {
        $add_css .= '.inkleadsform .sign_in_form div.btn_btn_submit div.inkleadsbutton input[type="submit"]'
                . '{background-color:' . get_option('leadcapture_btn_bg_col') . '!important;}';
    }
    if (get_option('leadcapture_btn_txt_col') != '') {
        $add_css .= '.inkleadsform .sign_in_form div.btn_btn_submit div.inkleadsbutton input[type="submit"]'
                . '{color:' . get_option('leadcapture_btn_txt_col') . '!important;}';
    }
    if (get_option('leads_form_bg_col') != '') {
        $add_css .= '.inkleadsform-conatainer'
                . '{background:' . get_option('leads_form_bg_col') . '!important;}';
    }
    if (get_option('leads_form_fields_bg_col') != '') {
        $add_css .= '.inkleadsform . ul.inkleadsul li textarea,
.inkleadsform . ul.inkleadsul li input[type="text"],
.inkleadsform . ul.inkleadsul li input[type="number"],
.inkleadsform . ul.inkleadsul li input[type="email"]'
                . '{background:' . get_option('leads_form_fields_bg_col') . '!important;'
                . 'border: solid 1px ' . get_option('leads_form_fields_bg_col') . '!important;}';
    }



    echo "<style>" . $add_css . "</style>";
}

if (!is_plugin_active('elementor/elementor.php')) {
    add_action('wp_print_styles', 'lead_option_css');
}
