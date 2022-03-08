<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>            
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="card">
    <div class="card-body">

    <div class="table-responsive">
      <table class="table table-striped bg-white text-nowrap" id="studentDataOnline">
      <thead>
        <tr class="text-center">
        <th width="1">#</th>
            <th style="width:300px;">Tag Name</th>
          <?php echo customize_view('th', []); ?> 
          <th width="1">Created Date</th>
          <th width="1">Updated Date</th>       
          <th width="1">State</th>
          <th width="1">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $x = 1;
        foreach ($result as $row) { ?>
        <tr>
          <td class="text-right"><?php echo $x; ?> </td>
          <td  class="text-center"><?php echo $row->name; ?></td>
          <?php echo customize_view('td', $row->created_by); ?>  
          <?php echo customize_view('td', $row->updated_by); ?>  
          <td class="text-center"><?php echo $row->created_at; ?></td>
          <td class="text-center"><?php echo $row->updated_at; ?></td>
          <td class="text-center">     
          <?php if($row->status == 1) { ?>       
            <span class="badge badge-success text-white">Public</span>
          <?php } else { ?>
            <span class="badge badge-dark text-white">Private</span>
          <?php } ?>
          </td>
          
          <td class="text-center"><a href="#" class="text-muted" id="actionDropdown" data-toggle="dropdown">
            <span class="material-icons md-20 align-middle">more_vert</span></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
              <a class="dropdown-item" href="<?php echo base_url('admin/tag/edit/'.$row->id); ?>">Edit</a>
              <a onclick="return confirm('Are you want to delete this data?');" class="dropdown-item" href="<?php echo base_url('admin/tag/delete/'.$row->id); ?>">Delete</a>
            </div>
          </td>
        </tr>
        <?php $x++; } ?>
      </tbody>
    </table>
    </div>
    </div>
  </div>

  <?php include(dirname(__FILE__) ."/../templates/footer.php"); ?>

  <!-- Modal -->
     <div class="modal fade" id="<?php echo str_replace('#','',$respond['modal']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog col-11 p-0" role="document">
          <div class="modal-content">
            <?php
              $attributes = array('class' => '');
              echo form_open('admin/tag/add', $attributes);
            ?>
            <div class="modal-header px-4">
              <h5 class="modal-title" id="exampleModalLabel">Add New Tags</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="material-icons ">close</span>
              </button>
            </div>
            <div class="modal-body p-4">
              <div class="form-group">
                <?php
                  echo form_label('Tags Name','name', array('class' => ''));
                  echo ' <span class="badge badge-danger">Required</span>';
                  echo form_input(array(
                    'name' => 'name',
                    'type' => 'text',
                    'value' => '',
                    'placeholder' => 'Enter tag name',
                    'class' => 'form-control'
                  ));
                ?>
              </div>

              <fieldset class="form-group">
                <div class="row">
                  <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                  <div class="col-sm-10">
                    <div class="form-check col-md-3 float-left">
                      <input class="form-check-input" type="radio" id="status1" name="status" value="1">
                      <label class="form-check-label" for="status1">Public</label>
                    </div>
                    <div class="form-check col-md-3 float-left">
                      <input class="form-check-input" type="radio" id="status2" name="status" value="0" checked="checked">
                      <label class="form-check-label" for="status2">Private</label>
                    </div>
                  </div>
                </div>
              </fieldset>

              <div class="modal-footer px-4">
                <button type="button" class="btn btn-sm btn-secondary text-white" data-dismiss="modal"><span class="material-icons align-top md-18 mr-1">close</span> Close</button>
                <button type="submit" class="btn btn-sm btn-primary text-white"><span class="material-icons align-top md-18 mr-1">add_circle</span> Add New</button>
              </div>
            </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
<!-- Modal -->
