<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelToken extends CI_Model
{
    public function GetToken()
    {
        return $this->session->userdata(sha1('token-login') . '_token') == null ? null : $this->session->userdata(sha1('token-login') . '_token');
    }
}
