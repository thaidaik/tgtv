<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("guest"); ?>">
                Khách hàng
            </a>
        </li>
        <li>
            <a href="<?php echo site_url("guest").'/'.$this->uri->segment(2); ?>">
                Danh sách khách hàng
            </a>
        </li>
        <li class="active">
            <a href="#">Tạo mới</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            <?php echo $this->config->item('text_adding'); ?> Khách hàng
        </h2>
    </div>
    <?php
    //flash messages
    if(isset($flash_message)){
        if($flash_message == TRUE)
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo $this->config->item('text_add_well_done_1').'New Guest'.$this->config->item('text_add_well_done_2');
            echo '</div>';
        }else{
            echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo $this->config->item('text_add_alert');
            echo '</div>';
        }
    }
    if(isset($error_upload)){
        if($error_upload != '')
        {
            echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo $error_upload;
            echo '</div>';
        }
    }
    ?>
    <div class="row">

        <?php
        $user_sex = $this->config->item('user_sex');
        $arr_guest_s_type = $this->config->item('guest_s_type');
        $arr_guest_s_visa = $this->config->item('guest_s_visa');
        $arr_guest_s_group = $this->config->item('guest_s_group');
        $arr_guest_power = $this->config->item('guest_power');
        $arr_guest_com_location = $this->config->item('guest_com_location');
        //form validation
        echo validation_errors();
        $attributes = array('class' => 'form-signin');
        echo form_open_multipart('guest/info/add', $attributes);

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">'.$this->config->item('text_image').'</label>';
        echo form_upload('tour_image', set_value('tour_image'), 'placeholder="Image" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_name">Họ và Tên</label>';
        echo form_input('guest_name', set_value('guest_name'), 'placeholder="Họ và Tên" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="sex">'.$this->config->item('text_sex').'</label>';
        echo form_dropdown('sex', $user_sex, set_value('sex'), 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_phone">Phone</label>';
        echo form_input('guest_phone', set_value('guest_phone'), 'placeholder="Phone" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_address">Địa chỉ</label>';
        echo form_input('guest_address', set_value('guest_address'), 'placeholder="Địa chỉ" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_s_type">Nhóm khách hàng</label>';
        echo form_dropdown('guest_s_type', $arr_guest_s_type, set_value('guest_s_type'), 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_s_visa">Visa</label>';
        echo form_dropdown('guest_s_visa', $arr_guest_s_visa, set_value('guest_s_visa'), 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_s_pay">Khách đi cùng</label>';
        echo form_dropdown('guest_s_group', $arr_guest_s_group, set_value('guest_s_group'), 'class="form-control"');
        echo '</div>';
        echo '</div>';

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="guest_email">Email</label>';
        echo form_input('guest_email', set_value('guest_email'), 'placeholder="Email" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_birthday">Ngày sinh</label><div class="input-group datepicker">';
        echo form_input('guest_birthday', set_value('guest_birthday'), 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div></div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_cmnd">CMND</label>';
        echo form_input('guest_cmnd', set_value('guest_cmnd'), 'placeholder="CMND" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_passport">Hộ Chiếu</label>';
        echo form_input('guest_passport', set_value('guest_passport'), 'placeholder="Pass port" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_country">Nguyên quán</label>';
        echo form_input('guest_country', set_value('guest_country'), 'placeholder="Nguyên quán" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_power">Đánh giá tài chính</label>';
        echo form_dropdown('guest_power', $arr_guest_power, set_value('guest_power'), 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_com_location">Vị trí nghề nghiệp</label>';
        echo form_dropdown('guest_com_location', $arr_guest_com_location, set_value('guest_com_location'), 'class="form-control"');
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
