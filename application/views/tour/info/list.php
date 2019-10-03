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
                $options_sizes = array(
                    'all' => 'all',
                    '0-19' => '0-19',
                    '20-29' => '20-29',
                    '30-39' => '30-39',
                    '40-49' => '40-49',
                );
                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                $options_duration = array('5','6','7','8','9','10','11','12','13',);
                $options_month = array('all','1','2','3','4','5','6','7','8','9','10','11','12');
                $options_year = array('all','2019','2020','2021');

                echo form_open('tour/info', $attributes);
                echo '<div class="row">';
                    echo '<div class="col-md-3">';
                        echo form_label('Tour:', 'location_link');
                        echo form_multiselect('location_link[]', $field_tour_location, $location_link_selected, 'class="form-control" id="location_link"');
                    echo '</div>';
                    echo '<div class="col-md-7">';
                        echo '<div class="row bottom-block" >';
                            echo form_label('Search:', 'search_string');
                            echo form_input('search_string', $search_string_selected, 'class="form-control" id="search_field"');
                            echo form_label('Size:', 'order');
                            echo form_dropdown('group_size', $options_sizes, $sizes_selected, 'class="form-control"');
                        echo '</div>';
                        echo '<div class="row bottom-block">';
                            echo form_label('Select month:', 'start_month');
                            echo form_dropdown('start_month', $options_month, $month_selected, 'class="form-control"');
                            echo form_label('Select year:', 'start_year');
                            echo form_dropdown('start_year', $options_year, $year_selected, 'class="form-control"');
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
                echo '<div class="row bottom-block" >';
                        echo '<a class="btn btn-danger" href="'.base_url().'tour/info">Reset</a>';
                echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
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
                $this->load->helper('true_function');
                foreach($tour_infos as $row)
                {
                    echo '<tr>';
                    echo '<td><a href="#" class="view-tour" data-id="'.$row['tour_id'].'" data-title="'.$row['tour_name'].'" data-toggle="modal" data-target="#myModal">'.$row['tour_code'].'</a></td>';
                    echo '<td><span class="tooltip-showname" data-toggle="tooltip" data-placement="right" id="tooltip-top" data-original-title="'.$row['tour_name'].'">'.truncateWords($row['tour_name'], 12).'</span></td>';
                    echo '<td>'.convertMilion($row['tour_price']).'</td>';
                    echo '<td>'.$row['tour_duration'].' d</td>';
                    echo '<td>'.$row['group_size'].' p</td>';
                    echo '<td>'.convertDateDMY($row['start_date']).'</td>';
                    echo '<td class="crud-actions">
                  <a href="'.site_url("tour").'/info/update/'.$row['tour_id'].'" class="btn btn-info">edit</a>  
                  <a href="'.site_url("tour").'/info/delete/'.$row['tour_id'].'" class="btn btn-danger">delete</a>
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