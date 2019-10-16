<div class="container">

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(1));?>
            <a  href="<?php echo site_url("admin"); ?>/signup" class="btn btn-success">Add a new</a>
        </h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well">

                <?php

                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                //save the columns names in a array that we will use as filter
                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                $options_tours = array(
                    'tour_id' => 'ID',
                    'tour_code' => 'Code',
                    'group_size' => 'Group Size',
                    'start_date' => 'Start Date',
                    'create_date' => 'Create date',
                );

                echo form_open('tour/info', $attributes);
                echo '<div class="row">';
                echo '<div class="col-md-10">';

                echo '<div class="row bottom-block" >';
                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected, 'class="form-control" id="search_field"');
                echo form_label('Size:', 'order');
                echo '</div>';

                echo '<div class="row">';
                echo form_label('Order by:', 'order');
                echo form_dropdown('order', $options_tours, $order, 'class="form-control"');
                echo form_label('Order type:', 'order');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');
                echo '</div>';

                echo '</div>';

                echo '<div class="col-md-2">';
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
                echo '<div class="row bottom-block" >';
                echo form_submit($data_submit);
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
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Email</th>
                    <th class="">CMND</th>
                    <th class="">Birthday</th>
                    <th class="">Actions</th>
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
                  <a href="'.site_url("guest").'/link/tour/'.$row['guest_id'].'/mnow'.'" class="btn btn-info btn-xs">add tour</a>  
                  <a href="'.site_url("guest").'/info/update/'.$row['guest_id'].'" class="btn btn-info btn-xs">edit</a>  
                  <a href="'.site_url("guest").'/info/delete/'.'" class="btn btn-danger btn-xs">delete</a>
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