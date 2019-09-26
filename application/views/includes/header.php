<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>TGTV</title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">TGTV</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" >User <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php if($this->uri->segment(2) == 'signup'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>admin/signup">New User</a>
                            </li>
                            <li <?php if($this->uri->segment(2) == 'list'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>admin/list">List User</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li <?php if($this->uri->segment(2) == 'role'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>admin/role">List Role</a>
                            </li>
                        </ul>
                    </li>

                    <li <?php if($this->uri->segment(2) == 'tour'){echo 'class="active"';}?>>
                        <a href="<?php echo base_url(); ?>tour/list">List tour</a>
                    </li>
                    <li <?php if($this->uri->segment(2) == 'customer'){echo 'class="active"';}?>>
                        <a href="<?php echo base_url(); ?>customer/list">List customer</a>
                    </li>
                    <li <?php if($this->uri->segment(2) == 'signup'){echo 'class="active"';}?>>
                        <a href="<?php echo base_url(); ?>admin/signup">Sign up</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" >Profile <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php if($this->uri->segment(2) == 'edit_member'){echo 'class="active"';}?>><a href="<?php echo base_url(); ?>admin/edit_member/<?php echo $this->session->userdata('user_id');?>">Edit Profile</a></li>
                            <li><a href="<?php echo base_url(); ?>admin/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
