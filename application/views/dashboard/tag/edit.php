<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/tag/edit/'.$result->id, $attributes);
          ?>
          <div class="modal-body p-4">
            <div class="form-group">
              <?php
                echo form_label('Tag Name','name', array('class' => ''));
                echo ' <span class="badge badge-danger">Required</span>';
                echo form_input(array(
                  'name' => 'name',
                  'type' => 'text',
                  'value' => html_escape(set_value('name',isset($result)?$result->name:''), ENT_QUOTES),
                  'placeholder' => 'Enter level name',
                  'class' => 'form-control col-md-6'
                ));
              ?>
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
              
            <div class="modal-footer px-4">
              <a href="<?php echo base_url('admin/category'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
              <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">update</span>Update&nbsp;</button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>