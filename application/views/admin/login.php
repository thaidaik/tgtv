<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title>CodeIgniter Admin Sample Project</title>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container login">
      <?php 
      $attributes = array('class' => 'form-signin');
      echo form_open('admin/login/validate_credentials', $attributes);
      echo '<h2 class="form-signin-heading">Login</h2>';
      echo form_input('user_name', '', 'placeholder="Username" class="form-control"');
      echo form_password('password', '', 'placeholder="Password" class="form-control"');
      if(isset($message_error) && $message_error){
          echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
          echo '</div>';             
      }
      //echo anchor('admin/signup', 'Signup!');
      echo form_submit('submit', 'Login', 'class="btn btn-large btn-primary"');
      echo form_close();
      ?>      
    </div><!--container-->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/admin.min.js"></script>
  </body>
</html>    
