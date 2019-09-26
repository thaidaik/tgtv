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
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="yellow header headerSortDown">Name</th>
                    <th class="yellow header headerSortDown">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($tour_location as $row)
                {
                    echo '<tr>';
                    echo '<td>'.$row['country'].'</td>';
                    echo '<td class="crud-actions">
                  <a href="'.site_url("tour").'/location/update/'.$row['id'].'" class="btn btn-info">edit</a>  
                  <a href="'.site_url("tour").'/location/delete/'.$row['id'].'" class="btn btn-danger">delete</a>
                </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

            <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

        </div>
    </div>