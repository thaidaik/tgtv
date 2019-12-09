<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="#">
                <?php echo ucfirst($this->uri->segment(1));?>
            </a>
        </li>
        <li>
            <a href="<?php echo site_url("tour").'/'.$this->uri->segment(2); ?>">
                Danh sách Tour
            </a>
        </li>
        <li class="active">
            <a href="#">Cập nhật thông tin Tour</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            <?php echo $this->config->item('text_updating'); ?> Thông tin Tour
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
        $color_table = $this->config->item('color_table');
        $start_date = $tour_info_data['0']['start_date'];
        $startdate = date("d-m-Y", strtotime($start_date));
        foreach ($tour_location_link as $value){
            $tour_location[] = $value->tour_location_id;
        }

        //form validation
        echo validation_errors();
        $attributes = array('class' => 'form-signin');
        echo form_open_multipart('tour/info/update/'.$this->uri->segment(4), $attributes);

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">'.$this->config->item('text_image').'</label>';
        echo form_upload('tour_image', $tour_info_data[0]['tour_image'], 'placeholder="Image" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_code">Tour Code</label>';
        echo form_input('tour_code', $tour_info_data[0]['tour_code'], 'placeholder="tour_code" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_name">Tour Name</label>';
        echo form_input('tour_name', $tour_info_data[0]['tour_name'], 'placeholder="tour_name" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="phone">Số ngày đi tour</label>';
        echo form_input('tour_duration', $tour_info_data[0]['tour_duration'], 'placeholder="Số ngày đi tour" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="departs">Giờ khởi hành</label>';
        echo '<div class="input-group timepicker">';
        echo form_input('departs', $tour_info_data[0]['departs'], 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="group_size">Số khách sẽ nhận</label>';
        echo form_input('group_size', $tour_info_data[0]['group_size'], 'placeholder="Số khách sẽ nhận" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tourtour_description_gift">Mô tả tóm tắt Tour</label>';
        echo form_textarea('tour_description', $tour_info_data[0]['tour_description'], 'placeholder="Mô tả tóm tắt Tour" class="form-control editor"');
        echo '</div>';

        echo '</div>';
        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">Chọn tuyến tham quan</label>';
        echo form_multiselect('location_link[]', $field_tour_location, $tour_location, 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="start_date">Ngày khởi hành</label>';
        echo '<div class="input-group datepicker">';
        echo form_input('start_date', $startdate, 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="flight">Chuyến bay</label>';
        echo form_input('flight', $tour_info_data[0]['flight'], 'placeholder="flight" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_gift">Quà tặng khuyến mãi</label>';
        echo form_input('tour_gift', $tour_info_data[0]['tour_gift'], 'placeholder="Quà tặng khuyến mãi" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_price">Giá Tour</label>';
        echo form_input('tour_price', $tour_info_data[0]['tour_price'], 'placeholder="Giá Tour" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_price_min">Giá Tour thấp nhất</label>';
        echo form_input('tour_price_min', $tour_info_data[0]['tour_price_min'], 'placeholder="Giá thấp nhất" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_gift">Thông tin hướng dẫn viên</label>';
        echo form_input('tour_guide_info', $tour_info_data[0]['tour_guide_info'], 'placeholder="Thông tin hướng dẫn viên" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_color">Select Color</label>';
        echo form_dropdown('tour_color', $color_table, $tour_info_data[0]['tour_color'], 'class="form-control"');
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
    <!-- Script -->
    <script>
        tinymce.init({
            selector:'.editor',
            theme: 'silver',
        });
    </script>
</div>
