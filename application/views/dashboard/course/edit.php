<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">
    <div class="row">
      <div class="col-lg-12 col-md-12 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open_multipart('admin/course/edit/'.$result->id, $attributes);
          ?>

          <div class="col-lg-8 col-md-8 float-left">
            <div class="form-group">
              <?php echo form_label('Course Title', 'name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
                echo form_input(array(
                'name' => 'name',
                'type' => 'text',
                'value' => html_escape(set_value('name',isset($result)?$result->cos_title:''), ENT_QUOTES),
                'placeholder' => 'Enter course title!',
                'class' => 'form-control',
                'id' => ''));
              ?>
              <span class="text-danger"><?php echo form_error('name'); ?></span>
            </div>
            

            <div class="form-group">
              <?php
                echo form_label('Description','desc', array('class' => 'col-form-label'));
              ?>
              <span class="badge badge-danger">Required</span>

              <textarea name="desc" cols="" rows="6" placeholder="Enter description" class="form-control">
                <?php echo html_escape(set_value('desc',isset($result)?$result->cos_des1:''), ENT_NOQUOTES); ?>
              </textarea>
                <span class="text-danger"><?php echo form_error('desc'); ?></span>
            </div>
	
            <?php
	          if(!empty($result->cos_image)){
		          echo '<img src="'.base_url().'upload/assets/adm/cos/'.$result->cos_image.'" style="width:90px;">';
	          } ?>
              <div class="form-group">
                <?php echo form_label('Course Cover', 'userfile',  array( 'class' => '', 'id' => '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-warning text-light">Only <?php echo ini_get('upload_max_filesize'); ?>!</span>		
			          <?php
			          echo form_input(array(
				          'name' => 'userfile',
				          'type' => 'file',
				          'class' => 'form-control-file',
                  'id' => 'clickImg',
                  'accept' => 'image/*'
			          ));
			          ?>
                  <span class="text-danger"><?php echo form_error( 'userfile' ); ?></span>
                  <div class="form-group" id="showImg"></div>
              </div>
          </div>
          
          <div class="col-lg-4 col-md-4 float-left">

            <div class="form-group">
              <?php echo form_label('Slug Name', 'slug', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
                echo form_input(array(
                'name' => 'slug',
                'type' => 'text',
                'value' => html_escape(set_value('slug',isset($result)?$result->slug_name:''), ENT_QUOTES),
                'placeholder' => 'Enter course slug!',
                'class' => 'form-control',
                'id' => ''));
              ?>
              <span class="text-danger"><?php echo form_error('slug'); ?></span>
            </div>

            <div class="form-group">
              <?php echo form_label('Subcategory', 'subcategory', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
              $setarray = array( 'class' => 'form-control', 'style' => '','id' => 'subcategoryid');
              echo form_dropdown(
                'subcategory',  //dropdown name
                $topic,
                set_value('subcategory',isset($result)?$result->subcat_id:''),
                $setarray
              );
              ?>
              <span class="text-danger"><?php echo form_error('subcategory'); ?></span>
            </div>
            
            <div class="form-group">
              <?php echo form_label('Course Level', 'level', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
              <span class="badge badge-danger">Required</span>
              <?php
              $setarray = array( 'class' => 'form-control', 'style' => '', 'id' => 'leveldata');
              echo form_dropdown(
                'level',  //dropdown name
                $level,
                set_value('level',isset($result)?$result->level_id:''),
                $setarray
              );
              ?>
              <span class="text-danger"><?php echo form_error('level'); ?></span>
            </div>
              
              <div class="border border-secondary-light25 bg-light p-3 mb-3">
              <div class="form-group">
                <?php echo form_label('Class', 'default_key', array( 'class' => 'form-control-label', 'id'=> '')); ?>              
                <div class="form-check">
                  <div class="custom-control mb-2 custom-radio d-inline-block col-md-4">
                    <input type="radio" id="customRadio1" name="default_key" class="custom-control-input" value="online" <?php if(($result->ref_key) == "online") { echo "checked";}?>>
                    <label class="custom-control-label" for="customRadio1">Online</label>
                  </div>
                  <div class="custom-control mb-4 custom-radio d-inline-block col-md-4">
                    <input type="radio" id="customRadio2" name="default_key" class="custom-control-input" value="offline" <?php if(($result->ref_key) == "offline") { echo "checked";}?>>
                    <label class="custom-control-label" for="customRadio2">Offline</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <?php echo form_label('Permission', 'status', array( 'class' => 'form-control-label', 'id'=> '')); ?>
                <div class="form-check">
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
            <button type="submit" class="btn mb-2 btn-sm flat btn-secondary py-1 px-1 float-right">
              <span class="material-icons align-top md-18 mr-1">update</span> Update
            </button>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/admin/js/ckeditor/ckeditor.js'); ?>"></script>
<script>
    CKEDITOR.replace('desc');
</script>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>
