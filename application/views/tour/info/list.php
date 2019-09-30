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
                $options_tours = array(
                    'tour_id' => 'ID',
                    'tour_code' => 'Code',
                    'group_size' => 'Group Size',
                    'start_date' => 'Start Date',
                    'create_date' => 'Create date',
                );

                echo form_open('admin/products', $attributes);
                echo '<div class="row">';
                    echo '<div class="col-md-2">';
                        echo form_label('Tour location:', 'location_link');
                        echo form_multiselect('manufacture_id', $field_tour_location, $location_link_selected, 'class="form-control"');
                    echo '</div>';
                    echo '<div class="col-md-9">';
                        echo '<div class="row" style="margin-bottom: 20px;">';
                            echo form_label('Start date:', 'search_string');
                            echo '<div class="input-group datepicker">';
                            echo form_input('start_date', set_value('start_date'), 'class="form-control" readonly');
                            echo '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>';
                            echo '</div>';

                            echo form_label('Search:', 'search_string');
                            echo form_input('search_string', $search_string_selected, 'class="form-control"');
                        echo '</div>';
                        echo '<div class="row">';
                            echo form_label('Order by:', 'order');
                            echo form_dropdown('order', $options_tours, $order, 'class="form-control"');
                            $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
                            $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                            echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="col-md-1">';
                        echo form_submit($data_submit);
                    echo '</div>';
                echo '</div>';
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th class="">#</th>
                    <th class="">Code</th>
                    <th class="">Name</th>
                    <th class="">Price</th>
                    <th class="">Duration</th>
                    <th class="">Size</th>
                    <th class="">Start Date</th>
                    <th class="">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($tour_infos as $row)
                {
                    echo '<tr>';
                    echo '<td>'.$row['tour_id'].'</td>';
                    echo '<td>'.$row['tour_code'].'</td>';
                    echo '<td>'.$row['tour_name'].'</td>';
                    echo '<td>'.$row['tour_price'].'</td>';
                    echo '<td>'.$row['tour_duration'].'</td>';
                    echo '<td>'.$row['group_size'].'</td>';
                    echo '<td>'.$row['start_date'].'</td>';
                    echo '<td class="crud-actions">
                  <a href="'.site_url("admin").'/products/update/'.$row['tour_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("admin").'/products/delete/'.$row['tour_id'].'" class="btn btn-danger">delete</a>
                </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

        </div>
    </div>