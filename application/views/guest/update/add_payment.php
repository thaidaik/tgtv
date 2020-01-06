<div class="container top">

    <div class="page-header">
        <h2>
            Thông tin khách hàng
        </h2>
    </div>
    <?php
    $this->load->helper('true_function');
    $user_sex = $this->config->item('user_sex');
    $guest_pay_status = $this->config->item('guest_s_pay');
    $guest_pay_by_type = $this->config->item('guest_s_pay_type');
    $guest_pay_finish = array('0'=>'Chưa hoàn thành','1'=>'Đã hoàn thành');

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
    $guestbirthday = date("d-m-Y", strtotime($guest_birthday));


    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<div class="row bottom-block"><label>Tên: </label>'.$sex_show.' '.$guest_info_data['0']['guest_name'].'</div>';
    echo '<div class="row bottom-block"><label>Phone: </label>'.$guest_info_data['0']['guest_phone'].'</div>';
    echo '<div class="row bottom-block"><label>Địa chỉ: </label>'.$guest_info_data['0']['guest_address'].'</div>';
    echo '<div class="row bottom-block"><label>Email: </label>'.$guest_info_data['0']['guest_email'].'</div>';
    echo '</div>';
    echo '<div class="col-md-6">';
    echo '<div class="row bottom-block"><label>Sinh nhật: </label>'.$guestbirthday.'</div>';
    echo '<div class="row bottom-block"><label>CMND: </label>'.$guest_info_data['0']['guest_cmnd'].'</div>';
    echo '<div class="row bottom-block"><label>Hộ chiếu: </label>'.$guest_info_data['0']['guest_passport'].'</div>';
    echo '<div class="row bottom-block"><label>Nguyên quán: </label>'.$guest_info_data['0']['guest_country'].'</div>';
    echo '</div>';
    echo '</div>';


    ?>
    <div class="page-header">
        <h2>
            Thông tin thanh toán
        </h2>
    </div>
    <div class="row">
        <?php
        if(isset($get_guest_tour_sale_data)){ ?>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="">Tên khách hàng</th>
                    <th class="">Tour name</th>
                    <th class="">Tên Sale</th>
                    <th class="">Cập nhật thanh toán</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($get_guest_tour_sale_data as $row)
                {
                    $select_date = checkDateData($row['start_date']);
                    echo '<tr>';
                    echo '<td>'.$row['guest_name'].'</td>';
                    echo '<td>'.$row['tour_name'].'</td>';
                    echo '<td>'.$row['user_name'].'</td>';
                    echo '<td class="text-nhapnhay">Đang chỉnh sửa...</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <hr class="style1">
            <?php
        }
        ?>
    </div>
    <?php
    if(isset($get_all_payment_toguest)){ ?>
    <div class="page-header">
        <h3>
            Danh sách thanh toán
        </h3>
    </div>
    <div class="row">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="">Trạng thái</th>
                <th class="">Số tiền</th>
                <th class="">Người thu</th>
                <th class="">Phương thức</th>
                <th class="">Ngày</th>
                <th class=""></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($get_all_payment_toguest as $row)
            {
                $url = site_url("guest").'/add/payment/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/pid_'.$row['id'];
                $select_date = convertDateDMY($row['guest_pay_time']);
                echo '<tr>';
                echo '<td>'.$guest_pay_status[$row['guest_pay_status']].'</td>';
                echo '<td>'.number_format($row['guest_pay_price'],0,",",".").'</td>';
                echo '<td>'.$all_users[$row['guest_pay_by_user_id']].'</td>';
                echo '<td>'.$guest_pay_by_type[$row['guest_pay_by_type']].'</td>';
                echo '<td>'.$select_date.'</td>';
                if(isset($get_payment_toguest_by_id)&& $get_payment_toguest_by_id[0]['id'] == $row['id']){
                    echo '<td class="text-nhapnhay">Đang chỉnh sửa...</td>';
                }else{
                    echo '<td><a href="'.$url.'" class="btn btn-success btn-xs">Sửa</a></td>';
                }
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
    <div class="page-header">
        <h3>
            <?php
            if(isset($get_payment_toguest_by_id)&& $get_payment_toguest_by_id){
                echo 'Edit payment: '. $guest_pay_status[$get_payment_toguest_by_id[0]['guest_pay_status']];
            }else{
                echo 'Thêm thanh toán';
            }
            ?>
        </h3>
    </div>
    <div class="row">

        <?php

        //form validation
        echo validation_errors();
        $attributes = array('class' => 'form-signin');
        if(isset($get_payment_toguest_by_id)&& $get_payment_toguest_by_id){
            echo form_open_multipart('guest/add/payment/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6), $attributes);
            $start_date = $get_payment_toguest_by_id['0']['guest_pay_time'];
            $guest_pay_time = date("d-m-Y", strtotime($start_date));
        }else{
            echo form_open_multipart('guest/add/payment/'.$this->uri->segment(4).'/'.$this->uri->segment(5), $attributes);
            $get_payment_toguest_by_id[0]['guest_pay_status'] = '';
            $get_payment_toguest_by_id[0]['guest_pay_by_user_id'] = '';
            $get_payment_toguest_by_id[0]['guest_pay_price'] = '';
            $get_payment_toguest_by_id[0]['guest_pay_by_type'] = '';
            $get_payment_toguest_by_id[0]['guest_pay_finish'] = '';
            $guest_pay_time ='';
        }

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="guest_pay_status">Trạng thái thanh toán</label>';
        echo form_dropdown('guest_pay_status', $guest_pay_status, $get_payment_toguest_by_id[0]['guest_pay_status'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_pay_by_user_id">Người thu tiền</label>';
        echo form_dropdown('guest_pay_by_user_id', $all_users, $get_payment_toguest_by_id[0]['guest_pay_by_user_id'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_pay_price">Tổng số tiền thu</label>';
        echo form_input('guest_pay_price', $get_payment_toguest_by_id[0]['guest_pay_price'], 'placeholder="" class="form-control" id="convert_number"');
        echo '</div>';
        echo '</div>';

        echo '<div class="col-sm-6">';
        echo '<div class="control-group"><label class="control-label required" for="guest_pay_by_type">Phương thức thu tiền</label>';
        echo form_dropdown('guest_pay_by_type', $guest_pay_by_type, $get_payment_toguest_by_id[0]['guest_pay_by_type'], 'class="form-control"');
        echo '</div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_pay_time">Thời gian thu tiền</label><div class="input-group datepicker">';
        echo form_input('guest_pay_time', $guest_pay_time, 'class="form-control" readonly');
        echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
        echo '</div></div>';
        echo '<div class="control-group"><label class="control-label required" for="guest_pay_finish">Hoàn thành thanh toán</label>';
        echo '<div class="fix-control"><input type="checkbox" name="guest_pay_finish" value="1" ';
        if($get_payment_toguest_by_id[0]['guest_pay_finish'] == 1){
            echo 'checked';
        }
        echo '> Đã thanh toán hết </div>';
        echo '</div>';
        echo '</div>';

        echo '</div>';

        echo '<div class="row">';
        echo '<div class="col-sm-6">';
        echo '<div><input type="hidden" name="user_sale_id" value="'.$get_guest_tour_sale_data[0]["user_id"].'"></div>';
        echo '<div><input type="hidden" name="tour_info_id" value="'.$get_guest_tour_sale_data[0]["tour_id"].'"></div>';
        echo form_submit('submit', 'submit', 'class="btn btn-large btn-primary"');
        $backurl = site_url("guest").'/link/tour/'.$this->uri->segment(4).'/mnow';
        echo '<a href="'.$backurl.'" class="btn btn-large btn-primary">Back</a>';
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
