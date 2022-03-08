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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['default_controller'] = 'auth'; //Get
$route['auth/login'] = '/auth/login'; //Post
$route['auth/logout'] = '/auth/logout';

$route['admin/panel'] = '/dashboard/dashboard/index';
$route['load/all'] = '/dashboard/dashboard/load';

/** Authorize User */
$route['admin/profile'] = '/dashboard/admin/profile';
$route['admin/password'] = '/dashboard/admin/password';
$route['admin/edit'] = '/dashboard/admin/edit_user';
$route['delete/record/(:any)/(:any)'] = '/dashboard/admin/delete_record/$1/$2';
/** All User */
$route['admin/auth/list'] = '/dashboard/admin/index';
$route['admin/auth/add'] = '/dashboard/admin/add';
$route['admin/auth/view/(:any)'] = '/dashboard/admin/views/$1';
$route['admin/auth/edit/(:any)'] = '/dashboard/admin/edit/$1';
$route['admin/auth/withdraw/(:any)'] = '/dashboard/admin/withdraw/$1';
$route['force/logout/(:any)'] = '/dashboard/admin/delete_all_record/$1';
/** Role Management */
$route['admin/role'] = '/dashboard/role/index';
$route['admin/role/add'] = '/dashboard/role/add';
$route['admin/role/edit/(:num)'] = '/dashboard/role/edit/$1';
$route['admin/role/delete/(:num)'] = '/dashboard/role/delete/$1';

$route['admin/category'] = '/dashboard/category/index';
$route['admin/category/add'] = '/dashboard/category/add';
$route['admin/category/edit/(:any)'] = '/dashboard/category/edit/$1';
$route['admin/category/delete/(:any)'] = '/dashboard/category/delete/$1';

$route['admin/subcategory'] = '/dashboard/subcategory/index';
$route['admin/subcategory/add'] = '/dashboard/subcategory/add';
$route['admin/subcategory/edit/(:any)'] = '/dashboard/subcategory/edit/$1';
$route['admin/subcategory/delete/(:any)'] = '/dashboard/subcategory/delete/$1';

$route['admin/level'] = '/dashboard/level/index';
$route['admin/level/add'] = '/dashboard/level/add';
$route['admin/level/edit/(:any)'] = '/dashboard/level/edit/$1';
$route['admin/level/delete/(:any)'] = '/dashboard/level/delete/$1';

$route['admin/room'] = '/dashboard/room/index';
$route['admin/room/add'] = '/dashboard/room/add';
$route['admin/room/edit/(:num)'] = '/dashboard/room/edit/$1';
$route['admin/room/delete/(:num)'] = '/dashboard/room/delete/$1';
$route['admin/room/view/(:num)'] = '/dashboard/room/view/$1';
$route['load/room/(:num)'] = '/dashboard/room/load/$1';

$route['admin/tag'] = '/dashboard/tag/index';
$route['admin/tag/add'] = '/dashboard/tag/add';
$route['admin/tag/edit/(:any)'] = '/dashboard/tag/edit/$1';
$route['admin/tag/delete/(:any)'] = '/dashboard/tag/delete/$1';

$route['admin/school'] = '/dashboard/jpschool/index';
$route['admin/school/add'] = '/dashboard/jpschool/add';
$route['admin/school/edit/(:num)'] = '/dashboard/jpschool/edit/$1';
$route['admin/school/delete/(:num)'] = '/dashboard/jpschool/delete/$1';
$route['admin/school/view/(:num)'] = '/dashboard/jpschool/view/$1';

$route['admin/local'] = '/dashboard/local/index';
$route['admin/local/add'] = '/dashboard/local/add';
$route['admin/local/edit/(:num)'] = '/dashboard/local/edit/$1';
$route['admin/local/delete/(:num)'] = '/dashboard/local/delete/$1';
$route['admin/local/view/(:num)'] = '/dashboard/local/view/$1';

$route['admin/course'] = '/dashboard/course/index';
$route['admin/course/add'] = '/dashboard/course/add';
$route['admin/course/view/(:any)'] = '/dashboard/course/view/$1';
$route['admin/course/edit/(:any)'] = '/dashboard/course/edit/$1';
$route['admin/course/delete/(:any)'] = '/dashboard/course/delete/$1';
$route['admin/course/fetch_level'] = '/dashboard/course/fetch_level';

$route['admin/instructor'] = '/dashboard/instructor/index';
$route['admin/instructor/add'] = '/dashboard/instructor/add';
$route['admin/instructor/view/(:any)'] = '/dashboard/instructor/view/$1';
$route['admin/instructor/edit/(:any)'] = '/dashboard/instructor/edit/$1';
$route['admin/instructor/delete/(:any)'] = '/dashboard/instructor/delete/$1';

$route['admin/class'] = '/dashboard/classes/index';
$route['admin/class/add'] = '/dashboard/classes/add';
$route['admin/class/edit/(:num)'] = '/dashboard/classes/edit/$1';
$route['admin/class/view/(:num)'] = '/dashboard/classes/view/$1';
$route['admin/class/delete/(:num)'] = '/dashboard/classes/delete/$1';
$route['load/calendar/(:num)'] = '/dashboard/classes/load/$1';