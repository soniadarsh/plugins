<?php

function past_appointment_detail() {
    global $wpdb;
    $db_obj = new Apt_DB();
    $appointment_data = $db_obj->tbl_appointment_data;
    $apt_transaction = $db_obj->tbl_transaction;
    if (isset($_POST['chkall_aptsubmit'])) {
        if (!empty($_POST['check_apt_list'])) {
            foreach ($_POST['check_apt_list'] as $checked) {
                $wpdb->query($wpdb->prepare("DELETE FROM $appointment_data WHERE APTID = %d", $checked));
                $wpdb->query($wpdb->prepare("DELETE FROM $apt_transaction WHERE TXN_ID = %d", $checked));
            }
        }
    }
    $todaydate = date("m/d/Y");     
    $query = "SELECT * FROM $appointment_data WHERE apt_data_date < '$todaydate' ORDER BY apt_data_date DESC $limit"; 
    $nr = $wpdb->query($query);
    if ($nr >= 1) {
        if (isset($_GET['pn'])) {
            $pn = preg_replace('/#[^0-9]#i/', '', $_GET['pn']);
        } else {
            $pn = 1;
        }
        $itemsPerPage = 10;
        $lastPage = ceil($nr/$itemsPerPage);
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
            $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pn == $lastPage) {
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
        } else if ($pn > 2 && $pn < ($lastPage - 1)) {
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pn > 1 && $pn < $lastPage) {
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }
        $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
//$sql2 = mysql_query("SELECT * FROM $appointment_data ORDER BY APTID DESC $limit");
        $pastsqldata = "SELECT * FROM $appointment_data WHERE apt_data_date < '$todaydate' ORDER BY apt_data_date DESC $limit";       
        $paginationDisplay = "";
        if ($lastPage != "1") {
//$paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
            if ($pn != 1) {
                $previous = $pn - 1;
                $paginationDisplay .= '&nbsp;  <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $previous . '">«</a> ';
            }
            $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
            if ($pn != $lastPage) {
                $nextPage = $pn + 1;
                $paginationDisplay .= '&nbsp;  <a class="inkpeginumber" href="' . get_permalink() . '?page=pasttrans&pn=' . $nextPage . '">»</a> ';
            }
        }
    }
    ?>
    <?php
    if ($_GET['page'] == 'pasttrans') {
        ?>
        <script language="javascript">
            jQuery(function () {
                // add multiple select / deselect functionality
                jQuery("#selectall_chkapt").click(function () {
                    jQuery('.chk_info').attr('checked', this.checked);
                });

                // if all checkbox are selected, check the selectall checkbox
                // and viceversa
                jQuery(".chk_info").click(function () {

                    if (jQuery(".chk_info").length == jQuery(".chk_info:checked").length) {
                        jQuery("#selectall_chkapt").attr("checked", "checked");

                    } else {
                        jQuery("#selectall_chkapt").removeAttr("checked");
                    }

                });
            });
        </script>
    <?php } ?>
    <div class="showdata">
        <h3><?php _e('All Past Appointments', 'appointment'); ?></h3>
        <form action="" method="post" >
            <table id="apt_data_show" class="wp-list-table widefat fixed pages" >
                <thead >
                    <tr>
                        <th  scope="col"><?php _e('Service Name', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Appointment Date', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Appointment Time', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Person Name', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Contact Email', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Contact Number', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Message', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Amount Paid', 'appointment'); ?></th>
                        <th  scope="col"><?php _e('Booking Date', 'appointment'); ?></th>
                        <th  scope="col" width="50px;" ><input type="checkbox" id="selectall_chkapt"/></th>
                    </tr>
                </thead>
                <?php
                $queries = $wpdb->get_results($pastsqldata);
                ?>
                <tbody>
                    <?php
                    $as = new AptService();
                    if (!empty($queries)) {
                        if ($nr >= 1) {
                            foreach ($queries as $query) {
                                if (get_option('apt_dformat') == '1') {
                            $datechange = str_replace('/', '/', $query->apt_data_date);          
                            $dateformat = explode('/', $datechange);       
                            $bookingdate = $dateformat[1] . '/' . $dateformat[0] . '/' . $dateformat[2];        
                        } else {
                           $bookingdate = $query->apt_data_date;
                        } 
                                ?>
                                <tr>
                                    <th  scope="col"><?php echo $query->apt_data_service_name; ?></th>
                                    <th  scope="col"><?php echo $bookingdate; ?></th>
                                    <th  scope="col"><?php echo $query->apt_data_time; ?></th>
                                    <th  scope="col"><?php echo $query->apt_data_persion_name; ?></th>
                                    <th  scope="col"><?php echo $query->apt_data_email; ?></th>
                                    <th  scope="col"><?php echo $query->apt_data_mobile; ?></th>
                                    <th  scope="col"><?php echo $query->apt_data_message; ?></th>
                                    <?php if ($query->apt_payment_method == 'paypal') { ?>
                                        <th  scope="col"><a href="<?php echo get_permalink() . "?page=bookedappointment&payment=" . $query->APTID; ?>"><?php echo $query->apt_data_price; ?></a></th>
                                    <?php } else { ?><th  scope="col"><?php echo $query->apt_data_price; ?></th> <?php } ?>
                                    <th  scope="col"><?php echo $query->apt_data_current_date; ?></th>
                                    <th class="textcenter"><input type="checkbox" class="chk_info" name="check_apt_list[]" value="<?php echo $query->APTID; ?>"/></th>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <th  colspan=10 scope="col"><a href="<?php echo get_permalink() . '?page=bookedappointment'; ?> "><?php _e('Back to All Booked Appointments', 'appointment'); ?></a><input type='submit' id='chkall_aptsubmit' name='chkall_aptsubmit'  value='<?php _e('Delete Checked', 'appointment'); ?>'/></th> 
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
        <div class="apt-pegi">	<strong><?php echo $nr; ?>&nbsp Items</strong>&nbsp &nbsp <?php echo $paginationDisplay; ?> </div> 
    </div>
    <?php
}
