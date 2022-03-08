<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-body">
          <?php
            $attributes = array('class' => 'form-horizontal form-label-left');
            echo form_open_multipart('admin/local/add', $attributes);
          ?>
          <div class="col-lg-12 col-md-12 float-left">
            <div class="col-lg-7 float-left">
              <div class="form-group">
                <?php echo form_label('Title', 'subject', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'subject',
                  'type' => 'text',
                  'value' => html_escape(set_value('subject',isset($result)?$result->subject:''), ENT_QUOTES),
                  'placeholder' => 'Enter course title!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('subject'); ?></span>
              </div>
              
              <div class="form-group">
                <?php
                  echo form_label('Requirement','requirement', array('class' => 'col-form-label'));
                ?>
                <span class="badge badge-danger">Required</span>
                <div class="col-md-12 col-sm-12 p-0">
                  <?php 
                    $data = array(
                    'name' => 'requirement',
                    'value' => '',
                    'rows' => '6',
                    'cols' => '',
                    'placeholder' => 'Enter requirement',
                    'class' => "form-control",
                    'value' => html_escape(set_value('requirement',isset($result)?$result->requirement:''), ENT_NOQUOTES)
                  );
                  echo form_textarea($data); ?>
                  <span class="text-danger"><?php echo form_error('requirement'); ?></span>
                </div>
              </div>
              
              <div class="form-group">
                <?php echo form_label('Tags', 'tags', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                $setarray = array( 'class' => 'form-control', 'style' => '');
                echo form_dropdown(
                  'tags',  //dropdown name
                  $respond['tags'],
                  set_value('tags',isset($result)?$result->tags_id:''),
                  $setarray
                );
                ?>
                <span class="text-danger"><?php echo form_error('tags'); ?></span>
              </div>
                
              <?php
                if(isset($result->photo)){
                  echo '<img src="'.base_url().'/upload/assets/adm/new/'.$result->photo.'">';
                } else { ?>
                  <div class="form-group">
                  <?php echo form_label('Company Image', 'userfile',  array( 'class' => '', 'id' => '', 'style' => 'margin-bottom:10px')); ?>
                  <span class="badge badge-warning text-light">Only <?php echo ini_get('upload_max_filesize'); ?>!</span>              
                  <?php
                    echo form_input(array(
                      'name' => 'userfile',
                      'type' => 'file',
                      'class' => 'form-control',
                      'id' => 'clickImg',
                      'accept' => 'image/*'
                    ));
                  ?>
                  <span class="text-danger"><?php echo form_error('userfile'); ?></span>                  
                </div>
                <div class="form-group" id="showImg"></div>
              <?php } ?>
            </div>

            <div class="col-lg-5 float-right">
              <div class="form-group">
                <?php echo form_label('Company Name', 'name', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <span class="badge badge-danger">Required</span>
                <?php
                  echo form_input(array(
                  'name' => 'name',
                  'type' => 'text',
                  'value' => html_escape(set_value('name',isset($result)?$result->name:''), ENT_QUOTES),
                  'placeholder' => 'Enter company name!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('name'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Company Email', 'email', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
                <?php
                  echo form_input(array(
                  'name' => 'email',
                  'type' => 'text',
                  'value' => html_escape(set_value('email',isset($result)?$result->email:''), ENT_QUOTES),
                  'placeholder' => 'Enter company email!',
                  'class' => 'form-control',
                  'id' => ''));
                ?>
                <span class="text-danger"><?php echo form_error('email'); ?></span>
              </div>

              <div class="form-group">
                <?php echo form_label('Phone number', 'phone', array( 'class' => '', 'id'=> '', 'style' => 'margin-bottom:10px')); ?>
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
                <?php
                  echo form_label('Company Address','address', array('class' => 'col-form-label'));
                ?>
                <span class="badge badge-danger">Required</span>
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
          <a href="<?php echo base_url('admin/local'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right mr-1"><span class="material-icons align-top md-18 mr-1">arrow_left</span>Back&nbsp;</a>
        <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/admin/js/ckeditor/ckeditor.js'); ?>"></script>
<script>
    CKEDITOR.replace('requirement');
</script>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>