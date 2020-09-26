<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('Library');
        $this->load->library('grocery_CRUD');
    }

	public function index()
	{
        $crud = $this->grocery_crud;
        $crud->set_table('anggota');
        $crud->fields('nrp','nama','email');
        $crud->columns('nrp','nama','email');
        $crud->display_as('nrp','NRP');
        $crud->display_as('nama','NAMA');
        $crud->display_as('email','EMAIL');
        $crud->order_by('id_anggota','desc');
        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Anggota/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates',$data);
    }
}
