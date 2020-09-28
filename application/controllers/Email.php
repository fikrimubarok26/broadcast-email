<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('Auth');
        $this->load->model('M_mail', 'mail');
        $this->load->library('Library');
        $this->load->library('grocery_CRUD');
    }
    public function index()
    {
        $datUser = $this->mail->data_user();
        $dataPengirim = $this->mail->data_pengirim();
        $url = base_url();
        $data = array(
            'title' => 'Kirim Email',
            'datauser' => $datUser,
            'datapengirim' => $dataPengirim,
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

        $asalPengirim = $this->input->post('asal');
        $dataPengirimNa = $this->mail->penggunaPengirim($asalPengirim);

        // Ambil Data
        $personal = $this->input->post('id_user');
        $pangkat  = $this->input->post('id_pangkat');

        // Pecah Data
        $pecahPersonal = explode(',', $personal);
        $pecahPangkat = explode(',', $pangkat);

        if ($pecahPersonal != '') {
            foreach ($pecahPersonal as $key) {
                @$TotalKirim += $this->db->get_where('anggota', ['id_anggota' => $key])->num_rows();
            }
        }
        if ($pecahPangkat != '') {
            foreach ($pecahPangkat as $key) {
                @$TotalKirim += $this->db->get_where('anggota', ['id_pangkat' => $key])->num_rows();
            }
        }

        // Insert ke Broadcast Email
        $insertDataNa = array(
            'tanggal_kirim'     => date("Y/m/h"),
            'judul_broadcast'   => $this->input->post('subjek'),
            'isi_broadcast'     => $this->input->post('isi_surat'),
            'jumlah_anggota'    => $TotalKirim,
        );

        $this->mail->insertDetail($insertDataNa);
        $idAkhir = $this->db->insert_id();


        // Ambil Personal Akun
        $emailPersonal = [];
        $idPersonal = [];
        foreach ($pecahPersonal as $pers) {
            $ambilDataPersonal = $this->db->get_where('anggota', ['id_anggota' => $pers])->result();
            foreach ($ambilDataPersonal as $getEmail) {
                $emailPersonal[] = $getEmail->email;
                $idPersonal[] = $getEmail->id_anggota;

                $insertData = array(
                    'id_broadcast' => $idAkhir,
                    'id_anggota'   => $getEmail->id_anggota,
                    'email'        => $getEmail->email,
                    'status'       => ($getEmail->email == '') ? '2' : '1'
                );

                $this->mail->insertSatuan($insertData);
            }
        }

        // Ambil Bersarkan Akun Jabatan
        $emailPangkat = [];
        $idPangkat = [];
        foreach ($pecahPangkat as $pang) {
            $ambilDataPangkat = $this->db->get_where('anggota', ['id_pangkat' => $pang])->result();
            foreach ($ambilDataPangkat as $getEmail) {
                $emailPangkat[] = $getEmail->email;
                $idPangkat[] = $getEmail->id_anggota;

                $insertData = array(
                    'id_broadcast' => $idAkhir,
                    'id_anggota'   => $getEmail->id_anggota,
                    'email'        => $getEmail->email,
                    'status'       => ($getEmail->email == '') ? '2' : '1',

                );

                $this->mail->insertSatuan($insertData);
            }
        }

        // Kirim Email
        $mail = array(
            'subjek' => $this->input->post('subjek'),
            'isi_surat' => $this->input->post('isi_surat'),
            'emailPangkat' => $emailPangkat,
            'emailPersonal' => $emailPersonal,
            'host'         => $dataPengirimNa->host,
            'smtp_secure'  => $dataPengirimNa->smtp_secure,
            'port'         => $dataPengirimNa->port,
            'email'        => $dataPengirimNa->email,
            'password'     => $dataPengirimNa->password,
        );

        $email = $this->req->sendMail($mail);

        // var_dump($email);


        // Hasil Pengiriman
        if (!$email->send()) {
            $this->session->set_flashdata('failed', 'Terjadi Kesalahan / Email tidak Terdaftar');
            redirect(base_url('email'), 'refresh');
        } else {
            $this->session->set_flashdata('success', 'Email Berhasil Terkirim');
            redirect(base_url('email'), 'refresh');
        }
    }



    public function detail($id = null)
    {

        $url = base_url();
        try {
            if ($id == null)
                throw new Exception('Param kosong');
            $ReadDetail = $this->mail->GetDetailBroadcast($id);

            $data['css'] = ["{$url}assets/plugin/datatables/datatables.min.css"];
            $data['js'] = ["{$url}assets/plugin/datatables/datatables.min.js"];
            // ambil data 'broadcast_email'
            $data['count'] = $ReadDetail['count'];
            $data['collections'] = $ReadDetail['collections'];

            // ambil data 'detail_broadcast'
            $data['CountDetail'] = $ReadDetail['CountDetail'];
            $data['CollectionsDetail'] = $ReadDetail['CollectionsDetail'];

            $data['page'] = 'Email/DetailBroadcast';
            // $this->library->printr($data);
            $this->load->view('Templates/Templates', $data);
        } catch (Exception $Error) {
            $this->session->set_flashdata('pesan', "<script>pesan_warning('" . ($Error->getmessage()) . "')</script>");
            redirect('email');
        } catch (Throwable $Error) {
            $this->session->set_flashdata('pesan', "<script>pesan_warning('Throwable " . ($Error->getmessage()) . "')</script>");
            redirect('email');
        }
    }

    public function Riwayat()
    {
        $crud = $this->grocery_crud;
        $crud->set_theme('flexigrid');
        $crud->set_table('broadcast_email');
        $crud->display_as('tanggal_kirim', 'TANGGAL KIRIM');
        $crud->display_as('judul_broadcast', 'SUBJEK');
        $crud->display_as('jumlah_anggota', 'JML ANGGOTA');
        $crud->set_relation('id_broadcast', 'detail_broadcast', 'email');
        // $crud->columns('tanggal_kirim', 'judul_broadcast', 'jumlah_anggota');
        $crud->columns('tanggal_kirim', 'judul_broadcast', 'jumlah_anggota');


        $crud->add_action('Detail', base_url('assets/img/details.png'), 'email/detail');
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_read();
        $crud->unset_delete();
        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Email/riwayatEmail';
        $this->load->view('Templates/Templates', $data);
    }

    public function GetRiwayat()
    {
        try {
            $input = $this->input->post() != null ? $this->input->post() : null;
            $data = $this->mail->ReadBroadcast($input);
            $message = [
                "draw" => 1,
                "recordsTotal" => 1,
                "recordsFiltered" => 1,
                "data" => [
                    [
                        "Airi",
                        "Satou",
                        "Accountant",
                        "Tokyo",
                    ]
                ]
            ];
        } catch (Exception $Error) {
            $message = [
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        } catch (Throwable $Error) {
            $message = [
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        } finally {
            echo json_encode($message);
        }
    }
}

/* End of file Controllername.php */
