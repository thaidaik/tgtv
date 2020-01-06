<?php
/**
 * Created by PhpStorm.
 * User: thaind
 * Date: 2/1/2020
 * Time: 4:08 PM
 */
?>
<div class="container top">
    <div class="page-header">
        <h2><?php echo $data_tour_name; ?></h2>
    </div>
    <?php
    $this->load->helper('true_function');
    $start_location = $this->config->item('start_location');
        if(isset($guest_sale_tour_info_data) && count($guest_sale_tour_info_data)){ ?>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="">Khách hàng</th>
                    <th class="">Sale</th>
                    <th class="">Khởi hành</th>
                    <th class="">Số lần thanh toán</th>
                    <th class="">Đã thanh toán</th>
                    <th class="">Tổng tiền</th>
                    <th class="">Trang thái</th>
                    <th class="">Cập nhật thanh toán</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach($guest_sale_tour_info_data as $row)
                {
                    $select_date = checkDateData($row['start_date']);
                    echo '<tr>';
                    echo '<td>'.$row['guest_name'].'</td>';
                    echo '<td>'.$row['user_name'].'</td>';
                    echo '<td>'.$start_location[$row['start_location']].'</td>';
                    echo '<td>'.$row['total_number_price'].'</td>';
                    echo '<td>'.number_format($row['total_price'],0,",",".").'</td>';
                    if($row['custom_price'] > '0'){
                        echo '<td>'.number_format($row['custom_price'],0,",",".").'</td>';
                    }else{
                        echo '<td>'.number_format($row['tour_price'],0,",",".").'</td>';
                    }
                    if($row['total_finish'] != '0'){
                        echo '<td>Done</td>';
                    }else{
                        echo '<td>Not</td>';
                    }
                    echo '<td><a href="'.site_url("guest").'/add/payment/gid_'.$row['guest_info_id'].'/'.$row['guest_tour_link_id'].'" class="btn btn-success btn-xs"> Cập nhật thanh toán</a>';
                    echo '<a href="'.site_url("guest").'/link/tour/gid_'.$row['guest_info_id'].'/mnow'.'" class="btn btn-info btn-xs"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.$this->config->item('text_view').' Edit</a></td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?php
        }?>
</div>