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
          <?php echo $this->config->item('text_adding'); ?> <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
        </div>

        <?php
        //flash messages
        if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> new product created with success.';
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
            <div class="col-md-6 col-xs-12">
            <?php
        //form data
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        $options_manufacture = array('' => $this->config->item('text_select'));
        foreach ($manufactures as $row)
        {
        $options_manufacture[$row['id']] = $row['name'];
        }

        //form validation
        echo validation_errors();

        echo form_open('admin/products/add', $attributes);
        ?>
            <fieldset>
                <div class="control-group row">
                    <div class="col-md-3 col-xs-12">
                        <label for="inputError" class="control-label">Description</label>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <div class="controls">
                        <input type="text" id="" class="form-control" name="description" value="<?php echo set_value('description'); ?>" >
                        </div>
                    </div>
                </div>
                <div class="control-group row">
                    <div class="col-md-3 col-xs-12">
                        <label for="inputError" class="control-label">Stock</label>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <div class="controls">
                        <input type="text" id="" class="form-control" name="stock" value="<?php echo set_value('stock'); ?>">
                        </div>
                    </div>
                </div>
                <div class="control-group row">
                    <div class="col-md-3 col-xs-12">
                    <label for="inputError" class="control-label">Cost Price</label>
                    <div class="controls">
                        <input type="text" id="" class="form-control" name="cost_price" value="<?php echo set_value('cost_price'); ?>">
                    </div>
                </div>
                </div>
                <div class="control-group row">
                    <label for="inputError" class="control-label">Sell Price</label>
                    <div class="controls">
                    <input type="text" class="form-control" name="sell_price" value="<?php echo set_value('sell_price'); ?>">
                    <!--<span class="help-inline">OOps</span>-->
                    </div>
                </div>
                <?php
                echo '<div class="control-group row">';
                echo '<label for="manufacture_id" class="control-label">Manufacture</label>';
                echo '<div class="controls">';
                //echo form_dropdown('manufacture_id', $options_manufacture, '', 'class="span2"');
                echo form_dropdown('manufacture_id', $options_manufacture, set_value('manufacture_id'), 'class="form-control"');
                echo '</div>';
                echo '</div">';
                ?>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit"><?php echo $this->config->item('text_save_changes'); ?></button>
                    <button class="btn" type="reset"><?php echo $this->config->item('text_cancel'); ?></button>
                </div>
            </fieldset>
            <?php echo form_close(); ?>
            </div>
        </div>
    </div>
     