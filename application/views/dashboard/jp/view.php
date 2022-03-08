<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>            
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="card">
    <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="title"><?php echo $result->subject; ?></h3>
        <hr class="my-2 dashed clearfix">
        <div class="col-md-12 mt-3">
          <div class="col-md-5 float-left">
            <?php if(!empty($result->photo)){ ?>
              <img class="mb-2 img-fluid bg-white col-md-12" src="<?php echo base_url('upload/assets/adm/new/'.$result->photo); ?>">
            <?php } else { ?>
              <img class="mb-2 img-fluid bg-white col-md-12" src="<?php echo base_url('/asset/admin/images/noimage.png'); ?>">
            <?php } ?>
          </div>
          <div class="col-md-7 p-0 float-left">  
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">Tag Name</span>
              <span class="badge badge-info text-light"><?php echo ucfirst($result->tag); ?></span>
            </p> 
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">School Name</span>
              <span><?php echo $result->name; ?></span>
            </p>
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">School Email</span>
              <span><?php echo $result->email; ?></span>
            </p>
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">School Phone</span>
              <span><?php echo $result->phone; ?></span>
            </p>
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">Address</span>
              <span><?php echo $result->address; ?></span>
            </p>  
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">Created Date</span>
              <span><?php echo $result->created_at; ?></span>
            </p> 
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">Updated Date</span>
              <span><?php echo $result->updated_at; ?></span>
            </p>
            <p>
              <span class="text-dark weight-300" style="width:130px; display:inline-block;">Status</span>
              <span><?php if($result->status == 1) { ?><a href="#" class="badge badge-success text-light">Public</a><?php } else { ?><a href="#" class="badge badge-dark">Private</a><?php } ?></span>
            </p>          
          </div>             
        </div>
        <div class="clearfix"></div>
        <hr class="my-2 dashed clearfix">        
        <div class="col-md-12 mt-4 mypage">
          <?php echo $result->requirement; ?>
        </div>
        <div class="clearfix"></div>
        <hr class="my-4 dashed clearfix">                
          <a href="<?php echo base_url('admin/school/edit/'.$result->id); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right ml-2" ><span class="material-icons align-text-bottom">edit</span></a>
          <a href="<?php echo base_url('admin/school'); ?>" class="btn mb-2 btn-sm flat btn-dark py-1 px-1 float-right" ><span class="material-icons align-text-bottom">keyboard_backspace</span></a>
      </div>
    </div>
  </div>
</div>
<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>