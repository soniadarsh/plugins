<?php
global $wpdb;
$apt_service = $db_obj->tbl_service;
$aptname = $_POST['fname'];
$aptserviceid = $_POST['service_select'];
$srchk = $wpdb->get_row("SELECT * FROM $apt_service WHERE service_id = '$aptserviceid' ", ARRAY_N);
$apttime = $_POST['time'];
$aptdate = $_POST['aptcal'];
$aptrandom = $_POST['random'];
$aptemail = $_POST['aptemail'];
$aptphone = $_POST['aptphone'];
$aptmessage = $_POST['aptmessage'];
$cancelreturn = 'cancelreturn';
//label1
if (isset($_POST['label1'])) {
    if (is_array($_POST['label1'])) {
        $lab2 = $_POST['label1'];
        $chk1 = implode(",", $lab2);
        $lead_form1 = $chk1;
    } else {
        $lead_form1 = $_POST['label1'];
    }
} else {
    $lead_form1 = '';
}
//label2
if (isset($_POST['label2'])) {
    if (is_array($_POST['label2'])) {
        $lab2 = $_POST['label2'];
        $chk1 = implode(",", $lab2);
        $lead_form2 = $chk1;
    } else {
        $lead_form2 = $_POST['label2'];
    }
} else {
    $lead_form2 = '';
}

//label3
if (isset($_POST['label3'])) {
    if (is_array($_POST['label3'])) {
        $lab2 = $_POST['label3'];
        $chk1 = implode(",", $lab2);
        $lead_form3 = $chk1;
    } else {
        $lead_form3 = $_POST['label3'];
    }
} else {
    $lead_form3 = '';
}
//label4
if (isset($_POST['label4'])) {
    if (is_array($_POST['label4'])) {
        $lab2 = $_POST['label4'];
        $chk1 = implode(",", $lab2);
        $lead_form4 = $chk1;
    } else {
        $lead_form4 = $_POST['label4'];
    }
} else {
    $lead_form4 = '';
}
//label5
if (isset($_POST['label5'])) {
    if (is_array($_POST['label5'])) {
        $lab2 = $_POST['label5'];
        $chk1 = implode(",", $lab2);
        $lead_form5 = $chk1;
    } else {
        $lead_form5 = $_POST['label5'];
    }
} else {
    $lead_form5 = '';
}

/**
 * Ipn values/notify values
 */
$notify_values = array(
    'apttime' => $_POST['time'],
    'aptdate' => $_POST['aptcal'],
    'aptname' => $_POST['fname'],
    'aptserviceid' => $_POST['service_select'],
    'aptrandom' => $_POST['random'],
    'aptemail' => $_POST['aptemail'],
    'aptphone' => $_POST['aptphone'],
    'aptmessage' => $_POST['aptmessage'],
    'label1' => $lead_form1,
    'label2' => $lead_form2,
    'label3' => $lead_form3,
    'label4' => $lead_form4,
    'label5' => $lead_form5,
);
$ipn_vals = base64_encode(serialize($notify_values));
$key = apt_generateRandomString(5);
update_option('gc_paypal_ipn_' . $key, $ipn_vals);
$notify_url = $db_obj->dir_url . 'ink-admin/appointments-form/getway/paypal/paypal-ipn.php';
// notify code ends



$url = get_option('return_apt_url');
define('PAYPAL_RETURN', $url . '?aptpaypalamountpaid&paypal-trans&apttime=' . $apttime . '&aptdate=' . $aptdate . '&aptname='
        . $aptname . '&aptserviceid=' . $aptserviceid . '&aptrandom=' . $aptrandom . '&aptemail=' . $aptemail . '&aptphone=' . $aptphone . '&label1=' . $lead_form1 . '&label2=' . $lead_form2 . '&label3=' . $lead_form3 . '&label4=' . $lead_form4 . '&label5=' . $lead_form5 . '&aptmessage=' . $aptmessage);

define('CANCEL_RETURN', $url . '?aptpaypalamountpaid&paypal-trans&apttime=' . $apttime . '&aptdate=' . $aptdate . '&aptname='
        . $aptname . '&aptserviceid=' . $aptserviceid . '&aptrandom=' . $aptrandom . '&aptemail=' . $aptemail . '&aptphone=' . $aptphone . '&label1=' . $lead_form1 . '&label2=' . $lead_form2 . '&label3=' . $lead_form3 . '&label4=' . $lead_form4 . '&label5=' . $lead_form5 . '&aptmessage=' . $aptmessage . '&return=' . $cancelreturn);
$paypalamount = $srchk[2];
$service_title = $srchk[1];
//$paymentOpts = get_payment_optins($_REQUEST['pay_method']);
$merchantid = get_option('apt_merchaint_email');
$cancel_return = CANCEL_RETURN;
//$notify_url = PAYPAL_RETURN;
$currency_code = get_option('apt_currency_code');
$returnUrl = PAYPAL_RETURN;
?>
<form name="frm_payment_method" class="frm_payment_method" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="business" value="<?php echo $merchantid; ?>"/>
    <!-- Instant Payment Notification & Return Page Details -->
    <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>"/>
    <input type="hidden" name="cancel_return" value="<?php echo $cancel_return; ?>"/>
    <input type="hidden" name="return" value="<?php echo $returnUrl; ?>"/>
    <input type="hidden" name="rm" value="2"/>
    <!-- Configures Basic Checkout Fields -->
    <input type="hidden" name="lc" value=""/>
    <input type="hidden" name="no_shipping" value="1"/>
    <input type="hidden" name="no_note" value="1"/>
    <input type="hidden" name="custom" value="<?php echo $key; ?>" />
    <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>"/>
    <input type="hidden" name="first_name" value="<?php echo $_POST['fname']; ?>"/>
    <input type="hidden" name="page_style" value="paypal"/>
    <input type="hidden" name="charset" value="utf-8"/>
    <input type="hidden" name="item_name" value="<?php echo $service_title; ?>"/>
    <input type="hidden" value="_xclick" name="cmd"/>
    <input type="hidden" name="amount" value="<?php echo $paypalamount; ?>"/>
</form>
<!--<div class="wrapper">
    <div class="clearfix container_message">
        <center><h1 class="head"><?php //_e('Processing.... Please Wait...', 'appointment'); ?></h1></center>
        <center><img class="processing" src="<?php //echo $db_obj->dir_url . 'ink-admin/images/ripple.svg'; ?>"/></center>
    </div>
</div>-->
<script>
//    setTimeout("document.frm_payment_method.submit()", 50);
    setTimeout(function () {
        console.log("form get submitted");
        jQuery(".frm_payment_method").submit();
        jQuery("body").append('<div class="wrapper"><div class="clearfix container_message"><center><img class="processing" src="<?php echo $db_obj->dir_url . 'ink-admin/images/ripple.svg'; ?>"/></center></div></div>');
        jQuery('body').css('opacity', '0.4');
        jQuery('img.processing').css('position', 'absolute');
        jQuery('.wrapper').css('display', 'block');
    }, 50);

</script>