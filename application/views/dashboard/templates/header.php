<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include(dirname(__FILE__) ."/aside.php"); ?>
<!--RIGHT CONTENT AREA-->
<div class="content-area">
  <header class="header sticky-top">
    <nav class="navbar navbar-dark bg-dark px-sm-2 py-0" style="border-bottom: 2px solid #ed3f41;">
      <a class="navbar-brand py-1 d-md-none  m-0 material-icons toggle-sidebar" href="#">menu</a>
      <ul class="navbar-nav flex-row ml-auto">
        <li class="nav-item">
          <a href="#" id="notificationDropdown" data-toggle="dropdown" class="nav-link text-secondary">
            <span class="material-icons align-middle">notification_important</span></a>
          <div class="dropdown-menu p-0 dropdown-lg notificationDropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
            <a class="dropdown-item py-3 border-bottom" href="#">
                <span class="badge badge-pill badge-danger mr-2">Warning</span> <small class="text-muted">Somthing went wrong !</small>
            </a>
            <button type="button" class="btn btn-light btn-sm btn-block">View All</button>
          </div>
        </li>
        <li>
          <a href="#" class="nav-link text-secondary"><span class="material-icons align-middle">chat</span></a>
        </li>
        <li class="nav-item user-logedin dropdown">
          <a href="#" id="userLogedinDropdown" data-toggle="dropdown" class="nav-link weight-300 dropdown-toggle">
          <span class="material-icons align-middle">account_circle</span> <?php echo ucfirst(isset($_SESSION['__user_information']['user_name'])?$_SESSION['__user_information']['user_name']:""); ?></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userLogedinDropdown">
            <a class="dropdown-item" href="<?php echo base_url('admin/profile'); ?>">Profile</a>
            <a class="dropdown-item" href="<?php echo base_url('admin/password'); ?>">Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">Log Out</a>
          </div>
        </li>
      </ul>
    </nav>
  </header>
  <div class="content-wrapper">
    <div class="row page-tilte align-items-center">
      <div class="col-md-auto">
        <a href="#" class="mt-3 d-md-none float-right toggle-controls"><span class="material-icons">keyboard_arrow_down</span></a>
        <h4 class="weight-100 title"><?php echo $title; ?></h4>
      </div> 
      <div class="col controls-wrapper mt-3 mt-md-0 d-none d-md-block ">
        <div class="controls d-flex justify-content-center justify-content-md-end float-right">
          <?php if(!empty($respond['add'])) { ?>
            <a class="btn flat btn-dark btn-sm py-1 px-2" href="<?php echo base_url($respond['add']); ?>"><span class="material-icons align-text-top md-20">add_circle</span></a>
          <?php } ?>
          <?php if(!empty($respond['edit'])) { ?>
            <a class="btn flat btn-dark btn-sm py-1 px-2" href="<?php echo base_url($respond['edit'].'/'.$id); ?>"><span class="material-icons align-text-top md-20">tune</span></a>
          <?php } ?>
          <?php if(!empty($respond['list'])) { ?>
            <a class="btn flat btn-dark btn-sm py-1 px-2" href="<?php echo base_url($respond['list']); ?>"><span class="material-icons align-text-top md-20">view_headline</span></a>
          <?php } ?>
          <?php if(!empty($respond['modal'])) { ?>
            <button class="btn flat btn-dark btn-sm py-1 px-2" data-toggle="modal" data-target="<?php echo $respond['modal']; ?>"><span class="material-icons align-text-top md-20">add_circle</span></button>
          <?php } ?>  
          <?php if(!empty($respond['view'])) { ?>
            <button class="btn flat btn-dark btn-sm py-1 px-2" data-toggle="modal" data-target="<?php echo $respond['view']; ?>"><span class="material-icons align-text-top md-20">visibility</span></button>
          <?php } ?>      
        </div>
      </div>
    </div> 

    <?php if(!empty($_SESSION['msg_success'])){ ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong>  <?php echo $_SESSION['msg_success']; ?> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" class="material-icons md-18">clear</span>
        </button>
      </div>
    <?php } ?>    

    <?php if(!empty($_SESSION['msg_error'])){ ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Warning!</strong>  <?php echo $_SESSION['msg_error']; ?> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" class="material-icons md-18">clear</span>
        </button>
      </div>
    <?php } ?>