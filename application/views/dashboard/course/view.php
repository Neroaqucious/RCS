<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
<div class="content">
  <div class="card mb-4">
    <div class="card-body">              
      <div class="col-md-6 float-left">
        <div class="float-left col-md-3 text-center">       
          <?php if(!empty($result->cos_image)) { ?> 
            <img src="<?php echo base_url('upload/assets/adm/cos/'.$result->cos_image); ?>" width="200" class="img-thumbnail" alt="pkt image">
          <?php } else { ?>
            <img src="<?php echo base_url('/asset/admin/images/thumb_noimage.png'); ?>" width="200" class="img-thumbnail" alt="pkt image">
          <?php } ?>
        </div>
        <div>
          <dl class="row">
            <dt class="col-sm-4">Course Name</dt>
            <dd class="col-sm-8"> <?php echo $result->cos_title; ?></dd>
            <dt class="col-sm-4">Slug Name</dt>
            <dd class="col-sm-8"> <?php echo $result->slug_name; ?></dd>
            <dt class="col-sm-4">Level </dt>
            <dd class="col-sm-8"> <?php echo $result->level; ?></dd>
            <dt class="col-sm-4">Subcategory </dt>
            <dd class="col-sm-8"> <?php echo $result->subcategory; ?></dd>
            <dt class="col-sm-4">Class </dt>
            <dd class="col-sm-8"> <?php echo strtolower($result->ref_key); ?> class</dd>
            <dt class="col-sm-4">Status </dt>
            <dd class="col-sm-8">
              <?php if($result->status == 1) { ?>       
                <span class="badge badge-success text-white">Public</span>
              <?php } else { ?>
                <span class="badge badge-dark text-white">Privated</span>
              <?php } ?>
            </dd>
          </dl>
        </div>        
      </div>

      <div class="col-md-6 float-left">
        <div class="table m-0">
          <span><?php echo $result->cos_des1; ?></span>
        </div>
      </div>    

      
      <div class="clearfix my-4"></div>

      
      
        
    </div>
  </div>
</div>

<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>