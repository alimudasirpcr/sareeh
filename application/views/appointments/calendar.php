<?php $this->load->view("partial/header"); ?>


<div class="main-content">
    <div class="container-fluid">
        <div class="row manage-table  card p-5">
            <div class=" ">
                <div class="card-header rounded rounded-3 p-5">
                    <h3 class="card-title">
                        <?php echo lang('calendar') ?>
                    </h3>
                </div>
                <div class="card-body nopadding table_holder table-responsive" id="table_holder">
                    <?php // echo  $calendar;?>
                </div>

                <div id="calendar"></div>


            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // The view to be displayed (month view)
        locale: 'en', // Language/locale setting
        headerToolbar: { // Toolbar settings
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: <?php echo json_encode($calendar_events); ?>,
        eventClick: function(info) {
            if (info.event.url) {
                // Open the link in a new tab
                window.open(info.event.url, '_blank');
                // Prevent the default behavior (redirecting to the link)
                info.jsEvent.preventDefault();
            }
        }
    });

    calendar.render(); // Render the calendar
});
</script>


<script>
date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);
var $date = $("#date");
var picker = $date.data("DateTimePicker");

$date.on('dp.change', function(e) {
    window.location = SITE_URL + '/appointments/calendar/' + e.date.format('YYYY') + '/' + e.date.format('M') +
        '/' + '-1' + '/' + e.date.format('D');
});
</script>

<?php $this->load->view("partial/footer"); ?>