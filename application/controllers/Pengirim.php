<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengirim extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
        $this->load->library('Library');
        $this->load->library('grocery_CRUD');
        $this->load->helper('hashids');
    }

    public function index()
    {

        $crud = $this->grocery_crud;
        $crud->set_theme('flexigrid');
        $crud->set_table('pengirim');
        $crud->display_as('email');
        $crud->display_as('email', 'EMAIL');
        $crud->display_as('password', 'PASSWORD');
        $crud->display_as('id_konfigurasi', 'HOST EMAIL');

        $crud->set_relation('id_konfigurasi', 'konfigurasi_email', 'host');
        $crud->columns('email');
        $crud->order_by('id', 'desc');

        $crud->callback_before_insert(array($this, 'encrypt_password_callback'));
        $crud->callback_before_update(array($this, 'encrypt_password_callback'));
        $crud->callback_edit_field('password', array($this, 'decrypt_password_callback'));

        $crud->required_fields('email', 'password', 'id_konfigurasi');
        $crud->field_type('password', 'password');
        $crud->unset_read();
        $crud->unset_clone();
        $output = $crud->render();

        $data['crud'] = $output;
        $data['page'] = 'Pengirim/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }

    function encrypt_password_callback($post_array)
    {
        $post_array['password'] = $this->library->Encode($post_array['password'], 2);
        return $post_array;
    }


    public function decrypt_password_callback($passw)
    {
        $passwdecrypt = $this->library->Decode($passw, 2);
        return "<input type='password' name='password' value='" . ($passwdecrypt) . "' />";
    }
}
