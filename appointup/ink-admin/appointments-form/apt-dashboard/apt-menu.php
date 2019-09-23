<?php

class Ink_AptMenu extends Ink_Appointment {

    static function Init() {
        $obj = new Ink_AptMenu();
        /**
         * Add admin menu page to the menu
         */
        add_action('admin_menu', array($obj, 'appointment_services'));
    }

    /**
     * Add scripts and stylesheet
     */
    function ink_apt_styles() {
        wp_enqueue_style('apt-style', $this->dir_url . 'ink-admin/css/apt-dashboard-style.css');
        wp_enqueue_style('apt-admin-css', $this->dir_url . "ink-admin/js/cal/jquery.calendars.picker.css", '', '', 'all');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('apt-tip-skyblue', $this->dir_url . "ink-admin/appointments-form/apt-dashboard/apt-toolltip/tip-twitter/tip-twitter.css", '', '', 'all');
    }

    function ink_apt_js() {
        wp_enqueue_script('jquery-calendar-admin', $this->dir_url . 'ink-admin/js/cal/jquery.calendars.js', array('jquery'));
        wp_enqueue_script('jquery-ui-plus-admin', $this->dir_url . 'ink-admin/js/cal/jquery.calendars.plus.js', array('jquery'));
        wp_enqueue_script('jquery-ui-cal-admin', $this->dir_url . 'ink-admin/js/cal/jquery.calendars.picker.js', array('jquery'));
        wp_enqueue_script('jquery-poshytip-admin', $this->dir_url . 'ink-admin/appointments-form/apt-dashboard/apt-toolltip/jquery.poshytip.js', array('jquery'));
    }

    function appointment_services() {
        $hook = array();
        $hook[] = add_menu_page(__('Appointments', 'appointment'), __('Appointments', 'appointment'), 'manage_options', 'aptservice', array($this, 'showdata'), $this->dir_url . 'ink-admin/images/menuicon.png', 58);
        $hook[] = add_submenu_page('aptservice', __('Create Appointments', 'appointment'), __('Create Appointments', 'appointment'), 'manage_options', 'createappoitment', array($this, 'create_appointment'));
        $hook[] = add_submenu_page('aptservice', __('Manual Appointments', 'appointment'), __('Manual Appointments', 'appointment'), 'manage_options', 'manualappointment', array($this, 'manual_appointment'));
        $hook[] = add_submenu_page('aptservice', __('Booked Appointments', 'appointment'), __('Appointments', 'appointment'), 'manage_options', 'bookedappointment', array($this, 'showdata'));
        $hook[] = add_submenu_page('aptservice', __('Appointment Calendar', 'appointment'), __('Appointment Calendar', 'appointment'), 'manage_options', 'viewcalendar', array($this, 'view_appointment_calendar'));
        $hook[] = add_submenu_page('aptservice', __('Payment Details', 'appointment'), __('Payment Details', 'appointment'), 'manage_options', 'trans', array($this, 'apt_trans'));
        $hook[] = add_submenu_page('aptservice', __('Custom Fields', 'appointment'), __('Custom Fields', 'appointment'), 'manage_options', 'customfield', array($this, 'appointment_custom_field'));     
        $hook[] = add_submenu_page('aptservice', __('Settings', 'appointment'), __('Settings', 'appointment'), 'manage_options', 'paymentsettings', array($this, 'appointment_setting'));
        $hook[] = add_submenu_page('aptservice', '', '', 'manage_options', 'pasttrans', 'past_appointment_detail');
        remove_submenu_page('aptservice', 'aptservice');
        foreach ($hook as $h) {
            add_action("admin_print_scripts-$h", array($this, 'ink_apt_styles'));
            add_action("admin_print_scripts-$h", array($this, 'ink_apt_js'));
            add_action("admin_enqueue_scripts", array($this, 'ink_apt_styles'));
            add_action("admin_enqueue_scripts", array($this, 'ink_apt_js'));
        }
    }

