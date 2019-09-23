<style> 
    .aptservice {
        display: none;
    } 
</style>
<div class="dateslot_wrap">
    <h1 class="dateslothead"></h1>
    <form class="date_slot" action="<?php echo $apturl . '&dateslot=' . $dateid; ?>" method="post">
        <table class="wp-list-table widefat fixed pages" id="apttable">
            <thead>
                <tr>
                    <th scope="col" class="aptdate"><?php _e('Opening Date', 'appointment'); ?><a id="tool-aptdate" href="#" title="<?php _e('The Start Date from which your service will be available.', 'appointment'); ?>"></a>
                    </th>
                    <th scope="col" class="closing"><?php _e('Closing Date', 'appointment'); ?><a id="tool-closing" href="#" title="<?php _e('The Close Date till your service will be available.', 'appointment'); ?>"></a>
                    </th>
                    <th scope="col" class="aptdatemon"><?php _e('Monday', 'appointment'); ?></th>
                    <th scope="col" class="aptdatetue"><?php _e('Tuesday', 'appointment'); ?></th>
                    <th scope="col" class="aptdatewed"><?php _e('Wednesday', 'appointment'); ?></th>
                    <th scope="col" class="aptdatethu"><?php _e('Thursday', 'appointment'); ?></th>
                    <th scope="col" class="aptdatefri"><?php _e('Friday', 'appointment'); ?></th>
                    <th scope="col" class="aptdatesat"><?php _e('Saturday', 'appointment'); ?></th>
                    <th scope="col" class="aptdatesun"><?php _e('Sunday', 'appointment'); ?></th>
                    <th scope="col" class="aptupdate"><label><?php _e('Update', 'appointment'); ?></label></th>
                    <th scope="col" class="apreset"><?php _e('Action', 'appointment'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $as = new AptService();
                $datechk = $wpdb->get_row("SELECT * FROM $apt_dateslot WHERE service_id = $dateid", ARRAY_A);
                ?>
                <tr>
                    <?php if (empty($datechk['dsi_str_date'])) { ?>
                        <th scope="col" class="aptdatechk"><input type="text" name="aptstartdate" id="aptstartdate" value="MM/DD/YYYY"/></th>
                    <?php } else { ?>
                        <th scope="col" class="aptdatechk"><input type="text" name="aptstartdate" id="aptstartdate" value="<?php echo $as->date_change_format($datechk['dsi_str_date']); ?>"/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_end_date'])) {
                        ?>
                        <th scope="col" class="aptdatechk"><input type="text" name="aptenddate" id="aptenddate" value="MM/DD/YYYY"/></th>
                    <?php } else { ?>
                        <th scope="col" class="aptdatechk"><input type="text" name="aptenddate" id="aptenddate" value="<?php echo $as->date_change_format($datechk['dsi_end_date']); ?>"/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_mon'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxmon" name="chkboxmon" value="2"></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxmon" name="chkboxmon" value="<?php echo $datechk['dsi_mon']; ?>" checked='checked'/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_tue'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxtue" name="chkboxtue" value="3"></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxtue" name="chkboxtue" value="<?php echo $datechk['dsi_tue']; ?>" checked='checked'/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_wed'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxwed" name="chkboxwed" value="4"></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxwed" name="chkboxwed" value="<?php echo $datechk['dsi_wed']; ?>" checked='checked'/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_thu'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxthu" name="chkboxthu" value="5"></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxthu" name="chkboxthu" value="<?php echo $datechk['dsi_thu']; ?>" checked='checked'/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_fri'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxfri" name="chkboxfri" value="6"></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxfri" name="chkboxfri" value="<?php echo $datechk['dsi_fri']; ?>" checked='checked'/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_sat'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxsat" name="chkboxsat" value="7"></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxsat" name="chkboxsat" value="<?php echo $datechk['dsi_sat']; ?>" checked='checked'/></th>
                        <?php
                    }
                    if (empty($datechk['dsi_sun'])) {
                        ?>
                        <th scope="col"><input type="checkbox" id="chkboxsun" name="chkboxsun" value="1"/></th>
                    <?php } else { ?>
                        <th scope="col"><input type="checkbox" id="chkboxsun" name="chkboxsun" value="<?php echo $datechk['dsi_sun']; ?>" checked='checked'/></th>
                    <?php } ?>
                    <th scope="col" class="aptchkupdate">
                        <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                        <input type="submit" name="chkupdate" id="chkupdate" value="<?php _e('Update', 'appointment'); ?>"/></th>
                    <th scope="col" class="sundelete">
                        <a id="chkreset" href="<?php echo $apturl . '&dateslot=' . $dateid . '&reset-dateslot=' . $dateid; ?>">
                            <label><?php _e('Reset', 'appointment'); ?></label>
                        </a>
                    </th>
                </tr>
                <tr>
                    <th colspan=11 scope="col">
                        <a style="float:left;" href='<?php echo get_permalink() . "?page=createappoitment&timeslot=" . $dateid; ?>' id="add">
                            <?php _e('Set Time Slot', 'appointment'); ?>
                        </a>
                        <a style="float:right;" href='<?php echo get_permalink() . "?page=createappoitment&service" ?>' id="add">
                            <?php _e('Back to Services', 'appointment'); ?>
                        </a>
                    </th>
                </tr>
            </tbody>
        </table>
    </form>
</div>