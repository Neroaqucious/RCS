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
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
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
        events:"<?php echo base_url('load/room/'.$respond['id']); ?>",    
        titleFormat: {year: '2-digit', month: 'short'},
        eventClick: function(info) {
            var eventObj = info.event;
            alert(info.event.extendedProps.room+"\n  "+info.event.extendedProps.instructor+"\n  "+info.event.title+"\n  "+(new Date(info.event.start)).toString().slice(0, 15)+"\n  "+(new Date(info.event.start)).toString().slice(16, 24)+" ~ "+(new Date(info.event.end)).toString().slice(16, 24)+"\n  "+info.event.extendedProps.description);
        },
        eventDidMount: function(info) {
          console.log(info.event);
          // {description: "Lecture", department: "BioChemistry"}
          if (info.event.textColor) {
            info.el.style.color=info.event.textColor;
          }
        },
      });
    calendar.render();
  });


//   var calendar = new FullCalendar.Calendar(calendarEl, {
//     timeZone: 'UTC',
//     headerToolbar: {
//       left: 'today prev,next',
//       center: 'title',
//       right: 'resourceTimelineDay,resourceTimelineTenDay,resourceTimelineMonth,resourceTimelineYear'
//     },
//     initialView: 'resourceTimelineDay',
//     scrollTime: '08:00',
//     aspectRatio: 1.5,
//     views: {
//       resourceTimelineDay: {
//         buttonText: ':15 slots',
//         slotDuration: '00:15'
//       },
//       resourceTimelineTenDay: {
//         type: 'resourceTimeline',
//         duration: { days: 10 },
//         buttonText: '10 days'
//       }
//     },
//     editable: true,
//     resourceAreaHeaderContent: 'Rooms',
//     resources: 'https://fullcalendar.io/demo-resources.json?with-nesting&with-colors',
//     events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
//   });

//   calendar.render();
// });

</script>

<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>

<div class="modal leftright-slide right-align fade" id="slideRightModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $result[0]['room']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="material-icons ">close</span>
        </button>
      </div>
      <div class="modal-body" style="overflow: scroll;">
        <table class="table table-striped m-0 bg-white">
          <thead>
            <tr class="text-center">
              <th>Course</th>
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
                  <td class="text-center text-light py-1" style=" font-size:0.8em;" class="text-light"><?php echo $row['name']; ?></td>
                  <td class="text-center text-light py-1" style=" font-size:0.8em;" class="text-light"><?php echo $row['instructor']; ?></td>    
                  <td class="text-center text-light py-1" style=" font-size:0.8em;" class=""><?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?></td>
                </td>    
              </tr>
            <?php } else { ?>
              <tr class="">
                <td class="text-center py-1 px-0" style=" font-size:0.8em;" class="text-light"><?php echo $row['name']; ?></td>
                <td class="text-center py-1 px-0" style=" font-size:0.8em;" class="text-light"><?php echo $row['instructor']; ?></td>    
                <td class="text-center py-1 px-0" style=" font-size:0.8em;" class=""><?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?></td>    
              </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>