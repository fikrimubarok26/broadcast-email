<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Anggota';
$route['dashboard'] = 'Dashboard';
$route['anggota'] = 'Anggota';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['email'] = 'Email';
$route['email/kirim'] = 'Email/sendMail';

$route['login/action'] = 'Login/Action';
$route['logout'] = 'Login/logout';
