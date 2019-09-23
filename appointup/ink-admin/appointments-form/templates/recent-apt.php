<style> .showdata{display:none;} </style>
<div class="showtendata">
    <h3><?php _e('Recent 10 Appointments', 'appointment'); ?></h3>
    <form action="#" method="post" >
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
                </tr>
            </thead>
            <?php
            
            $recenttodaydate = date("m/d/Y");
            $recentsqldata = "SELECT * FROM $db->tbl_appointment_data WHERE apt_data_date >= '$recenttodaydate' ORDER BY apt_data_date DESC $limit";           
            $queries = $db->db->get_results($recentsqldata);            
            if (!empty($queries)) {
                ?>
                <tbody>
                    <?php
                    $ij = 0;
                     $datechange="";
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
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <th  colspan=9 scope="col"><a href="<?php echo get_permalink() . '?page=bookedappointment'; ?> "><?php _e('Back to All Booked Appointments', 'appointment'); ?> </a></th> </tr>
            </tbody>
        </table>
    </form>
    <div class="apt-pegi">	<strong><?php echo $nr; ?>&nbsp Items</strong>&nbsp &nbsp <?php echo $paginationDisplay; ?> </div> 
</div>