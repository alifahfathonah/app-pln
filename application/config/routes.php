<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'frontend/beranda';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// BACKEND

// barang
$route['admin/master-barang'] = 'barang';
// atasan
$route['admin/master-atasan'] = 'atasan';
// divisi
$route['admin/master-divisi'] = 'divisi';
// kategori divisi
$route['admin/master-kategori-divisi'] = 'kategori_divisi';
// cabang
$route['admin/master-cabang'] = 'cabang';
// jenis kendaraan
$route['admin/master-jenis-kendaraan'] = 'jenis_kendaraan';
// kendaraan
$route['admin/master-kendaraan'] = 'kendaraan';
// makan siang
$route['admin/master-makan-siang'] = 'makan_siang';
// snack
$route['admin/master-snack'] = 'snack';
// ruangan
$route['admin/master-ruangan'] = 'ruangan';
// users
$route['admin/users'] = 'users';
// users profil
$route['admin/users/profil'] = 'users/profil';
// users profil
$route['admin/users/change-password'] = 'users/change_password';
// persetujuan
$route['admin/setting-persetujuan'] = 'persetujuan';

// peminjaman kendaraan
$route['admin/peminjaman-kendaraan'] = 'peminjaman_kendaraan';
// permohonan peminjaman kendaraan
$route['admin/permohonan-peminjaman-kendaraan'] = 'permohonan_peminjaman_kendaraan';

// peminjaman ruangan
$route['admin/peminjaman-ruangan'] = 'peminjaman_ruangan';
// permohonan peminjaman ruangan
$route['admin/permohonan-peminjaman-ruangan'] = 'permohonan_peminjaman_ruangan';

// FRONTEND

// beranda
$route['beranda'] = 'frontend/beranda';
// ceklis kendaraan
$route['form-ceklis-kendaraan'] = 'frontend/ceklis_kendaraan';
// buku tamu
$route['buku-tamu'] = 'frontend/buku_tamu';
// booking ruangan
$route['booking/ruangan'] = 'frontend/ruangan';
// booking kendaraan
$route['booking/kendaraan'] = 'frontend/kendaraan';
// ATK
$route['atk'] = 'frontend/atk';
$route['report-atk'] = 'frontend/report_atk';




