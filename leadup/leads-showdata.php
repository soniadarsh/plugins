<?php

function leads_capture_data() { // Create the page
    $leadsdata_url = admin_url('admin.php?page=leadsdata', 'http');
    ?>
    <div id="contain">
        <div id="themesheader">
            <div class="lead_head">
                <h1><?php _e('Leads Xplode', 'leadcapture'); ?></h1>
                <p><?php _e('Below are the messages received from your Visitors including their contacts details.', 'leadcapture'); ?></p>
            </div>
            <br />      
        </div>	
        <?php
        global $wpdb, $leads_dynamicform;
        if (isset($_POST['chk_all_submit'])) {
            if (!empty($_POST['check_info_list'])) {
                foreach ($_POST['check_info_list'] as $checked) {
                    $wpdb->query($wpdb->prepare("DELETE FROM $leads_dynamicform WHERE id = %d", $checked));
                }
            }
        }
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $wpdb->query($wpdb->prepare("DELETE FROM $leads_dynamicform WHERE id = %d", $id));
        }
        $return_data = paginationdisplay();
        $nr = $return_data['column_number'];
        $sql2 = $return_data['perpage_limit'];
        $sql = $return_data['show_data'];
        $paginationDisplay = $return_data['pegination_display'];
        ?>
    </div>
    <?php if ($_GET['page'] == 'leadsdata') { ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <SCRIPT language="javascript">
            $(function () {
                // add multiple select / deselect functionality
                $("#selectall_chkinfo").click(function () {
                    $('.chk_info').attr('checked', this.checked);
                });
                // if all checkbox are selected, check the selectall checkbox
                // and viceversa
                $(".chk_info").click(function () {
                    if ($(".chk_info").length == $(".chk_info:checked").length) {
                        $("#selectall_chkinfo").attr("checked", "checked");
                    } else {
                        $("#selectall_chkinfo").removeAttr("checked");
                    }

                });
            });
        </SCRIPT>
    <?php } ?>
    <div class="main-table">
        <form action='' method='post'>
            <table class="wp-list-table widefat fixed pages">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectall_chkinfo"/></th>
                        <?php
                        global $leads_dynamic_index, $wpdb;
                        $sqlfeatch = $wpdb->get_results("SELECT * FROM $leads_dynamic_index", ARRAY_A);
//echo $form_count = mysql_num_rows($sqlfeatch);
                        foreach ($sqlfeatch as $row) {
                            $csv1[] = $row["lead_name"];
                            ?>
                            <th  scope="col"><?php echo $row["lead_name"]; ?> </th>
                        <?php } ?> 
                        <th  scope="col">Date</th>
                        <th  scope="col">Action</th>
                    </tr>	
                </thead>
                <?php
//data fetch for dashboard 
                if ($nr >= 1) {
                    foreach ($sql2 as $row) {
                        $id = $row["id"];
                        $name = $row["name"];
                        $leadform1 = $row["leadform1"];
                        $leadform2 = $row["leadform2"];
                        $leadform3 = $row["leadform3"];
                        $leadform4 = $row["leadform4"];
                        $leadform5 = $row["leadform5"];
                        $leadform6 = $row["leadform6"];
                        $leadform7 = $row["leadform7"];
                        $leadform8 = $row["leadform8"];
                        $leadform9 = $row["leadform9"];
                        $date = $row["date"];
                        ?>  
                        <tbody id="trans_list">
                            <tr class="data">   
                                <th  scope="col"><input type="checkbox" class="chk_info" name="check_info_list[]" value="<?php echo $id; ?>"/></th>
                                <th  scope="col"><?php echo $name; ?></th>					
                                <th  scope="col"><?php echo $leadform1; ?></th>			
                                <th  scope="col"><?php echo $leadform2; ?></th>				
                                <th  scope="col"><?php echo $leadform3; ?></th>				
                                <th  scope="col"><?php echo $leadform4; ?></th>				
                                <th  scope="col"><?php echo $leadform5; ?></th>				
                                <th  scope="col"><?php echo $leadform6; ?></th>					
                                <th  scope="col"><?php echo $leadform7; ?></th>				
                                <th  scope="col"><?php echo $leadform8; ?></th>			
                                <th  scope="col"><?php echo $leadform9; ?></th>		
                                <th  scope="col"><?php echo $date ?></th>
                                <th  scope="col"><a href="<?php echo $leadsdata_url . "&pn=&delete=" . $id; ?>"><img src="<?php echo IMG_PLUGIN_URL . 'ico-close.png'; ?>" alt="Delete" height="16" width="16" /></a></th>
                            </tr>
                        <tbody id="trans_list">
                            <?php
                        }
                    }
                    $x = export_leads();
                    ?>
            </table>
            <input type='submit' id='chk_all_submit' name='chk_all_submit'  value='<?php _e('Delete Checked', 'leadcapture'); ?>'/>
            <div class="page-bottom">	<strong><?php echo $nr; ?>&nbsp Items</strong>&nbsp &nbsp <?php echo $paginationDisplay; ?> </div> 
            <table class="wp-list-table widefat fixed pages" style="width:180px;">
                <thead>
                    <tr> 
                        <th scope="col" style="text-align:center;">
                            <?php _e('Download CSV File', 'leadcapture'); ?>
                        </th>		 
                    </tr>
                </thead>
                <tbody id="trans_list">
                    <tr>	 
                        <th scope="col" style="text-align:center;"> 
                            <a id="csvfile" href="<?php echo $x; ?>">
                                <img src="<?php echo CSS_PLUGIN_URL; ?>export.png" alt="<?php _e('Download CSV File', 'leadcapture'); ?>" height="32" width="32" />
                            </a>
                        </th>
                    </tr>
                </tbody>
            </table> 
    </div>
    <?php
}
