<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<!-- Fullcalendar Icons -->
<link href="<?php echo base_url('asset/admin/fullcalendar/lib/main.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('asset/admin/fullcalendar/lib/main.min.js'); ?>"></script>

<div class="content-wrapper col-md-12 d-block p-0">
  <div class="bg-white p-3 col-md-12 d-inline-block">
    <div id="calendar"></div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          center: 'prev,today,next',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        weekends: true,
        editable: false,
        selectable: false,
        initialDate: new Date(),
        navLinks: true, // can click day/week names to navigate views
        businessHours: false, // display business hours
        dayMaxEvents: true, // allow "more" link when too many events
        height: 650,
        eventDisplay: 'list-item',
        aspectRatio: 0.5,
        nowIndicator: true,
        eventTimeFormat: {
          hour: 'numeric',
          minute: '2-digit',
          omitZeroMinute: true,
          meridiem: 'narrow'
        },
        events:"<?php echo base_url('load/calendar/'.$respond['id']); ?>",    
        titleFormat: {year: '2-digit', month: 'short'},
        eventClick: function(info) {
          var eventObj = info.event;
            if(info.event.extendedProps.description != "") {
              alert(info.event.extendedProps.room+"\n  "+info.event.extendedProps.instructor+"\n  "+info.event.title+"\n  "+(new Date(info.event.start)).toString().slice(0, 15)+"\n  "+(new Date(info.event.start)).toString().slice(16, 24)+" ~ "+(new Date(info.event.end)).toString().slice(16, 24)+"\n  "+info.event.extendedProps.description);
            }
        },
        eventDidMount: function(info) {
          if (info.event.textColor) {
            info.el.style.color=info.event.textColor;
          }
        },
      });
    calendar.render();
  });
</script>

<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>

<div class="modal leftright-slide right-align fade" id="slideRightModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php print_r($result[0]['name']); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="material-icons ">close</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table m-0 bg-white">
          <thead>
            <tr class="text-center">
              <th>Room</th>
              <th>Instructor</th>
              <th >DateTime</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $today = strtotime("now");
            $x = 1;
            foreach($result as $row) {  
              if($today > $row['start_time'] && $today < $row['end_time']) { ?>
                <tr class="bg-success">
                  <td class="text-center text-light py-1 px-0" style=" font-size:0.9em;" class="text-light"><?php echo $row['room']; ?></td>    
                  <td class="text-center text-light py-1 px-0" style=" font-size:0.9em;" class="text-light"><?php echo $row['instructor']; ?></td>    
                  <td class="text-center text-light py-1 px-0" style=" font-size:0.9em;" class=""><?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?></td> 
                </tr>
              <?php } elseif($today < $row['start_time'] && $today < $row['end_time']) {  ?>
                <tr class="bg-dark">
                  <td class="text-center text-light py-1 px-0" style=" font-size:0.9em;" class="text-light"><?php echo $row['room']; ?></td>    
                  <td class="text-center text-light py-1 px-0" style=" font-size:0.9em;" class="text-light"><?php echo $row['instructor']; ?></td>    
                  <td class="text-center text-light py-1 px-0" style=" font-size:0.9em;" class=""><?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?></td>
                </tr>
              <?php } else { ?>
                <tr class="bg-muted">
                  <td class="text-center text-secondary py-1 px-0" style=" font-size:0.9em;" class="text-light"><?php echo $row['room']; ?></td>    
                  <td class="text-center text-secondary py-1 px-0" style=" font-size:0.9em;" class="text-light"><?php echo $row['instructor']; ?></td>    
                  <td class="text-center text-secondary py-1 px-0" style=" font-size:0.9em;" class=""><?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?></td>
                </tr>
              <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>