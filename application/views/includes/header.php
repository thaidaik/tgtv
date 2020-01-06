<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>TGTV</title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  <script src='<?php echo base_url(); ?>resources/tinymce/tinymce.min.js'></script>
</head>
<body>
    <nav class="navbar navbar-inverse main-menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">TG Travel Application</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown <?php if($this->uri->segment(1) == 'admin'){echo ' active';}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-users" aria-hidden="true"></i> Quản lý nhân viên <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php if($this->uri->segment(2) == 'signup'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>admin/signup">Tạo nhân viên mới</a>
                            </li>
                            <li <?php if($this->uri->segment(2) == 'list'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>admin/list">Danh sách nhân viên</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li <?php if($this->uri->segment(2) == 'role'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>admin/role">Danh sách nhóm</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown <?php if($this->uri->segment(1) == 'tour'){echo ' active';}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-paper-plane" aria-hidden="true"></i> Quản lý Tour <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php if($this->uri->segment(1) == 'tour' && $this->uri->segment(2) == 'info' && $this->uri->segment(3) == ''){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>tour/info">Danh sách Tour</a>
                            </li>
                            <li <?php if($this->uri->segment(1) == 'tour' && $this->uri->segment(2) == 'info' && $this->uri->segment(3) == 'add'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>tour/info/add">Thêm mới Tour</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li <?php if($this->uri->segment(1) == 'tour' && $this->uri->segment(2) == 'location'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>tour/location">Danh sách điểm tham quan</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown <?php if($this->uri->segment(1) == 'guest'){echo ' active';}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-address-card-o" aria-hidden="true"></i> Quản lý khách hàng <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php if($this->uri->segment(1) == 'guest' && $this->uri->segment(2) == 'info' && $this->uri->segment(3) == ''){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>guest/info">Danh sách khách hàng</a>
                            </li>
                            <li <?php if($this->uri->segment(1) == 'guest' && $this->uri->segment(2) == 'info' && $this->uri->segment(3) == 'add'){echo 'class="active"';}?>>
                                <a href="<?php echo base_url(); ?>guest/info/add">Thêm mới khách hàng</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" ><i class="fa fa-cog" aria-hidden="true"></i> Profile <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php if($this->uri->segment(2) == 'edit_member'){echo 'class="active"';}?>><a href="<?php echo base_url(); ?>admin/edit_member/<?php echo $this->session->userdata('user_id');?>">Edit Profile</a></li>
                            <li><a href="<?php echo base_url(); ?>admin/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
