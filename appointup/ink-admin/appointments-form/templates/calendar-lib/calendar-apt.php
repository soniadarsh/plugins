<link rel='stylesheet' href='<?php echo plugins_url('css/jquery-ui.min.css', __FILE__); ?>' />
<link href='<?php echo plugins_url('css/fullcalendar.css', __FILE__); ?>' rel='stylesheet' />
<link href='<?php echo plugins_url('css/fullcalendar.print.css', __FILE__); ?>' rel='stylesheet' media='print' />
<script src='<?php echo plugins_url('js/moment.min.js', __FILE__); ?>'></script>
<script src='<?php echo plugins_url('js/jquery.min.js', __FILE__); ?>'></script>
<script src='<?php echo plugins_url('js/fullcalendar.min.js', __FILE__); ?>'></script>
<script src='<?php echo plugins_url('js/jquery-ui.min.js', __FILE__); ?>'></script>
<script src='<?php echo plugins_url('js/lang-all.js', __FILE__); ?>'></script>
<script>

    $(document).ready(function () {

        $.each($.fullCalendar.langs, function (langCode) {
            $('#lang-selector').append(
                    $('<option/>')
                    .attr('value', langCode)
                    .prop('selected', langCode == currentLangCode)
                    .text(langCode)
                    );
        });

        // rerender the calendar when the selected option changes
        $('#lang-selector').on('change', function () {
            if (this.value) {
                currentLangCode = this.value;
                $('#calendar').fullCalendar('destroy');
                renderCalendar();
            }
        });

        var currentLangCode = 'en';
        function renderCalendar() {
            $('#calendar').fullCalendar({
                theme: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: new Date(),
                lang: currentLangCode,
                timeFormat: 'h:mma',
                editable: false,
                slotMinutes: 30,
                weekNumbers: true,
                buttonIcons: false, // show the prev/next text
                displayEventEnd: true,
                eventLimit: true, // allow "more" link when too many events
                events: [<?php
global $wpdb;
$db = new Apt_DB();
$appointment_data = $db->tbl_appointment_data;
$query = "SELECT * FROM $appointment_data";
$aptsql = $db->db->get_results($query, ARRAY_A);
foreach ($aptsql as $appointment_details) {
    $apt_title = $appointment_details['apt_data_persion_name'];
    $apt_description = sprintf(__("Service Name : %s <br>Email: %s <br> Price : %s", 'appointment'), $appointment_details['apt_data_service_name'], $appointment_details['apt_data_email'], $appointment_details['apt_data_price']);
    $apt_date = $appointment_details['apt_data_date'];
   
    $y = date('Y', strtotime($appointment_details['apt_data_date']));
    $m = date('n', strtotime($appointment_details['apt_data_date'])) - 1;
    $d = date('d', strtotime($appointment_details['apt_data_date']));
    $date = "$y-$m-$d";    
    $date = str_replace("-", ", ", $date);    
    $time_interval = $appointment_details['apt_data_time'];
    $apt_time = explode('-', $time_interval);
    $start_time = date("H, i", strtotime($apt_time[0]));
    $end_time = date("H, i", strtotime($apt_time[1]));
    $url = "?page=update-appointment&updateid=" . $appointment_details['APTID'] . "&&from=calendar";
    ?>{
                       
                        title: "<?php echo $apt_title; ?>",
                        start: new Date(<?php echo "$date, $start_time"; ?>),
                        end: new Date(<?php echo "$date, $end_time"; ?>),
                        description: '<?php echo $apt_description; ?>',
                        allDay: false,
                        backgroundColor: "#E4F1F9",
                        textColor: "black",
                    },<?php } ?>],
                eventRender: function (event, element) {
                    $(element).find(".fc-event-time").remove();
                    element.attr('href', 'javascript:void(0);');
                    element.click(function () {
                        $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
                        $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
                        $("#eventInfo").html(event.description);
                        $("#eventLink").attr('href', event.url);
                        $("#eventContent").dialog({
                            modal: true,
                            title: event.title,
                            width: 350,
                            buttons: {
                                Close: function () {
                                    $(this).dialog('close');
                                }
                            },
                            close: function () {
                            }
                        });
                    });
                }
            });
        }
        renderCalendar();
    });

</script>
<style>
    #calendar {
        margin: 20px;
    }
    #top {
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        font-size: 14px;
    }
    #top select{
        width: 130px;
        margin-left: 7px;
    }

</style>
<div id='top'>
    <b>
        <?php _e('Language: ', 'appointment'); ?>
    </b>
    <select id='lang-selector'></select>
</div>
<div id='calendar'></div>
<div id="eventContent" title="Event Details" style="display:none;">
    <p id="eventInfo" style="margin: 5px 0;"></p>
    Start: <span id="startTime"></span><br>
    End: <span id="endTime"></span>
</div>