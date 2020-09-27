<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Anggota';
$route['anggota'] = 'Anggota';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['email'] = 'Email';
$route['email/kirim'] = 'Email/sendMail';
$route['email/riwayat'] = 'Email/riwayatEmail';
$route['dokumen-saya/getUser'] = 'Email/getUser';
$route['dokumen-saya/getPangkat'] = 'Email/getPangkat';


$route['logout'] = 'Login/logout';