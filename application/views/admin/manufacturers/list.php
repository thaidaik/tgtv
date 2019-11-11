    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a>
        </li>
        <li class="active">
            Quản lý nhóm nhân viên
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          Quản lý nhóm nhân viên
          <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success"><?php echo $this->config->item('text_add_a_new'); ?></a>
        </h2>
      </div>
      
      <div class="row">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead>
              <tr>
                <th class="yellow header headerSortDown"><?php echo $this->config->item('text_name');?></th>
                <th class="yellow header headerSortDown">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $this->load->model('manufacturers_model');
              $fix_data = array();
              foreach($manufacturers as $key=>$row){
                  $fix_data[$key] = $row;
                  $fix_data[$key]['count'] = $this->manufacturers_model->count_member($row['id']);
              }
              foreach($fix_data as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['name'].' <span class="badge"> '.$row['count'].'</span></td>';
                echo '<td class="crud-actions">
                  <a href="'.site_url("admin").'/role/update/'.$row['id'].'" class="btn btn-info">'.$this->config->item('text_edit').'</a>  ';
                if($row['count'] == 0){
                    echo '<a href="'.site_url("admin").'/role/delete/'.$row['id'].'" class="btn btn-danger">'.$this->config->item('text_delete').'</a> ';
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