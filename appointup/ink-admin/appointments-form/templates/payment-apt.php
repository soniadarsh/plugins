<style> .showdata{display:none;} </style>
<h3><a href='<?php echo get_permalink() . "?page=createappoitment&service" ?>'><?php _e('Create New Service', 'appointment'); ?></a></h3>
<form action="<?php echo $apturl . '&service=service'; ?>" method="post" >
    <table id="apt_data_show" class="wp-list-table widefat fixed pages" >
        <thead >
            <tr>
                <th  scope="col"><label><?php _e('Service Taken', 'appointment'); ?></label> </th>
                <th  scope="col"><?php _e('Payer Paypal Email', 'appointment'); ?></th>
                <th  scope="col"><label><?php _e('Amount Paid', 'appointment'); ?></label></th>
                <th  scope="col"><?php _e('Transaction Date', 'appointment'); ?></th>
                <th  scope="col"><?php _e('Transaction ID', 'appointment'); ?></th>
                <th  scope="col"><?php _e('Status', 'appointment'); ?></th>
            </tr>
        </thead>
        <?php
        $sqldata = $db->db->prepare("SELECT * FROM $apt_transaction WHERE TXN_ID='$aptid'");
        $queries = $db->db->get_results($sqldata);
        ?>
        <tbody>
            <?php foreach ($queries as $query) { ?>
                <tr>
                    <th  scope="col"> <label><?php echo $query->apt_txn_service_name; ?></label> </th>
                    <th  scope="col"><?php echo $query->apt_txn_payer_email; ?></th>
                    <th  scope="col"> <label><?php echo $query->apt_txn_price; ?></label></th>
                    <th  scope="col"><?php echo $query->apt_txn_booking_date; ?></th>
                    <th  scope="col"><?php echo $query->apt_txn_txnid; ?></th>
                    <th  scope="col"><?php echo $query->apt_txn_status; ?></th>
                </tr>
                <tr><td colspan=6> <a href="<?php echo get_permalink() . "?page=bookedappointment"; ?>"><?php _e('Back to All Booked Appointments', 'appointment'); ?></a></td></tr>
            <?php } ?>
        </tbody>
    </table>
</form>