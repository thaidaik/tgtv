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
            echo '<div class="alert alert-danger">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo $this->config->item('text_add_alert');
            echo '</div>';
        }
    }
    ?>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <?php
            //form data
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            //form validation
            echo validation_errors();
            echo form_open('tour/location/add', $attributes);
            $tour_continent = $this->config->item('tour_continent');
            ?>
            <fieldset>
                <div class="control-group">
                    <label for="inputError" class="control-label">Country</label>
                    <div class="controls">
                        <input type="text" id="" name="country" value="<?php echo set_value('country'); ?>" class="form-control">
                        <!--<span class="help-inline">Woohoo!</span>-->
                    </div>
                </div>
                <div class="control-group">
                    <label for="inputError" class="control-label">Continent</label>
                        <?php echo form_dropdown('continent', $tour_continent, set_value('europe'), 'class="form-control"'); ?>
                </div>
                <div class="form-actions block-fix">
                    <button class="btn btn-primary" type="submit"><?php echo $this->config->item('text_save_changes'); ?></button>
                    <button class="btn" type="reset"><?php echo $this->config->item('text_cancel'); ?></button>
                </div>
            </fieldset>
            <?php echo form_close(); ?>
        </div>
        <div class="col-sm-2"></div>
    </div>
