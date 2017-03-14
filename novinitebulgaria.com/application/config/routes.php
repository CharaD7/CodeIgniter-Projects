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


$route['^(\w{2})$'] = $route['default_controller'];

$route['jsloader/(:any)'] = "JSLoader/file/$1";

$route['(:any)_(:num)'] = "view_article/index/$2";
$route['(\w{2})/(:any)_(:num)'] = "view_article/index/$3";

$route['article_(:num)'] = "home/viewProduct/$3";

$route['^(\w{2})/(.*)$'] = '$2';

// Category url name
$route[rawurlencode('категория') . '/(:any)'] = "home/category/$1";
$route[rawurlencode('категория') . '/(:any)/(:any)'] = "home/category/$1/$2";

// Search
$route[rawurlencode('резултати') . '/' . rawurlencode('търсене')] = "home/search";
$route[rawurlencode('резултати') . '/' . rawurlencode('търсене') . '/(:num)'] = "home/search/$1";

// About Us
$route[rawurlencode('за-нас')] = "aboutus";

// ADMIN LOGIN/LOGOUT
$route['admin'] = "admin/home/login";
$route['admin/logout'] = "admin/home/home/logout";
// NEWSPAPER GROUP
$route['admin/publish'] = "admin/newspaper/publish";
$route['admin/publish/(:num)'] = "admin/newspaper/publish/index/$1";
$route['admin/articles'] = "admin/newspaper/articles";
$route['admin/articles/(:num)'] = "admin/newspaper/articles/index/$1";
$route['admin/categories'] = "admin/newspaper/categories";
$route['admin/categories/(:num)'] = "admin/newspaper/categories/index/$1";
$route['admin/texts'] = "admin/newspaper/texts";
$route['admin/texts/(:num)'] = "admin/newspaper/texts/index/$1";

// SETTINGS GROUP
$route['admin/languages'] = "admin/advanced_settings/languages";
$route['admin/history'] = "admin/advanced_settings/history";
$route['admin/history/(:num)'] = "admin/advanced_settings/history/index/$1";
$route['admin/filemanager'] = "admin/advanced_settings/filemanager";
$route['admin/adminusers'] = "admin/advanced_settings/adminusers";

// AJAX CALLED
$route['admin/changePass'] = "admin/home/home/changePass";
$route['admin/articlestatusChange'] = "admin/newspaper/articles/articlestatusChange";
$route['admin/editcategorie'] = "admin/newspaper/categories/editCategorie";
$route['admin/changeNavVisibility'] = "admin/newspaper/categories/changeNavVisibility";
$route['admin/removeImage'] = "admin/newspaper/publish/removeImage";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
