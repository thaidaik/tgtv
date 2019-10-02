<?php


defined('BASEPATH') OR exit('No direct script access allowed');


class ItemController extends CI_Controller {


    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function ajaxRequest()
    {
        $data['data'] = $this->db->get("products")->result();
        $this->load->view('itemlist', $data);
    }


    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function ajaxRequestPost()
    {
        $this->load->database();
        $data = array(
            'stock' => $this->input->post('stock'),
            'description' => $this->input->post('description')
        );
        $this->db->insert('products', $data);

        echo 'Added successfully.';
    }
}