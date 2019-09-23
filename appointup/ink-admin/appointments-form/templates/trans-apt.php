<div class="showdata">
    <h3><?php _e('Payment Transaction Details', 'appointment'); ?></h3>
    <form action="<?php echo admin_url('admin.php?page=createappoitment&service=service'); ?>" method="post" >
        <table id="apt_data_show" class="wp-list-table widefat fixed pages" >
            <thead >
                <tr>
                    <th  scope="col"> <label><?php _e('Service Taken', 'appointment'); ?></label> </th>
                    <th  scope="col"><?php _e('Payer Paypal Email', 'appointment'); ?></th>
                    <th  scope="col"> <label><?php _e('Amount Paid', 'appointment'); ?></label></th>
                    <th  scope="col"><?php _e('Transaction Date', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Transaction ID', 'appointment'); ?></th>
                    <th  scope="col"><?php _e('Status', 'appointment'); ?></th>
                </tr>
            </thead>
            <?php
            $queries = $wpdb->get_results($sqldata);
            ?>
            <tbody>
                <?php
                if (!empty($queries)) {
                    foreach ($queries as $query) {
                        ?>
                        <tr>
                            <th  scope="col"> <label><?php echo $query->apt_txn_service_name; ?></label> </th>
                            <th  scope="col"><?php echo $query->apt_txn_payer_email; ?></th>
                            <th  scope="col"> <label><?php echo $query->apt_txn_price; ?></label></th>
                            <th  scope="col"><?php echo $query->apt_txn_booking_date; ?></th>
                            <th  scope="col"><?php echo $query->apt_txn_txnid; ?></th>
                            <th  scope="col"><?php echo $query->apt_txn_status; ?></th>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <th  colspan='6' scope="col"><?php _e('Not Found Data', 'appointment'); ?></th> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
    <div class="apt-pegi">
        <strong><?php echo $nr; ?>&nbsp Items</strong>&nbsp &nbsp <?php echo $paginationDisplay; ?> 
    </div>
</div>