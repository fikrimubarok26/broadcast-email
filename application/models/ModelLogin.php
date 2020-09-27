<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelLogin extends CI_Model
{

    public function CekLogin($data)
    {
        try {

            $CekLogin = $this->db->select('password,id')
                ->from('admin')
                ->where(['username' => $data['username']])
                ->get();
            if ($CekLogin->num_rows() <= 0)
                throw new Exception('Username atau password salah');
            $source = $CekLogin->row();
            if (password_hash($source->password, PASSWORD_DEFAULT) == false)
                throw new Exception('Password salah');

            // ambil id_admin
            $data['id_admin'] = $CekLogin->id;
            $message = [
                'status' => 200,
                'message' => 'ok',
                'data' => $data
            ];
        } catch (Exception $Error) {
            $message = [
                'status' => 400,
                'message' => $Error->getMessage()
            ];
        } catch (Throwable $Error) {
            $message = [
                'status' => 400,
                'message' => 'Throwable ' . $Error->getMessage()
            ];
        } finally {
            return $message;
        }
    }
}
