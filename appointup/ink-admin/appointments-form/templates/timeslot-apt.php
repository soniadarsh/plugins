<style> 
    .aptservice {
        display: none;
    } 
</style>
<div class="time-slot-wrap">
    <h1 class="timeslot-head"></h1>

    <div class="tabel-scroll">
        <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
            <h3><?php _e('Bulk Add Timing', 'appointment'); ?></h3>
            <table id="ap_service" class="wp-list-table widefat fixed pages">
                <thead>
                    <tr>
                        <th class="sttime" scope="col" colspan=2><?php _e('Start Time', 'appointment'); ?><a id="tool-start" href="#" title="<?php _e('Time from which your service will be available.', 'appointment'); ?>"></a>
                        </th>
                        <th class="entime" scope="col" colspan=2><?php _e('End Time', 'appointment'); ?>
                            <a id="tool-end" href="#" title="<?php _e('The end time till your service is available.', 'appointment'); ?>"></a>
                        </th>
                        <th class="actime" scope="col" colspan=4><?php _e('Appointment Count', 'appointment'); ?>
                            <a id="tool-appointment" href="#" title="<?php _e('Number of Appointments you want to book at a particular time slot.', 'appointment'); ?>"></a>
                        </th>
                        <th class="titime" scope="col" colspan=2><?php _e('Time Interval', 'appointment'); ?>
                            <a id="tool-interval" href="#" title="<?php _e('Interval between time slots. Numeric Value in minutes. Example: 30, 45, 60', 'appointment'); ?>"></a>
                        </th>
                    </tr>
                    <tr>
                        <th colspan=2 scope="col">
                            <input type="text" name="opentime" id="opentime" value="10:00" maxlength="5"/>
                            <select id="selectopen" name="selectopen">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th colspan=2 scope="col">
                            <input type="text" name="closetime" id="closetime" value="12:00" maxlength="5"/>
                            <select id="selectclose" name="selectclose">
                                <option value='PM'>PM</option>
                                <option value='AM'>AM</option>
                            </select>
                        </th>
                        <th colspan=3 scope="col">
                            <input type="text" name="booktime" id="booktime" maxlength="3"/></th>
                        <th colspan=2 scope="col">
                            <input type="text" name="inttime" id="inttime" maxlength="3"/>&nbsp <span class="apt-min">minutes</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="col"><?php _e('Monday', 'appointment'); ?></th>
                        <th scope="col"><?php _e('Tuesday', 'appointment'); ?></th>
                        <th scope="col"><?php _e('Wednesday', 'appointment'); ?></th>
                        <th scope="col"><?php _e('Thursday', 'appointment'); ?></th>
                        <th scope="col"><?php _e('Friday', 'appointment'); ?></th>
                        <th scope="col"><?php _e('Saturday', 'appointment'); ?></th>
                        <th colspan=3 scope="col"><?php _e('Sunday', 'appointment'); ?></th>
                    </tr>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="chk_mon" name="chk_mon" value="monday">
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="chk_tue" name="chk_tue" value="tuesday">
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="chk_wed" name="chk_wed" value="wednesday">
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="chk_thu" name="chk_thu" value="thursday">
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="chk_fri" name="chk_fri" value="friday">
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="chk_sat" name="chk_sat" value="saturday">
                        </th>
                        <th scope="col">
                            <input type="checkbox" id="chk_sun" name="chk_sun" value="sunday">
                        </th>
                        <th scope="col" colspan=2>
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="submit" name="alldateadd" id="alldateadd" value="<?php _e('Add Bulk Timing', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </tbody>
            </table>
        </form>
        <h3 class="timeslot-head"><?php _e('All Available Timing', 'appointment'); ?></h3>

        <div class="avitime">
            <table id="ap_service" class="wp-list-table widefat fixed pages">
                <thead>
                    <tr>
                        <th scope="col" class="ap_srname"><?php _e('Day', 'appointment'); ?></th>
                        <th scope="col"> <?php _e('Opening Time', 'appointment'); ?></th>
                        <th scope="col"> <?php _e('Closing Time', 'appointment'); ?></th>
                        <th scope="col"><?php _e('Appointment Count', 'appointment'); ?></th>
                        <th scope="col"> <?php _e('Action', 'appointment'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <!---------Start Monday Condition -------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                        <th scope="col" class="ap_srname">
                            <input type="hidden" name="tsmon" id="tsmon" value="monday"/><?php _e('Monday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strmon" id="strmon" value="10:00" maxlength="5"/>
                            <select id="strselectmon" name="strselectmon">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select></th>
                        <th scope="col">
                            <input type="text" name="endmon" id="endmon" value="10:30" maxlength="5"/>
                            <select id="endselectmon" name="endselectmon">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="bookmon" id="bookmon" class="booktext"/>
                        </th>
                        <th scope="col" class="addbutton">
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddmon" id="hiddmon" value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addmon" id="addmon" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                // ----Monday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $tstimeid AND timeslot_day ='monday' ORDER BY timeslot_id ASC";
                        $nr = $wpdb->query($query);
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/></th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value=" <?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/>
                                    </th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" title="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!--------- End Monday condition
                                        start Tuesday Condition -------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                    <tr>
                        <th scope="col" class="ap_srname">
                            <input type="hidden" name="tstus" id="tstus" value="tuesday"/>
                            <?php _e('Tuesday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strtus" id="strtus" value='10:00' maxlength="5"/>
                            <select id="strselecttus" name="strselecttus">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="endtus" id="endtus" value='10:30' maxlength="5"/>
                            <select id="endselecttus" name="endselecttus">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="booktue" id="booktue" class="booktext"/>
                        </th>
                        <th scope="col">
                            <input type="hidden" name="tsrand" id="tsrand"
                                   value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddtus" id="hiddtus"
                                   value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addtus" id="addtus" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                // ----Tuesday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $tstimeid AND timeslot_day ='tuesday' ORDER BY timeslot_id ASC";
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        $nr = $wpdb->query($query);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value=" <?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/>
                                    </th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!--------- End Tuesday condition
                                        start Wednesday Condition -------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                        <th scope="col" class="ap_srname"><input type="hidden" name="tswed" id="tswed" value="wednesday"/><?php _e('Wednesday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strwed" id="strwed" value="10:00" maxlength="5"/>
                            <select id="strselectwed" name="strselectwed">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="endwed" id="endwed" value="10:30" maxlength="5"/>
                            <select id="endselectwed" name="endselectwed">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="bookwed" id="bookwed" class="booktext"/>
                        </th>
                        <th scope="col">
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddwed" id="hiddwed" value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addwed" id="addwed" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                // ----Wednesday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $tstimeid AND timeslot_day ='wednesday' ORDER BY timeslot_id ASC";
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        $nr = $wpdb->query($query);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value=" <?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/></th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!--------- End Wednesday condition
                                        start Thursday Condition -------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                        <th scope="col" class="ap_srname">
                            <input type="hidden" name="tsthu" id="tsthu" value="thursday"/><?php _e('Thursday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strthu" id="strthu" value="10:00" maxlength="5"/>
                            <select id="strselectthu" name="strselectthu">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="endthu" id="endthu" value="10:30" maxlength="5"/>
                            <select id="endselectthu" name="endselectthu">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select></th>
                        <th scope="col">
                            <input type="text" name="bookthu" id="bookthu" class="booktext"/>
                        </th>
                        <th scope="col">
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddthu" id="hiddthu" value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addthu" id="addthu" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                // ----Thursday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $tstimeid AND timeslot_day ='thursday' ORDER BY timeslot_id ASC";
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        $nr = $wpdb->query($query);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/></th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value=" <?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/>
                                    </th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!--------- End Thursday condition
                                        start Friday Condition -------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                        <th scope="col" class="ap_srname">
                            <input type="hidden" name="tsfri" id="tsfri" value="friday"/>
                            <?php _e('Friday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strfri" id="strfri" value="10:00" maxlength="5"/>
                            <select id="strselectfri" name="strselectfri">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="endfri" id="endfri" value="10:30" maxlength="5"/>
                            <select id="endselectfri" name="endselectfri">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="bookfri" id="bookfri" class="booktext"/>
                        </th>
                        <th scope="col">
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddfri" id="hiddfri" value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addfri" id="addfri" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                // ----Friday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $tstimeid AND timeslot_day ='friday' ORDER BY timeslot_id ASC";
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        $nr = $wpdb->query($query);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value=" <?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/>
                                    </th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!--------- End Friday condition
                                        start Saturday Condition -------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                        <th scope="col" class="ap_srname">
                            <input type="hidden" name="tssat" id="tssat" value="saturday"/>
                            <?php _e('Saturday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strsat" id="strsat" value="10:00" maxlength="5"/>
                            <select id="strselectsat" name="strselectsat">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="endsat" id="endsat" value="10:30" maxlength="5"/>
                            <select id="endselectsat" name="endselectsat">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="booksat" id="booksat" class="booktext"/>
                        </th>
                        <th scope="col">
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddsat" id="hiddsat" value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addsat" id="addsat" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                // ----saturday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $tstimeid AND timeslot_day ='saturday' ORDER BY timeslot_id ASC";
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        $nr = $wpdb->query($query);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value=" <?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/>
                                    </th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!--*** End Saturday Condition 
                                               Start sunday condition **----------->
                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                    <tr>
                        <th scope="col"><input type="hidden" name="tssun" id="tssun" value="sunday"/>
                            <?php _e('Sunday', 'appointment'); ?>
                        </th>
                        <th scope="col">
                            <input type="text" name="strsun" id="strsun" value="10:00" maxlength="5"/>
                            <select id="strselect" name="strselect">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="endsun" id="endsun" value="10:30" maxlength="5"/>
                            <select id="endselect" name="endselect">
                                <option value='AM'>AM</option>
                                <option value='PM'>PM</option>
                            </select>
                        </th>
                        <th scope="col">
                            <input type="text" name="booksun" id="booksun" class="booktext"/>
                        </th>
                        <th scope="col">
                            <input type="hidden" name="tsrand" id="tsrand" value="<?php echo rand(); ?>"/>
                            <input type="hidden" name="hiddsun" id="hiddsun" value="<?php echo $timeid; ?>"/>
                            <input type="submit" name="addsun" id="addsun" value="<?php _e('Add', 'appointment'); ?>"/>
                        </th>
                    </tr>
                </form>
                <?php
                //---sunday show data----->>
                $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                $tstimeid = (!empty($tsvalue)) ? $tsvalue->service_id : null;
                if ((!empty($tstimeid)) && (!empty($timeid))) {
                    $tsvalue = $wpdb->get_row("SELECT * FROM $apt_timeslot WHERE  service_id = $timeid");
                    $tstslotid = $tsvalue->service_id;
                    if ($tstslotid == $timeid) {
                        $query = "SELECT * FROM $apt_timeslot WHERE service_id = $timeid AND timeslot_day ='sunday' ORDER BY timeslot_id ASC";
                        $showts = $wpdb->get_results($query, ARRAY_A);
                        $nr = $wpdb->query($query);
                        foreach ($showts as $timerow) {
                            ?>
                            <tr>
                                <th scope="col" class="time_sunday"></th>
                                <?php if ((isset($_GET['edit-timeslot'])) && $_GET['edit-timeslot'] == $timerow['timeslot_id']) { ?>
                                <form action="<?php echo $apturl . '&timeslot=' . $timeid; ?>" method="post">
                                    <th scope="col">
                                        <input type="text" name="smon" id="smon" value="<?php echo $timerow['timeslot_start_time']; ?>" maxlength="8"/>
                                    </th>
                                    <th scope="col">
                                        <input type="text" name="emon" id="emon" value="<?php echo $timerow['timeslot_end_time']; ?>" maxlength="8"/></th>
                                    <th scope="col">
                                        <input type="text" name="editbooks" id="editbooks" class="booktext" value="<?php echo $timerow['booking_number_time']; ?>"/>
                                    </th>
                                    <th scope="col">
                                        <input type="hidden" name="edit-timeid" id="edit-timeid" value="<?php echo $_GET['edit-timeslot']; ?>"/>
                                        <input type="submit" name="update-timeslot" id="update-service" value="" title="<?php _e('Update Time Slot', 'appointment'); ?>"/></th>
                                </form>
                            <?php } else { ?>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_start_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['timeslot_end_time']; ?></th>
                                <th  scope="col" class="time_sunday"><?php echo $timerow['booking_number_time']; ?></th>
                                <th scope="col" class="sundelete">
                                    <a id="edit" href="<?php echo $apturl . '&timeslot=' . $timeid . '&edit-timeslot=' . $timerow['timeslot_id']; ?>">
                                        <img src="<?php echo $root; ?>/images/icon-edit.png" alt="<?php _e('Edit', 'appointment'); ?>" title="<?php _e('Edit', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                    <a href="<?php echo $apturl . '&timeslot=' . $timeid . '&delete-timeslot=' . $timerow['timeslot_id']; ?>" >
                                        <img src="<?php echo $root; ?>/images/ico-close.png" alt="<?php _e('Delete', 'appointment'); ?>" height="16" width="16" />
                                    </a>
                                </th>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <!----------------- ***End sunday condition****  ------->
                <tr>
                    <th colspan=4 scope="col">
                        <a style="float:left;" href='<?php echo get_permalink() . "?page=createappoitment&service" ?>' id="add"><?php _e('Back to Services', 'appointment'); ?></a>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>