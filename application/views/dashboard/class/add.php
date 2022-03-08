<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/class/add', $attributes);
          ?>

          <div class="col-lg-8 col-md-8 float-left">
            <div class="form-group">
              <?php echo form_label('Room', 'room', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
              $setarray = array( 'class' => 'form-control', 'style' => '', 'id' => 'coursedata');
              echo form_dropdown(
                'room',  //dropdown name
                $respond['room'],
                set_value('room',isset($result)?$result->room_id:''),
                $setarray
              );
              ?>
              <span class="text-danger"><?php echo form_error('room'); ?></span>
            </div>   

            <div class="form-group">
              <?php echo form_label('Course', 'course', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
              $setarray = array( 'class' => 'form-control', 'style' => '', 'id' => 'coursedata');
              echo form_dropdown(
                'course',  //dropdown name
                $respond['course'],
                set_value('course',isset($result)?$result->course_id:''),
                $setarray
              );
              ?>
              <span class="text-danger"><?php echo form_error('course'); ?></span>
            </div>

            <div class="form-group">
              <?php echo form_label('Instructor', 'instructor', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
                $setarray = array( 'class' => 'form-control', 'style' => '', 'id' => 'coursedata');
                echo form_dropdown(
                  'instructor',  //dropdown name
                  $respond['instructor'],
                  set_value('instructor',isset($result)?$result->instructor_id:''),
                  $setarray
                );
              ?>
              <span class="text-danger"><?php echo form_error('instructor'); ?></span>
            </div>

            <div class="form-group">
              <?php
                echo form_label('Description','desc', array('class' => 'col-form-label'));
              ?>
                <div class="col-md-12 col-sm-12 p-0">
                <?php
                  $data = array(
                    'name' => 'desc',
                    'value' => '',
                    'rows' => '6',
                    'cols' => '',
                    'placeholder' => 'Enter description',
                    'class' => "form-control",
                    'value' => html_escape(set_value('desc',isset($result)?$result->description:''), ENT_NOQUOTES)
                  );
                  echo form_textarea($data); ?>
                  <span class="text-danger"><?php echo form_error('desc'); ?></span>
                </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-4 float-left" >
            <div class="border border-secondary-light25 bg-light p-3 mb-3">
              <div class="form-group">
                <?php echo form_label('Date (start & end)', 'class_times', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <div class="col-md-6 float-left p-0">
                  <div>
                    <input type="date" step="1" name="start_date" id="start_date" class="form-control" placeholder="" value="<?php echo html_escape(set_value('start_date',isset($result)?$result->start_date:''), ENT_QUOTES) ?>">
                    <span class="text-danger"><?php echo form_error( 'start_date' ); ?></span>
                  </div>
                </div>
                <div class="col-md-6 float-right p-0">
                  <div>
                    <input type="date" step="1" name="end_date" id="end_date" class="form-control" placeholder="" value="<?php echo html_escape(set_value('end_date',isset($result)?$result->end_date:''), ENT_QUOTES) ?>">
                    <span class="text-danger"><?php echo form_error( 'end_date' ); ?></span>
                  </div>
                </div>
              </div>              
              <div class="clearfix"></div>
              <hr>
                
              <div class="form-group">
                <?php echo form_label('Days (target day)', 'class_days', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <div class="input-group">
                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Mon" name="class_days[]" value="Mon">
                    <label class="custom-control-label" for="Mon">Mon</label> 
                  </div>

                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Tue" name="class_days[]" value="Tue">
                    <label class="custom-control-label" for="Tue">Tue</label> 
                  </div>

                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Wed" name="class_days[]" value="Wed">
                    <label class="custom-control-label" for="Wed">Wed</label> 
                  </div>

                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Thu" name="class_days[]" value="Thu">
                    <label class="custom-control-label" for="Thu">Thu</label> 
                  </div>

                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Fri" name="class_days[]" value="Fri">
                    <label class="custom-control-label" for="Fri">Fri</label> 
                  </div>

                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Sat" name="class_days[]" value="Sat">
                    <label class="custom-control-label" for="Sat">Sat</label> 
                  </div>

                  <div class="custom-control mb-2 mr-4 custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="Sun" name="class_days[]" value="Sun">
                    <label class="custom-control-label" for="Sun">Sun</label> 
                  </div>    
                </div>
                <span class="text-danger"><?php echo form_error('class_days[]'); ?></span>
              </div>
              <hr>
              <input type="checkbox" class="custom-control-input d-none" id="Sun" name="class_days[]">

              <div class="form-group">
                <?php echo form_label('Times (start & end)', 'class_times', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                  
                  <div class="col-md-6 float-left">
                    <?php
                      echo form_input(array(
                      'name' => 'start_time',
                      'type' => 'time',
                      'value' => html_escape(set_value('start_time',isset($result)?$result->start_time:''), ENT_QUOTES),
                      'class' => 'form-control',
                      'id' => 'start_time',
                    ));
                    ?>
                    <span class="text-danger"><?php echo form_error('start_time'); ?></span>
                  </div>
                  <div class="col-md-6 float-right">
                    <?php
                      echo form_input(array(
                      'name' => 'end_time',
                      'type' => 'time',
                      'value' => html_escape(set_value('end_time',isset($result)?$result->end_time:''), ENT_QUOTES),
                      'class' => 'form-control',
                      'id' => 'end_time',
                    ));
                    ?>
                    <span class="text-danger"><?php echo form_error('end_time'); ?></span>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
                <hr>

                <div class="form-group">
                  <?php echo form_label('Schedule Color', 'class', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                  <?php
                  $color = array(
                    "" => "Select Color",
                    "#9d1919" => "red",
                    "#19729d" => "blue",
                    "#199d35" => "green",
                    "#9d9919" => "yellow",
                    "#fd7e14" => "orange",
                    "#6c757d" => "gray",
                    "#e83e8c" => "pink",
                    "#17a2b8" => "cyan",
                    "#20c997" => "teal",
                    "#6f42c1" => "purple",
                    "#000000" => "black",                    
                  );
                  $setarray = array( 'class' => 'form-control', 'id' => 'color', 'style' => '');
                    echo form_dropdown(
                      'color',  //dropdown name
                      $color,
                      set_value('color',isset($result)?$result->color:''),
                      $setarray
                    );
                  ?>
                </div>               
                
              <div class="form-group">
                <?php echo form_label('Status', 'status', array( 'class' => 'form-control-label', 'id'=> '')); ?>
                <div class="form-check ml-3">
                  <div class="custom-control mb-2 custom-radio d-inline-block col-md-4">
                    <input type="radio" id="customRadio3" name="status" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="customRadio3">Public</label>
                  </div>
                  <div class="custom-control mb-4 custom-radio d-inline-block col-md-4">
                    <input type="radio" id="customRadio4" name="status" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="customRadio4">Private</label>
                  </div>
                </div>
              </div>
            </div>

          <div class="clearfix"></div>
          <hr class="my-4 dashed clearfix">
            <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">add_circle</span>Submit&nbsp;</button>
            <a href="<?php echo base_url('admin/class'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>