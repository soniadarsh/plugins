<?php
// Create the page
//function dynamic_create_form() {
// here we have created the object of Apt_Db
$obj_data = new Apt_DB();
$lead_field_table = $obj_data->tbl_apt_lead_field_table;
$lead_field_count = $obj_data->tbl_apt_lead_field_count;
$lead_select_field = $obj_data->tbl_apt_lead_select_field;
$root = $this->dir_url . 'ink-admin/';
$admin_url = admin_url('admin.php?page=customfield', '');
global $wpdb;
//global $lead_field_count;
//delete column
$countdelete = 1;
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $wpdb->query($wpdb->prepare("DELETE FROM $lead_field_count WHERE ID = %d", $id));
}
if (isset($_GET['add-lead'])) {
    global $wpdb;
//    global $lead_field_count, $lead_field_table;
    $addlead = $_GET['add-lead'];
    $spid = $wpdb->get_row("SELECT * FROM $lead_field_table WHERE PID=$addlead", ARRAY_N);
    $field_id = $spid[2] . '_' . $spid[1];
    $query = $wpdb->insert($lead_field_table, array(
        'ID' => $spid[1],
        'field_name' => $spid[2],
        'text_name' => 'New Field',
        'field_id' => $field_id,
    ));
}
if (isset($_GET['delete-lead'])) {
    $pid = $_GET['delete-lead'];
    global $wpdb;
//    global $lead_field_count, $lead_field_table;
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
//    global $wpdb, $lead_field_count;
//        $radiochk = $wpdb->get_row("SELECT * FROM $lead_field_count WHERE  text_name='$myselect'");
//        var_dump($radiochk);
//        $chkradio = $radiochk->text_name;
    if (($myselect == 'select') || empty($cname)) {
//featch randam value
        echo "<div style='color:red; margin-top:10px; margin-left:150px;'>" . __('Enter Field Name / Select Field Type', 'appointment') . " </div>";
    } else {
//        global $lead_field_table, $lead_field_count, $lead_select_field;
//        $lead_field_table = $obj_data->tbl_apt_lead_field_table;
//        $lead_field_count = $obj_data->tbl_apt_lead_field_count;
//        $lead_select_field = $obj_data->tbl_apt_lead_select_field;

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
    $newclass = new AptLeadsSetData();
    $newclass->table_update($label, $cname);
} // end add if
$count = $wpdb->get_var("SELECT COUNT(*) FROM $lead_field_count");
?>
<div id="tabvanilla" class="inkwidget">
    <h3>Add Custom Field In Your Form</h3>
    <div id="popular" class="tabdiv">           
        <?php if ($count <= 9) { ?>
            <div class="custom-header">
                <form action="<?php echo $admin_url; ?>" method="post" >
                    <select style="display:none;" id="textlabel" name="textlabel" >
                        <?php
                        $a = new AptLeadsSetData();
                        if (!$a->check('label1')) {
                            ?> <option value="label1"><?php _e('Label1', 'appointment'); ?></option> <?php
                        }
                        if (!$a->check('label2')) {
                            ?> <option value="label2"><?php _e('Label2', 'appointment'); ?></option> <?php
                        }
                        if (!$a->check('label3')) {
                            ?> <option value="label3"><?php _e('Label3', 'appointment'); ?></option> <?php
                        }
                        if (!$a->check('label4')) {
                            ?> <option value="label4"><?php _e('Label4', 'appointment'); ?></option> <?php
                        }
                        if (!$a->check('label5')) {
                            ?> <option value="label5"><?php _e('Label5', 'appointment'); ?></option> <?php
                        }
                        ?>
                    </select>
                    <table class="wp-list-table widefat fixed pages" style=" width:900px; ">
                        <thead>
                            <tr>
                                <th  scope="col"> <label><?php _e('Field Name:', 'appointment'); ?></label> </th>
                                <th  scope="col"> <input type="text" name="cname" id="cname" /></th>
                                <th  scope="col"><label><?php _e('Select Field Type:', 'appointment'); ?></label></th>
                                <th  scope="col">
                                    <select id="myselect" name="myselect">
                                        <option value="select"><?php _e('--- Select ---', 'appointment'); ?></option>
                                        <option value="text">Single Line Text</option>
                                        <option value="textarea">Multi Line Text</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="radio">Radio</option>
                                        <option value="number">Number</option>
                                    </select>
                                </th>
    <!--									<th  scope="col">
                                        <label>Required:<input type="checkbox" name="required" id="required" class="required"/></label>
                                </th>-->
                                <th  scope="col">
                                    <input type="submit" name="add" id="lead-add" value="<?php _e('Add Field', 'appointment'); ?>" />
                                    <input type="hidden" name="randvalue" id="randvalue" value="<?php echo rand(); ?>" />
                                </th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
            <?php
        }

        /**
         * second updated table program
         */
        global $wpdb;
//        global $lead_field_count;
        ?>
        <table class="wp-list-table widefat fixed pages" style="width:900px;">
            <?php
            $query = "SELECT * FROM $lead_field_count ";
            $results = $wpdb->get_results($query);
            if ($results) {
                ?>
                <thead>
                    <tr>
                        <th class="field" scope="col"><?php _e('S.No.', 'appointment'); ?></th>
                        <th  class="rckbox" scope="col"><?php _e('Field Name', 'appointment'); ?></th>
                        <th  class="fieldname" scope="col"><?php _e('Field Options', 'appointment'); ?></th>
                        <th  class="field_type" scope="col"><?php _e('Field Type', 'appointment'); ?></th>
                        <!--<th  class="required" scope="col"><?php //_e('Required', 'appointment'); ?></th>-->
                        <th  class="field_edit" scope="col"><?php _e('Edit', 'appointment'); ?></th>                            
                        <th  class="action" scope="col"><?php _e('Delete', 'appointment'); ?></th>
                    </tr>
                </thead>
                <?php
// text/text area update
                if (isset($_POST['update'])) {
                    global $wpdb;
//                    global $lead_field_count, $lead_field_table; 
                    $rname = $_POST['rname'];
                    if (isset($_POST['required'])) {
                        $required = $_POST['required'];
                    } else {
                        $required = '';
                    }
                    $uname = $_POST['uname'];
                    $ulabel = $_POST['ulabel'];
                    $wpdb->update($lead_field_count, array('text_value' => $rname, 'required' => $required), array('ID' => $uname), array('%s'), array('%d'));
                    $newclass = new AptLeadsSetData;
                    $newclass->table_update($ulabel, $rname);
                }
// checkbox/radio update
                if (isset($_POST['update-lead'])) {
                    global $wpdb;
//                    global $lead_field_count, $lead_field_table;
                    $cbname = $_POST['cbname'];
                    $crname = $_POST['crname'];
                    $pidname = $_POST['pidname'];
                    $idname = $_POST['idname'];
                    $ulabel = $_POST['ulabel'];
                    $required = isset($_POST['required']) ? $_POST['required'] : '';
                    $wpdb->update($lead_field_table, array('text_name' => $crname), array('PID' => $pidname), array('%s'), array('%d'));
                    $wpdb->update($lead_field_count, array('text_value' => $cbname, 'required' => $required), array('ID' => $idname), array('%s'), array('%d'));
                    $newclass = new AptLeadsSetData;
                    $newclass->table_update($ulabel, $cbname);
                }
//                global $lead_field_count;
                $sqlfeatch = $wpdb->get_results("SELECT * FROM $lead_field_count", ARRAY_A);
                $count = 1;
                foreach ($sqlfeatch as $row) {
                    $number = 1;
                    $number1 = 1;
                    $id = $row["ID"];
                    $inputname = $row["text_name"];
                    $textname = $row["text_value"];
                    $required = $row["required"];
//                    echo $number . $number1 . $inputname . $textname . $required;
                    if (($inputname == 'radio') || ($inputname == 'checkbox')) { //Only radio and checkbox allow
//                        global $lead_field_table;
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
                                                <?php echo $count++.'.'; ?></th>
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
                                            global $wpdb;
//                                            global $lead_field_count;
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
                                        <th  scope="col"><a href="<?php echo $admin_url . "&delete-lead=" . $PID; ?>"><img src="<?php echo $root; ?>/images/ico-close.png" alt="Delete" height="16" width="16" /></a></th>
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
                                        <th  scope="col"><a id="edit" href="<?php echo $admin_url . "&edit2=" . $PID; ?>"><img src="<?php echo $root; ?>images/icon-edit.png" alt="edit" height="16" width="16" /></a>
                                            <a href="<?php echo $admin_url . "&add-lead=" . $PID; ?>"><img src="<?php echo $root; ?>images/icon-add.png" alt="Delete" height="16" width="16" /></a>
                                        </th>
                                        <th  scope="col">
                                            <a href="<?php echo $admin_url . "&delete-lead=" . $PID; ?>">
                                                <img src="<?php echo $root; ?>images/ico-close.png" alt="Delete" height="16" width="16" />
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
                                <th  class="field" scope="col"><?php echo $count++.'.'; ?></th>
                                <?php
                                if (isset($_GET['edit'])) {
                                    $update = $_GET['edit'];
                                } else {
                                    $update = '';
                                }
                                if (($update == $id)) {
                                    $editid = $_GET['edit'];
                                    global $wpdb;
//                                    global $lead_field_count;
                                    $rid = $wpdb->get_row("SELECT * FROM $lead_field_count WHERE ID = $editid", ARRAY_N);
                                    
                                    ?>
                            <form action="<?php echo $admin_url . "&update=" . $id; ?>" method="post">
                                <th  scope="col"><input type="text" name="rname" id="rname" value="<?php echo $rid[2]; ?>" /></th> 
                                <th  scope="col"></th>
                                <th  scope="col"> <?php echo $rid[1]; ?></th>
                                <th  scope="col" style="display:none;"> <input type="text" name="uname" id="uname" value="<?php echo $rid[0]; ?>" /></th>
                                <th  scope="col" style="display:none;"> <input type="text" name="ulabel" id="ulabel" value="<?php echo $rid[3]; ?>" />
                                </th>
                                <!--<th  scope="col"><input type="checkbox" <?php echo ($rid[4]) ? 'checked="checked"' : ''; ?> name="required" id="required" /></th>-->
                                <th  scope="col"><input type="submit" name="update" id="update-lead"  value="" /></th>
                                <th  scope="col"><a href="<?php echo $admin_url . "&delete=" . $id; ?>"><img src="<?php echo $root; ?>images/ico-close.png" alt="Delete" height="16" width="16" /></a></th>
                            </form>
                            <?php
                        } else {
                            if (($inputname != 'radio') && ($inputname != 'checkbox')) {
                                ?>
                                <th  scope="col"><?php echo $textname; ?></th> 
                                <th  scope="col"></th> 
                                <th  scope="col"><?php echo $inputname; ?></th>
                                <!--<th  scope="col"><?php echo ($required) ? "Yes" : "No"; ?></th>-->
                                <th  scope="col"><a id="edit" href="<?php echo $admin_url . "&edit=" . $id; ?>"><img src="<?php echo $root; ?>images/icon-edit.png" alt="edit" height="16" width="16" /></a></th>                                    
                                <th  scope="col"><a href="<?php echo $admin_url . "&delete=" . $id; ?>"><img src="<?php echo $root; ?>images/ico-close.png" alt="Delete" height="16" width="16" /></a></th>
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
                        <th colspan="7"><?php _e("No fields", 'appointment'); ?></th>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- second update table ends -->
    </div><!--/popular-->
</div><!--/widget-->
<?php
//}
//if (isset($_POST['curradd'])) {
//    if (isset($_POST['currname']) && $_POST['currcode'] && $_POST['currsymbol']) {
//        $currname = $_POST['currname'];
//        $currcode = $_POST['currcode'];
//        $currsymbol = $_POST['currsymbol'];
//        $query = $wpdb->insert($currency_table, array(
//            'apt_c_name' => $currname,
//            'apt_c_code' => $currcode,
//            'apt_c_symbol' => $currsymbol,
//            'apt_c_des' => ''
//        ));
//        if ($query):
//            echo "<p>Note: Currency Inserted Successfully<p>";
//        endif;
//    } else {
//        echo "<p>Note: Please Fill Up The Complete Data<p>";
//    }
//}
?>

<!--<h3>Add Your Own Currency</h3>
<div class="Currency-addition">
    <form action="<?php echo $admin_url ?>" method="post">
        <label><?php _e('Enter Currency Name:', 'appointment'); ?></label> 
        <input type="text" name="currname" id="currname"/>
        <label><?php _e('Enter Currency Code:', 'appointment'); ?></label> 
        <input type="text" name="currcode" id="currcode"/>
        <label><?php _e('Enter Currency Symbol:', 'appointment'); ?></label> 
        <input type="text" name="currsymbol" id="currsymbol"/>
        <input type="submit" name="curradd" id="curradd" value="<?php _e('Add Currency', 'appointment'); ?>" />
    </form>
</div>-->