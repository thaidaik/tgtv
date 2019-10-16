<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("guest"); ?>">
                <?php echo ucfirst($this->uri->segment(1));?>
            </a>
        </li>
        <li>
            <a href="<?php echo site_url("guest").'/'.$this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2));?>
            </a>
        </li>
        <li class="active">
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
    </div>
    <?php
    //flash messages
    if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo $this->config->item('text_add_well_done_1').'New location'.$this->config->item('text_add_well_done_2');
            echo '</div>';
        }else{
            echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo $this->config->item('text_add_alert');
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
        $guest_birthday = $guest_info_data['0']['guest_birthday'];
        $guestbirthday = date("d-m-Y", strtotime($guest_birthday));
        //form validation
        echo validation_errors();
        $attributes = array('class' => 'form-signin');
        echo form_open_multipart('guest/info/update/'.$this->uri->segment(4), $attributes);

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">Image</label>';
        echo form_upload('tour_image', $guest_info_data['0']['guest_images'], 'placeholder="Image" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_name">guest_name</label>';
        echo form_input('guest_name', $guest_info_data['0']['guest_name'], 'placeholder="guest_name" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_sex">Sex</label>';
        echo form_dropdown('guest_sex', $user_sex, $guest_info_data['0']['guest_sex'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_phone">guest_phone</label>';
        echo form_input('guest_phone', $guest_info_data['0']['guest_phone'], 'placeholder="guest_phone" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_address">guest_address</label>';
        echo form_input('guest_address', $guest_info_data['0']['guest_address'], 'placeholder="guest_address" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_s_type">guest_s_type</label>';
        echo form_dropdown('guest_s_type', $arr_guest_s_type, $guest_info_data['0']['guest_s_type'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_s_visa">guest_s_visa</label>';
        echo form_dropdown('guest_s_visa', $arr_guest_s_visa, $guest_info_data['0']['guest_s_visa'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_s_pay">guest_s_group</label>';
        echo form_dropdown('guest_s_group', $arr_guest_s_group, $guest_info_data['0']['guest_s_group'], 'class="form-control"');
        echo '</div>';
        echo '</div>';

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="guest_email">guest_email</label>';
        echo form_input('guest_email', $guest_info_data['0']['guest_email'], 'placeholder="guest_email" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_birthday">guest_birthday</label><div class="input-group datepicker">';
        echo form_input('guest_birthday', $guestbirthday, 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div></div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_cmnd">guest_cmnd</label>';
        echo form_input('guest_cmnd', $guest_info_data['0']['guest_cmnd'], 'placeholder="guest_cmnd" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_passport">guest_passport</label>';
        echo form_input('guest_passport', $guest_info_data['0']['guest_passport'], 'placeholder="guest_passport" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_country">guest_country</label>';
        echo form_input('guest_country', $guest_info_data['0']['guest_country'], 'placeholder="guest_country" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_power">guest_power</label>';
        echo form_dropdown('guest_power', $arr_guest_power, $guest_info_data['0']['guest_power'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_com_location">guest_com_location</label>';
        echo form_dropdown('guest_com_location', $arr_guest_com_location, $guest_info_data['0']['guest_com_location'], 'class="form-control"');
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
