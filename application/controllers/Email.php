<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_mail', 'mail');
    }

    public function index()
    {

        $datUser = $this->mail->data_user();
        $url = base_url();
        $data = array(
            'title' => 'Kirim Email',
            'datauser' => $datUser,
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

    function getUser()
    {
        echo json_encode($this->mail->data_user());
    }

    function getPangkat()
    {
        echo json_encode($this->mail->data_pangkat());
    }

    public function sendMail()
    {

        // Ambil Data
        $personal = $this->input->post('id_user');
        $pangkat  = $this->input->post('id_pangkat');

        // Pecah Data
        $pecahPersonal = explode(',', $personal);
        $pecahPangkat = explode(',', $pangkat);

        // Ambil Personal Akun
        $emailPersonal = [];
        $idPersonal = [];
        foreach ($pecahPersonal as $pers) {
            $ambilDataPersonal = $this->db->get_where('anggota', ['id_anggota' => $pers])->result();
            $TotalKirimPersonal = $this->db->get_where('anggota', ['id_anggota' => $pers])->num_rows();
            foreach ($ambilDataPersonal as $getEmail) {
                $emailPersonal[] = $getEmail->email;
                $idPersonal[] = $getEmail->id_anggota;
            } 
        }
        
        // Ambil Bersarkan Akun Jabatan
        $emailPangkat = [];
        $idPangkat = [];
        foreach ($pecahPangkat as $pang) {
           $ambilDataPangkat = $this->db->get_where('anggota', ['id_pangkat' => $pang])->result();
            $TotalKirimPangkat = $this->db->get_where('anggota', ['id_pangkat' => $pang])->num_rows();
            foreach ($ambilDataPangkat as $getEmail) {
                $emailPangkat[] = $getEmail->email;
                $idPangkat[] = $getEmail->id_anggota;
            } 
        }

        // Jika Yang diisi akun Personal
        if ($emailPersonal != '') {
            foreach ($idPersonal as $key) {
                // Insert Data 
                $insertData = array(
                    'tanggal_kirim' => date("Y/m/h"),
                    'judul_broadcast' => $this->input->post('subjek'),
                    'isi_broadcast' => $this->input->post('isi_surat'),
                    'id_user' => $key,
                    // 'jumlah_anggota' => $TotalKirimPersonal,
                );

                $this->mail->insert($insertData);
            }            
        }


        // Jika yang diisi akun Pangkat
        if ($emailPangkat != '') {
             foreach ($idPangkat as $key) {
                // Insert Data 
                $insertData = array(
                    'tanggal_kirim' => date("Y/m/h"),
                    'judul_broadcast' => $this->input->post('subjek'),
                    'isi_broadcast' => $this->input->post('isi_surat'),
                    'id_user' => $key,
                    // 'jumlah_anggota' => $TotalKirimPangkat,
                );

                $this->mail->insert($insertData);
            }         
        }
        


        // Kirim Email
        $mail = array(
            'subjek' => $this->input->post('subjek'),
            'isi_surat' => $this->input->post('isi_surat'),
            'emailPangkat' => $emailPangkat,
            'emailPersonal' => $emailPersonal,
        );

        $email = $this->req->sendMail($mail);

        // Hasil Pengiriman
        // if (!$email->send()) {
        //     $msg = array(
        //         'surat' => 'fail',
        //         'msg' => 'Terjadi kesalahan Saat mengirim Email !',
        //     );
        // } else {
        //     $msg = array(
        //         'surat' => 'ok',
        //         'msg' => 'Berhasil Mengirim Data !',
        //     );
        // }
        // echo json_encode($msg);

    }

    public function riwayatEmail()
    {
        $url = base_url();
        $data = array(
            'title' => 'Kirim Email',
            'page' => 'Email/riwayatEmail',
            'crud' => null,
        );

        $this->load->view('Templates/Templates', $data);
    }

}

/* End of file Controllername.php */
