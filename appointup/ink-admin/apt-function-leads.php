<?php

function apt_leads_fetach() {
    $leadsdata_url = admin_url('admin.php?page=leadsdata', 'https');
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

function apt_leads_radio($textid, $id, $required = '') {
    $obj_data = new Apt_DB();
    $lead_field_table = $obj_data->tbl_apt_lead_field_table;
    global $wpdb;
//    global $lead_field_table, $radio_table;

    $sqlfeatch2 = $wpdb->get_results("SELECT * FROM $lead_field_table", ARRAY_A);
    foreach ($sqlfeatch2 as $row2) {
        $rtext = $row2["text_name"];
        $fname = $row2["field_name"];
        $fnid = $row2["field_id"];
        $id2 = $row2["ID"];
        if ($id == $id2) {
//            echo '</br>';
            $field_required = ($required) ? '"required = "required"' : '""';
            $array_radio = '<label class="lead-radio-div"><input type="radio" ' . $field_required . ' id="radiobox" name="' . $textid . '" value="' . $rtext . '"><span class="radiomark"></span><div class="radioname">' . $rtext . '</div></label>';
            echo $array_radio;
        }
    }
}

function apt_leads_chkbox($textid, $id) {
    global $wpdb;
    $obj_data = new Apt_DB();
    $lead_field_table = $obj_data->tbl_apt_lead_field_table;
//    global $lead_field_table, $radio_table;
    $sqlfeatch2 = $wpdb->get_results("SELECT * FROM $lead_field_table", ARRAY_A);
    foreach ($sqlfeatch2 as $row2) {
        $rtext = $row2["text_name"];
        $fname = $row2["field_name"];
        $fnid = $row2["field_id"];
        $id2 = $row2["ID"];
        if ($id == $id2) {
            ?>
            <label class="lead-check-div">
                <input type="checkbox" id="chkbox" name="<?php echo $textid; ?>[]" value="<?php echo $rtext; ?>">
                <span class="checkmark"></span>
                <div class="checkname"><?php echo $rtext; ?></div>
            </label>
            <?php
        }
    }
}

function apt_leads_textarea($textname, $textid, $required = '', $id) {
    $br = new AptLeadsSetData();
    $browser = $br->user_browser();
    global $wpdb;
$sqlfetch = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "apt_lead_field_count WHERE ID = $id", ARRAY_A);
?>

    <li>
        <?php
        if (!empty($sqlfetch)) {
        ?>
        <div class="textfixdate1">
            <h4>
                <span class="fix_date">
                    <?php
                    foreach ($sqlfetch as $item) {
                        echo $item['text_value'];
                    }
                    ?>                
                </span>
            </h4>
        </div>
    <?php } ?>
        <textarea name="<?php echo $textid; ?>" class="inktext inklarge" id="textmsg" <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
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
              ?></textarea> </li>
    <?php
}

function apt_leads_text($textname, $textid, $texttype, $required = '', $id) {
    $br = new AptLeadsSetData();
    $browser = $br->user_browser();
    global $wpdb;
    $sqlfetch = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "apt_lead_field_count WHERE ID = $id", ARRAY_A);
    if ($textname == 'Email') {
        
        ?>
        <li><input type="email" name="<?php echo $textid; ?>" class="inktext inklarge" id="leademail" <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                        this.value = '';
                    }" onblur="if (this.value == '') {
                                this.value = '<?php echo $textname; ?>';
                            }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField email" <?php echo ($required) ? "required" : ""; ?>  />
        </li>
        <?php } else { ?>				
        <li class="text_field">  
        <?php if (!empty($sqlfetch)) { ?>
                <div class="textfixdate2">
                    <h4>
                        <span class="fix_date">
                            <?php
                            foreach ($sqlfetch as $item) {
                                echo $item['text_value'];
                            }
                            ?>                
                        </span>
                    </h4>
                </div>
            <?php } ?>
            <input type="<?php echo $texttype; ?>" class="inktext inklarge" name="<?php echo $textid; ?>" id="leaduser" <?php
            $br = new AptLeadsSetData();
            $browser = $br->user_browser();
            if ($browser == "ie") {
                ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                                        this.value = '';
                                    }" onblur="if (this.value == '') {
                                                this.value = '<?php echo $textname; ?>';
                                            }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField" <?php echo ($required) ? "required" : ""; ?>  /></li>                            
                   <?php
               }
           }

           function apt_leads_number($textname, $textid, $texttype, $required = '', $id) {
               $br = new AptLeadsSetData();
               $browser = $br->user_browser();
               global $wpdb;
              $sqlfetch = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "apt_lead_field_count WHERE ID = $id", ARRAY_A);
               if ($textname == 'Number') {
                   ?>
        <li>

            <input type="number" name="<?php echo $textid; ?>" class="inktext inklarge" id="leadnum" <?php if ($browser == "ie") { ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                            this.value = '';
                        }" onblur="if (this.value == '') {
                                    this.value = '<?php echo $textname; ?>';
                                }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField number" <?php echo ($required) ? "required" : ""; ?> min="1"/></li>
        <?php } else { ?>				
        <li class="num_field">  
        <?php if (!empty($sqlfetch)) { ?>
                <div class="textfixdate3">
                    <h4>
                        <span class="fix_date">
                            <?php
                            foreach ($sqlfetch as $item) {
                                echo $item['text_value'];
                            }
                            ?>                
                        </span>
                    </h4>
                </div>
            <?php } ?>
            <input type="<?php echo $texttype; ?>" class="inktext inklarge" name="<?php echo $textid; ?>" id="leadnum" <?php
            $br = new AptLeadsSetData();
            $browser = $br->user_browser();
            if ($browser == "ie") {
                ?> onfocus="if (this.value == '<?php echo $textname; ?>') {
                                        this.value = '';
                                    }" onblur="if (this.value == '') {
                                                this.value = '<?php echo $textname; ?>';
                                            }" value="<?php echo $textname; ?>"  <?php } ?>  placeholder="<?php
                   echo $textname;
                   echo ($required) ? "*" : "";
                   ?>" class="<?php echo ($required) ? "required" : ""; ?> requiredField" <?php echo ($required) ? "required" : ""; ?>  min="1"/></li>                        
        <?php
    }
}

function apt_generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
