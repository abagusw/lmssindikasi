<?php

use CodeIgniter\Router\RouteCollection;
$routes->setAutoRoute(true);
$routes->setAutoRoute('legacy');


/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Home');
$routes->get('/', 'Auth::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');


$routes->group('/', ['filter' => 'auth'], function ($routes) {

	$routes->get('auth/logout', 'Auth::logout');

	$routes->get('dashboard', 'Dashboard::index');

	$routes->get('user/profile', 'User::profile');
	$routes->patch('user/(:segment)/changeprofile', 'User::changeProfile/$1');

	$routes->get('user/new', 'User::new');
	$routes->post('user', 'User::create');
	$routes->get('user', 'User::index');
	$routes->get('user/(:segment)/edit', 'User::edit/$1');
	$routes->patch('user/(:segment)', 'User::update/$1');
	$routes->delete('user/(:segment)', 'User::delete/$1');
	$routes->patch('user/(:segment)/changestatus', 'User::changeStatus/$1');

	//Routes member Reg//
	$routes->get('member/(:segment)','Member::index/$1');
	$routes->post('member/getDataMember/(:segment)','Member::getDataMember/$1');
	$routes->get('member/getDataMemberDetail/(:segment)','Member::getDataMemberDetail/$1');
	$routes->post('member/ubahStatus','Member::ubahStatus');


});

