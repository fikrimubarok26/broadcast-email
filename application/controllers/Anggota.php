<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
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
        $crud->set_theme('flexigrid');
        $crud->set_table('anggota');
        $crud->display_as('nrp', 'NRP');
        $crud->display_as('nama', 'NAMA');
        $crud->display_as('email', 'EMAIL');
        $crud->display_as('id_jabatan', 'NAMA JABATAN');
        $crud->display_as('id_pangkat', 'NAMA PANGKAT');
        $crud->set_relation('id_jabatan', 'jabatan', 'nama_jabatan');
        $crud->set_relation('id_pangkat', 'pangkat', 'nama_pangkat');
        $crud->columns('nrp', 'nama', 'id_jabatan', 'id_pangkat', 'email');
        $crud->order_by('id_anggota', 'desc');

        $crud->required_fields('nrp', 'nama', 'email');
        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Anggota/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }
}
