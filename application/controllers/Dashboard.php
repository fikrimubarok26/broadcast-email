<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
    }

    public function index()
    {
        $data = [
            'page' => 'Dashboard'
        ];
        $this->load->view('Templates/Templates', $data);
    }
}
