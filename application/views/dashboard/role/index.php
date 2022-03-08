<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>            
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>

  <div class="card">
    <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped bg-white text-nowrap" id="RcsTable">
      <thead>
        <tr class="text-center">
          <th>#</th>
          <th>Name</th>
          <th>Permission</th>
          <th>Session</th>          
          <?php echo customize_view('th', []); ?> 
          <th width="1">Created Date</th>
          <th width="1">Updated Date</th>          
          <th width="1">State </th>
          <th width="1">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $x = 1;
          foreach($result as $row) {  
        ?>
        <tr>
          <th><?php echo $x; ?></th>
          <td class="text-dark weight-300"><?php echo $row->name; ?></td>          
          <td class="text-left"> <?php echo str_replace('pe_','',$row->config); ?></td>
          <td class="text-center"><?php echo $row->session/60; ?> Minutes</td>          
          <?php echo customize_view('td', $row->created_by); ?>  
          <?php echo customize_view('td', $row->updated_by); ?>  
          <td class="text-center"><?php echo $row->created_at; ?></td>
          <td class="text-center"><?php echo $row->updated_at; ?></td>          
          <td class="text-center">
            <?php if($row->status == 1) { ?>
              <span class="badge badge-success text-white">Public</span>
            <?php } else { ?>
              <span class="badge badge-secondary text-white">Private</span>
            <?php } ?>
          </td>
          <td class="text-center"><a href="#" class="text-muted" id="actionDropdown" data-toggle="dropdown">
            <span class="material-icons md-20 align-middle">more_vert</span></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
              <a class="dropdown-item" href="<?php echo base_url('admin/role/edit/'.$row->id); ?>">Edit</a>
              <a onclick="return confirm('Are you want to delete this data?');"  class="dropdown-item" href="<?php echo base_url('admin/role/delete/'.$row->id); ?>">Delete</a>
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