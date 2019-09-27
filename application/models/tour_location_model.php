<?php
class Tour_location_model extends CI_Model {

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
    public function get_tour_location_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tour_location');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch tour_location data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_tour_location($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {

        $this->db->select('*');
        $this->db->from('tour_location');
        if($search_string){
            $this->db->like('country', $search_string);
        }
        $this->db->group_by('id');

        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('id', $order_type);
        }

        if($limit_start && $limit_end){
            $this->db->limit($limit_start, $limit_end);
        }

        if($limit_start != null){
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_data_field_tour_location()
    {

        $this->db->select('id');
        $this->db->select('country');
        $this->db->from('tour_location');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_tour_location($search_string=null, $order=null)
    {
        $this->db->select('*');
        $this->db->from('tour_location');
        if($search_string){
            $this->db->like('country', $search_string);
        }
        if($order){
            $this->db->order_by($order, 'Asc');
        }else{
            $this->db->order_by('id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Add the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function add_tour_location($data)
    {
        $insert = $this->db->insert('tour_location', $data);
        return $insert;
    }

    /**
     * Update tour_location
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_tour_location($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tour_location', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if($report !== 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Delete tour_locationr
     * @param int $id - tour_location id
     * @return boolean
     */
    function delete_tour_location($id){
        $this->db->where('id', $id);
        $this->db->delete('tour_location');
    }

}
?>
