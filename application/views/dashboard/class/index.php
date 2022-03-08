<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/../templates/header.php"); ?>
  <div class="card">
    <div class="card-body">
    <div class="">
      <table class="table table-striped table-responsive bg-white text-nowrap" id="RcsTable">
      <thead>
        <tr class="text-center">
          <th width="1">#</th>
          <th>Course</th>
          <th>Instructor</th>          
          <th>Room</th>                    
          <th>Days</th>
          <th>Times</th>
          <th>Date</th>
          <th>Duration</th>
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
          <th class="text-right"><?php echo $x; ?></th>          
          <td class="text-left"><a href="<?php echo base_url('admin/class/view/'.$row->id); ?>"><?php echo $row->course_name; ?><a></td>
          <td class="text-left"><?php echo $row->inst_name; ?></td>
          <td class="text-center"><?php echo $row->room_name; ?></td>                             
          <td class="text-center"><?php echo $row->days; ?></td>
          <td class="text-center" ><?php echo $row->start_time.' ~ '.$row->end_time; ?></td>
          <td class="text-center" ><?php echo $row->start_date.' ~ '.$row->end_date; ?></td>
          <td class="text-center"><?php echo $row->duration; ?> days</td>
          <?php echo customize_view('td', $row->created_by); ?>  
          <?php echo customize_view('td', $row->updated_by); ?>      
          <td><?php echo $row->created_at; ?></td>
          <td><?php echo $row->updated_at; ?></td>     
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
              <a class="dropdown-item" href="<?php echo base_url('admin/class/edit/'.$row->id); ?>">Edit</a>
              <a onclick="return confirm('Are you want to delete this data?');"  class="dropdown-item" href="<?php echo base_url('admin/class/delete/'.$row->id); ?>">Delete</a>
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