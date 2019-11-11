<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
            </a>
        </li>
        <li>
            <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">Quản lý nhóm nhân viên</a>
        </li>
        <li class="active">
            <a href="#">Sửa nhóm nhân viên</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
        <?php echo $this->config->item('text_updating'); ?>  nhóm nhân viên
        </h2>
    </div>


    <?php
    //flash messages
    if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> Role updated with success.';
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
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <?php
            //form data
            $attributes = array('class' => 'form-horizontal', 'id' => '');

            //form validation
            echo validation_errors();

            echo form_open('admin/role/update/'.$this->uri->segment(4).'', $attributes);
            ?>
            <fieldset>
                <div class="control-group">
                    <label for="inputError" class="control-label">Tên nhóm nhân viên</label>
                    <div class="controls">
                    <input type="text" id="" name="name" value="<?php echo $manufacture[0]['name']; ?>" class="form-control">
                    <!--<span class="help-inline">Woohoo!</span>-->
                    </div>
                </div>
                <br/>
                <div class="control-group">
                    <button class="btn btn-primary" type="submit"><?php echo $this->config->item('text_save_changes'); ?></button>
                    <button class="btn" type="reset"><?php echo $this->config->item('text_cancel'); ?></button>
                </div>
            </fieldset>

            <?php echo form_close(); ?>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
