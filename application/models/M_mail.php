<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mail extends CI_Model {

	public function data_user()
		{
			$this->db->select('id_anggota as value, nama as name ');
			$this->db->from('anggota');
			$this->db->order_by('nama', 'ASC');
			return $this->db->get()->result();
		}	

	public function data_pangkat()
		{
			$this->db->select('id_pangkat as value, nama_pangkat as name ');
			$this->db->from('pangkat');
			$this->db->order_by('nama_pangkat', 'ASC');
			return $this->db->get()->result();
		}

	public function insert($data)
		{
			$this->db->insert('broadcast_email', $data);
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

}

/* End of file M_user.php */
/* Location: ./application/models/M_user.php */