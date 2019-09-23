<style>
    div#price{
        display: none;
    }
    .ink-container{
        width: 400px;
        margin: auto auto;
        text-align: center;
    }
    h2.manual-apt-head{
        text-align: center;
    }
</style>
<h2 class="manual-apt-head">Book Your Appointment Manually</h2>
<?php
$shortcode = do_shortcode('[ink-appointments-form]');
?>
<div class="elementor-shortcode"><?php echo $shortcode; ?></div>
