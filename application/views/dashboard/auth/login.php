<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta name="description" content="<?php echo $respond['description']; ?>">
    <meta name="author" content="<?php echo $respond['author']; ?>">    
    <link rel="shortcut icon" href="<?php echo base_url("upload/favicon.ico")?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('upload/favicon.ico'); ?>" type="image/x-icon">    
    <!-- Meta, title, CSS, favicons, etc. -->
    <link href="<?php echo base_url('asset/admin/css/pages/login.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/admin/css/fonts.css'); ?>" rel="stylesheet">
    <title><?php echo $title; ?> - P.K.T Education Center</title>
  </head>
  <body>
  <section class="wrapper">
    <div class="login">
      <div class="form mr-auto ml-auto">
        <img src="<?php echo base_url('asset/admin/images/pkt.png'); ?>" class="adm-logo" alt="pkt education logo">
        <h3 class="head">Sign In to Your Account</h3>
        <?php echo form_open($action); ?>
        <div class="form-group">
          <?php
            $data = array(
              'name'  => 'token',
              'type' => 'hidden',
              'value' => $respond['token']
            );
            echo form_input($data);
          ?>
          <?php
            $data = array(
              'name'  => 'slug',
              'type' => 'hidden',
              'value' => $respond['slug']
            );
            echo form_input($data);
          ?>
          <?php
            echo form_label('User Name','user_name', array('class' => 'col-form-label'));
          ?>
          <?php
            $data = array(
              'name'  => 'user_name',
              'type' => 'text',
              'placeholder' => '',
              'class' => 'form-custom',
              'id' => 'InputEmail',
              'autocomplete' => "new-user_name",
            );
            echo form_input($data);
          ?>
        </div>
        <div class="form-group">
          <?php
            echo form_label('Password','user_password', array('class' => 'col-form-label'));
          ?>
          <?php
            $data = array(
              'name'  => 'user_password',
              'type' => 'password',
              'placeholder' => '',
              'class' => 'form-custom',
              'id' => 'InputPassword',
              'autocomplete' => "new-user_password",
            );
            echo form_input($data);
          ?>
        </div>
        <button type="submit" class="btn mt-4 btn-block" style="color: #fff;background-color: #c62d29;border-color: #c62d29;width: 80%;margin: 0 auto;border-radius: 0px; display:block; text-align:center;">Login</button>
        <?php echo form_close(); ?>
        <?php if(!empty($_SESSION['msg_error'])){ ?>
          <div style="text-align: center;margin-top: 20px;color: #f00;"><?php echo $_SESSION['msg_error']; ?></div>
        <?php } ?>
      </div>
    </div>    
    </section>
  </body>
</html>
