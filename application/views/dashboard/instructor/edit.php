<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/instructor/edit/'.$result->id, $attributes);
          ?>

        <div class="col-md-12">
          <div class="col-md-6 float-left">
            <div class="form-group">
              <?php echo form_label('Instructor Name', 'full_name', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'name')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
                echo form_input(array(
                  'name' => 'full_name',
                  'type' => 'text',
                  'value' => html_escape(set_value('full_name',isset($result)?$result->name:''), ENT_QUOTES),
                  'placeholder' => 'Enter instructor name!',
                  'class' => 'form-control',
                  'id' => 'name',
                  'autocomplete' => 'new-name'));
                ?>
              <span class="text-danger"><?php echo form_error('full_name'); ?></span>
            </div>
            
            <div class="form-group">
              <?php echo form_label('Email', 'email', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'email')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
                echo form_input(array(
                  'name' => 'email',
                  'type' => 'text',
                  'value' => html_escape(set_value('email',isset($result)?$result->email:''), ENT_QUOTES),
                  'placeholder' => 'Enter email account!',
                  'class' => 'form-control',
                  'id' => 'email',
                  'autocomplete' => 'new-email'));
              ?>
              <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>

            <div class="form-group">
              <?php echo form_label('Password', 'password', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'password')); ?>
              <?php
                echo form_input(array(
                  'name' => 'password',
                  'type' => 'password',
                  'value' => '',
                  'placeholder' => 'Enter password!',
                  'class' => 'form-control',
                  'id' => 'password',
                  'autocomplete' => 'new-password'));
              ?>
              <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>

            <div class="form-group">
              <?php echo form_label('Confirm Password', 'conf_password', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'conf_password')); ?>
              <?php
                echo form_input(array(
                  'name' => 'conf_password',
                  'type' => 'password',
                  'value' => '',
                  'placeholder' => 'Enter confirm password!',
                  'class' => 'form-control',
                  'id' => 'conf_password',
                  'autocomplete' => 'new-conf_password'));
              ?>
              <span class="text-danger"><?php echo form_error('conf_password'); ?></span>
            </div>

            <div class="form-group">
              <?php
                echo form_label('Address','address', array('class' => 'col-form-label'));
              ?>
              <div class="col-md-12 col-sm-12 p-0">
                <?php 
                  $data = array(
                  'name' => 'address',
                  'value' => '',
                  'rows' => '3',
                  'cols' => '',
                  'placeholder' => 'Enter address',
                  'class' => "form-control",
                  'value' => set_value('address',isset($result)?$result->address:'')
                );
                echo form_textarea($data); ?>
                <span class="text-danger"><?php echo form_error('address'); ?></span>
              </div>
            </div>
          </div>

            <div class="col-md-6 float-left">
              <div class="form-group">
                <?php echo form_label('Phone Number', 'phone', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'phone')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                    'name' => 'phone',
                    'type' => 'text',
                    'value' => html_escape(set_value('phone',isset($result)?$result->phone:''), ENT_QUOTES),
                    'placeholder' => 'Enter phone number!',
                    'class' => 'form-control',
                    'id' => 'phone',
                    'autocomplete' => 'new-phone'));
                ?>
                <span class="text-danger"><?php echo form_error('phone'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('NRC No.', 'nrc', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'nrc')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                    'name' => 'nrc',
                    'type' => 'text',
                    'value' => html_escape(set_value('nrc',isset($result)?$result->nrc:''), ENT_QUOTES),
                    'placeholder' => 'Enter student name!',
                    'class' => 'form-control',
                    'id' => 'nrc',
                    'autocomplete' => 'new-nrc'));
                  ?>
                <span class="text-danger"><?php echo form_error('nrc'); ?></span>
              </div>
                  
              <div class="form-group">
                <?php echo form_label('Birthday', 'birthday', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'birthday')); ?>
                <?php
                  echo form_input(array(
                    'name' => 'birthday',
                    'type' => 'date',
                    'value' => html_escape(set_value('birthday',isset($result)?date('Y-m-d', strtotime($result->birthday)):''), ENT_QUOTES),
                    'placeholder' => 'Enter student name!',
                    'class' => 'form-control',
                    'id' => 'birthday',
                    'autocomplete' => 'new-birthday'));
                  ?>
                <span class="text-danger"><?php echo form_error('birthday'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Education', 'education', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'education')); ?>
                <?php
                  echo form_input(array(
                    'name' => 'education',
                    'type' => 'text',
                    'value' => html_escape(set_value('education',isset($result)?$result->education:''), ENT_QUOTES),
                    'placeholder' => 'Enter education!',
                    'class' => 'form-control',
                    'id' => 'education',
                    'autocomplete' => 'new-education'));
                  ?>
                <span class="text-danger"><?php echo form_error('education'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Main Lecture', 'lecture', array( 'class' => '', 'id'=> '', 'style' => '', 'for' => 'lecture')); ?>
                <?php
                echo form_input(array(
                  'name' => 'lecture',
                  'type' => 'text',
                  'value' => html_escape(set_value('lecture',isset($result)?$result->lecture:''), ENT_QUOTES),
                  'placeholder' => 'Enter lecture!',
                  'class' => 'form-control',
                  'id' => 'lecture',
                  'autocomplete' => 'new-lecture'));
                ?>
                <span class="text-danger"><?php echo form_error('lecture'); ?></span>
              </div>
            
              <div class="form-group">
                <?php echo form_label('Status', 'status', array( 'class' => 'form-control-label', 'id'=> '')); ?>
                <div class="form-check ml-3">
                  <div class="custom-control mb-2 custom-radio d-inline-block col-md-4">
                    <input type="radio" id="customRadio3" name="status" class="custom-control-input" value="1" <?php if(($result->status) == 1) { echo "checked";}?>>
                    <label class="custom-control-label" for="customRadio3">Public</label>
                  </div>
                  <div class="custom-control mb-4 custom-radio d-inline-block col-md-4">
                    <input type="radio" id="customRadio4" name="status" class="custom-control-input" value="0" <?php if(($result->status) == 0) { echo "checked";}?>>
                    <label class="custom-control-label" for="customRadio4">Private</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <hr class="my-4 dashed clearfix">

          <div class="text-right">
            <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">update</span>Update&nbsp;</button>
            <a href="<?php echo base_url('admin/instructor'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  </div>
</div>

<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>