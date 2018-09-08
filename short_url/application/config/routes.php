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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'users/login';
$route['register'] = 'users/register';
$route['forgot-password'] = 'users/forgot_password';
$route['create-short-url'] = 'shorturls/add';
$route['dashboard'] = 'shorturls/dashboard';
$route['logout'] = 'users/logout';
$route['list-short-url'] = 'shorturls/index';
$route['reset_password/(:any)'] = 'users/reset_password/$1';

#Advertisment

$route['shorturls'] = 'shorturls/index';
$route['shorturls/getReports'] = 'shorturls/getReports';
$route['shorturls/delete/(:any)'] = 'shorturls/delete/$1';//1 deleted id
$route['shorturls/bulkautions/(:any)/(:any)'] = 'shorturls/bulkautions/$1/$2';
$route['shorturls/view/(:any)'] = 'shorturls/view/$1';
$route['shorturls_view/view/(:any)'] = 'shorturls/view/$1';
$route['shorturls_enable/enable/(:any)/(:any)/(:any)'] = 'shorturls/update_status/$1/enable/$2/$3';
$route['shorturls_enable/disable/(:any)/(:any)/(:any)'] = 'shorturls/update_status/$1/disable/$2/$3';
$route['shorturls_edit/edit/(:any)'] = 'shorturls/edit/$1';
$route['shorturls/edit/(:any)'] = 'shorturls/edit/$1';
$route['shorturls/(:any)'] = 'shorturls/index/$1';
$route['shorturls/(:any)/(:any)/(:any)'] = 'shorturls/index/$1/$2/$3';
$route['shorturls_delete/delete/(:any)'] = 'shorturls/delete/$1';//1 deleted id
$route['shorturls/(:any)/(:any)'] = 'shorturls/index/$1/$2';
$route['shorturls/(:any)/(:any)/(:any)'] = 'shorturls/index/$1/$2/$3';
$route['shorturls/(:any)/(:any)/(:any)/(:any)'] = 'shorturls/index/$1/$2/$3/$4';
$route['settings'] = 'shorturls/settings';

################# Last Url #################
$route['(:any)'] = 'home/longurlConvert/$1';



