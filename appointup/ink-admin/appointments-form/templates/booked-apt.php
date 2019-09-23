<div class="showdata">
    <h3><?php _e('Booked Appointments', 'appointment'); ?><a href="<?php echo admin_url() . 'admin.php?page=viewcalendar'; ?>" class="apt-cal-btn"><?php _e('View in Calendar', 'appointment'); ?></a></h3>
    <form action="#" method="post" >
        <table id="apt_data_show" class="wp-list-table widefat fixed pages" >
            <thead >
                <tr>
                    <th  scope="col"><?php _e('Service Name', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Appointment Date', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Appointment Time', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Client Name', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Contact Email', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Contact Number', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Message', 'appointment'); ?></th>
                    <?php
                    $leads_dynamic_index = $db->tbl_apt_leads_dynamic_index;
                    $sqlfeatch = $db->db->get_results("SELECT * FROM $leads_dynamic_index", ARRAY_A);
                    foreach ($sqlfeatch as $row) {
                        ?>
                        <th  scope="col"><?php echo $row["lead_name"]; ?> </th>
                    <?php } ?> 
                    <th  scope="col"><?php _e('Amount Paid', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Booking Date', 'appointment'); ?></th>
                    <th  scope="col" width="50px;" ><input type="checkbox" id="show_chkapt"/></th>
                </tr>
            </thead>
            <?php
            if (!isset($sqldata)) {
                $sqldata = '';
            }
            global $limit;
            $bookedtodaydate = date("m/d/Y");
            
            //$query = "SELECT * FROM $db->tbl_appointment_data WHERE ddmmyyy >= $bookedtodaydate";
            
            $sqldata = "SELECT * FROM $db->tbl_appointment_data WHERE apt_data_date >= '$bookedtodaydate' ORDER BY apt_data_date DESC $limit"; 
          
            $queries = $db->db->get_results($sqldata);                                 
            ?>
            <tbody>
                <?php
                $as = new AptService();               
                if ($queries) {
                    foreach ($queries as $query) {                      
                        ?>
                        <tr>
                            <th  scope="col"><?php echo $query->apt_data_service_name; ?></th>
                            <?php
                           if (get_option('apt_dformat') == '1') {
                            $datechange = str_replace('/', '/', $query->apt_data_date);          
                            $dateformat = explode('/', $datechange);       
                            $bookingdate = $dateformat[1] . '/' . $dateformat[0] . '/' . $dateformat[2];        
                        } else {
                           $bookingdate = $query->apt_data_date;
                        }                           
                            ?>                            
                            <th  scope="col"><?php echo $bookingdate; ?></th>
                             <th  scope="col"><?php echo $query->apt_data_time; ?></th>
                            <th  scope="col"><?php echo $query->apt_data_persion_name; ?></th>
                            <th  scope="col"><?php echo $query->apt_data_email; ?></th>
                            <th  scope="col"><?php echo $query->apt_data_mobile; ?></th>
                            <th  scope="col"><?php echo $query->apt_data_message; ?></th>
                            <th  scope="col"><?php echo $query->fieldlabel1; ?></th>
                            <th  scope="col"><?php echo $query->fieldlabel2; ?></th>
                            <th  scope="col"><?php echo $query->fieldlabel3; ?></th>
                            <th  scope="col"><?php echo $query->fieldlabel4; ?></th>
                            <th  scope="col"><?php echo $query->fieldlabel5; ?></th>
                            <?php if ($query->apt_payment_method == 'paypal') { ?>
                                <th  scope="col"><a href="<?php echo get_permalink() . "?page=bookedappointment&payment=" . $query->APTID; ?>"><?php echo $query->apt_data_price; ?></a></th>
                            <?php } else { ?><th  scope="col"><?php echo $query->apt_data_price; ?></th> <?php } ?>
                            <th  scope="col"><?php echo $query->apt_data_current_date; ?></th>
                            <th class="textcenter"><input type="checkbox" class="apt_chk" name="check_apt_show[]" value="<?php echo $query->APTID; ?>"/></th>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <th  colspan=7 scope="col"><a href="<?php echo get_permalink() . '?page=bookedappointment&showtendata'; ?> "><?php _e('View All Recent Appointments', 'appointment'); ?></a></th> 
                    <th   colspan=7 scope="col">
                        <a href="<?php echo get_permalink() . '?page=pasttrans'; ?> "><?php _e('View All Past Appointments', 'appointment'); ?></a></th>
                    <th><input type='submit' id='chkall_sub' name='chkall_sub'  value='<?php _e('Delete', 'appointment'); ?>'/></th>
                </tr>
            </tbody>
        </table>
    </form>
    <div class="apt-pegi"><strong><?php echo $nr; ?>&nbsp Items</strong>&nbsp &nbsp <?php echo $paginationDisplay; ?> </div>
    <div >
        <table class="wp-list-table widefat fixed pages" style="width:280px; height:20px;" >
            <thead><tr> <th scope="col" style="text-align:center;"><?php _e('Download CSV File', 'appointment'); ?></th>         
                    <th scope="col" style="text-align:center;"> <a id="csvfile" href="<?php echo $import_appointment; ?>"><img src="<?php echo $this->dir_url; ?>/ink-admin/images/export.png" alt="Download CSV File" height="32" width="32" /></a>    </th>
            </thead></table> 
    </div>
</div>