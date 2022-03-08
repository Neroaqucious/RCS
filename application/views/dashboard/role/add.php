<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/role/add', $attributes);
          ?>

        <div class="col-lg-6 col-md-6 float-left">
          <div class="form-group">
            <?php echo form_label('Role Name', 'role_name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
            <span class="badge badge-danger">Required</span>
            <?php
              echo form_input(array(
              'name' => 'role_name',
              'type' => 'text',
              'value' => html_escape(set_value('role_name',isset($result)?$result->name:''), ENT_QUOTES),
              'placeholder' => 'Enter role name!',
              'class' => 'form-control',
              'id' => ''));
            ?>
            <span class="text-danger"><?php echo form_error('role_name'); ?></span>
          </div>

          <div class="form-group">
            <?php echo form_label('Session', 'session', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
            <span class="badge badge-danger">Required</span>
            <span class="badge badge-warning text-light">Only Minutes</span>
            <?php
              echo form_input(array(
                'name' => 'session',
                'type' => 'text',
                'value' => html_escape(set_value('session',isset($result)?$result->session:''), ENT_QUOTES),
                'placeholder' => 'Enter session!',
                'class' => 'form-control',
                'id' => ''));
            ?>
            <span class="text-danger"><?php echo form_error('session'); ?></span>
          </div>

          <div class="form-group">
            <?php echo form_label('Configuration', 'permission', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?><span class="badge badge-danger">Required</span>
            <div class="input-group">
              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per1" name="permission[]" value="pe_admin">
                <label class="custom-control-label" for="per1">Admin Management</label>
              </div>              

              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per2" name="permission[]" value="pe_category">
                <label class="custom-control-label" for="per2">Category Management</label>
              </div>

              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per3" name="permission[]" value="pe_classes">
                <label class="custom-control-label" for="per3">Class Management</label>
              </div>

              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per" name="permission[]" value="pe_instructor">
                <label class="custom-control-label" for="per">Instructor Management</label>
              </div>

              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per4" name="permission[]" value="pe_course">
                <label class="custom-control-label" for="per4">Course Management</label>
              </div>

              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per7" name="permission[]" value="pe_information">
                <label class="custom-control-label" for="per7">Information Management</label>
              </div>
              
              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per5" name="permission[]" value="pe_student">
                <label class="custom-control-label" for="per5">Student Management</label>
              </div>
              
              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per10" name="permission[]" value="pe_accountant">
                <label class="custom-control-label" for="per10">Accountant Management</label>
              </div>

              <div class="custom-control mb-2 mr-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="per11" name="permission[]" value="pe_payment">
                <label class="custom-control-label" for="per11">Payment Management</label>
              </div>
            </div>
            <div class="clearfix d-block">
              <span class="text-danger"><?php echo form_error('permission[]'); ?></span>
            </div>
          </div>

          <div class="form-group">
            <?php echo form_label('Status', 'status', array( 'class' => 'form-control-label pr-3', 'id'=> '')); ?>
            <div class="custom-control mb-2 custom-radio d-inline-block col-md-2">
              <input type="radio" id="customRadio1" name="status" class="custom-control-input" value="1">
              <label class="custom-control-label" for="customRadio1">Public</label>
            </div>
            <div class="custom-control mb-4 custom-radio d-inline-block col-md-2">
              <input type="radio" id="customRadio2" name="status" class="custom-control-input" value="0" checked="checked">
              <label class="custom-control-label" for="customRadio2">Private</label>
            </div>
          </div>

        </div>
        <div class="clearfix"></div>
        <hr class="my-4 dashed clearfix">
          <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">add_circle</span>Submit&nbsp;</button>
          <a href="<?php echo base_url('admin/role'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
        <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>