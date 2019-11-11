<div class="container top">

    <div class="page-header">
        <h2>
            Guest Information
        </h2>
    </div>
    <?php
    $this->load->helper('true_function');
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

    $user_sex_text = $this->config->item('user_sex_text');
    $sex_show = '';
    if(isset($user_sex_text[$guest_info_data['0']['guest_sex']]) && count($user_sex_text[$guest_info_data['0']['guest_sex']])){
        $sex_show = $user_sex_text[$guest_info_data['0']['guest_sex']];
    }
    $guest_birthday = $guest_info_data['0']['guest_birthday'];
    $guest_birthdays = date("d-m-Y", strtotime($guest_birthday));


    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<div class="row bottom-block"><label>Guest Name: </label>'.$sex_show.' '.$guest_info_data['0']['guest_name'].'</div>';
    echo '<div class="row bottom-block"><label>Guest Phone: </label>'.$guest_info_data['0']['guest_phone'].' days</div>';
    echo '<div class="row bottom-block"><label>Guest Adress: </label>'.$guest_info_data['0']['guest_address'].'</div>';
    echo '<div class="row bottom-block"><label>Guest Email: </label>'.$guest_info_data['0']['guest_email'].'</div>';
    echo '</div>';
    echo '<div class="col-md-6">';
    echo '<div class="row bottom-block"><label>Guest Birthday: </label>'.$guest_birthdays.'</div>';
    echo '<div class="row bottom-block"><label>Guest ID: </label>'.$guest_info_data['0']['guest_cmnd'].'</div>';
    echo '<div class="row bottom-block"><label>Guest Passport: </label>'.$guest_info_data['0']['guest_passport'].'</div>';
    echo '<div class="row bottom-block"><label>Guest Country: </label>'.$guest_info_data['0']['guest_country'].'</div>';
    echo '</div>';
    echo '</div>';
    echo '<hr class="style1">';

    if(isset($guest_sale_tour_info_data)){ ?>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="">Guest name</th>
                <th class="">Tour name</th>
                <th class="">Sale name</th>
                <th class="">Update Payment</th>
                <th class="">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($guest_sale_tour_info_data as $row)
            {
                $select_date = checkDateData($row['start_date']);
                echo '<tr>';
                echo '<td>'.$row['guest_name'].'</td>';
                echo '<td>'.$row['tour_name'].'</td>';
                echo '<td>'.$row['user_name'].'</td>';
                echo '<td><a href="'.site_url("guest").'/add/payment/'.$this->uri->segment(4).'/'.$row['guest_tour_link_id'].'" class="btn btn-success">Update Payment</a></td>';
                echo '<td class="crud-actions">
                  <a href="'.site_url("guest").'/link/tour/'.$this->uri->segment(4).'/'.$select_date.'/'.$row['guest_tour_link_id'].'" class="btn btn-info">'.$this->config->item('text_edit').'</a>  
                </td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <hr class="style1">
    <?php
    }

    ?>
    <div class="page-header">
        <h2>
            <?php
            if(isset($get_guest_tour_sale_data) && count($get_guest_tour_sale_data)){
                echo 'Edit Sale and Tour';
            }else{
                echo $this->config->item('text_adding').' Data To Guest';
            }
            ?>

        </h2>
    </div>
    <div class="row">

        <?php

        //form validation
        echo validation_errors();
        $attributes = array('class' => 'form-signin');
        if(isset($get_guest_tour_sale_data) && count($get_guest_tour_sale_data)){
            echo form_open_multipart('guest/link/tour/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6), $attributes);
            $select_sale = $get_guest_tour_sale_data[0]['user_id'];
            $select_tour = $get_guest_tour_sale_data[0]['tour_id'];
        }else{
            echo form_open_multipart('guest/link/tour/'.$this->uri->segment(4).'/'.$this->uri->segment(5), $attributes);
            $select_sale = null;
            $select_tour = null;
        }

        echo '<div class="col-sm-12">';

        echo '<div class="control-group"><label class="control-label required bottom-block" for="sale_id">Select Sale</label>';
        echo form_dropdown('sale_id', $all_users, $select_sale, 'class="form-control"');
        echo '</div>'; ?>
        <div class="control-group"><label class="control-label required" for="sale_id">Choose Tour</label></div>
        <ul class="nav nav-tabs">
                <li <?php if($this->uri->segment(5) == 'mnow' || $this->uri->segment(5) == ''){echo 'class="active"';}?> >
                    <a href="<?php echo site_url("guest").'/link/tour/'.$this->uri->segment(4).'/mnow'; if(isset($get_guest_tour_sale_data) && count($get_guest_tour_sale_data)){echo '/'.$this->uri->segment(6);} ?>"><?php echo date('m/Y');?></a></li>
                <li <?php if($this->uri->segment(5) == 'mnowst'){echo 'class="active"';}?> >
                    <a href="<?php echo site_url("guest").'/link/tour/'.$this->uri->segment(4).'/mnowst'; if(isset($get_guest_tour_sale_data) && count($get_guest_tour_sale_data)){echo '/'.$this->uri->segment(6);}?>"><?php echo $date = date('m/Y', strtotime('+1 month', strtotime(date("Y-m-01")))); ?></a></li>
                <li <?php if($this->uri->segment(5) == 'mnownd'){echo 'class="active"';}?> >
                    <a href="<?php echo site_url("guest").'/link/tour/'.$this->uri->segment(4).'/mnownd'; if(isset($get_guest_tour_sale_data) && count($get_guest_tour_sale_data)){echo '/'.$this->uri->segment(6);}?>"><?php echo $date = date('m/Y', strtotime('+2 month', strtotime(date("Y-m-01")))); ?></a></li>
                <li <?php if($this->uri->segment(5) == 'mnowrd'){echo 'class="active"';}?> >
                    <a href="<?php echo site_url("guest").'/link/tour/'.$this->uri->segment(4).'/mnowrd'; if(isset($get_guest_tour_sale_data) && count($get_guest_tour_sale_data)){echo '/'.$this->uri->segment(6);}?>"><?php echo $date = date('m/Y', strtotime('+3 month', strtotime(date("Y-m-01")))); ?></a></li>
            </ul>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="">#</th>
                <th class="">Code</th>
                <th class=""><?php echo $this->config->item('text_name'); ?></th>
                <th class="">Price</th>
                <th class="">Duration</th>
                <th class="">Size</th>
                <th class="">Start Date</th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach($tour_infos as $row)
            {
                echo '<tr class="'.$row['tour_color'].'">';
                echo '<td><input type="radio" name="tour_id" value="'.$row['tour_id'].'"';
                if($select_tour == $row['tour_id']){
                   echo ' checked="checked" ';
                }
                echo '></td>';
                echo '<td><a href="#" class="view-tour" data-id="'.$row['tour_id'].'" data-title="'.$row['tour_name'].'" data-toggle="modal" data-target="#myModal">'.$row['tour_code'].'</a></td>';
                echo '<td><span class="tooltip-showname" data-toggle="tooltip" data-placement="right" id="tooltip-top" data-original-title="'.$row['tour_name'].'">'.truncateWords($row['tour_name'], 15).'</span></td>';
                echo '<td>'.convertMilion($row['tour_price']).'</td>';
                echo '<td>'.$row['tour_duration'].' d</td>';
                echo '<td>'.$row['group_size'].' p</td>';
                echo '<td>'.convertDateDMY($row['start_date']).'</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>

        <?php
        echo '</div>';
        echo '</div>';

        echo '<div class="row">';
        echo '<div class="col-sm-6">';
        echo form_submit('submit', 'submit', 'class="btn btn-large btn-primary"');
        echo form_close();
        echo '</div>';
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>
