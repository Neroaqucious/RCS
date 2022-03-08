<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/htmlhead.php"); ?>
<?php include(dirname(__FILE__) ."/function.php"); ?>
<section class="wrapper">
<!-- SIDEBAR -->
<aside class="sidebar">
  <nav class="navbar navbar-dark">
    <a class="navbar-brand ml-1 py-1 brand-title" href="<?php echo base_url('admin/panel'); ?>">PKT スクール</a>
    <span></span>
    <a class="navbar-brand py-0 material-icons toggle-sidebar" href="#">menu</a>
  </nav>
  <nav class="navigation" >
    <ul>
      <li class="<?php if($uri[0] != "" && $uri[0] == "dashboard") { echo "open active"; } ?>">
        <a href="<?php echo base_url('admin/panel'); ?>" title="Dashboard"><span class="nav-icon material-icons">dashboard</span> Dashboard</a>
      </li>
      <?php if (string_pos($sess_config, "pe_category") !== FALSE){ ?>
      <li class="<?php if($uri[0] != "" && $uri[0] == "category") { echo "open active"; } ?>">
        <a href="#" title="Layout Options"><span class="nav-icon material-icons">category</span> Category </a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "category_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/category'); ?>" title="Category List"> Category List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "subcategory_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/subcategory'); ?>" title="Subcategory List"> Subcategory List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "level_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/level'); ?>" title="Level List"> Level List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "room_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/room'); ?>" title="Room List"> Room List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "tag_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/tag'); ?>" title="Tag List"> Tag List</a></li>
        </ul>
      </li> 
      <?php } ?>
      
      <?php if (string_pos($sess_config, "pe_course") !== FALSE){ ?>
      <li class="<?php if($uri[0] != "" && $uri[0] == "course") { echo "open active"; } ?>">
        <a href="#" title="Layout Options"><span class="nav-icon material-icons">book</span> Course</a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "course_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/course'); ?>" title="Course List"> List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "course_add") { echo "active"; } ?>"><a href="<?php echo base_url('admin/course/add'); ?>" title="Add Course"> Add New</a></li>
        </ul>
      </li>  
      <?php } ?>

      <?php if (string_pos($sess_config, "pe_classes") !== FALSE){ ?>
      <li class="<?php if($uri[0] != "" && $uri[0] == "class") { echo "open active"; } ?>">
        <a href="#" title="Layout Options"><span class="nav-icon material-icons">view_carousel</span> Class</a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "class_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/class') ?>" title=""> List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "class_add") { echo "active"; } ?>"><a href="<?php echo base_url('admin/class/add') ?>" title=""> Add New</a></li>
        </ul>
      </li>
      <?php } ?>

      <?php if (string_pos($sess_config, "pe_student") !== FALSE){ ?>
      <li><a href="#" title="Layout Options"><span class="nav-icon material-icons">account_box</span> Student </a>
        <ul class="sub-nav">
            <li><a href="#" title=""> List</a></li>
            <li><a href="#" title=""> Add New</a></li>
        </ul>
      </li>
      <?php } ?>

      <?php if (string_pos($sess_config, "pe_instructor") !== FALSE){ ?>
      <li class="<?php if($uri[0] != "" && $uri[0] == "instructor") { echo "open active"; } ?>"><a href="#" title="Layout Options"><span class="nav-icon material-icons">record_voice_over</span> Instructor </a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "instructor_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/instructor') ?>" title=""> List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "instructor_add") { echo "active"; } ?>"><a href="<?php echo base_url('admin/instructor/add') ?>" title=""> Add New</a></li>
        </ul>
      </li> 
      <?php } ?>

      <?php if (string_pos($sess_config, "pe_information") !== FALSE){ ?>
      <li class="<?php if($uri[0] != "" && $uri[0] == "information") { echo "open active"; } ?>">
        <a href="#" title="Layout Options"><span class="nav-icon material-icons">info</span> Information</a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "jpschool_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/school') ?>" title=""> 日本 School</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "local_list") { echo "active"; } ?>"><a href="<?php echo base_url('admin/local') ?>" title=""> Local Company</a></li>
        </ul>
      </li>
      <?php } ?>

    <?php if (string_pos($sess_config, "pe_payment") !== FALSE){ ?>
      <li><a href="#" title="Layout Options"><span class="nav-icon material-icons">credit_card</span> Payment </a>
        <ul class="sub-nav">
          <li><a href="#" title=""> List</a></li>
          <li><a href="#" title=""> Tax List</a></li>
          <li><a href="#" title=""> Discount List</a></li>
        </ul>
      </li>
    <?php } ?>
    
    <?php if (string_pos($sess_config, "pe_accountant") !== FALSE){ ?>
      <li><a href="#" title="Layout Options"><span class="nav-icon material-icons">extension</span> Accountant </a>
      <ul class="sub-nav">
        <li><a href="#" title=""> Salary List</a></li>
        <li><a href="#" title=""> Billing List</a></li>
        <li><a href="#" title=""> Expense List</a></li>
        <li><a href="#" title=""> Purchase List</a></li>
      </ul>
      <?php } ?>

      <?php if (string_pos($sess_config, "pe_admin") !== FALSE){ ?>
      <li class="<?php if($uri[0] != "" && $uri[0] == "admin") { echo "open active"; } ?>">
        <a href="#" title="Layout Options"><span class="nav-icon material-icons">security</span> Administrator </a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "admin_list") { echo "active"; } ?>">
          <a href="<?php echo base_url('admin/auth/list') ?>" title="Admin List">List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "admin_add") { echo "active"; } ?>">
          <a href="<?php echo base_url('admin/auth/add') ?>" title="Admin Add">Add New</a></li>
        </ul>
      </li>
      <li class="<?php if($uri[0] != "" && $uri[0] == "role") { echo "open active"; } ?>">
        <a href="" title="Roles"><span class="nav-icon material-icons">developer_board</span> Role</a>
        <ul class="sub-nav">
          <li class="<?php if($uri[1] != "" && $uri[1] == "role_list") { echo "active"; } ?>">
            <a href="<?php echo base_url('admin/role') ?>" title="Role List">List</a></li>
          <li class="<?php if($uri[1] != "" && $uri[1] == "role_add") { echo "active"; } ?>">
            <a href="<?php echo base_url('admin/role/add') ?>" title="Role Add">Add New</a></li>
        </ul>
      </li>
      <?php } ?>
    </li>
    </ul>
  </nav>
</aside>