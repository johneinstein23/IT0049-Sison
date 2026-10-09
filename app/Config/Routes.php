<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');

// Require a valid session for the dashboard and every customer/user action.
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('customers', 'CustomerAccounts::index', ['filter' => 'auth']);
$routes->get('customers/new', 'CustomerAccounts::createForm', ['filter' => 'auth']);
$routes->post('customers', 'CustomerAccounts::create', ['filter' => 'auth']);
$routes->get('customers/(:num)/edit', 'CustomerAccounts::edit/$1', ['filter' => 'auth']);
$routes->post('customers/(:num)', 'CustomerAccounts::update/$1', ['filter' => 'auth']);
$routes->get('users', 'UserAccounts::index', ['filter' => 'auth']);
$routes->get('users/new', 'UserAccounts::createForm', ['filter' => 'auth']);
$routes->post('users', 'UserAccounts::create', ['filter' => 'auth']);
$routes->get('users/(:num)/edit', 'UserAccounts::edit/$1', ['filter' => 'auth']);
$routes->post('users/(:num)', 'UserAccounts::update/$1', ['filter' => 'auth']);
