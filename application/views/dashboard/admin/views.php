<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="content">  
    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <div style="text-align:center">
                <img src="<?php echo base_url('asset/admin/images/user.png'); ?>" class="img-thumbnail img-fluid rounded-circle" alt="user image" width="100">
            </div>
            <div class="text-center mt-3">
                <p>
                    <span>User Name : </span>
                    <span class="text-dark weight-300"><?php echo $result->username; ?></span>
                </p>
                <p>
                    <span>Password : </span>
                    <span class="text-dark weight-300"> ********</span>
                </p>
                <p>
                    <span>Permission : </span>
                    <span class="text-dark weight-300"><span class="badge badge-info text-white"><?php echo $result->role; ?></span></span>
                </p>
                <hr class="my-4 dashed">
                <?php if (string_pos($sess_config, "admin")) {  ?>
                    <a href="<?php echo base_url('admin/auth/add'); ?>" class="btn btn-sm btn-dark text-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add New User"><span class="material-icons align-middle">add_circle</span></a>
                    <a href="<?php echo base_url('admin/auth/list'); ?>" class="btn btn-sm btn-dark text-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="User List"><span class="material-icons align-middle">view_headline</span></a>
                <?php } ?>
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
                <a class="nav-link px-4 py-3 rounded-0" id="site-tab" data-toggle="tab" href="#site" usr_role="tab" aria-controls="site" aria-selected="true"><span class="material-icons align-middle">settings_applications</span> Configuration</a>
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
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Full Name</span>
                <span><?php echo $result->full_name; ?></span>
              </p>
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
                <span class="text-dark weight-300" style="width:130px; display:inline-block;">Permission</span>
                <span><?php echo str_replace('pe_','',$result->config); ?></span>
              </p>
            </div>

            <div class="tab-pane fade" id="site" usr_role="tabpanel" aria-labelledby="site-tab">
              <?php foreach($respond['config'] as $row=>$val) { ?>
                <p>
                  <span class="text-dark weight-300" style="width:130px;display:inline-block;vertical-align: top;"><?php echo $row; ?></span>
                  <span style="display: inline-block;width: 600px;overflow: auto;"><?php echo $val; ?></span>
                </p>
              <?php } ?>
              </div>
                
            <div class="tab-pane fade" id="logs" usr_role="tabpanel" aria-labelledby="logs-tab">
              <div class="">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped bg-white text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ipaddress</th>
                            <th>agent</th>
                            <th>Total Minutes</th>
                            <th>Session Start</th>
                            <th>Session Timeout</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($record as $row) { ?>
                        <tr>
                            <td><?php echo $row->id; ?></td>
                            <td><?php echo $row->ipaddress; ?></td>
                            <td><?php echo $row->agent; ?></td>
                            <td><?php echo $row->session/60; ?> Min</td>
                            <td><?php echo $row->start_time; ?></td>
                            <td><?php echo $row->end_time; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
                <hr class="my-2 dashed">
                <div class="text-right">
                  <a href="<?php echo base_url('force/logout/'.$respond['id']); ?>" class="btn btn-sm btn-dark text-light" data-toggle="tooltip" data-placement="top" title="" data-original-title=""><span class="material-icons align-middle">autorenew</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
<!-- /page content -->

<?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>
