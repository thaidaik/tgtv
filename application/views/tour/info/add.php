<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                Quản lý Tour
            </a>
        </li>
        <li class="active">
            <a href="#">Tạo mới Tour</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            <?php echo $this->config->item('text_adding'); ?> Tour
        </h2>
    </div>
    <?php
    //flash messages
    if(isset($flash_message)){
        if($flash_message == TRUE)
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
        $color_table = $this->config->item('color_table');
        //form validation
        echo validation_errors();
        $attributes = array('class' => 'form-signin');
        echo form_open_multipart('tour/info/add', $attributes);

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">'.$this->config->item('text_image').'</label>';
        echo form_upload('tour_image', set_value('tour_image'), 'placeholder="Image" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_code">Tour Code</label>';
        echo form_input('tour_code', set_value('tour_code'), 'placeholder="Tour Code" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_name">Tour Name</label>';
        echo form_input('tour_name', set_value('tour_name'), 'placeholder="Tour Name" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="phone">Số ngày đi tour</label>';
        echo form_input('tour_duration', set_value('tour_duration'), 'placeholder="Số ngày đi tour" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="departs">Giờ khởi hành</label>';
        echo '<div class="input-group timepicker">';
        echo form_input('departs', set_value('departs'), 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="group_size">Số khách sẽ nhận</label>';
        echo form_input('group_size', set_value('group_size'), 'placeholder="group_size" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tourtour_description_gift">Mô tả tóm tắt Tour</label>';
        echo form_textarea('tour_description', set_value('tour_description'), 'placeholder="Mô tả tóm tắt Tour" class="form-control"');
        echo '</div>';

        echo '</div>';
        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">Chọn tuyến tham quan</label>';
        echo form_multiselect('location_link[]', $field_tour_location, '1', 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="start_date">Ngày khởi hành</label>';
        echo '<div class="input-group datepicker">';
        echo form_input('start_date', set_value('start_date'), 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="flight">Chuyến bay</label>';
        echo form_input('flight', set_value('flight'), 'placeholder="flight" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_gift">Quà tặng khuyến mãi</label>';
        echo form_input('tour_gift', set_value('tour_gift'), 'placeholder="tour_gift" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_price">Giá Tour</label>';
        echo form_input('tour_price', set_value('tour_price'), 'placeholder="Giá Tour" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_price_min">Giá Tour thấp nhất</label>';
        echo form_input('tour_price_min', set_value('tour_price_min'), 'placeholder="Giá thấp nhất" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_gift">Thông tin hướng dẫn viên</label>';
        echo form_input('tour_guide_info', set_value('tour_guide_info'), 'placeholder="Thông tin hướng dẫn viên" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_color">Select Color</label>';
        echo form_dropdown('tour_color', $color_table, set_value('tour_color'), 'class="form-control"');
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
