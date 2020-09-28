<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pangkat extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
        $this->load->library('Library');
        $this->load->library('grocery_CRUD');
    }

    public function index()
    {
        $crud = $this->grocery_crud;
        $crud->set_table('pangkat');
        $crud->fields('nama_pangkat');
        $crud->set_theme('flexigrid');

        $crud->columns('nama_pangkat');
        $crud->display_as('nama_pangkat', 'NAMA PANGKAT');
        $crud->order_by('id_pangkat', 'desc');
        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Pangkat/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }
}
