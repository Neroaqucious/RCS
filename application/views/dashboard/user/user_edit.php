<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/edit', $attributes);
          ?>
            <div class="col-lg-6 col-md-6 float-left">
              <div class="form-group">
                <?php echo form_label('Full Name', 'admin_name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'admin_name',
                  'type' => 'text',
                  'value' => html_escape(set_value('admin_name',isset($result)?$result->full_name:''), ENT_QUOTES),
                  'placeholder' => 'Enter full name!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('admin_name'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Email', 'admin_email', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                    'name' => 'admin_email',
                    'type' => 'email',
                    'value' => html_escape(set_value('admin_email',isset($result)?$result->email:''), ENT_QUOTES),
                    'placeholder' => 'Enter email name!',
                    'class' => 'form-control',
                    'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('admin_email'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Phone Number', 'admin_phone', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                    'name' => 'admin_phone',
                    'type' => 'text',
                    'value' => html_escape(set_value('admin_phone',isset($result)?$result->phone:''), ENT_QUOTES),
                    'placeholder' => 'Enter phone number!',
                    'class' => 'form-control',
                    'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('admin_phone'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Address' ,'admin_address' , array( 'id' => '', 'class' => '', 'style' => 'margin-bottom:10px;')); ?>
                <?php echo form_textarea(array(
                  'name'        => 'admin_address',
                  'type'        => 'text',
                  'value'       => html_escape(set_value( 'admin_address' , isset($result)?$result->address:''), ENT_QUOTES),
                  'placeholder' => 'Enter Content Text!',
                  'class'       => 'form-control',
                  'rows'          => '5'	));
                ?>
                <span class="text-danger"><?php echo form_error('admin_address'); ?></span>
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