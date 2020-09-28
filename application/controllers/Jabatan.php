<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
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
        $crud->set_table('jabatan');
        $crud->set_theme('flexigrid');
        $crud->fields('nama_jabatan');
        $crud->columns('nama_jabatan');
        $crud->display_as('nama_jabatan', 'NAMA JABATAN');
        $crud->order_by('id_jabatan', 'desc');
        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Jabatan/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }
}
