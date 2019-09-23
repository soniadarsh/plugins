<?php

class LeadsSetData {

    private $name;
    private $captcha;
    private $multiemail;
    private $lead_form1, $lead_form2, $lead_form3, $lead_form4, $lead_form5,
            $lead_form6, $lead_form7, $lead_form8, $lead_form9, $lead_form10;

//accessor and mutetar function for create
    public function get_lead_name() {
        return $this->lead_name;
    }

    public function set_lead_name($x) {
        $this->lead_name = $x;
    }

    public function get_randvalue() {
        return $this->randvalue;
    }

    public function set_randvalue($x) {
        $this->randvalue = $x;
    }

    public function set_form1($x) {
        $this->form1 = $x;
    }

    public function set_form2($x) {
        $this->form2 = $x;
    }

    public function set_form3($x) {
        $this->form3 = $x;
    }

    public function set_form4($x) {
        $this->form4 = $x;
    }

    public function set_form5($x) {
        $this->form5 = $x;
    }

    public function set_form6($x) {
        $this->form6 = $x;
    }

    public function set_form7($x) {
        $this->form7 = $x;
    }

    public function set_form8($x) {
        $this->form8 = $x;
    }

    public function set_form9($x) {
        $this->form9 = $x;
    }

    public function set_form10($x) {
        $this->form10 = $x;
    }

//function

    public function savetodb() {
        global $wpdb, $leads_dynamicform;
        $sql = "SELECT * FROM $leads_dynamicform WHERE  rand_value =$this->randvalue";
        $value = $wpdb->get_row($sql);
        if (!$value) {

            if (isset($_SESSION['last_id'])) {
                // code to update member data

                $datavalue = array(
                    'id' => $_SESSION['last_id'],
                    'name' => $this->lead_name,
                    'leadform1' => $this->form1,
                    'leadform4' => $this->form4,
                    'leadform5' => $this->form5,
                    'leadform6' => $this->form6,
                    'leadform7' => $this->form7,
                    'leadform8' => $this->form8,
                    'leadform9' => $this->form9,
                    'date' => date('Y-m-d'),
                    'rand_value' => $this->randvalue
                );
                if ($this->form2 != '') {
                    $datavalue['leadform2'] = $this->form2;
                }
                if ($this->form3 != '') {
                    $datavalue['leadform3'] = $this->form3;
                }

                $query = $wpdb->replace($leads_dynamicform, $datavalue);
            } else {

                $datavalue = array(
                    'name' => $this->lead_name,
                    'leadform1' => $this->form1,
                    'leadform4' => $this->form4,
                    'leadform5' => $this->form5,
                    'leadform6' => $this->form6,
                    'leadform7' => $this->form7,
                    'leadform8' => $this->form8,
                    'leadform9' => $this->form9,
                    'date' => date('Y-m-d'),
                    'rand_value' => $this->randvalue
                );
                if ($this->form2 != '') {
                    $datavalue['leadform2'] = $this->form2;
                }
                if ($this->form3 != '') {
                    $datavalue['leadform3'] = $this->form3;
                }
                $query = $wpdb->insert($leads_dynamicform, $datavalue);
            }
        }
        /* php code
          $query="insert into inkthemes_info values('$this->lead_name','$this->email','$this->contact','$this->message','$this->captcha')";
          echo "<br/>$query";
         */
    }

