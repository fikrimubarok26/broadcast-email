<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
    }


    public function index()
    {
        $url = base_url();
        $data = array(
            'title' => 'Kirim Email',
            'page' => 'Email/email',
            'crud' => null,
            'css' => [
                "{$url}assets/plugin/tagify/tagify.css",
                "{$url}assets/plugin/summernote/summernote.min.css",

            ],
            'js' => [
                "{$url}assets/plugin/tagify/jQuery.tagify.min.js",
                "{$url}assets/plugin/tagify/tagify.min.js",
                "{$url}assets/plugin/summernote/summernote.min.js",
                "{$url}assets/template/js/email.js",
            ],
        );

        $this->load->view('Templates/Templates', $data);
    }

    public function sendMail()
    {

        $tujuan = $this->input->post('tujuan');

        $pecahEmail = explode(',', $tujuan);

        $emailUser = [];
        foreach ($pecahEmail as $keyNa) {
            $dataEmail = $this->db->get_where('anggota', ['email' => $keyNa])->result();
            foreach ($dataEmail as $keyKey) {
                $emailUser[] = $keyKey->email;
            }
        }

        $mail = array(
            'subjek' => $this->input->post('subjek'),
            'isi_surat' => $this->input->post('isi_surat'),
            'email' => $emailUser,
        );

        // var_dump($emailUser);

        $email = $this->req->sendMail($mail);

        if (!$email->send()) {
            $msg = array(
                'surat' => 'fail',
                'msg' => 'Terjadi kesalahan Saat mengirim Email !',
            );
        } else {
            $msg = array(
                'surat' => 'ok',
                'msg' => 'Berhasil Mengirim Data !',
            );
        }
        echo json_encode($msg);
    }
}

/* End of file Controllername.php */
