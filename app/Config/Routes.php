<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get("/product/", "Home::product");
$routes->get('/login', 'Users::login_page');

/////// OAUTH ///////
$routes->get('auth/login',    'Users::login');
$routes->get('auth/callback', 'Users::callback');
$routes->get('auth/logout',   'Users::logout');
$routes->get('/getinfos', "Users::infos");