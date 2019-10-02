<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1));?>
            </a>
        </li>
        <li class="active">
            <?php echo ucfirst($this->uri->segment(2));?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2));?>
            <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
    </div>

    <div class="row">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="">Name</th>
                    <th class="">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $this->load->model('tour_location_model');
                $fix_data = array();
                foreach($tour_location as $key=>$row){
                    $fix_data[$key] = $row;
                    $fix_data[$key]['count'] = $this->tour_location_model->count_country_link($row['id']);
                }
                foreach($fix_data as $row)
                {
                    echo '<tr>';
                    echo '<td>'.$row['country'].' <span class="badge"> '.$row['count'].'</span></td>';
                    echo '<td class="crud-actions">
                            <a href="'.site_url("tour").'/location/update/'.$row['id'].'" class="btn btn-info">edit</a>  ';
                    if($row['count'] == 0){
                        echo '<a href="'.site_url("tour").'/location/delete/'.$row['id'].'" class="btn btn-danger">delete</a> ';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>
        </div>
    </div>