    function showdata() {
        $db = new Apt_DB();
        $table_data_type = '';
        $appointment_data = $db->tbl_appointment_data;
        $todaydate = date("dmY");
        $data_sql = $db->db->get_results("SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $appointment_data . "' AND column_name ='ddmmyyy'", ARRAY_A);
        if (!empty($data_sql) && isset($data_sql[0])) {
            if (array_key_exists('DATA_TYPE', $data_sql[0])) {
                $table_data_type = $data_sql[0]['DATA_TYPE'];
            }
        }
        if ($table_data_type == "int") {
 $db->db->query("ALTER TABLE {$appointment_data} CHANGE ddmmyyy ddmmyyy INT(11) NOT NULL DEFAULT '0'");
           // $db->db->query("ALTER TABLE {$appointment_data} CHANGE ddmmyyy DATE NOT NULL DEFAULT '0000-00-00'");
            $data_to_col = $db->db->get_results("SELECT ddmmyyy FROM {$appointment_data}", ARRAY_A);
            $data_from_col = $db->db->get_results("SELECT APTID, apt_data_date FROM {$appointment_data}", ARRAY_A);
            foreach ($data_from_col as $value) {
                $time_parts = explode('/', $value['apt_data_date']);
                $time_str = $time_parts[2] . "-" . $time_parts[1] . "-" . $time_parts[0];
                $db->db->update($appointment_data, array('ddmmyyy' => $time_str), array('APTID' => $value['APTID']));
            }
        } else {
            $todaydate = date("m/d/Y");
        }
       
        $paginationDisplay = "";
       
        $query = "SELECT * FROM $db->tbl_appointment_data WHERE apt_data_date >= '$todaydate'";
        $aptsql = $db->db->get_results($query, ARRAY_A);
        $nr = $db->db->query($query);
        if ($nr >= 1) {
            if (isset($_GET['pn'])) {
                $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']);
            } else {
                $pn = 1;
            }
            $itemsPerPage = 10;
            $lastPage = ceil($nr / $itemsPerPage);
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
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            } else if ($pn == $lastPage) {
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
            } else if ($pn > 2 && $pn < ($lastPage - 1)) {
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
            } else if ($pn > 1 && $pn < $lastPage) {
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber"  href="' . get_permalink() . '?page=bookedappointment&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            }
            $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
//$sql2 = mysql_query("SELECT * FROM $appointment_data ORDER BY APTID DESC $limit");
            $bookedtodaydate = date("m/d/Y");
            $sqldata = "SELECT * FROM $db->tbl_appointment_data  WHERE apt_data_date >= '$bookedtodaydate' ORDER BY apt_data_date DESC $limit";
            if ($lastPage != "1") {
//$paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
                if ($pn != 1) {
                    $previous = $pn - 1;
                    $paginationDisplay .= '&nbsp;  <a class="inkpegi" href="' . get_permalink() . '?page=bookedappointment&pn=' . $previous . '">«</a> ';
                }
                $paginationDisplay .= '<span  class="paginationNumbers">' . $centerPages . '</span>';
                if ($pn != $lastPage) {
                    $nextPage = $pn + 1;
                    $paginationDisplay .= '&nbsp;  <a class="inkpegi" href="' . get_permalink() . '?page=bookedappointment&pn=' . $nextPage . '">»</a> ';
                }
            }
        }
        /*         * * Csv file Download * */
        $uploads = wp_upload_dir();
        $aptfile = $uploads['basedir'];
        $import_path = $uploads['baseurl'];
        $import_appointment = $import_path . "/appointment_data.csv";
        $aptfilename = $aptfile . "/appointment_data.csv";
        $handle = fopen($aptfilename, 'w+');
        $leads_dynamic_index = $db->tbl_apt_leads_dynamic_index;
        $sqlfeatchcsv = $db->db->get_results("SELECT * FROM $leads_dynamic_index", ARRAY_A);
        fputcsv($handle, array(__('Sr.No.', 'appointment'), __('Service Name', 'appointment'), __('Appointment Date', 'appointment'), __('Appointment Time', 'appointment'), __('Person Name', 'appointment'), __('Email Address', 'appointment'), __('Contact Number', 'appointment'), __('Message', 'appointment'), $sqlfeatchcsv[0]["lead_name"], $sqlfeatchcsv[1]["lead_name"], $sqlfeatchcsv[2]["lead_name"], $sqlfeatchcsv[3]["lead_name"], $sqlfeatchcsv[4]["lead_name"], __('Amount Paid', 'appointment'), __('Payer Paypal Email', 'appointment'), __('Transaction ID', 'appointment'), __('Paid Date', 'appointment')));
        $count = 1;
//data fetch for CSV file   
        $apt_transaction = $db->tbl_transaction;
        $csvsql = $db->db->get_results("SELECT * FROM $db->tbl_appointment_data", ARRAY_A);
        foreach ($csvsql as $row) {
            $aptid = $row['APTID'];
            $service_id = $row['service_id'];
            $apt_ink = $db->db->get_row("SELECT * FROM $apt_transaction WHERE TXN_ID ='$aptid'", ARRAY_N);
            $service_name = $db->db->get_row("SELECT * FROM ". $db->db->prefix."apt_service WHERE service_id=".$service_id, ARRAY_A);            
            $handle = fopen($aptfilename, 'a');
            fputcsv($handle, array($count, $service_name["service_name"], $row["apt_data_date"], $row["apt_data_time"], $row["apt_data_persion_name"], $row["apt_data_email"], $row["apt_data_mobile"], $row["apt_data_message"], $row["fieldlabel1"], $row["fieldlabel2"], $row["fieldlabel3"], $row["fieldlabel4"], $row["fieldlabel5"], $row["apt_data_price"], $apt_ink[6], $apt_ink[7], $row["apt_data_current_date"]));
            fclose($handle);
            $count++;
        }
        if ($_GET['page'] == 'bookedappointment') {
            //wp_enqueue_script('jquery-chk-show', INK_ADMIN . '/js/jquery.min.js', array('jquery'));   
            if (isset($_POST['chkall_sub'])) {
                if (!empty($_POST['check_apt_show'])) {
                    foreach ($_POST['check_apt_show'] as $checked) {
                        $db->db->query($db->db->prepare("DELETE FROM $db->tbl_appointment_data WHERE APTID = %d", $checked));
                        $db->db->query($db->db->prepare("DELETE FROM $apt_transaction WHERE TXN_ID = %d", $checked));
                    }
                }
            }
            ?>
            <script type="text/javascript">
                jQuery(function () {

                    // add multiple select / deselect functionality
                    jQuery("#show_chkapt").click(function () {
                        jQuery('.apt_chk').attr('checked', this.checked);
                    });

                    // if all checkbox are selected, check the selectall checkbox
                    // and viceversa
                    jQuery(".apt_chk").click(function () {

                        if (jQuery(".apt_chk").length == jQuery(".apt_chk:checked").length) {
                            jQuery("#show_chkapt").attr("checked", "checked");

                        } else {
                            jQuery("#show_chkapt").removeAttr("checked");
                        }

                    });
                });
            </script>
            <?php

        }
        include($this->dir . '/ink-admin/appointments-form/templates/booked-apt.php');
        /**
         * Show payments
         */
        if (isset($_GET['payment'])) {
            $recenttodaydate = date("m/d/Y");
            $recentsqldata = "SELECT * FROM $db->tbl_appointment_data WHERE apt_data_date >= '$recenttodaydate' ORDER BY apt_data_date DESC $limit";
            $aptid = $_GET['payment'];
           include($this->dir . '/ink-admin/appointments-form/templates/recent-apt.php');
        }
        /**
         * Show recent appointments
         */
        if (isset($_GET['showtendata'])) {
            $aptid = isset($_GET['payment']) ? $_GET['payment'] : '';
            $recenttodaydate = date("m/d/Y");
            //pegination
            $recent_query = "SELECT * FROM $db->tbl_appointment_data WHERE apt_data_date >= '$recenttodaydate'";
            $recentaptsql = $db->db->get_results($recent_query);
          
            $nr = $recentaptsql;          
  
            $recentsqldata = '';            
            if (sizeof($nr) >= 1) {
                if (isset($_GET['pn'])) {
                    $pn = preg_replace('/#[^0-9]#i/', '', $_GET['pn']);
                    
                } else {
                    $pn = 1;
                }
               
                $itemsPerPage = 10;
                $lastPage = ceil(sizeof($nr)/$itemsPerPage);                 
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
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
                } else if ($pn == $lastPage) {
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                    $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
                } else if ($pn > 2 && $pn < ($lastPage - 1)) {
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                    $centerPages .= '&nbsp; <span class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
                } else if ($pn > 1 && $pn < $lastPage) {
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                    $centerPages .= '&nbsp; <span  class="selectpeginumber" class="pagNumActive">' . $pn . '</span> &nbsp;';
                    $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
                }
                $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;

                //$recentsqldata = "SELECT * FROM $db->tbl_appointment_data  WHERE ddmmyyy >= CAST(CURRENT_TIMESTAMP AS DATE) ORDER BY apt_data_date DESC $limit";
                $paginationDisplay = "";
                if ($lastPage != "1") {

                    if ($pn != 1) {
                        $previous = $pn - 1;
                        $paginationDisplay .= '&nbsp;  <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $previous . '">«</a> ';
                    }
                    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
                    if ($pn != $lastPage) {
                        $nextPage = $pn + 1;
                        $paginationDisplay .= '&nbsp;  <a class="inkpeginumber" href="' . get_permalink() . '?page=bookedappointment&showtendata&pn=' . $nextPage . '">»</a> ';
                    }
                }
            }
            include($this->dir . '/ink-admin/appointments-form/templates/recent-apt.php');
        }
    }

    function view_appointment_calendar() {
        include($this->dir . '/ink-admin/appointments-form/templates/calendar-lib/calendar-apt.php');
    }

    function manual_appointment() {
        include($this->dir . '/ink-admin/manual-apt.php');
    }

    function appointment_custom_field() {
        include($this->dir . '/ink-admin/appointments-form/templates/apt-leads-customform.php');
    }   

    function create_appointment() {
        $db = new Apt_DB();
        $root = $this->dir_url . 'ink-admin/';
        $apturl = admin_url('admin.php?page=createappoitment');
        global $wpdb;
        $apt_service = $db->tbl_service;
        $apt_timeslot = $db->tbl_timeslot;
        $apt_dateslot = $db->tbl_dateslot;
        /**
         * Deletion
         */
        /* --------Apt Service delete row ------------ */
        if (isset($_GET['delete-service'])) {
            $id = $_GET['delete-service'];
            $wpdb->query($wpdb->prepare("DELETE FROM $apt_service WHERE service_id = %d", $id));
            $wpdb->query($wpdb->prepare("DELETE FROM $apt_dateslot WHERE service_id = %d", $id));
// $time_count = $wpdb->get_var( "SELECT COUNT(service_id) FROM $apt_timeslot WHERE service_id='$id'" );
            $wpdb->query($wpdb->prepare("DELETE FROM $apt_timeslot WHERE service_id = %d", $id));
        }
        /**
         *  time slot delete
         */
        if (isset($_GET['delete-timeslot'])) {
            $id = $_GET['delete-timeslot'];
            $wpdb->query($wpdb->prepare("DELETE FROM $apt_timeslot WHERE timeslot_id = %d", $id));
        }
        /**
         * date slot delete
         */
        if (isset($_GET['reset-dateslot'])) {
            $id = $_GET['reset-dateslot'];
            $wpdb->query($wpdb->prepare("DELETE FROM $apt_dateslot WHERE service_id = %d", $id));
        }
        /**
         * update area
         */
        /* --------Apt Service update row ------------ */
        if (isset($_POST['update-service'])) {
            $wpdb->update($apt_service, array('service_name' => $_POST['upname'], 'service_price' => $_POST['upprice'], 'service_paid' => $_POST['uptype']), array('service_id' => $_POST['srid']), array('%s', '%s'), array('%d'));
        }
        if ($_GET['page'] == 'createappoitment') {
            if (isset($_POST['sradd'])) {
                $as = new AptService();
                $as->insert_service($_POST['srname'], $_POST['srprice'], $_POST['srpaid'], $_POST['srrand']);
            }
            include($this->dir . '/ink-admin/appointments-form/templates/service-apt.php');
        }
        /**
         * Time Slot condition
         */
        if (isset($_GET['timeslot'])) {
            $as = new AptService();
            $timeid = $_GET['timeslot'];
            /**
             * Update timeslot
             */
            if (isset($_POST['update-timeslot'])) {
                $wpdb->update($apt_timeslot, array('timeslot_start_time' => $_POST['smon'], 'timeslot_end_time' => $_POST['emon'], 'booking_number_time' => $_POST['editbooks']), array('timeslot_id' => $_POST['edit-timeid']), array('%s', '%s', '%d'), array('%d'));
            }
            /**
             * all timeslot ontime add
             */
            if (isset($_POST['alldateadd'])) {
                $int_time = $_POST['inttime'];
                $chk_mon = isset($_POST['chk_mon']) ? $_POST['chk_mon'] : '';
                $chk_tue = isset($_POST['chk_tue']) ? $_POST['chk_tue'] : '';
                $chk_wed = isset($_POST['chk_wed']) ? $_POST['chk_wed'] : '';
                $chk_thu = isset($_POST['chk_thu']) ? $_POST['chk_thu'] : '';
                $chk_fri = isset($_POST['chk_fri']) ? $_POST['chk_fri'] : '';
                $chk_sat = isset($_POST['chk_sat']) ? $_POST['chk_sat'] : '';
                $chk_sun = isset($_POST['chk_sun']) ? $_POST['chk_sun'] : '';
                if (!empty($int_time)) {
                    $open_am_time = $_POST['opentime'] . '' . $_POST['selectopen'];
                    $close_am_time = $_POST['closetime'] . '' . $_POST['selectclose'];
                    $tsrand = $_POST['tsrand'];
                    $arr_day = array($chk_mon, $chk_tue, $chk_wed, $chk_thu, $chk_fri, $chk_sat, $chk_sun);
                    $as->all_day_time_set($timeid, $open_am_time, $close_am_time, $int_time, $arr_day, $tsrand, $_POST['booktime']);
                }
            }
            $aptser = $wpdb->get_row("SELECT * FROM $apt_service WHERE service_id= '$timeid'", ARRAY_N);
            /**
             * submit for sunday
             */
            if (!empty($timeid)) {
                if (isset($_POST['addsun'])) {
                    $as = new AptService();
                    $start_sun = $_POST['strsun'] . ' ' . $_POST['strselect'];
                    $end_sun = $_POST['endsun'] . ' ' . $_POST['endselect'];
                    $as->insert_timeslot($_POST['hiddsun'], $start_sun, $end_sun, $_POST['tssun'], $_POST['tsrand'], $_POST['booksun']);
                }
                /**
                 * submit for monday
                 */
                if (isset($_POST['addmon'])) {
                    $as = new AptService();
                    $start_mon = $_POST['strmon'] . ' ' . $_POST['strselectmon'];
                    $end_mon = $_POST['endmon'] . ' ' . $_POST['endselectmon'];
                    $as->insert_timeslot($_POST['hiddmon'], $start_mon, $end_mon, $_POST['tsmon'], $_POST['tsrand'], $_POST['bookmon']);
                }
                /**
                 * submit for Tuesday
                 */
                if (isset($_POST['addtus'])) {
                    $as = new AptService();
                    $start_tus = $_POST['strtus'] . ' ' . $_POST['strselecttus'];
                    $end_tus = $_POST['endtus'] . ' ' . $_POST['endselecttus'];
                    $as->insert_timeslot($_POST['hiddtus'], $start_tus, $end_tus, $_POST['tstus'], $_POST['tsrand'], $_POST['booktue']);
                }
                /**
                 * submit for Wednesday
                 */
                if (isset($_POST['addwed'])) {
                    $as = new AptService();
                    $start_wed = $_POST['strwed'] . ' ' . $_POST['strselectwed'];
                    $end_wed = $_POST['endwed'] . ' ' . $_POST['endselectwed'];
                    $as->insert_timeslot($_POST['hiddwed'], $start_wed, $end_wed, $_POST['tswed'], $_POST['tsrand'], $_POST['bookwed']);
                }
                /**
                 * submit for Thursday
                 */
                if (isset($_POST['addthu'])) {
                    $as = new AptService();
                    $start_thu = $_POST['strthu'] . ' ' . $_POST['strselectthu'];
                    $end_thu = $_POST['endthu'] . ' ' . $_POST['endselectthu'];
                    $as->insert_timeslot($_POST['hiddthu'], $start_thu, $end_thu, $_POST['tsthu'], $_POST['tsrand'], $_POST['bookthu']);
                }
                /**
                 * submit for Friday
                 */
                if (isset($_POST['addfri'])) {
                    $as = new AptService();
                    $start_fri = $_POST['strfri'] . ' ' . $_POST['strselectfri'];
                    $end_fri = $_POST['endfri'] . ' ' . $_POST['endselectfri'];
                    $as->insert_timeslot($_POST['hiddfri'], $start_fri, $end_fri, $_POST['tsfri'], $_POST['tsrand'], $_POST['bookfri']);
                }
                /**
                 * submit for Saturday
                 */
                if (isset($_POST['addsat'])) {
                    $as = new AptService();
                    $start_sat = $_POST['strsat'] . ' ' . $_POST['strselectsat'];
                    $end_sat = $_POST['endsat'] . ' ' . $_POST['endselectsat'];
                    $as->insert_timeslot($_POST['hiddsat'], $start_sat, $end_sat, $_POST['tssat'], $_POST['tsrand'], $_POST['booksat']);
                }
                include($this->dir . '/ink-admin/appointments-form/templates/timeslot-apt.php');
            } // epmty if check 
            else {
                _e("You do not have sufficient permissions to access this page.", 'appointment');
            }
        } // second table end
        if (isset($_GET['dateslot'])) {
            $dateid = $_GET['dateslot'];
            if (isset($_POST['chkupdate'])) {
                $as = new AptService();
                $chkboxsun = isset($_POST['chkboxsun']) ? $_POST['chkboxsun'] : '';
                $chkboxmon = isset($_POST['chkboxmon']) ? $_POST['chkboxmon'] : '';
                $chkboxtue = isset($_POST['chkboxtue']) ? $_POST['chkboxtue'] : '';
                $chkboxwed = isset($_POST['chkboxwed']) ? $_POST['chkboxwed'] : '';
                $chkboxthu = isset($_POST['chkboxthu']) ? $_POST['chkboxthu'] : '';
                $chkboxfri = isset($_POST['chkboxfri']) ? $_POST['chkboxfri'] : '';
                $chkboxsat = isset($_POST['chkboxsat']) ? $_POST['chkboxsat'] : '';
                $strdate = $_POST['aptstartdate'];
                $snewdate = $as->date_change_format($strdate);
                $enddate = $_POST['aptenddate'];
                $endnewdate = $as->date_change_format($enddate);
                $as->insert_dateslot($dateid, $snewdate, $endnewdate, $chkboxsun, $chkboxmon, $chkboxtue, $chkboxwed, $chkboxthu, $chkboxfri, $chkboxsat, $_POST['tsrand']);
                echo "<h2 id='dateupdate' style='color:green; margin-top:8px; margin-left:350px;'>" . __('Date Slot Updated.', 'appointment') . "</h2>";
                ?>
                <?php

            }
            $showvalue = $wpdb->get_row("SELECT * FROM $apt_service WHERE service_id = $dateid", ARRAY_N);
            include($this->dir . '/ink-admin/appointments-form/templates/dateslot-apt.php');
        }
        include($this->dir . '/ink-admin/appointments-form/templates/js-apt.php');
    }

    function apt_trans() {
        $db = new Apt_DB();
        global $wpdb;
        $apt_transaction = $db->tbl_transaction;
        //pegination
        $query = "SELECT * FROM $apt_transaction";
        $transaptsql = $wpdb->get_results($query, ARRAY_A);
        $nr = $wpdb->query($query);
        $paginationDisplay = "";
        $sqldata = "";
        if ($nr >= 1) {
            if (isset($_GET['pn'])) {
                $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']);
            } else {
                $pn = 1;
            }
            $itemsPerPage = 15;
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
                $centerPages .= '&nbsp; <span class="pagNumActive selectpeginumber">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            } else if ($pn == $lastPage) {
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive selectpeginumber">' . $pn . '</span> &nbsp;';
            } else if ($pn > 2 && $pn < ($lastPage - 1)) {
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive selectpeginumber">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
            } else if ($pn > 1 && $pn < $lastPage) {
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive selectpeginumber">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            }
            $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
//$sql2 = mysql_query("SELECT * FROM $appointment_data ORDER BY APTID DESC $limit");
            $sqldata = "SELECT * FROM $apt_transaction ORDER BY TXNID DESC $limit";

            if ($lastPage != "1") {
//$paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
                if ($pn != 1) {
                    $previous = $pn - 1;
                    $paginationDisplay .= '&nbsp;  <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $previous . '">«</a> ';
                }
                $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
                if ($pn != $lastPage) {
                    $nextPage = $pn + 1;
                    $paginationDisplay .= '&nbsp;  <a class="inkpeginumber" href="' . get_permalink() . '?page=trans&pn=' . $nextPage . '">»</a> ';
                }
            }
        }
        include($this->dir . '/ink-admin/appointments-form/templates/trans-apt.php');
    }

    function appointment_setting() {
        global $wpdb;
        $apt_db = new Apt_DB();
        $apt_currency = $apt_db->tbl_currency;
        $c_queries = $wpdb->get_results("SELECT * FROM $apt_currency");
        if (isset($_POST['reset']) && isset($_POST['of_save']) == 'reset') {
            $options_to_delete = array('apt_currency_code', 'apt_currency_symbol',
                'apt_merchaint_email', 'apt_paypal', 'apt_form_head', 'apt_fix_date', 'apt_btn_txt', 'return_apt_url', 'apt_recaptcha_public', 'apt_recaptcha_private',
                'apt_custom_msg', 'apt_excp_open', 'apt_excp_close', 'apt_disable_days', 'cpt_enable', 'sms_enable', 'apt_reminder_subject', 'apt_reminder_mail',
                'apt_reminder_to_admin', 'apt_reminder_mail_from', 'apt_sms_sid', 'apt_sms_token', 'apt_sms_number', 'apt_sms_own_number', 'apt_reminder_day', 'apt_form_style', 'apt_form_background_color', 'apt_form_background_input_color', 'apt_form_border_input_color', 'apt_form_text_color', 'submit_btn_background_color', 'submit_btn_hover_background_color', 'submit_btn_txt_color', 'submit_btn_shadow_color', 'apt_dformat');
            foreach ($options_to_delete as $option) {
                delete_option($option);
            }
            $apt_db->option_setup();
        }
        if (isset($_POST['submit'])) {
            if (isset($_POST['apt_currency']) && $_POST['apt_currency'] != '') {
                $currency_symbol = $_POST['apt_currency'];
                $c_chk = $wpdb->get_row("SELECT * FROM $apt_currency Where apt_c_code='$currency_symbol'", ARRAY_N);
                update_option('apt_currency_code', $currency_symbol);
                update_option('apt_currency_symbol', $c_chk[3]);
            }

            if (isset($_POST['merchaint_email']) && $_POST['merchaint_email'] != '') {
                $merchaint_email = $_POST['merchaint_email'];
                update_option('apt_merchaint_email', $merchaint_email);
            }

            if (isset($_POST['paypal_ipn']) && $_POST['paypal_ipn'] != '') {
                $paypal_ipn = $_POST['paypal_ipn'];
                update_option('paypal_ipn', $paypal_ipn);
            }
            if (isset($_POST['payment_mode']) && $_POST['payment_mode'] != '') {
                $payment_mode = $_POST['payment_mode'];
                $apt_form_head = $_POST['apt_form_head'];
                $apt_fix_date = $_POST['apt_fix_date'];
                $apt_btn_txt = $_POST['apt_btn_txt'];
                $apt_custom_msg = $_POST['apt_custom_msg'];
                update_option('apt_paypal', $payment_mode);
                update_option('apt_form_head', $apt_form_head);
                update_option('apt_fix_date', $apt_fix_date);
                update_option('apt_btn_txt', $apt_btn_txt);
                update_option('apt_custom_msg', $apt_custom_msg);
            }
            $apt_cpt = $_POST['cpt_on'];
            update_option('cpt_enable', $apt_cpt);            
            $apt_sms = $_POST['sms_on'];
            update_option('sms_enable', $apt_sms);
            if (isset($_POST['apt_recaptcha_public']) && $_POST['apt_recaptcha_private'] != '') {
                $apt_recaptcha_public = $_POST['apt_recaptcha_public'];
                $apt_recaptcha_private = $_POST['apt_recaptcha_private'];
                update_option('apt_recaptcha_public', $apt_recaptcha_public);
                update_option('apt_recaptcha_private', $apt_recaptcha_private);
            }
            if (isset($_POST['apt_excp_open']) && $_POST['apt_excp_open'] != get_option('apt_excp_open')) {
                update_option('apt_excp_open', $_POST['apt_excp_open']);
            }
            if (isset($_POST['apt_excp_close']) && $_POST['apt_excp_close'] != get_option('apt_excp_close')) {
                update_option('apt_excp_close', $_POST['apt_excp_close']);
            }
            if (isset($_POST['apt_disable_days'])) {
                update_option('apt_disable_days', $_POST['apt_disable_days']);
            } else {
                update_option('apt_disable_days', '');
            }
            if (isset($_POST['apt_reminder_mail']) && $_POST['apt_reminder_mail'] != get_option('apt_reminder_mail')) {
                update_option('apt_reminder_mail', $_POST['apt_reminder_mail']);
            }
            if (isset($_POST['apt_reminder_to_admin']) && $_POST['apt_reminder_to_admin'] != get_option('apt_reminder_to_admin')) {
                update_option('apt_reminder_to_admin', $_POST['apt_reminder_to_admin']);
            }
            if (isset($_POST['apt_reminder_mail_from']) && $_POST['apt_reminder_mail_from'] != get_option('apt_reminder_mail_from') && $_POST['apt_reminder_day'] != '') {
                update_option('apt_reminder_mail_from', $_POST['apt_reminder_mail_from']);
            }
            if (isset($_POST['apt_sms_sid']) && $_POST['apt_sms_sid'] != get_option('apt_sms_sid') && $_POST['apt_sms_sid'] != '') {
                update_option('apt_sms_sid', $_POST['apt_sms_sid']);
            }
            if (isset($_POST['apt_sms_token']) && $_POST['apt_sms_token'] != get_option('apt_sms_token') && $_POST['apt_sms_token'] != '') {
                update_option('apt_sms_token', $_POST['apt_sms_token']);
            }
            if (isset($_POST['apt_sms_number']) && $_POST['apt_sms_number'] != get_option('apt_sms_number') && $_POST['apt_sms_number'] != '') {
                update_option('apt_sms_number', $_POST['apt_sms_number']);
            }
            if (isset($_POST['apt_sms_own_number']) && $_POST['apt_sms_own_number'] != get_option('apt_sms_own_number') && $_POST['apt_sms_own_number'] != '') {
                update_option('apt_sms_own_number', $_POST['apt_sms_own_number']);
            }
            if (isset($_POST['apt_reminder_day']) && $_POST['apt_reminder_day'] != get_option('apt_reminder_day')) {
                update_option('apt_reminder_day', $_POST['apt_reminder_day']);
            }
            if (isset($_POST['apt_reminder_subject']) && $_POST['apt_reminder_subject'] != get_option('apt_reminder_subject')) {
                update_option('apt_reminder_subject', $_POST['apt_reminder_subject']);
            }
            if (isset($_POST['apt_form_style']) && $_POST['apt_form_style'] != get_option('apt_form_style')) {
                update_option('apt_form_style', $_POST['apt_form_style']);
            }
             if (isset($_POST['apt_date_format']) && $_POST['apt_date_format'] != get_option('apt_dformat')) {
                update_option('apt_dformat', $_POST['apt_date_format']);
            }
            if (isset($_POST['apt_form_background_color']) && $_POST['apt_form_background_color'] != get_option('apt_form_background_color')) {
                update_option('apt_form_background_color', $_POST['apt_form_background_color']);
            }
            if (isset($_POST['apt_form_text_color']) && $_POST['apt_form_text_color'] != get_option('apt_form_text_color')) {
                update_option('apt_form_text_color', $_POST['apt_form_text_color']);
            }
            if (isset($_POST['apt_form_background_input_color']) && $_POST['apt_form_background_input_color'] != get_option('apt_form_background_input_color')) {
                update_option('apt_form_background_input_color', $_POST['apt_form_background_input_color']);
            }
            if (isset($_POST['apt_form_border_input_color']) && $_POST['apt_form_border_input_color'] != get_option('apt_form_border_input_color')) {
                update_option('apt_form_border_input_color', $_POST['apt_form_border_input_color']);
            }
            if (isset($_POST['submit_btn_background_color']) && $_POST['submit_btn_background_color'] != get_option('submit_btn_background_color')) {
                update_option('submit_btn_background_color', $_POST['submit_btn_background_color']);
            }
            if (isset($_POST['submit_btn_hover_background_color']) && $_POST['submit_btn_hover_background_color'] != get_option('submit_btn_hover_background_color')) {
                update_option('submit_btn_hover_background_color', $_POST['submit_btn_hover_background_color']);
            }
            if (isset($_POST['submit_btn_txt_color']) && $_POST['submit_btn_txt_color'] != get_option('submit_btn_txt_color')) {
                update_option('submit_btn_txt_color', $_POST['submit_btn_txt_color']);
            }
            if (isset($_POST['submit_btn_shadow_color']) && $_POST['submit_btn_shadow_color'] != get_option('submit_btn_shadow_color')) {
                update_option('submit_btn_shadow_color', $_POST['submit_btn_shadow_color']);
            }
        }
        include($this->dir . '/ink-admin/appointments-form/templates/setting-apt.php');
    }
}

Ink_AptMenu::Init();