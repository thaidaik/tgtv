<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1));?>
            </a>
        </li>
        <li>
            <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2));?>
            </a>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Thêm mới nhân viên
        </h2>
    </div>

    <?php
    //flash messages
    if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> product updated with success.';
            echo '</div>';
        }else{
            echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    ?>
    <div class="row">
    <?php
    //form validation
    echo validation_errors();
    $attributes = array('class' => 'form-signin');
    echo form_open_multipart('admin/edit_member/'.$this->uri->segment(3).'', $attributes);
    $user_sex = $this->config->item('user_sex');
    $user_block = $this->config->item('user_block');
    //$user_role = $this->config->item('user_role');
    $options_role = array('' => $this->config->item('text_select'));
    foreach ($roles as $row)
    {
        $options_role[$row['id']] = $row['name'];
    }

    $bdate = $member['0']['birthday'];
    $birthday = date("d-m-Y", strtotime($bdate));
    ?>
    <div class="col-sm-6">
    <div class="control-group"><label class="control-label required" for="image"><?php echo $this->config->item('text_image'); ?></label>
        <input type="file" name="image" value="" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="username"><?php echo $this->config->item('text_username'); ?></label>
        <input type="text" name="username" value="<?php echo $member['0']['user_name']; ?>" placeholder="Username" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="name"><?php echo $this->config->item('text_name'); ?></label>
        <input type="text" name="first_name" value="<?php echo $member['0']['first_name']; ?>" placeholder="Name" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="email">Email</label>
        <input type="text" name="email_address" value="<?php echo $member['0']['email_address']; ?>" placeholder="Email" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="sex"><?php echo $this->config->item('text_sex'); ?></label>
        <?php echo form_dropdown('sex', $user_sex, $member['0']['sex'], 'class="form-control"'); ?>
    </div>
    <div class="control-group"><label class="control-label required" for="address"><?php echo $this->config->item('text_address'); ?></label>
        <input type="text" name="address" value="<?php echo $member['0']['address']; ?>" placeholder="Address" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="sex"><?php echo $this->config->item('text_block_select'); ?></label>
        <?php echo form_dropdown('block', $user_block, $member['0']['block'], 'class="form-control"'); ?>
    </div>
    </div>
        <div class="col-sm-6">
    <div class="control-group"><label class="control-label required" for="phone">Phone</label>
        <input type="text" name="phone" value="<?php echo $member['0']['phone']; ?>" placeholder="Phone" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="birthday"><?php echo $this->config->item('text_birthday'); ?></label>
        <div class="input-group datepicker">
        <input type="text" name="birthday" value="<?php echo $birthday; ?>" class="form-control" readonly=""><span class="input-group-addon"><span class="fa fa-calendar"></span></span>
        </div>
    </div>
    <div class="control-group"><label class="control-label required" for="identificatio"><?php echo $this->config->item('text_identificatio'); ?></label>
        <input type="text" name="identificatio_id" value="<?php echo $member['0']['identificatio_id']; ?>" placeholder="Identificatio ID" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="passport"><?php echo $this->config->item('text_passport'); ?></label>
        <input type="text" name="passport" value="<?php echo $member['0']['passport']; ?>" placeholder="Passport" class="form-control">
    </div>
    <div class="control-group"><label class="control-label required" for="color">Select Color</label>
        <input type="text" name="color" value="" class="form-control jscolor" style="background-color: <?php echo $member['0']['color']; ?>;">
    </div>
    <?php
    if($member['0']['role'] != '1704'): ?>
    <div class="control-group"><label class="control-label required" for="role"><?php echo $this->config->item('text_role'); ?></label>
        <?php echo form_dropdown('role', $options_role, $member['0']['role'], 'class="form-control"'); ?>
    </div>
    <?php else: ?>
        <input type="hidden" name="role" value="<?php echo $member['0']['role']; ?>" >
    <?php endif;?>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
        <input type="submit" name="submit" value="submit" class="btn btn-large btn-primary"></form>
        </div>
    </div>
    <?php
    echo form_close();
    ?>
</div>

