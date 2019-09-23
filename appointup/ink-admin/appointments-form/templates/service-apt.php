<div class="aptservice">
    <h1 class="aptheading"></h1>
    <form action="<?php echo $apturl . '&service=service'; ?>" method="post">
        <table id="ap_service" class="wp-list-table widefat fixed pages">
            <thead>
                <tr>
                    <th scope="col" class="ap_srname"><label><?php _e('Enter Service Name:', 'appointment'); ?></label></th>
                    <th scope="col"><input type="text" name="srname" id="srname" placeholder="<?php _e('Name', 'appointment'); ?>" required/></th>
                    <th scope="col" id="price"><label><?php _e('Price:', 'appointment'); ?></label></th>
                    <th scope="col"><input type="text" name="srprice" id="srprice" title="<?php _e('Enter the Price for the service in numeric value: Example: 10, 15, 20', 'appointment'); ?>" required/></th>


                    <th scope="col" id="ap_type"><label><?php _e('Payment Type:', 'appointment'); ?></label></th>
                    <th scope="col">
                        <select id="sap_type" name="srpaid">
                            <option value="free">Free</option> 
                            <option value="paid" selected>Paid</option>
                        </select>
                    </th>

                    <th scope="col">
                        <input type="submit" name="sradd" id="sradd" value="<?php _e('Add New Service', 'appointment'); ?>"/>
                        <input type="hidden" name="srrand" id="srrand" value="<?php echo rand(); ?>"/>
                    </th>
                </tr>   
            </thead>
        </table>
    </form>
    <div class="show_service">
        <table id="show_service" class="wp-list-table widefat fixed pages">
            <thead>
                <tr>
                    <th scope="col" class="srno"><?php _e('Sr. No.', 'appointment'); ?></th>
                    <th scope="col" class="srname"><?php _e('Service Name', 'appointment'); ?></th>
                    <th scope="col" class="srprice"><?php _e('Service Price', 'appointment'); ?></th>
                    <th scope="col" class="srpaid"><?php _e('Service Type', 'appointment'); ?></th>
                    <th scope="col" class="sradddate"><?php _e('Add Date Slot', 'appointment'); ?></th>
                    <th scope="col" class="srnaddtime"><?php _e('Add Time Slot', 'appointment'); ?></th>
                    <th scope="col" class="sraction"><label><?php _e('Action', 'appointment'); ?></label></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queries = $wpdb->get_results("SELECT * FROM $apt_service");
                $count = 1;
                foreach ($queries as $query) {
                    $query->service_id;
                    ?>
                    <tr>
                        <th scope="col"><?php echo $count; ?></th>
                        <?php if (isset($_GET['edit-service']) && $_GET['edit-service'] == $query->service_id) { ?>
                    <form action="<?php echo $apturl . '&service=service'; ?>" method="post">
                        <th scope="col">
                            <input type="text" name="upname" id="upname" value='<?php echo $query->service_name; ?>'/>
                        </th>
                        <th scope="col">
                            <input type="text" name="upprice" id="upprice" value='<?php echo $query->service_price; ?>'/>
                        </th>
                        <th scope="col">
                            <select id="uptype" name="uptype">
                                <option value="free">Free</option> 
                                <option value="paid" <?php if ($query->service_paid == 'paid') { echo 'selected'; } ?>>Paid</option>
                            </select>
                        </th>
                        <input type="hidden" name="srid" id="srid" value='<?php echo $query->service_id; ?>'/>
                        <th scope="col">
                            <a id="add" href='<?php echo get_permalink() . "?page=createappoitment&dateslot=" . $query->service_id; ?>'>
                                <img src="<?php echo $root; ?>/images/add.png" alt="<?php _e('Add Date Slot', 'appointment'); ?>" title="<?php _e('Add Date Slot', 'appointment'); ?>" height="18" width="18"/>
                            </a>
                        </th>
                        <th scope="col">
                            <a href='<?php echo get_permalink() . "?page=createappoitment&timeslot=" . $query->service_id; ?>'>
                                <img src="<?php echo $root; ?>/images/add.png" alt="<?php _e('Add Time Slot', 'appointment'); ?>" title="<?php _e('Add Time Slot', 'appointment'); ?>" height="18" width="18"/>
                            </a>
                        </th>
                        <th scope="col">
                            <input type="submit" name="update-service" id="update-service" value="" title="<?php _e('Save Service', 'appointment'); ?>"/>
                        </th>
                    </form>
                <?php } else { ?>
                    <th scope="col"><?php echo $query->service_name; ?></th>
                    <th scope="col"><?php echo $query->service_price; ?></th>
                    <th scope="col"><?php echo $query->service_paid; ?></th>
                    <th scope="col">
                        <a id="add" href='<?php echo get_permalink() . "?page=createappoitment&dateslot=" . $query->service_id; ?>'>
                            <img src="<?php echo $root; ?>/images/add.png" alt="<?php _e('Add Date Slot', 'appointment'); ?>" height="18" width="18" title="<?php _e('Add Date Slot', 'appointment'); ?>"/>
                        </a>
                    </th>
                    <th scope="col">
                        <a id="add" href='<?php echo get_permalink() . "?page=createappoitment&timeslot=" . $query->service_id; ?>'>
                            <img src="<?php echo $root; ?>/images/add.png" alt="<?php _e('Add Time Slot', 'appointment'); ?>" height="18" width="18" title="<?php _e('Add Time Slot', 'appointment'); ?>"/>
                        </a>
                    </th>
                    <th scope="col">
                        <a id="edit" href="<?php echo $apturl . '&service&edit-service=' . $query->service_id; ?>">
                            <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16"/>&nbsp;&nbsp;
                        </a>
                        <a href="<?php echo $apturl . '&service&delete-service=' . $query->service_id; ?>">
                            <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" title="<?php _e('Delete', 'appointment'); ?>" height="16" width="16"/>
                        </a>
                    </th>
                <?php } ?>
                </tr>
                <?php
                $count++;
            }
            ?>
            </tbody>
        </table>
        <p class="service-text"><?php echo APT_TEXT; ?></p>
    </div>
</div>