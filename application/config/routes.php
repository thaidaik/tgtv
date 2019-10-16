<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'user/index';
$route['404_override'] = '';

/*admin*/
$route['admin']                         = 'user/index';
$route['admin/list']                    = 'user/index';
$route['admin/list/(:any)']             = 'user/index/$1';
$route['admin/signup']                  = 'user/signup';
$route['admin/create_member']           = 'user/create_member';
$route['admin/edit_member']             = 'user/edit_member';
$route['admin/edit_member/(:any)']      = 'user/edit_member/$1';
$route['admin/delete/(:any)']           = 'user/delete/$1';
$route['admin/login']                   = 'user/index';
$route['admin/logout']                  = 'user/logout';
$route['admin/login/validate_credentials'] = 'user/validate_credentials';

$route['admin/products'] = 'admin_products/index';
$route['admin/products/add'] = 'admin_products/add';
$route['admin/products/update'] = 'admin_products/update';
$route['admin/products/update/(:any)'] = 'admin_products/update/$1';
$route['admin/products/delete/(:any)'] = 'admin_products/delete/$1';
$route['admin/products/(:any)'] = 'admin_products/index/$1'; //$1 = page number

$route['admin/role'] = 'admin_manufacturers/index';
$route['admin/role/add'] = 'admin_manufacturers/add';
$route['admin/role/update'] = 'admin_manufacturers/update';
$route['admin/role/update/(:any)'] = 'admin_manufacturers/update/$1';
$route['admin/role/delete/(:any)'] = 'admin_manufacturers/delete/$1';
$route['admin/role/(:any)'] = 'admin_manufacturers/index/$1'; //$1 = page number

$route['tour/info'] = 'tour_info/index';
$route['tour/info/add'] = 'tour_info/add';
$route['tour/info/update'] = 'tour_info/update';
$route['tour/info/update/(:any)'] = 'tour_info/update/$1';
$route['tour/info/delete/(:any)'] = 'tour_info/delete/$1';
$route['tour/info/(:any)'] = 'tour_info/index/$1'; //$1 = page number
$route['ajax-viewTour'] = 'tour_info/ajaxViewTour';
$route['tour_xls'] = 'tour_info/createXLS';

$route['tour/location'] = 'tour_location/index';
$route['tour/location/(:any)'] = 'tour_location/index/$1'; //$1 = page number
$route['tour/location/add'] = 'tour_location/add';
$route['tour/location/update'] = 'tour_location/update';
$route['tour/location/update/(:any)'] = 'tour_location/update/$1';
$route['tour/location/delete/(:any)'] = 'tour_location/delete/$1';

$route['guest/info'] = 'guest_info/index';
$route['guest/info/add'] = 'guest_info/add';
$route['guest/info/update'] = 'guest_info/update';
$route['guest/info/update/(:any)'] = 'guest_info/update/$1';
$route['guest/info/delete/(:any)'] = 'guest_info/delete/$1';
$route['guest/info/(:any)'] = 'guest_info/index/$1'; //$1 = page number
$route['ajax-viewGuest'] = 'guest_info/ajaxViewTour';
$route['guest_xls'] = 'guest_info/createXLS';

$route['guest/link/tour/(:any)'] = 'guest_info/addInfoTour/$1';
$route['guest/add/payment/(:any)'] = 'guest_info/addPayment/$1';
//test

$route['ajax-request-test'] = 'ItemController/ajaxRequest';
$route['ajax-requestPost-test'] = 'ItemController/ajaxRequestPost';
/* End of file routes.php */
/* Location: ./application/config/routes.php */