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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//VPN MASTER
$route['list_vpn'] = 'Admin/list_vpn';
$route['list_vpn/form_vpn/(:num)'] = 'Admin/form_vpn/$1';
$route['save_vpn_master/(:num)'] = 'VPN/save_vpn_master/$1';

//PAYMENT MASTER
$route['list_payment'] = 'Admin/list_payment';
$route['list_payment/form_payment/(:num)'] = 'Admin/form_payment/$1';
$route['save_payment/(:num)'] = 'Payment/save_payment/$1';

$route['list_order_vpn'] = 'Admin/list_order_vpn';
$route['list_order_vpn/manage_vpn/(:any)'] = 'Admin/manage_vpn/$1';
$route['edit_vpn/(:any)'] = 'VPN/edit_vpn/$1';
$route['delvpn/(:any)'] = 'VPN/delete_vpn/$1';

$route['order_vpn'] = 'Admin/order_vpn';
$route['simpan_order_vpn'] = 'VPN/simpan_order_vpn';

$route['check_status_vpn'] = 'VPN/check_status_vpn';

//ACCOUNT
$route['account'] = 'Admin/account_setting';
$route['editing_account'] = 'Account/editing_account';

//SALDO
$route['saldo/isi_saldo'] = 'Admin/isi_saldo';
$route['saldo/pending'] = 'Admin/list_topup/pending';
$route['saldo/success'] = 'Admin/list_topup/success';
$route['saldo/cancel'] = 'Admin/list_topup/cancel';
$route['saldo/konfirmasi'] = 'Admin/konfirmasi_saldo';
$route['topup_saldo'] = 'Saldo/topup_saldo';
$route['cancel_topup/(:any)'] = 'Saldo/cancel_topup/$1';
$route['konfirmasi_saldo/(:any)/(:any)/(:any)'] = 'Saldo/konfirmasi_saldo/$1/$2/$3';
$route['get_update_tele'] = 'Saldo/get_update_tele';

//USER
$route['user/list'] = 'Admin/list_user';
$route['user/edit/(:any)'] = 'Admin/user_edit/$1';
$route['save_user/(:any)'] = 'User/save_user/$1';

//ROUTEROS
$route['routeros/(:any)'] = 'Admin/routeros/$1';
$route['routeros/list'] = 'Admin/routeros/list';
$route['test_routeros/(:any)'] = 'Routeros/test/$1';
$route['save_routeros/(:any)'] = 'Routeros/save/$1';

//REGISTRATION
$route['activation/(:any)'] = 'Auth/activation/$1';

//FORGET PASSWORD
$route['forget_password'] = 'Auth/forget_password';
$route['fpass'] = 'Auth/fpass';

