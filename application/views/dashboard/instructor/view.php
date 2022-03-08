<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>

  <div class="content">  
    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <div style="text-align:center">
                <img src="<?php echo base_url('asset/admin/images/noimage.png'); ?>" class="img-thumbnail img-fluid rounded-circle" alt="pkt image" width="200">
            </div>
            <div class="text-center mt-3">
                <p>
                    <span class="text-dark weight-300"><?php echo $result->name; ?></span>
                </p>
                <p>
                    <span class="text-dark weight-300"> ********</span>
                </p>
                
                <hr class="my-4 dashed">
                  <a href="<?php echo base_url('admin/instructor'); ?>" class="btn  btn-sm py-1 px-2 btn-dark text-light"><span class="material-icons align-text-top md-24">view_headline</span></a>
                  <a href="<?php echo base_url('admin/instructor/edit/'.$result->id); ?>" class="btn  btn-sm py-1 px-2 btn-dark text-light"><span class="material-icons align-text-top md-24">edit</span></a>
              </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-8"> 
        <div class="card mb-4">
          <div class="card-header p-0">
            <ul class="nav nav-tabs active-thik nav-dark border-0" id="myTab" usr_role="tablist">
              <li class="nav-item">
                <a class="nav-link px-4 py-3 active rounded-0" id="profile-tab" data-toggle="tab" href="#profile" usr_role="tab" aria-controls="profile" aria-selected="false"><span class="material-icons align-middle">account_box</span> Information</a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-4 py-3 rounded-0" id="site-tab" data-toggle="tab" href="#site" usr_role="tab" aria-controls="site" aria-selected="true"><span class="material-icons align-middle">tune</span> Configuration</a>
              </li>
                <li class="nav-item">
                    <a class="nav-link px-4 py-3 rounded-0" id="logs-tab" data-toggle="tab" href="#logs" usr_role="tab" aria-controls="logs" aria-selected="true"><span class="material-icons align-middle">history</span> Login Session</a>
                </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" usr_role="tabpanel" aria-labelledby="profile-tab">
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Email</span>
                <span><?php echo $result->email; ?></span>
              </p>
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Phone</span>
                <span><?php echo $result->phone; ?></span>
              </p>
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Address</span>
                <span><?php echo $result->address; ?></span>
              </p>
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Birthday</span>
                <span><?php echo $result->birthday; ?></span>
              </p>
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">NRC No</span>
                <span><?php echo $result->nrc; ?></span>
              </p>
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Education</span>
                <span><?php echo $result->education; ?></span>
              </p>
              <p>
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Lecture</span>
                <span><?php echo $result->lecture; ?></span>
              </p>
            </div>

            <div class="tab-pane fade" id="site" usr_role="tabpanel" aria-labelledby="site-tab">
            </div>
                
            <div class="tab-pane fade" id="logs" usr_role="tabpanel" aria-labelledby="logs-tab">
            </div>
            
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
<!-- /page content -->

<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>
