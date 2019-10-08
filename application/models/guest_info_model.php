<?php
/**
 * Created by PhpStorm.
 * User: thaind
 * Date: 8/10/2019
 * Time: 3:02 PM
 */

class Guest_info_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function get_tour_info_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tour_info');
        $this->db->where('tour_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch products data from the database
     * possibility to mix search, filter and order
     * @param int $manufacuture_id
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_tour_infos($month_selected=null,  $year_selected=null, $sizes_selected=null, $location_link=null, $search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end)
    {
        $this->db->select('tour_info.*');
        $this->db->from('tour_info');
        if($sizes_selected != false && $sizes_selected != null && $sizes_selected != 'all'){
            $size_array = explode('-',$sizes_selected);
            $this->db->where('tour_info.group_size BETWEEN "'.$size_array[0].'" AND "'.$size_array[1].'"');
        }
        if($month_selected != false && $month_selected != null && $month_selected != 'all'){
            $this->db->where('MONTH(tour_info.start_date)',$month_selected);
        }
        if($year_selected != false && $year_selected != null && $year_selected != 'all'){
            $this->db->where('YEAR(tour_info.start_date)',$year_selected);
        }
        if($location_link != null && count($location_link) != 0){
            $str_query = '(';
            foreach ($location_link as $key=>$value){
                if($key == 0){
                    $str_query .= 'tour_location_link.tour_location_id = '.$value;
                    //$this->db->where('tour_location_link.tour_location_id', $value);
                }else{
                    $str_query .= ' OR tour_location_link.tour_location_id = '.$value;
                    //$this->db->or_where('tour_location_link.tour_location_id', $value);
                }
            }
            $str_query .= ')';
            $this->db->where($str_query, null, false);
        }
        if($search_string){
            $this->db->like('tour_info.tour_name', $search_string);
        }

        $this->db->join('tour_location_link', 'tour_info.tour_id = tour_location_link.tour_info_id', 'inner');

        $this->db->group_by('tour_info.tour_id');

        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('tour_info.tour_id', $order_type);
        }

        if($limit_start){
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $manufacture_id
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_tour_infos($month_selected=null,  $year_selected=null, $sizes_selected=null, $location_link=null, $search_string=null, $order=null)
    {
        $this->db->select('tour_info.*');
        $this->db->from('tour_info');
        if($sizes_selected != false && $sizes_selected != null && $sizes_selected != 'all'){
            $size_array = explode('-',$sizes_selected);
            $this->db->where('tour_info.group_size BETWEEN "'.$size_array[0].'" AND "'.$size_array[1].'"');
        }
        if($month_selected != false && $month_selected != null && $month_selected != 'all'){
            $this->db->where('MONTH(tour_info.start_date)',$month_selected);
        }
        if($year_selected != false && $year_selected != null && $year_selected != 'all'){
            $this->db->where('YEAR(tour_info.start_date)',$year_selected);
        }
        if($location_link != null && count($location_link) != 0){
            foreach ($location_link as $key=>$value){
                if($key == 0){
                    $this->db->where('tour_location_link.tour_location_id', $value);
                }else{
                    $this->db->or_where('tour_location_link.tour_location_id', $value);
                }
            }
        }
        if($search_string){
            $this->db->like('tour_info.tour_name', $search_string);
        }
        $this->db->join('tour_location_link', 'tour_info.tour_id = tour_location_link.tour_info_id', 'inner');

        $this->db->group_by('tour_info.tour_id');

        if($order){
            $this->db->order_by($order, 'Asc');
        }else{
            $this->db->order_by('tour_info.tour_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function add_guest_info($data)
    {
        $insert = $this->db->insert('guest_info', $data);
        return $insert;
    }

    /**
     * Update product
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_tour_info($id, $data, $location_link)
    {
        $this->db->where('tour_id', $id);
        $this->db->update('tour_info', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        $this->reset_tour_location_link($id);
        foreach ($location_link as $value){
            $data_link= array(
                'tour_info_id' => $id,
                'tour_location_id' => $value
            );
            $this->db->insert('tour_location_link', $data_link);
        }
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if($report !== 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Delete product
     * @param int $id - product id
     * @return boolean
     */
    function delete_tour_info($id){
        $this->db->where('id', $id);
        $this->db->delete('tour_info');
    }

    function reset_tour_location_link($id){
        $this->db->where('tour_info_id', $id);
        $this->db->delete('tour_location_link');
    }

    function get_tour_location_link_by_tour_info_id($id){
        $this->db->select('*');
        $this->db->from('tour_location_link');
        $this->db->where('tour_info_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

}
?>
