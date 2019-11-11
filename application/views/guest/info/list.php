<div class="container">

    <div class="page-header users-header">
        <h2>
            Danh sách khách hàng
            <a  href="<?php echo site_url("guest"); ?>/info/add" class="btn btn-success"><?php echo $this->config->item('text_add_a_new'); ?></a>
        </h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well">

                <?php

                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                //save the columns names in a array that we will use as filter
                $options_order_type = array('Asc' => $this->config->item('text_asc'), 'Desc' => $this->config->item('text_desc'));
                $options_tours = array(
                    'guest_code' => 'Mã khách hàng',
                    'guest_name' => 'Tên khách hàng',
                );

                echo form_open('tour/info', $attributes);
                echo '<div class="row">';
                echo '<div class="col-md-10">';

                echo '<div class="row " >';
                echo form_label('Tên khách hàng:', 'search_string');
                echo form_input('search_string', $search_string_selected, 'class="form-control" id="search_field"');
                echo form_label('Mã khách hàng:', 'search_code'); // new field xxx
                echo form_input('search_code', $search_string_selected, 'class="form-control" id="search_field"');
                echo '</div>';

                /*echo '<div class="row">';
                echo form_label($this->config->item('text_order_by'), 'order');
                echo form_dropdown('order', $options_tours, $order, 'class="form-control"');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');
                echo '</div>';*/

                echo '</div>';

                echo '<div class="col-md-2">';
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => $this->config->item('text_go'));
                echo '<div class="row " >';
                echo form_submit($data_submit);
                echo ' <a class="btn btn-success" href="'.base_url().'tour_info/createXLS">Export XLS</a>';
                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="">Code</th>
                    <th class=""><?php echo $this->config->item('text_name'); ?></th>
                    <th class="">Phone</th>
                    <th class="">Email</th>
                    <th class="">CMND</th>
                    <th class=""><?php echo $this->config->item('text_birthday'); ?></th>
                    <th class=""></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $this->load->helper('true_function');
                foreach($tour_infos as $row)
                {
                    echo '<tr>';
                    echo '<td>'.$row['guest_code'].'</td>';
                    echo '<td>'.$row['guest_name'].'</td>';
                    echo '<td>'.$row['guest_phone'].'</td>';
                    echo '<td>'.$row['guest_email'].'</td>';
                    echo '<td>'.$row['guest_cmnd'].'</td>';
                    echo '<td>'.convertDateDMY($row['guest_birthday']).'</td>';
                    echo '<td class="crud-actions">
                  <a href="'.site_url("guest").'/link/tour/gid_'.$row['guest_id'].'/mnow'.'" class="btn btn-success btn-xs">Quản lý tour</a>  
                  <a href="'.site_url("guest").'/info/update/'.$row['guest_id'].'" class="btn btn-info btn-xs">'.$this->config->item('text_edit').'</a>  
                  <a href="'.site_url("guest").'/info/delete/'.'" class="btn btn-danger btn-xs">'.$this->config->item('text_delete').'</a>
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