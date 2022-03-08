<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/password', $attributes);
          ?>
            <div class="col-lg-6 col-md-6 float-left">            
              <div class="form-group">
                <?php echo form_label('Current User Name', 'user_name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-warning">Can't allow username modified!</span>
                <?php
                  echo form_input(array(
                  'name' => 'user_name',
                  'type' => 'text',
                  'value' => html_escape(set_value('user_name',isset($result)?$result->username:''), ENT_QUOTES),
                  'placeholder' => 'Enter current user name!',
                  'class' => 'form-control',
                  'disabled' => 'disabled'));
                ?>
                <span class="text-danger"><?php echo form_error('user_name'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Current Password', 'curr_user_pass', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'curr_user_pass',
                  'type' => 'password',
                  'value' => "",
                  'placeholder' => 'Enter current password!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('curr_user_pass'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('New Password', 'new_user_pass', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'new_user_pass',
                  'type' => 'password',
                  'value' => "",
                  'placeholder' => 'Enter password!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('new_user_pass'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Confirm Password', 'user_conf_pass', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'user_conf_pass',
                  'type' => 'password',
                  'value' => "",
                  'placeholder' => 'Enter password!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('user_conf_pass'); ?></span>
              </div>
            </div>

            <div class="clearfix"></div>

            <hr class="my-4 dashed clearfix">
            <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">update</span>Update&nbsp;</button>
            <a href="<?php echo base_url('admin/profile'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>

</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>