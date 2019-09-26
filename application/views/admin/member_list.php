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
                $options_role = array('' => "Select");
                foreach ($roles as $row)
                {
                    $options_role[$row['id']] = $row['name'];
                }
                //save the columns names in a array that we will use as filter
                $options_users = array(
                    'id' => 'ID',
                    'first_name' => 'Name',
                    'birthday' => 'Birthday',
                    'create_date' => 'Create date',
                );


                echo form_open('admin/list', $attributes);

                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected, 'class="form-control"');

                echo form_label('Role:', 'role_id');
                echo form_dropdown('role_id', $options_role, $role_id_selected, 'class="form-control"');

                echo form_label('Order by:', 'order');
                echo form_dropdown('order', $options_users, $order, 'class="form-control"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');

                echo form_submit($data_submit);

                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th class="">ID</th>
                    <th class="">Name</th>
                    <th class="">Email</th>
                    <th class="">Phone</th>
                    <th class="">Birthday</th>
                    <th class="">Role</th>
                    <th class="">Modify Date</th>
                    <th class="">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $options_role['1704'] = 'Admin'; // add role admin
                foreach($users as $row)
                {
                    $bdate = $row['birthday'];
                    $birthday = date("d-m-Y", strtotime($bdate));
                    echo '<tr>';
                    echo '<td>'.$row['id'].'</td>';
                    echo '<td><a href="'.site_url("admin").'/edit_member/'.$row['id'].'" >'.$row['first_name'].'</a></td>';
                    echo '<td>'.$row['email_address'].'</td>';
                    echo '<td>'.$row['phone'].'</td>';
                    echo '<td>'.$birthday.'</td>';
                    echo '<td>'.$options_role[$row['role']].'</td>';
                    echo '<td>'.$row['modify_date'].'</td>';
                    echo '<td class="crud-actions">
                        <img alt="Image" src="'.base_url(). 'uploads/' .$row['thumb']. '" class="img-thumbnail">  
                        <a href="'.site_url("admin").'/delete_member/'.$row['id'].'" class="btn btn-danger">delete</a>
                </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

        </div>
    </div>