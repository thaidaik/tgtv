<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1));?>
            </a>
        </li>
        <li class="active">
            <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
                Tạo mới nhân viên
            </a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            <?php echo $this->config->item('text_adding'); ?> nhân viên
        </h2>
    </div>
    <div class="row">

    <?php
    $user_sex = $this->config->item('user_sex');
    //$user_role = $this->config->item('user_role');
    $options_role = array('' => $this->config->item('text_select'));
    foreach ($roles as $row)
    {
        $options_role[$row['id']] = $row['name'];
    }
    //form validation
    echo validation_errors();
    $attributes = array('class' => 'form-signin');
    echo form_open_multipart('admin/create_member', $attributes);
    echo '<div class="col-sm-6">';
    echo '<div class="control-group"><label class="control-label required" for="image">'.$this->config->item('text_image').'</label>';
    echo form_upload('image', set_value('image'), 'placeholder="Image" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="username">'.$this->config->item('text_username').'</label>';
    echo form_input('username', set_value('username'), 'placeholder="Username" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="name">'.$this->config->item('text_name').'</label>';
    echo form_input('first_name', set_value('first_name'), 'placeholder="Name" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="email">Email</label>';
    echo form_input('email_address', set_value('email_address'), 'placeholder="Email" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="sex">'.$this->config->item('text_sex').'</label>';
    echo form_dropdown('sex', $user_sex, set_value('sex'), 'class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="address">'.$this->config->item('text_address').'</label>';
    echo form_input('address', set_value('address'), 'placeholder="Address" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="phone">Phone</label>';
    echo form_input('phone', set_value('phone'), 'placeholder="Phone" class="form-control"');
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-6">';
    echo '<div class="control-group"><label class="control-label required" for="birthday">'.$this->config->item('text_birthday').'</label>';
    echo '<div class="input-group datepicker">';
    echo form_input('birthday', set_value('birthday'), 'class="form-control" readonly');
    echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
    echo '</div>';
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="identificatio">'.$this->config->item('text_identificatio').'</label>';
    echo form_input('identificatio_id', set_value('identificatio_id'), 'placeholder="Identificatio ID" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="passport">'.$this->config->item('text_passport').'</label>';
    echo form_input('passport', set_value('passport'), 'placeholder="Passport" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="color">Select Color</label>';
    echo form_input('color', set_value('color'), 'placeholder="FFFFFF" class="form-control jscolor"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="role">'.$this->config->item('text_role').'</label>';
    echo form_dropdown('role', $options_role, set_value('role'), 'class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="password">Password</label>';
    echo form_password('password', '', 'placeholder="Password" class="form-control"');
    echo '</div>';
    echo '<div class="control-group"><label class="control-label required" for="password2">Password confirm</label>';
    echo form_password('password2', '', 'placeholder="Password confirm" class="form-control"');
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-sm-6">';
    echo form_submit('submit', 'submit', 'class="btn btn-large btn-primary"');
    echo form_close();
    echo '</div>';
?>
    </div>
</div>
