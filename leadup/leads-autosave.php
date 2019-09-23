<?php
// session_start();  
global $wpdb;
$tablename = $wpdb->prefix . 'leads_dynamicform';
$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . $tablename . "'");
?>
<script>
//    jQuery(document).ready(function () {

//        if (jQuery("#leaduser").keyup()) {
//            console.log(jQuery("#leaduser").val());
//        }
        jQuery("input").change(function (event) {
            //lead_xplode_autosave();
        });
//    });
    jQuery(document).ajaxComplete(function () {
//        if (jQuery("input").val() == '') {
        //lead_xplode_autosave();
//        }
    });
    jQuery(window).load(function () {
        if (jQuery("input").val() == '') {
            //console.log('sldkfjhsdfh');
            //lead_xplode_autosave();

        }
    });



    function lead_xplode_autosave() {
        //            var name = jQuery(this).val();
//            var name = jQuery(jQuery("input").attr('name')).val() == 'Name' ? jQuery(jQuery("input").attr('name')).val() : '';
//            var input_variable = jQuery("input").attr('name');
        var name = jQuery("input[name='Name']").val();
        var email = jQuery("input[name='Email']").val();
        var number = jQuery("input[name='Number']").val();
        var message = jQuery("textarea[name='Message']").val();
        var label1 = jQuery("input[name='label1']").val();
        var label2 = jQuery("input[name='label2']").val();
        var label3 = jQuery("input[name='label3']").val();
        var label4 = jQuery("input[name='label4']").val();
        var label5 = jQuery("input[name='label5']").val();
        var label6 = jQuery("input[name='label6']").val();
        var label7 = jQuery("input[name='label7']").val();

        var session = '<?php echo isset($_SESSION["last_id"]) ? $_SESSION["last_id"] : "" ?>';
        var autoincreement = '<?php echo $last->Auto_increment; ?>';
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        jQuery.ajax(
                {
                    url: ajaxurl,
                    type: "POST",
//                        dataType: "json",
                    data: {
                        action: 'add_foobar',
                        name: name,
                        email: email,
                        number: number,
                        message: message,
                        label1: label1,
                        label2: label2,
                        label3: label3,
                        label4: label4,
                        label5: label5,
                        label6: label6,
                        label7: label7,
                        autoincreement: autoincreement,
                        session: session
                    },
                    success: function (msg) {
                        console.log(msg);
                    },
                    error: function (errorThrown) {
                        //    console.log(errorThrown);
                    }
                }
        );
    }
</script>
