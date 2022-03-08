<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>  
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open('admin/subcategory/edit/'.$result->id, $attributes);
          ?>

          <div class="modal-body p-4">

            <div class="form-group">
              <?php echo form_label('Category Name', 'catid', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
              $setarray = array( 'class' => 'form-control col-md-6', 'style' => '');
              echo form_dropdown(
                'catid',  //dropdown name
                $category,
                set_value('catid',isset($result)?$result->cat_id:''),
                $setarray
              );
              ?>
              <span class="text-danger"><?php echo form_error('catid'); ?></span>
            </div>

            <div class="form-group">
              <?php
                echo form_label('Subcategory name','name', array('class' => ''));
                echo ' <span class="badge badge-danger">Required</span>';
                echo form_input(array(
                  'name' => 'name',
                  'type' => 'text',
                  'value' => html_escape(set_value('name',isset($result)?$result->name:''), ENT_QUOTES),
                  'placeholder' => 'Enter subcategory name',
                  'class' => 'form-control col-md-6'
                ));
              ?>
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
              
            <div class="modal-footer px-4">
              <a href="<?php echo base_url('admin/subcategory'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
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