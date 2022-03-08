<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open_multipart('admin/instructor/add', $attributes);
          ?>
          <div class="col-lg-12 col-md-12 float-left p-0">
            <div class="col-lg-7 float-left">
              <div class="form-group">
                <?php echo form_label('Name', 'full_name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'full_name',
                  'type' => 'text',
                  'value' => html_escape(set_value('full_name',isset($result)?$result->name:''), ENT_QUOTES),
                  'placeholder' => 'Enter instructor name!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('full_name'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Email', 'email', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'email',
                  'type' => 'text',
                  'value' => html_escape(set_value('email',isset($result)?$result->email:''), ENT_QUOTES),
                  'placeholder' => 'Enter email !',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('email'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Password', 'password', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'password',
                  'type' => 'password',
                  'value' => html_escape(set_value('password',isset($result)?$result->password:''), ENT_QUOTES),
                  'placeholder' => 'Enter password !',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('password'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Confirm Password', 'conf_password', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'conf_password',
                  'type' => 'password',
                  'value' => html_escape(set_value('conf_password',isset($result)?$result->password:''), ENT_QUOTES),
                  'placeholder' => 'Enter password !',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('conf_passwords'); ?></span>
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
                    'value' => html_escape(set_value('address',isset($result)?$result->address:''), ENT_NOQUOTES)
                  );
                  echo form_textarea($data); ?>
                  <span class="text-danger"><?php echo form_error('address'); ?></span>
                </div>
              </div>
            </div>

            <div class="col-lg-5 float-right">
              <div class="form-group">
                <?php echo form_label('Phone Number', 'phone', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'phone',
                  'type' => 'text',
                  'value' => html_escape(set_value('phone',isset($result)?$result->phone:''), ENT_QUOTES),
                  'placeholder' => 'Enter phone number!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('phone'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Birthday', 'birthday', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <?php
                  echo form_input(array(
                  'name' => 'birthday',
                  'type' => 'date',
                  'value' => html_escape(set_value('birthday',isset($result)?$result->birthday:''), ENT_QUOTES),
                  'placeholder' => 'Enter birthday!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('birthday'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('NRC Number', 'nrc', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <?php
                  echo form_input(array(
                  'name' => 'nrc',
                  'type' => 'text',
                  'value' => html_escape(set_value('nrc',isset($result)?$result->nrc:''), ENT_QUOTES),
                  'placeholder' => 'Enter NRC!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('nrc'); ?></span>
              </div>
          
              <div class="form-group">
                <?php echo form_label('Education', 'education', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <?php
                  echo form_input(array(
                  'name' => 'education',
                  'type' => 'text',
                  'value' => html_escape(set_value('education',isset($result)?$result->education:''), ENT_QUOTES),
                  'placeholder' => 'Enter Education!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('education'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Lecture', 'lecture', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <?php
                  echo form_input(array(
                  'name' => 'lecture',
                  'type' => 'text',
                  'value' => html_escape(set_value('lecture',isset($result)?$result->lecture:''), ENT_QUOTES),
                  'placeholder' => 'Enter lecture!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('lecture'); ?></span>
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
          </div>          

        <div class="clearfix"></div>
        <hr class="my-4 dashed clearfix">
          <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">add_circle</span>Submit&nbsp;</button>
          <a href="<?php echo base_url('admin/instructor'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
        <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>