<div class="container">
    <div class="page-header users-header">
        <h2>
            Danh sách nhân viên
            <a  href="<?php echo site_url("admin"); ?>/signup" class="btn btn-success"><?php echo $this->config->item('text_add_a_new'); ?></a>
        </h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well">

                <?php

                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                $options_role = array('' => $this->config->item('text_select'));
                foreach ($roles as $row)
                {
                    $options_role[$row['id']] = $row['name'];
                }
                //save the columns names in a array that we will use as filter
                $options_users = array(
                    'id' => 'ID',
                    'first_name' => $this->config->item('text_name'),
                    'birthday' => $this->config->item('text_birthday'),
                    'create_date' => $this->config->item('text_create_date'),
                );


                echo form_open('admin/list', $attributes);

                echo form_label($this->config->item('text_search'), 'search_string');
                echo form_input('search_string', $search_string_selected, 'class="form-control"');

                echo form_label($this->config->item('text_role'), 'role_id');
                echo form_dropdown('role_id', $options_role, $role_id_selected, 'class="form-control"');

                echo form_label($this->config->item('text_order_by'), 'order');
                echo form_dropdown('order', $options_users, $order, 'class="form-control"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => $this->config->item('text_go'));

                $options_order_type = array('Asc' => $this->config->item('text_asc'), 'Desc' => $this->config->item('text_desc'));
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');

                echo form_submit($data_submit);

                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th class="">ID</th>
                    <th class=""><?php echo $this->config->item('text_name'); ?></th>
                    <th class="">Email</th>
                    <th class="">Phone</th>
                    <th class=""><?php echo $this->config->item('text_birthday'); ?></th>
                    <th class=""><?php echo $this->config->item('text_role'); ?></th>
                    <th class=""><?php echo $this->config->item('text_modify_date'); ?></th>
                    <th class=""></th>
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
                        <img alt="Image" src="'.base_url(). 'uploads/' .$row['thumb']. '" class="img-thumbnail">  <br/>
                        <a href="'.site_url("admin").'/edit_member/'.$row['id'].'" class="btn btn-primary">'.$this->config->item('text_edit').'</a>
                        <a href="'.site_url("admin").'/delete_member/'.$row['id'].'" class="btn btn-danger">'.$this->config->item('text_delete').'</a>
                </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

        </div>
    </div>