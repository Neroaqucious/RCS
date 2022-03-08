<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/room/edit/'.$result->id, $attributes);
          ?>

        <div class="col-lg-6 col-md-6 float-left">
          <div class="form-group">
            <?php echo form_label('Room Name', 'name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
            <span class="badge badge-danger">Required</span>
            <?php
              echo form_input(array(
              'name' => 'name',
              'type' => 'text',
              'value' => html_escape(set_value('name',isset($result)?$result->name:''), ENT_QUOTES),
              'placeholder' => 'Enter room name!',
              'class' => 'form-control',
              'id' => ''));
            ?>
            <span class="text-danger"><?php echo form_error('name'); ?></span>
          </div>

          <div class="form-group">
            <?php
              echo form_label('Main Content','description', array('class' => 'col-form-label'));
            ?>
            <div class="col-md-12 col-sm-12 p-0">
              <?php 
                $data = array(
                'name' => 'description',
                'value' => '',
                'rows' => '6',
                'cols' => '',
                'placeholder' => 'Enter description',
                'class' => "form-control",
                'value' => html_escape(set_value('description',isset($result)?$result->description:''), ENT_NOQUOTES)
              );
              echo form_textarea($data); ?>
              <span class="text-danger"><?php echo form_error('description'); ?></span>
            </div>
          </div>

          <div class="form-group">
            <?php echo form_label('Status', 'status', array( 'class' => 'form-control-label pr-3', 'id'=> '')); ?>
            <div class="custom-control mb-2 custom-radio d-inline-block col-md-2">
              <input type="radio" id="customRadio1" name="status" class="custom-control-input" value="1" <?php if(($result->status) == 1) { echo "checked";}?>>
              <label class="custom-control-label" for="customRadio1">Public</label>
            </div>
            <div class="custom-control mb-4 custom-radio d-inline-block col-md-2">
              <input type="radio" id="customRadio2" name="status" class="custom-control-input" value="0" <?php if(($result->status) == 0) { echo "checked";}?>>
              <label class="custom-control-label" for="customRadio2">Private</label>
            </div>
          </div>

        </div>
        <div class="clearfix"></div>
          <hr class="my-4 dashed clearfix">            
            <button type="submit" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right"><span class="material-icons align-top md-18 mr-1">update</span>Update&nbsp;</button>
            <a href="<?php echo base_url('admin/room'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>