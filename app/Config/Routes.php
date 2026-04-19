<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('item/thumbnail/(:num)/(1|0)', "Home::item_thumbnail/$1/$2");
$routes->get("item/(:segment)", "Home::product/$1");
$routes->get('login', 'Users::login_page');
$routes->get('dashboard', 'Users::dashboard');
$routes->get('catalogue', 'Home::catalogue');
$routes->get('cart', 'Home::cart');
$routes->post('user/getcart', 'Home::getcart');

/////// OAUTH ///////
$routes->get('auth/login',    'Users::login');
$routes->get('auth/callback', 'Users::callback');
$routes->get('auth/logout',   'Users::logout');
$routes->get('/getinfos', "Users::infos");