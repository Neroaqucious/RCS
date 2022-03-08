<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<link href="<?php echo base_url('asset/admin/fullcalendar/lib/main.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('asset/admin/fullcalendar/lib/main.min.js'); ?>"></script>

  <div class="content">
    <div class="card mb-2">
      <div class="card-body p-lg-3">
        <div class="row">  
          <div class="col-md-6 col-lg-3 mb-lg-0">   
            <h6 class="weight-200 mb-3 border-left border-success pl-2 border-width-medium">Total <span class="text-muted"> Classes</span></h6>
            <div class="media align-items-center">
              <span class="material-icons text-light mr-3 circle p-3 border border-success bg-success">view_carousel</span>
              <div class="media-body">
                <h4 class="weight-200 m-0"><?php echo $class_count; ?>&nbsp;Nos</h4>
              </div>
            </div> 
          </div>

          <div class="col-md-6 col-lg-3 mb-lg-0">   
            <h6 class="weight-200 mb-3 border-left border-secondary pl-2 border-width-medium">Total <span class="text-muted"> Rooms</span></h6>
            <div class="media align-items-center">
              <span class="material-icons text-light mr-3 circle p-3 border border-secondary bg-secondary">pages</span>
              <div class="media-body">
                <h4 class="weight-200 m-0"><?php echo $room; ?>&nbsp;Nos</h4>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 mb-lg-0">   
            <h6 class="weight-200 mb-3 border-left border-info pl-2 border-width-medium">Total <span class="text-muted">  Course</span></h6>
            <div class="media align-items-center">
              <span class="material-icons text-light mr-3 circle p-3 border border-info bg-info">class</span>
              <div class="media-body">
                <h4 class="weight-200 m-0"><?php echo $course_count; ?>&nbsp;Nos</h4>
              </div>
            </div> 
          </div>

          <div class="col-md-6 col-lg-3 mb-lg-0">  
            <h6 class="weight-200 mb-3 border-left border-primary pl-2 border-width-medium">Total <span class="text-muted">  Instructor</span></h6>
            <div class="media align-items-center">
                <span class="material-icons text-light mr-3 circle p-3 border border-primary bg-primary">record_voice_over</span>
                <div class="media-body">
                  <h4 class="weight-200 m-0"><?php echo $instructor; ?>&nbsp;Nos</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-lg-8">
        <div class="bg-white p-3">
          <div id="calendar"></div>
        </div>
      </div>

      <div class="col-lg-4 p-0">
        <div class="card mb-lg-0">
          <div class="card-header bg-dark text-success py-1">Today <span class="text-light">Schedule (<?php echo date('d, M Y') ?>)</span></div>
          <div class="card-body">
            <ul class="list-unstyled recent-activites" style="height: 393px;overflow: scroll;">
              <?php 
              $today = strtotime("now");
                foreach($result as $row) { 
                  if($today > $row['start_time'] && $today < $row['end_time']) { ?>
                <li>
                  <span class="activity-icon border-success"></span>
                  <div class="media align-items-center">
                      <div class="media-body">
                      <h6 class="weight-200 mb-0"><?php echo $row['room']; ?> - <?php echo $row['name']; ?></h6>
                      <small class="text-muted"><?php echo $row['instructor']; ?>  ( <?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?> )</small>
                      </div>
                  </div>
                </li>
                <?php } elseif($today < $row['start_time'] && $today < $row['end_time']) {  ?>
                <li>
                  <span class="activity-icon border-gray"></span>
                  <div class="media align-items-center">
                      <div class="media-body">
                        <h6 class="weight-200 text-gray mb-0"><?php echo $row['room']; ?> - <?php echo $row['name']; ?></h6>
                        <small class="text-gray"><?php echo $row['instructor']; ?>  ( <?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?> )</small>
                      </div>
                  </div>
                </li>
              
                <?php } else { ?>
                <li>
                  <span class="activity-icon border-light"></span>
                  <div class="media align-items-center">
                      <div class="media-body">
                        <h6 class="weight-200 text-muted mb-0"><?php echo $row['room']; ?> - <?php echo $row['name']; ?></h6>
                        <small class="text-muted"><?php echo $row['instructor']; ?>  ( <?php echo date('d, M h:i', $row['start_time']) ." ~ ".date('h:i', $row['end_time']); ?> )</small>
                      </div>
                  </div>
                </li>
                <?php } } ?>
               
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
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
            height: 450,
            eventDisplay: 'list-item',
            nowIndicator: true,
            eventTimeFormat: {
              hour: 'numeric',
              minute: '2-digit',
              omitZeroMinute: true,
              meridiem: 'narrow'
            },
            events:"<?php echo base_url('load/all/'); ?>",    
            titleFormat: {year: '2-digit', month: 'short'},
            eventClick: function(info) {
                var eventObj = info.event;
                alert(info.event.extendedProps.room+"\n  "+info.event.extendedProps.instructor+"\n  "+info.event.title+"\n  "+(new Date(info.event.start)).toString().slice(0, 15)+"\n  "+(new Date(info.event.start)).toString().slice(16, 24)+" ~ "+(new Date(info.event.end)).toString().slice(16, 24)+"\n  "+info.event.extendedProps.description);
            },
            eventDidMount: function(info) {
              // console.log(info.event);
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
    