    public function email_send($mail_list = array()) {
        $leadurl = home_url();
        global $wpdb, $leads_dynamicform, $leads_dynamic_index;
        $sql = "SELECT * FROM $leads_dynamicform WHERE  rand_value =$this->randvalue";
        $value = $wpdb->get_row($sql);
        if (!$value) {
            if (empty($mail_list)) {
                $multiemail = get_option('leadcapture-email');
                $explode_emails = explode(", ", $multiemail);
            } else {
                $explode_emails = $mail_list;
            }
            $email_message = __("Form details below.", 'leadcapture') . "\n\n";

            function clean_string($string) {
                $bad = array("content-type", "bcc:", "to:", "cc:", "href");
                return str_replace($bad, "", $string);
            }

            $in = 1;
            while ($in <= 10) {
                global $wpdb, $leads_dynamicform, $leads_dynamic_index;
                ;
                $emailcount2 = $wpdb->get_row("SELECT * FROM $leads_dynamic_index WHERE id = '$in'", ARRAY_N);
                $emailcount[] = $emailcount2[1];
                $in++;
            }

            if (!empty($this->lead_name)) {
                $email_message .= $emailcount[0] . ": " . clean_string($this->lead_name) . "\n";
            }
            if (!empty($this->form1)) {
                $email_message .= $emailcount[1] . ": " . clean_string($this->form1) . "\n";
            }
            if (!empty($this->form2)) {
                $email_message .= $emailcount[2] . ": " . clean_string($this->form2) . "\n";
            }
            if (!empty($this->form3)) {
                $email_message .= $emailcount[3] . ": " . clean_string($this->form3) . "\n";
            }
            if (!empty($this->form4)) {
                $email_message .= $emailcount[4] . ": " . clean_string($this->form4) . "\n";
            }
            if (!empty($this->form5)) {
                $email_message .= $emailcount[5] . ": " . clean_string($this->form5) . "\n";
            }
            if (!empty($this->form6)) {
                $email_message .= $emailcount[6] . ": " . clean_string($this->form6) . "\n";
            }
            if (!empty($this->form7)) {
                $email_message .= $emailcount[7] . ": " . clean_string($this->form7) . "\n";
            }
            if (!empty($this->form8)) {
                $email_message .= $emailcount[8] . ": " . clean_string($this->form8) . "\n";
            }
            if (!empty($this->form9)) {
                $email_message .= $emailcount[9] . ": " . clean_string($this->form9) . "\n";
            }
            $email_message .= "Site URL: " . clean_string($leadurl) . "\n";
// create email headers
            for ($i = 0; $i < count($explode_emails); $i++) {
                $email_to = $explode_emails[$i];
                $email_subject = __("Message Received from a New Lead", 'leadcapture');
                //$headers = "Content-type: text/html; charset=UTF-8\r\n";
//                $headers = 'From: ' . $this->form1 . "\r\n" .
//                        'Reply-To: ' . $this->form1 . "\r\n" .
//                        'X-Mailer: PHP/' . phpversion();
                wp_mail($email_to, $email_subject, $email_message);
            }
            $leaduri = $_SERVER['REQUEST_URI'];
            $leaduri = strstr($leaduri, '?code', true);
            $leadsname = $_SERVER['SERVER_NAME'];
            $full_path = 'http://' . $leadsname . $leaduri;
            if(get_option('leadcapture-ack')!=''){ 
                $lead_ack = get_option('leadcapture-ack');                
            }else{
                $lead_ack = "We have received your request and will get back to you on your email.";
            }
            ?>
            <div class="inkleadsform-conatainer inkleadsform-submitted">
                <div class="inkleadsform-top"></div>
                <div class="inkleadsform">
                    <?php
                    echo "<div class='sucess-send'><a href=" . wp_get_original_referer() . ">" . __('Back', 'leadcapture') . "</a><h2>" . $lead_ack . "</h2></div>";
                    ?>
                </div>
            </div>
            <?php
        }
    }

    public function check($labelname) {
        $customname = $labelname;
        global $wpdb, $lead_field_count;
        $value1 = $wpdb->get_row("SELECT * FROM $lead_field_count WHERE  text_label='$customname'");
        return $value1;
    }

    public function table_update($ulabel, $rname) {
        global $wpdb, $leads_dynamic_index;
        if ($ulabel == 'Name') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 1), array('%s'), array('%d'));
        }
        if ($ulabel == 'Email') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 2), array('%s'), array('%d'));
        }
        if ($ulabel == 'Number') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 3), array('%s'), array('%d'));
        }
        if ($ulabel == 'Message') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 4), array('%s'), array('%d'));
        }
        if ($ulabel == 'label1') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 5), array('%s'), array('%d'));
        }
        if ($ulabel == 'label2') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 6), array('%s'), array('%d'));
        }
        if ($ulabel == 'label3') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 7), array('%s'), array('%d'));
        }
        if ($ulabel == 'label4') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 8), array('%s'), array('%d'));
        }
        if ($ulabel == 'label5') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 9), array('%s'), array('%d'));
        }
        if ($ulabel == 'label6') {
            $wpdb->update($leads_dynamic_index, array('lead_name' => $rname), array('id' => 10), array('%s'), array('%d'));
        }
    }

    function user_browser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $ub = '';
        if (preg_match('/MSIE/i', $u_agent)) {
            $ub = "ie";
        }
        return $ub;
    }

    function ink_capt1() {
        $text = rand(0, 9);
        return $text;
    }

    function ink_capt2() {
        $text1 = rand(0, 9);
        return $text1;
    }

}
