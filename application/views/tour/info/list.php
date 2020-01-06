<div class="container">

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(1));?>
            <a  href="<?php echo site_url("tour"); ?>/info/add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->config->item('text_add_a_new'); ?></a>
        </h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well">

                <?php

                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                //save the columns names in a array that we will use as filter
                $options_location_group = array(
                    'eu' => 'Châu Âu',
                    'us' => 'Châu Mỹ',
                    'asia' => 'Châu Á',
                );
                $options_tours = array(
                    'tour_id' => 'ID',
                    'tour_code' => 'Code',
                    'group_size' => 'Group Size',
                    'start_date' => 'Start Date',
                    'create_date' => 'Create date',
                );
                $options_sizes = array(
                    'all' => 'all',
                    '0-19' => '0-19',
                    '20-29' => '20-29',
                    '30-39' => '30-39',
                    '40-49' => '40-49',
                );
                $options_order_type = array('Asc' => $this->config->item('text_asc'), 'Desc' => $this->config->item('text_desc'));
                $options_duration = array('5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13');
                $options_month = array('all'=>'Tất cả','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12');
                $options_year = array('all'=>'Tất cả','2019'=>'2019','2020'=>'2020','2021'=>'2021');

                echo form_open('tour/info', $attributes);
                echo '<div class="row">';
                    echo '<div class="col-md-3">';
                        echo '<div class="row bottom-block" >';
                            echo form_label('Khu vưc :', 'location_link'); // new field xxx
                            echo form_dropdown('location_group', $options_location_group, $location_link_selected, 'class="form-control" id="location_link_3"');
                        echo '</div>';
                        echo '<div class="row bottom-block" >';
                            echo form_label('Quốc gia :', 'location_link');
                            //echo form_multiselect('location_link[]', $field_tour_location, $location_link_selected, 'class="form-control" id="location_link"');
                            echo form_dropdown('location_link[]', $field_tour_location, $location_link_selected, 'class="form-control" id="location_link_2"');
                        echo '</div>';
                        echo '<div class="row bottom-block">';
                            echo form_label($this->config->item('text_search_code'), 'search_code');
                            echo form_input('search_code', $search_code_selected, 'class="form-control" id="search_field_code"');
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="col-md-7">';
                        echo '<div class="row bottom-block" >';
                            echo form_label('Tour name:', 'search_string');
                            echo form_input('search_string', $search_string_selected, 'class="form-control" id="search_field"');
                            /*echo form_label($this->config->item('text_size'), 'order');
                            echo form_dropdown('group_size', $options_sizes, $sizes_selected, 'class="form-control"');*/ // old field xxx
                        echo '</div>';
                        echo '<div class="row bottom-block">';
                            echo form_label('Khởi hành:  Ngày', 'start_day'); // new field xxx
                            echo form_dropdown('start_day', $options_month, $month_selected, 'class="form-control"');
                            echo form_label('Tháng', 'start_month');
                            echo form_dropdown('start_month', $options_month, $month_selected, 'class="form-control"');
                            echo form_label('Năm:', 'start_year');
                            echo form_dropdown('start_year', $options_year, $year_selected, 'class="form-control"');
                        echo '</div>';
                        echo '<div class="row">';
                            echo form_label($this->config->item('text_order_by'), 'order');
                            echo form_dropdown('order', $options_tours, $order, 'class="form-control"');
                            echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="col-md-2">';
                        $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => $this->config->item('text_go'));
                        echo '<div class="row bottom-block" >';
                        echo form_submit($data_submit);
                echo '</div>';
                echo '<div class="row bottom-block" >';
                        echo '<a class="btn btn-danger" href="'.base_url().'tour/info">Reset</a>';
                echo '</div>';
                echo '<div class="row bottom-block" >';
                        echo '<a class="btn btn-success" href="'.base_url().'tour_info/createXLS">Export XLS</a>';
                echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class=""></th>
                    <th class="">Tour Code</th>
                    <th class="">Tour Name</th>
                    <th class="">Giá Tour</th>
                    <th class="">Số ngày</th>
                    <th class="">Số khách</th>
                    <th class="">K SG</th>
                    <th class="">K HN</th>
                    <th class="">Còn nhận</th>
                    <th class="">Khởi hành</th>
                    <th class=""></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $this->load->helper('true_function');
                foreach($tour_infos as $row)
                {
                    echo '<tr class="'.$row['tour_color'].'">';
                    $night = $row['tour_duration'] - 1;
                    $slot = $row['group_size'] - $row['group_slot'];

                    //echo '<tr>';
                    echo '<td width="80px"><img alt="Image" src="'.base_url(). 'uploads/' .$row['tour_image_thumb']. '" width="80px" class="img-thumbnail"/></td>';
                    echo '<td><a href="" class="view-tour" data-id="'.$row['tour_id'].'" data-title="'.$row['tour_name'].'" data-toggle="modal" data-target="#myModal">'.$row['tour_code'].'</a></td>';
                    echo '<td><a href="'.$row['tour_link'].'" target="_blank"><span class="tooltip-showname" data-toggle="tooltip" data-placement="right" id="tooltip-top" data-original-title="'.$row['tour_name'].'">'.truncateWords($row['tour_name'], 25).'</span></a></td>';
                    echo '<td>'.number_format($row['tour_price'],0,",",".").'</td>';
                    echo '<td>'.$row['tour_duration'].'N'.$night.'Đ</td>';
                    echo '<td>'.$row['group_size'].'</td>';
                    echo '<td>'.$row['group_slot_saigon'].'</td>';
                    echo '<td>'.$row['group_slot_hanoi'].'</td>';
                    echo '<td>'.$slot.'</td>';
                    echo '<td>'.convertDateDMY($row['start_date']).'<br/> '.$row['departs'].' '.$row['flight'].'</td>';
                    echo '<td class="crud-actions">
                  <a href="'.site_url("tour").'/info/update/'.$row['tour_id'].'" class="btn btn-info btn-xs"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> '.$this->config->item('text_edit').'</a>  
                  <a href="'.site_url("payment").'/'.$row['tour_id'].'" class="btn btn-success btn-xs">View</a>
                </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

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
    </div>
</div>