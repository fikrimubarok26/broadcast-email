<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_mail extends CI_Model
{

    public function data_user()
    {
        $this->db->select('id_anggota as value, nama as name ');
        $this->db->from('anggota');
        $this->db->order_by('nama', 'ASC');
        return $this->db->get()->result();
    }

    public function data_pengirim()
    {
        $this->db->select('*');
        $this->db->from('pengirim');
        $this->db->join('konfigurasi_email', 'konfigurasi_email.id_konfigurasi = pengirim.id_konfigurasi', 'left');
        $this->db->order_by('email', 'ASC');
        return $this->db->get()->result();
    }

    public function penggunaPengirim($id)
    {
        $this->db->select('*');
        $this->db->from('pengirim');
        $this->db->join('konfigurasi_email', 'konfigurasi_email.id_konfigurasi = pengirim.id_konfigurasi', 'left');
        $this->db->where('id', $id);
        $this->db->order_by('email', 'ASC');
        return $this->db->get()->row();
    }

    public function data_pangkat()
    {
        $this->db->select('id_pangkat as value, nama_pangkat as name ');
        $this->db->from('pangkat');
        $this->db->order_by('nama_pangkat', 'ASC');
        return $this->db->get()->result();
    }

    public function insertSatuan($data)
    {
        $this->db->insert('detail_broadcast', $data);
        return $this->cekPerubahan();
    }

    public function cekPerubahan()
    {
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertDetail($data)
    {   
        $this->db->insert('broadcast_email', $data);
        return $this->cekPerubahan();
    }

    public function GetDetailBroadcast($id = null){

        $Read = $this->db->select('tanggal_kirim,
                                   judul_broadcast,
                                   isi_broadcast,
                                   jumlah_anggota')
                          ->from('broadcast_email')
                          ->where(['broadcast_email.id_broadcast' => $id])
                          ->get();

        $ReadDetail = $this->db->query("
            SELECT 
                detail_broadcast.email,
                detail_broadcast.status,

                anggota.nrp,
                anggota.nama,

                (SELECT jbt.nama_jabatan FROM jabatan jbt WHERE anggota.id_jabatan = jbt.id_jabatan) AS nama_jabatan,
                (SELECT pkt.nama_pangkat FROM pangkat pkt WHERE anggota.id_pangkat = pkt.id_pangkat) AS nama_pangkat

                FROM detail_broadcast 

                LEFT JOIN anggota ON detail_broadcast.id_anggota = anggota.id_anggota

                WHERE detail_broadcast.id_broadcast = ?
        ",[$id]);
        // $this->library->printr($ReadDetail->result_array());
        $data['count'] = $Read->num_rows();
        $data['collections'] = [];
        if($data['count'] > 0)
            $data['collections'] = $Read->row();

        $data['CountDetail'] = $ReadDetail->num_rows();
        $data['CollectionsDetail'] = [];
        if($data['CountDetail'] > 0)
            $data['CollectionsDetail'] = $ReadDetail->result_array();
    
        return $data;
    }
}

/* End of file M_user.php */
/* Location: ./application/models/M_user.php */