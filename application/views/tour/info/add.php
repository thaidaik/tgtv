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
            Adding <?php echo ucfirst($this->uri->segment(2));?>
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
            echo '<div class="alert alert-error">';
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
        echo '<div class="control-group"><label class="control-label required" for="tour_image">Image</label>';
        echo form_upload('tour_image', set_value('tour_image'), 'placeholder="Image" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_code">Tour Code</label>';
        echo form_input('tour_code', set_value('tour_code'), 'placeholder="tour_code" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_name">Tour Name</label>';
        echo form_input('tour_name', set_value('tour_name'), 'placeholder="tour_name" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="phone">Tour Duraction</label>';
        echo form_input('tour_duration', set_value('tour_duration'), 'placeholder="tour_duration" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="group_size">Group Size</label>';
        echo form_input('group_size', set_value('group_size'), 'placeholder="group_size" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tourtour_description_gift">Tour Description</label>';
        echo form_textarea('tour_description', set_value('tour_description'), 'placeholder="tour_description" class="form-control"');
        echo '</div>';

        echo '</div>';
        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="tour_image">Select Location</label>';
        echo form_multiselect('location_link[]', $field_tour_location, '1', 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="start_date">Start Date</label>';
        echo '<div class="input-group datepicker">';
        echo form_input('start_date', set_value('start_date'), 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_gift">Tour Gift</label>';
        echo form_input('tour_gift', set_value('tour_gift'), 'placeholder="tour_gift" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_price">Tour Price</label>';
        echo form_input('tour_price', set_value('tour_price'), 'placeholder="tour_price" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_price_min">Tour Price Min</label>';
        echo form_input('tour_price_min', set_value('tour_price_min'), 'placeholder="tour_price_min" class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="tour_gift">Tour Guide Info</label>';
        echo form_input('tour_guide_info', set_value('tour_guide_info'), 'placeholder="tour_guide_info" class="form-control"');
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
